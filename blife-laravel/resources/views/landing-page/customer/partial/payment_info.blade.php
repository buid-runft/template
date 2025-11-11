<div class="mb-4">
    <h3 class="fs-16 fw-700 text-dark">
        {{ translate('Any additional info?') }}
    </h3>
    <textarea name="additional_info" rows="5" class="form-control rounded-0"
        placeholder="{{ translate('Type your text...') }}"></textarea>
</div>
<div>
    <h3 class="fs-16 fw-700 text-dark">
        {{ translate('Select a payment option') }}
    </h3>
    <div class="row gutters-10">
        @foreach (get_activate_payment_methods() as $payment_method)
            @endforeach

        @if (get_setting('cash_payment') == 1)
            @php
                // [BACKEND DIRECTIVE: LOGIC MOVEMENT - COD CHECK]
                // SERVICE LAYER (PaymentService): Method 'isCodAvailable(Collection $carts)' ต้องทำตรรกะการตรวจสอบ Digital Product และ 'cash_on_delivery' ของทุกสินค้าบน Server
                $digital = 0;
                $cod_on = 1;
                // ... ตรรกะการตรวจสอบ COD ...
            @endphp
            @if ($digital != 1 && $cod_on == 1)
                @endif
        @endif

        @if (Auth::check())
            @if (addon_is_activated('offline_payment'))
                @foreach (get_all_manual_payment_methods() as $method)
                    @endforeach
                @endif
        @endif
    </div>

    @if (addon_is_activated('offline_payment') && count(get_all_manual_payment_methods())>0)
        <div class="d-none mb-3 rounded border bg-white p-3 text-left">
            </div>
    @endif

    @if (Auth::check() && get_setting('wallet_system') == 1)
        <div class="py-4 px-4 text-center bg-soft-secondary-base mt-4">
            <div class="fs-14 mb-3">
                <span class="opacity-80">{{ translate('Or, Your wallet balance :') }}</span>
                <span class="fw-700">{{ single_price(Auth::user()->balance) }}</span>
            </div>
            </div>
    @endif
</div>
