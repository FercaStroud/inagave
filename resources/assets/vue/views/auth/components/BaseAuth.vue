<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';

@Component
export default class BaseAuth extends Vue {
}
</script>

<template lang="pug">
  div.custom-vh(:style="{background: 'url(https://inagave.com/background_panel.jpg) no-repeat', }")
    router-view
</template>

<style lang="scss" scoped>
.custom-vh{
  height: calc(100vh - 64px);
}
.reset-password {
  padding-top: 0px;
}
</style>
