<template>
  <div class="grid cols-2-1-1">
    <PromoTile v-bind="items[0]" :width="600" :height="300"/>
    <PromoTile v-bind="items[1]" :width="300" :height="300"/>
    <PromoTile v-bind="items[2]" :width="300" :height="300"/>
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
.cols-2-1-1 {
  grid-template-columns: 2fr 1fr 1fr;
}
</style>
