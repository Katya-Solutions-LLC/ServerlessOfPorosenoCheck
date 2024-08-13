<template>
  <div id="verifyCustomer">
    <form @submit="formSubmit">
      <div class="card-list-data">
        <div class="row">
          <InputField class="col-md-6" :is-required="true" :label="$t('quick_booking.lbl_first_name')" placeholder="" v-model="first_name" :error-message="errors.first_name" :error-messages="errorMessages['first_name']"></InputField>
          <InputField class="col-md-6" :is-required="true" :label="$t('quick_booking.lbl_last_name')" placeholder="" v-model="last_name" :error-message="errors['last_name']" :error-messages="errorMessages['last_name']"></InputField>
        </div>

        <InputField :is-required="true" :label="$t('quick_booking.lbl_Email')" placeholder="" v-model="email" :error-message="errors['email']" :error-messages="errorMessages['email']"></InputField>
        <div class="form-group">
          <label class="form-label">{{ $t('quick_booking.lbl_phone_number') }}<span class="text-danger">*</span> </label>
          <vue-tel-input :value="mobile" @input="handleInput" v-bind="{ mode: 'international', maxLen: 15 }"></vue-tel-input>
          <span class="text-danger">{{ errors['mobile'] }}</span>
        </div>

        <div class="form-group col-md-4">
          <label for="" class="form-label w-100">{{ $t('quick_booking.lbl_gender') }}</label>
          <div class="d-flex mt-2">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="gender" v-model="gender" id="male" value="male" />
              <label class="form-check-label" for="male">{{ $t('quick_booking.lbl_male') }}</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="gender" v-model="gender" id="female" value="female" />
              <label class="form-check-label" for="female">{{ $t('quick_booking.lbl_female') }}</label>
            </div>

            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="gender" v-model="gender" id="other" value="other" />
              <label class="form-check-label" for="other"> {{ $t('quick_booking.lbl_other') }}</label>
            </div>
          </div>
        </div>
        <div class="card-footer">
        <button class="btn btn-primary iq-text-uppercase">{{$t('quick_booking.submit')}}</button>
        </div>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted,computed} from 'vue'
import { useField, useForm } from 'vee-validate'
import * as yup from 'yup'
import { useModuleId, useRequest, useOnOffcanvasHide } from '@/helpers/hooks/useCrudOpration'
import InputField from '@/vue/components/form-elements/InputField.vue'
import { STORE_CUSTOMER } from '@/vue/constants/quick_booking'
import {useQuickBooking} from '../../store/quick-booking'

const { getRequest, storeRequest, updateRequest, listingRequest } = useRequest()
const emit = defineEmits(['add_user'])

onMounted(() => {

  setFormData(defaultData())
})


const store = useQuickBooking()
   const user = computed(() => store.user)



const defaultData = () => {
  errorMessages.value = {}
  return {
    first_name: '',
    last_name: '',
    email: user.value.email,
    mobile: '',
    gender: ''
  }
}

const setFormData = (data) => {
  resetForm({
    values: {
      email: data.email,
      first_name: data.first_name,
      last_name: data.last_name,
      mobile: data.mobile,
      gender: data.gender
    }
  })
}

const numberRegex = /^\d+$/
let EMAIL_REGX = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/
const validationSchema = yup.object({
  first_name: yup
    .string()
    .required('First Name is a required field')
    .test('is-string', 'Only strings are allowed', (value) => {
      // Regular expressions to disallow special characters and numbers
      const specialCharsRegex = /[!@#$%^&*(),.?":{}|<>\-_;'\/+=\[\]\\]/
      return !specialCharsRegex.test(value) && !numberRegex.test(value)
    }),
  last_name: yup
    .string()
    .required('Last Name is a required field')
    .test('is-string', 'Only strings are allowed', (value) => {
      // Regular expressions to disallow special characters and numbers
      const specialCharsRegex = /[!@#$%^&*(),.?":{}|<>\-_;'\/+=\[\]\\]/
      return !specialCharsRegex.test(value) && !numberRegex.test(value)
    }),
  email: yup.string().required('Email is a required field').matches(EMAIL_REGX, 'Must be a valid email'),
  mobile: yup
    .string()
    .required('Phone No is a required field')
    .matches(/^(\+?\d+)?(\s?\d+)*$/, 'Phone Number must contain only digits')
})

const { handleSubmit, errors, resetForm } = useForm({
  validationSchema
})
const { value: first_name } = useField('first_name')
const { value: last_name } = useField('last_name')
const { value: email } = useField('email')
const { value: gender } = useField('gender')
const { value: mobile } = useField('mobile')
const errorMessages = ref({})
const IS_SUBMITED = ref(false)

// phone number
const handleInput = (phone, phoneObject) => {
  // Handle the input event
  if (phoneObject?.formatted) {
    mobile.value = phoneObject.formatted
  }
}

const reset_datatable_close_offcanvas = (res) => {
  if (res.status) {
    window.successSnackbar(res.message)
    setFormData(defaultData())
  } else {
    window.errorSnackbar(res.message)
    errorMessages.value = res.all_message
  }
}

// Form Submit
const formSubmit = handleSubmit((values) => {
  storeRequest({ url: STORE_CUSTOMER, body: values }).then((res) => {
    if(res.errors){

    }else{

      emit('add_user', res.data)

    }
 
  })
})
</script>
