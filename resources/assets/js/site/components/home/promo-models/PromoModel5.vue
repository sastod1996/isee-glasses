<template>
  <div class="uk-grid-medium uk-flex-middle" uk-grid>
    <div class="uk-width-3-5@s">
      <PromoTile v-bind="items[0]" :width="720" :height="300"/>
    </div>
    <div class="uk-width-2-5@s">
      <PromoTile v-bind="items[1]" :width="480" :height="300"/>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    items: {
      type: Array,
      required: true
    }
  }
}
</script>
