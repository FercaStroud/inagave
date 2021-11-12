<script lang="ts">
import {Component, Emit, Prop, Vue} from 'vue-property-decorator';
import {Action, State, namespace} from 'vuex-class';

const pStore = namespace('products');

@Component({})

export default class ProductImageModal extends Vue {
  @Prop() form;
  @Prop() isAdd;
  @Prop() isVisible;
  @pStore.Action addProductImage;
  @pStore.Action setImageModalVisible;
  @pStore.State isProductImageModalLoading;
  @Action setDialogMessage;

  handleOk() {
    if (this.isAdd) {
      this.addProductImage(this.form);
    }
  }

  handleClose() {
    this.setImageModalVisible(false);
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
    :ok-disabled='isProductImageModalLoading',
    :ok-title='isProductImageModalLoading ? $t("buttons.sending") : isAdd ? $t("buttons.add") : $t("buttons.update")',
    :title='isAdd ? $t("strings.add") : $t("strings.edit")',
    @hide='handleClose',
    @ok.prevent='handleOk',
  )
    b-form
      b-row
        b-col(md="12")
          b-form-group(
            :label='$t("products.form_product_image_id")'
            :description='$t("products.form_product_image_id_description")'
            label-for='id',
          )
            b-form-input#id(
              type='number',
              v-model='form.product_id',
              min="0"
              readonly
              required,
            )
        b-col(md="12")
          b-form-group(
            :label='$t("products.form_product_image_name")'
            :description='$t("products.form_product_image_name_description")'
            label-for='name',
          )
            b-form-input#name(
              type='text',
              v-model='form.name',
              maxlength="75",
              required,
            )
        b-col(md="12")
          b-form-group(
            :label='$t("products.form_product_image")'
            :description='$t("products.form_product_image_description")'
            label-for='name',
          )
            b-form-file#src(
              accept="image/*",
              :browse-text='$t("strings.browse")',
              :state="Boolean(form.src)"
              v-model='form.src',
              :placeholder='$t("strings.choose_img")'
              :drop-placeholder='$t("strings.drop_img")'
            )

</template>
