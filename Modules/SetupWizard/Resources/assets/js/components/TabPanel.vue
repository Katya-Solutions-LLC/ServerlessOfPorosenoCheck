<template>
  <form action="#category">
    <div class="d-flex justify-content-between align-items-center">
      <h4>{{ title }}</h4>
    </div>
    <hr />
    <component :is="dynamicComponent"></component>
    <div class="card-footer">
      <button type="close" class="btn btn-danger iq-text-uppercase" v-if="wizardPrev" @click="nextTabChange(wizardPrev)">Back</button>
      <button type="submit" class="btn btn-primary iq-text-uppercase" v-if="wizardNext" @click="nextTabChange(wizardNext)">Next</button>
    </div>
  </form>
</template>
<script setup>
// Library
import { computed } from 'vue'

// Components
import NotFound from './NotFound.vue'
import DatabaseConnection from './SetupComponent/DatabaseConnection.vue'
import SalonRegistration from './SetupComponent/SalonRegistration.vue'
import AdminRegistration from './SetupComponent/AdminRegistration.vue'
import Branches from './SetupComponent/Branches.vue'
import Services from './SetupComponent/Services.vue'
import Staff from './SetupComponent/Staff.vue'
import Finished from './SetupComponent/Finished.vue'

const props = defineProps({
  wizardNext: {
    default: '',
    type: [String, Number]
  },
  wizardPrev: {
    default: '',
    type: [String, Number]
  },
  type: {
    type: String
  },
  title: {
    type: String
  }
})

const dynamicComponent = computed(() => {
  switch (props.type) {
    case 'database-connection':
      return DatabaseConnection
      break

    case 'salon-registration':
      return SalonRegistration
      break

    case 'admin-registration':
      return AdminRegistration
      break

    case 'salon-branches':
      return Branches
      break

    case 'salon-services':
      return Services
      break

    case 'salon-staff':
      return Staff
      break

    case 'setup-finished':
      return Finished
      break

    default:
      return NotFound
      break
  }
})
const emit = defineEmits(['onClick'])
const nextTabChange = (value) => {
  emit('onClick', value)
}
</script>
