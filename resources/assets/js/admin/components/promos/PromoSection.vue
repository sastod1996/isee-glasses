<template>
  <div class="uk-card uk-card-default">
    <div class="uk-card-header">
      <div class="uk-flex uk-flex-between uk-flex-middle">
        <div>
          <h3 class="uk-h2 uk-text-bold uk-margin-remove">
            {{ index + 1 }}: {{ title || '(sin título)' }} —
            <button
              :disabled="$root.saving"
              @click="toggleSection"
              class="uk-button uk-button uk-button-small uk-button-default uk-text-bold"
              :class="['uk-text-' + (hidden ? 'danger' : 'success')]"
            >{{ hidden ? 'OCULTO' : 'VISIBLE' }}</button>
          </h3>
        </div>
        <div>
          <ul class="uk-iconnav">
            <li v-if="index">
              <a
                @click="moveSectionUp"
                uk-icon="ratio: 1.2; icon: arrow-up"
                uk-tooltip="Mover arriba"
                class="uk-text-success"
              ></a>
            </li>
            <li v-if="index < sections.length - 1">
              <a
                @click="moveSectionDown"
                uk-icon="ratio: 1.2; icon: arrow-down"
                uk-tooltip="Mover abajo"
                class="uk-text-success"
              ></a>
            </li>
            <li>
              <a
                @click="renameSection"
                uk-icon="ratio: 1.2; icon: pencil"
                uk-tooltip="Renombrar"
                class="uk-text-warning"
              ></a>
            </li>
            <li>
              <a
                @click="removeSection"
                uk-icon="ratio: 1.2; icon: trash"
                uk-tooltip="Eliminar sección"
                class="uk-text-danger"
              ></a>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <div class="uk-card-body">
      <div>
        <div
          v-for="(row, r) in rows"
          :key="r"
          class="uk-card uk-card-small uk-card-default uk-margin-medium"
        >
          <div class="uk-card-header">
            <div class="uk-flex uk-flex-between uk-flex-middle">
              <div>
                <span class="uk-text-bold uk-h4">Fila {{ r + 1 }}</span>
                (Modelo {{ row.model }})
              </div>
              <div>
                <ul class="uk-iconnav">
                  <!-- <li><a uk-icon="icon: arrow-up" uk-tooltip="Mover arriba" class="uk-text-success"></a></li>
                  <li><a uk-icon="icon: arrow-down" uk-tooltip="Mover abajo" class="uk-text-success"></a></li>-->
                  <li>
                    <a
                      @click="removeRow(r)"
                      uk-icon="icon: trash"
                      uk-tooltip="Eliminar fila"
                      class="uk-text-danger"
                    ></a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="uk-card-body">
            <component
              :is="'PromoModel' + row.model"
              :items="row.items"
              @change="(kind, tile) => change(r, tile, kind)"
            />
          </div>
        </div>

        <div class="uk-card uk-card-small uk-background-muted uk-card-body uk-text-center">
          <div class="uk-width-medium uk-margin-auto uk-text-center">
            <h4 class="uk-text-uppercase uk-margin-small">Nueva fila</h4>
            <div class="uk-flex uk-flex-middle uk-margin-small">
              <select v-model="newRowModel" class="uk-select uk-margin-small-right">
                <option v-for="m in modelsQty" :key="m" :value="m">Modelo {{ m }}</option>
              </select>
              <a
                href="/admin-images/modelos-1-11.jpg"
                target="_blank"
                uk-icon="question"
                uk-tooltip="Mostrar los modelos"
              ></a>
            </div>
            <button @click="addRow" class="uk-button uk-button-secondary">Añadir fila</button>
          </div>
        </div>
      </div>
    </div>

    <PromoImageModal ref="modal"/>
  </div>
</template>

<script>
import PromoImageModal from "./PromoImageModal";

export default {
  props: {
    title: String,
    rows: Array,
    index: Number,
    hidden: Boolean
  },
  components: {
    PromoImageModal
  },
  data() {
    return {
      sections: this.$root.$data.sections,
      modelsItemsQuantities: this.$root.$data.modelsItemsQuantities,
      newRowModel: 1
    };
  },
  computed: {
    section() {
      return this.sections[this.index];
    },
    modelsQty() {
      return this.modelsItemsQuantities.length;
    }
  },
  methods: {
    toggleSection() {
      this.section.hidden = !this.hidden;
      this.$root.save();
    },
    moveSectionUp() {
      moveLeft(this.sections, this.index);
    },
    moveSectionDown() {
      moveRight(this.sections, this.index);
    },
    async renameSection() {
      const title = await UIkit.modal.prompt(
        "Ingrese el título de la sección:",
        this.title
      );
      if (title) {
        this.section.title = title;
        this.$root.save();
      }
    },
    async removeSection() {
      try {
        await UIkit.modal.confirm(`¿Desea eliminar la sección: ${this.title}?`);
        this.sections.splice(this.index, 1);
        this.$root.save();
      } catch (e) {}
    },
    async removeRow(r) {
      try {
        await UIkit.modal.confirm(
          `¿Desea eliminar la fila ${r + 1} de la sección ${this.title}?`
        );
        this.section.rows.splice(r, 1);
        this.$root.save();
      } catch (e) {}
    },
    addRow() {
      const model = this.newRowModel;
      const length = this.modelsItemsQuantities[model - 1];
      const items = Array.from({ length }, u => ({ url: "", img: "" }));
      this.section.rows.push({ model, items });
    },
    change(row, item, kind) {
      if (kind === "image") this.changeImage(row, item);
      else if (kind === "link") this.changeLink(row, item);
    },
    changeImage(rowIdx, itemIdx) {
      const item = this.section.rows[rowIdx].items[itemIdx];
      this.$refs.modal.open(item.img).then(img => {
        item.img = img;
        this.$root.save();
      }).catch(() => {});
    },
    changeLink(rowIdx, itemIdx) {
      const item = this.section.rows[rowIdx].items[itemIdx];
      UIkit.modal.prompt("Ingrese el enlace:", item.url).then(url => {
        if (!url || url === item.url) return;
        item.url = url;
        this.$root.save();
      });
    }
  }
};

function moveLeft(arr, idx) {
  if (idx <= 0) return;
  if (idx >= arr.length) return;
  const item = arr[idx];
  arr.splice(idx, 1);
  arr.splice(idx - 1, 0, item);
}

function moveRight(arr, idx) {
  if (idx < 0) return;
  if (idx >= arr.length) return;
  const item = arr[idx];
  arr.splice(idx, 1);
  arr.splice(idx + 1, 0, item);
}
</script>
