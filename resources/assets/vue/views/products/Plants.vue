<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import {Action, namespace} from 'vuex-class';

const pStore = namespace('products');
const prStore = namespace('prices');
const sStore = namespace('settings');

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
export default class Plants extends Vue {
  @Action setBackUrl;
  @Action setMenu;

  @pStore.State isLoading;
  @pStore.State products;
  @pStore.Action loadUserProducts;
  @pStore.Mutation SET_LOADING;

  @prStore.State prices;
  @prStore.Action loadPrices;

  @sStore.State settings;
  @sStore.Action loadSettings;

  isModalAdd = true;
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
      this.getSettings();
      this.getPrices();
      this.getProducts();
    });
  }

  async getProducts(): Promise<void> {
    this.loadUserProducts();
  }

  async getPrices(): Promise<void> {
    this.loadPrices();
  }

  async getSettings(): Promise<void> {
    this.loadSettings();
  }

  getProductPriceByYear(planted_at) {
    return (this.prices.find(({year}) => year === parseInt(planted_at.slice(0, 4)))).price;
  }

  async maintenancePayPalPayment(product): Promise<void> {
    this.SET_LOADING(true);
    try {
      product.price = this.settings.maintenance;
      const response = await axios.post('paypal/checkout/maintenance', product);
      if (response.data.result.links !== undefined) {
        let links = response.data.result.links;
        links.forEach(function (item, index) {
          if (item.rel === "approve") {
            window.location.replace(item.href);
          }
        })
      } else {
        alert(
          "Error desconocido,, favor de mandar lo siguiente al administrador:"
          + JSON.stringify(response.data)
        )
      }
    } catch {
      this.$bvModal.msgBoxOk('' + this.$t('errors.generic_error'));
    } finally {
      this.mpContainer = true;
      this.SET_LOADING(false);
    }
  }

  async maintenancePayment(product): Promise<void> {
    this.SET_LOADING(true);
    try {
      product.price = this.settings.maintenance;
      const response = await axios.post('checkout/maintenance', product);
      const mp = new window["MercadoPago"](
        this.$store.state.MP_TOKEN, {
          locale: 'es-MX'
        }
      );
      mp.checkout({
        preference: {
          id: response.data.id
        },
        autoOpen: true,
      });
    } catch {
      this.$bvModal.msgBoxOk('' + this.$t('errors.generic_error'));
    } finally {
      this.mpContainer = true;
      this.SET_LOADING(false);
    }
  }

  async cloneProduct(product): Promise<void> {
    if (parseInt(product.cloneQty) > parseInt(product.quantity)) {
      this.$bvModal.msgBoxOk('' + this.$t('errors.max_error'));
    } else {
      this.SET_LOADING(true);

      try {
        const response = await axios.post('clone/product', product);
      } catch {
        this.$bvModal.msgBoxOk('' + this.$t('errors.generic_error'));

      } finally {
        this.mpContainer = false;
        this.getProducts();
      }
    }
  }
}
</script>

<template lang="pug">
  b-container.mb-5(tag='main' fluid)
    b-row
      b-col.mt-3
        h2 {{ $t('products.my_plants') }}

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
              b-col.mt-2(md="12" sm="12" v-if="product.quantity === 0")
                h2.font-weight-bold.text-danger.text-center.montserrat {{ $t('strings.sold') }}
              b-col.mt-2(md="3" sm="12")
                strong {{ $t('products.location') }}
                l-map(
                  :zoom="14"
                  :center="[47.41322, -1.219482]"
                  style="height: 240px; width: 100%;"
                )
                  l-tile-layer(
                    url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                    attribution="'&copy; <a href=\"http://osm.org/copyright\">OpenStreetMap</a> contributors"
                  )
                  l-marker(
                    :icon="icon"
                    :lat-lng="[47.41322, -1.219482]"
                  )
                  l-control(
                    position="topright"
                  )
                    b-link(
                      :href="product.location_url"
                      target="_blank"
                    ) {{ $t('strings.view_in_maps') }}
                small.text-muted {{ product.location }}

              b-col(md="5" sm="12")
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
                  strong {{ $t('strings.payment_at') }}: &nbsp;
                  span.text-muted {{ product.created_at | moment("D, MMMM YYYY") }}
                  br/
                  strong {{ $t('strings.jimado_at') }}: &nbsp;
                  span.text-muted {{ product.jimado_at | moment("D, MMMM YYYY") }}
                  br/
                  strong {{ $t('strings.owner') }}: &nbsp;
                  span.text-muted {{ product.user.name }}
                  br/
                  strong {{ $t('products.available') }}: &nbsp;
                  span.text-success(v-if="product.available" ) {{$t("strings.true")}}
                  span.text-danger(v-else) {{$t("strings.false")}}

                hr
              b-col(
                md="4"
                sm="12"
                v-if="product.isMaintenancePaid || product.maintenance_type === 1"
              )
                p.mt-3.text-center.font-weight-bold.text-info.montserrat {{ $t('prices.title') }}:
                p.text-center.text-primary.montserrat(style="font-size:1.5em") {{ getProductPriceByYear(product.planted_at) }} (MXN)
                b-input-group(v-if="!isLoading && !mpContainer && !product.available")
                  b-form-input(
                    type="number"
                    min="0"
                    v-model="product.cloneQty"
                    :max="product.quantity"
                  )
                  b-input-group-append
                    b-button(
                      variant="warning"
                      @click="cloneProduct(product)"
                    ) {{ $t('strings.generate_product') }}
                div(v-if="isLoading")
                  b-button(
                    variant="warning"
                    disabled
                    block
                  )
                    b-spinner(
                      small
                      variant="light"
                      type="grow"
                    )

              b-col(
                md="4"
                sm="12"
                v-if="!product.isMaintenancePaid && product.available !== 1 && product.maintenance_type !== 1"
              )
                p.mt-3.text-center.font-weight-bold.text-info.montserrat {{ $t('strings.maintenance_price') }}:
                p.font-weight-bold.text-center.text-danger.montserrat ${{ settings.maintenance }} (MXN)
                hr
                p.text-center.font-weight-bold.text-info.montserrat {{ $t('strings.total') }}:
                p.font-weight-bold.text-center.text-danger.montserrat(style="font-size:2em") ${{ parseFloat(product.quantity) * parseFloat(settings.maintenance) }} (MXN)
                hr
                b-button(
                  variant="warning"
                  @click="maintenancePayment(product)"
                  block
                  v-if="!isLoading"
                ) {{ $t('strings.generate_maintenance_payment') }} - Mercado Pago
                div(v-else)
                  b-button(
                    variant="warning"
                    disabled
                    block
                  )
                    b-spinner(
                      small
                      variant="light"
                      type="grow"
                    )

                b-button(
                  variant="info"
                  @click="maintenancePayPalPayment(product)"
                  block
                  v-if="!isLoading"
                ) {{ $t('strings.generate_maintenance_payment') }} - PayPal
                div(v-else)
                  b-button(
                    variant="info"
                    disabled
                    block
                  )
                    b-spinner(
                      small
                      variant="light"
                      type="grow"
                    )

            b-col.mt-2(md="12" sm="12" v-if="product.available !== 1 && product.maintenance_type !== 1" )
              h2.font-weight-bold.text-danger.text-center.montserrat {{ $t('strings.maintenance_history') }}
              b-table(
                style="max-height: calc(100vh - 191px); font-size: .75em;"
                striped
                hover
                responsive
                sticky-header
                no-border-collapse
                bordered
                outlined
                head-variant="dark"
                small
                :items="product.maintenances"
              )

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
