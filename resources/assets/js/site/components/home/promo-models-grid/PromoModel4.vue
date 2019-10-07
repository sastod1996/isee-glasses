<template>
  <div class="grid cols-3-4-3">
    <PromoTile v-bind="items[0]" :width="360" :height="300"/>
    <PromoTile v-bind="items[1]" :width="480" :height="300"/>
    <PromoTile v-bind="items[2]" :width="360" :height="300"/>
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
.cols-3-4-3 {
  grid-template-columns: 3fr 4fr 3fr;
}
</style>
