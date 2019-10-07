<template>
  <div class="grid cols-1-1-1">
    <div class="grid rows-1-1">
      <PromoTile v-bind="items[0]" :width="400" :height="300"/>
      <PromoTile v-bind="items[1]" :width="400" :height="300"/>
    </div>
    <div class="grid">
      <PromoTile v-bind="items[2]" :width="400" :height="620"/>
    </div>
    <div class="grid rows-2-1">
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

<style lang="scss" scoped>
.cols-1-1-1 {
  grid-template-columns: 1fr 1fr 1fr;
}

.rows-2-1 {
  grid-template-rows: 2fr 1fr;
}

.rows-1-1 {
  grid-template-rows: 1fr 1fr;
}
</style>
