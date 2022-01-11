import Vue from 'vue';

const SET_PRODUCTS = (state, payload) => {
  state.products = payload;
};

const SET_PRODUCT_IMAGES = (state, payload) => {
  (state.products).forEach((data, key) => {
    if (data.id === payload[0].product_id) {
      state.products[key].images = payload;
    }
  });
};

const ADD_PRODUCT = (state, payload) => {
  state.products.unshift(payload);
};

const ADD_PRODUCT_IMAGE = (state, payload) => {
  (state.products).forEach((data, key) => {
    if (data.id === parseInt(payload.product_id, 10)) {
      if (state.products[key].images === undefined) {
        state.products[key].images = [];
      }
      (state.products[key].images).unshift(payload);
    }
  });
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

const DELETE_PRODUCT_IMAGE = (state, payload) => {
  let idx;
  (state.products).forEach((data, key) => {
    if (data.id === payload.product_id) {
      idx = (state.products[key].images).findIndex(u => u.id === payload.id);
      if (idx >= 0) {
        Vue.delete(state.products, idx);
      }
    }
  });
};

const SET_SELECTED_PRICE = (state, payload) => {
  state.selectedPrice = payload;
};

const SET_LOADING = (state, payload) => {
  state.isLoading = payload;
};

const SET_MODAL_ADD = (state, payload) => {
  state.isModalAdd = payload;
};

const SET_PRODUCT_IMAGE_MODAL_ADD = (state, payload) => {
  state.isProductImageModalAdd = payload;
};

const SET_MODAL_LOADING = (state, payload) => {
  state.isModalLoading = payload;
};

const SET_PRODUCT_IMAGES_MODAL_LOADING = (state, payload) => {
  state.isProductImageModalLoading = payload;
};

const SET_MODAL_VISIBLE = (state, payload) => {
  state.isModalVisible = payload;
};

const SET_PRODUCT_IMAGES_MODAL_VISIBLE = (state, payload) => {
  state.isProductImageModalVisible = payload;
};

const SET_FORM = (state, payload) => {
  state.form = payload;
};

const SET_PRODUCT_IMAGE_FORM = (state, payload) => {
  state.productImageForm = payload;
};

export default {
  SET_PRODUCTS,
  SET_PRODUCT_IMAGES,
  ADD_PRODUCT,
  ADD_PRODUCT_IMAGE,
  UPDATE_PRODUCT,
  DELETE_PRODUCT,
  DELETE_PRODUCT_IMAGE,
  SET_LOADING,
  SET_MODAL_LOADING,
  SET_PRODUCT_IMAGES_MODAL_LOADING,
  SET_MODAL_VISIBLE,
  SET_PRODUCT_IMAGES_MODAL_VISIBLE,
  SET_FORM,
  SET_PRODUCT_IMAGE_FORM,
  SET_MODAL_ADD,
  SET_PRODUCT_IMAGE_MODAL_ADD,
  SET_SELECTED_PRICE,
};
