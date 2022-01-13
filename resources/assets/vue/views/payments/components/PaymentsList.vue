<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import {Action, State, namespace} from 'vuex-class';

const pStore = namespace('payments');

@Component({
             components: {}
           })

export default class PaymentsList extends Vue {
  @pStore.State payments;
  @pStore.State fields;
  @pStore.State isLoading;
  @pStore.Action loadUserPayments;
  @pStore.Action loadAllPayments;

  async created() {
    if (this.actualUser.type_id === 2) {
      await this.getUserPayments();
    } else {
      await this.getAllPayments();
    }
  }

  get actualUser() {
    return this.$store.state.auth.user;
  }

  async getAllPayments(): Promise<void> {
    this.loadAllPayments();
  }

  async getUserPayments(): Promise<void> {
    this.loadUserPayments();
  }

}

</script>

<template lang="pug">
  div
    b-button(
      v-if="actualUser.type_id == 2"
      style="margin-bottom: 5px;"
      @click="loadUserPayments"
      size="sm"
      variant="outline-primary"
    ) {{ $t('strings.update_table') }}
    b-button(
      v-else
      style="margin-bottom: 5px;"
      @click="loadAllPayments"
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
      :items="payments"
      :fields="fields"
      select-mode="single"
      small
    )

      template(#table-busy)
        div.text-center.text-danger
          b-spinner.align-middle

      template(v-slot:head(estate)="data")
        span {{$t("payments.estate")}}
      template(v-slot:head(user_name)="data")
        span {{$t("payments.user_name")}}
      template(v-slot:head(price)="data")
        span {{$t("payments.price")}}
      template(v-slot:head(quantity)="data")
        span {{$t("payments.quantity")}}
      template(v-slot:head(total)="data")
        span {{$t("payments.total")}}
      template(v-slot:head(collection_id)="data")
        span {{$t("payments.collection_id")}}
      template(v-slot:head(collection_status)="data")
        span {{$t("payments.collection_status")}}
      template(v-slot:head(payment_id)="data")
        span {{$t("payments.payment_id")}}
      template(v-slot:head(status)="data")
        span {{$t("payments.status")}}
      template(v-slot:head(payment_type)="data")
        span {{$t("payments.payment_type")}}
      template(v-slot:head(external_reference)="data")
        span {{$t("payments.external_reference")}}
      template(v-slot:head(merchant_order_id)="data")
        span {{$t("payments.merchant_order_id")}}
      template(v-slot:head(preference_id)="data")
        span {{$t("payments.preference_id")}}
      template(v-slot:head(site_id)="data")
        span {{$t("payments.site_id")}}
      template(v-slot:head(processing_mode)="data")
        span {{$t("payments.processing_mode")}}
      template(v-slot:head(merchant_account_id)="data")
        span {{$t("payments.merchant_account_id")}}
      template(v-slot:head(feedback_status)="data")
        span {{$t("payments.feedback_status")}}
      template(v-slot:head(preference_status)="data")
        span {{$t("payments.preference_status")}}
      template(v-slot:head(created_at)="data")
        span {{$t("strings.created_at")}}

      template(v-slot:cell(user_name)="data")
        span(v-if="data.item.user !== null") {{ data.item.user.name }} {{ data.item.user.lastname }}
      template(v-slot:cell(created_at)="data")
        span {{ data.item.created_at | moment("D, MMMM YYYY") }}

      template(v-slot:cell(index)="data")
        span {{ data.index + 1 }}

</template>

<style lang="scss" scoped>

</style>
