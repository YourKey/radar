<template>
    <div class="card bg-base-100 shadow-xl mb-6">
        <div class="card-body">
            <div class="font-weight-bold flex justify-between">
                <a class="btn btn-link" :title="page.url" :href="page.url" target="_blank">{{ decodeURI(page.url) }}
                    <svg class="ml-1" preserveAspectRatio="xMinYMin" viewBox="0 0 20 20" fill="none" width="1em" height="1em"><path fill-rule="evenodd" clip-rule="evenodd" d="M15.132 15.921H4.079V4.868h4.737V3.29H4.079C3.203 3.29 2.5 4 2.5 4.87V15.92c0 .869.703 1.579 1.579 1.579h11.053c.868 0 1.579-.71 1.579-1.579v-4.737h-1.58v4.737zM11.974 2.5v1.579h2.834L10.395 8.42l1.113 1.113 4.413-4.342v2.834H17.5V2.5h-5.526z" fill="currentColor"></path></svg>
                </a>
                <div>
                    <button @click="createSnapshot(page)" class="btn btn-success mr-2">Run</button>
                    <a :href="page.snapshots_url" class="btn btn-outline gap-2">
                        Snapshots
                        <div class="badge">{{ page.snapshots.length }}</div>
                    </a>
                </div>
            </div>
            <div class="mockup-code mt-3 max-h-96 overflow-auto">
                <pre><code>{{ html }}</code></pre>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "PageCard",
    props: ['page'],
    data() {
      return {
          html: '',
          token: document.querySelector('meta[name="token"]').content,
      };
    },
    mounted() {
        if (this.page.snapshots.length) this.html = this.page.snapshots[0].data;
        console.log(this.page);
    },
    methods: {
        createSnapshot(page) {
            const headers = {
                accept: 'application/json',
                Authorization: 'Bearer ' + this.token
            }
            axios.post('/api/v1/snapshots', page, { headers: headers })
                .then(response => {
                    this.html = response.data.body;
                    console.log(response.data);
                })
        }
    }
}
</script>

<style scoped>

</style>
