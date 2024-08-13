<template>
  <form @submit="formSubmit">
    <CardTitle title="Analytics" icon="fas fa-cube"></CardTitle>
    <InputField :label="$t('setting_analytics_page.lbl_name')" placeholder="google analytics (gtag)" v-model="google_analytics" :errorMessage="errors.google_analytics"></InputField>
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
      google_analytics: data.google_analytics
    }
  })
}

// Validations
const validationSchema = yup.object({
  google_analytics: yup.string({ required_error: 'Google analytics is required' })
})
const { handleSubmit, errors, resetForm } = useForm({ validationSchema })
const { value: google_analytics } = useField('google_analytics')

//fetch data
const data = 'google_analytics'

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
