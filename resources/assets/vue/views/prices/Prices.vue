<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { Action, namespace } from 'vuex-class';

import PricesList from './components/PricesList.vue';
import PricesModal from './components/PricesModal.vue';

const pStore = namespace('prices');

@Component({
  components: {
    PricesList,
    PricesModal,
  },
})
export default class Prices extends Vue {
  @Action setBackUrl;
  @Action setMenu;
  @pStore.State isLoading;
  @pStore.State form;
  @pStore.State isModalVisible;
  @pStore.Action setModalVisible;
  @pStore.Action setModalAdd;
  @pStore.Action setForm;

  isModalAdd = true;
  price: Partial<Price> = {};

  async created() {
    this.setBackUrl('/');
    this.setMenu([
      {
        key: 'add_price',
        text: 'prices.add_price',
        handler: this.addPrice,
      },
    ]);
  }

  addPrice(): void {
    this.setModalAdd(true);
    this.setForm(this.price);
    this.setModalVisible(true);
  }

}
</script>

<template lang="pug">
  b-container(tag='main' fluid)
    b-row
      b-col.mt-3
        h2 {{ $t('prices.title') }}
        PricesList

    prices-modal(
      ref='prices_modal',
      :form='form',
      :is-add='isModalAdd',
      :is-visible='isModalVisible',
    )
</template>
