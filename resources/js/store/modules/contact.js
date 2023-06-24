import {apiClient} from "../../services/Api.js";

const state = {
    all: [],
    query: "",
    model: 'contact',
    modelData: {},
    detail: {},
}

const getters = {
    all: state => state.all,
    query: state => state.query,
    contact: state => state.contact,
    detail: state => state.detail,
}

const actions = {
    fetchData({commit, state}) {
        let query = state.query;
        return new Promise((resolve, reject) => {
            apiClient.get(state.model + "?query=" + query)
                .then(res => {
                    let response = res.data;
                    if (response.data) {
                        commit("setAll", response.data)
                    }
                    resolve(res);
                })
                .catch(err => {
                    reject(err);
                })
                .finally(() => {
                });
        });
    },

    fetchDetail({commit, state}, id) {
        return new Promise((resolve, reject) => {
            apiClient.get(state.model + '/detail/' + id)
                .then(res => {
                    let response = res.data;
                    commit("setDetail", response.data)
                    resolve(res);
                })
                .catch(err => {
                    reject(err);
                })
                .finally(() => {
                });
        });
    },

    store({commit, state}) {
        return new Promise((resolve, reject) => {
            apiClient.post(`${state.model}/store`, state.modelData)
                .then(response => {
                    resolve(response);
                })
                .catch(err => {
                    reject(err);
                })
        })
    },
    update({commit, state}, id) {
        return new Promise((resolve, reject) => {
            apiClient.put(`${state.model}/update/${id}`, state.modelData)
                .then(response => {
                    resolve(response);
                })
                .catch(err => {
                    reject(err);
                })
        })
    }
}

const mutations = {
    setAll(state, items) {
        state.all = items;
    },

    setModalData(state, data) {
        state.modelData = data;
    },

    setDetail(state, data) {
        state.detail = data;
    }
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}
