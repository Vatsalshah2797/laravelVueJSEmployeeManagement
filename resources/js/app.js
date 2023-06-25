
import './bootstrap';
import { createApp } from 'vue';
//import * as Vue from 'vue' // in Vue 3
import axios from 'axios';
import VueAxios from 'vue-axios';

const app = createApp({});
app.use(VueAxios, axios);

import EmployeeComponent from './components/EmployeeComponent.vue';
app.component('employee-component', EmployeeComponent);

app.mount('#app');
