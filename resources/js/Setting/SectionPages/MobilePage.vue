<template>
  <form @submit="formSubmit">
    <CardTitle title="Mobile" icon="fa-solid fa-mobile-screen-button"></CardTitle>
    <InputField :label="$t('setting_mobile_page.lbl_primary')" placeholder="Primary" v-model="primary" :errorMessage="errors.primary"></InputField>
    <InputField :label="$t('setting_mobile_page.lbl_secondary')" placeholder="Secondary" v-model="secondary" :errorMessage="errors.secondary"></InputField>
    <InputField :label="$t('setting_mobile_page.lbl_app_id')" placeholder="App ID" v-model="app_id" :errorMessage="errors.app_id"></InputField>
    <InputField :label="$t('setting_mobile_page.lbl_security')" placeholder="App Security" v-model="app_security" :errorMessage="errors.app_security"></InputField>
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
      primary: data.primary,
      secondary: data.secondary,
      app_id: data.app_id,
      app_security: data.app_security
    }
  })
}
//validation
const validationSchema = yup.object({
  primary: yup.string({ required_error: 'Primary is required' }),
  secondary: yup.string({ required_error: 'Secondary is required' }),
  app_id: yup.string({ required_error: 'App id is required' }),
  app_security: yup.string({ required_error: 'App security is required' })
})

const { handleSubmit, errors, resetForm } = useForm({ validationSchema })

const { value: primary } = useField('primary')
const { value: secondary } = useField('secondary')
const { value: app_id } = useField('app_id')
const { value: app_security } = useField('app_security')

//fetch data
const data = 'primary,secondary,app_id,app_security'
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
