<template>
    <div class="card bg-base-100 shadow rounded">
        <div class="card-body">
            <form @submit.prevent="submit">
                <div class="card-title mt-3">Name</div>
                <input type="text" placeholder="Name" class="input input-bordered w-full max-w-xs" v-model="name" />
                <div class="card-title mt-3">Pages</div>
                <input-repeater ref="repeater"></input-repeater>
                <div class="card-title mt-3">Settings</div>
                <div class="flex">
                    <label class="label bold-weight-bold">How often to look for changes?</label>
                    <label class="label cursor-pointer">
                        <span class="label-text mr-1">Everyday</span>
                        <input type="radio" name="update_range" value="1" v-model="settings.update_range" class="radio checked:bg-red-500" />
                    </label>
                    <label class="label cursor-pointer">
                        <span class="label-text mr-1">Every week</span>
                        <input type="radio" name="update_range" value="7" v-model="settings.update_range" class="radio checked:bg-blue-500" />
                    </label>
                    <label class="label cursor-pointer">
                        <span class="label-text mr-1">Every month</span>
                        <input type="radio" name="update_range" value="30" v-model="settings.update_range" class="radio checked:bg-green-500" />
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
                update_range: 30,
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
    mounted() {
        // this.repeater = this.$refs.repeater.pages;
    }
}
</script>

<style scoped>

</style>
