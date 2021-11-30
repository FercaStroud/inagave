import Vue from 'vue';

const SET_SETTINGS = (state, payload) => {
  state.settings = payload;
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
  SET_SETTINGS,
  SET_LOADING,
  SET_MODAL_LOADING,
  SET_MODAL_VISIBLE,
  SET_FORM,
  SET_MODAL_ADD,
};
