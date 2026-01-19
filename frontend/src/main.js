import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

// Import global CSS
import './assets/css/main.css'

const app = createApp(App)

app.use(router)
app.mount('#app')
