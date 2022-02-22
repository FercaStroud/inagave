<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import {Action, namespace} from 'vuex-class';
import ContentDashboard from "@/views/dashboard/components/ContentDashboard.vue";

@Component({
  components: {ContentDashboard}
})
export default class Dashboard extends Vue {
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
  b-container.pb-5(tag='main' fluid)
    ContentDashboard
    b-row.pt-5
</template>
