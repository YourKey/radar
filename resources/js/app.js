import { createApp } from "vue";
import PageCard from "./components/PageCard";
import CreateProject from "./components/CreateProject";


const app = createApp({});
app.component('PageCard', PageCard);
app.component('CreateProject', CreateProject);
app.mount('#app');

require("./bootstrap");
