<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { Action, namespace } from 'vuex-class';

import WalletsList from './components/WalletsList.vue';

@Component({
  components: {
    WalletsList,
  },
})

export default class Wallets extends Vue {
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
      WalletsList
</template>
