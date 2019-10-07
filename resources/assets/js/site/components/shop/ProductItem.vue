<template>
  <div class="product-item">
    <div class="uk-card uk-card-default">
      <div class="uk-card-header uk-padding-small">
        <div class="uk-flex uk-flex-wrap uk-flex-center uk-flex-middle uk-grid-small" uk-grid>
          <div class="uk-text-nowrap">
            <a class="uk-link-reset uk-text-bold" :href="product.cart ? '/cart' : '/shop/' + product.slug">
              <span class="" uk-icon="icon: user"></span>
              {{ titles.pruebame }}
            </a>&nbsp;
            <span v-if="state.user" class="">
              <a @click="toggleWish(product)" class="uk-link-reset" :class="{ 'icon-selected': wished, 'uk-disabled': changing }">
                <span uk-icon="icon: heart"></span>
              </a>
            </span>
            <span v-else class="">
              <a href="#modal-login" uk-toggle uk-icon="icon: heart"></a>
            </span>
          </div>
          <div class="">
            <a target="popupfb" :href="'http://www.facebook.com/share.php?u='+'https://isee-glasses.com/'+lang+'/shop/'+product.slug+'&description='+product.description" onclick="window.open('','popupfb','width=576,height=626,scrollbars=no,toolbar=no')" class="uk-margin-small-left">
              <img src="/pages/producto/facebook-1.png" alt="">
            </a>
          </div>
        </div>
      </div>
      <a class="uk-card-body uk-padding-small uk-text-center uk-link-reset uk-display-block" :href="product.cart ? '/cart' : '/shop/' + product.slug" @click="saveFilters()">
      <!-- <a id="go-product" class="uk-card-body uk-padding-small uk-text-center uk-link-reset uk-display-block" @click="saveFilters()"> -->
        <img :src="imageUrl" alt="" style="height:160px;">
        <!-- <img :src="imageUrl" style="width:240.72px; height:160.47px;"> -->
        <div class="uk-margin-remove uk-text-bold uk-h3">
          {{ product.name }}
        </div>
        <p class="uk-margin-remove">{{ product.code }}</p>
        <h4 class="uk-margin-remove">
          <template v-if="state.client && state.client.ally">
            <b v-if="product.promo"> {{ rate.symbol }} {{ product.promo | toRate(rate.value) }}</b>
            <b v-else> {{ rate.symbol }} {{ product.price | toRate(rate.value) }}</b>
          </template>
          <template v-else>
            <span v-if="product.promo" class="uk-text-small strikethrough">
              {{ rate.symbol }} {{ product.promo | toRate(rate.value) }}
            </span>
            <b> {{ rate.symbol }} {{ product.price | toRate(rate.value) }}</b>
          </template>
        </h4>
      </a>
    </div>
  </div>
</template>

<script>
import convertRate from '../../helpers/convertRate'
const statics = window.statics
const state = window.state
const $ = window.$

export default {
  props: ['product', 'rates', 'rate'],
  data () {
    return {
      ...statics,
      state,
      changing: false,
      imageUrl: '/images/600x400.png'
    }
  },
  filters: {
    toRate (amount, value) {
      return convertRate(amount, value)
    }
  },
  computed: {
    wishIndex () {
      return this.state.wishes.findIndex(w => w.product_id === this.product.id)
    },
    wished () {
      return this.wishIndex > -1
    }
  },
  methods: {
    toggleWish (product) {
      if (this.changing) return
      this.changing = true
      $.get(`/${this.lang}/shop2/wish/${this.product.id}`)
        .done(res => {
          if (res.wish) {
            this.state.wishes.push({ product_id: this.product.id })
          } else {
            if (this.wishIndex > -1) this.state.wishes.splice(this.wishIndex, 1)
          }
        })
        .fail(err => {
          console.log(err)
        })
        .always(() => {
          this.changing = false
        })
    },
    saveFilters (){
      this.$emit('saveFilters')
    }
  },
  created () {
    var image = new window.Image()
    image.onload = () => { this.imageUrl = this.product.image }
    image.src = this.product.image
  }
}
</script>

<style>
.icon-selected svg {
  color: red;
}
.icon-selected svg path {
  fill: red !important;
}

.strikethrough {
	position: relative;
}

.strikethrough:before {
	position: absolute;
	content: "";
	left: 0;
	top: 50%;
	right: 0;
	border-top: 1px solid;
	border-color: #003d5d;

  -webkit-transform:rotate(-10deg);
  -moz-transform:rotate(-10deg);
  -ms-transform:rotate(-10deg);
  -o-transform:rotate(-10deg);
  transform:rotate(-10deg);
}
</style>
