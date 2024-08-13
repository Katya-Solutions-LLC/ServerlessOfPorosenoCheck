import { InitApp } from '@/helpers/main'
import EventsOffcanvas from './components/EventsOffcanvas.vue'

// import FormOffcanvas from './components/FormOffcanvas.vue'

const app = InitApp()

// app.component('form-offcanvas', FormOffcanvas)
app.component('events-offcanvas', EventsOffcanvas)

app.mount('[data-render="app"]');
