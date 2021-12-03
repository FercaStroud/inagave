<script lang="ts">
import {Component, Emit, Prop, Vue} from 'vue-property-decorator';
import {Action, State, namespace} from 'vuex-class';

const pStore = namespace('percentages');

@Component({})

export default class PercentagesModal extends Vue {
  @Prop() form;
  @Prop() isAdd;
  @Prop() isVisible;
  @pStore.Action addPercentage;
  @pStore.Action editPercentage;
  @pStore.Action setModalVisible;
  @pStore.State isModalLoading;
  @pStore.State isModalAdd;
  @Action setDialogMessage;

  handleOk() {
    if (this.isModalAdd) {
      this.addPercentage(this.form);
    } else {
      this.editPercentage(this.form);
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
    :title='isModalAdd ? $t("percentages.add_percentage") : $t("prices.edit_percentage")',
    @hide='handleClose',
    @ok.prevent='handleOk',
  )
    b-form
      b-row
        b-col(md="6")
          b-form-group(
            :label='$t("percentages.form_name")'
            :description='$t("percentages.form_name_description")'
            label-for='name',
          )
            b-form-input#name(
              type='text',
              v-model='form.name',
              required,
            )
        b-col(md="6")
          b-form-group(
            :label='$t("percentages.form_value")'
            :description='$t("percentages.form_value_description")'
            label-for='value',
          )
            b-form-input#name(
              type='numeric',
              min="0"
              step="0.1"
              v-model='form.value',
              required,
            )
</template>
