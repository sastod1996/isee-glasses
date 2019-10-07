<template>
  <div class="grid cols-1-1-1">
    <PromoTile v-bind="items[0]" :width="400" :height="300"/>
    <PromoTile v-bind="items[1]" :width="400" :height="300"/>
    <PromoTile v-bind="items[2]" :width="400" :height="300"/>
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
.cols-1-1-1 {
  grid-template-columns: 1fr 1fr 1fr;
}
</style>
