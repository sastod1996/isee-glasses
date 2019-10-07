<template>
  <section>
    <div id="gallery" class="uk-section uk-section-xsmall">
      <div class="uk-container">

        <!-- Mobile -->
        <div class="uk-margin-small uk-hidden@s">
          <div class="uk-text-center">
            <span class="uk-h2 uk-text-bold">
              {{ lang === 'en' ? product.name_en : product.name }}
            </span>
            <br>
            <span class="uk-h3">Cod. {{ product.code }}</span>
          </div>
          <div class="uk-grid uk-grid-small uk-flex-between" uk-grid>
            <div class="uk-width-1-2">
              <span class="uk-h5 uk-text-uppercase">{{ titles.color }}</span><br>
              <select class="uk-select" v-model="prod.color">
                <option v-for="color in colors" :value="color">
                  {{ lang === 'en' ? color.name_en : color.name }}
                </option>
              </select>
            </div>
            <div class="uk-width-1-2 uk-text-right">
              <div class="">
                <span class="uk-h5 uk-text-uppercase">{{ titles.size }}</span>
                <span uk-icon="question"></span>
                <div class="" uk-drop="pos: bottom-right; offset: 0">
                  <div class="uk-padding-small uk-card uk-card-default">
                    <div class="uk-drop-grid isee-h6">
                      <p class="uk-text-center">
                        <img src="/pages/producto/talla.png" alt="">
                      </p>
                    </div>
                  </div>
                </div>
                <!-- <div class="uk-inline">
                </div> -->
              </div>

              <div v-for="size in sizes" class="uk-inline">
                <label style="cursor: pointer; width: 38px; height: 38px; margin-left: 5px;" class="uk-border-circle isee-h3 uk-text-bold uk-text-center uk-flex uk-flex-middle uk-flex-center" :class="size === prod.size ? 'selected' : 'unselected'">
                  <input v-model="prod.size" class="uk-hidden" type="radio" name="size" :value="size">
                  <div v-if="lang === 'en'" class="isee-h5">
                    {{ size.name_en }}
                  </div>
                  <div v-else class="isee-h5">
                    {{ size.name }}
                  </div>
                </label>
              </div>
            </div>
          </div>
        </div>
        <!-- end mobile -->

        <div class="uk-grid-small" uk-grid>
          <div class="uk-width-2-3@s uk-width-1-1">
            <!-- Mobile -->
            <div class="uk-hidden@s">
              <div class="uk-position-relative uk-visible-toggle uk-light" uk-slider>
                <ul class="uk-slider-items uk-child-width-1-1">
                  <li v-for="pic in filteredPhotos">
                    <img :src="pic.url" alt="">
                  </li>
                </ul>

                <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slider-item="next"></a>
              </div>
            </div>

            <!-- Desktop -->
            <div class="uk-visible@s padding-remove@xs uk-padding-small">
              <div>
                <glass-test v-show="showTester" :glassImage="filteredCameras[0].url"></glass-test>
                <div v-show="!showTester" class="isee-border">
                  <div class="uk-flex uk-flex-center uk-flex-middle">
                    <img class="uk-visible@m uk-width-1-1 isee-image-show" style="height: 400px; width: auto; max-height: 400px;" :src="filteredPhotos[selectedImage].url" alt="product">
                    <img class="uk-hidden@m uk-width-1-1 isee-image-show" style="height: 180px; width: auto; max-height: 400px;" :src="filteredPhotos[selectedImage].url" alt="product">
                    <!-- <img class="uk-width-1-1 isee-image-show" :src="filteredPhotos[selectedImage].url" alt="product"> -->
                  </div>
                </div>
                <div class="uk-margin-small-top">
                  <div class="uk-grid-small uk-grid-match uk-flex uk-flex-center" uk-grid>
                    <div class="uk-width-1-4@l uk-width-1-3" v-for="(image, index) in filteredPhotos">
                      <div class="isee-border uk-inline" style="height:110px;">
                        <label class="isee-cursor uk-position-center" @click="showTester = false">
                          <input v-model="selectedImage" type="radio" name="selectedImage" :value="index" class="uk-hidden">
                          <img class="" style="max-height: 100px;" :src="image.url" alt="">
                        </label>
                      </div>
                    </div>
                    <div v-if="!contacto" class="uk-width-1-4@l uk-visible@l">
                      <a @click.prevent="showModalTester = true" class="uk-link-reset" href="#">
                        <div class="isee-background-green uk-padding-small uk-height-1-1 uk-flex uk-flex-center uk-flex-middle">
                          <div class="uk-text-center uk-light">
                            <span class="" uk-icon="icon: user; ratio: 1.5"></span><br>
                            <span class="isee-h4">{{ titles.pruebame }}</span>
                          </div>
                        </div>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="uk-width-1-3@s uk-width-1-1">
            <div class="uk-padding-small padding-remove@xs">
              <div class="uk-visible@s">
                <div class="uk-margin">
                  <div class="">
                    <span v-if="lang === 'en'" class="uk-h2 uk-text-bold">{{ product.name_en }}</span>
                    <span v-else class="uk-h2 uk-text-bold">{{ product.name }}</span><br>
                  </div>
                  <div class="">
                    <span class="uk-h3">Cod. {{ product.code }}</span>
                  </div>
                  <div class="">
                    <span v-if="stock == 0" class="uk-h5">Producto sin stock, por favor comuniquese con nosotros para saber disponibilidad</span>
                  </div>
                </div>
                <div class="uk-margin">
                  <span class="uk-h3 uk-text-bold">{{ titles.color }}:</span><br>
                  <div class="uk-flex uk-flex-left uk-flex-middle">
                    <div class="uk-width-1-2">
                      <select v-if="lang === 'en'" class="uk-select" v-model="prod.color">
                        <option v-for="color in colors" :value="color">{{ color.name_en }}</option>
                      </select>
                      <select v-else class="uk-select" v-model="prod.color">
                        <option v-for="color in colors" :value="color">{{ color.name }}</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="uk-margin">
                  <div class="uk-position-relative">
                    <span class="uk-h3 uk-text-bold">{{ titles.size }}: </span>
                    <span class="uk-position-center uk-margin-small-left uk-flex uk-flex-middle" style="width: 20px" uk-icon="icon: question" type="button"></span>
                    <div class="" uk-drop="pos: bottom-right">
                      <div class="uk-padding-small uk-card uk-card-default">
                        <div class="uk-drop-grid isee-h6">
                          <p class="uk-text-center">
                            <img src="/pages/producto/talla.png" alt="">
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="uk-flex uk-flex-left">
                    <div v-for="size in sizes">
                      <label style="cursor: pointer; width: 40px; height: 40px; margin-right: 10px;" class="uk-border-circle isee-h3 uk-text-bold uk-text-center uk-flex uk-flex-middle uk-flex-center" :class="size === prod.size ? 'selected' : 'unselected'">
                        <input v-model="prod.size" class="uk-hidden" type="radio" name="size" :value="size">
                        <div v-if="lang === 'en'" class="isee-h5">
                          {{ size.name_en }}
                        </div>
                        <div v-else class="isee-h5">
                          {{ size.name }}
                        </div>
                      </label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="uk-grid-small" uk-grid>
                <div class="uk-width-auto uk-width-1-1@s">
                  <div v-if="user.client && user.client.ally" class="isee-h2 uk-text-bold">
                    {{ rate.symbol }} {{ product.promo ? product.promo : product.price | toRate(rate.value) }}
                  </div>
                  <div v-else>
                    <div v-if="product.promo" class="isee-h4 uk-text-bold">
                      <span class="strikethrough">{{ rate.symbol }} {{ product.promo | toRate(rate.value) }}</span>
                    </div>
                    <div class="isee-h2 uk-text-bold">{{ rate.symbol }} {{ product.price | toRate(rate.value) }}</div>
                  </div>

                  <div class="isee-h6 uk-text-bold uk-visible@s">
                    <span>Aceptamos todos los medios de pago</span>
                  </div>
                </div>
                <div class="uk-width-expand uk-width-1-1@s">
                  <div>
                    <div class="isee-h6 uk-text-bold">
                      <a class="uk-link-reset" href="/nosotros#beneficios">
                        Envios gratis a todo el mundo desde Lima, Perú
                      </a>
                    </div>
                    <div class="isee-h6 uk-text-bold">
                      <a class="uk-link-reset" href="/nosotros#beneficios">
                        Compra 100% segura, sus datos de compra están protegidos
                      </a>
                    </div>
                    <div class="isee-h6 uk-text-bold uk-hidden@s uk-margin-small-top">
                      <span>Aceptamos todos los medios de pago</span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="uk-margin uk-hidden@l">
                <a @click="showModalTester = true" class="uk-width-1-1 uk-button uk-button-primary uk-light uk-text-bold" style="font-size: 1rem; padding: 8px 30px; line-height: 1.4rem;">{{ titles.pruebame }}</a>
              </div>



              <div class="uk-margin-top">
                <div class="isee-button uk-width-1-1">
                  <a v-if="!user" class="uk-width-1-1 uk-button uk-text-bold isee-background-green uk-light" href="#modal-login" uk-toggle style="font-size: 1rem; padding: 8px 30px; line-height: 1.4rem;"><img src="/fonts/vendor/lentes-01.png" width="25" height="25"> {{titles.btn1}}</a>
                  <div v-else class="uk-grid-small" uk-grid>
                    <div :class="solar ? 'uk-hidden' : 'uk-width-3-5@l uk-width-1-1'">
                      <a class="uk-width-1-1 uk-button uk-button-primary uk-light uk-text-bold" href="#types" uk-scroll="offset: 100" style="font-size: 1rem; padding: 8px 25px; line-height: 1.4rem;">{{titles.btn1}} &nbsp; &nbsp; &nbsp;<img src="/fonts/vendor/lentes-01.png" width="25" height="25"></a>
                    </div>
                    <div v-if="user.client" :class="solar ? 'uk-width-1-1' : 'uk-width-2-5@l uk-width-1-1'">
                      <form class="uk-width-1-1" @submit.prevent="sendAjaxToCart">
                        <button class="uk-width-1-1 uk-button isee-background-green uk-light uk-text-bold" style="font-size: 1rem; padding: 8px 30px; line-height: 1.4rem;">{{titles.btnAgregar}}</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Mobile buttons (tab)  -->
    <div v-show="!solar" class="uk-hidden@s uk-container">
      <div class="uk-grid-collapse" uk-grid>
        <div :class="user ? 'uk-width-1-2' : 'uk-width-1-1'">
          <button @click="tab = 1" class="uk-text-bold uk-button uk-button-small uk-height-1-1 uk-width-1-1" :class="tab === 1 ? 'isee-background-green uk-light' : 'uk-button-default'" style="line-height: 24px">
            {{ lang === 'en' ? 'PRODUCT INFORMATION' : 'INFORMACIÓN DEL PRODUCTO' }}
          </button>
        </div>
        <div v-if="user" :class="user ? 'uk-width-1-2' : 'uk-width-1-1'">
          <button @click="tab = 2" class="uk-text-bold uk-button uk-button-small uk-height-1-1" :class="tab === 2 ? 'isee-background-green uk-light' : 'uk-button-default'" style="line-height: 24px">
            {{ lang === 'en' ? 'CUSTOM YOUR GLASSES' : 'ELIGE TU TIPO DE LENTE' }}
          </button>
        </div>
      </div>
    </div>

    <div :class="{ 'hidden@xs': tab === 2 }">

      <div class="uk-section uk-section-xsmall">
        <div class="uk-container uk-container-small">
          <div class="">
            <div class="">
              <p class="uk-h3 uk-text-bold">{{titles.detalles}}</p>
            </div>
            <div class="uk-child-width-1-3@s uk-child-width-1-2 uk-grid-small" uk-grid>
              <div class="isee-h5" v-for="characteristic in product.characteristics">
                <span v-if="lang === 'en'" class="uk-text-bold">{{ characteristic.name_en }}: </span>
                <span v-else class="uk-text-bold">{{ characteristic.name }}: </span>
                <span class="" v-for="(attribute, index) in characteristic.attributes">
                  <span v-if="lang === 'en'">{{ attribute.name_en }}</span>
                  <span v-else>{{ attribute.name }}</span>
                  <span v-if="index < characteristic.attributes.length-2">, </span>
                  <span v-else-if="index < characteristic.attributes.length-1"> {{titles.y}} </span>
                </span>
              </div>
            </div>
            <div class="uk-margin-top">
              <div class="isee-h5">
                <span v-if="lang === 'en'" class="uk-text-bold">DESCRIPTION:</span>
                <span v-else class="uk-text-bold">DESCRIPCIÓN:</span>
                <div>
                  <span v-if="lang === 'en'">{{ product.description_en }}</span>
                  <span v-else>{{ product.description }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="uk-section uk-section-xsmall uk-margin-small-bottom">
        <div class="uk-container uk-container-small">
          <div class="">
            <div class="">
              <p class="uk-h3 uk-text-bold">{{ titles.medidas }}</p>
            </div>
            <div class="uk-child-width-1-4@m uk-child-width-1-2 uk-text-center" uk-grid>
              <div class="">
                <div class="uk-grid-small" uk-grid>
                  <div class="uk-width-2-5@s">
                    <span>
                      <img class="uk-width-2-3 uk-width-1-1@s" :src="'/pages/producto/ancho.png'" alt="">
                    </span>
                  </div>
                  <div class="uk-width-3-5@s uk-flex uk-flex-middle uk-flex-center">
                    <span v-if="lang === 'en'" class="uk-text-bold">Width: </span>
                    <span v-else class="uk-text-bold">Ancho: </span>
                    <span class="isee-h5 uk-margin-small-left"> {{ prod.size.width }} mm.</span>
                  </div>
                </div>
              </div>
              <div class="">
                <div class="uk-grid-small" uk-grid>
                  <div class="uk-width-2-5@s">
                    <span>
                      <img class="uk-width-2-3 uk-width-1-1@s" :src="'/pages/producto/puente.png'" alt="">
                    </span>
                  </div>
                  <div class="uk-width-3-5@s uk-flex uk-flex-middle uk-flex-center">
                    <span v-if="lang === 'en'" class="uk-text-bold">Bridge: </span>
                    <span v-else class="uk-text-bold">Puente: </span>
                    <span class="isee-h5 uk-margin-small-left"> {{ prod.size.bridge }} mm.</span>
                  </div>
                </div>
              </div>
              <div class="">
                <div class="uk-grid-small" uk-grid>
                  <div class="uk-width-2-5@s">
                    <span>
                      <img class="uk-width-2-3 uk-width-1-1@s" :src="'/pages/producto/largo.png'" alt="">
                    </span>
                  </div>
                  <div class="uk-width-3-5@s uk-flex uk-flex-middle uk-flex-center">
                    <span v-if="lang === 'en'" class="uk-text-bold">Large: </span>
                    <span v-else class="uk-text-bold">Largo: </span>
                    <span class="isee-h5 uk-margin-small-left"> {{ prod.size.large }} mm.</span>
                  </div>
                </div>
              </div>
              <div class="">
                <div class="uk-grid-small" uk-grid>
                  <div class="uk-width-2-5@s">
                    <span>
                      <img class="uk-width-2-3 uk-width-1-1@s" :src="'/pages/producto/alto.png'" alt="">
                    </span>
                  </div>
                  <div class="uk-width-3-5@s uk-flex uk-flex-middle uk-flex-center">
                    <span v-if="lang === 'en'" class="uk-text-bold">Height: </span>
                    <span v-else class="uk-text-bold">Alto: </span>
                    <span class="isee-h5 uk-margin-small-left"> {{ prod.size.height }} mm.</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

    <div v-show="!solar" :class="!user ? 'uk-hidden' : { 'hidden@xs': tab === 1 }" class="uk-container uk-container-small">

      <ul ref="accordion" uk-accordion>
        <li id="types" class="uk-open">
          <h3 class="uk-accordion-title accordion-title-blue" data-index="1.">{{titles.seccion1}}</h3>
          <div class="uk-accordion-content">
            <div class="">
              <!-- Mobile -->
              <div class="uk-hidden@s">
                <div class="uk-flex uk-flex-between" v-for="typeG in typs">
                  <label class="uk-display-block uk-border-rounded">
                    <input v-model="type" class="uk-radio" type="radio" :value="typeG">
                    {{ lang === 'en' ? typeG.name_en : typeG.name }}
                  </label>
                  <div class="">
                    <span style="width: 20px" uk-icon="icon: question"></span>
                    <div uk-drop="pos: bottom-right; offset: 0">
                      <div class="uk-padding-small uk-card uk-card-default">
                        <div class="uk-drop-grid">
                          <div  class="uk-text-justify">
                            <div v-if="lang === 'en'" class="isee-h6">{{ typeG.description_en }}</div>
                            <div v-else class="isee-h6">{{ typeG.description }}</div>
                          </div>
                          <p class="uk-text-center">
                            <img :src="typeG.image" alt="">
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Desktop -->
              <div class="uk-visible@s uk-section uk-section-xsmall">
                <div class="uk-container uk-container-small">
                  <div class="">
                    <div class="uk-child-width-1-5@s uk-child-width-1-1 uk-grid-small" uk-grid>
                      <div class="uk-margin-auto" v-for="typeG in typs">
                        <label class="uk-display-block uk-border-rounded" style="cursor: pointer">
                          <input v-model="type" class="uk-hidden" type="radio" :value="typeG">
                          <div class="isee-padding-xsmall" :class="typeG === type ? 'selected' : 'unselected'">
                            <div class="uk-position-relative uk-text-center">
                              <span class="isee-h5 uk-text-bold uk-text-uppercase">
                                <span v-if="lang === 'en'">
                                  {{ typeG.name_en }}
                                </span>
                                <span v-else>
                                  {{ typeG.name }}
                                </span>
                              </span>
                              <span class="uk-position-right uk-flex uk-flex-middle" style="width: 20px" uk-icon="icon: question" type="button"></span>
                              <div class="" uk-drop="pos: bottom-center">
                                <div class="uk-padding-small uk-card uk-card-default">
                                  <div class="uk-drop-grid">
                                    <div  class="uk-text-justify">
                                      <div v-if="lang === 'en'" class="isee-h6">{{ typeG.description_en }}</div>
                                      <div v-else class="isee-h6">{{ typeG.description }}</div>
                                    </div>
                                    <p class="uk-text-center">
                                      <img :src="typeG.image" alt="">
                                    </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </li>

        <li id="prescription">
          <h3 class="uk-accordion-title accordion-title-blue" data-index="2.">{{titles.seccion2}}</h3>
          <div class="uk-accordion-content">
            <div v-show="prescVisible">
              <div class="uk-container uk-container-small">
                <div class="">
                  <div class="uk-text-center uk-padding-small padding-remove@xs">
                    <p class="isee-h5">Es necesario que adjunte la imagen de su receta para que su compra tenga garantía de cambio.</p>
                  </div>

                  <!-- Desktop -->
                  <div class="uk-visible@s">
                    <ul class="uk-flex uk-flex-center uk-subnav uk-subnav-pill uk-grid-match uk-grid-small" uk-grid uk-switcher>
                      <li class="uk-width-1-3@s uk-width-auto">
                        <a href="#">
                          <div class="uk-text-bold uk-text-center isee-h4 text-medium">
                            {{titles.seccion22}}
                          </div>
                        </a>
                      </li>
                      <li class="uk-width-1-3@s uk-width-auto">
                        <a href="#">
                          <div class="uk-text-bold uk-text-center isee-h4 text-medium">
                            {{titles.seccion21}}
                          </div>
                        </a>

                      </li>
                      <li class="uk-width-1-3@s uk-width-auto">
                        <a href="#">
                          <div class="uk-text-bold uk-text-center isee-h4 text-medium">
                            {{titles.seccion23}}
                          </div>
                        </a>
                      </li>
                    </ul>
                    <ul class="uk-switcher uk-margin-top">
                      <li>
                        <form class="" @submit.prevent="submitForm">
                          <div class="uk-text-center uk-margin-small" uk-margin>
                            <div class="uk-width-1-2" uk-form-custom="target: true">
                              <input type="file" @change="onFileChange">
                              <input :value="presc.filename" class="uk-input uk-form isee-upload-file" type="text" placeholder="Seleccionar receta">
                            </div>
                            <span v-if="user !== 0" class="">
                              <span v-if="user.client" class="">
                                <button class="uk-button isee-background-green uk-light uk-text-bold isee-btn-guardar" type="submit">{{titles.enviar}}</button>
                              </span>
                              <span>
                                <a v-on:click="clear" uk-icon="icon: close; ratio: 1.5"></a>
                              </span>
                            </span>
                            <span v-else class="">
                              <a class="uk-button isee-background-green uk-light uk-text-bold" href="#modal-login" uk-toggle>{{titles.ingresar}}</a>
                            </span>
                            <div class="uk-text-center">
                              <span>Tamaño máximo: 1 MB</span><br>
                              <span>Formato: .jpg y .png</span>
                            </div>
                          </div>
                        </form>
                      </li>
                      <li>
                        <form class="" @submit.prevent="submitForm">
                          <div class="">
                            <div class="isee-table-prescription">
                              <table class="uk-table uk-table-responsive">
                                <thead>
                                  <tr>
                                    <th class="uk-width-1-5"></th>
                                    <th class="uk-width-1-5 uk-text-center">
                                      <div class="uk-position-relative uk-text-center">
                                        <span class="isee-h6">{{titles.esfera}} (ESF)</span>
                                        <span class="uk-position-right uk-flex uk-flex-middle" uk-icon="icon: question" type="button"></span>
                                        <div class="" uk-drop="pos: bottom-center" style="width: 420px;">
                                          <div class="uk-card uk-card-body uk-card-default uk-padding-small isee-table-prescription-drop">
                                            <div class="uk-drop-grid">
                                              <div class="uk-text-justify">
                                                <div class="isee-h6" style="text-transform: none;">{{titles.esferadesc}}</div>
                                                <div class="uk-overflow-auto">
                                                  <table class="uk-table uk-table-responsive uk-table-hover uk-table-divider uk-text-center uk-text-middle">
                                                    <thead>
                                                      <tr class="uk-text-center">
                                                        <th></th>
                                                        <th></th>
                                                        <th class="uk-text-center">Esf.</th>
                                                        <th class="uk-text-center">Cil.</th>
                                                        <th class="uk-text-center">Eje</th>
                                                        <th class="uk-text-center">DIP</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                      <tr>
                                                        <td rowspan="2" class="uk-text-middle">Lejos</td>
                                                        <td>OD</td>
                                                        <td class="isee-background-gray">+4.50</td>
                                                        <td>-0.75</td>
                                                        <td>160°</td>
                                                        <td rowspan="2" class="uk-text-middle">65</td>
                                                      </tr>
                                                      <tr>
                                                        <td>OI</td>
                                                        <td class="isee-background-gray">+5.00</td>
                                                        <td>-1.25</td>
                                                        <td>160°</td>
                                                      </tr>
                                                      <tr>
                                                        <td rowspan="2" class="uk-text-middle">Cerca</td>
                                                        <td>OD</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td rowspan="2" class="uk-text-middle">63</td>
                                                      </tr>
                                                      <tr>
                                                        <td>OI</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                      </tr>
                                                      <tr>
                                                        <td class="" colspan="2">Obs.:</td>
                                                        <td class="" colspan="3">ADD +1.25</td>
                                                        <td></td>
                                                      </tr>
                                                    </tbody>
                                                  </table>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </th>
                                    <th class="uk-width-1-5 uk-text-center">
                                      <div class="uk-position-relative uk-text-center">
                                        <span class="isee-h6">{{titles.cilindro}} (CIL)</span>
                                        <span class="uk-position-right uk-flex uk-flex-middle" uk-icon="icon: question" type="button"></span>
                                        <div class="" uk-drop="pos: bottom-center" style="width: 420px;">
                                          <div class="uk-card uk-card-body uk-card-default uk-padding-small isee-table-prescription-drop">
                                            <div class="uk-drop-grid">
                                              <div class="uk-text-justify">
                                                <div class="isee-h6" style="text-transform: none;">{{titles.cilindrodesc}}</div>
                                                <div class="uk-overflow-auto">
                                                  <table class="uk-table uk-table-responsive uk-table-hover uk-table-divider uk-text-center uk-text-middle">
                                                    <thead>
                                                      <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th class="uk-text-center">Esf.</th>
                                                        <th class="uk-text-center">Cil.</th>
                                                        <th class="uk-text-center">Eje</th>
                                                        <th class="uk-text-center">DIP</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                      <tr>
                                                        <td rowspan="2" class="uk-text-middle">Lejos</td>
                                                        <td>OD</td>
                                                        <td>+4.50</td>
                                                        <td class="isee-background-gray">-0.75</td>
                                                        <td>160°</td>
                                                        <td rowspan="2" class="uk-text-middle">65</td>
                                                      </tr>
                                                      <tr>
                                                        <td>OI</td>
                                                        <td>+5.00</td>
                                                        <td class="isee-background-gray">-1.25</td>
                                                        <td>160°</td>
                                                      </tr>
                                                      <tr>
                                                        <td rowspan="2" class="uk-text-middle">Cerca</td>
                                                        <td>OD</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td rowspan="2" class="uk-text-middle">63</td>
                                                      </tr>
                                                      <tr>
                                                        <td>OI</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                      </tr>
                                                      <tr>
                                                        <td class="" colspan="2">Obs.:</td>
                                                        <td class="" colspan="3">ADD +1.25</td>
                                                        <td></td>
                                                      </tr>
                                                    </tbody>
                                                  </table>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </th>
                                    <th class="uk-width-1-5 uk-text-center">
                                      <div class="uk-position-relative uk-text-center">
                                        <span class="isee-h6">{{titles.eje}} (AXI)</span>
                                        <span class="uk-position-right uk-flex uk-flex-middle" uk-icon="icon: question" type="button"></span>
                                        <div class="" uk-drop="pos: bottom-center" style="width: 420px;">
                                          <div class="uk-card uk-card-body uk-card-default uk-padding-small isee-table-prescription-drop">
                                            <div class="uk-drop-grid">
                                              <div class="uk-text-justify">
                                                <div class="isee-h6" style="text-transform: none;">{{titles.ejedesc}}</div>
                                                <div class="uk-overflow-auto">
                                                  <table class="uk-table uk-table-responsive uk-table-hover uk-table-divider uk-text-center uk-text-middle">
                                                    <thead>
                                                      <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th class="uk-text-center">Esf.</th>
                                                        <th class="uk-text-center">Cil.</th>
                                                        <th class="uk-text-center">Eje</th>
                                                        <th class="uk-text-center">DIP</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                      <tr>
                                                        <td rowspan="2" class="uk-text-middle">Lejos</td>
                                                        <td>OD</td>
                                                        <td>+4.50</td>
                                                        <td>-0.75</td>
                                                        <td class="isee-background-gray">160°</td>
                                                        <td rowspan="2" class="uk-text-middle">65</td>
                                                      </tr>
                                                      <tr>
                                                        <td>OI</td>
                                                        <td>+5.00</td>
                                                        <td>-1.25</td>
                                                        <td class="isee-background-gray">160°</td>
                                                      </tr>
                                                      <tr>
                                                        <td rowspan="2" class="uk-text-middle">Cerca</td>
                                                        <td>OD</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td rowspan="2" class="uk-text-middle">63</td>
                                                      </tr>
                                                      <tr>
                                                        <td>OI</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                      </tr>
                                                      <tr>
                                                        <td class="" colspan="2">Obs.:</td>
                                                        <td class="" colspan="3">ADD +1.25</td>
                                                        <td></td>
                                                      </tr>
                                                    </tbody>
                                                  </table>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </th>
                                    <th class="uk-width-1-5 uk-text-center">
                                      <div class="uk-position-relative uk-text-center">
                                        <span class="isee-h6">{{titles.adicion}}<br>(ADD)</span>
                                        <span class="uk-position-right uk-flex uk-flex-middle" uk-icon="icon: question" type="button"></span>
                                        <div class="" uk-drop="pos: bottom-center" style="width: 420px;">
                                          <div class="uk-card uk-card-body uk-card-default uk-padding-small isee-table-prescription-drop">
                                            <div class="uk-drop-grid">
                                              <div class="uk-text-justify">
                                                <div class="isee-h6" style="text-transform: none;">{{titles.adiciondesc}}</div>
                                                <div class="uk-overflow-auto">
                                                  <table class="uk-table uk-table-responsive uk-table-hover uk-table-divider uk-text-center uk-text-middle">
                                                    <thead>
                                                      <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th class="uk-text-center">Esf.</th>
                                                        <th class="uk-text-center">Cil.</th>
                                                        <th class="uk-text-center">Eje</th>
                                                        <th class="uk-text-center">DIP</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                      <tr>
                                                        <td rowspan="2" class="uk-text-middle">Lejos</td>
                                                        <td>OD</td>
                                                        <td>+4.50</td>
                                                        <td>-0.75</td>
                                                        <td>160°</td>
                                                        <td rowspan="2" class="uk-text-middle isee-background-gray">65</td>
                                                      </tr>
                                                      <tr>
                                                        <td>OI</td>
                                                        <td>+5.00</td>
                                                        <td>-1.25</td>
                                                        <td>160°</td>
                                                      </tr>
                                                      <tr>
                                                        <td rowspan="2" class="uk-text-middle">Cerca</td>
                                                        <td>OD</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td rowspan="2" class="uk-text-middle">63</td>
                                                      </tr>
                                                      <tr>
                                                        <td>OI</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                      </tr>
                                                      <tr>
                                                        <td class="" colspan="2">Obs.:</td>
                                                        <td class="" colspan="3">ADD +1.25</td>
                                                        <td></td>
                                                      </tr>
                                                    </tbody>
                                                  </table>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>
                                      <div class="uk-hidden@m uk-text-uppercase uk-text-bold">{{ titles.ojoder }} (OD)</div>
                                      <div class="uk-visible@m">{{ titles.ojoder }} (OD)</div>
                                    </td>
                                    <td>
                                      <div class="uk-hidden@m">
                                        <div class="" uk-grid>
                                          <div class="uk-width-1-2">
                                            {{titles.esfera}} (ESF)
                                          </div>
                                          <div class="uk-width-1-2">
                                            <select class="uk-select" v-model="presc.esfod">
                                              <option v-for="i in 73" :value="0.25*(i-1)-10" selected>{{ 0.25*(i-1)-10 | currency }}</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="uk-visible@m">
                                        <select class="uk-select" v-model="presc.esfod">
                                          <option v-for="i in 73" :value="0.25*(i-1)-10" selected>{{ 0.25*(i-1)-10 | currency }}</option>
                                        </select>
                                      </div>
                                    </td>
                                    <td>
                                      <div class="uk-hidden@m">
                                        <div class="" uk-grid>
                                          <div class="uk-width-1-2">
                                            {{titles.cilindro}} (CIL)
                                          </div>
                                          <div class="uk-width-1-2">
                                            <select class="uk-select" v-model="presc.cilod">
                                              <option v-for="i in 49" :value="0.25*(i-1)-6" selected>{{ 0.25*(i-1)-6 | currency }}</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="uk-visible@m">
                                        <select class="uk-select" v-model="presc.cilod">
                                          <option v-for="i in 49" :value="0.25*(i-1)-6" selected>{{ 0.25*(i-1)-6 | currency }}</option>
                                        </select>
                                      </div>
                                    </td>
                                    <td>
                                      <div class="uk-hidden@m">
                                        <div class="" uk-grid>
                                          <div class="uk-width-1-2">
                                            {{titles.eje}} (AXI)
                                          </div>
                                          <div class="uk-width-1-2">
                                            <select class="uk-select" v-model="presc.axiod">
                                              <option v-for="i in 181" :value="i-1" selected>{{ i-1 }}</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="uk-visible@m">
                                        <select class="uk-select" v-model="presc.axiod">
                                          <option v-for="i in 181" :value="i-1" selected>{{ i-1 }}</option>
                                        </select>
                                      </div>
                                    </td>
                                    <td>
                                      <div class="uk-hidden@m">
                                        <div class="" uk-grid>
                                          <div class="uk-width-1-2">
                                            {{titles.adicion}} (ADD)
                                          </div>
                                          <div class="uk-width-1-2">
                                            <select class="uk-select" v-model="presc.addod">
                                              <option v-for="i in 17" :value="0.25*(i-1)" selected>{{ 0.25*(i-1) | currency }}</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="uk-visible@m">
                                        <select class="uk-select" v-model="presc.addod">
                                          <option v-for="i in 17" :value="0.25*(i-1)" selected>{{ 0.25*(i-1) | currency }}</option>
                                        </select>
                                      </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>
                                      <div class="uk-hidden@m uk-text-uppercase uk-text-bold">{{titles.ojoizq}} (OI)</div>
                                      <div class="uk-visible@m">{{titles.ojoizq}} (OI)</div>
                                    </td>
                                    <td>
                                      <div class="uk-hidden@m">
                                        <div class="" uk-grid>
                                          <div class="uk-width-1-2">
                                            {{titles.esfera}} (ESF)
                                          </div>
                                          <div class="uk-width-1-2">
                                            <select class="uk-select" v-model="presc.esfoi">
                                              <option v-for="i in 73" :value="0.25*(i-1)-10" selected>{{ 0.25*(i-1)-10 | currency }}</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="uk-visible@m">
                                        <select class="uk-select" v-model="presc.esfoi">
                                          <option v-for="i in 73" :value="0.25*(i-1)-10" selected>{{ 0.25*(i-1)-10 | currency }}</option>
                                        </select>
                                      </div>
                                    </td>
                                    <td>
                                      <div class="uk-hidden@m">
                                        <div class="" uk-grid>
                                          <div class="uk-width-1-2">
                                            {{titles.cilindro}} (CIL)
                                          </div>
                                          <div class="uk-width-1-2">
                                            <select class="uk-select" v-model="presc.ciloi">
                                              <option v-for="i in 49" :value="0.25*(i-1)-6" selected>{{ 0.25*(i-1)-6 | currency }}</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="uk-visible@m">
                                        <select class="uk-select" v-model="presc.ciloi">
                                          <option v-for="i in 49" :value="0.25*(i-1)-6" selected>{{ 0.25*(i-1)-6 | currency }}</option>
                                        </select>
                                      </div>
                                    </td>
                                    <td>
                                      <div class="uk-hidden@m">
                                        <div class="" uk-grid>
                                          <div class="uk-width-1-2">
                                            {{titles.eje}} (AXI)
                                          </div>
                                          <div class="uk-width-1-2">
                                            <select class="uk-select" v-model="presc.axioi">
                                              <option v-for="i in 181" :value="i-1" selected>{{ i-1 }}</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="uk-visible@m">
                                        <select class="uk-select" v-model="presc.axioi">
                                          <option v-for="i in 181" :value="i-1" selected>{{ i-1 }}</option>
                                        </select>
                                      </div>
                                    </td>
                                    <td>
                                      <div class="uk-hidden@m">
                                        <div class="" uk-grid>
                                          <div class="uk-width-1-2">
                                            {{titles.adicion}} (ADD)
                                          </div>
                                          <div class="uk-width-1-2">
                                            <select class="uk-select" v-model="presc.addoi">
                                              <option v-for="i in 17" :value="0.25*(i-1)" selected>{{ 0.25*(i-1) | currency }}</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="uk-visible@m">
                                        <select class="uk-select" v-model="presc.addoi">
                                          <option v-for="i in 17" :value="0.25*(i-1)" selected>{{ 0.25*(i-1) | currency }}</option>
                                        </select>
                                      </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>
                                      <div class="uk-hidden@m">
                                        <span class="uk-text-uppercase uk-text-bold">{{ titles.distanciainter }} (DIP)</span>
                                        <span class="" uk-icon="icon: question" type="button"></span>
                                        <div class="" uk-drop="pos: bottom-center">
                                          <div class="uk-padding-small uk-card uk-card-default">
                                            <div class="uk-drop-grid">
                                              <div class="uk-text-justify">
                                                <div class="isee-h6">{{titles.distanciainterdesc}}</div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="uk-visible@m">
                                        <div class="uk-position-relative">
                                          <span>{{titles.distanciainter}} (DIP)</span>
                                          <span class="uk-position-right uk-flex uk-flex-middle" uk-icon="icon: question" type="button"></span>
                                          <div class="" uk-drop="pos: bottom-center">
                                            <div class="uk-padding-small uk-card uk-card-default">
                                              <div class="uk-drop-grid">
                                                <div class="uk-text-justify">
                                                  <div class="isee-h6">{{titles.distanciainterdesc}}</div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </td>
                                    <td>
                                      <div class="uk-hidden@m">
                                        <div class="" uk-grid>
                                          <div class="uk-width-1-2">
                                            DIP lejos
                                          </div>
                                          <div class="uk-width-1-2">
                                            <select class="uk-select" v-model="presc.esfdip">
                                              <option v-for="i in 31" :value="i+49" selected>{{ i+49 }}</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="uk-visible@m">
                                        <select class="uk-select" v-model="presc.esfdip">
                                          <option v-for="i in 31" :value="i+49" selected>{{ i+49 }}</option>
                                        </select>
                                      </div>
                                    </td>
                                    <!-- <td></td>
                                    <td></td>
                                    <td></td> -->
                                  </tr>
                                  <tr>
                                    <td>
                                      <div class="uk-hidden@m">
                                        <span class="uk-text-uppercase uk-text-bold">{{ titles.distanciainter2 }} (DIP)</span>
                                        <span class="" uk-icon="icon: question" type="button"></span>
                                        <div class="" uk-drop="pos: bottom-center">
                                          <div class="uk-padding-small uk-card uk-card-default">
                                            <div class="uk-drop-grid">
                                              <div class="uk-text-justify">
                                                <div class="isee-h6">{{titles.distanciainter2desc}}</div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="uk-visible@m">
                                        <div class="uk-position-relative">
                                          <span>{{titles.distanciainter2}} (DIP)</span>
                                          <!-- <span class="uk-position-right uk-flex uk-flex-middle" uk-icon="icon: question" type="button"></span> -->
                                          <!-- <div class="" uk-drop="pos: bottom-center">
                                            <div class="uk-padding-small uk-card uk-card-default">
                                              <div class="uk-drop-grid">
                                                <div class="uk-text-justify">
                                                  <div class="isee-h6">{{titles.distanciainter2desc}}</div>
                                                </div>
                                              </div>
                                            </div>
                                          </div> -->
                                        </div>
                                      </div>
                                    </td>
                                    <td>
                                      <div class="uk-hidden@m">
                                        <div class="" uk-grid>
                                          <div class="uk-width-1-2">
                                            DIP cerca
                                          </div>
                                          <div class="uk-width-1-2">
                                            <select class="uk-select" v-model="presc.dip">
                                              <option v-for="i in 31" :value="i+49" selected>{{ i+49 }}</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="uk-visible@m">
                                        <select class="uk-select" v-model="presc.dip">
                                          <option v-for="i in 31" :value="i+49" selected>{{ i+49 }}</option>
                                        </select>
                                      </div>
                                    </td>
                                    <!-- <td></td>
                                    <td></td>
                                    <td></td> -->
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            <div class="uk-margin">
                              <div class="">
                                <div class="">
                                  <p class="uk-text-bold">{{titles.pregunta1}}</p>
                                </div>
                                <div class="">
                                  <textarea v-model="presc.desc" class="uk-width-1-1 uk-textarea" rows="2"></textarea>
                                </div>
                              </div>
                            </div>
                            <div class="uk-text-center">
                              <div class="">
                                <div v-if="user !== 0" class="">
                                  <button v-if="user.client" class="uk-button uk-button-large isee-background-green uk-light uk-text-bold isee-btn-guardar" type="submit">{{titles.guardar}}</button>
                                </div>
                                <div v-else class="">
                                  <a class="uk-button uk-button-large isee-background-green uk-light uk-text-bold" href="#modal-login" uk-toggle>{{titles.ingresar}}</a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </form>
                      </li>
                      <li>
                        <div v-if="user == 0" class="">
                          <div class="">
                            <p class="isee-h4">{{titles.mensaje1}}</p>
                            <p>
                              <a class="uk-button uk-button-default" href="#modal-login" uk-toggle>{{titles.ingresar}}</a>
                            </p>
                          </div>
                        </div>
                        <div v-else class="">
                          <div v-if="!user.client">
                            <div class="uk-text-center">
                              <p class="isee-h4">{{titles.mensaje2}}</p>
                            </div>
                          </div>
                          <div v-else>
                            <div v-if="prescripts.length" class="">
                              <div class="" v-for="p in prescripts">
                                <label class="isee-h5">
                                  <input v-model="presc" name="prescription" type="radio" :value="p">
                                  {{ p.name.substr(0,12) == 'isee-archivo' ? p.name.substr(13) : p.name }}
                                </label>
                                <span> {{ p.created_at ? '- '+moment(p.created_at).fromNow() : '' }}</span>
                              </div>
                            </div>
                            <div v-else class="">
                              <div class="uk-text-center">
                                <p class="isee-h4">{{titles.mensaje3}}</p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>

                  <!-- Mobile -->
                  <div class="uk-hidden@s">

                    <label class="padding-sm uk-display-block border">
                      <input type="radio" v-model="prescTab" :value="1" class="uk-radio">
                      <b>{{titles.seccion22}}</b>
                    </label>
                    <label class="padding-sm uk-display-block border">
                      <input type="radio" v-model="prescTab" :value="2" class="uk-radio">
                      <b>{{titles.seccion21}}</b>
                    </label>
                    <label class="padding-sm uk-display-block border">
                      <input type="radio" v-model="prescTab" :value="3" class="uk-radio">
                      <b>{{titles.seccion23}}</b>
                    </label>

                    <br>

                    <form v-show="prescTab === 1" class="" @submit.prevent="submitForm">
                      <div class="uk-text-center uk-margin-small" uk-margin>
                        <div class="uk-width-1-2" uk-form-custom="target: true">
                          <input type="file" @change="onFileChange">
                          <input :value="presc.filename" class="uk-input uk-form isee-upload-file" type="text" placeholder="Seleccionar receta">
                        </div>
                        <span v-if="user !== 0" class="">
                          <span v-if="user.client" class="">
                            <button class="uk-button isee-background-green uk-light uk-text-bold isee-btn-guardar" type="submit">{{titles.enviar}}</button>
                          </span>
                          <span>
                            <a v-on:click="clear" uk-icon="icon: close; ratio: 1.5"></a>
                          </span>
                        </span>
                        <span v-else class="">
                          <a class="uk-button isee-background-green uk-light uk-text-bold" href="#modal-login" uk-toggle>{{titles.ingresar}}</a>
                        </span>
                        <div class="uk-text-center">
                          <span>Tamaño máximo: 1 MB</span><br>
                          <span>Formato: .jpg y .png</span>
                        </div>
                      </div>
                    </form>

                    <form v-show="prescTab === 2" class="" @submit.prevent="submitForm">
                      <div class="">

                        <div class="isee-table-prescription">
                          <table class="uk-table uk-table-small">
                            <thead>
                              <tr>
                                <th></th>
                                <th>OI</th>
                                <th>OD</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <th>Esf</th>
                                <td>
                                  <select class="uk-select uk-form-small" v-model="presc.esfoi">
                                    <option v-for="i in 73" :value="0.25*(i-1)-10" selected>{{ 0.25*(i-1)-10 | currency }}</option>
                                  </select>
                                </td>
                                <td>
                                  <select class="uk-select uk-form-small" v-model="presc.esfod">
                                    <option v-for="i in 73" :value="0.25*(i-1)-10" selected>{{ 0.25*(i-1)-10 | currency }}</option>
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <th>Cil</th>
                                <td>
                                  <select class="uk-select uk-form-small" v-model="presc.ciloi">
                                    <option v-for="i in 49" :value="0.25*(i-1)-6" selected>{{ 0.25*(i-1)-6 | currency }}</option>
                                  </select>
                                </td>
                                <td>
                                  <select class="uk-select uk-form-small" v-model="presc.cilod">
                                    <option v-for="i in 49" :value="0.25*(i-1)-6" selected>{{ 0.25*(i-1)-6 | currency }}</option>
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <th>Axi</th>
                                <td>
                                  <select class="uk-select uk-form-small" v-model="presc.axioi">
                                    <option v-for="i in 181" :value="i-1" selected>{{ i-1 }}</option>
                                  </select>
                                </td>
                                <td>
                                  <select class="uk-select uk-form-small" v-model="presc.axiod">
                                    <option v-for="i in 181" :value="i-1" selected>{{ i-1 }}</option>
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <th>Add</th>
                                <td>
                                  <select class="uk-select uk-form-small" v-model="presc.addoi">
                                    <option v-for="i in 17" :value="0.25*(i-1)" selected>{{ 0.25*(i-1) | currency }}</option>
                                  </select>
                                </td>
                                <td>
                                  <select class="uk-select uk-form-small" v-model="presc.addod">
                                    <option v-for="i in 17" :value="0.25*(i-1)" selected>{{ 0.25*(i-1) | currency }}</option>
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <th>Dip lejos</th>
                                <td>
                                  <select class="uk-select uk-form-small" v-model="presc.esfdip">
                                    <option v-for="i in 31" :value="i+49" selected>{{ i+49 }}</option>
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <th>Dip cerca</th>
                                <td>
                                  <select class="uk-select uk-form-small" v-model="presc.dip">
                                    <option v-for="i in 31" :value="i+49" selected>{{ i+49 }}</option>
                                  </select>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>

                        <div class="uk-margin">
                          <div class="">
                            <div class="">
                              <p class="uk-text-bold">{{titles.pregunta1}}</p>
                            </div>
                            <div class="">
                              <textarea v-model="presc.desc" class="uk-width-1-1 uk-textarea" rows="2"></textarea>
                            </div>
                          </div>
                        </div>
                        <div class="uk-text-center">
                          <div class="">
                            <div v-if="user !== 0" class="">
                              <button v-if="user.client" class="uk-button uk-button-large isee-background-green uk-light uk-text-bold isee-btn-guardar" type="submit">{{titles.guardar}}</button>
                            </div>
                            <div v-else class="">
                              <a class="uk-button uk-button-large isee-background-green uk-light uk-text-bold" href="#modal-login" uk-toggle>{{titles.ingresar}}</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>

                    <div v-show="prescTab === 3" class="">
                      <div v-if="user == 0" class="">
                        <div class="">
                          <p class="isee-h4">{{titles.mensaje1}}</p>
                          <p>
                            <a class="uk-button uk-button-default" href="#modal-login" uk-toggle>{{titles.ingresar}}</a>
                          </p>
                        </div>
                      </div>
                      <div v-else class="">
                        <div v-if="!user.client">
                          <div class="uk-text-center">
                            <p class="isee-h4">{{titles.mensaje2}}</p>
                          </div>
                        </div>
                        <div v-else>
                          <div v-if="prescripts.length" class="">
                            <div class="" v-for="p in prescripts" :key="p">
                              <label class="isee-h5">
                                <input v-model="presc" name="prescription-mobile" type="radio" :value="p">
                                {{ p.name.substr(0,12) == 'isee-archivo' ? p.name.substr(13) : p.name }}
                              </label>
                              <span> {{ p.created_at ? '- '+moment(p.created_at).fromNow() : '' }}</span>
                            </div>
                          </div>
                          <div v-else class="">
                            <div class="uk-text-center">
                              <p class="isee-h4">{{titles.mensaje3}}</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>

            </div>
          </div>
        </li>

        <li id="packs">
          <h3 class="uk-accordion-title accordion-title-blue" data-index="3.">{{titles.seccion3}}</h3>
          <div class="uk-accordion-content">
            <div class="isee-packs-section">
              <div class="uk-container uk-container-small">
                <div class="">
                  <div class="uk-text-center uk-padding-small padding-remove@xs">
                    <p class="isee-h4 uk-text-bold">- {{titles.msgseccion3}} -</p>
                  </div>

                  <!-- Desktop -->
                  <div class="uk-visible@s uk-child-width-1-3@s uk-child-width-1-2 uk-grid-small" uk-height-match="target: > div > div > label .isee-packs" uk-grid>
                    <div v-for="packG in selectedType">
                      <div class="" :class="packG.class">
                        <label style="cursor: pointer;">
                          <input v-model="pack" class="uk-hidden" type="radio" name="" :value="packG">
                          <div class="isee-padding-xsmall" :class="packG === pack ? 'selected' : 'unselected'">
                            <div class="uk-text-center uk-position-relative">
                              <span v-if="lang === 'en'" class="isee-h4 uk-text-uppercase uk-text-bold">{{ packG.name_en }} </span>
                              <span v-else class="isee-h4 uk-text-uppercase uk-text-bold">{{ packG.name }} </span>
                              <span class="uk-position-right uk-flex uk-flex-middle" style="width: 20px" uk-icon="icon: question" type="button"></span>
                              <div class="" uk-drop="pos: bottom-center">
                                <div class="uk-padding-small uk-card uk-card-default">
                                  <div class="uk-drop-grid">
                                    <div v-if="lang === 'en'" class="isee-h6 uk-text-justify" v-html="packG.help_en"></div>
                                    <div v-else class="isee-h6 uk-text-justify" v-html="packG.help"></div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="isee-padding-xsmall isee-border uk-text-center" :class="packG === pack ? 'pack-selected' : 'pack-unselected'">
                            <div style="padding: 8px">
                              <div class="isee-h5 uk-text-bold isee-packs">
                                <p v-if="lang === 'en'" v-html="packG.description_en"></p>
                                <p v-else v-html="packG.description"></p>
                              </div>
                              <div class="uk-text-bold isee-h5">{{ rate.symbol }} {{ packG.price | toRate(rate.value) }}</div>
                            </div>
                          </div>
                        </label>
                      </div>
                    </div>
                  </div>

                  <!-- Mobile -->
                  <ul class="uk-hidden@s" uk-accordion>
                    <li v-for="(packG, index) in selectedType" :class="{ 'uk-open': index === 0 }">
                      <div class="uk-accordion-title" :class="{ selected: pack === packG, [packG.class]: true }" @click="pack = packG">
                        <span>{{ lang === 'en' ? packG.name_en : packG.name }}</span>
                        <!-- <span>{{ rate.symbol }} {{ packG.price | toRate(rate.value) }}</span> -->
                      </div>
                      <div class="uk-accordion-content uk-margin-remove">
                        <div class="" :class="packG.class">
                          <div class="isee-padding-xsmall isee-border">
                            <div style="padding: 8px">
                              <div class="uk-grid uk-flex-middle" uk-grid>
                                <div class="uk-width-expand">
                                  <div class="uk-text-bold isee-packs uk-text-small">
                                    <div v-if="lang === 'en'" v-html="packG.description_en"></div>
                                    <div v-else v-html="packG.description"></div>
                                  </div>
                                </div>
                                <div class="uk-width-auto">
                                  <div class="uk-text-bold uk-h4 uk-margin-remove">{{ rate.symbol }} {{ packG.price | toRate(rate.value) }}</div>
                                  <div class="uk-text-right">
                                    <span uk-icon="icon: question"></span>
                                  </div>
                                  <div class="" uk-drop="pos: bottom-right; offset: 0">
                                    <div class="uk-padding-small uk-card uk-card-default">
                                      <div class="uk-drop-grid">
                                        <div v-if="lang === 'en'" class="isee-h6 uk-text-justify" v-html="packG.help_en"></div>
                                        <div v-else class="isee-h6 uk-text-justify" v-html="packG.help"></div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                  </ul>

                </div>
              </div>
            </div>
          </div>
        </li>

        <li id="characteristics">
          <h3 class="uk-accordion-title accordion-title-blue" data-index="4.">CARACTERÍSTICAS ADICIONALES</h3>
          <div class="uk-accordion-content margin-remove@xs">
            <div>
              <div class="uk-container uk-container-small">
                <div class="">
                  <div class="uk-text-center uk-padding-small">
                    <div class="isee-h4 uk-text-bold">{{titles.seccion4}}</div>
                  </div>

                  <!-- Desktop -->
                  <div class="uk-visible@s">
                    <ul class="uk-flex uk-flex-center uk-subnav uk-subnav-pill uk-grid-small uk-grid-match" uk-grid uk-switcher>
                      <li v-for="(aditional, index) in selectedPack" class="uk-width-1-3@s uk-width-1-1">
                        <a href="#" class="" style="padding: 15px;">
                          <div class="uk-position-relative">
                            <label v-if="lang === 'en' " class="" style="width: 90%; float: left; text-align: center;">
                              <span class="isee-h4 uk-text-uppercase uk-text-bold">{{ aditional.name_en }}</span>
                            </label>
                            <label v-else class="" style="width: 90%; float: left; text-align: center;">
                              <span class="isee-h4 uk-text-uppercase uk-text-bold">{{ aditional.name }}</span>
                            </label>
                            <span v-if="aditional.description.length" class="uk-position-right uk-flex uk-flex-middle" uk-icon="icon: question" type="button" style="width: 20px; height: 20px; float: left; margin-top: 5px;"></span>
                            <div v-if="aditional.description.length" class="" uk-drop="pos: bottom-center">
                              <div class="uk-padding-small uk-card uk-card-default">
                                <div class="uk-drop-grid">
                                  <div v-if="lang === 'en'" class="uk-text-justify">
                                    <div class="isee-h6">{{ aditional.description_en }}</div>
                                  </div>
                                  <div v-else class="uk-text-justify">
                                    <div class="isee-h6">{{ aditional.description }}</div>
                                  </div>
                                  <p class="uk-text-center">
                                    <img :src="aditional.image" alt="">
                                  </p>
                                </div>
                              </div>
                            </div>
                          </div>
                        </a>
                      </li>
                    </ul>
                    <ul class="uk-switcher uk-margin-top">
                      <li class="uk-padding-small" v-for="aditional in selectedPack">
                        <div class="" v-for="option in aditional.options" >
                          <div class="uk-grid-small" v-if="option.price != '0.00'" uk-grid>
                            <div class="uk-width-1-3@s uk-width-1-1 isee-padding-xsmall isee-h5 uk-background-muted">
                              <div class="uk-position-relative">
                                <label v-if="lang === 'en'" style="cursor: pointer">
                                  <input v-model="opt" class="uk-radio" type="radio" :value="option"> {{ option.name_en }}
                                </label>
                                <label v-else style="cursor: pointer">
                                  <input v-model="opt" class="uk-radio" type="radio" :value="option"> {{ option.name }}
                                </label>
                                <span class="uk-position-right uk-flex uk-flex-middle" uk-icon="icon: question" type="button"></span>
                                <div class="" uk-drop="pos: bottom-center">
                                  <div class="uk-padding-small uk-card uk-card-default">
                                    <div class="uk-drop-grid">
                                      <div v-if="lang === 'en'" class="uk-text-justify isee-h6">{{ option.description_en }}</div>
                                      <div v-else class="uk-text-justify isee-h6">{{ option.description }}</div>
                                      <div class="uk-margin-small uk-text-center">
                                        <img :src="option.image" alt="">
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="uk-width-1-3@s uk-width-1-1 isee-padding-xsmall isee-h5 uk-text-center">
                              <div class="">
                                <div v-if="option.colors.length > 0" class="uk-flex uk-flex-middle" uk-grid>
                                  <div class="uk-width-1-3@s uk-width-1-1">
                                    <span class="uk-text-bold">Color:</span>
                                  </div>
                                  <div class="uk-width-2-3@s uk-width-1-1">
                                    <select v-if="opt == option" class="uk-select" name="" v-model="optcolor">
                                      <option selected disabled :value="{}">Seleccionar color</option>
                                      <option v-for="color in option.colors" :value="color">{{ color.name }}</option>
                                    </select>
                                    <select v-else class="uk-select" name="">
                                      <option selected disabled :value="{}">Seleccionar color</option>
                                      <option v-for="color in option.colors" :value="color">{{ color.name }}</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="uk-width-1-6@s uk-width-1-1 isee-padding-xsmall isee-h5 uk-flex uk-flex-middle">
                              {{titles.precioAdicional}}:
                            </div>
                            <div class="uk-width-1-6@s uk-width-1-1 isee-padding-xsmall isee-h5 uk-flex uk-flex-middle uk-background-muted uk-text-right uk-text-bold">
                              + {{ rate.symbol }} {{ option.price | toRate(rate.value) }}
                            </div>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>

                  <!-- Mobile -->
                  <div class="uk-hidden@s">

                    <div class="uk-flex uk-child-width-expand uk-text-uppercase uk-text-center uk-margin" uk-switcher>
                      <div v-for="(aditional, index) in selectedPack" class="tab uk-flex uk-flex-middle uk-flex-center">
                        <a class="uk-text-bold">{{ lang === 'en' ? aditional.name_en : aditional.name }}</a>
                      </div>
                    </div>

                    <!-- This is the container of the content items -->
                    <ul class="uk-switcher">
                      <li v-for="(aditional, index) in selectedPack">

                        <div v-if="aditional.description.length" class="uk-text-center uk-margin-small-bottom">
                          <span uk-icon="icon: question"></span>
                          <div class="" uk-drop="pos: bottom-center">
                            <div class="uk-padding-small uk-card uk-card-default">
                              <div class="uk-drop-grid">
                                <div v-if="lang === 'en'" class="uk-text-justify">
                                  <div class="isee-h6">{{ aditional.description_en }}</div>
                                </div>
                                <div v-else class="uk-text-justify">
                                  <div class="isee-h6">{{ aditional.description }}</div>
                                </div>
                                <p class="uk-text-center">
                                  <img :src="aditional.image" alt="">
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="uk-padding-small uk-margin-small-bottom" v-for="option in aditional.options" v-if="option.price != '0.00'">
                          <div class="isee-padding-xsmall isee-h5 drop-boundary">
                            <div class="uk-flex-middle uk-grid-small" uk-grid>
                              <div class="uk-width-expand">
                                <label class="uk-display-block" v-if="lang === 'en'" style="cursor: pointer; height: 30px; line-height: 30px; background-color: #eee; padding: 0 5px;">
                                  <input v-model="opt" class="uk-radio" type="radio" :value="option"> {{ option.name_en }}
                                </label>
                                <label class="uk-display-block" v-else style="cursor: pointer; height: 30px; line-height: 30px; background-color: #eee; padding: 0 5px;">
                                  <input v-model="opt" class="uk-radio" type="radio" :value="option"> {{ option.name }}
                                </label>
                              </div>
                              <div class="uk-width-auto">
                                <div v-if="option.colors.length > 0">
                                  <select v-if="opt == option" class="uk-select uk-form-small" style="width: 80px" name="" v-model="optcolor">
                                    <option selected disabled :value="{}">Color</option>
                                    <option v-for="color in option.colors" :value="color">{{ color.name }}</option>
                                  </select>
                                  <select v-else class="uk-select uk-form-small" style="width: 80px" name="">
                                    <option selected disabled :value="{}">Color</option>
                                    <option v-for="color in option.colors" :value="color">{{ color.name }}</option>
                                  </select>
                                </div>
                              </div>
                              <div class="uk-width-auto uk-text-right">
                                <div class="uk-inline">
                                  <span uk-icon="icon: question"></span>
                                  <div class="" uk-drop="boundary: .drop-boundary; pos: bottom-right">
                                    <div class="uk-padding-small uk-card uk-card-default">
                                      <div>
                                        <div v-if="lang === 'en'" class="uk-text-justify isee-h6">{{ option.description_en }}</div>
                                        <div v-else class="uk-text-justify isee-h6">{{ option.description }}</div>
                                        <div class="uk-margin-small uk-text-center">
                                          <img :src="option.image" alt="">
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="uk-text-right isee-padding-xsmall isee-h5 uk-text-bold uk-margin-small-top">
                            {{titles.precioAdicional}}: <br>
                            + {{ rate.symbol }} {{ option.price | toRate(rate.value) }}
                          </div>
                        </div>


                      </li>
                    </ul>

                  </div>

                </div>
              </div>
            </div>
          </div>
        </li>
      </ul>

    </div>

    <!-- GARANTÍA -->
    <div :class="{ 'hidden@xs': tab === 1 }" v-if="warranties.length" class="uk-section uk-section-xsmall">
      <div class="uk-container uk-container-small">
        <div class="">
          <div class="uk-text-center uk-padding-small">
            <p class="uk-h3 uk-text-bold">{{titles.seccion5}}</p>
          </div>
          <div v-for="warranty in warranties" class="uk-grid-match" uk-grid>
            <div class="uk-width-5-6@s uk-width-1-1">
              <div class="isee-padding-small">
                <div class="">
                  <input :id="warranty.slug" v-model="warr" type="checkbox" class="uk-checkbox" :value="warranty">
                  <label v-if="lang === 'en'" :for="warranty.slug" style="cursor: pointer">
                    <span class="uk-text-bold isee-h5 uk-padding-small uk-text-uppercase"> {{ warranty.time }} {{ warranty.period_en }} {{titles.garantia}}</span>
                    <span class="" uk-icon="icon: question" type="button" style="width: 20px; height: 20px;"></span>
                    <div class="" uk-drop="pos: right">
                      <div class="uk-padding uk-card uk-card-default">
                        <div class="uk-drop-grid">
                          <div v-if="lang === 'en'" class="uk-text-center">
                            <div class="isee-h4 uk-text-bold">{{ warranty.help_en }}</div>
                          </div>
                          <div v-else class="uk-text-center">
                            <div class="isee-h4 uk-text-bold">{{ warranty.help }}</div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <br>
                    <span class="isee-h6 isee-padding-large">{{ warranty.description_en }}</span>
                  </label>
                  <label v-else :for="warranty.slug" style="cursor: pointer">
                    <span class="uk-text-bold isee-h5 uk-padding-small uk-text-uppercase">GARANTÍA DE {{ warranty.time }} {{ warranty.period }}</span>
                    <span class="" uk-icon="icon: question" type="button" style="width: 20px; height: 20px;"></span>
                    <div class="" uk-drop="pos: right">
                      <div class="uk-padding uk-card uk-card-default">
                        <div class="uk-drop-grid">
                          <div v-if="lang === 'en'" class="uk-text-center">
                            <div class="isee-h4 uk-text-bold">{{ warranty.help_en }}</div>
                          </div>
                          <div v-else class="uk-text-center">
                            <div class="isee-h4 uk-text-bold">{{ warranty.help }}</div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <br>
                    <span class="isee-h6 isee-padding-large">{{ warranty.description }}</span>
                  </label>
                </div>
              </div>
            </div>
            <div class="uk-width-1-6@s uk-width-1-1">
              <div class="isee-h4 uk-text-bold uk-text-right">
                + {{ rate.symbol }} {{ warranty.price | toRate(rate.value) }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="modal-detalles" uk-modal>
      <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">Agregar al carrito</h2>

        <dl class="uk-description-list">
          <dt>Producto</dt>
          <dd>{{ lang === 'es' ? product.name : product.name_en }}</dd>
          <dt>Color</dt>
          <dd>{{ lang === 'es' ? prod.color.name : prod.color.name_en }}</dd>
          <dt>Talla</dt>
          <dd>{{ lang === 'es' ? prod.size.name : prod.size.name_en }}</dd>
          <dt>Tipo</dt>
          <dd>{{ lang === 'es' ? type.name : type.name_en }}</dd>
          <dt>Paquete:</dt>
          <dd>{{ lang === 'es' ? pack.name : pack.name_en }}</dd>
          <template v-if="opt.name">
            <dt>Extra:</dt>
            <dd>{{ lang === 'es' ? opt.name : opt.name_en }} {{ lang === 'es' ? optcolor.name : optcolor.name_en }}</dd>
          </template>
        </dl>

        <p class="uk-text-right">
          <button class="uk-button uk-button-default uk-modal-close" type="button">Cancelar</button>
          <button @click="confirmed = true; sendAjaxToCart()" class="uk-button uk-button-secondary" type="button">Continuar</button>
        </p>
      </div>
    </div>

    <!-- Total -->
    <div>
      <div class="uk-section uk-section-xsmall">
        <div class="uk-container uk-container-small">
          <div class="uk-text-right">
            <p class="isee-h3">Total: <span class="uk-text-bold">{{ rate.symbol }} {{ totalPrice | toRate(rate.value) }}</span></p>
          </div>
        </div>
      </div>
      <div  class="uk-section uk-section-xsmall">
        <div v-if="stock > 0" class="">
          <div class="uk-text-center">
            <div v-if="user !== 0" class="">
              <div v-if="user.client" class="">
                <form class="" @submit.prevent="sendAjaxToCart">
                  <div class="">
                    <button class="uk-button uk-button-large uk-text-bold isee-background-green isee-h5 uk-light">{{titles.btnAgregar}}</button>
                  </div>
                </form>
              </div>
            </div>
            <div v-else class="">
              <a class="uk-button uk-button-large uk-text-bold isee-background-green isee-h5 uk-light" href="#modal-login" uk-toggle>{{titles.btnAgregar}}</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <GlassTester :visible.sync="showModalTester" :product="product.slug" style="z-index: 9999"/>

  </section>
</template>

<script>
import GlassTest from './GlassTest'
import convertRate from '../helpers/convertRate'
import moment from 'moment'
Vue.prototype.moment = moment
const $ = window.$

export default {
  props: ['product', 'rates', 'types', 'user', 'warranties', 'rateslug', 'titles', 'login', 'lang'],
  data () {
    return {
      showModalTester: false,
      tab: 1,
      prescTab: 1,
      confirmed: false,
      solar: false,
      contacto: false,
      selectedImage: 0,
      showTester: false,
      prod: {
        color: '',
        size: ''
      },
      type: {},
      pack: {},
      opt: {},
      optcolor: {},
      presc: {
        name: '',
        file: '',
        filename: '',
        esfod: 0,
        esfoi: 0,
        esfdip: 0,
        dip: 0,
        cilod: 0,
        ciloi: 0,
        axiod: 0,
        axioi: 0,
        addod: 0,
        addoi: 0,
        desc: ''
      },
      pres: {
        esfod: 0,
        esfoi: 0,
        cilod: 0,
        ciloi: 0
      },
      prescripts: {},
      warr: [],
      usr: {
        cid: '',
        email: '',
        password: ''
      },
      rate: {},
      info: {
        total_price: 0
      },
      sending: false,
      error: false
    }
  },
  watch: {
    presc: {
      handler (obj) {
        Object.keys(obj).forEach(k => {
          this.pres[k] = Math.abs(obj[k])
        })
      },
      deep: true
    }
  },
  filters: {
    toRate (amount, value) {
      return convertRate(amount, value)
    },
    currency (amount) {
      amount = amount.toFixed(2)
      if (amount > 0) {
        amount = '+' + amount
      }
      return amount
    }
  },
  methods: {
    onFileChange (event) {
      var input = event.target
      if (input.files && input.files[0]) {
        var reader = new FileReader()
        reader.fileName = input.files[0].name
        reader.onload = (e) => {
          this.presc.file = e.target.result
          this.presc.filename = e.target.fileName
        }
        reader.readAsDataURL(input.files[0])
      }
      // this.presc.file = input.files[0].name
    },
    clear (event) {
      this.presc.file = ''
      this.presc.filename = ''
      $('.isee-upload-file').val('')
    },
    async mobileValidation () {
      try {
        if (this.presc.file || this.presc.id) {
          if (this.confirmed) return true
          UIkit.modal('#modal-detalles').show()
          return false
        } else {
          if (this.tab === 1) {
            this.tab = 2
            await this.$nextTick()
          }
          await UIkit.accordion(this.$refs.accordion).toggle(1)
          UIkit.scroll($('<a></a>'), { offset: 160 }).scrollTo('#prescription')
          UIkit.notification({
            message: 'Guarde su prescripción o suba su receta',
            status: 'danger',
            pos: 'bottom-center',
            timeout: 3000
          })
          return false
        }
      } catch (e) {
        console.log(e)
        return false
      }
    },
    async sendAjaxToCart () {
      // if (window.innerWidth < 600 && !this.solar) {
      //   if (!await this.mobileValidation()) return
      // }
      var pack_name = this.pack.name
      if (this.lang == 'en') {
        pack_name = this.pack.name_en
      }
      // if (this.presc.id || !this.prescVisible) {
      if (this.opt.id && this.opt.colors.length) {
        if (this.optcolor.id) {
          $.post('/'+this.lang+'/cart', {
            id: this.product.id,
            slug: this.product.slug,
            name: this.product.name,
            name_en: this.product.name_en,
            code: this.product.code,
            image: this.filteredPhotos[0].url,
            qty: 1,
            size_attr: this.prod.size.attribute_id,
            color_attr: this.prod.color.attribute_id,
            size: this.prod.size.attribute_product_id,
            color: this.prod.color.attribute_product_id,
            sizecolor_id: this.prod.color.sizecolor_id,
            code_color: this.prod.color.lab_codecolor,
            // prod_price: this.product.promo ? this.product.promo : this.product.price,
            prod_price: (this.user.client && this.user.client.ally && this.product.promo) ? this.product.promo : this.product.price, // Si es aliado no toma el valor de promocion
            type_id: this.type.id,
            pack_id: this.pack.pack_id,
            type_pack_id: this.pack.id,
            pack_price: this.pack.price,
            pack_name: pack_name,
            option_id: this.opt.option_id,
            prescription_id: this.presc.id,
            option_price: this.opt.price,
            optcolor_id: this.optcolor.id,
            warranty_id: this.warr[0] ? this.warr[0].id : null,
            warranty_price: this.warr[0] ? this.warr[0].price : null,
            price: this.totalPrice

          }).done(response => {
            if (response.success) {
              $(location).attr('href', '/'+this.lang+'/cart')
            } else {
              UIkit.notification({
                message: 'Ya se encuentra en carrito',
                status: 'danger',
                pos: 'bottom-center',
                timeout: 3000
              })
            }
          }).fail(err => {

          })
          .always(() => {

          })
        } else {
          UIkit.scroll($('<a></a>'), { offset: 80 }).scrollTo('#characteristics');
          UIkit.notification({
            message: 'Seleccione color a la característica',
            status: 'danger',
            pos: 'bottom-center',
            timeout: 3000
          });
        }
      }else {
        $.post('/'+this.lang+'/cart', {
          id: this.product.id,
          slug: this.product.slug,
          name: this.product.name,
          name_en: this.product.name_en,
          code: this.product.code,
          image: this.filteredPhotos[0].url,
          qty: 1,
          size_attr: this.prod.size.attribute_id,
          color_attr: this.prod.color.attribute_id,
          code_color: this.prod.color.lab_codecolor,
          size: this.prod.size.attribute_product_id,
          color: this.prod.color.attribute_product_id,
          sizecolor_id: this.prod.color.sizecolor_id,
          // prod_price: this.product.promo ? this.product.promo : this.product.price,
          prod_price: (this.user.client && this.user.client.ally && this.product.promo) ? this.product.promo : this.product.price, // Si es aliado no toma el valor de promocion
          // prod_price: this.product.price,
          type_id: this.type.id,
          pack_id: this.pack.pack_id,
          type_pack_id: this.pack.id,
          pack_price: this.pack.price,
          pack_name: pack_name,
          option_id: this.opt.option_id,
          prescription_id: this.presc.id,
          option_price: this.opt.price,
          optcolor_id: this.optcolor.id,
          warranty_id: this.warr[0] ? this.warr[0].id : null,
          warranty_price: this.warr[0] ? this.warr[0].price : null,
          price: this.totalPrice

        })
        .done(response => {
          if (response.success) {
            $(location).attr('href', '/'+this.lang+'/cart')
          }else {
            UIkit.notification({
              message: 'Ya se encuentra en carrito',
              status: 'danger',
              pos: 'bottom-center',
              timeout: 3000
            });
          }
        })
        .fail(err => {

        })
        .always(() => {

        })
      }
      // } else {
      //   UIkit.accordion(this.$refs.accordion).toggle(1)
      //   UIkit.scroll($('<a></a>'), { offset: 80 }).scrollTo('#prescription');
      //   UIkit.notification({
      //     message: 'Guarde su prescripción o suba su receta',
      //     status: 'danger',
      //     pos: 'bottom-center',
      //     timeout: 3000
      //   });
      // }
    },
    validatePrescription () {
      var cont = 0;
      if (this.presc.addod != 0) { cont++ }
      if (this.presc.addoi != 0) { cont++ }
      if (this.presc.axiod != 0) { cont++ }
      if (this.presc.axioi != 0) { cont++ }
      if (this.presc.cilod != 0) { cont++ }
      if (this.presc.ciloi != 0) { cont++ }
      // if (this.presc.esfdip != 0) { cont++ } //esfdip tiene un valor por default, no se considera
      if (this.presc.esfod != 0) { cont++ }
      if (this.presc.esfoi != 0) { cont++ }

      //Si tiene solo archivo
      if (this.presc.file && !cont > 0) {
        this.presc.name = 'isee-archivo-'
        return true;
        //Si no tiene ni medidas ni archivo
      }else if (! (cont > 0 || this.presc.file) ) {
        UIkit.notification({
          message: 'Ingrese medidas a su prescripción o suba un archivo',
          status: 'danger',
          pos: 'bottom-center',
          timeout: 5000
        })
        return false;
      }else {
        return true;
      }
    },
    submitForm () {
      var url = ''
      this.sending = true
      if ( this.validatePrescription() ) {
        if (this.presc.id > 0) {
          $.ajax({
            method: 'PUT',
            url: '/prescriptions/'+this.presc.id,
            data: {
              pres: this.presc,
              cli: this.usr
            },
            success: function (response) {
              if (response.success) {
                if (response.prescription.name.substr(0,12) == 'isee-archivo') {
                  // remover de la lista de medidas guardadas
                }
                UIkit.notification({
                  message: '<i uk-icon="icon: check"></i> Receta editada',
                  status: 'primary',
                  pos: 'bottom-center',
                  timeout: 5000
                })
              }
            },
            error: function (response) {
              UIkit.notification({
                message: '<i uk-icon="icon: check"></i> Seleccionar imagen',
                status: 'danger',
                pos: 'bottom-center',
                timeout: 5000
              })
            }
          });
        }else {
          $.post('/prescriptions', {pres: this.presc, cli: this.usr})
          .done(response => {
            if (response.success) {
              this.presc.id = response.prescription.id
              this.presc.name = response.prescription.name
              if (response.prescription.name.substr(0,12) != 'isee-archivo') {
                this.prescripts.push(response.prescription)
              }
              UIkit.notification({
                message: '<i uk-icon="icon: check"></i> Receta creada',
                status: 'primary',
                pos: 'bottom-center',
                timeout: 5000
              })
            }
          })
          .fail(err => {
            UIkit.notification({
              message: '<i uk-icon="icon: check"></i> Error',
              status: 'danger',
              pos: 'bottom-center',
              timeout: 5000
            })
          })
          .always(() => {
            this.sending = false
          })
        }
      }
    }
  },
  computed: {
    prescVisible () {
      if ((this.type.slug !== 'sin-medida') && !this.solar) {
        return true
      } else {
        return false
      }
    },
    totalPrice () {
      var warr = this.warr[0] ? this.warr[0].price : 0
      var opt = this.opt.price ? this.opt.price : 0
      var pric = this.pack.price ? this.pack.price : 0
      // if (this.product.promo) {
      //   this.info.total_price = parseFloat(this.product.promo) + parseFloat(pric) + parseFloat(opt) + parseFloat(warr)
      // }else {
      //   this.info.total_price = parseFloat(this.product.price) + parseFloat(pric) + parseFloat(opt) + parseFloat(warr)
      // }
      var productPrice = (this.user.client && this.user.client.ally && this.product.promo) ? this.product.promo : this.product.price
      this.info.total_price = parseFloat(productPrice) + parseFloat(pric) + parseFloat(opt) + parseFloat(warr)
      return this.info.total_price
    },
    colors () {
      var allColors = this.product.characteristics.find(c => (c.slug == 'color')).attributes
      var sizeColors = this.sizes.find(s => (s.attribute_product_id == this.prod.size.attribute_product_id)).colors
      var sizeColors = sizeColors.map(c => (allColors.find(a => (a.attribute_product_id == c.color_id))))
      sizeColors = sizeColors.map(sc => {
        sc.sizecolor_id = this.sizes.find(s => (this.prod.size.attribute_product_id == s.attribute_product_id)).colors.find(c => (c.color_id == sc.attribute_product_id)).id
        return sc
      })
      this.prod.color = sizeColors[0]
      return sizeColors
    },
    sizes () {
      var sizes = []
      var attributes = this.product.characteristics.find(c => (c.slug == 'tamanio')).attributes
      attributes = attributes.map(a => {
        if (a.colors.length > 0) {
          sizes.push(a)
        }
      })
      return sizes
    },
    typs () {
      var types = this.types
      if (this.solar) {
        types = this.types.filter(t => (t.slug == 'sin-medida'))
      }
      return types
    },
    filteredPhotos () {
      return this.colors.find(c => (c == this.prod.color)).images
    },
    selectedType () {
      this.presc.esfdip = 59
      this.presc.dip = 59
      if (this.type.slug == 'de-distancia') {
        this.presc.esfdip = 63
        this.presc.dip = 63
      }
      var filtered = this.typs.find(t => (t == this.type)).packs
      var firstPack
      var count = 0
      var esf = 0
      var cil = 0
      if (this.pres.esfod > this.pres.esfoi) {
        esf = this.presc.esfod
      } else {
        esf = this.presc.esfoi
      }
      if (this.pres.cilod > this.pres.ciloi) {
        cil = this.presc.cilod
      } else {
        cil = this.presc.ciloi
      }
      filtered = filtered.map(p => {
        var flag = ((p.esfmin <= esf && esf <= p.esfmax) && (p.cilmin <= cil && cil <= p.cilmax))
        if (count == 0 && flag) {
          firstPack = p
          count = count+1
        }
        p.class = flag ? 'isee-pack-active' : 'isee-pack-inactive'
        return p
      })
      if (firstPack) {
        this.pack = firstPack
      }else {
        this.pack = {}
      }
      return filtered
    },
    selectedPack () {
      this.opt = {}
      return this.pack.aditionals
    },
    selectedOption () {
      this.optcolor = {}
      return this.opt.colors
    },
    filteredCameras () {
      return this.colors.find(c => (c.attribute_product_id == this.prod.color.attribute_product_id)).cameras
    },
    stock (){
      return this.prod.size.colors.find(c => (c.color_id == this.prod.color.attribute_product_id)).stock
    }
  },
  created () {
    moment.locale(this.lang)
    this.prescripts = this.user.client ? this.user.client.prescriptions : ''
    this.prod.size = this.sizes[0]
    this.prod.color = this.sizes[0].colors[0]
    this.usr.cid = this.user.client ? this.user.client.id : false
    // Si es solar, seleccionar 'sin-medida'
    var attr = this.product.characteristics.find(c => (c.slug == 'uso')).attributes
    // console.log(attr[0].slug)
    if (attr[0].slug !== 'solares') {
      if (attr[0].slug == 'lentes-de-contacto') {
        this.contacto = true
      }
      this.solar = false
      this.type = this.types[0]
      this.pack = this.types[0].packs[0]
    } else {
      this.solar = true
      this.type = this.types[4]
      this.pack = this.types[4].packs[0]
    }

    // Tipo de cambio
    if (!this.rateslug) {
      this.rate = this.rates.find(r => (r.slug == 'soles'))
      var rat = ''
      // $.getJSON('http://api.wipmania.com/jsonp?callback=?')
      $.getJSON('https://ipapi.co/json/')
      .done( (data) => {
        if (data.country == 'PE') {
          rat = 'soles'
        }else{
          rat = 'dolares'
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
  },
  components:{ GlassTest }
}

</script>

<style lang="scss">
  .selected-color {
    border: 2.5px solid #003d5d;
  }

  .unselected-color {
    border: 2.5px solid transparent;
  }

  .selected, .pack-selected {
    background-color: #a6dd2c;
    color: white;
  }

  .pack-unselected {
    background-color: white;
  }

  .isee-pack-inactive {
    pointer-events: none;
  }

  .isee-pack-inactive > label > div {
    background-color: #e7e4e5;
    color: black;
  }

  .unselected {
    background-color: #e7e4e5;
  }

  .uk-subnav-pill > .uk-active > a {
    background-color: #a6dd2c;
  }

  .uk-subnav-pill > * > :first-child {
    background-color: #e7e4e5;
    color: #003d5d
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
  	border-top: 2px solid;
  	border-color: #003d5d;

    -webkit-transform:rotate(-10deg);
    -moz-transform:rotate(-10deg);
    -ms-transform:rotate(-10deg);
    -o-transform:rotate(-10deg);
    transform:rotate(-10deg);
  }

  @media (max-width: 600px) {
    .isee-packs .uk-list > li {
      margin: 2px 0 !important;
    }
  }

  @import './product/styles.scss';
</style>
