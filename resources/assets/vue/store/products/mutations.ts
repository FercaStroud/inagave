import Vue from 'vue';

const SET_PRODUCTS = (state, payload) => {
  state.products = payload.data;
};

const ADD_PRODUCT = (state, payload) => {
  state.products.unshift(payload);
};

const UPDATE_PRODUCT = (state, payload) => {
  const idx = state.products.findIndex(u => u.id === payload.id);

  if (idx >= 0) {
    Vue.set(state.products, idx, payload);
  }
};

const DELETE_PRODUCT = (state, payload) => {
  const idx = state.products.findIndex(u => u.id === payload.id);

  if (idx >= 0) {
    Vue.delete(state.products, idx);
  }
};

const SET_LOADING = (state, payload) => {
  state.isLoading = payload;
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
  SET_PRODUCTS,
  ADD_PRODUCT,
  UPDATE_PRODUCT,
  DELETE_PRODUCT,
  SET_LOADING,
  SET_MODAL_LOADING,
  SET_MODAL_VISIBLE,
  SET_FORM,
};
