<template>
  <div class="uk-grid-medium uk-flex-middle" uk-grid>
    <div class="uk-width-expand@s" uk-margin="margin: uk-margin-top">
      <PromoTile v-bind="items[0]" :width="840" :height="300"/>
      <div class="uk-grid-medium" uk-grid>
        <div class="uk-width-2-5@s">
          <PromoTile v-bind="items[1]" :width="328" :height="300"/>
        </div>
        <div class="uk-width-3-5@s">
          <PromoTile v-bind="items[2]" :width="492" :height="300"/>
        </div>
      </div>
    </div>
    <div class="uk-width-3-10@s" uk-margin="margin: uk-margin-top">
      <PromoTile v-bind="items[3]" :width="360" :height="200"/>
      <PromoTile v-bind="items[4]" :width="360" :height="400"/>
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

<style lang="scss" scoped>
@media (min-width: 640px) {
  .uk-width-3-10\@s {
    width: calc(30% + 8px);
  }
}
</style>
