import axios from 'axios';
import checkResponse from '@/utils/checkResponse';

const loadSettings = async ({ commit }, payload) => {
  commit('SET_LOADING', true);

  try {
    const response = await axios.get('get/all/settings');
    const checkErrors = checkResponse(response);

    if (checkErrors) {
      commit('SET_DIALOG_MESSAGE', checkErrors.message, { root: true });
    } else {
      commit('SET_SETTINGS', response.data);
    }
  } catch (e) {
    commit('SET_DIALOG_MESSAGE', 'errors.generic_error', { root: true });
  } finally {
    commit('SET_LOADING', false);
  }
};

const editSettings = async ({ commit }, payload) => {
  const settings = {
    maintenance: payload.maintenance,
  };

  commit('SET_MODAL_LOADING', true);

  try {
    const response = await axios.post('edit/settings/', settings);
    const checkErrors = checkResponse(response);

    if (checkErrors) {
      commit('SET_DIALOG_MESSAGE', checkErrors.message, { root: true });
    } else {
      commit('SET_SETTINGS', response.data);
      commit('SET_MODAL_VISIBLE', false);
    }
  } catch {
    commit('SET_DIALOG_MESSAGE', 'errors.generic_error', { root: true });
  } finally {
    commit('SET_MODAL_LOADING', false);
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
  loadSettings,
  setForm,
  setModalAdd,
  editSettings,
  setModalVisible,
};
