<script lang="ts">
import {Component, Emit, Prop, Vue} from 'vue-property-decorator';
import {Action, State, namespace} from 'vuex-class';
import axios from 'axios';
import checkResponse from '@/utils/checkResponse';

const uStore = namespace('users');
const pStore = namespace('products');

@Component({})

export default class AddProductToUser extends Vue {
  @Prop() form;
  @Prop() isVisible;
  @uStore.Action setModalToAddProductToUserVisible;
  @uStore.Action addProductToUser;
  @uStore.State isModalLoading;
  @uStore.State isModalToAddProductVisible;
  @Action setDialogMessage;

  @pStore.State products;
  @pStore.Action loadProducts;
  @pStore.Action setLoading;
  @pStore.State isLoading;

  async created() {
    await this.getProducts();
  }

  async getProducts(): Promise<void> {
    this.loadProducts();
  }

  async handleOk(): Promise<void> {
    try {
      this.setLoading(true);
      const response = await axios.post('user/add/product/', this.form);
      const checkErrors = checkResponse(response);

      if (checkErrors) {
        this.$bvToast.toast('', {
          title: checkErrors.message,
          variant: 'danger',
          toaster: 'b-toaster-top-center',
          solid: true
        });
      } else {
        this.handleClose();
      }

    } catch {
      this.$bvToast.toast('', {
        title: this.$t('errors.generic_error'),
        variant: 'danger',
        toaster: 'b-toaster-top-center',
        solid: true
      });
    } finally {
      this.setLoading(false);
    }
  }

  handleClose() {
    this.setModalToAddProductToUserVisible(false);
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
    :ok-title='$t("buttons.add")',
    :title='$t("products.add_product")',
    @hide='handleClose',
    @ok.prevent='handleOk',
  )
    b-form
      b-row
        b-col(md="6")
          b-form-group(
            v-if="!isLoading"
            :label='$t("products.form_estate")'
            :description='$t("products.form_estate_description")'
            label-for='estate',
          )
            b-form-select(
              v-model="form.product_id"
              :select-size="7"
            )
              b-form-select-option(
                v-for="(product, i) in products" :key="i"
                :value="product.id"
              ) {{product.estate}}
          b-button(
            v-else
            variant="warning"
            disabled
            block
          )
            b-spinner(
              small
              variant="light"
              type="grow"
            )
        b-col(md="6")
          b-form-group(
            v-if="!isLoading"
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
          b-button(
            v-else
            variant="warning"
            disabled
            block
          )
            b-spinner(
              small
              variant="light"
              type="grow"
            )

</template>
