<template>
  <div ref="calenderRef"></div>
  <booking-form :booking-type="bookingType"
                :status-list="bookingStatus"
                @onSubmit="onSubmitEvent"
                :booking-data="bookingData"></booking-form>
</template>
<script setup>
import { reactive, ref, onMounted, onUnmounted, watch } from 'vue'
import { createRequest } from '@/helpers/utilities'

import Calendar from '@event-calendar/core'
import DayGrid from '@event-calendar/day-grid'
import List from '@event-calendar/list'
import TimeGrid from '@event-calendar/time-grid'
import ResourceTimeGrid from '@event-calendar/resource-time-grid'
import Interaction from '@event-calendar/interaction'


import BookingForm from './BookingForm.vue'
import { INDEX_URL } from '../constant/booking'
import * as moment from 'moment'

const props = defineProps({
  status: { type: String, required: true },
  slotDuration: { type: String },
  branchId: {type: [String , Number]},
  date: new Date()
})
let slotsDurations = '00:15'
if(props.slotDuration !== '') {
  slotsDurations = props.slotDuration
}
const bookingStatus = ref(JSON.parse(props.status))
const calenderRef = ref(null)
const calenderInit = ref(null)
const bookingType = ref('')
const bookingData = reactive({
  id: 0,
  start_date_time: null,
  employee_id: null,
  branch_id: props.branchId
})

const setBooking = (info) => {
  bookingData.id = info.id || 0
  bookingData.employee_id = info?.resource?.id || null
  bookingData.start_date_time = info.date || null
}

const showBookingForm = (info) => {
  bookingType.value = 'CALENDER_BOOKING'
  const elem = document.getElementById('booking-form')
  setBooking(info)
  const form = bootstrap.Offcanvas.getOrCreateInstance(elem)
  form.show()
  document.querySelector('.offcanvas-backdrop')?.remove()
  updateBodyClass('show')
}

const hideBookingForm = () => {
  const elem = document.getElementById('booking-form')
  const form = bootstrap.Offcanvas.getOrCreateInstance(elem)
  form.hide()
  updateBodyClass('hide')
}

const updateBodyClass = (value = 'hide') => {
  if(value == 'show') {
    document.body.classList.add('calender-view')
  } else {
    document.body.classList.remove('calender-view')
  }
}

const createBooking = () => {
  bookingType.value = 'CREATE_BOOKING'
  showBookingForm({})
}
onUnmounted(() => {
  const elem = document.getElementById('booking-form')
  if(elem !== null) {
    updateBodyClass('hide')
    elem.removeEventListener('hide.bs.offcanvas', function() {
      setBooking({})
      updateBodyClass('hide')
      bookingType.value = ''
    })
  }
})
onMounted(() => {
  const elem = document.getElementById('booking-form')
  if(elem !== null) {
    elem.addEventListener('hide.bs.offcanvas', function() {
      setBooking({})
      updateBodyClass('hide')
      bookingType.value = ''
    })
    const bkid = new URL(location.href).searchParams.get('booking_id')
    if(bkid !== null && bkid !== undefined) {
      bookingType.value = 'CALENDER_BOOKING'
      showBookingForm({id: bkid})
    }
  }
  if (calenderRef !== null) {
    calenderInit.value = new Calendar({
      target: calenderRef.value,
      props: {
        plugins: [DayGrid, List, TimeGrid, ResourceTimeGrid, Interaction],
        options: {
          date: props.date,
          slotEventOverlap: false,
          dragScroll: false,
          view: 'resourceTimeGridDay',
          height: '800px',
          headerToolbar: {
            start: 'prev,next today',
            center: 'title',
            end: 'resourceTimeGridDay'
            // dayGridMonth,timeGridWeek,timeGridDay,listWeek
          },
          buttonText: function (texts) {
            texts.resourceTimeGridDay = 'Day'
            texts.resourceTimeGridWeek = 'Week'
            return texts
          },
          eventContent: function (data) {
            if(data.event.titleHTML !== undefined) {
              return {html: data.event.titleHTML + data.timeText}
            }
            return data.timeText
          },
          slotLabelFormat: function (data) {
            // Convert the input string to a Date object
            const date = new Date(data);

            // Get the hour and minute from the Date object
            const minute = data.getMinutes();

            // Check if the hour and minute are both "00"
            if (minute === 0) {
              return moment(data).format('hh:mm A');
            } else {
              return '';
            }
          },
          resources: [],
          scrollTime: '09:00:00',
          events: [],
          views: {
            timeGridWeek: { pointer: true },
            resourceTimeGridWeek: { pointer: true },
            resourceTimeGridDay: { pointer: true }
          },
          eventSources: [
            {
              events: async function () {
                const events = await createRequest(INDEX_URL()).then((res) => {
                  const { employees, data } = res
                  calenderInit.value.setOption('resources', employees)
                  return data
                })
                return events
              }
            }
          ],
          dateClick: function (info) {
            showBookingForm(info)
          },
          select: function (info) {
            showBookingForm(info)
          },
          eventClick: function (info) {
            const updatedInfo = {
              id: info.event.id,
              resource: {id: info.event.resourceIds[0]},
              date: info.event.start
            }
            showBookingForm(updatedInfo)
          },
          eventStartEditable: false,
          slotDuration: slotsDurations,
          dayMaxEvents: true,
          nowIndicator: true,
          selectable: false
        }
      }
    })
  }
})

const onSubmitEvent = () => {
  calenderInit.value.refetchEvents()
}

</script>
<style >
@import '@event-calendar/core/index.css';
body {
  transition: width 400ms ease;
}
.calender-view {
  width: calc(100% - 382px);
  transition: width 400ms ease;
}
.ec-lines {
  width: unset;
  margin-left: 8px;
}
.booking-datepicker .flatpickr-wrapper{
  width: 100% !important;
  display: block;
}
.ec-header .ec-day {
  overflow: inherit !important;
  height: inherit !important;
  line-height: inherit;
  min-height: inherit;
}
.ec-day.ec-today {
  background-color: var(--bs-body-bg);
}
.dark .ec-day.ec-today {
  background-color: #181818;
}
.ec-event{
  border-radius: 0;
  border-bottom: 2px solid var(--bs-border-color);
  cursor: pointer;
}
.ec-body:not(.ec-compact) .ec-line:nth-child(even):after{
  border-bottom-style: solid;
}
.ec-line:not(:first-child):after {
  border-color: var(--bs-border-color);
}
.ec-header,.ec-all-day,.ec-body,.ec-days,.ec-day{
  border-color: var(--bs-border-color);
}
.ec-button, .ec-button:not(:disabled) {
  color: var(--bs-body-color);
  background-color: var(--bs-body-bg);
  border-color: var(--bs-border-color);
}
.dark .ec-button:not(:disabled):hover, .dark .ec-button.ec-active {
  border-color: var(--bs-border-color);
  background-color: var(--bs-body-bg);
}
.ec-icon.ec-prev:after, .ec-icon.ec-next:after {
  border-color: var(--bs-body-color);
}
</style>
