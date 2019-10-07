Vue.component('product', require('./components/Product.vue').default);
Vue.component('glass-test', require('./components/GlassTest.vue').default);

const app = new Vue({
    el: '#app'
});
