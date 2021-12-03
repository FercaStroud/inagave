import axios from 'axios';
import checkResponse from '@/utils/checkResponse';

const loadMaintenances = async ({ commit }, payload) => {
  commit('SET_LOADING', true);

  try {
    const response = await axios.get('maintenances');
    const checkErrors = checkResponse(response);

    if (checkErrors) {
      commit('SET_DIALOG_MESSAGE', checkErrors.message, { root: true });
    } else {
      commit('SET_MAINTENANCES', response.data);
    }
  } catch (e) {
    commit('SET_DIALOG_MESSAGE', 'errors.generic_error', { root: true });
  } finally {
    commit('SET_LOADING', false);
  }
};

export default {
  loadMaintenances,
};
