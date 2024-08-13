<template>
    <form @submit="formSubmit">
      <div class="offcanvas offcanvas-end offcanvas-booking" tabindex="-1" id="customer-form-offcanvas" aria-labelledby="form-offcanvasLabel">
        <FormHeader :currentId="currentId" :editTitle="editTitle" :createTitle="createTitle"></FormHeader>
        <div class="offcanvas-body">
          <div class="row m-0">
            <div class="col-md-12 p-0">
              <div class="col-md-12 p-0 text-center">
                <img :src="ImageViewer || defaultImage" class="img-fluid avatar avatar-120 avatar-rounded mb-2" alt="profile-image" />
                <div class="d-flex align-items-center justify-content-center gap-2">
                  <input type="file" ref="profileInpuRef" class="form-control d-none" id="logo" name="profile_image" accept=".jpeg, .jpg, .png, .gif" @change="changeLogo" />
                  <label class="btn btn-soft-primary mb-3" for="logo">{{($t('booking.upload'))}}</label>
                  <input type="button" class="btn btn-soft-danger mb-3" name="remove" value="Remove" @click="removeLogo()" v-if="ImageViewer" />
                </div>
                <span class="text-danger">{{ errors.profile_image }}</span>
              </div>
  
              <InputField :is-required="true" :label="$t('customer.lbl_first_name')" placeholder="" v-model="first_name" :error-message="errors.first_name" :error-messages="errorMessages['first_name']"></InputField>
              <InputField :is-required="true" :label="$t('customer.lbl_last_name')" placeholder="" v-model="last_name" :error-message="errors['last_name']" :error-messages="errorMessages['last_name']"></InputField>
  
              <InputField :is-required="true" :label="$t('customer.lbl_Email')" placeholder="" v-model="email" :error-message="errors['email']" :error-messages="errorMessages['email']"></InputField>
              <div class="form-group p-0">
                <label class="form-label">{{ $t('customer.lbl_phone_number') }}<span class="text-danger">*</span> </label>
                <vue-tel-input :value="mobile" @input="handleInput" v-bind="{ mode: 'international', maxLen: 15 }" class="form-control"></vue-tel-input>
                <span class="text-danger">{{ errors['mobile'] }}</span>
              </div>
  
              <div class="row" v-if="currentId === 0">
                <InputField type="password" class="col-md-12" :is-required="true" :label="$t('employee.lbl_password')"
                  placeholder="" v-model="password" :error-message="errors['password']"
                  :error-messages="errorMessages['password']"></InputField>
  
                <InputField type="password" class="col-md-12" :is-required="true" :label="$t('employee.lbl_confirm_password')"
                  placeholder="" v-model="confirm_password" :error-message="errors['confirm_password']"
                  :error-messages="errorMessages['confirm_password']"></InputField>
              </div>
  
  
              <div class="form-group p-0 col-md-4 mb-0">
                <label for="" class="form-label w-100">{{ $t('customer.lbl_gender') }}</label>
                <div class="d-flex mt-2">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" v-model="gender" id="male" value="male" />
                    <label class="form-check-label" for="male"> {{ $t('customer.lbl_male') }} </label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" v-model="gender" id="female" value="female" />
                    <label class="form-check-label" for="female"> {{ $t('customer.lbl_female') }} </label>
                  </div>
  
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" v-model="gender" id="other" value="other" />
                    <label class="form-check-label" for="other"> {{ $t('customer.lbl_other') }} </label>
                  </div>
                </div>
              </div>
              <div v-for="field in customefield" :key="field.id">
                <FormElement v-model="custom_fields_data" :name="field.name" :label="field.label" :type="field.type" :required="field.required" :options="field.value" :field_id="field.id"></FormElement>
              </div>
            </div>
          </div>
        </div>
        <FormFooter></FormFooter>
      </div>
    </form>
  </template>
  <script setup>
  import { ref, onMounted } from 'vue'
  import { EDIT_URL, STORE_URL, UPDATE_URL } from '../../constant/customer'
  import { useField, useForm } from 'vee-validate'
  
  import { VueTelInput } from 'vue3-tel-input'
  
  import { useModuleId, useRequest, useOnOffcanvasHide } from '@/helpers/hooks/useCrudOpration'
  import * as yup from 'yup'
  // import 'flatpickr/dist/flatpickr.css';
  import { readFile } from '@/helpers/utilities'
  import FormHeader from '@/vue/components/form-elements/FormHeader.vue'
  import FormFooter from '@/vue/components/form-elements/FormFooter.vue'
  import InputField from '@/vue/components/form-elements/InputField.vue'
  import FormElement from '@/helpers/custom-field/FormElement.vue'
  
  // props
  defineProps({
    createTitle: { type: String, default: '' },
    editTitle: { type: String, default: '' },
    defaultImage: { type: String, default: 'https://dummyimage.com/600x300/cfcfcf/000000.png' },
    customefield: { type: Array, default: () => [] }
  })
  
  const { getRequest, storeRequest, updateRequest, listingRequest } = useRequest()
  
  /*
   * Form Data & Validation & Handeling
   */
  const currentId = useModuleId(() => {
    if (currentId.value > 0) {
      getRequest({ url: EDIT_URL, id: currentId.value }).then((res) => res.status && setFormData(res.data))
    } else {
      setFormData(defaultData())
    }
  })
  
  // File Upload Function
  const ImageViewer = ref(null)
  const profileInpuRef = ref(null)
  const fileUpload = async (e, { imageViewerBS64, changeFile }) => {
    let file = e.target.files[0]
    await readFile(file, (fileB64) => {
      imageViewerBS64.value = fileB64
  
      profileInpuRef.value.value = ''
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
  
  /*
   * Form Data & Validation & Handeling
   */
  // Default FORM DATA
  const defaultData = () => {
    errorMessages.value = {}
    return {
      id: null,
      first_name: '',
      last_name: '',
      email: '',
      mobile: '',
      password: '',
      confirm_password: '',
      gender: 'male',
      profile_image: '',
      custom_fields_data: {}
    }
  }
  
  //  Reset Form
  const setFormData = (data) => {
    ImageViewer.value = data.profile_image
    resetForm({
      values: {
        id: data.id,
        first_name: data.first_name,
        last_name: data.last_name,
        email: data.email,
        mobile: data.mobile,
        password: data.password,
        confirm_password: data.confirm_password,
        gender: data.gender,
        profile_image: data.profile_image,
        custom_fields_data: data.custom_field_data
      }
    })
  }
  
  const reset_datatable_close_offcanvas = (res) => {
    if (res.status) {
      window.successSnackbar(res.message)
      renderedDataTable.ajax.reload(null, false)
      bootstrap.Offcanvas.getInstance('#customer-form-offcanvas').hide()
      setFormData(defaultData())
    } else {
      window.errorSnackbar(res.message)
      errorMessages.value = res.all_message
    }
  }
  
    const numberRegex = /^\d+$/;
    let EMAIL_REGX = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
  
    // Validations
    const validationSchema = yup.object({
      first_name: yup.string()
      .required('First Name is a required field')
      .test('is-string', 'Only strings are allowed', (value) => {
        // Regular expressions to disallow special characters and numbers
        const specialCharsRegex = /[!@#$%^&*(),.?":{}|<>\-_;'\/+=\[\]\\]/
        return !specialCharsRegex.test(value) && !numberRegex.test(value)
      }),
  
      last_name: yup.string()
      .required('Last Name is a required field')
      .test('is-string', 'Only strings are allowed', (value) => {
        // Regular expressions to disallow special characters and numbers
        const specialCharsRegex = /[!@#$%^&*(),.?":{}|<>\-_;'\/+=\[\]\\]/
        return !specialCharsRegex.test(value) && !numberRegex.test(value)
      }),
      email: yup.string().required('Email is a required field').matches(EMAIL_REGX, 'Must be a valid email'),
      mobile: yup.string()
      .required('Phone Number is a required field').matches(/^(\+?\d+)?(\s?\d+)*$/, 'Phone Number must contain only digits'),
      password : yup.string().test('password','Password is required' , function(value) {
        if(currentId === 0 && !value){
          return false;
        }
        return true
      }
      ).min(8,'Password must be at least 8 characters long'),
      confirm_password : yup.string().test('confirm_password', 'Confirm password is required', function(value) {
        if(currentId === 0 && !value){
          return false;
        }
        return true
      }
      ).oneOf([yup.ref('password')], 'Passwords must match'),
  
    })
  
  
  const { handleSubmit, errors, resetForm } = useForm({
    validationSchema
  })
  const { value: id } = useField('first_name')
  const { value: first_name } = useField('first_name')
  const { value: last_name } = useField('last_name')
  const { value: email } = useField('email')
  const { value: gender } = useField('gender')
  const { value: mobile } = useField('mobile')
  const { value: profile_image } = useField('profile_image')
  const { value: custom_fields_data } = useField('custom_fields_data')
  const { value: password } = useField('password')
  const { value: confirm_password } = useField('confirm_password')
  const errorMessages = ref({})
  
  // phone number
  const handleInput = (phone, phoneObject) => {
    // Handle the input event
    if (phoneObject?.formatted) {
      mobile.value = phoneObject.formatted
    }
  }
  
  // Form Submit
  const formSubmit = handleSubmit((values) => {
    values.custom_fields_data = JSON.stringify(values.custom_fields_data)
  
    if (currentId.value > 0) {
      updateRequest({ url: UPDATE_URL, id: currentId.value, body: values, type: 'file' }).then((res) => reset_datatable_close_offcanvas(res))
    } else {
      storeRequest({ url: STORE_URL, body: values, type: 'file' }).then((res) => reset_datatable_close_offcanvas(res))
    }
  })
  
  useOnOffcanvasHide('customer-form-offcanvas', () => setFormData(defaultData()))
  </script>
  