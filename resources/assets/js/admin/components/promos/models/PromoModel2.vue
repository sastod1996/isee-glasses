<template>
  <div class="uk-child-width-1-3@s uk-grid-medium uk-flex-middle" uk-grid>
    <div>
      <PromoTile v-bind="items[0]" @change="$emit('change', $event, 0)" :width="400" :height="300"/>
      <PromoTile v-bind="items[1]" @change="$emit('change', $event, 1)" :width="400" :height="300" class="uk-margin-top"/>
    </div>
    <div>
      <PromoTile v-bind="items[2]" @change="$emit('change', $event, 2)" :width="400" :height="620"/>
    </div>
    <div>
      <PromoTile v-bind="items[3]" @change="$emit('change', $event, 3)" :width="400" :height="400"/>
      <PromoTile v-bind="items[4]" @change="$emit('change', $event, 4)" :width="400" :height="200" class="uk-margin-top"/>
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
