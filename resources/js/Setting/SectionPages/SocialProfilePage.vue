<template>
  <form @submit="formSubmit">
    <CardTitle title="Social Profile" icon="fas fa-users"></CardTitle>

    <InputField :label="$t('setting_social_page.lbl_fb_url')" :is-required="true"  placeholder="Facebook Page URL" v-model="facebook_url" :errorMessage="errors.facebook_url" :errorMessages="errorMessages.facebook_url"></InputField>

    <InputField :label="$t('setting_social_page.lbl_twitter_url')" :is-required="true"  placeholder="Twitter Profile URL" v-model="twitter_url" :errorMessage="errors.twitter_url" :errorMessages="errorMessages.twitter_url"></InputField>

    <InputField :label="$t('setting_social_page.lbl_insta_url')"  :is-required="true" placeholder="Instagram Account URL" v-model="instagram_url" :errorMessage="errors.instagram_url" :errorMessages="errorMessages.instagram_url"></InputField>

    <InputField :label="$t('setting_social_page.lbl_linkedin_url')" placeholder="LinkedIn URL" v-model="linkedin_url" :errorMessage="errors.linkedin_url"></InputField>

    <InputField :label="$t('setting_social_page.lbl_youtube_url')" placeholder="Youtube Channel URL" v-model="youtube_url" :errorMessage="errors.youtube_url"></InputField>

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
      facebook_url: data.facebook_url,
      twitter_url: data.twitter_url,
      instagram_url: data.instagram_url,
      linkedin_url: data.linkedin_url,
      youtube_url: data.youtube_url
    }
  })
}
//validation
const validationSchema = yup.object({
  facebook_url: yup.string({ required_error: 'Facebook url is required' }).url('Must be a valid facebook url'),
  twitter_url: yup.string({ required_error: 'Twitter url is required' }).url('Must be a valid twitter url'),
  instagram_url: yup.string({ required_error: 'Instagram url is required' }).url('Must be a valid instagram url'),
  linkedin_url: yup.string({ required_error: 'Linkedin url is required' }).url('Must be a valid linkedin url'),
  youtube_url: yup.string({ required_error: 'Youtube url is required' }).url('Must be a valid youtube url')
})

const { handleSubmit, errors, resetForm } = useForm({
  validationSchema
})
const errorMessages = ref({})
const { value: facebook_url } = useField('facebook_url')
const { value: twitter_url } = useField('twitter_url')
const { value: instagram_url } = useField('instagram_url')
const { value: linkedin_url } = useField('linkedin_url')
const { value: youtube_url } = useField('youtube_url')

const display_submit_message = (res) => {
  IS_SUBMITED.value = false
  if (res.status) {
    window.successSnackbar(res.message)
  } else {
    window.errorSnackbar(res.message)
    errorMessages.value = res.errors
  }
}
//fetch data
const data = 'facebook_url,twitter_url,instagram_url,linkedin_url,youtube_url'
onMounted(() => {
  createRequest(GET_URL(data)).then((response) => {
    setFormData(response)
  })
})

//Form Submit
const formSubmit = handleSubmit((values) => {
  IS_SUBMITED.value = true
  const newValues = {}
  Object.keys(values).forEach((key) => {
    newValues[key] = values[key] || ''
  })
  storeRequest({ url: STORE_URL, body: newValues }).then((res) => display_submit_message(res))
})
</script>
