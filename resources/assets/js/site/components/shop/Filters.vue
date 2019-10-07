<template>
  <div class="">

    <div class="">
      <div v-for="category in resources.categories">
        <label>
          <input v-model="f.categories" @change="updateValue" :value="category.id" type="checkbox" class="uk-checkbox" :disabled="loading">
          {{ category.name }}
        </label>
      </div>
    </div>

    <div class="uk-padding-small uk-hidden@m uk-text-center">
      <h4 @click="$refs.chars.classList.toggle('uk-visible@m')" class="uk-pointer uk-margin-remove">
        <b>FILTROS</b>
        <span uk-icon="chevron-down"></span>
      </h4>
    </div>

    <div ref="chars" class="uk-visible@m uk-margin isee-characteristics-div">
      <ul class="isee-characteristics-ul" uk-accordion="multiple: true">
        <li v-for="(characteristic, index) in computedCharacteristics" class="uk-open">
          <h3 class="uk-accordion-title uk-text-bold uk-text-center">
            <template v-if="index == 0"> Premium </template>
            <template v-else>
              {{ characteristic.name }}
            </template>
          </h3>
          <div class="uk-accordion-content">
            <!-- <div class="uk-grid uk-child-width-1-2 uk-child-width-1-1@s uk-child-width-1-2@m uk-grid-small" uk-grid> -->
            <div>
              <div v-for="attribute in characteristic.attributes">
                <label>
                  <a class="uk-link-reset" href="#filters" @click="scroll">
                    <label>
                      <input v-model="f.attributes" @change="updateValue, $refs.chars.classList.toggle('uk-visible@m')" :value="attribute.id" type="checkbox" class="uk-checkbox" :disabled="loading" >
                      {{ attribute.name }}
                    </label>
                  </a>
                </label>
              </div>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  props: ['value', 'resources', 'loading'],
  data () {
    return {
      f: {
        categories: [],
        attributes: []
      }
    }
  },
  watch: {
    value: {
      handler () { this.f = this.value },
      deep: true
    }
  },
  computed: {
    primaryColors () {
      var chars = this.resources.characteristics
      var attrs = chars.find(c => c.slug === 'color').attributes
      var primaries = {}
      attrs.forEach(a => {
        primaries[a.primary] = primaries[a.primary] || { name: a.primary, ids: [] }
        primaries[a.primary].ids.push(a.id)
      })
      var colors = []
      Object.keys(primaries).forEach(p => {
        colors.push({
          name: primaries[p].name,
          id: primaries[p].ids.join(',')
        })
      })
      return colors
    },
    computedCharacteristics () {
      var chars = this.resources.characteristics
      chars = chars.map(c => {
        if (c.slug === 'color') {
          c.attributes = this.primaryColors
          return c
        }
        return c
      })
      return chars
    }
  },
  methods: {
    updateValue () {
      this.$emit('input', this.f)
    },
    scroll (){
      // console.log('scroll!!');
      $('html, body').stop().animate({
            scrollTop: $('#filters').offset().top - 100
        }, 'slow');
    }
  },
  created () {
    this.f = this.value
  }
}
</script>

<style lang="css">
.uk-pointer {
  cursor: pointer;
}
</style>
