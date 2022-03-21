<script lang="ts">
import {Component, Emit, Prop, Vue} from 'vue-property-decorator';
import {Action, State, namespace} from 'vuex-class';

const pStore = namespace('prices');

@Component({})

export default class PricesModal extends Vue {
  @Prop() form;
  @Prop() isAdd;
  @Prop() isVisible;
  @pStore.Action addPrice;
  @pStore.Action editPrice;
  @pStore.Action setModalVisible;
  @pStore.State isModalLoading;
  @pStore.State isModalAdd;
  @Action setDialogMessage;

  handleOk() {
    if (this.isModalAdd) {
      this.addPrice(this.form);
    } else {
      this.editPrice(this.form);
    }
  }

  handleClose() {
    this.setModalVisible(false);
  }
}
</script>

<template lang="pug">
  b-modal(
    hide-header-close=true,
    :visible='isVisible',
    size="md",
    scrollable
    centered
    :cancel-title='$t("buttons.cancel")',
    :ok-disabled='isModalLoading',
    :ok-title='isModalLoading ? $t("buttons.sending") : isModalAdd ? $t("buttons.add") : $t("buttons.update")',
    :title='isModalAdd ? $t("prices.add_price") : $t("prices.edit_price")',
    @hide='handleClose',
    @ok.prevent='handleOk',
  )
    b-form
      b-row
        b-col(md="6")
          b-form-group(
            :label='$t("prices.form_price")'
            :description='$t("prices.form_price_description")'
            label-for='price',
          )
            b-form-input#price(
              type='numeric',
              min="0"
              step="0.1"
              v-model='form.price',
              required,
            )
        b-col(md="6")
          b-form-group(
            :label='$t("prices.form_weight")'
            :description='$t("prices.form_weight_description")'
            label-for='weight',
          )
            b-form-input#weight(
              type='numeric',
              v-model='form.weight',
              min="0"
              step="0.1"
              required,
            )
        b-col(md="6")
          b-form-group(
            :label='$t("prices.form_year")'
            :description='$t("prices.form_year_description")'
            label-for='year',
          )
            b-form-input#year(
              type='numeric',
              v-model='form.year',
              min="0"
              required,
            )
        b-col(md="6")
          b-form-group(
            label='Default',
            label-for='default',
          )
            b-form-checkbox#default(
              name="default",
              switch,
              v-model='form.default',
            )
</template>
