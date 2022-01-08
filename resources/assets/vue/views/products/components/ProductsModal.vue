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
  @pStore.State isModalAdd;
  @Action setDialogMessage;

  handleOk() {
    if (this.isModalAdd) {
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
    :ok-title='isModalLoading ? $t("buttons.sending") : isModalAdd ? $t("buttons.add") : $t("buttons.update")',
    :title='isModalAdd ? $t("products.add_product") : $t("products.edit_product")',
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
            :label='$t("products.form_size")'
            :description='$t("products.form_size_description")'
            label-for='size',
          )
            b-form-input#size(
              type='text',
              v-model='form.size',
              maxlength="20",
              required,
            )
        b-col(md="4")
          b-form-group(
            :label='$t("products.form_age_name")'
            :description='$t("products.form_age_description")'
            label-for='age',
          )
            b-form-input#age(
              type='number',
              min=0,
              required,
              v-model='form.age',
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
            :label='$t("products.form_inagave_price_name")'
            :description='$t("products.form_inagave_price_description")'
            label-for='inagave_price',
          )
            b-form-input#inagave_price(
              type='text',
              required,
              v-model='form.price',
            )
        b-col(md="6")
          b-form-group(
            :label='$t("products.form_maintenance_price_name")'
            :description='$t("products.form_maintenance_price_description")'
            label-for='maintenance_price',
          )
            b-form-input#maintenance_price(
              type='text',
              required,
              v-model='form.maintenance_price',
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
        b-col(md="6")
          b-form-group(
            :label='$t("products.form_planted_at")'
            :description='$t("products.form_planted_at_description")'
            label-for='planted_at',
          )
            b-form-datepicker#planted_at(
              v-model='form.planted_at',
              required,
            )
        b-col(md="6")
          b-form-group(
            :label='$t("products.form_jimado_at")'
            :description='$t("products.form_jimado_at_description")'
            label-for='jimado_at',
          )
            b-form-datepicker#jimado_at(
              v-model='form.jimado_at',
              required,
            )
        b-col(md="6")
          b-form-group(
            :label='$t("products.form_available")',
            :description='$t("products.form_available_description")',
            label-for='available',
          )
            b-form-checkbox#available(
              name="available",
              switch,
              v-model='form.available',
            )
        b-col(md="12")
          span {{$t("products.form_description")}}
          quill-editor(
            ref="myQuillEditor"
            v-model="form.description"
            :options="{}"
          )
</template>
