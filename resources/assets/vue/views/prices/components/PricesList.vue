<script lang="ts">
import {Component, Prop, Vue} from 'vue-property-decorator';
import {Action, State, namespace} from 'vuex-class';
import dialog from '@/utils/dialog';

import PricesModal from './PricesModal.vue';

const pStore = namespace('prices');

@Component({
  components: {
    PricesModal,
  }
})

export default class PricesList extends Vue {
  @pStore.State form;
  @pStore.State prices;
  @pStore.State fields;
  @pStore.State isLoading;
  @pStore.State isModalVisible;
  @pStore.State isModalAdd;
  @pStore.Action loadPrices;
  @pStore.Action deletePrice;
  @pStore.Action setModalVisible;
  @pStore.Action setModalAdd;
  @pStore.Action setForm;

  search = '';

  async created() {
    if (this.prices.length == 0) {
      await this.getPrices();
    }
  }

  get actualUser() {
    return this.$store.state.auth.user;
  }

  editPrice(price: Price): void {
    this.setModalAdd(false);
    this.setForm(price);
    this.setModalVisible(true);
  }

  async deletePriceConfirm(price: Price): Promise<void> {
    if (!(await dialog('front.delete_price_confirmation', true))) {
      return;
    }

    this.deletePrice(price);
  }

  async getPrices(): Promise<void> {
    this.loadPrices();
  }
}

</script>

<template lang="pug">
  div
    b-form-input#search.mb-2(
      type="search"
      v-model='search',
      :placeholder='$t("strings.search")'
      style="width:230px;float:right"
    )

    b-button(
      style="margin-bottom: 5px;"
      @click="getPrices"
      size="sm"
      variant="outline-primary"
    ) {{ $t('strings.update_table') }}

    b-table.btable(
      style="max-height: calc(100vh - 191px); font-size: .75em;"
      striped
      hover
      responsive
      sticky-header
      no-border-collapse
      bordered
      outlined
      head-variant="dark"
      :busy="isLoading"
      :items="prices"
      :fields="fields"
      select-mode="single"
      small
      :filter="search"
    )

      template(#table-busy)
        div.text-center.text-danger
          b-spinner.align-middle

      template(v-slot:head(price)="data")
        span {{$t("prices.price")}}
      template(v-slot:head(year)="data")
        span {{$t("prices.year")}}

      template(v-slot:head(created_at)="data")
        span {{$t("strings.created_at")}}
      template(v-slot:head(updated_at)="data")
        span {{$t("strings.updated_at")}}
      template(v-slot:head(actions)="data")
        span {{$t("strings.actions")}}

      template(v-slot:cell(price)="data")
        span ${{data.item.price}} (MXN)
      template(v-slot:cell(year)="data")
        span {{data.item.year}}
      template(v-slot:cell(created_at)="data")
        span {{ data.item.created_at | moment("D, MMMM YYYY") }}
      template(v-slot:cell(updated_at)="data")
        span {{ data.item.updated_at | moment("D, MMMM YYYY") }}
      template(v-slot:cell(actions)="data")
        b-button-group(size="sm")
          b-button(
            @click="editPrice(data.item)"
            :title="$t('strings.edit')"
            variant="info"
            style="font-size:.8em"
          )
            | {{$t('strings.edit')}}

          b-button(
            :title="$t('strings.delete')"
            @click="deletePriceConfirm(data.item)"
            variant="danger"
            style="font-size:.8em"
          )
            | {{$t('strings.delete')}}

      template(v-slot:cell(index)="data")
        span {{ data.index + 1 }}
</template>

<style lang="scss" scoped>

</style>
