<template>
  <div class="">
    <select :value="active" @change="updateValue($event.target.value)" class="uk-select" :disabled="loading">
      <option v-for="(o, i) in opts" :value="i" :key="i">{{ o.text }}</option>
    </select>
  </div>
</template>

<script>
export default {
  props: ['value', 'loading', 'opts'],
  computed: {
    active () {
      return this.opts.findIndex(o => {
        return o.value[0] === this.value[0] && o.value[1] === this.value[1]
      })
    }
  },
  methods: {
    updateValue (i) {
      this.$emit('input', this.opts[i].value)
    }
  }
}
</script>

<style lang="css">
</style>
