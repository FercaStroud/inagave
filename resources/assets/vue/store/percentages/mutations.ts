import Vue from 'vue';

const SET_PERCENTAGES = (state, payload) => {
  state.percentages = payload;
};

const ADD_PERCENTAGE = (state, payload) => {
  state.percentages.unshift(payload);
};

const UPDATE_PERCENTAGE = (state, payload) => {
  const idx = state.percentages.findIndex(u => u.id === payload.id);

  if (idx >= 0) {
    Vue.set(state.percentages, idx, payload);
  }
};

const DELETE_PERCENTAGE = (state, payload) => {
  const idx = state.percentages.findIndex(u => u.id === payload.id);

  if (idx >= 0) {
    Vue.delete(state.percentages, idx);
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
  SET_PERCENTAGES,
  ADD_PERCENTAGE,
  UPDATE_PERCENTAGE,
  DELETE_PERCENTAGE,
  SET_LOADING,
  SET_MODAL_LOADING,
  SET_MODAL_VISIBLE,
  SET_FORM,
  SET_MODAL_ADD,
};
