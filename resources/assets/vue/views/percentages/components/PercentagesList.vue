<script lang="ts">
import {Component, Prop, Vue} from 'vue-property-decorator';
import {Action, State, namespace} from 'vuex-class';
import dialog from '@/utils/dialog';

import PercentagesModal from './PercentagesModal.vue';

const pStore = namespace('percentages');

@Component({
             components: {
               PercentagesModal,
             }
           })

export default class PercentagesList extends Vue {
  @pStore.State form;
  @pStore.State percentages;
  @pStore.State fields;
  @pStore.State isLoading;
  @pStore.State isModalVisible;
  @pStore.State isModalAdd;
  @pStore.Action loadPercentages;
  @pStore.Action deletePercentage;
  @pStore.Action setModalVisible;
  @pStore.Action setModalAdd;
  @pStore.Action setForm;

  search = '';

  async created() {
    await this.getPercentages();
  }

  get actualUser() {
    return this.$store.state.auth.user;
  }

  editPercentage(percentage: Percentage): void {
    this.setModalAdd(false);
    this.setForm(percentage);
    this.setModalVisible(true);
  }

  async deletePercentageConfirm(percentage: Percentage): Promise<void> {
    if (!(await dialog('front.delete_percentage_confirmation', true))) {
      return;
    }

    this.deletePercentage(percentage);
  }

  async getPercentages(): Promise<void> {
    this.loadPercentages();
  }
}

</script>

<template lang="pug">
  div
    b-form-input#search.mb-2(
      type="search"
      v-model='search',
      :placeholder='$t("strings.search")'
      style="width:230px;float:right"
    )

    b-button(
      style="margin-bottom: 5px;"
      @click="getPercentages"
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
      :items="percentages"
      :fields="fields"
      select-mode="single"
      small
      :filter="search"
    )

      template(#table-busy)
        div.text-center.text-danger
          b-spinner.align-middle

      template(v-slot:head(name)="data")
        span {{$t("percentages.name")}}
      template(v-slot:head(value)="data")
        span {{$t("percentages.value")}}

      template(v-slot:head(created_at)="data")
        span {{$t("strings.created_at")}}
      template(v-slot:head(updated_at)="data")
        span {{$t("strings.updated_at")}}
      template(v-slot:head(actions)="data")
        span {{$t("strings.actions")}}

      template(v-slot:cell(value)="data")
        span {{data.item.value}}%
      template(v-slot:cell(name)="data")
        span {{data.item.name}}
      template(v-slot:cell(created_at)="data")
        span {{ data.item.created_at | moment("D, MMMM YYYY") }}
      template(v-slot:cell(updated_at)="data")
        span {{ data.item.updated_at | moment("D, MMMM YYYY") }}
      template(v-slot:cell(actions)="data")
        b-button-group(size="sm")
          b-button(
            @click="editPercentage(data.item)"
            :title="$t('strings.edit')"
            variant="info"
            style="font-size:.8em"
          )
            | {{$t('strings.edit')}}

          b-button(
            :title="$t('strings.delete')"
            @click="deletePercentageConfirm(data.item)"
            variant="danger"
            style="font-size:.8em"
          )
            | {{$t('strings.delete')}}

      template(v-slot:cell(index)="data")
        span {{ data.index + 1 }}
</template>

<style lang="scss" scoped>

</style>
