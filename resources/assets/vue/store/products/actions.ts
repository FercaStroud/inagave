import axios from 'axios';
import checkResponse from '@/utils/checkResponse';

const loadProducts = async ({ commit }, payload) => {
  commit('SET_LOADING', true);

  try {
    const response = await axios.get('products');
    const checkErrors = checkResponse(response);

    if (checkErrors) {
      commit('SET_DIALOG_MESSAGE', checkErrors.message, { root: true });
    } else {
      commit('SET_PRODUCTS', response);
    }
  } catch (e) {
    commit('SET_DIALOG_MESSAGE', 'errors.generic_error', { root: true });
  } finally {
    commit('SET_LOADING', false);
  }
};

const addProduct = async ({ commit }, payload) => {
  const product = {
    estate: payload.estate,
    size_estate: payload.size_estate,
    plant_age: payload.plant_age,
    municipality: payload.municipality,
    location: payload.location,
    description: payload.description,
    location_url: payload.location_url,
    quantity: payload.quantity,
    price: payload.price,
  };

  commit('SET_MODAL_LOADING', true);

  try {
    const response = await axios.post('products', product);
    const checkErrors = checkResponse(response);
    if (checkErrors) {
      commit('SET_DIALOG_MESSAGE', checkErrors.message, { root: true });
    } else {
      commit('ADD_PRODUCT', response);
      commit('SET_MODAL_VISIBLE', false);
    }
  } catch {
    commit('SET_DIALOG_MESSAGE', 'errors.generic_error', { root: true });
  } finally {
    commit('SET_MODAL_LOADING', false);
  }
};

const editProduct = async ({ commit }, payload) => {
  const product = {
    estate: payload.estate,
    size_estate: payload.size_estate,
    plant_age: payload.plant_age,
    municipality: payload.municipality,
    location: payload.location,
    description: payload.description,
    location_url: payload.location_url,
    quantity: payload.quantity,
    price: payload.price,
  };

  commit('SET_MODAL_LOADING', true);

  try {
    const response = await axios.put(`products/${payload.id}`, product);
    const checkErrors = checkResponse(response);

    if (checkErrors) {
      commit('SET_DIALOG_MESSAGE', checkErrors.message, { root: true });
    } else {
      commit('UPDATE_PRODUCT', response);
      commit('SET_MODAL_VISIBLE', false);
    }
  } catch {
    commit('SET_DIALOG_MESSAGE', 'errors.generic_error', { root: true });
  } finally {
    commit('SET_MODAL_LOADING', false);
  }
};

const deleteProduct = async ({ commit }, payload) => {
  try {
    const response = await axios.delete(`products/${payload.id}`);
    const checkErrors = checkResponse(response);

    if (checkErrors) {
      commit('SET_DIALOG_MESSAGE', checkErrors.message, { root: true });
    } else {
      commit('DELETE_PRODUCT', payload);
      commit('SET_DIALOG_MESSAGE', 'front.deleted_successfully', { root: true });
    }
  } catch {
    commit('SET_DIALOG_MESSAGE', 'errors.generic_error', { root: true });
  }
};

const setModalVisible = ({ commit }, payload) => {
  commit('SET_MODAL_VISIBLE', payload);
};

const setForm = ({ commit }, payload) => {
  commit('SET_FORM', payload);
};

export default {
  loadProducts,
  setForm,
  addProduct,
  editProduct,
  deleteProduct,
  setModalVisible,
};
