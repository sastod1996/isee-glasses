<template>
  <div class="tile uk-background-muted uk-transition-toggle" :style="style">
    <div v-if="!img" class="uk-position-center uk-text-center uk-text-white uk-text-large">
      {{ width }}x{{ height }}
    </div>
    
    <div class="uk-transition-slide-bottom uk-position-bottom uk-overlay uk-overlay-default">
      <ul class="uk-iconnav uk-margin-remove uk-flex-center">
        <li><a @click="$emit('change', 'image')" uk-icon="ratio: 1.15; icon: image" uk-tooltip="Cambiar imagen" class="uk-text-primary"></a></li>
        <li><a @click="$emit('change', 'link')" uk-icon="ratio: 1.15; icon: link" uk-tooltip="Cambiar enlace" class="uk-text-primary"></a></li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    width: {
      type: Number,
      required: true
    },
    height: {
      type: Number,
      required: true
    },
    img: {
      type: String
    },
    url: {
      type: String
    }
  },
  computed: {
    style () {
      return {
        paddingTop: (this.height / this.width) * 100 + '%',
        backgroundImage: this.img ? `url(${this.img})` : 'none',
        border: !this.img ? '1px dashed #003d5d' : 'none'
      }
    }
  }
}
</script>

<style lang="scss" scoped>
.tile {
  position: relative;
  height: 0;
  background-position: center;
  background-size: cover;
  overflow: hidden;
}
</style>
