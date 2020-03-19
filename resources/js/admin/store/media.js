import { merge } from "lodash";
import { mapStore } from "../utils/store";

export default merge(
  {
    namespaced: true,
    state: {},
    mutations: {},
    getters: {},
    actions: {}
  },
  mapStore("files", { url: "/api/admin/v1/media", loadingKey: "media.files" })
);
