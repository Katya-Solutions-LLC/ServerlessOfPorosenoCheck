import { InitApp } from '@/helpers/main'

import FormOffcanvas from './components/FormOffcanvas.vue'
import LogisticZoneOffcanvas from './components/LogisticZoneOffcanvas.vue'

const app = InitApp()

app.component('form-offcanvas', FormOffcanvas)
app.component('logistic-zone-offcanvas', LogisticZoneOffcanvas)

app.mount('[data-render="app"]');
