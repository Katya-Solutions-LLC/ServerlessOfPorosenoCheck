<template>
  <form @submit="formSubmit">
    <CardTitle title="Meta" icon="fas fa-globe-asia"></CardTitle>
    <InputField :label="$t('setting_meta_page.lbl_site_name')" placeholder="meta_site_name" v-model="meta_site_name" :errorMessage="errors.meta_site_name"></InputField>
    <InputField :label="$t('setting_meta_page.lbl_description')" placeholder="meta description" v-model="meta_description" :errorMessage="errors.meta_description"></InputField>
    <InputField :label="$t('setting_meta_page.lbl_keyword')" placeholder="meta keyword" v-model="meta_keyword" :errorMessage="errors.meta_keyword"></InputField>
    <InputField :label="$t('setting_meta_page.lbl_image')" placeholder="meta image" v-model="meta_image" :errorMessage="errors.meta_image"></InputField>
    <InputField :label="$t('setting_meta_page.lbl_fb_app_id')" placeholder="meta facebook app id" v-model="meta_fb_app_id" :errorMessage="errors.meta_fb_app_id"></InputField>
    <InputField :label="$t('setting_meta_page.lbl_twitter_site')" placeholder="Meta twitter site account" v-model="meta_twitter_site" :errorMessage="errors.meta_twitter_site"></InputField>
    <InputField :label="$t('setting_meta_page.lbl_twitter_creator')" placeholder="meta twitter creator account" v-model="meta_twitter_creator" :errorMessage="errors.meta_twitter_creator"></InputField>
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
      meta_site_name: data.meta_site_name,
      meta_description: data.meta_description,
      meta_keyword: data.meta_keyword,
      meta_image: data.meta_image,
      meta_fb_app_id: data.meta_fb_app_id,
      meta_twitter_site: data.meta_twitter_site,
      meta_twitter_creator: data.meta_twitter_creator
    }
  })
}
//validation
const validationSchema = yup.object({
  meta_site_name: yup.string({ required_error: 'Meta site name is required' }),
  meta_description: yup.string({ required_error: 'Meta description is required' }),
  meta_keyword: yup.string({ required_error: 'Meta keyword is required' }),
  meta_image: yup.string({ required_error: 'Meta image is required' }),
  meta_fb_app_id: yup.string({ required_error: 'Meta fb app id is required' }),
  meta_twitter_site: yup.string({ required_error: 'Meta twitter site is required' }),
  meta_twitter_creator: yup.string({ required_error: 'Meta twitter creator is required' })
})

const { handleSubmit, errors, resetForm } = useForm({ validationSchema })

const { value: meta_site_name } = useField('meta_site_name')
const { value: meta_description } = useField('meta_description')
const { value: meta_keyword } = useField('meta_keyword')
const { value: meta_image } = useField('meta_image')
const { value: meta_fb_app_id } = useField('meta_fb_app_id')
const { value: meta_twitter_site } = useField('meta_twitter_site')
const { value: meta_twitter_creator } = useField('meta_twitter_creator')

//fetch data
const data = 'meta_site_name,meta_description,meta_keyword,meta_image,meta_fb_app_id,meta_twitter_site,meta_twitter_creator'
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
