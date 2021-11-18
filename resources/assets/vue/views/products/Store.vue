<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import {Action, namespace} from 'vuex-class';

const pStore = namespace('products');

import {latLng, icon} from "leaflet";
import {LMap, LTileLayer, LMarker, LIcon, LControl} from 'vue2-leaflet';
import 'leaflet/dist/leaflet.css';


@Component({
  components: {
    LMap,
    LTileLayer,
    LMarker,
    LIcon,
    LControl
  },
})
export default class Users extends Vue {
  @Action setBackUrl;
  @Action setMenu;
  @pStore.State isLoading;
  @pStore.State products;
  @pStore.Action loadStoreProducts;

  isModalAdd = true;
  product: Partial<Product> = {};

  async created() {
    this.setBackUrl('/');
  }

  mounted() {
    this.$nextTick(() => {
      if ((this.products).length == 0) {
        this.getProducts();
      }
    });
  }

  async getProducts(): Promise<void> {
    this.loadStoreProducts();
  }

  icon = icon(
    {
      iconUrl: "/assets/images/agave.svg",
      iconSize: [50, 50],
      iconAnchor: [50, 50]
    }
  );
}
</script>

<template lang="pug">
  b-container(tag='main' fluid)
    b-row
      b-col.mt-3
        h2 {{ $t('products.title') }}

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
              b-col(md="3" sm="12")
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
                  :center="[47.41322, -1.219482]"
                  style="height: 282px; width: 100%;"
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

                hr
                p
                  strong {{ $t('strings.total') }}:
                    .montserrat.total.text-danger.text-right $ {{ parseFloat(product.checkoutQty * product.price).toFixed(2) }}
                b-input-group
                  b-form-input(
                    type="number"
                    min="0"
                    v-model="product.checkoutQty"
                    :max="product.quantity"
                  )
                  b-input-group-append
                    b-button(
                      variant="danger"
                    ) {{ $t('strings.checkout') }}

            b-col.mt-2(md="12" sm="12")
                hr
                strong {{ $t('products.description') }}
                div(v-html="product.description" )

</template>

<style lang="scss" scoped>
.product-card{
  border-radius: 20px !important;
}
.price{
}
.total{
  font-size: 2em;
}
</style>
