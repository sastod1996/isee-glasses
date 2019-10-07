<template>
  <section class="uk-section">
    <div class="uk-container uk-container-large">
      <div class="uk-grid-small" uk-grid>
        <div class="uk-width-1-3@m uk-width-1-1">
          <div class="uk-padding uk-padding-remove-top">
            <div class="uk-background-muted">
              <div class="">
                <div class="isee-background-green">
                  <div class="uk-padding-small uk-text-center uk-light">
                    <div class="isee-h3 uk-text-bold">{{titles.caracteristicas}}</div>
                  </div>
                </div>
                <div class="uk-padding">
                  <div v-for="(category, c) in categories" :key="c">
                    <label v-if="lang === 'en'">
                      <input v-model="cats" class="uk-checkbox" type="checkbox" :value="category.slug"> {{ category.name_en }}
                    </label>
                    <label v-else>
                      <input v-model="cats" class="uk-checkbox" type="checkbox" :value="category.slug"> {{ category.name }}
                    </label>
                  </div>
                  <div class="uk-margin uk-hidden@m">
                    <div class="uk-position-relative" @click="expandList('isee-characteristics-div')">
                      <span class="uk-text-bold">FILTROS</span>
                      <span class="uk-position-right uk-flex uk-flex-middle" uk-icon="icon: plus; ratio:0.8"></span>
                    </div>
                  </div>
                  <div class="uk-visible@m uk-margin isee-characteristics-div">
                    <ul class="isee-characteristics-ul" uk-accordion="multiple: true" v-for="(characteristic, index) in characteristics" :key="index">
                      <li class="uk-open uk-visible@m">
                        <p v-if="index == 0" class="uk-accordion-title uk-text-center uk-text-bold">Premium</p>
                        <p v-if="lang === 'en' && index !== 0" class="uk-accordion-title uk-text-center uk-text-bold">{{ characteristic.name_en }}</p>
                        <p v-if="lang !== 'en' && index !== 0" class="uk-accordion-title uk-text-center uk-text-bold">{{ characteristic.name }}</p>
                        <div class="uk-accordion-content">
                          <div class="" v-for="(attribute, a) in characteristic.attributes" :key="a">
                            <label v-if="lang === 'en'">
                              <input v-model="attrs" class="uk-checkbox" type="checkbox" :value="attribute"> {{ attribute.name_en }}
                            </label>
                            <label v-else>
                              <input v-model="attrs" class="uk-checkbox" type="checkbox" :value="attribute"> {{ attribute.name }}
                            </label>
                          </div>
                        </div>
                      </li>
                      <li class="uk-hidden@m">
                        <p v-if="index == 0" class="uk-accordion-title uk-text-center uk-text-bold">Premium</p>
                        <p v-if="lang === 'en' && index !== 0" class="uk-accordion-title uk-text-center uk-text-bold">{{ characteristic.name_en }}</p>
                        <p v-if="lang !== 'en' && index !== 0" class="uk-accordion-title uk-text-center uk-text-bold">{{ characteristic.name }}</p>
                        <div class="uk-accordion-content">
                          <div class="" v-for="(attribute, index) in characteristic.attributes" :key="index">
                            <label v-if="lang === 'en'">
                              <input v-model="attrs" class="uk-checkbox" type="checkbox" :value="attribute"> {{ attribute.name_en }}
                            </label>
                            <label v-else>
                              <input v-model="attrs" class="uk-checkbox" type="checkbox" :value="attribute"> {{ attribute.name }}
                            </label>
                          </div>
                        </div>
                      </li>
                    </ul>
                    <ul class="isee-characteristics-ul" uk-accordion="multiple: true">
                      <li class="uk-open uk-visible@m">
                        <p class="uk-accordion-title uk-text-center uk-text-bold">Color</p>
                        <div class="uk-accordion-content">
                          <div class="" v-for="(primary, p) in primaries" :key="p">
                            <!-- <label v-if="lang === 'en'">
                              <input v-model="prims" class="uk-checkbox" type="checkbox" :value="primary"> {{ primary.name_en }}
                            </label> -->
                            <label>
                              <input v-model="prims" class="uk-checkbox" type="checkbox" :value="primary"> {{ primary.name }}
                            </label>
                          </div>
                        </div>
                      </li>
                      <li class="uk-hidden@m">
                        <p class="uk-accordion-title uk-text-center uk-text-bold">Color</p>
                        <div class="uk-accordion-content">
                          <div class="" v-for="(primary, p) in primaries" :key="p">
                            <!-- <label v-if="lang === 'en'">
                              <input v-model="prims" class="uk-checkbox" type="checkbox" :value="primary"> {{ primary.name_en }}
                            </label> -->
                            <label>
                              <input v-model="prims" class="uk-checkbox" type="checkbox" :value="primary"> {{ primary.name }}
                            </label>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="uk-width-2-3@m uk-width-1-1">
          <div class="uk-visible@s" uk-grid>
            <div class="uk-width-1-4">
              <select class="uk-select" v-model="orderByPrice">
                <option value="" disabled selected>{{titles.dropdown1}}</option>
                <option value="asc">{{titles.dropdown2}}</option>
                <option value="desc">{{titles.dropdown3}}</option>
              </select>
            </div>
            <div class="uk-width-expand">

            </div>
            <div class="uk-width-1-4">
              <ul class="uk-pagination uk-flex-right">
                <!-- <li v-for="i in 4">
                  <label>
                    <input v-model="paginate" class="uk-hidden" type="radio" :value="i">
                    <span class="">
                      {{ i }}
                    </span>
                  </label>
                </li> -->
              </ul>
            </div>
          </div>
          <div class="uk-flex uk-margin">
            <div class="uk-child-width-1-3@m uk-child-width-1-2@s uk-child-width-1-1 uk-grid-small uk-grid-match" uk-grid>
              <div v-for="(product, p) in filteredProducts" :key="p">
                <div class="uk-card uk-card-default">
                  <div class="uk-card-header uk-padding-small">
                    <div class="uk-flex uk-flex-wrap uk-flex-center uk-grid-small" uk-grid>
                      <div class="uk-text-nowrap">
                        <a class="uk-link-reset uk-text-bold" :href="product.cart ? '/cart' : '/shop/' + product.slug">
                          <span class="" uk-icon="icon: user"></span>
                          {{titles.pruebame}}
                        </a>&nbsp;
                        <span v-if="user !== 0" class="">
                          <button v-if="product.wishlist" :id="'product-'+product.id" @click="changeWishList(product)" class="icon-selected" uk-icon="icon: heart"></button>
                          <button v-else :id="'product-'+product.id" @click="changeWishList(product)" class="" uk-icon="icon: heart"></button>
                        </span>
                        <span v-else class="">
                          <a href="#modal-login" uk-toggle uk-icon="icon: heart"></a>
                        </span>
                      </div>
                      <div class="">
                        <a target="popupfb" :href="'http://www.facebook.com/share.php?u='+'https://isee-glasses.com/'+lang+'/shop/'+product.slug+'&description='+product.description" onclick="window.open('','popupfb','width=576,height=626,scrollbars=no,toolbar=no')" class="uk-icon-link uk-margin-small-left" uk-icon="facebook"></a>
                        <!-- <div :id="product.slug" class="fb-share-button" :data-href="'https://isee-glasses.com/'+lang+'/shop/'+product.slug" data-layout="button" data-size="small" data-mobile-iframe="true">
                          <a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fisee-glasses.com%2F&amp;src=sdkpreparse">Share</a>
                        </div> -->
                      </div>
                    </div>
                  </div>
                  <div class="uk-card-body uk-padding-small uk-text-center">
                    <div class="uk-text-center">
                      <a class="uk-link-reset" :href="product.cart ? '/cart' : '/shop/' + product.slug">
                        <img :src="product.image" alt="product" class="uk-img-preserve">
                      </a>
                    </div>
                    <div class="">
                      <div v-if="lang === 'en'">
                        <a class="uk-h4 uk-link-reset uk-text-bold" :href="product.cart ? '/cart' : '/shop/' + product.slug">{{ product.name_en }}</a>
                      </div>
                      <div v-else>
                        <a class="uk-h4 uk-link-reset uk-text-bold" :href="product.cart ? '/cart' : '/shop/' + product.slug">{{ product.name }}</a>
                      </div>
                      <div class="">
                        <span class="uk-h6" href="#">{{ product.code }}</span>
                      </div>
                      <div v-if="!product.promo" class="">
                        <span class="uk-h5 uk-text-bold">{{ rate.symbol }} {{ product.price | toRate(rate.value) }}</span>
                      </div>
                      <div v-if="product.promo" class="">
                        <span class="uk-h6"><s>{{ rate.symbol }} {{ product.price | toRate(rate.value) }}</s></span>
                        <span class="uk-h5 uk-text-bold">{{ rate.symbol }} {{ product.promo | toRate(rate.value) }}</span>
                      </div>
                    </div>
                    <!-- <div class="">
                      <span class="uk-text-bold" v-for="att in product.attributes">{{ att.slug }}, </span>
                    </div> -->
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="uk-visible@s" uk-grid>
            <div class="uk-width-1-4">
              <select class="uk-select">
                <option>{{titles.dropdown1}}</option>
                <option>{{titles.dropdown2}}</option>
              </select>
            </div>
            <div class="uk-width-expand">

            </div>
            <div class="uk-width-1-4">
              <ul class="uk-pagination uk-flex-right">
                <!-- <li v-for="i in 4">
                  <label>
                    <input v-model="paginate" class="uk-hidden" type="radio" :value="i">
                    <span class="">
                      {{ i }}
                    </span>
                  </label>
                </li> -->
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
  import _ from 'lodash'
  import convertRate from '../helpers/convertRate'

  var csrf_token = $('meta[name="csrf-token"]').attr('content');

  var url = new URL(window.location.href)
  var params = new URLSearchParams(url.search)
  var cats = params.get('cats')
  var attrs = params.get('attrs')
  var title = params.get('title')
  var strCats = []
  var strAttrs = []
  if (cats != null) {
    strCats = cats.split(',')
  }
  if (attrs != null) {
    strAttrs = attrs.split(',')
  }

  export default {
    props: ['products', 'categories', 'user', 'characteristics', 'rates', 'rateslug', 'titles', 'lang', 'primaries'],
    data () {
      return {
        csrf: csrf_token,
        cats: [],
        attrs: [],
        prims: [],
        rate: {},
        orderByPrice: '',
        prods: {},
        paginate: 1
      }
    },
    filters: {
      toRate (amount, value) {
        return convertRate(amount, value)
      }
    },
    methods: {
      expandList (selectedClass) {
        var cls = $('.'+selectedClass)
        if (cls.hasClass('uk-visible@m')) {
          cls.removeClass('uk-visible@m')
        } else {
          cls.addClass('uk-visible@m')
        }
      },
      changeWishList (product) {
        var el = document.getElementById('product-'+product.id)
        if (el.classList.contains('icon-selected')) {
          $.ajax({
            method: 'DELETE',
            url: '/'+this.lang+'/wishlist/'+product.rowId+'/ajax',
            success: function (response) {
              if (response.success) {
                var el = document.getElementById('product-'+product.id)
                el.classList.remove('icon-selected')
                // UIkit.notification({
                //   message: '<i uk-icon="icon: check"></i> ¡Quitado!',
                //   status: 'primary',
                //   pos: 'bottom-center',
                //   timeout: 5000
                // })
              }
            },
            error: function (response) {
              UIkit.notification({
                message: '<i uk-icon="icon: check"></i> ¡Error!',
                status: 'danger',
                pos: 'bottom-center',
                timeout: 5000
              })
            }
          });
        } else {
          $.post('/'+this.lang+'/wishlist', { product })
            .done(response => {
              if (response.success) {
                product.rowId = response.product.rowId
                var el = document.getElementById('product-'+product.id)
                el.classList.add('icon-selected')
                // UIkit.notification({
                //   message: '<i uk-icon="icon: check"></i> ¡Agregado!',
                //   status: 'primary',
                //   pos: 'bottom-center',
                //   timeout: 5000
                // })
              }else{
                UIkit.notification({
                  message: '<i uk-icon="icon: check"></i> ¡No pudo agregarse!',
                  status: 'danger',
                  pos: 'bottom-center',
                  timeout: 5000
                })
              }
            })
            .fail(err => {
              UIkit.notification({
                message: '<i uk-icon="icon: check"></i> ¡Error!',
                status: 'danger',
                pos: 'bottom-center',
                timeout: 5000
              })
            })
            .always(() => {
            })
        }
      }
    },
    computed: {
      productsColor () {
        var primaries = this.prods
        // primaries = this.prims.length ? primaries.filter(p => (p.categories.filter(c => !!this.prims.find(pr => pr.value == c.primary)).length )) : primaries
        this.prims.forEach(pr => {
          primaries = primaries.filter(p => (p.attributes.filter(a => (a.characteristic_id == 6 && a.primary == pr.value)).length))
        })
        return primaries
      },
      chars () {
        var chars = []
        this.attrs.forEach(a => {
          var char = this.characteristics.find(c => (a.characteristic_id == c.id))
          if(!chars.find(c => c == char)) chars.push(char)
        })
        return chars
      },
      attributes () {
        var attrs = []
        this.characteristics.forEach(ch => {
          ch.attributes.forEach(a => {
            attrs.push(a)
          })
        })
        return attrs
      },
      filteredProducts () {
        var filtered = this.productsColor
        filtered = this.cats.length ? filtered.filter(p => (p.categories.filter( c => !!this.cats.find(cat => cat == c.slug) ).length )) : filtered
        this.chars.forEach(char => {
          filtered = filtered.filter(p => (p.attributes.filter( a => this.attrs.find(att => att.id == a.id && att.characteristic_id == char.id)).length ))
        })
        filtered.forEach(f => {
          f.real = f.promo ? f.promo : f.price
          return f
        })
        filtered = _.orderBy(filtered, ['real'], [this.orderByPrice])
        return filtered
      }
    },
    created() {
      this.prods = this.products.data
      this.cats = strCats
      // this.orderByPrice = 'asc'

      strAttrs.forEach(a => {
        var found = _.find(this.attributes, at => (at.slug == a))
        if (found) {
          this.attrs.push(found)
        }
      })

      if (!this.rateslug) {
        var rat = ''
        $.getJSON('http://api.wipmania.com/jsonp?callback=?')
          .done( (data) => {
            if (data.address.country == 'Peru') {
              rat = 'soles'
            }else{
              rat = 'soles'
            }
          })
          .fail( (data) => {
            rat = 'soles'
          })
          .always( (data) => {
            this.rate = this.rates.find(r => (r.slug == rat))
          })
      }else {
        this.rate = this.rates.find(r => (r.slug == this.rateslug))
      }
    }
  }

</script>

<style lang="css">
  .icon-selected svg {
    color: red;
  }
  .icon-selected svg path {
    fill: red !important;
  }
</style>
