<template>
    <div class="mt-2" v-for="(page, key) in pages">
        <div class="badge badge-outline h-6 w-6">{{ key+1 }}</div>
        <input type="text" placeholder="URL" class="input input-bordered w-full max-w-xs ml-3" v-model="page.url" />
        <input type="text" placeholder="Find Selector" class="input input-bordered w-full max-w-xs ml-3" v-model="page.filters.selector" />
        <input type="text" placeholder="Remove Selector" class="input input-bordered w-full max-w-xs ml-3" v-model="page.filters.removeSelector" />
        <label class="ml-2 label-text cursor-pointer">
            html
            <input type="radio" value="html" v-model="page.filters.type" class="radio" />
        </label>
        <label class="label-text cursor-pointer">
            text
            <input type="radio" value="text" v-model="page.filters.type" class="radio" />
        </label>
        <button @click.prevent="removeInput(key)" class="btn btn-error btn-circle btn-sm ml-6">×</button>
    </div>
    <button @click.prevent="addInput" class="btn btn-primary mt-2">+ add page</button>
</template>

<script>
export default {
    name: "InputRepeater",
    data() {
        return {
            pages: [],
        }
    },
    methods: {
        addInput() {
            this.pages.push({
                url: null,
                filters: {
                    template: null,
                    selector: null,
                    removeSelector: null,
                    type: 'html',
                }
            });
        },
        removeInput(index)
        {
            this.pages.splice(index, 1);
        },
    },
    mounted() {
        this.addInput();
    }
}
</script>

<style scoped>

</style>
