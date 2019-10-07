<template>
  <div class="uk-grid-medium uk-flex-middle uk-child-width-1-4@s" uk-grid>
    <div class="uk-width-1-2@s">
      <PromoTile v-bind="items[0]" @change="$emit('change', $event, 0)" :width="600" :height="300"/>
    </div>
    <div>
      <PromoTile v-bind="items[1]" @change="$emit('change', $event, 1)" :width="300" :height="300"/>
    </div>
    <div>
      <PromoTile v-bind="items[2]" @change="$emit('change', $event, 2)" :width="300" :height="300"/>
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
