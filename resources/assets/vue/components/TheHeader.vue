<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import {State, namespace} from 'vuex-class';
import {BIconArrowLeftShort, BIconGithub} from 'bootstrap-vue';

import TheMessageBadge from '../views/messages/components/TheMessageBadge.vue';
import TheSettings from './TheSettings.vue';

const aStore = namespace('auth');

@Component({
  components: {
    TheSettings,
    TheMessageBadge,
    BIconArrowLeftShort,
    BIconGithub,
  },
})
export default class TheHeader extends Vue {
  @State backUrl;
  @State menu;
  @aStore.State user;
  @aStore.Action logout;

  showSettings(): void {
    (<any>this.$refs.the_settings).$refs.modal.show();
  }

  get homePath() {
    return this.user.home_path;
  }

  get path(): string {
    return this.$route.name || '';
  }
}
</script>

<template lang="pug">
  div
    b-navbar.navbar-expand-lg.bg-light.shadow(
      type='light'
      toggleable="lg"
      style='background-color: #f8f9fa;z-index:1;'
    )
      b-link.back-button.text-secondary(v-show='path !== homePath', :to='backUrl')
        b-icon-arrow-left-short(style='width: 30px; height: 30px;')

      b-navbar-brand(:to='homePath', :class='{"has-back": path !== homePath}')
        img.d-inline-block.align-top(
          src='/assets/images/agave.svg',
          alt='Logo',
          height=31,
          style="margin-right:5px"
        )
        span(style="font-size:1em") Administración

      b-navbar-toggle(target='nav_collapse')

      b-collapse#nav_collapse(is-nav)
        b-navbar-nav.ml-auto
          b-nav-item.border-navigator(
            v-if="user.type_id === 2"
            to="/store"
          )
            img.icon-navigator(src="/assets/images/store.png" :alt="$t('strings.store')")
            | {{ $t('strings.store') }}

          b-nav-item.border-navigator(
            v-if="user.type_id === 2"
          )
            img.icon-navigator(src="/assets/images/cash.png" :alt="$t('strings.withdraws')")
            | {{ $t('strings.withdraws') }}

          b-nav-item.border-navigator(
            v-if="user.type_id === 2"
          )
            img.icon-navigator(src="/assets/images/care.png" :alt="$t('strings.care')")
            | {{ $t('strings.care') }}

          b-nav-item.border-navigator(
            v-if="user.type_id === 2"
          )
            img.icon-navigator(src="/assets/images/payment.png" :alt="$t('strings.payments')")
            | {{ $t('strings.payments') }}

          b-nav-item.menu(
            v-for='item in menu',
            :key='item.key',
            @click.prevent='item.handler',
            href='#',
          ) {{ $t(item.text) }}

          b-nav-item-dropdown(:text='user.name' dropleft)
            b-dropdown-item(
              @click='showSettings',
            ) {{ $t('strings.settings') }}

            b-dropdown-item(
              @click='logout',
            ) {{ $t('home.logout') }}

          b-nav-item(
            v-if="user.type_id === 1"
            v-b-toggle.sidebar
          ) {{ $t('strings.menu') }}

    b-sidebar(
      v-if="user.type_id === 1"
      id="sidebar"
      title="Sidebar"
      shadow
      ria-labelledby='sidebar-no-header-title'
      no-header
      bg-variant="primary"
    )
      .bg-white
        b-container
          b-navbar-brand(:to='homePath', :class='{"has-back": path !== homePath}')
            img.d-inline-block.align-top(
              src='/assets/images/agave.svg',
              alt='Logo',
              height=31,
              style="margin-right:5px"
            )
            span(style="font-size:1em;color:black") Administración

      b-container.mt-5.small.text-light.font-weight-bold {{ $t('sidebar.shortcuts') }}
        b-list-group(flush)
          b-list-group-item.text-light(to="/users")
            b-icon(icon="people" variant="light" size="1em")
            | {{ $t('sidebar.users') }}
          b-list-group-item.text-light(to="/products")
            b-icon(icon="layout-text-sidebar" variant="light" size="1em")
            | {{ $t('sidebar.products') }}
          b-list-group-item.text-light(href="#")
            b-icon(icon="shop" variant="light" size="1em")
            | Cras justo odio

    the-settings(ref='the_settings')
</template>

<style scoped lang="scss">
.border-navigator {
  margin-right: 10px;

  a {
    transition-duration: .2s;

    &:hover {
      color: #3A7C8D !important;
    }
  }
}

.icon-navigator {
  margin-right: 7px;
}

.has-back {
  padding-left: 15px;
}

.github-link a {
  display: flex;
  align-items: center;
}

.b-icon.bi {
  margin-right: 7px;

  &:hover {
    color: white !important;
  }
}

.list-group-item {
  position: relative;
  display: block;
  padding: 0.2rem 0;
  border: none;

  background: none;

  &:hover {
    color: white;
  }
}
.navbar{
  height:42px
}
@media (max-width: 991px) {
  .navbar{
    height:initial;
  }
}
</style>
