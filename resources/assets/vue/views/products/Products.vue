<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { Action, namespace } from 'vuex-class';

import ProductsList from './components/ProductsList.vue';
import ProductsModal from './components/ProductsModal.vue';

const pStore = namespace('products');

@Component({
  components: {
    ProductsList,
    ProductsModal,
  },
})
export default class Products extends Vue {
  @Action setBackUrl;
  @Action setMenu;
  @pStore.State isLoading;
  @pStore.State form;
  @pStore.State isModalVisible;
  @pStore.Action setModalVisible;
  @pStore.Action setModalAdd;
  @pStore.Action setForm;

  isModalAdd = true;
  product: Partial<Product> = {};

  async created() {
    this.setBackUrl('/');
    this.setMenu([
      {
        key: 'add_product',
        text: 'products.add_product',
        handler: this.addProduct,
      },
    ]);
  }

  addProduct(): void {
    this.setModalAdd(true);
    this.product.available = true;
    this.setForm(this.product);
    this.setModalVisible(true);
  }

}
</script>

<template lang="pug">
b-container(tag='main' fluid)
  b-row
    b-col.mt-3
      h2 {{ $t('products.title') }}
      ProductsList

  products-modal(
    ref='products_modal',
    :form='form',
    :is-add='isModalAdd',
    :is-visible='isModalVisible',
  )
</template>
