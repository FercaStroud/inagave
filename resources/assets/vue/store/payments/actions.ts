import axios from 'axios';
import checkResponse from '@/utils/checkResponse';

const loadUserPayments = async ({ commit }, payload) => {
  commit('SET_LOADING', true);

  try {
    const response = await axios.get('get/user/payments');
    const checkErrors = checkResponse(response);

    if (checkErrors) {
      commit('SET_DIALOG_MESSAGE', checkErrors.message, { root: true });
    } else {
      commit('SET_PAYMENTS', response.data);
    }
  } catch (e) {
    commit('SET_DIALOG_MESSAGE', 'errors.generic_error', { root: true });
  } finally {
    commit('SET_LOADING', false);
  }
};

const loadAllPayments = async ({ commit }, payload) => {
  commit('SET_LOADING', true);

  try {
    const response = await axios.get('get/all/payments');
    const checkErrors = checkResponse(response);

    if (checkErrors) {
      commit('SET_DIALOG_MESSAGE', checkErrors.message, { root: true });
    } else {
      commit('SET_PAYMENTS', response.data);
    }
  } catch (e) {
    commit('SET_DIALOG_MESSAGE', 'errors.generic_error', { root: true });
  } finally {
    commit('SET_LOADING', false);
  }
};

export default {
  loadUserPayments,
  loadAllPayments,
};
