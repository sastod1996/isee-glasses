<template>
  <div class="grid">
    <PromoTile v-bind="items[0]" :width="1200" :height="300"/>
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
