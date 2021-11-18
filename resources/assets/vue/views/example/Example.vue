<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { Action } from 'vuex-class';

// TODO change
@Component
export default class Home extends Vue {
  @Action setBackUrl;
  @Action setMenu;
  @Action setDialogMessage;

  mounted() {
    this.setBackUrl('/');
    this.setMenu([]);
  }
}
</script>

<template lang="pug">
b-container(tag='main')
  h1 {{ $t('strings.example') }}
</template>
