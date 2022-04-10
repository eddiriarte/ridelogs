import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import axios from 'axios'

axios.defaults.withCredentials = true

import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.min.css'
import store from './store'

createApp(App).use(store).use(store).use(router).mount('#app')
