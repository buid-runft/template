<div class="mb-4">
    <h3 class="fs-16 fw-700 text-dark">
        {{ 'ข้อมูลเพิ่มเติมใดๆ หรือไม่?' }}
    </h3>
    <textarea name="additional_info" rows="5" class="form-control rounded-0"
        placeholder="{{ 'พิมพ์ข้อความของคุณ...' }}"></textarea>
</div>
<div>
    <h3 class="fs-16 fw-700 text-dark">
        {{ 'เลือกตัวเลือกการชำระเงิน' }}
    </h3>
    <div class="row gutters-10">
        @foreach (get_activate_payment_methods() as $payment_method)
            @endforeach

        @if(get_setting('manual_payment_activation') == 1)
        <div class="row gutters-10 manual-payment-row">
            </div>
        @endif
    </div>

    @if (Auth::check() && get_setting('wallet_system') == 1)
        <div class="py-4 px-4 text-center bg-soft-secondary-base mt-4">
            <div class="fs-14 mb-3">
                <span class="opacity-80">{{ 'หรือ, ยอดเงินในกระเป๋าของคุณ :' }}</span>
                <span class="fw-700">{{ single_price(Auth::user()->balance) }}</span>
            </div>
            @if (Auth::user()->balance < $total)
                <button type="button" class="btn btn-secondary" disabled>
                    {{ 'ยอดเงินไม่เพียงพอ' }}
                </button>
            @else
                <button type="button" onclick="use_wallet()"
                    class="btn btn-primary fs-14 fw-700 px-5 rounded-0">
                    {{ 'ชำระด้วยกระเป๋าเงิน' }}
                </button>
            @endif
        </div>
    @endif
</div>
