<template>
  <div class="uk-child-width-1-3@s uk-grid-medium uk-flex-middle" uk-grid>
    <div uk-margin="margin: uk-margin-top">
      <PromoTile v-bind="items[0]" :width="400" :height="300"/>
      <PromoTile v-bind="items[1]" :width="400" :height="300"/>
    </div>
    <div>
      <PromoTile v-bind="items[2]" :width="400" :height="620"/>
    </div>
    <div uk-margin="margin: uk-margin-top">
      <PromoTile v-bind="items[3]" :width="400" :height="400"/>
      <PromoTile v-bind="items[4]" :width="400" :height="200"/>
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
