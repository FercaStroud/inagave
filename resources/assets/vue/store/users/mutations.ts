import Vue from 'vue';

const SET_USERS = (state, payload) => {
  state.users = payload.data;

  state.pagination = {
    currentPage: payload.current_page,
    perPage: payload.per_page,
    totalUsers: payload.total,
    totalPages: payload.last_page,
  };
};

const SET_USER_STATS = (state, payload) => {
  state.stats = payload.data;
};

const ADD_USER = (state, payload) => {
  state.users.unshift(payload);
};

const UPDATE_USER = (state, payload) => {
  const idx = state.users.findIndex(u => u.id === payload.id);

  if (idx >= 0) {
    Vue.set(state.users, idx, payload);
  }
};

const DELETE_USER = (state, payload) => {
  const idx = state.users.findIndex(u => u.id === payload.id);

  if (idx >= 0) {
    Vue.delete(state.users, idx);
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

const SET_MODAL_TO_ADD_PRODUCT_VISIBLE = (state, payload) => {
  state.isModalToAddProductVisible = payload;
};

const SET_FORM_PRODUCT = (state, payload) => {
  state.formProduct = payload;
};

export default {
  SET_USERS,
  ADD_USER,
  UPDATE_USER,
  DELETE_USER,
  SET_LOADING,
  SET_MODAL_LOADING,
  SET_MODAL_VISIBLE,
  SET_USER_STATS,
  SET_MODAL_TO_ADD_PRODUCT_VISIBLE,
  SET_FORM_PRODUCT,
};
