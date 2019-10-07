<template>
  <div>
    
    <div class="uk-card uk-card-small uk-card-primary uk-card-body" uk-sticky>
      <div class="uk-position-relative uk-flex uk-flex-between uk-flex-middle">
        <div>
          <h1 class="uk-h3 uk-margin-remove">PROMOCIONES</h1>
        </div>
        <div v-if="$root.saving" class="uk-position-center" uk-spinner></div>
        <div>
          <button @click="$root.save" class="uk-button uk-button-primary uk-text-bold">GUARDAR</button>
        </div>
      </div>
    </div>
    
    <PromoSection
      v-for="(section, s) in sections"
      :key="s"
      v-bind="section"
      :index="s"
      class="uk-margin-large-bottom uk-margin-medium-top"
    />

    <div class="uk-card uk-card-body uk-card-default uk-background-muted uk-margin-medium-top">
      <div class="uk-width-large uk-margin-auto uk-text-center">
        <h3 class="uk-text-uppercase uk-text-bold">Nueva sección</h3>
        <input v-model="newSectionTitle" @keypress.enter="addSection" maxlength="60" placeholder="Título (opcional)" class="uk-input uk-display-block uk-margin uk-text-center">
        <button @click="addSection" class="uk-button uk-button-primary">Añadir sección</button>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  data () {
    return {
      sections: this.$root.$data.sections,
      newSectionTitle: ''
    }
  },
  methods: {
    addSection () {
      this.sections.push({
        title: this.newSectionTitle,
        rows: [],
        hidden: false
      })
      this.newSectionTitle = ''
    }
  }
}
</script>
