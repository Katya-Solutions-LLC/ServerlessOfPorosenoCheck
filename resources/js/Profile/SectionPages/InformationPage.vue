<template>
  <form @submit="formSubmit">
    <div class="d-flex justify-content-between align-items-center">
      <CardTitle title="Personal Information" icon="fa-solid fa-user"></CardTitle>
    </div>
    <div class="row">
      <div class="col-12 row">
        <div class="col-md-8">
          <div class="row">
            <InputField class="col-md-6" :is-required="true" :label="$t('profile.lbl_first_name')" :value="first_name" v-model="first_name" :error-message="errors['first_name']"></InputField>
            <InputField class="col-md-6" :is-required="true" :label="$t('profile.lbl_last_name')" :value="last_name" v-model="last_name" :error-message="errors['last_name']"></InputField>
            <InputField class="col-md-6" :is-required="true" :label="$t('profile.lbl_email')" :value="email" v-model="email" :error-message="errors['email']" :is-disabled="USER_TYPE !== 'admin'"></InputField>
            <div class="form-group col-md-6">
              <label class="form-label"> {{ $t('profile.lbl_mobile') }} <span class="text-danger">*</span> </label>
              <vue-tel-input type="number" :value="mobile" @input="handleInput" v-bind="{ mode: 'international', maxLen: 15 }"></vue-tel-input>
              <span class="text-danger">{{ errors['mobile'] }}</span>
            </div>
          </div>
        </div>

        <div class="col-md-4 text-center">
          <img :src="ImageViewer || defaultImage" class="img-fluid avatar avatar-120 avatar-rounded mb-2"
            alt="profile-image" />
          <div class="d-flex align-items-center justify-content-center gap-2">
            <input type="file" ref="profileInputRef" class="form-control d-none" id="logo" name="profile_image"
              accept=".jpeg, .jpg, .png, .gif" @change="changeLogo" />
            <label class="btn btn-info" for="logo">Upload</label>
            <input type="button" class="btn btn-danger" name="remove" value="Remove" @click="removeLogo()"
              v-if="ImageViewer" />
          </div>
          <span class="text-danger">{{ errors.profile_image }}</span>
        </div>
        <div class="form-group col-md-4">
          <label for="" class="form-label w-100">{{ $t('profile.lbl_gender') }}</label>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" v-model="gender" id="male" value="male" :checked="gender == 'male'" />
            <label class="form-check-label" for="male"> {{ $t('profile.lbl_male') }} </label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" v-model="gender" id="female" value="female" :checked="gender == 'female'" />
            <label class="form-check-label" for="female"> {{ $t('profile.lbl_female') }} </label>
          </div>

          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" v-model="gender" id="other" value="other" :checked="gender == 'other'" />
            <label class="form-check-label" for="other"> {{ $t('profile.lbl_other') }} </label>
          </div>
          <p class="mb-0 text-danger">{{ errors.gender }}</p>
        </div>
        <div class="form-group m-0 col-md-4" v-if="enable_multi_vendor && USER_TYPE !== 'pet_store' && USER_TYPE !== 'user' && USER_TYPE !== 'admin' && USER_TYPE !== 'demo_admin' && USER_TYPE !== 'pet_sitter'">
          <div class="d-flex justify-content-between align-items-center">
            <label class="form-check-label" for="enable-store">
              {{ $t('profile.enable_shop') }}
            </label>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" :true-value="1" :false-value="0" v-model="enable_store" id="enable-store" :checked="enable_store" />
            </div>
          </div>
        </div>
        <!-- <div class="form-group m-0 col-md-4">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" :true-value="1" :false-value="0" v-model="show_in_calender" id="show-in-calender" :checked="show_in_calender" />
            <label class="form-check-label" for="show-in-calender">
              {{ $t('profile.lbl_show_in_calender') }}
            </label>
          </div>
        </div> -->

        <SubmitButton :IS_SUBMITED="IS_SUBMITED"></SubmitButton>
      </div>
    </div>
  </form>
</template>

<script setup>
import CardTitle from '@/Setting/Components/CardTitle.vue'
import InputField from '@/vue/components/form-elements/InputField.vue'
import { onMounted, ref } from 'vue'
import { useField, useForm } from 'vee-validate'
import { VueTelInput } from 'vue3-tel-input'
import { INFORMATION_STORE, GET_URL,GET_CONFIGURATION } from '@/vue/constants/users'

import { readFile } from '@/helpers/utilities'
import { createRequest } from '@/helpers/utilities'
import * as yup from 'yup'
import { useRequest } from '@/helpers/hooks/useCrudOpration'
import SubmitButton from './Forms/SubmitButton.vue'

const IS_SUBMITED = ref(false)

const { storeRequest,getRequest } = useRequest()

// File Upload Function
const ImageViewer = ref(null)
const profileInputRef = ref(null)
const defaultImage = ref('https://dummyimage.com/600x300/cfcfcf/000000.png')

const fileUpload = async (e, { imageViewerBS64, changeFile }) => {
  let file = e.target.files[0]
  await readFile(file, (fileB64) => {
    imageViewerBS64.value = fileB64

    profileInputRef.value.value = '';
  })
  changeFile.value = file
}
// Function to delete Images
const removeImage = ({ imageViewerBS64, changeFile }) => {
  imageViewerBS64.value = null
  changeFile.value = null
}

const changeLogo = (e) => fileUpload(e, { imageViewerBS64: ImageViewer, changeFile: profile_image })
const removeLogo = () => removeImage({ imageViewerBS64: ImageViewer, changeFile: profile_image })


const USER_TYPE = ref('')
//  Reset Form
const setFormData = (data) => {
  ImageViewer.value = data.profile_image
  USER_TYPE.value = data.user_type
  // const isPetStore = data.user_type && data.user_type.includes('pet_store');
  resetForm({
    values: {
      first_name: data.first_name,
      last_name: data.last_name,
      email: data.email,
      mobile: data.mobile,
      show_in_calender: data.show_in_calender,
      gender: data.gender,
      profile_image: data.profile_image,
      enable_store: data.enable_store,
    }
  })
}

// phone number
const handleInput = (phone, phoneObject) => {
  // Handle the input event
  if (phoneObject?.formatted) {
    mobile.value = phoneObject.formatted
  }
}

const validationSchema = yup.object({
  first_name: yup.string().required('first name is required'),
  last_name: yup.string().required('last name is required'),
  email: yup.string().required('email is required'),
  mobile: yup.string().required('mobile is required'),
  show_in_calender: yup.string().required('show_in_calender is required'),
})

const { handleSubmit, errors, resetForm } = useForm({
  validationSchema
})
const errorMessages = ref(null)
const { value: first_name } = useField('first_name')
const { value: last_name } = useField('last_name')
const { value: email } = useField('email')
const { value: mobile } = useField('mobile')
const { value: show_in_calender } = useField('show_in_calender')
const { value: gender } = useField('gender')
const { value: profile_image } = useField('profile_image')
const { value: enable_store } = useField('enable_store')
const enable_multi_vendor = ref(false);
//fetch data
const data = 'first_name'
onMounted(() => {
  createRequest(GET_URL()).then((response) => {
    if(response.status) {
      setFormData(response.data)
    }
  })
  getConfiguration();
})

// message
const display_submit_message = (res) => {
  IS_SUBMITED.value = false
  if (res.status) {
    window.successSnackbar(res.message)
    window.location.reload();
  } else {
    window.errorSnackbar(res.message)
    // errorMessages.value = res.all_message
  }
}

//Form Submit
const formSubmit = handleSubmit((values) => {
  IS_SUBMITED.value = true
  storeRequest({ url: INFORMATION_STORE, body: values, type: 'file' }).then((res) => display_submit_message(res))
})


const getConfiguration = (() => {
  getRequest({ url: GET_CONFIGURATION }).then((res) => {
    if (res.status && res.enable_multi_vendor === 1) {
      enable_multi_vendor.value = true;
    } else {
      console.error('Error fetching configuration:');
    }})
})
</script>

<style>
.favicon-image {
  width: 50px;
  height: 50px;
}
</style>
