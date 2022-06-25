import { createApp } from 'vue'
import App from './App.vue'
import PrimeVue from 'primevue/config';
import router from './router'
import store from './store'
import 'primevue/resources/themes/saga-blue/theme.css'       //theme
import 'primevue/resources/primevue.min.css'                 //core css
import 'primeicons/primeicons.css'     
import ConfirmationService from 'primevue/confirmationservice';
import ToastService from 'primevue/toastservice';
import './index.css'                     //icons
createApp(App).use(store).use(router).use(ConfirmationService).use(ToastService).use(PrimeVue).mount('#app')
