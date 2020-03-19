<template>
  <q-card class="my-card">
    <q-card-section>
      <q-btn color="green" label="上传" />
      <q-btn color="primary" label="添加目录" />
      <q-btn color="secondary" label="刷新" />
    </q-card-section>

    <q-separator />

    <q-card-actions vertical>
      <q-btn flat>Action 1</q-btn>
      <q-btn flat>Action 2</q-btn>
    </q-card-actions>
    {{loading}}
    <q-inner-loading :showing="loading['media.files']">
      <q-spinner-bars size="50px" color="primary" />
    </q-inner-loading>
  </q-card>
</template>

<script>
import { mapActions, mapState } from "vuex";
export default {
  name: "MediaManager",
  created() {
    this.loadFiles();
  },
  computed: {
    ...mapState(["loading"])
  },
  methods: {
    ...mapActions("media", ["loadFiles"])
  }
};
</script>

<style scoped>
</style>
