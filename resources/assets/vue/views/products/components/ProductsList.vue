<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import {Action, State, namespace} from 'vuex-class';
import dialog from '@/utils/dialog';

const pStore = namespace('products');

@Component({})

export default class ProductsCard extends Vue {
  @pStore.State form;
  @pStore.State products;
  @pStore.State fields;
  @pStore.State pagination;
  @pStore.State isLoading;
  @pStore.State isModalVisible;
  @pStore.State isModalAdd;
  @pStore.Action deleteProduct;
  @pStore.Action loadProducts;
  @pStore.Action setModalVisible;
  @pStore.Action setForm;


  async created() {
    if (this.products.length == 0) {
      await this.getProducts();
    }
  }

  get actualUser() {
    return this.$store.state.auth.user;
  }

  editProduct(product: Product): void {
    this.isModalAdd = false;
    this.setModalVisible(true);

    this.form = { ...product };
  }

  async deleteProductConfirm(product: Product): Promise<void> {
    if (!(await dialog('front.delete_product_confirmation', true))) {
      return;
    }

    this.deleteProduct(product);
  }

  async getProducts(): Promise<void> {
    this.loadProducts();
  }

}

</script>

<template lang="pug">
  div
    b-button(
      style="margin-bottom: 5px;"
      @click="getProducts"
      size="sm"
      variant="primary"
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
      :items="products"
      :fields="fields"
      select-mode="single"
      small
    )

      template(#table-busy)
        div.text-center.text-danger
          b-spinner.align-middle

      template(v-slot:head(estate)="data")
        span {{$t("products.estate")}}
      template(v-slot:head(size_estate)="data")
        span {{$t("products.size_estate")}}
      template(v-slot:head(plant_age)="data")
        span {{$t("products.plant_age")}}
      template(v-slot:head(municipality)="data")
        span {{$t("products.municipality")}}
      template(v-slot:head(location)="data")
        span {{$t("products.location")}}
      template(v-slot:head(location_url)="data")
        span {{$t("products.location_url")}}
      template(v-slot:head(quantity)="data")
        span {{$t("products.quantity")}}
      template(v-slot:head(price)="data")
        span {{$t("products.price")}}

      template(v-slot:head(created_at)="data")
        span {{$t("strings.created_at")}}
      template(v-slot:head(updated_at)="data")
        span {{$t("strings.updated_at")}}
      template(v-slot:head(actions)="data")
        span {{$t("strings.actions")}}


      template(v-slot:cell(location_url)="data")
        a(v-show="data.item.location_url" :href="data.item.location_url" target="_blank") Link
      template(v-slot:cell(description)="data")
        b-button(
          size="sm"
          variant="primary"
          @click="data.toggleDetails"
          :title="(data.detailsShowing ? $t('strings.hide') : $t('strings.show'))+' '+$t('strings.details')"
        )
          b-icon(
            icon="eye"
            style="color: #fff;margin-right:5px"
          )
          span {{ data.detailsShowing ? $t('strings.hide') : $t('strings.show') }} {{ $t('strings.details') }}

      template(v-slot:cell(created_at)="data")
        span {{ data.item.created_at | moment("dddd D, MMMM YYYY") }}
      template(v-slot:cell(updated_at)="data")
        span {{ data.item.updated_at | moment("dddd D, MMMM YYYY") }}
      template(v-slot:cell(actions)="data")
        b-button-group(size="sm")
          b-button(
            @click="editProduct(data.item)"
            :title="$t('strings.edit')"
            variant="info"
          )
            b-icon(
              icon="pencil"
              style="color: #fff;margin-right:5px"
            )
            | {{$t('strings.edit')}}

          b-button(
            :title="$t('strings.delete')"
            @click="deleteProductConfirm(data.item)"
            variant="danger"
          )
            b-icon(
              icon="trash-fill"
              style="color: #fff;margin-right:5px"
            )
            | {{$t('strings.delete')}}

      template(v-slot:cell(index)="data")
        span {{ data.index + 1 }}

      template(#row-details='data')
        b-container.bg-white
          b-row
            b-col(
              v-html="data.item.description"
            )
</template>

<style lang="scss" scoped>

</style>
