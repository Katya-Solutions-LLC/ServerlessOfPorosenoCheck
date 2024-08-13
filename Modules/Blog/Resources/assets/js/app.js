import { InitApp } from '@/helpers/main'
import BlogsOffcanvas from './components/BlogsOffcanvas.vue'

// import FormOffcanvas from './components/FormOffcanvas.vue'

const app = InitApp()

// app.component('form-offcanvas', FormOffcanvas)
app.component('blogs-offcanvas', BlogsOffcanvas)

app.mount('[data-render="app"]');
