<template>
  <div class="uk-grid-medium uk-flex-middle" uk-grid>
    <div class="uk-width-2-5@s" uk-margin="margin: uk-margin-top">
      <PromoTile v-bind="items[0]" :width="480" :height="400"/>
      <PromoTile v-bind="items[1]" :width="480" :height="200"/>
    </div>
    <div class="uk-width-3-5@s">
      <div class="uk-grid-medium uk-child-width-1-2@s" uk-grid>
        <div uk-margin="margin: uk-margin-top">
          <PromoTile v-bind="items[2]" :width="360" :height="300"/>
          <PromoTile v-bind="items[3]" :width="360" :height="300"/>
        </div>
        <div uk-margin="margin: uk-margin-top">
          <PromoTile v-bind="items[4]" :width="360" :height="400"/>
          <PromoTile v-bind="items[5]" :width="360" :height="200"/>
        </div>
      </div>
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
