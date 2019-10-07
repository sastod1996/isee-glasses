<template>
  <div class="grid cols-7-3">
    <div class="grid rows-1-1">
      <PromoTile v-bind="items[0]" :width="840" :height="300"/>
      <div class="grid cols-2-3">
        <PromoTile v-bind="items[1]" :width="328" :height="300"/>
        <PromoTile v-bind="items[2]" :width="492" :height="300"/>
      </div>
    </div>
    <div class="grid rows-1-2">
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
.cols-7-3 {
  grid-template-columns: 7fr 3fr;
}

.cols-2-3 {
  grid-template-columns: 2fr 3fr;
}

.rows-1-2 {
  grid-template-rows: 1fr 2fr;
}

.rows-1-1 {
  grid-template-rows: 1fr 1fr;
}
</style>
