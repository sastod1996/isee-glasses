<template>
  <div ref="modal" uk-modal="bg-close: false; esc-close: false">
    <div class="uk-modal-dialog">
      <button class="uk-modal-close-default" uk-close></button>
      <div class="uk-modal-body uk-text-center">
        <input ref="input" type="file" @change="upload" hidden>
        <div v-if="uploading" class="uk-padding uk-background-muted">
          Cargando imagen...
        </div>
        <div v-else>
          <img v-if="newUrl" :src="newUrl" class="uk-display-block uk-margin" alt>
          <button @click="$refs.input.click()" class="uk-button uk-button-secondary">
            {{ newUrl ? 'Cambiar' : 'Seleccionar' }} imagen
          </button>
        </div>
      </div>
      <div class="uk-modal-footer uk-text-right">
        <button @click="cancel" class="uk-button uk-button-default uk-modal-close">Cancelar</button>
        <button @click="save" class="uk-button uk-button-primary">Guardar</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      modal: null,
      newUrl: "",
      uploading: false
    };
  },
  mounted() {
    this.modal = UIkit.modal(this.$refs.modal);
  },
  beforeDestroy() {
    this.modal.$destroy();
  },
  methods: {
    open(url) {
      return new Promise((resolve, reject) => {
        this.newUrl = url || '';
        this.modal.show();
        this.$once("save", () => resolve(this.newUrl));
        this.$once("cancel", reject);
      });
    },
    cancel() {
      this.modal.hide();
      this.$emit("cancel");
    },
    save() {
      this.url = this.newUrl;
      this.modal.hide();
      this.$emit("save");
    },
    async upload() {
      const file = this.$refs.input.files[0];
      if (!file) return;
      this.uploading = true;
      try {
        const formData = new FormData();
        formData.append("image", file);
        const { data: path } = await axios.post(
          "/admin/promotions/upload",
          formData,
          {
            headers: { "Content-Type": "multipart/form-data" }
          }
        );
        this.newUrl = path;
      } catch (error) {
        console.log(error.message);
      }
      this.uploading = false;
    }
  }
};
</script>

<style>
</style>
