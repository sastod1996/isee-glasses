<template>
  <div class="uk-grid-medium uk-flex-middle uk-child-width-1-3@s" uk-grid>
    <div>
      <PromoTile v-bind="items[0]" :width="400" :height="300"/>
    </div>
    <div>
      <PromoTile v-bind="items[1]" :width="400" :height="300"/>
    </div>
    <div>
      <PromoTile v-bind="items[2]" :width="400" :height="300"/>
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
