<template>
  <div class="pagination">
    <ul v-if="pages > 0" class="uk-pagination uk-flex-center uk-h4" uk-margin>
      <li :class="{ 'uk-invisible': value < 2 }">
        <a @click="to(value - 1)" :class="{ 'uk-disabled': loading }">
          <span uk-pagination-previous="ratio: 1.5"></span>
        </a>
      </li>
      <li v-for="page in elements(pages, value)" :class="{ 'uk-active': page == value }" class="">
        <span v-if="page === '...'">{{ page }}</span>
        <span v-else-if="page === value">{{ page }}</span>
        <a v-else @click="to(page)" :href="'#shop'" :class="{ 'uk-disabled': loading }">{{ page }}</a>
      </li>
      <li :class="{ 'uk-invisible': value >= pages }">
        <a @click="to(value + 1)" :class="{ 'uk-disabled': loading }">
          <span uk-pagination-next="ratio: 1.5"></span>
        </a>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  props: ['value', 'pages', 'loading'],
  methods: {
    to (page) {
      this.$emit('input', page)
      $('html, body').stop().animate({
            scrollTop: $('#shop').offset().top - 100
        }, 'slow');
    },
    elements (pages, value){
      if (pages>7) {
        var start, end;
        if (value<4) {
          start = 1
          end = 7
        }else if (value>pages-3) {
          start = pages-6
          end = pages
        }else {
          start = value-3
          end = value+3
        }
        var arr = []
        for (var i = start; i <= end; i++) {
          arr.push(i)
        }
        return arr;
      }else{
        return pages;
      }
    }
  }
}
</script>

<style>
</style>
