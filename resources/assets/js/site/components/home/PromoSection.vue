<template>
  <div class="uk-margin-large-bottom">

    <h2 v-if="title" class="section-title uk-text-uppercase uk-text-bold">{{ title }}</h2>
    
    <component
      v-for="(row, r) in rows"
      :key="r"
      :is="'PromoModel' + row.model"
      :items="row.items"
      class="uk-margin"
    />

  </div>
</template>

<script>
export default {
  props: {
    title: String,
    rows: Array
  }
}
</script>

<style scoped>
.section-title::before {
  content: ' \25B6';
  color: #a6dd2c;
  margin-left: -2px;
  margin-right: 17px;
  transform: scaleY(1.6);
  position: relative;
  float: left;
}
</style>
