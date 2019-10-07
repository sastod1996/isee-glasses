Vue.component('PromoTile', require('./components/promos/PromoTile.vue').default)
for (let i = 1; i <= 11; i++) {
  Vue.component('PromoModel' + i, require(`./components/promos/models/PromoModel${i}.vue`).default);
}
Vue.component('PromoSection', require('./components/promos/PromoSection.vue').default)
Vue.component('PromoContainer', require('./components/promos/PromoContainer.vue').default)

const app = new Vue({
  el: '#app',
  data: {
    sections: window.PromoContainer.sections,
    modelsItemsQuantities: [6, 5, 5, 3, 2, 3, 2, 3, 4, 1, 3],
    saving: false,
  },
  methods: {
    async save() {
      UIkit.notification.closeAll()
      if (this.saving) return
      this.saving = true
      try {
        await axios.put('/admin/promotions/1', { sections: this.sections })
        UIkit.notification('Cambios guardados', 'success')
      } catch (error) {
        UIkit.notification('Error al actualizar', 'danger')
      }
      this.saving = false
    }
  }
})
