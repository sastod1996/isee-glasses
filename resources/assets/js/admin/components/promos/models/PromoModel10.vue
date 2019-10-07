<template>
  <PromoTile v-bind="items[0]" @change="$emit('change', $event, 0)" :width="1200" :height="300"/>
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
