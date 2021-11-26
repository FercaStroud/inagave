<script lang="ts">
import {Component, Prop, Vue} from 'vue-property-decorator';
import {Action, State, namespace} from 'vuex-class';
import dialog from '@/utils/dialog';

import ProductImageModal from './ProductImageModal.vue';

const pStore = namespace('products');

@Component({
  components: {
    ProductImageModal,
  }
})

export default class ProductsList extends Vue {
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
  @pStore.Action setModalAdd;
  @pStore.Action setForm;

  image: Partial<Image> = {};
  @pStore.State productImageForm;
  @pStore.State isProductImageModalLoading;
  @pStore.State isProductImageModalVisible;
  @pStore.State isProductImageModalAdd;
  @pStore.Action setImageForm;
  @pStore.Action setImageModalVisible;
  @pStore.Action addProductImage;
  @pStore.Action loadProductImages;
  @pStore.Action deleteProductImage;

  search = '';

  async created() {
    if (this.products.length == 0) {
      await this.getProducts();
    }
  }

  get actualUser() {
    return this.$store.state.auth.user;
  }

  editProduct(product: Product): void {
    this.setModalAdd(false);
    product.available = Boolean(product.available);
    this.setForm(product);
    this.setModalVisible(true);
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

  async getProductImages(product_id: number): Promise<void> {
    this.loadProductImages({product_id});
  }

  addImageToProduct(product_id: number): void {
    this.image.product_id = product_id;
    this.setImageForm(this.image);
    this.setImageModalVisible(true);
  }

  async deleteProductImageConfirm(image: Image): Promise<void> {
    if (!(await dialog('front.delete_product_image_confirmation', true))) {
      return;
    }

    this.deleteProductImage(image);
  }
}

</script>

<template lang="pug">
  div
    product-image-modal(
      ref='product-image-modal',
      :form='productImageForm',
      :is-add='true',
      :is-visible='isProductImageModalVisible',
    )

    b-form-input#search.mb-2(
      type="search"
      v-model='search',
      :placeholder='$t("strings.search")'
      style="width:230px;float:right"
    )

    b-button(
      style="margin-bottom: 5px;"
      @click="getProducts"
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
      :items="products"
      :fields="fields"
      select-mode="single"
      small
      :filter="search"
    )

      template(#table-busy)
        div.text-center.text-danger
          b-spinner.align-middle

      template(v-slot:head(estate)="data")
        span {{$t("products.estate")}}
      template(v-slot:head(size)="data")
        span {{$t("products.size")}}
      template(v-slot:head(age)="data")
        span {{$t("products.age")}}
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
      template(v-slot:head(owner)="data")
        span {{$t("strings.owner")}}
      template(v-slot:head(available)="data")
        span {{$t("products.available")}}

      template(v-slot:head(planted_at)="data")
        span {{$t("strings.planted_at")}}
      template(v-slot:head(jimado_at)="data")
        span {{$t("strings.jimado_at")}}
      template(v-slot:head(created_at)="data")
        span {{$t("strings.created_at")}}
      template(v-slot:head(updated_at)="data")
        span {{$t("strings.updated_at")}}
      template(v-slot:head(actions)="data")
        span {{$t("strings.actions")}}

      template(v-slot:cell(available)="data")
        span.text-success(v-if="data.item.available" ) {{$t("strings.true")}}
        span.text-danger(v-else) {{$t("strings.false")}}
      template(v-slot:cell(size)="data")
        span {{data.item.size}} (ha)
      template(v-slot:cell(price)="data")
        span ${{data.item.price}} (MXN)
      template(v-slot:cell(age)="data")
        span {{data.item.age}} {{$t("strings.years")}}
      template(v-slot:cell(owner)="data")
        span {{data.item.user.name}} {{data.item.user.lastname}}
      template(v-slot:cell(location_url)="data")
        a(v-show="data.item.location_url" :href="data.item.location_url" target="_blank") Link
      template(v-slot:cell(description)="data")
        b-button.btn-block(
          size="sm"
          variant="outline-primary"
          style="font-size:.75em"
          @click="data.toggleDetails"
          :title="(data.detailsShowing ? $t('strings.hide') : $t('strings.show'))+' '+$t('strings.details')"
        )
          span {{ data.detailsShowing ? $t('strings.hide') : $t('strings.show') }} {{ $t('strings.details') }}

      template(v-slot:cell(created_at)="data")
        span {{ data.item.created_at | moment("D, MMMM YYYY") }}
      template(v-slot:cell(updated_at)="data")
        span {{ data.item.updated_at | moment("D, MMMM YYYY") }}
      template(v-slot:cell(planted_at)="data")
        span {{ data.item.planted_at | moment("D, MMMM YYYY") }}
      template(v-slot:cell(jimado_at)="data")
        span {{ data.item.jimado_at | moment("D, MMMM YYYY") }}
      template(v-slot:cell(actions)="data")
        b-button-group(size="sm")
          b-button(
            @click="editProduct(data.item)"
            :title="$t('strings.edit')"
            variant="info"
            style="font-size:.8em"
          )
            | {{$t('strings.edit')}}

          b-button(
            :title="$t('strings.delete')"
            @click="deleteProductConfirm(data.item)"
            variant="danger"
            style="font-size:.8em"
          )
            | {{$t('strings.delete')}}

      template(v-slot:cell(index)="data")
        span {{ data.index + 1 }}

      template(#row-details='data')
        b-container(fluid)
          b-row
            b-col(
              md="4"
            )
              b-card(
                border-variant="primary"
              )
                b-card-title
                  strong {{$t("strings.images")}}
                  b-button-group(
                    style="float:right"
                    size="sm"
                  )
                    b-button(
                      :title="$t('strings.update')"
                      size="sm"
                      @click="getProductImages(data.item.id)"
                      variant="outline-primary"
                    )
                      | {{$t('strings.update')}}
                    b-button(
                      size="sm"
                      :title="$t('strings.add')"
                      @click="addImageToProduct(data.item.id)"
                      variant="success"
                    )
                      | {{$t('strings.add')}}
                b-card-body
                  b-container(fluid)
                    b-row
                      b-col.border.p-1(
                        md="3"
                        v-for="(image, key) in data.item.images" :key="key"
                      )
                        img.img-fluid(
                          :src="'/products/' + image.src"
                        )
                        b-button.btn-block.mt-1(
                          :title="$t('strings.delete')"
                          @click="deleteProductImageConfirm(image)"
                          variant="outline-danger"
                          style="font-size:.8em;"
                        )
                          | {{$t('strings.delete')}}

            b-col(
              md="8"
            )
              b-card(
                border-variant="primary"
              )
                b-card-title {{$t("products.form_description")}}
                b-card-body
                  div(v-html="data.item.description")
</template>

<style lang="scss" scoped>

</style>
