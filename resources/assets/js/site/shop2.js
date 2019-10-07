const Vue = window.Vue

Vue.component('isee-shop', require('./components/shop/Shop').default)

/* eslint-disable */
const app = new Vue({
    el: '#app'
})
