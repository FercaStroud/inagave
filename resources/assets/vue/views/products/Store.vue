<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import {Action, namespace} from 'vuex-class';

const pStore = namespace('products');
const prStore = namespace('prices');
const aStore = namespace('auth');

import {latLng, icon} from "leaflet";
import {LMap, LTileLayer, LMarker, LIcon, LControl} from 'vue2-leaflet';
import 'leaflet/dist/leaflet.css';
import axios from "axios";

@Component({
  components: {
    LMap,
    LTileLayer,
    LMarker,
    LIcon,
    LControl
  },
})
export default class Store extends Vue {
  @Action setBackUrl;
  @Action setMenu;

  @aStore.State user;

  @pStore.State isLoading;
  @pStore.State products;
  @pStore.Action loadStoreProducts;
  @pStore.Mutation SET_LOADING;

  @prStore.State prices;
  @prStore.Action loadPrices;

  isModalAdd = true;
  product: Partial<Product> = {};
  mpContainer = false;

  icon = icon(
    {
      iconUrl: "/assets/images/agave.svg",
      iconSize: [50, 50],
      iconAnchor: [50, 50]
    }
  );

  async created() {
    this.setBackUrl('/');
  }

  mounted() {
    this.$nextTick(() => {
        this.getProducts();
        this.getPrices();
    });
  }

  async getProducts(): Promise<void> {
    this.loadStoreProducts();
  }

  async getPrices(): Promise<void> {
    this.loadPrices();
  }

  getProductPriceByYear(planted_at) {
    return (this.prices.find(({year}) => year === parseInt(planted_at.slice(0, 4)))).price;
  }

  async checkout(product): Promise<void> {
    if (parseInt(product.checkoutQty) > parseInt(product.quantity)) {
      this.$bvModal.msgBoxOk('' + this.$t('errors.max_error'));
    } else {

      if(product.user.type_id !== 1) {
        product.price = this.getProductPriceByYear(product.planted_at);
      }
      this.SET_LOADING(true);

      try {
        const response = await axios.post('checkout', product);
        const mp = new window["MercadoPago"](
          this.$store.state.MP_TOKEN, {
            locale: 'es-MX'
          }
        );
        mp.checkout({
          preference: {
            id: response.data.id
          },
          render: {
            container: '.mp-container' + product.id,
            label: this.$t('strings.checkout'),
          },
          autoOpen: true,
        });
      } catch {
        this.$bvToast.toast('', {
          title: this.$t('errors.generic_error'),
          variant: 'danger',
          toaster: 'b-toaster-top-center',
          solid: true
        })
      } finally {
        this.mpContainer = true;
        this.SET_LOADING(false);
        /*setTimeout(function (){
          window.close()
        }, 2000)*/
      }
    }
  }
}
</script>

<template lang="pug">
  b-container.mb-5(tag='main' fluid)
    b-row
      b-col.mt-3
        h2 {{ $t('products.title') }}

    b-row
      b-col.mt-3
        b-button(
          @click="getProducts();mpContainer = false;"
          size="sm"
          variant="outline-primary"
        ) {{ $t('strings.update') }}

    b-row
      b-col.mt-3(
        v-for="(product, key) in products"
        :key="key"
        sm="12"
        md="12"
        lg="12"
      )
        b-card.product-card.shadow
          b-card-body(style="padding:0")
            b-row
              b-col.mt-2(
                v-if="product.user.type_id === 2"
                md="3"
                sm="12"
              )
                strong {{ $t('prices.title') }}
                b-list-group(
                  style="max-height: 282px; overflow: auto"
                )
                  b-list-group-item(
                    v-for="(price, key) in prices"
                    :key="key"
                    class="flex-column align-items-start"
                  )
                    .d-flex.w-100.justify-content-between
                      h5.mb-1 ${{price.price}} (MXN)
                      small {{price.year}}
              b-col(v-else md="3" sm="12")
                b-carousel(
                  id="carousel-fade"
                  indicators
                )
                  b-carousel-slide(
                    v-for="(image, index) in product.images"
                    :key="index"
                    :img-src="'/products/' + image.src"
                    style="max-height:300px"
                  )
                .font-weight-bold.montserrat.price.text-right.mt-3 $ {{ product.price }}&nbsp;
                  small / {{ $t('strings.unit') }}

              b-col.mt-2(md="6" sm="12")
                strong {{ $t('products.location') }}
                l-map(
                  :zoom="14"
                  :center="(product.location).split(',')"
                  style="height: 282px; width: 100%;"
                )
                  l-tile-layer(
                    url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                    attribution="'&copy; <a href=\"http://osm.org/copyright\">OpenStreetMap</a> contributors"
                  )
                  l-marker(
                    :icon="icon"
                    :lat-lng="(product.location).split(',')"
                  )
                  l-control(
                    position="topright"
                  )
                    b-link(
                      :href="product.location_url"
                      target="_blank"
                    ) {{ $t('strings.view_in_maps') }}
                small.text-muted {{ product.location }}

              b-col(md="3" sm="12")
                .font-weight-bold.text-info.montserrat {{ product.estate }}
                hr
                p
                  strong {{ $t('products.municipality') }}: &nbsp;
                  span.text-muted {{ product.municipality }}
                  br/
                  strong {{ $t('products.size') }}: &nbsp;
                  span.text-muted {{ product.size }} {{ $t('strings.acres') }}
                  br/
                  strong {{ $t('products.age') }}: &nbsp;
                  span.text-muted {{ product.age }} {{ $t('strings.years') }}
                  br/
                  strong {{ $t('products.quantity') }}: &nbsp;
                  span.text-muted {{ product.quantity }} {{ $t('strings.units') }}
                  br/
                  strong {{ $t('strings.planted_at') }}: &nbsp;
                  span.text-muted {{ product.planted_at | moment("D, MMMM YYYY") }}
                  br/
                  strong {{ $t('strings.jimado_at') }}: &nbsp;
                  span.text-muted {{ product.jimado_at | moment("D, MMMM YYYY") }}
                  br/
                  strong {{ $t('strings.owner') }}: &nbsp;
                  span.text-muted {{ product.user.name }}

                hr
                p(v-if="product.user.type_id === 1")
                  strong {{ $t('strings.total') }}:
                    .montserrat.total.text-danger.text-right $ {{ parseFloat(product.checkoutQty * product.price).toFixed(2) }}
                p(v-else)
                  strong {{ $t('strings.total') }}:
                    .montserrat.total.text-danger.text-right $ {{ parseFloat(product.checkoutQty * getProductPriceByYear(product.planted_at)).toFixed(2) }}
                b-input-group(v-if="!isLoading && !mpContainer && product.user_id !== user.id")
                  b-form-input(
                    type="number"
                    min="0"
                    v-model="product.checkoutQty"
                    :max="product.quantity"
                  )
                  b-input-group-append
                    b-button(
                      variant="danger"
                      @click="checkout(product)"
                    ) {{ $t('strings.generate_payment') }}
                div(v-if="isLoading")
                  b-button(
                    variant="danger"
                    disabled
                    block
                  )
                    b-spinner(
                      small
                      variant="light"
                      type="grow"
                    )
                div( :class="'w100 mp-container' + product.id")

            b-col.mt-2(md="12" sm="12")
              hr
              strong {{ $t('products.description') }}
              div(v-html="product.description" )

</template>

<style lang="scss" scoped>
.product-card {
  border-radius: 20px !important;
}

.price {
}

.total {
  font-size: 2em;
}
</style>
