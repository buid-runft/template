@php
    // [BACKEND DIRECTIVE: LOGIC MOVEMENT - GROUPING]
    // 1. SERVICE LAYER (ShippingService): Method 'groupCartItemsByOwner(Collection $carts)' ต้องทำตรรกะนี้บน Server
    // 2. API ENDPOINT: POST /api/v1/checkout/get-delivery-options ต้องส่งข้อมูลที่จัดกลุ่มแล้ว (admin_products, seller_products)
    // 3. REPOSITORY LAYER (CartRepository/ProductRepository): ต้องมี Method ดึงข้อมูล CartItem พร้อม Eager Loading Product
    $admin_products = array();
    $seller_products = array();
    // ... ตรรกะการจัดกลุ่มสินค้าตาม 'admin' หรือ 'seller' ...
@endphp

@if (!empty($admin_products))
    <div class="card mb-3 border-left-0 border-top-0 border-right-0 border-bottom rounded-0 shadow-none">
        <div class="card-header py-3 px-0 border-left-0 border-top-0 border-right-0 border-bottom border-dashed">
            <h5 class="fs-16 fw-700 text-dark mb-0">{{ get_setting('site_name') }} {{ translate('Inhouse Products') }} ({{ sprintf("%02d", count($admin_products)) }})</h5>
        </div>
        <div class="card-body p-0">
            @include('frontend.partials.cart.delivery_info_details', ['products' => $admin_products, 'product_variation' => $admin_product_variation, 'owner_id' => get_admin()->id ])
        </div>
    </div>
@endif
<input type="hidden" id="carrierCount" value="{{ count($carrier_list) }}">
@if (!empty($seller_products))
    @foreach ($seller_products as $key => $seller_product)
        <div class="card-body p-0">
            @include('frontend.partials.cart.delivery_info_details', ['products' => $seller_product, 'product_variation' => $seller_product_variation, 'owner_id' => $key ])
        </div>
    @endforeach
@endif
