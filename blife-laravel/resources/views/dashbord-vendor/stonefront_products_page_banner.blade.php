<div class="accordion-box-content">
    <div class="tab-content clearfix">
        <div class="panel-wrap">
            @include('storefront::admin.storefront.tabs.partials.single_banner', [
                'label' => trans('storefront::storefront.form.product_page_banner'),
                'name' => 'storefront_product_page_banner', // SETTING KEY: 'storefront_product_page_banner' (Array/JSON containing image path and link)
                'banner' => $banner, // BACKEND VARIABLE: $banner (Pre-fetched Banner data)
            ])
        </div>
    </div>
</div>
