<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import {Action} from 'vuex-class';


@Component({})
export default class Example extends Vue {
  @Action setBackUrl;
  @Action setMenu;
  @Action setDialogMessage;


  async created() {
    this.setBackUrl('/');
    this.setMenu([]);
  }

}
</script>

<template lang="pug">
  b-container(tag='main' fluid)
</template>
