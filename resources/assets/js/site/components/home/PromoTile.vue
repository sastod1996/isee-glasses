<template>
  <div class="tile" :style="style">
    <a v-if="img && url" :href="url" class="tile-link"></a>
    <img v-if="!img" class="uk-position-center" style="max-width: 50%" src="/pages/inicio/logo.png" alt="">
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
        backgroundImage: this.img ? `url(${this.img})` : 'none'
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
  background-color: #f8f8f8;
}

.tile-link {
  user-select: none;
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  transition: all .3s;
  opacity: 0;
  background-color: rgba(165, 221, 44, 0.3);
}

.tile-link:hover {
  opacity: 1;
}
</style>
