@if ($errors->any())
    @endif

@if(Auth::check())
    @foreach (Auth::user()->addresses as $key => $address)
   @php
        // [BACKEND DIRECTIVE: LOGIC MOVEMENT]
        // 1. SERVICE LAYER (AddressService): Method 'checkAddressValidity(Address $address, array $settings)'
        // 2. LOGIC: ตรรกะการตรวจสอบสถานะ City/Area ($is_disabled) ควรทำบน Server เพื่อให้เป็น Business Logic ที่เชื่อถือได้
        // 3. API ENDPOINT: GET /api/v1/user/shipping-addresses ต้องส่งคืนสถานะ 'is_disabled' ของแต่ละ Address
        $city = optional($address->city);
        $area_id = $address->area_id;
        $has_area_id = !is_null($area_id);
        $city_status = $city->status;
        $active_area_exists = $city->areas()->where('status', 1)->exists(); 
        $area_status = $has_area_id ? optional($address->area)->status : 1;
        $is_disabled = ($city_status === 0) || ($has_area_id && $area_status === 0) || ($active_area_exists && !$has_area_id) ||  ($address->state_id == null && get_setting('has_state') == 1);
    @endphp

    <div class="border mb-4 {{ $is_disabled ? ' border-danger' : '' }}">
        <div class="row">
            <div class="col-md-8">
                </div>

            <div class="col-md-4 p-3 text-right">
                <a class="btn btn-sm btn-secondary-base text-white mr-4 rounded-0 px-4"
                   onclick="edit_address('{{ $address->id }}')">
                    {{ translate('Change') }}
                </a>
            </div>
            @if($is_disabled)
            <div class="col-md-12">
               <div class="text-center text-danger">
                    <span>{{ translate('We no longer deliver in this area.') }}</span>
                </div>
            </div>
            @endif
        </div>
    </div>
@endforeach

    <input type="hidden" name="checkout_type" value="logged">
    <div class="border p-3 c-pointer text-center bg-light has-transition hov-bg-soft-light h-100 d-flex flex-column justify-content-center" onclick="add_new_address()">
        <i class="las la-plus mb-1 fs-20 text-gray"></i>
        <div class="alpha-7 fw-700">{{ translate('Add New Address') }}</div>
    </div>
@else
    @include('frontend.partials.cart.guest_shipping_info')
@endif

