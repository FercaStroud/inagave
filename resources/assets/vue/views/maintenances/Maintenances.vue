<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { Action, namespace } from 'vuex-class';

import MaintenancesList from './components/MaintenancesList.vue';

@Component({
  components: {
    MaintenancesList,
  },
})

export default class Payments extends Vue {
  @Action setBackUrl;
  @Action setMenu;

  async created() {
    this.setBackUrl('/');
    this.setMenu([]);
  }

}
</script>

<template lang="pug">
b-container(tag='main' fluid)
  b-row
    b-col.mt-3
      h2 {{ $t('maintenances.title') }}
      MaintenancesList
</template>
