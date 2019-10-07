<template>
  <div id="productList" class="">
    <div v-if="products && products.length" class="uk-margin">
      <div class="uk-child-width-1-3@l uk-child-width-1-2@s uk-child-width-1-1 uk-grid-small uk-grid-match" uk-grid>
        <div v-for="product in products" :key="product.id">
          <product-item v-on:saveFilters="saveFilters" :product="product" :rates="rates" :rate="rat" />
        </div>
      </div>
    </div>
    <div v-else class="uk-section uk-background-muted uk-text-center">
      <h3 v-if="loading">Cargando...</h3>
      <h3 v-else>No se encontraron resultados</h3>
    </div>
  </div>
</template>

<script>
import ProductItem from './ProductItem'

export default {
  props: ['products', 'loading', 'rates', 'rat' ],
  components: { ProductItem },
  methods: {
    saveFilters (){
      this.$emit('saveFilters')
    }
  }

}
</script>
