<div
    x-data="HeaderSearch({
        categories: {{ $categories }},
        initialQuery: '{{ addslashes(request('query')) }}',
        initialCategory: '{{ addslashes(request('category')) }}'
    })"
    class="header-search-wrap-parent"
>
    <div
        class="header-search-wrap-overlay"
        :class="{ active: showSuggestions }"
    >
    </div>

    <div
        class="header-search-wrap"
        :class="{ 'has-suggestion': hasAnySuggestion }"
        @click.away="hideSuggestions"
    >
        <div class="header-search">
            <form autocomplete="on" class="search-form" @submit.prevent="search">
                <div
                    class="header-search-lg"
                    :class="{
                        'header-search-lg-background': showSuggestions
                    }"
                >
                    <input
                        type="text"
                        name="query"
                        class="form-control search-input"
                        :class="{ focused: showSuggestions }"
                        autocomplete="on"
                        
                        placeholder="{{ 'ค้นหาสินค้า...' }}" 
                        
                        @focus="showExistingSuggestions"
                        @keydown.escape="hideSuggestions"
                        @keydown.down="nextSuggestion"
                        @keydown.up="prevSuggestion"
                        x-model="form.query"
                    />

                    <div class="search-category-dropdown">
                        </div>

                    <button type="submit" class="search-btn">
                        <i class="las la-search"></i>
                    </button>
                </div>
            </form>
            
            <div class="search-suggestions-wrap">
                <div class="product-suggestions">
                    <ul class="list-inline product-suggestions-list">
                        <template x-for="product in suggestions.products" :key="product.id">
                            <li :class="{ active: product.active }" @click="selectSuggestion(product)">
                                <a :href="product.url" class="product-wrap">
                                    <div class="product-image">
                                        </div>
                                    <div class="product-info">
                                        <span
                                            class="product-name"
                                            x-text="product.name"
                                        ></span>

                                        <div class="product-badges">
                                            <template x-if="!product.in_stock">
                                                <ul class="list-inline product-badge">
                                                    <li class="badge badge-danger">
                                                        {{ 'สินค้าหมด' }}
                                                    </li>
                                                </ul>
                                            </template>
                                        </div>

                                        <div
                                            class="product-price"
                                            x-html="product.formatted_price"
                                        ></div>
                                    </div>
                                </a>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>

            <template x-if="suggestions.remaining !== 0">
                <a
                    :href="moreResultsUrl"
                    class="more-results"
                    x-text="
                        // [TRANSLATION MAPPED]: more_results. Assumes a translation key structure like 'ดูผลลัพธ์เพิ่มเติมอีก :count รายการ'
                        trans('storefront::layouts.more_results', {
                            count: suggestions.remaining
                        })
                    "
                    @click="hideSuggestions"
                >
                </a>
            </template>
        </div>
    </div>
    
    @include('storefront::public.layouts.header.search_suggestions')
</div>
