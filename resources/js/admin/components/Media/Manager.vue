<template>
  <div>
    <q-card class="media-manager" flat bordered>
      <div class="bg-blue-grey-1 q-pl-md q-pr-md">
        <div class="row items-center no-wrap">
          <div class="col">
            <div>Our Planet</div>
          </div>

          <div class="col-auto">
            <q-btn color="green-7" round flat icon="cloud_upload" @click.stop="handleOpenUpload"></q-btn>
          </div>
        </div>
      </div>

      <q-separator />

      <q-card-section horizontal class="row">
        <q-card-section class="col-md-auto" v-if="$q.screen.gt.sm">
          <div style="width: 250px;">123</div>
        </q-card-section>

        <q-separator vertical v-if="$q.screen.gt.sm" />

        <div class="col relative-position">
          <q-card-section class="q-mb-xl">
            <ul class="q-gutter-md row items-start">
              <li v-for="(file, index) in files.data" :key="index" class="q-gutter-md">
                <q-img
                  :src="file.url"
                  style="width: 120px"
                  :ratio="1"
                  basic
                  spinner-color="white"
                  class="rounded-borders"
                >
                  <template v-slot:error>
                    <div
                      class="absolute-full flex flex-center bg-negative text-white"
                    >Cannot load image</div>
                  </template>
                </q-img>
              </li>
            </ul>
          </q-card-section>

          <div class="absolute-bottom">
            <q-pagination
              class="flex flex-center"
              :value="files.current_page"
              @input="handlePage"
              :max="files.last_page"
              input
            />
          </div>
        </div>
      </q-card-section>

      <q-inner-loading :showing="loading['media.files']">
        <q-spinner-bars size="50px" color="primary" />
      </q-inner-loading>
    </q-card>

    <q-dialog v-model="uploadDialogShow">
      <q-uploader label="上传" v-bind="uploadProps" @uploaded="handleUploaded" multiple>
        <template v-slot:list="scope">
          <div v-if="scope.files.length">
            <q-list separator>
              <q-item v-for="file in scope.files" :key="file.name">
                <q-item-section v-if="file.__img" thumbnail class="gt-xs">
                  <img :src="file.__img.src" />
                </q-item-section>

                <q-item-section>
                  <q-item-label class="full-width ellipsis">{{ file.name }}</q-item-label>

                  <q-item-label caption>Status: {{ file.__status }}</q-item-label>

                  <q-item-label caption>{{ file.__sizeLabel }} / {{ file.__progressLabel }}</q-item-label>
                </q-item-section>

                <q-item-section top side>
                  <q-btn
                    class="gt-xs"
                    size="12px"
                    flat
                    dense
                    round
                    icon="delete"
                    @click="scope.removeFile(file)"
                  />
                </q-item-section>
              </q-item>
            </q-list>
          </div>
        </template>
      </q-uploader>
    </q-dialog>
  </div>
</template>

<script>
import { mapActions, mapState, mapGetters } from "vuex";
import G from "../../boot/global";

export default {
  name: "MediaManager",
  data() {
    return {
      uploadDialogShow: false
    };
  },
  created() {
    this.getFiles();
  },
  computed: {
    ...mapState(["loading"]),
    ...mapGetters("media", ["files"]),
    currentPage: {
      get() {
        return this.files.current_page;
      },
      set(val) {
        this.handleRefresh();
      }
    },
    uploadProps() {
      return {
        autoUpload: true,
        url: G.url.media.upload,
        method: "POST",
        "field-name": "file",
        headers: Object.keys(this.$http.defaults.headers.common).map(key => ({
          name: key,
          value: this.$http.defaults.headers.common[key]
        }))
      };
    }
  },
  methods: {
    ...mapActions("media", ["loadFiles"]),

    async handleOpenUpload() {
      this.uploadDialogShow = true;
    },

    async handleUploaded() {
      this.uploadDialogShow = false;
      this.handleRefresh();
    },

    async handleRefresh() {
      this.getFiles({ page: this.files.current_page });
    },

    async handlePage(page) {
      this.getFiles({ page });
    },

    async getFiles({ page = 1 } = {}) {
      this.loadFiles({ page });
    }
  }
};
</script>

<style lang="scss" scoped>
</style>
