<script lang="ts">
import {Component, Emit, Prop, Vue} from 'vue-property-decorator';
import {Action, State, namespace} from 'vuex-class';

const pStore = namespace('products');

@Component({})

export default class ProductsModal extends Vue {
  @Prop() form;
  @Prop() isAdd;
  @Prop() isVisible;
  @pStore.Action addProduct;
  @pStore.Action editProduct;
  @pStore.Action setModalVisible;
  @pStore.State isModalLoading;
  @Action setDialogMessage;

  handleOk() {
    if (this.isAdd) {
      this.addProduct(this.form);
    } else {
      this.editProduct(this.form);
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
    size="xl",
    scrollable
    centered
    :cancel-title='$t("buttons.cancel")',
    :ok-disabled='isModalLoading',
    :ok-title='isModalLoading ? $t("buttons.sending") : isAdd ? $t("buttons.add") : $t("buttons.update")',
    :title='isAdd ? $t("products.add_product") : $t("products.edit_product")',
    @hide='handleClose',
    @ok.prevent='handleOk',
  )
    b-form
      b-row
        b-col(md="4")
          b-form-group(
            :label='$t("products.form_estate")'
            :description='$t("products.form_estate_description")'
            label-for='estate',
          )
            b-form-input#estate(
              type='text',
              v-model='form.estate',
              maxlength="75",
              required,
            )
        b-col(md="4")
          b-form-group(
            :label='$t("products.form_size_estate")'
            :description='$t("products.form_size_estate_description")'
            label-for='size_estate',
          )
            b-form-input#size_estate(
              type='text',
              v-model='form.size_estate',
              maxlength="20",
              required,
            )
        b-col(md="4")
          b-form-group(
            :label='$t("products.form_plant_age_name")'
            :description='$t("products.form_plant_age_description")'
            label-for='plant_age',
          )
            b-form-input#plant_age(
              type='number',
              min=0,
              required,
              v-model='form.plant_age',
            )
        b-col(md="4")
          b-form-group(
            :label='$t("products.form_quantity_name")'
            :description='$t("products.form_quantity_description")'
            label-for='quantity',
          )
            b-form-input#quantity(
              type='number',
              min=0,
              required,
              v-model='form.quantity',
            )
        b-col(md="4")
          b-form-group(
            :label='$t("products.form_price_name")'
            :description='$t("products.form_price_description")'
            label-for='price',
          )
            b-form-input#price(
              type='text',
              required,
              v-model='form.price',
            )
        b-col(md="4")
          b-form-group(
            :label='$t("products.form_municipality")'
            :description='$t("products.form_municipality_description")'
            label-for='municipality',
          )
            b-form-input#municipality(
              type='text',
              v-model='form.municipality',
              maxlength="75",
              required,
            )
        b-col(md="6")
          b-form-group(
            :label='$t("products.form_location")'
            :description='$t("products.form_location_description")'
            label-for='location',
          )
            b-form-input#location(
              type='text',
              v-model='form.location',
              maxlength="125",
              required,
            )
        b-col(md="6")
          b-form-group(
            :label='$t("products.form_location_url")'
            :description='$t("products.form_location_url_description")'
            label-for='location_url',
          )
            b-form-input#location_url(
              type='text',
              v-model='form.location_url',
              maxlength="475",
              required,
            )
        b-col(md="12")
          span {{$t("products.form_description")}}
          quill-editor(
            ref="myQuillEditor"
            v-model="form.description"
            :options="{}"
          )

</template>
