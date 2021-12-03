<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { Action, namespace } from 'vuex-class';

import PercentagesList from './components/PercentagesList.vue';
import PercentagesModal from './components/PercentagesModal.vue';

const pStore = namespace('percentages');

@Component({
  components: {
    PercentagesList,
    PercentagesModal,
  },
})
export default class Percentages extends Vue {
  @Action setBackUrl;
  @Action setMenu;
  @pStore.State isLoading;
  @pStore.State form;
  @pStore.State isModalVisible;
  @pStore.Action setModalVisible;
  @pStore.Action setModalAdd;
  @pStore.Action setForm;

  isModalAdd = true;
  percentage: Partial<Percentage> = {};

  async created() {
    this.setBackUrl('/');
    this.setMenu([
      {
        key: 'add_percentage',
        text: 'percentages.add_percentage',
        handler: this.addPercentage,
      },
    ]);
  }

  addPercentage(): void {
    this.setModalAdd(true);
    this.setForm(this.percentage);
    this.setModalVisible(true);
  }

}
</script>

<template lang="pug">
  b-container(tag='main' fluid)
    b-row
      b-col.mt-3
        h2 {{ $t('percentages.title') }}
        PercentagesList

    percentages-modal(
      ref='percentages_modal',
      :form='form',
      :is-add='isModalAdd',
      :is-visible='isModalVisible',
    )
</template>
