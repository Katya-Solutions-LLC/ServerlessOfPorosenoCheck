import { InitApp } from '@/helpers/main'
import PettypeOffcanvas from './components/PettypeOffcanvas.vue'
import PetsOffcanvas from './components/PetsOffcanvas.vue'
import BreedOffcanvas from './components/BreedOffcanvas.vue'
import CustomerOffcanvas from './components/CustomerOffcanvas.vue'
import ChangePassword from './components/ChangePassword.vue'
import AssignPetFormOffCanvas from './components/assign/AssignPetFormOffCanvas.vue'
import PetFormOffCanvas from './components/PetFormOffCanvas.vue'
import PetNotesOffcanvas from './components/PetNotesOffcanvas.vue'
import AddPetsNotes from './components/AddPetsNotes.vue'
import SendPushNotification from './components/SendPushNotification.vue'
import VueTelInput from 'vue3-tel-input'
import 'vue3-tel-input/dist/vue3-tel-input.css'




// import FormOffcanvas from './components/FormOffcanvas.vue'

const app = InitApp()

// app.component('form-offcanvas', FormOffcanvas)

app.component('pet-type-offcanvas', PettypeOffcanvas)
app.component('pets-offcanvas', PetsOffcanvas)
app.component('breed-offcanvas', BreedOffcanvas)
app.component('customer-offcanvas', CustomerOffcanvas)
app.component('change-password', ChangePassword)
app.component('assign-pet', AssignPetFormOffCanvas)
app.component('pet-offcanvas', PetFormOffCanvas)
app.component('pet-notes-offcanvas', PetNotesOffcanvas)
app.component('add-pets-notes', AddPetsNotes)
app.component('send-push-notification', SendPushNotification)
app.mount('[data-render="app"]');