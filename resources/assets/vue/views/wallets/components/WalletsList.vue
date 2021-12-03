<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import {Action, State, namespace} from 'vuex-class';
import axios from "axios";

const wStore = namespace('wallets');
const uStore = namespace('users');

@Component({
  components: {}
})

export default class WalletsList extends Vue {
  @wStore.State wallets;
  @wStore.State fields;
  @wStore.State form;
  @wStore.State isLoading;
  @wStore.State isModalVisible;
  @wStore.Action loadWallets;
  @wStore.Action loadUserWallet;
  @wStore.Action setModalVisible;
  @wStore.Action setLoading;

  @uStore.State stats;
  @uStore.Action setUserStats;
  @uStore.Action loadUserStats;

  async created() {
    if (this.wallets.length == 0) {
      if (this.actualUser.type_id === 2) {
        await this.getUserWallets();
      } else {
        await this.getAllWallets();
      }
    }
    await this.getUserStats();
  }

  get actualUser() {
    return this.$store.state.auth.user;
  }

  async getAllWallets(): Promise<void> {
    this.loadWallets();
  }

  async getUserWallets(): Promise<void> {
    this.loadUserWallet();
  }

  async getUserStats(): Promise<void> {
    this.loadUserStats();
  }

  async requestWithdraw() {
    if (this.form.amount > this.stats.total_user_founds) {
      this.$bvModal.msgBoxOk('' + this.$t('errors.max_error'));

    } else if (this.form.account === '' || this.form.bank === '') {
      this.$bvModal.msgBoxOk('' + this.$t('errors.generic_error'));

    } else {
      this.setLoading(true);
      try {
        const response = await axios.post('request/withdraw', this.form);

      } catch {
        this.$bvModal.msgBoxOk('' + this.$t('errors.generic_error'));

      } finally {
        this.setLoading(false);
        await this.getUserWallets();
        await this.getUserStats();
        this.setModalVisible(false);
      }
    }
  }

  async changeStatus(wallet) {
    this.setLoading(true);
    try {
      const response = await axios.post('approve/user/request', wallet);

    } catch {
      this.$bvModal.msgBoxOk('' + this.$t('errors.generic_error'));

    } finally {
      this.loadWallets()
    }
  }
}

</script>

<template lang="pug">
  div
    b-container(fluid)
      b-row
        b-col(md="8" sm="12")
          h2 {{ $t('wallets.title') }}
        b-col(md="4" sm="12" v-if="this.actualUser.type_id === 2" )
          .text-center.font-weight-bold.text-info.montserrat {{ $t('strings.total_wallet_user') }}:
          p.font-weight-bold.text-center.text-danger.montserrat(style="font-size:2em") ${{(stats.total_user_founds).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')}} (MXN)

    b-modal(
      v-model="isModalVisible"
      @hide="form.amount = 0; form.account = ''; form.bank = ''; setModalVisible(false)",
      hide-header-close
      centered
      hide-footer
    )
      b-container(fluid)
        b-row
          b-col(md="12")
            .text-center.font-weight-bold.text-info.montserrat {{ $t('strings.total_wallet_user') }}:
            p.font-weight-bold.text-center.text-danger.montserrat(style="font-size:2em") ${{(stats.total_user_founds).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')}} (MXN)
          b-col(md="12")
            .text-left.font-weight-bold.text-info.montserrat {{ $t('wallets.amount') }}:
            b-form-input(
              type="number"
              min="0"
              step="0.01"
              v-model="form.amount"
              :max="stats.total_user_founds"
            )
          b-col.mt-3(md="12")
            .text-left.font-weight-bold.text-info.montserrat {{ $t('wallets.bank') }}:
            b-form-input(
              type="text"
              v-model="form.bank"
            )
          b-col.mt-3(md="12")
            .text-left.font-weight-bold.text-info.montserrat {{ $t('wallets.account') }}:
            b-form-input(
              type="text"
              v-model="form.account"
            )
          b-col.mt-3(md="12")
            b-button(
              v-if="!isLoading"
              style="margin-bottom: 5px;"
              @click="requestWithdraw"
              variant="success"
              block
            ) {{ $t('strings.request') }}
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
    b-button(
      v-if="actualUser.type_id === 2"
      style="margin-bottom: 5px;"
      @click="getUserWallets"
      size="sm"
      variant="outline-primary"
    ) {{ $t('strings.update_table') }}
    b-button(
      v-else
      style="margin-bottom: 5px;"
      @click="getAllWallets"
      size="sm"
      variant="outline-primary"
    ) {{ $t('strings.update_table') }}
    b-button.ml-2(
      v-if="actualUser.type_id === 2"
      style="margin-bottom: 5px;"
      @click="form.amount = 0; form.account = ''; form.bank = ''; setModalVisible(true);"
      size="sm"
      variant="warning"
    ) {{ $t('wallets.request') }}

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
      :items="wallets"
      :fields="fields"
      select-mode="single"
      small
    )

      template(#table-busy)
        div.text-center.text-danger
          b-spinner.align-middle

      template(v-slot:head(user_name)="data")
        span {{$t("wallets.user_name")}}
      template(v-slot:head(status)="data")
        span {{$t("wallets.status")}}
      template(v-slot:head(amount)="data")
        span {{$t("wallets.amount")}}
      template(v-slot:head(bank)="data")
        span {{$t("wallets.bank")}}
      template(v-slot:head(account)="data")
        span {{$t("wallets.account")}}
      template(v-slot:head(type)="data")
        span {{$t("wallets.type")}}
      template(v-slot:head(created_at)="data")
        span {{$t("strings.created_at")}}
      template(v-slot:head(details)="data")
        span {{$t("strings.details")}}

      template(v-slot:cell(user_name)="data")
        span {{ data.item.user.name }} {{ data.item.user.lastname }}
      template(v-slot:cell(created_at)="data")
        span {{ data.item.created_at | moment("D, MMMM YYYY") }}
      template(v-slot:cell(details)="data")
        b-button(
          variant="outline-primary"
          style="font-size:.8em"
          @click="data.toggleDetails"
          :title="(data.detailsShowing ? $t('strings.hide') : $t('strings.show'))+' '+$t('strings.details')"
        )
          span {{ data.detailsShowing ? $t('strings.hide') : $t('strings.show') }} {{ $t('strings.details') }}

      template(v-slot:cell(amount)="data")
        strong.text-success(v-if="data.item.type === 'DEPOSIT'") + ${{ (parseInt(data.item.amount)).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') }} (MXN)
        strong.text-danger(v-else) - ${{ (parseInt(data.item.amount)).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') }} (MXN)

      template(v-slot:cell(actions)="data")
        b-button(
          v-if="actualUser.type_id !== 2 && data.item.status === 'PENDING'"
          @click="changeStatus(data.item)"
          :title="$t('strings.edit')"
          variant="warning"
          style="font-size:.8em"
        )
          | {{$t('strings.approve')}}

      template(#row-details='data')
        b-container.bg-primary(fluid)
          b-row
            b-col
              b-table.mt-3.bg-white(
                style="max-height: calc(100vh - 191px);"
                striped
                hover
                responsive
                sticky-header
                no-border-collapse
                bordered
                small
                head-variant="dark"
                :items="data.item.transactions"
              )

      template(v-slot:cell(index)="data")
        span {{ data.index + 1 }}

</template>

<style lang="scss" scoped>

</style>
