import { capitalize } from "lodash";
import { paginationDataStruct } from "./index";
import $http from "../boot/http";

function resolveMutation(name) {
  return (state, data) => (state[name] = data);
}

function resolveGetter(name) {
  return state => state[name] || paginationDataStruct;
}

function resolveAction(
  name,
  { url, method, loadingKey, getterKey, mutationKey }
) {
  return async ({ getters, dispatch, commit }, params = {}) => {
    await dispatch("toggleLoading", { key: loadingKey }, { root: true });

    const oldData = getters[getterKey];

    const httpOptions = {};
    if (method == "get") {
      httpOptions[params] = { page: 1, limit: 15, ...params };
    } else {
      httpOptions;
    }
    const { data } = await $http({
      url,
      method,
      params: method == "get" ? { page: 1, limit: 15, ...params } : {},
      data: method != "get" ? params : {}
    });

    await dispatch(
      "toggleLoading",
      { key: loadingKey, loading: false },
      { root: true }
    );

    commit(mutationKey, {
      ...data,
      data: (data.current_page != 1 ? oldData.data : []).concat(data.data),
      has_next_page: data.last_page > data.current_page
    });

    return data;
  };
}

export function mapStore(
  name,
  {
    url,
    method = "get",
    loadingKey = name,
    stateKey = name,
    mutationKey = "set" + capitalize(stateKey),
    getterKey = name,
    actionKey = "load" + capitalize(stateKey),
    mutation = resolveMutation(name),
    getter = resolveGetter(name),
    action = resolveAction(name, {
      url,
      method,
      loadingKey,
      getterKey,
      mutationKey
    })
  } = {}
) {
  const store = {
    state: {
      [stateKey]: false
    },
    mutations: {},
    getters: {},
    actions: {}
  };

  if (mutation !== false) {
    store.mutations[mutationKey] = mutation;
  }

  if (getter !== false) {
    store.getters[getterKey] = getter;
  }

  if (action !== false) {
    store.actions[actionKey] = action;
  }

  return store;
}
