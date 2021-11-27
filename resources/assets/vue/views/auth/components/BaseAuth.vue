<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';

@Component
export default class BaseAuth extends Vue {
}
</script>

<template lang="pug">
  div.custom-vh(:style="{background: 'url(https://inagave.com/wp-content/uploads/2021/09/bruno-emmanuelle-U0-3w8afuok-unsplash-scaled.jpg) no-repeat', }")
    b-container(fluid)
      b-row
        b-col.mt-5.mb-5.shadow(
          md="8"
          sm="10"
          lg="8"
          offset-sm="1"
          offset-md="2"
          offset-lg="2"
          style="backdrop-filter: blur(15px); border-radius:25px; background-color:rgba(255,255,255,0.5)"
        )
          router-link(:to='{ name: "auth.login" }')
            img.mt-3(
              src='/assets/images/logo.svg',
              alt='Logo'
              style="width:300px;margin-left:50%;left:-150px;position:relative;"
            )
          router-view


</template>

<style lang="scss" scoped>
.custom-vh{
  height: 100vh;
}
.reset-password {
  padding-top: 0px;
}
</style>
