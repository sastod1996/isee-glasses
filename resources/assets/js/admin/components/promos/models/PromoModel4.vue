<template>
  <div class="uk-grid-medium uk-flex-middle" uk-grid>
    <div class="uk-width-3-10@s">
      <PromoTile v-bind="items[0]" @change="$emit('change', $event, 0)" :width="360" :height="300"/>
    </div>
    <div class="uk-width-expand@s">
      <PromoTile v-bind="items[1]" @change="$emit('change', $event, 1)" :width="480" :height="300"/>
    </div>
    <div class="uk-width-3-10@s">
      <PromoTile v-bind="items[2]" @change="$emit('change', $event, 2)" :width="360" :height="300"/>
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
    width: 30%;
  }
}
</style>
