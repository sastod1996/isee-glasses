<template>
  <section>
    <div id="" class="uk-section uk-background-cover uk-background-default">
      <div class="uk-section-small uk-padding-remove-bottom">
        <div class="uk-container uk-container-small">
          <div id="articles" v-if="cart.items.length>0">
            <div>
              <div class="uk-h1 uk-text-center isee-bold isee-spacing-small">
                {{titles.principal.cart}}
              </div>
              <div class="">
                <div class="uk-margin-large-top">
                  <ul class="uk-flex uk-flex-center uk-subnav uk-grid-large uk-grid-match uk-visible@s" uk-grid>
                    <li class="uk-width-1-3@s uk-width-1-1">
                      <div class="uk-inline uk-margin uk-text-center">
                        <img id="background1" class="uk-border-circle" :src="'/pages/carrito/circle-blue.png'" alt="" style="width: 50px; height: 50px;">
                        <div class="uk-position-medium uk-position-center uk-overlay isee-h3 uk-text-bold">
                          <span class="">1</span>
                        </div>
                      </div>
                    </li>
                    <li class="uk-width-1-3@s uk-width-1-1">
                      <div class="uk-inline uk-margin uk-text-center">
                        <img id="background2" class="uk-border-circle uk-hidden" :src="'/pages/carrito/circle-blue.png'" alt="" style="width: 50px; height: 50px;">
                        <div class="uk-position-medium uk-position-center uk-overlay isee-h3 uk-text-bold">
                          <span class="">2</span>
                        </div>
                      </div>
                    </li>
                    <li class="uk-width-1-3@s uk-width-1-1">
                      <div class="uk-inline uk-margin uk-text-center">
                        <img id="background3" class="uk-border-circle uk-hidden" :src="'/pages/carrito/circle-blue.png'" alt="" style="width: 50px; height: 50px;">
                        <div class="uk-position-medium uk-position-center uk-overlay isee-h3 uk-text-bold">
                          <span class="">3</span>
                        </div>
                      </div>
                    </li>
                  </ul>
                  <ul class="uk-flex uk-flex-center uk-subnav uk-grid-large uk-grid-match uk-hidden" uk-grid uk-switcher>
                    <li id="first">1</li>
                    <li id="second">2</li>
                    <li id="third">3</li>
                  </ul>
                  <ul class="uk-switcher uk-margin-large">
                    <li>
                      <div class="" id="cart-table">
                        <div class="">
                          <div v-for="(article, index) in cartItems">
                            <div v-if="index != 0 && index != cartItems.length">
                              <div class="uk-margin">
                                <hr class="isee-hr">
                              </div>
                            </div>
                            <div :id="'article'+article.id">
                              <div class="" uk-grid>
                                <div class="uk-width-2-5@s uk-width-1-1 uk-flex uk-flex-middle">
                                  <img class="uk-width-1-1" :src="article.image" alt="">
                                </div>
                                <div class="uk-width-3-5@s uk-width-1-1">
                                  <table class="uk-table uk-table-small">
                                    <tbody class="">
                                      <tr>
                                        <td class="isee-h5 isee-bold">{{titles.principal.prod_price}}</td>
                                        <td class="uk-width-small uk-text-right">
                                          <!-- <a class="uk-link-reset uk-text-bold" :href="'{{ route('cart.destroy', article.rowId) }}'" data-method="delete" data-confirm="{{titles.principal.deleteItem}}" data-method="delete"> -->
                                          <a class="uk-link-reset uk-text-bold" v-on:click="deleteItem(article, index)">
                                            {{titles.principal.delete}}
                                            <span uk-icon="icon: close; ratio: 1.2"></span>
                                          </a>
                                        </td>
                                      </tr>
                                      <tr class="">
                                        <td v-if="lang == 'en'" class="uk-text-left">{{article.name_en}} ({{ article.code }})</td>
                                        <td v-else class="uk-text-left">{{article.name}} ({{ article.code }})</td>
                                        <td class="uk-text-right">{{ symbol }} {{ article.prodprice | toRate(value) }}</td>
                                      </tr>
                                      <!-- Color -->
                                      <tr class="">
                                        <td v-if="lang == 'es'" class="uk-text-left"><b>Color:</b> {{article.color.name}}
                                          <template v-if="article.color_attr.lab_codecolor">
                                            ({{article.color_attr.lab_codecolor}})
                                          </template>
                                        </td>
                                        <td v-else class="uk-text-left">
                                          <b>Color:</b> {{article.color.name_en}}
                                          ({{ article.color_attr.lab_codecolor && article.color_attr.lab_codecolor }})
                                        </td>
                                      </tr>
                                      <!-- Tamaño -->
                                      <tr class="">
                                        <td class="uk-text-left"> <b>{{titles.principal.tamanio}}:</b> {{article.size.name}} </td>
                                      </tr>
                                      <!-- Tipo + Paquete -->
                                      <tr v-if="article.uso.slug != 'solares'" class="">
                                        <td class="isee-h5 isee-bold">{{titles.principal.tipo}} + {{titles.principal.pack}}</td>
                                      </tr>
                                      <tr v-if="article.uso.slug != 'solares'" class="">
                                        <td v-if="lang == 'en'" class="uk-margin-small">{{ article.type.name_en }} + {{ article.pack.name_en }} ({{ article.typepack.material_en }})</td>
                                        <td v-else class="uk-margin-small">{{ article.type.name }} + {{ article.pack.name }} ({{ article.typepack.material }})</td>
                                        <td class="uk-text-right">{{ symbol }} {{ article.pack_price | toRate(value) }}</td>
                                      </tr>
                                      <tr v-if="article.option">
                                        <td class="isee-h5 uk-margin-small isee-bold">{{titles.principal.option}}</td>
                                      </tr>
                                      <tr v-if="article.option" class="">
                                        <td v-if="lang == 'en'" class="uk-margin-small">{{article.option.name_en}}
                                          <span v-if="article.optcolor">{{ '('+ article.optcolor.name_en +' )' }}</span>
                                        </td>
                                        <td v-else class="uk-margin-small">{{article.option.name }}
                                          <span v-if="article.optcolor">{{ '('+ article.optcolor.name +')' }}</span>
                                        </td>
                                        <td class="uk-text-right">{{ symbol }} {{ article.opt_price | toRate(value) }}</td>
                                      </tr>
                                      <tr v-if="article.warranty">
                                        <td class="isee-h5 uk-margin-small isee-bold">{{titles.principal.garantia}}</td>
                                      </tr>
                                      <tr v-if="article.warranty" class="">
                                        <td v-if="lang == 'en'" class="uk-margin-small">{{article.warranty.name_en}}</td>
                                        <td v-else class="uk-margin-small">{{article.warranty.name}}</td>
                                        <td class="uk-text-right">{{ symbol }}{{ article.warranty_price | toRate(value) }}</td>
                                      </tr>
                                      <!-- Descuento por cupones -->
                                      <tr v-if="cart.coupon && article.discount != 0">
                                        <td class="isee-h5 uk-margin-small isee-bold">{{titles.principal.DESCUENTO}}</td>
                                      </tr>
                                      <tr v-if="cart.coupon && article.discount != 0" class="">
                                        <td class="uk-margin-small">Descuento {{cart.coupon.code}}</td>
                                        <td class="uk-text-right">- {{ symbol }}{{ article.discount | toRate(value) }}</td>
                                      </tr>
                                      <!-- Descuento automatico para aliados -->
                                      <tr v-if="user.client && user.client.ally">
                                        <td class="isee-h5 uk-margin-small isee-bold">DCTO CONVENIO</td>
                                      </tr>
                                      <template v-if="user.client && user.client.ally">
                                        <tr v-for="dcto in article.allDcts" class="">
                                          <td class="uk-margin-small">{{ dcto.msg }}</td>
                                          <td class="uk-text-right isee-bold">- {{ symbol }}{{ dcto.amount | toRate(value) }}</td>
                                        </tr>
                                      </template>
                                      <tr>
                                        <td class="isee-h3 uk-margin-small isee-bold">SUBTOTAL</td>
                                        <td class="isee-h3 uk-text-bold uk-text-right">{{ symbol }} <span>{{ article.totalprice | toRate(value) }}</span></td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div v-if="!user.client.ally" class="uk-margin uk-flex uk-flex-middle" uk-grid>
                          <div class="uk-width-2-5@s uk-width-1-1">
                            <div class="uk-text-bold isee-h5">
                              <span> {{titles.principal.preguntaCodigo}}</span>
                            </div>
                          </div>
                          <div class="uk-width-3-5@s uk-width-1-1">
                            <div class="uk-child-width-1-2@s uk-child-width-1-1" uk-grid>
                              <div class="">
                                <input v-model="codecoupon" id="code" class="uk-input uk-form-large uk-width-1-1" type="text" name="code" :placeholder="titles.principal.msgcodigo1">
                              </div>
                              <div class="">
                                <button id="apply-coupon" class="uk-button uk-button-large uk-width-1-1 uk-text-bold isee-background-green isee-h5 uk-light" @click="validateCoupon">{{titles.principal.msgcodigo2}}</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="uk-background-muted uk-padding">
                          <div class="uk-child-width-1-2@s uk-child-width-1-1" uk-grid>
                            <div class="">
                              <p class="">
                                <span class="" uk-icon="icon: user; ratio: 1.2"></span>
                                <span class="uk-text-bold uk-h5">{{titles.principal.comprasegura}}</span>
                              </p>
                              <p class="uk-width-2-3@s uk-width-1-1 uk-h6">
                                {{titles.principal.msgcompra1}}
                              </p>
                            </div>
                            <div class="">
                              <table class="uk-table">
                                <tbody>
                                  <tr>
                                    <td>{{titles.principal.subtotal}}</td>
                                    <td>{{ symbol }} {{ cart.subtotal | toRate(value) }}</td>
                                  </tr>
                                  <tr v-if="hasCoupon || cart.discount > 0">
                                    <td>Descuento</td>
                                    <td> - {{ symbol}} {{ cart.discount | toRate(value)}}</td>
                                  </tr>
                                  <tr>
                                    <td>{{titles.principal.gastos}}</td>
                                    <td>{{ symbol }} 0.00</td>
                                  </tr>
                                  <tr class="uk-text-bold">
                                    <td>{{titles.principal.total}}</td>
                                    <td>{{ symbol }} {{ cart.total | toRate(value) }}</td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                        <div class="uk-margin">
                          <div class="uk-text-right">
                            <a id="siguiente" class="uk-button uk-button-primary uk-light uk-button-large uk-text-bold isee-h4" href="#" uk-switcher-item="1">{{titles.principal.btnsiguiente}}</a>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li id="second-content">
                      <div class="uk-grid-small uk-grid-match" uk-grid>
                        <div class="uk-width-3-5@s uk-width-1-1">
                          <div class="uk-margin">
                            <div class="uk-padding-small isee-background-gray">
                              <div class="uk-flex uk-flex-center isee-h3 uk-text-center isee-bold">{{titles.principal.titulo1}}</div>
                            </div>
                            <div class="uk-padding isee-border">
                              <form id="details-order" class="uk-grid-small" uk-grid>
                                <input type="hidden" id="culqi_amount" name="amount" :value="cart.total | toRate(value)">
                                <div class="uk-width-1-1 uk-margin-small">
                                  <div id="msgValidate" class="uk-alert-danger uk-hidden" uk-alert>
                                    <a class="uk-alert-close" uk-close></a>
                                    <p>Por favor complete todos los campos</p>
                                  </div>
                                </div>
                                <div class="uk-width-1-1">
                                  <input disabled class="uk-input uk-form-large" type="text" id="first_name" name="first_name" :value="user.first_name" :placeholder="titles.forms.nombres" required>
                                </div>
                                <div class="uk-width-1-1">
                                  <input disabled class="uk-input uk-form-large" type="text" id="last_name" name="last_name" :value="user.last_name" :placeholder="titles.forms.apellidos" required>
                                </div>
                                <div class="uk-width-1-1">
                                  <input disabled class="uk-input uk-form-large" type="email" id="email" name="email" :value="user.email" :placeholder="titles.forms.correo" required>
                                </div>
                                <div class="uk-width-1-1">
                                  <input class="uk-input uk-form-large" type="tel" id="telephone" name="telephone" :value="user.telephone" :placeholder="titles.forms.tlf +' / '+titles.forms.cel" required>
                                </div>
                                <div class="uk-width-1-2@s uk-width-1-1">
                                  <select class="uk-select uk-form-large crs-country" id="country" name="country" data-show-default-option="false" :data-default-value="user.client.country" data-region-id="city" >
                                  </select>
                                </div>
                                <div class="uk-width-1-2@s uk-width-1-1">
                                  <select class="uk-select uk-form-large" id="city" name="city" data-show-default-option :data-default-value="user.client.city" value="Lima">
                                  </select>
                                </div>
                                <div class="uk-width-1-2@s uk-width-1-1">
                                  <input class="uk-input uk-form-large uk-hidden" id="input-district" type="text" name="district" :value="user.client.district" :placeholder="titles.forms.distrito" required>
                                  <select class="uk-select uk-form-large" id="select-district" name="district" :value="user.client.district" required>
                                    <option disabled value="">Seleccionar distrito</option>
                                    <option v-for="district in districts" :value="district.value">{{ district.name }}</option>
                                  </select>
                                </div>
                                <div class="uk-width-1-2@s uk-width-1-1">
                                  <input class="uk-input uk-form-large" type="text" id="postal_code" name="postal_code" :value="user.client.code" :placeholder="titles.forms.codpostal" maxlength="10">
                                </div>
                                <div class="uk-width-1-1">
                                  <input class="uk-input uk-form-large" type="text" id="address" name="address" :value="user.client.address" :placeholder="titles.forms.direccion" maxlength="100" required>
                                </div>
                                <div class="uk-width-1-1">
                                  <input class="uk-input uk-form-large" type="text" id="reference" name="reference" :value="user.client.reference" :placeholder="titles.forms.referencia" maxlength="100">
                                </div>
                              </form>
                            </div>
                            <div class="uk-margin">
                              <div class="uk-text-left">
                                <a id="regresar" class="uk-button uk-button-primary uk-light uk-button-large uk-text-bold isee-h4" href="#" uk-switcher-item="0">{{titles.principal.btnregresar}}</a>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="uk-width-2-5@s uk-width-1-1">
                          <div class="uk-margin">
                            <div class="uk-padding-small isee-background-gray">
                              <div class="uk-flex uk-flex-center isee-h3 uk-text-center isee-bold">{{titles.principal.titulo2}}</div>
                            </div>
                            <div class="uk-padding uk-padding-remove-bottom isee-border" id="checkout-table">
                              <div class="uk-text-center">
                                <div v-for="article in cartItems">
                                  <div class="">
                                    <div class="">
                                      <img :src="article.image" alt="" style="width: 170px; height: 100px;">
                                    </div>
                                    <table class="uk-table">
                                      <tbody class="uk-text-bold">
                                        <tr class="">
                                          <td v-if="lang == 'es'" class="uk-text-left">{{article.name}}</td>
                                          <td v-else class="uk-text-left">{{article.name_en}}</td>
                                          <td class="">{{ symbol }} {{ article.totalprice | toRate(value) }}</td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                              </div>
                              <hr>
                              <div class="">
                                <table class="uk-table uk-table-divider">
                                  <tbody class="uk-text-bold uk-h4">
                                    <tr class="">
                                      <td class="uk-text-left">{{titles.principal.subtotal}}</td>
                                      <td class="uk-text-right">{{ symbol }} {{ cart.subtotal | toRate(value) }}</td>
                                    </tr>
                                    <tr v-if="hasCoupon || cart.discount>0" class="">
                                      <td class="uk-text-left">{{titles.principal.descuento}}</td>
                                      <td class="uk-text-right">- {{ symbol }} {{ cart.discount | toRate(value) }}</td>
                                    </tr>
                                    <tr class="">
                                      <td class="uk-text-left">{{titles.principal.total}}</td>
                                      <td class="uk-text-right">{{ symbol }} {{ cart.total | toRate(value) }}</td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                          <div class="uk-margin">
                            <div class="uk-padding-small isee-background-gray">
                              <div class="uk-flex uk-flex-center isee-h3 uk-text-center isee-bold">{{titles.principal.titulo3}}</div>
                            </div>
                            <div class="uk-padding isee-border">
                              <div class="uk-margin">
                                <div class="uk-grid-small uk-flex-center" uk-grid>
                                  <div v-for="i in 8" :key="i">
                                    <img :src="'/pages/carrito/tarjetaspago'+i+'.jpg'" alt="">
                                  </div>
                                </div>
                              </div>
                              <div class="uk-margin">
                                <label id="checkbox-terms">
                                  <input id="accept-terms" class="uk-checkbox" type="checkbox"><span class="isee-color-gray uk-margin-small-left">{{titles.principal.msg1}} <a href="#" uk-toggle="target: #terminos"> {{titles.principal.msg2}}</a></span><br>
                                </label>
                              </div>
                              <div class="uk-margin uk-text-center">
                                <a @click="payCulqi" class="uk-button uk-button-large uk-text-bold isee-background-green uk-light isee-h4" id="culqi-button">{{titles.principal.btnpagar}}</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li id="third-content">
                      <div class="uk-background-primary">
                        <div class="uk-text-center uk-padding">
                          <p>
                            <img src="/pages/carrito/modal.png" alt="">
                          </p>
                          <p class="uk-light isee-h3 uk-text-bold">{{titles.principal.msgfin1}}</p>
                          <p class="uk-light isee-h5">
                            {{titles.principal.msgfin2}}
                          </p>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
              <div id="terminos" uk-modal>
                <div class="uk-modal-dialog uk-width-2-3@m uk-width-1-1 uk-background-primary">
                  <button class="uk-modal-close-default" type="button" uk-close></button>
                  <div class="uk-modal-body isee-modal-body">
                    <div class="uk-text-center uk-padding uk-padding-remove-bottom">
                      <p class="uk-h2 uk-text-bold uk-light">{{titles.terms.terms}}</p>
                    </div>
                    <div class="uk-padding-medium uk-background-default">
                      <div class="uk-padding">
                        <div class="">
                          <div class="uk-h4 uk-text-bold">{{titles.terms.titulo1}}</div>
                          <p class="uk-text-justify">
                            {{titles.terms.desc1}}
                          </p>
                        </div>
                        <div class="">
                          <div class="uk-h4 uk-text-bold">{{titles.terms.titulo2}}</div>
                          <p class="uk-text-justify">
                            {{titles.terms.desc2}}
                          </p>
                        </div>
                        <div class="">
                          <div class="uk-h4 uk-text-bold">{{titles.terms.titulo3}}</div>
                          <p>
                            {{titles.terms.desc3}}
                          </p>
                        </div>
                        <div class="">
                          <div class="uk-h4 uk-text-bold">{{titles.terms.titulo4}}</div>
                          <p>
                            {{titles.terms.desc4}}
                          </p>
                        </div>
                        <div class="">
                          <div class="uk-h4 uk-text-bold">{{titles.terms.titulo5}}</div>
                          <p>
                            {{titles.terms.desc5}}
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div v-else>
            <div class="">
              <div class="uk-h1 uk-text-center isee-bold isee-spacing-small">
                {{titles.principal.carritovacio}}
              </div>
              <div class="uk-h4 uk-text-center isee-bold">
                {{titles.principal.ir}} <a class="uk-link-reset" href="/shop">{{titles.principal.comprar}}</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="modal-close-default" uk-modal>
      <div class="uk-modal-dialog uk-modal-body uk-padding-large">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-text-center uk-padding">
          <p class="isee-h2 uk-text-bold">
            {{titles.principal.msgerror1}}
          </p>
          <p class="isee-h4">
            {{titles.principal.msgerror2}}
          </p>
        </div>
      </div>
    </div>

    <div id="iframeloading" class="uk-text-center" style= "display:none; position: fixed; top: 0px; left: 0px; width: 100%; height: 100%;">
       <img class="uk-position-center" src="/pages/carrito/loading.gif" alt="loading"  />
     </div>

  </section>
</template>

<script>
import _ from 'lodash'
import convertRate from '../helpers/convertRate'
var csrf_token = $('meta[name="csrf-token"]').attr('content')

export default {
  props: ['lang', 'titles', 'symbol', 'value', 'preorder', 'user', 'districts'],
  data () {
    return {
      csrf: csrf_token,
      subt: '',
      codecoupon: '',
      coupon: {
        id: 0,
        discount: 0
      },
      rate: {
        val: this.value,
        symbol: this.symbol
      },
      codevalid: '',
      show_msg: false,
      cart: this.preorder
    }
  },
  filters: {
    toRate (amount, value) {
      return convertRate(amount, value)
    }
  },
  methods: {
    deleteItem (article, index) {
      var cart = this.cartItems
      $.ajax({
        method: 'DELETE',
        url: '/cart/'+article.rowId,
        success: function (response) {
          if (response.success) {
            // cart.splice(index, 1)
            // UIkit.notification({
            //   message: '¡Eliminado!',
            //   status: 'primary',
            //   pos: 'bottom-center',
            //   timeout: 3000
            // })
            window.location.reload()
          } else {
            UIkit.notification({
              message: '¡Error!',
              status: 'danger',
              pos: 'bottom-center',
              timeout: 3000
            })
          }
        }
      })
    },
    validateCoupon () {
      this.coupon.id = 0
      this.coupon.discount = 0
      console.log(this.preorder.items)
      axios.post('/discount', {code: this.codecoupon, preorder: this.preorder, client_id: this.user.id})
      .then(res => {
        var response = res.data
        console.log(response.data)
        this.show_msg = true
        if (response.success) {
          this.cart = response.preorder
          this.codevalid = response.discounted
          this.coupon.id = response.coupon_id
          this.coupon.discount = response.discount
          UIkit.notification({
            message: '<span uk-icon="icon: success"></span> '+response.message,
            status: 'success',
            pos: 'bottom-center',
            timeout: 3000
          })
        } else {
          this.codevalid = response.discounted
          this.cart = this.preorder
          UIkit.notification({
            message: '<span uk-icon="icon: warning"></span> '+response.message,
            status: 'danger',
            pos: 'bottom-center',
            timeout: 3000
          })
        }
      })
    },
    payCulqi () {
      var curren
      if ( this.rate.symbol == 'S/.') {
        curren = 'PEN'
      } else {
        curren = 'USD'
      }
      var amount = $('#culqi_amount').val()
      amount = parseFloat(amount).toFixed(2)
      if (amount) {
        amount = amount.split('.').join("")
        amount = amount.split(',').join("")
        Culqi.publicKey = window.culqi_pk
        Culqi.settings({
          title: 'I-SEE',
          currency: curren,
          description: 'Esta es tu compra en I-SEE',
          amount: amount
        })
      }

      if( validateForm() ) {
        if($("#accept-terms").is(':checked') && validateForm()) {
          setValues(this.cart, amount)
          Culqi.open();
          // event.preventDefault();
        } else {
          UIkit.notification({
            message: 'Debe aceptar los términos y condiciones',
            status: 'danger',
            pos: 'top-center',
            timeout: 5000
          })
        }
      }
    }
  },
  computed: {
    hasCoupon () {
      return this.codevalid
    },
    cartItems () {
      return this.cart.items
    }
  }
}

</script>

<style lang="css">
</style>
