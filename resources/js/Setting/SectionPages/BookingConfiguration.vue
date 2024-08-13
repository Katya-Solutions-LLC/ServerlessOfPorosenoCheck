<template>
  <form @submit="formSubmit">

    <CardTitle title="Booking Configuration" icon="fa-solid fa-paper-plane"></CardTitle>

    <div class="row mb-4">
        <div class="col-md-6">
          <InputField  :label="`${$t('setting_booking_page.lbl_pet_daycare_amount')} (${CURRENCY_SYMBOL})`"  placeholder="Daycare Amount" v-model="pet_daycare_amount" :errorMessage="errors.pet_daycare_amount"></InputField>
          <span>{{ $t('setting_booking_page.daycare_message') }}</span>

        </div>
        <div class="col-md-6">
          <InputField  :label="`${$t('setting_booking_page.lbl_pet_boarding_amount')} (${CURRENCY_SYMBOL})`" placeholder="Boarding Amount" v-model="pet_boarding_amount" :errorMessage="errors.pet_boarding_amount"></InputField>
          <span>{{ $t('setting_booking_page.boarding_message') }}</span>
        </div>
    </div>
    <SubmitButton :IS_SUBMITED="IS_SUBMITED"></SubmitButton>
  </form>
</template>

<script setup>
import { ref } from 'vue'
import CardTitle from '@/Setting/Components/CardTitle.vue'
import InputField from '@/vue/components/form-elements/InputField.vue'
import { useField, useForm } from 'vee-validate'
import { STORE_URL, GET_URL } from '@/vue/constants/setting'

import * as yup from 'yup'
import { useRequest } from '@/helpers/hooks/useCrudOpration'
import { onMounted } from 'vue'
import { createRequest } from '@/helpers/utilities'
import SubmitButton from './Forms/SubmitButton.vue'

const { storeRequest } = useRequest()
const IS_SUBMITED = ref(false)

//  Reset Form
const setFormData = (data) => {
  resetForm({
    values: {
      pet_daycare_amount: data.pet_daycare_amount,
      pet_boarding_amount: data.pet_boarding_amount,
    }
  })
}
const CURRENCY_SYMBOL = ref(window.defaultCurrencySymbol)
//validation
const validationSchema = yup.object({
  pet_daycare_amount: yup.string({ required_error: 'pet_daycare_amount is required' }),
  pet_boarding_amount: yup.string({ required_error: 'pet_boarding_amount is required' }),
})

const { handleSubmit, errors, resetForm } = useForm({ validationSchema })

const { value: pet_daycare_amount } = useField('pet_daycare_amount')
const { value: pet_boarding_amount } = useField('pet_boarding_amount')

//fetch data
const data = 'pet_daycare_amount,pet_boarding_amount'
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

