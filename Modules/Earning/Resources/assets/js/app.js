import { InitApp } from '@/helpers/main'

import EarningFormOffcanvas from './components/EarningFormOffcanvas.vue'
import ViewCommissions from './components/ViewCommissions.vue'


const app = InitApp()

app.component('earning-form-offcanvas', EarningFormOffcanvas)
app.component('view-commissions-offcanvas', ViewCommissions)

app.mount('[data-render="app"]');
