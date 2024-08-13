<template>
  <div class="card-list-data">
    <div class="course-picker"> 
      <div class="card-light-bg">
        <div><flat-pickr v-model="date" :config="config" @change="dateUpdate"/></div>
      </div>
      <div class="card-light-bg iq-time-slot p-3">
          <div class="iq-time-animation d-grid grid-template-3 gap-3" v-if="timeSlotList.length > 0">
            <template v-if="!IS_LOADER">
              <template v-for="(item, index) in timeSlotList" :key="`items-${index}`">
                <div>
                  <input type="radio" :id="item.value" v-model="start_date_time" :value="item.value" name="radio" class="btn-check" @change="onChange"/>
                  <label :for="item.value" class="btn d-block py-2 px-2">{{ item.label }}</label>
                </div>
              </template>
            </template>
            <template v-else>
                <label v-for="index in 24" :key="index" class="skeleton skeleton-label-box"></label>
            </template>
          </div>

          <div class="iq-time-animation d-grid grid-template-3 gap-3" v-if="timeSlotList.length == 0 && IS_LOADER && date">
            <label v-for="index in 24" :key="index" class="skeleton skeleton-label-box"></label>
          </div>
      
          <div class="h-100 d-flex align-items-center justify-content-center" v-else>
            <p>
              <template v-if="!date">
                Please Select Date
              </template>
              <template v-else-if="timeSlotList.length == 0">
                No Slots Available! Please Select Diffrent Date.
              </template>
            </p>
          </div>
        </div>
    </div>

  </div>
  <div class="card-footer" v-if="timeSlotList.length > 0">
    <button type="button" class="btn btn-secondary iq-text-uppercase" v-if="wizardPrev" @click="prevTabChange(wizardPrev)">Back</button>
    <button type="button" v-if="timeSlotList.length > 0 && wizardNext" class="btn btn-primary iq-text-uppercase" :disabled="start_date_time !== null ? false : true" @click="nextTabChange(wizardNext)">Next</button>
  </div>
</template>
<script setup>
import { ref, watch } from 'vue'
import { useRequest } from '@/helpers/hooks/useCrudOpration'
import {useQuickBooking} from '../../store/quick-booking'
// Select Options List Request
import { SLOT_TIME_LIST } from '@/vue/constants/quick_booking'
import flatPickr from 'vue-flatpickr-component';
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
const date = ref(null);


const config = ref({
    inline: true,
    dateFormat: 'Y-m-d',
    minDate: 'today',
});

const start_date_time = ref(null);

const {  listingRequest } = useRequest()

const store = useQuickBooking()
const timeSlotList = ref([]);
const IS_LOADER = ref(true)

const getSlots = () => {
  IS_LOADER.value = true
    listingRequest({ url: SLOT_TIME_LIST, data: {branch_id: store.booking.branch_id, date: date.value, employee_id: store.booking.employee_id}}).then((res) => {
      setTimeout(() => {
        IS_LOADER.value = false
      timeSlotList.value = res.data
      }, 1000);
  })
}
const dateUpdate = () => {
    getSlots()
}

watch(() => start_date_time.value, (value) => {
  store.updateBookingValues(
    {key: 'start_date_time',value: value}
  )
  store.updateBookingServiceTimeValues(value)
}, {deep: true})
watch(() => store.bookingResponse, (value) => {
  resetData()
}, {deep: true})

// On Change Next
const onChange = () => {
    emit('tab-change', props.wizardNext)
}
const nextTabChange = (val) => (emit('tab-change', val))
const prevTabChange = (val) => {
  resetData()
  emit('tab-change', val)
}

const resetData = () => {
  store.updateBookingValues(
    {key: 'start_date_time',value: null}
  )
  store.updateBookingServiceTimeValues(null)
  start_date_time.value = null
  date.value = null
  timeSlotList.value = []
}
</script>

<style scoped>
.flatpickr-input{
  display:none !important;
}

.booking-wizard .iq-time-slot {
    height: 430px;
    overflow: auto;
}

.booking-wizard .iq-time-slot .iq-time-animation {
  /* -webkit-animation: fade-in-bottom 0.60s ease-in-out both;
  animation: fade-in-bottom 0.60s ease-in-out both; */
}

.course-picker{
  display: grid;
  grid-template-columns: repeat(2, minmax(0%, 1fr));
  gap: 1rem;
}

.course-picker .flatpickr-calendar {
  height: 400px;
  background: transparent;
}
.list-group{
  border-radius: 0;
    gap: 1.5rem;
}
.list-group-item{
  border: var(--bs-list-group-border-width) solid var(--bs-list-group-border-color) !important;
  border-radius: var(--bs-border-radius)
}

.card-light-bg {
    background: rgba(var(--bs-primary-rgb), 0.1);
    padding: 15px;
    border-radius: var(--bs-border-radius);
}

.iq-time-slot label {
  background: var(--bs-white);
  font-size: 12px;
  font-weight: 600;
  width: 100%;
  transition: all 0.5s ease-in-out;
}

.iq-time-slot label:hover,
.iq-time-slot .btn-check:checked + .btn {
  color: var(--bs-white);
  background: var(--bs-primary);
}

@media (max-width: 991px) {
  .course-picker {
    display: block;
  }
}

</style>
