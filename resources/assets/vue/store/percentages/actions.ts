import axios from 'axios';
import checkResponse from '@/utils/checkResponse';

const loadPercentages = async ({ commit }, payload) => {
  commit('SET_LOADING', true);

  try {
    const response = await axios.get('percentages');
    const checkErrors = checkResponse(response);

    if (checkErrors) {
      commit('SET_DIALOG_MESSAGE', checkErrors.message, { root: true });
    } else {
      commit('SET_PERCENTAGES', response.data);
    }
  } catch (e) {
    commit('SET_DIALOG_MESSAGE', 'errors.generic_error', { root: true });
  } finally {
    commit('SET_LOADING', false);
  }
};

const addPercentage = async ({ commit }, payload) => {
  const percentage = {
    name: payload.name,
    value: payload.value,
  };

  commit('SET_MODAL_LOADING', true);

  try {
    const response = await axios.post('percentages', percentage);
    const checkErrors = checkResponse(response);
    if (checkErrors) {
      commit('SET_DIALOG_MESSAGE', checkErrors.message, { root: true });
    } else {
      commit('ADD_PERCENTAGE', response.data);
      commit('SET_MODAL_VISIBLE', false);
    }
  } catch {
    commit('SET_DIALOG_MESSAGE', 'errors.generic_error', { root: true });
  } finally {
    commit('SET_MODAL_LOADING', false);
  }
};

const editPercentage = async ({ commit }, payload) => {
  const percentage = {
    value: payload.value,
    name: payload.name,
  };

  commit('SET_MODAL_LOADING', true);

  try {
    const response = await axios.put(`percentage/${payload.id}`, percentage);
    const checkErrors = checkResponse(response);

    if (checkErrors) {
      commit('SET_DIALOG_MESSAGE', checkErrors.message, { root: true });
    } else {
      commit('UPDATE_PERCENTAGE', response);
      commit('SET_MODAL_VISIBLE', false);
    }
  } catch {
    commit('SET_DIALOG_MESSAGE', 'errors.generic_error', { root: true });
  } finally {
    commit('SET_MODAL_LOADING', false);
  }
};

const deletePercentage = async ({ commit }, payload) => {
  try {
    const response = await axios.delete(`percentages/${payload.id}`);
    const checkErrors = checkResponse(response);

    if (checkErrors) {
      commit('SET_DIALOG_MESSAGE', checkErrors.message, { root: true });
    } else {
      commit('DELETE_PERCENTAGE', payload);
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
  loadPercentages,
  setForm,
  setModalAdd,
  addPercentage,
  editPercentage,
  deletePercentage,
  setModalVisible,
};
