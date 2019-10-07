<template>
  <div class="shop uk-section">
    <div class="uk-container uk-container-large">
      <div class="uk-grid-small" uk-grid>

        <div id="filters" class="uk-width-1-3@l uk-width-2-5@m">
          <div class="uk-padding uk-padding-remove-vertical">
            <div class="uk-card uk-background-muted">
              <div class="uk-hidden@m">
                <div class="uk-padding-remove-vertical uk-card-header isee-background-green uk-light uk-text-center">
                  <h3 class="uk-card-title uk-text-uppercase uk-text-bold">
                    Características
                  </h3>
                </div>
              </div>
              <div class="uk-visible@m">
                <div class="uk-card-header isee-background-green uk-light uk-text-center">
                  <h3 class="uk-card-title uk-text-uppercase uk-text-bold">
                    Características
                  </h3>
                </div>
              </div>
              <div class="uk-card-body uk-padding-small">
                <filters v-model="filters" :resources="resources" :loading="loading" />
              </div>
            </div>
          </div>
        </div>

        <div id="shop" class="uk-width-expand">
          <div class="uk-flex uk-flex-column">
            <div v-for="i in 2" :key="i" class="uk-grid-small uk-flex-wrap uk-flex-center uk-margin" uk-grid :class="{ 'uk-flex-last': i === 2 }">
              <div class="uk-width-1-4@m uk-width-small">
                <sort v-model="order" :loading="loading" :opts="orderOpts" />
              </div>
              <div class="uk-width-auto@s uk-text-center">
                <div :class="{ 'uk-invisible': !loading }">
                  <span uk-spinner></span>
                </div>
              </div>
              <div v-if="i == 1" id="pagination" class="uk-width-expand@m uk-width-medium">
                <pagination v-model="page" :pages="pages" :loading="loading" />
              </div>
              <div v-else class="uk-width-expand@m uk-width-medium">
                <pagination v-model="page" :pages="pages" :loading="loading" />
              </div>
            </div>
            <product-list v-on:saveFilters="saveOpts" v-model="pages" :products="products" :loading="loading" :rates="rates" :rat="rate"/>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
  import Filters from './Filters'
  import Sort from './Sort'
  import Pagination from './Pagination'
  import ProductList from './ProductList'
  const $ = window.$
  const state = window.state

  const orderOpts = [
    { value: ['qty', 'asc'], text: 'Ordenar por' },
    { value: ['name', 'asc'], text: 'Nombre A-Z' },
    { value: ['name', 'desc'], text: 'Nombre Z-A' },
    { value: ['price', 'asc'], text: 'Precio más bajo' },
    { value: ['price', 'desc'], text: 'Precio más alto' }
  ]
  var shopfilters
  if (localStorage.getItem('shop-filters') == undefined) {
    shopfilters = { attributes: [], categories: [] }
  }else{
    shopfilters = JSON.parse(localStorage.getItem('shop-filters'))
  }
  if (state.query.attrs) {
    shopfilters.attributes = shopfilters.attributes.concat( state.query.attrs )
  }
  if (state.query.cats) {
    shopfilters.categories = shopfilters.categories.concat( state.query.cats )
  }

  export default {
    props: [ 'rateslug', 'rates'],
    data () {
      return {
        orderOpts,
        pages: 0,
        loading: false,
        products: [],
        resources: {
          categories: [],
          characteristics: []
        },
        resourcesLoaded: false,
        // Options
        page: shopfilters.page || 1,
        order: shopfilters.order || orderOpts[0].value,
        filters: {
          attributes: shopfilters.attributes || [],
          categories: shopfilters.categories ||[]
        },
        rate: {}
      }
    },
    computed: {
      opts () {
        return {
          per_page: 15,
          page: this.page,
          order: this.order[0],
          dir: this.order[1],
          attrs: this.filters.attributes.join(','),
          cats: this.filters.categories.join(',')
        }
      }
    },
    watch: {
      filters: {
        deep: true,
        handler () {
          this.page = 1
        }
      },
      opts: 'fetchProducts'
    },
    methods: {
      fetchProducts () {
        if (this.loading) return
        this.loading = true
        $.get('/api/shop', this.opts)
          .done(res => {
            this.products = res.data
            this.pages = res.last_page
          })
          .fail(err => {
            console.error(err)
          })
          .always(() => {
            this.loading = false
          })
      },
      fetchResources () {
        $.get('/api/shop-data/')
          .done(res => { this.resources = res })
          .fail(err => { console.error(err) })
      },
      saveOpts (){
        var filts = this.filters
        filts.page = this.page
        filts.order = this.order
        localStorage.setItem('shop-filters', JSON.stringify(filts));
      }
    },
    created () {
      this.fetchResources()
      this.fetchProducts()
    },
    mounted() {
      if (!this.rateslug) {
        this.rate = this.rates.find(r => (r.slug == 'soles')) //06112017 lplp
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
    components: {
      Sort,
      Filters,
      Pagination,
      ProductList
    }
  }
</script>
