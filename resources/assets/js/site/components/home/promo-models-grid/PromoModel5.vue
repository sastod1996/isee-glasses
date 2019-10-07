<template>
  <div class="grid cols-3-2">
    <PromoTile v-bind="items[0]" :width="720" :height="300"/>
    <PromoTile v-bind="items[1]" :width="480" :height="300"/>
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
.cols-3-2 {
  grid-template-columns: 3fr 2fr;
}
</style>
