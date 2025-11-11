<div class="modal-body px-4 py-5 c-scrollbar-light">
    <div class="row">
        <div class="col-lg-6">
            <div class="row no-gutters mt-3">
                <div class="col-sm-2">
                    <div class="opacity-60 fs-14 mt-2">{{ translate('Quantity') }}</div>
                </div>
                <div class="col-sm-10">
                    <div class="product-quantity d-flex align-items-center">
                        </div>
                </div>
            </div>

            <div class="row no-gutters mt-3">
                <div class="col-sm-2">
                    <div class="opacity-60 fs-14 mt-2">{{ translate('Total Price') }}</div>
                </div>
                <div class="col-sm-10">
                    <div class="product-price">
                        <strong id="chosen_price" class="fw-700 fs-18 text-primary">{{ single_price($product->unit_price) }}</strong>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <div class="d-flex flex-wrap align-items-center">
                    @if ($product->external_link != null)
                        <a type="button" class="btn btn-soft-primary rounded-0 mr-2 add-to-cart fw-600" href="{{ $product->external_link }}">
                            <i class="las la-share"></i>
                            <span class="d-none d-md-inline-block">{{ translate($product->external_link_btn)}}</span>
                        </a>
                    @else
                        <button type="button" class="btn btn-primary rounded-0 buy-now fw-600 add-to-cart" 
                            @if (Auth::check() || get_Setting('guest_checkout_activation') == 1) 
                                onclick="addToCart()" 
                            @else 
                                onclick="showLoginModal()" 
                            @endif
                        >
                            <i class="la la-shopping-cart"></i>
                            <span class="d-none d-md-inline-block">{{ 'เพิ่มลงในตะกร้า' }}</span>
                        </button>
                    @endif
                    <button type="button" class="btn btn-secondary rounded-0 out-of-stock fw-600 d-none" disabled>
                        <i class="la la-cart-arrow-down"></i>{{ 'สินค้าหมด' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#option-choice-form input').on('change', function () {
        // [TECHNICAL COMMENT]: Calls function to update price based on variant/option selection
        getVariantPrice(); 
    });
</script>
