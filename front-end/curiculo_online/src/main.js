import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

import './assets/css/main.css'

import 'bootstrap/dist/css/bootstrap.min.css'
import './assets/css/all.min.css'

import jQuery from "jquery"
$ =window.$ = window.jQuery = jQuery;

import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;
window.Modal = bootstrap.Modal;

const app = createApp(App)

app.use(router)

app.mount('#app')
