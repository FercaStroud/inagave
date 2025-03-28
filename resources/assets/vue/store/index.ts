import Vue from 'vue';

import 'promise-polyfill/src/polyfill';
import Vuex from 'vuex';

import actions from './actions';
import getters from './getters';
import mutations from './mutations';
import state from './state';

import messages from './messages';
import users from './users';
import products from './products';
import payments from './payments';
import prices from './prices';
import settings from './settings';
import wallets from './wallets';
import maintenances from './maintenances';
import percentages from './percentages';
import auth from './auth';

Vue.use(Vuex);

const modules = {
  messages,
  users,
  products,
  payments,
  prices,
  settings,
  wallets,
  maintenances,
  percentages,
  auth,
};

const store = new Vuex.Store({
  modules,
  actions,
  getters,
  mutations,
  state,
});

export default store;
