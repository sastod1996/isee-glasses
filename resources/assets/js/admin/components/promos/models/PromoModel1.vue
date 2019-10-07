<template>
  <div class="uk-grid-medium uk-flex-middle" uk-grid>
    <div class="uk-width-2-5@s">
      <PromoTile v-bind="items[0]" @change="$emit('change', $event, 0)" :width="480" :height="400"/>
      <PromoTile v-bind="items[1]" @change="$emit('change', $event, 1)" :width="480" :height="200" class="uk-margin-top"/>
    </div>
    <div class="uk-width-3-5@s">
      <div class="uk-grid-medium uk-child-width-1-2@s" uk-grid>
        <div>
          <PromoTile v-bind="items[2]" @change="$emit('change', $event, 2)" :width="360" :height="300"/>
          <PromoTile v-bind="items[3]" @change="$emit('change', $event, 3)" :width="360" :height="300" class="uk-margin-top"/>
        </div>
        <div>
          <PromoTile v-bind="items[4]" @change="$emit('change', $event, 4)" :width="360" :height="400"/>
          <PromoTile v-bind="items[5]" @change="$emit('change', $event, 5)" :width="360" :height="200" class="uk-margin-top"/>
        </div>
      </div>
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
