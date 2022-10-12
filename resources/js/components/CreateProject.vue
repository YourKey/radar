<template>
    <div class="card bg-base-100 shadow rounded">
        <div class="card-body">
            <form @submit.prevent="submit">
                <div class="card-title mt-3">Project name</div>
                <input type="text" placeholder="Name" class="input input-bordered w-full max-w-xs" v-model="name" />
                <div class="card-title mt-3">Pages for parse</div>
                <input-repeater ref="repeater"></input-repeater>
                <div class="card-title mt-3">Settings</div>
                <div class="form-control">
                    <label class="label font-bold">How often to look for changes?</label>
                    <label class="label cursor-pointer w-52">
                        <span class="label-text mr-1">Everyday</span>
                        <input type="radio" name="update_range" value="24" v-model.number="settings.update_range" class="radio checked:bg-red-500" />
                    </label>
                    <label class="label cursor-pointer w-52">
                        <span class="label-text mr-1">Every week</span>
                        <input type="radio" name="update_range" value="168" v-model.number="settings.update_range" class="radio checked:bg-blue-500" />
                    </label>
                    <label class="label cursor-pointer w-52">
                        <span class="label-text mr-1">Every month</span>
                        <input type="radio" name="update_range" value="720" v-model.number="settings.update_range" class="radio checked:bg-green-500" />
                    </label>
                </div>
                <div class="form-control w-52 mt-2">
                    <div class="font-bold">Telegram notify</div>
                    <label class="label cursor-pointer">
                        <span class="label-text mr-1">🔴 fail parse notify</span>
                        <input type="checkbox" name="telegram_fail_notify" value="true" v-model="settings.telegram_fail_notify" class="checkbox checked:bg-blue-500" />
                    </label>
                    <label class="label cursor-pointer">
                        <span class="label-text mr-1">🟢 success parse notify</span>
                        <input type="checkbox" name="telegram_success_notify" value="true" v-model="settings.telegram_success_notify" class="checkbox checked:bg-blue-500" />
                    </label>
                </div>
                <div class="form-group">
                    <button class="mt-3 btn btn-success" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import InputRepeater from "./InputRepeater";
export default {
    name: "CreateProject.vue",
    components: {
        InputRepeater,
    },
    data() {
        return {
            name: null,
            settings: {
                update_range: 24,
                telegram_fail_notify: true,
                telegram_success_notify: false,
            },
            token: document.querySelector('meta[name="token"]').content,
        }
    },
    methods: {
      submit() {
          const headers = {
              accept: 'application/json',
              Authorization: 'Bearer ' + this.token
          }
          axios.post('/api/v1/projects', {
              name: this.name,
              settings: this.settings,
              pages: this.$refs.repeater.pages
          }, { headers: headers })
          .then(response => {
              if (response.data.redirect) window.location.replace(response.data.redirect);
          }).catch(e => {
              console.log(e);
          })
      }
    },
}
</script>

<style scoped>

</style>
