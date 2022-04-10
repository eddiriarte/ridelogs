//store/modules/auth.js

import axios from 'axios';

const state = {
  user: 'eiriarte',
}

const getters = {
  isAuthenticated: state => !!state.user,
}

const actions = {
  async LogIn ({commit}, user) {
    await axios.post('login', user)
    await commit('setUser', user.get('username'))
  },
  async LogOut ({commit}) {
    await axios.post('logout')
    await commit('setUser', null)
  },
}

const mutations = {
  setUser (state, username) {
    state.user = username
  },
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
}
