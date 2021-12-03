import axios from 'axios';
import checkResponse from '@/utils/checkResponse';

const loadWallets = async ({ commit }, payload) => {
  commit('SET_LOADING', true);

  try {
    const response = await axios.get('wallets');
    const checkErrors = checkResponse(response);

    if (checkErrors) {
      commit('SET_DIALOG_MESSAGE', checkErrors.message, { root: true });
    } else {
      commit('SET_WALLETS', response.data);
    }
  } catch (e) {
    commit('SET_DIALOG_MESSAGE', 'errors.generic_error', { root: true });
  } finally {
    commit('SET_LOADING', false);
  }
};

const loadUserWallet = async ({ commit }, payload) => {
  commit('SET_LOADING', true);

  try {
    const response = await axios.get('get/user/wallet');
    const checkErrors = checkResponse(response);

    if (checkErrors) {
      commit('SET_DIALOG_MESSAGE', checkErrors.message, { root: true });
    } else {
      commit('SET_WALLETS', response.data);
    }
  } catch (e) {
    commit('SET_DIALOG_MESSAGE', 'errors.generic_error', { root: true });
  } finally {
    commit('SET_LOADING', false);
  }
};

const editWallet = async ({ commit }, payload) => {
  const wallet = {
    status: payload.status,
  };

  commit('SET_MODAL_LOADING', true);

  try {
    const response = await axios.put(`wallet/${payload.id}`, wallet);
    const checkErrors = checkResponse(response);

    if (checkErrors) {
      commit('SET_DIALOG_MESSAGE', checkErrors.message, { root: true });
    } else {
      commit('UPDATE_WALLET', response);
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

const setLoading = ({ commit }, payload) => {
  commit('SET_LOADING', payload);
};

export default {
  loadWallets,
  loadUserWallet,
  editWallet,
  setForm,
  setModalAdd,
  setModalVisible,
  setLoading,
};
