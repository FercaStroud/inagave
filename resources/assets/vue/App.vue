<script lang="ts">
import {Component, Vue, Watch} from 'vue-property-decorator';
import {Action, State, namespace} from 'vuex-class';

import BaseAuth from './views/auth/components/BaseAuth.vue';
import TheHeader from './components/TheHeader.vue';

import dialog from '@/utils/dialog';

const aStore = namespace('auth');

@Component({
  components: {
    BaseAuth,
    TheHeader,
  },
})
export default class App extends Vue {
  @Action loadData;
  @State dialogMessage;
  @aStore.State user;

  /**
   * Yeah, I will use emoji here.
   * I recommend Noto Color Emoji font if you use Linux.
   */
  locales = [
    {flag: '🇺🇸', name: 'en', title: 'Switch to English', language: 'English'},
    {flag: '🇪🇸', name: 'es', title: 'Cambiar a Español', language: 'Español'},
  ];

  get activeLocale() {
    return this.$i18n.locale();
  }

  changeLocale(locale: string) {
    this.$i18n.set(locale);
  }

  @Watch('dialogMessage')
  onDialogMessageChange(newVal) {
    if (newVal) {
      dialog(newVal, false);
    }
  }
}
</script>

<template lang="pug">
  .app
    dialogs-wrapper
    div(v-if='user.id')
      the-header
      b-container(fluid)
        b-row
          b-col#sidebar.bg-primary(lg="2" md="3" sm="12")
            small.text-light.font-weight-bold {{ $t('sidebar.shortcuts') }}
            b-list-group(flush)
              b-list-group-item.text-light(to="/products")
                b-icon(icon="layout-text-sidebar" variant="light" size="1em")
                | {{ $t('sidebar.products') }}
              b-list-group-item.text-light(href="#")
                b-icon(icon="people" variant="light" size="1em")
                | Cras justo odio
              b-list-group-item.text-light(href="#")
                b-icon(icon="shop" variant="light" size="1em")
                | Cras justo odio
            #footer-sidebar
              img.img-thumbnail.rounded-circle(
                src='/assets/images/agave.svg'
                alt='Pofile Logo'
                style="max-width:40px;margin-right:10px;float:left"
              )
              .color-white(style="font-size:.8em") {{(user.name).slice(0,17)}}...
              .color-white(style="font-size:.8em") {{(user.email).slice(0,17)}}...
          b-col#home(tag='main' lg="10" md="9" sm="12")
            router-view#router
    router-view#router(v-else)
    .languages
      b-button(
        v-for='(locale, i) in locales',
        :class='{ active: activeLocale === locale.name }',
        :key='i',
        :title='locale.title',
        @click='changeLocale(locale.name)',
      ) {{ locale.flag }}
</template>

<style lang="scss" scoped>
#sidebar {
  height: calc(100vh - 42px);
}


#footer-sidebar {
  width: 100%;
  position: absolute;
  bottom: 0;
  left: 0;
  padding: 15px;
}

.b-icon.bi {
  margin-right: 7px;
  &:hover{
    color:white !important;
  }
}

.list-group-item {
  position: relative;
  display: block;
  padding: 0.2rem 0;
  border: none;

  background: none;
  &:hover{
    color:white;
  }
}

.app {
  height: 100%;

  .languages {
    bottom: 16px;
    position: fixed;
    right: 16px;
    z-index: 2;

    .btn {
      margin-left: 5px;
    }
  }
}

@media (max-width: 767px) {
  #sidebar {
    height: auto;
  }
  #footer-sidebar {
    position: relative;
  }
}
</style>
