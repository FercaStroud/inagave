<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import {Action, namespace} from 'vuex-class';
import LineChart from "@/components/charts/LineChart";
import axios from "axios";

const pStore = namespace('prices');
const sStore = namespace('settings');
const uStore = namespace('users');

@Component({
  components: {LineChart}
})
export default class ContentDashboard extends Vue {
  @Action setBackUrl;
  @Action setMenu;
  @Action setDialogMessage;

  @uStore.State stats;
  @uStore.Action setUserStats;
  @uStore.Action loadUserStats;

  @pStore.State isLoading;
  @pStore.State prices;
  @pStore.State pricesArray;
  @pStore.State yearsArray;
  @pStore.Action loadPrices;
  @pStore.Mutation SET_LOADING;

  mounted() {
    this.$nextTick(() => {
      this.getPrices();
      this.getUserStats();
    });
  }

  async getPrices(): Promise<void> {
    this.loadPrices();
  }

  async getUserData(): Promise<void> {
    await this.getPrices();
    await this.getUserStats();
  }

  async getUserStats(): Promise<void> {
    this.loadUserStats();
  }

}
</script>

<template lang="pug">
  div
    h1.mt-5 {{ $t('strings.dashboard') }}

    b-button(
      style="margin-bottom: 5px;"
      @click="getUserData"
      size="sm"
      variant="outline-primary"
    ) {{ $t('strings.update_dashboard') }}

    b-row.pt-5.pb-5(v-if="!isLoading" )
      b-col(md="6" sm="12")
        b-row
          b-col(md="12" sm="12")
            b-card
              b-card-body
                h2.montserrat.text-primary {{ $t('prices.title') }}
                line-chart(
                  :chart-data="{ labels: yearsArray, datasets: [ { label: $t('prices.title'),  backgroundColor: '#ffc10770', data: pricesArray } ] }"
                  :options="{ responsive: true, maintainAspectRatio: false }"
                )
      b-col(md="6" sm="12")
        b-row
          b-col(md="12" sm="12")
            b-card
              b-card-body
                .text-center.font-weight-bold.text-info.montserrat {{ $t('strings.total_wallet_user_plants') }}:
                p.font-weight-bold.text-center.text-danger.montserrat(style="font-size:2em") ${{(stats.total_plant_founds).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')}} (MXN)
                b-button(variant="warning" block to="/user/products") {{ $t('strings.sell_plant') }}

          b-col.mt-3(md="6" sm="12")
            b-card
              b-card-body
                .text-center.font-weight-bold.text-info.montserrat {{ $t('strings.total_wallet_user') }}:
                p.font-weight-bold.text-center.text-danger.montserrat(style="font-size:2em") ${{(stats.total_user_founds).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')}} (MXN)
                b-button(variant="warning" block to="/wallet" ) {{ $t('strings.withdraw_wallet') }}

          b-col.mt-3(md="6" sm="12")
            b-card
              b-card-body
                .text-center.font-weight-bold.text-info.montserrat {{ $t('strings.total_user_plants') }}:
                p.font-weight-bold.text-center.text-danger.montserrat(style="font-size:2em") {{stats.total_plants}}

                .text-center.font-weight-bold.text-info.montserrat {{ $t('strings.total_user_plants_inagave_method') }}:
                p.font-weight-bold.text-center.text-danger.montserrat(style="font-size:1.2em")  {{stats.total_plants_m_inagave}}

                .text-center.font-weight-bold.text-info.montserrat {{ $t('strings.total_user_plants_total_method') }}:
                p.font-weight-bold.text-center.text-danger.montserrat(style="font-size:1.2em")  {{stats.total_plants_m_total}}
                b-button(variant="primary" block to="/store") {{ $t('strings.buy_plants') }}

</template>
