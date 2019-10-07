<template>
  <div v-if="existVisible" class="uk-section-small">
    <div class="uk-container">

      <template v-for="(section, s) in sections">
        <PromoSection v-if="!section.hidden" :key="s" v-bind="section" />
      </template>

    </div>
  </div>
</template>

<script>
export default {
  props: {
    sections: Array
  },
  computed: {
    existVisible () {
      return this.sections.some(s => !s.hidden)
    }
  }
};
</script>
