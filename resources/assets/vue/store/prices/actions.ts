import axios from 'axios';
import checkResponse from '@/utils/checkResponse';

const loadPrices = async ({ commit }, payload) => {
  commit('SET_LOADING', true);

  try {
    const response = await axios.get('prices');
    const checkErrors = checkResponse(response);

    if (checkErrors) {
      commit('SET_DIALOG_MESSAGE', checkErrors.message, { root: true });
    } else {
      commit('SET_PRICES', response.data);
    }
  } catch (e) {
    commit('SET_DIALOG_MESSAGE', 'errors.generic_error', { root: true });
  } finally {
    commit('SET_LOADING', false);
  }
};

const addPrice = async ({ commit }, payload) => {
  const price = {
    price: payload.price,
    year: payload.year,
  };

  commit('SET_MODAL_LOADING', true);

  try {
    const response = await axios.post('prices', price);
    const checkErrors = checkResponse(response);
    if (checkErrors) {
      commit('SET_DIALOG_MESSAGE', checkErrors.message, { root: true });
    } else {
      commit('ADD_PRICE', response.data);
      commit('SET_MODAL_VISIBLE', false);
    }
  } catch {
    commit('SET_DIALOG_MESSAGE', 'errors.generic_error', { root: true });
  } finally {
    commit('SET_MODAL_LOADING', false);
  }
};

const editPrice = async ({ commit }, payload) => {
  const product = {
    price: payload.price,
    year: payload.year,
  };

  commit('SET_MODAL_LOADING', true);

  try {
    const response = await axios.put(`prices/${payload.id}`, product);
    const checkErrors = checkResponse(response);

    if (checkErrors) {
      commit('SET_DIALOG_MESSAGE', checkErrors.message, { root: true });
    } else {
      commit('UPDATE_PRICE', response);
      commit('SET_MODAL_VISIBLE', false);
    }
  } catch {
    commit('SET_DIALOG_MESSAGE', 'errors.generic_error', { root: true });
  } finally {
    commit('SET_MODAL_LOADING', false);
  }
};

const deletePrice = async ({ commit }, payload) => {
  try {
    const response = await axios.delete(`prices/${payload.id}`);
    const checkErrors = checkResponse(response);

    if (checkErrors) {
      commit('SET_DIALOG_MESSAGE', checkErrors.message, { root: true });
    } else {
      commit('DELETE_PRICE', payload);
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

const setModalAdd = ({ commit }, payload) => {
  commit('SET_MODAL_ADD', payload);
};

export default {
  loadPrices,
  setForm,
  setModalAdd,
  addPrice,
  editPrice,
  deletePrice,
  setModalVisible,
};
