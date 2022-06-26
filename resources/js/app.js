require('./bootstrap');

import { createApp } from 'vue';
import Index from './Index';

const app = createApp({});
app
    .component('index', Index)
    .mount('#app');