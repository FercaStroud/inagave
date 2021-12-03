import Vue from 'vue';

const SET_MAINTENANCES = (state, payload) => {
  state.maintenances = payload;
};

const SET_LOADING = (state, payload) => {
  state.isLoading = payload;
};

export default {
  SET_MAINTENANCES,
  SET_LOADING,
};
