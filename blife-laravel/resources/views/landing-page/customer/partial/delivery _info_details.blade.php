<div class="row gutters-16">
    @php
    // [BACKEND DIRECTIVE: LOGIC MOVEMENT - PHYSICAL CHECK]
    // SERVICE LAYER (ShippingService): Method 'isPhysicalOrder(array $products)' ต้องตรวจสอบว่ามีสินค้า Physical หรือไม่ เพื่อแสดงตัวเลือกการจัดส่ง
    $physical = false;
    // ... ตรรกะเช็ค $product->digital ...
    @endphp

    @if ($physical)
    <div class="col-md-6 mb-2">
        <h6 class="fs-14 fw-700 mt-3">{{ translate('Choose Delivery Type') }}</h6>
        <div class="row gutters-16">
            </div>

        @if ($pickup_point_list)
        <div class="mt-3 pickup_point_id_{{ $owner_id }} d-none">
            </div>
        @endif

        @if (get_setting('shipping_type') == 'carrier_wise_shipping')
        <div class="row pt-3 carrier_id_{{ $owner_id }}">
            @if($carrier_list->isEmpty())
                @else
            @foreach($carrier_list as $carrier_key => $carrier)
            <div class="col-md-12 mb-2">
                <label class="aiz-megabox d-block bg-white mb-0">
                    <input type="radio" name="carrier_id_{{ $owner_id }}" value="{{ $carrier->id }}" 
                        onchange="updateDeliveryInfo('carrier', {{ $carrier->id }}, {{ $owner_id }})">
                    <span class="d-flex flex-wrap p-3 aiz-megabox-elem rounded-0">
                        <span class="flex-grow-1 pl-4 pl-sm-3 fw-600 mt-2 mt-sm-0 text-sm-right">{{ single_price(carrier_base_price($carts, $carrier->id, $owner_id, $shipping_info)) }}</span>
                    </span>
                </label>
            </div>
            @endforeach
            @endif
        </div>
        @endif
    </div>
    @endif
</div>
