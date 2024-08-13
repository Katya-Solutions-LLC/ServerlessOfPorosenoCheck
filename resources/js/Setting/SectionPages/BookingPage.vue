<template>
  <form @submit="formSubmit">
    <CardTitle title="Booking" icon="fa-solid fa-calendar-days"></CardTitle>
    <div class="form-group">
      <label class="form-label" for="slot_duration">{{ $t('setting_booking_page.lbl_name') }}</label>
      <flat-pickr placeholder="Slot Duration (Min)" id="slot_duration" class="form-control" v-model="slot_duration" :value="slot_duration" :config="config"></flat-pickr>
      <span class="text-danger">{{ errors.slot_duration }}</span>
    </div>
    <SubmitButton :IS_SUBMITED="IS_SUBMITED"></SubmitButton>
  </form>
</template>
<script setup>
import CardTitle from '@/Setting/Components/CardTitle.vue'
import { onMounted, ref } from 'vue'
import { useField, useForm } from 'vee-validate'
import { STORE_URL, GET_URL } from '@/vue/constants/setting'
import { createRequest } from '@/helpers/utilities'
import { useRequest } from '@/helpers/hooks/useCrudOpration'
import FlatPickr from 'vue-flatpickr-component'
import SubmitButton from './Forms/SubmitButton.vue'
const config = ref({
  dateFormat: 'H:i',
  time_24hr: true,
  enableTime: true,
  noCalendar: true,
  defaultHour: '00', // Update default hour to 9
  defaultMinute: '30'
})

const IS_SUBMITED = ref(false)
const { storeRequest } = useRequest()
//  Reset Form
const setFormData = (data) => {
  resetForm({
    values: {
      slot_duration: data.slot_duration
    }
  })
}
const { handleSubmit, errors, resetForm } = useForm()
const errorMessage = ref(null)
const { value: slot_duration } = useField('slot_duration')
slot_duration.value = '00:30'
const data = 'slot_duration'
onMounted(() => {
  createRequest(GET_URL(data)).then((response) => {
    setFormData(response)
  })
})
// message
const display_submit_message = (res) => {
  IS_SUBMITED.value = false
  if (res.status) {
    window.successSnackbar(res.message)
  } else {
    window.errorSnackbar(res.message)
  }
}
//Form Submit
const formSubmit = handleSubmit((values) => {
  IS_SUBMITED.value = true
  storeRequest({ url: STORE_URL, body: values }).then((res) => display_submit_message(res))
})
</script>
