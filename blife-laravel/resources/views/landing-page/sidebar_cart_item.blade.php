<template x-for="cartItem in $store.cart.items" :key="cartItem.id">
    <div x-data="CartItem(cartItem)" class="cart-item sidebar-cart-item">
        <a :href="productUrl" class="product-image">
            <img
                :src="baseImage"
                :class="{
                    'image-placeholder': !hasBaseImage,
                }"
                :alt="productName"
                loading="lazy"
            />
        </a>

        <div class="product-info">
            <a
                :href="productUrl"
                class="product-name"
                :title="productName"
                x-text="productName"
            >
            </a>
            
            <template x-if="hasAnyVariation">
                <ul class="list-inline product-options">
                    <template
                        x-for="(variation, key) in cartItem.variations"
                        :key="variation.id"
                    >
                        <li>
                            <label x-text="`${variation.name}:`"></label>
                            <span x-text="`${variation.values[0].label}${variationsLength === Number(key) ? '' : ','}`"></span>
                        </li>
                    </template>
                </ul>
            </template>
            
            <template x-if="hasAnyOption">
                <ul class="list-inline product-options">
                    <template
                        x-for="(option, key) in cartItem.options"
                        :key="option.id"
                    >
                        <li>
                            </li>
                    </template>
                </ul>
            </template>
            
            <div class="d-flex align-items-center justify-content-between">
                <div class="quantity-control-wrap">
                    <div class="input-group quantity-control">
                        <button
                            type="button"
                            class="btn btn-number btn-minus"
                            :disabled="isQtyDecreaseDisabled(cartItem)"
                            @click="updateQuantity(cartItem, cartItem.qty - 1)"
                        >
                            <svg></svg>
                        </button>

                        <input
                            type="text"
                            class="form-control input-number"
                            :value="cartItem.qty"
                            :min="1"
                            max="100000"
                            :data-cart-id="cartItem.id"
                            @change="updateQuantity(cartItem, $event.target.value)"
                        />

                        <button
                            type="button"
                            class="btn btn-number btn-plus"
                            :disabled="isQtyIncreaseDisabled(cartItem)"
                            @click="updateQuantity(cartItem, cartItem.qty + 1)"
                        >
                            <svg></svg>
                        </button>
                    </div>
                </div>

                <div class="product-price" x-text="`x ${formatCurrency(unitPrice)}`"></div>
            </div>
        </div>

        <div class="remove-cart-item">
            <button class="btn-remove" @click="removeCartItem">
                <i class="las la-times"></i>
            </button>
        </div>
    </div>
</template>
