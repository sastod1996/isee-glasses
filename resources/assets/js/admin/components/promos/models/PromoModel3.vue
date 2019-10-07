<template>
  <div class="uk-grid-medium uk-flex-middle" uk-grid>
    <div class="uk-width-expand@s">
      <PromoTile v-bind="items[0]" @change="$emit('change', $event, 0)"  :width="840" :height="300"/>
      <div class="uk-grid-medium uk-margin-top" uk-grid>
        <div class="uk-width-2-5@s">
          <PromoTile v-bind="items[1]" @change="$emit('change', $event, 1)"  :width="328" :height="300"/>
        </div>
        <div class="uk-width-3-5@s">
          <PromoTile v-bind="items[2]" @change="$emit('change', $event, 2)"  :width="492" :height="300"/>
        </div>
      </div>
    </div>
    <div class="uk-width-3-10@s">
      <PromoTile v-bind="items[3]" @change="$emit('change', $event, 3)"  :width="360" :height="200"/>
      <PromoTile v-bind="items[4]" @change="$emit('change', $event, 4)"  :width="360" :height="400" class="uk-margin-top"/>
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
@media (min-width: 640px) {
  .uk-width-3-10\@s {
    width: calc(30% + 8px);
  }
}
</style>
