Vue.component('PromoTile', require('./components/home/PromoTile.vue').default);
for (let i = 1; i <= 11; i++) {
  Vue.component('PromoModel' + i, require(`./components/home/promo-models/PromoModel${i}.vue`).default);
}
Vue.component('PromoSection', require('./components/home/PromoSection.vue').default);
Vue.component('PromoContainer', require('./components/home/PromoContainer.vue').default);

const app = new Vue({
  el: '#app',
  data: {
    sections: window.PromoContainer.sections
  }
});
