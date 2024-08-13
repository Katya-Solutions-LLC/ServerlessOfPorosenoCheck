// import "./calender"
import { InitApp } from '@/helpers/main'
import { createPinia } from 'pinia'

import BookingForm from './components/BookingForm.vue'
import VatForm from './components/VatBookingForm.vue'
import GroomerForm from './components/GroomerBookingForm.vue'
import TrainerForm from './components/TrainerBookingForm.vue'
import WalkerForm from './components/WalkerBookingForm.vue'
import DayCareForm from './components/DayCareBookingForm.vue'

import VueTelInput from 'vue3-tel-input'
import 'vue3-tel-input/dist/vue3-tel-input.css'


const pinia = createPinia()
const app = InitApp()

app.component('vat-form', VatForm)
app.component('groomer-form', GroomerForm)
app.component('trainer-form', TrainerForm)
app.component('walker-form', WalkerForm)
app.component('daycare-form', DayCareForm)
app.component('booking-form', BookingForm)

app.use(pinia)
app.mount('[data-render="app"]');
