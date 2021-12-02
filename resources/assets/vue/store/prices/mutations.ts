import Vue from 'vue';

const SET_PRICES = (state, payload) => {
  state.prices = payload;
  state.pricesArray = [];
  state.yearsArray = [];
  payload.forEach(price => state.pricesArray.push(price.price));
  payload.forEach(price => state.yearsArray.push(price.year));
};

const ADD_PRICE = (state, payload) => {
  state.prices.unshift(payload);
};

const UPDATE_PRICE = (state, payload) => {
  const idx = state.prices.findIndex(u => u.id === payload.id);

  if (idx >= 0) {
    Vue.set(state.prices, idx, payload);
  }
};

const DELETE_PRICE = (state, payload) => {
  const idx = state.prices.findIndex(u => u.id === payload.id);

  if (idx >= 0) {
    Vue.delete(state.prices, idx);
  }
};

const SET_LOADING = (state, payload) => {
  state.isLoading = payload;
};

const SET_MODAL_ADD = (state, payload) => {
  state.isModalAdd = payload;
};

const SET_MODAL_LOADING = (state, payload) => {
  state.isModalLoading = payload;
};

const SET_MODAL_VISIBLE = (state, payload) => {
  state.isModalVisible = payload;
};

const SET_FORM = (state, payload) => {
  state.form = payload;
};

export default {
  SET_PRICES,
  ADD_PRICE,
  UPDATE_PRICE,
  DELETE_PRICE,
  SET_LOADING,
  SET_MODAL_LOADING,
  SET_MODAL_VISIBLE,
  SET_FORM,
  SET_MODAL_ADD,
};
