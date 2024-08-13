<template>
  <div class="card-list-data">
      <div class="row row-cols-1 row-cols-md-2" v-if="!IS_LOADER">
          <div class="col" v-for="(item, index) in serviceList" :key="item">

              <div class="iq-widget">
                  <input type="radio" :id="item.name + item.id" name="radio" :value="item.id" v-model="service_id" class="btn-check" @change="onChange"/>
                  <label :for="item.name + item.id" class="d-block w-100">
                      <div class="card iq-branch-box">
                          <div class="card-body">
                              <div class="text-center mb-4">
                                  <div class="branch-image">
                                      <img :src="item.feature_image" class="avatar-70 rounded-circle" alt="feature-image" loading="lazy">
                                  </div>
                                  <div class="branch-content mt-3 mt-sm-0">
                                      <h4 class="mb-1">{{ item.name || 'No Branch' }}</h4>
                                     
                                  </div>
                              </div>
                             
                          </div>
                      </div>
                  </label>
              </div>
          </div>
      </div>
      <div v-else class="row row-cols-1 row-cols-md-2">
          <div class="col" v-for="index in 4" :key="index">
              <div class="iq-widget card card-skeleton">
                  <div class="card-body">
                      <div class="text-center mb-4">
                          <div class="skeleton skeleton-image avatar-70 m-auto rounded-circle">
                          </div>
                          <div class="mt-3 mt-sm-0">
                              <h4 class="skeleton skeleton-title w-50 mb-3"></h4>
                          </div>
                      </div>
            
                  </div>
              </div>
          </div>
      </div>
      <div class="h-100 w-75 d-flex align-items-center justify-content-center" v-if="serviceList.length == 0 && !IS_LOADER">
        We apologize, but currently, there are no available Services for booking appointments.
      </div>
  </div>
  <div class="card-footer">
      <button type="button" class="btn btn-secondary iq-text-uppercase" v-if="wizardPrev" @click="prevTabChange(wizardPrev)">Back</button>
    <button type="button" class="btn btn-primary iq-text-uppercase" :disabled="service_id !== null ? false : true" v-if="wizardNext" @click="nextTabChange(wizardNext)">Next</button>
  </div>
</template>
<script setup>
// Library Import
import { ref, onMounted, watch } from 'vue'

// Custom Hooks Import
import { useRequest } from '@/helpers/hooks/useCrudOpration'

// Store Import
import {useQuickBooking} from '../../store/quick-booking'

// URL Constant Import
import { SERVICE_LIST } from '@/vue/constants/quick_booking'

// Props & Emits
const props = defineProps({
wizardNext: {
  default: '',
  type: [String, Number]
},
wizardPrev: {
  default: '',
  type: [String, Number]
},
})
const emit = defineEmits(['tab-change', 'onReset'])

// List, Store, Update, Get Data Request Hook
const {  listingRequest } = useRequest()

// Variables
const serviceList = ref([]);
const service_id = ref(null)
const IS_LOADER = ref(true)

// Mounted
onMounted(() => {
  geServicelist()
})

// Functions
const geServicelist = () => {
  IS_LOADER.value = true
  listingRequest({ url: SERVICE_LIST}).then((res) => {
      IS_LOADER.value = false
      serviceList.value = res.data
})
}

// Store
const store = useQuickBooking()

// On Change Next
const onChange = () => {
  emit('tab-change', props.wizardNext)
}
// Next & Prev Function
const nextTabChange = (val) => (emit('tab-change', val))
const prevTabChange = (val) => {
  resetData()
  emit('tab-change', val)
}

// Reset Data Function
const resetData = () => {
  service_id.value = null
}

// Watch
watch(() => service_id.value, (value) => {
store.updateBookingValues(
  {key: 'service_id',value: value}
)
}, {deep: true})
watch(() => store.bookingResponse, (value) => {
resetData()
}, {deep: true})

</script>
<!-- Scoped styles it will work only on this component-->
<style scoped>
  .card-list-data {
      position: relative;
      padding-top: 10px;
      padding-right: 10px;
  }
  .iq-branch-box {
      cursor: pointer;
      border: 1px solid var(--bs-border-color);
      transition: all 0.5s ease-in-out;
      animation: fade-in 0.75s ease-in-out both;
  }

  .iq-branch-box:hover {
      border-color: var(--bs-primary);
      transform: translateY(-5px);
  }

  .iq-branch-box::after {
      position: absolute;
      content: "";
      background: var(--bs-primary) url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='m6 10 3 3 6-6'/%3e%3c/svg%3e");
      height: 23px;
      width: 23px;
      border: 2px solid var(--bs-white);
      top: -7px;
      left: auto;
      right: -7px;
      border-radius: 100%;
      opacity: 0;
      transition: all 0.5s ease-in-out;
  }

  .iq-widget .btn-check:checked + label .iq-branch-box {
      border-color: var(--bs-primary);
      background: rgba(var(--bs-primary-rgb), 0.1);
  }

  .iq-widget .btn-check:checked + label .iq-branch-box::after {
      opacity: 1;
  }

  .iq-branch-box .card-body {
      padding: 20px;
  }
  .iq-contact-detail p {
      font-size: 14px;
  }
  .iq-branch-for {
      position: absolute;
      top: 10px;
      left: auto;
      right: 15px;
  }
</style>
