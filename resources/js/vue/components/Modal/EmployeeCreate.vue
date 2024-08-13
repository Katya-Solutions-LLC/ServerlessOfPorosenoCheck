<template>
    <!-- Modal -->
    <form @submit="formSubmit" class="">
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Create Manager</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row" id="form-offcanvas">
                          <InputField class="col-md-6" :is-required="true" label="First Name" placeholder="" v-model="first_name" :error-message="errors['first_name']" :error-messages="errorMessages['first_name']"></InputField>
                          <InputField class="col-md-6" :is-required="true" label="Last Name" placeholder="" v-model="last_name" :error-message="errors['last_name']" :error-messages="errorMessages['last_name']"></InputField>

                          <InputField class="col-md-6" :is-required="true" label="Email" placeholder="" v-model="email" :error-message="errors['email']" :error-messages="errorMessages['email']"></InputField>
                          <div class="form-group col-md-6">
                            <label class="form-label">{{ $t('branch.lbl_contact_number') }}<span class="text-danger">*</span> </label>
                            <vue-tel-input :value="mobile" @input="handleInput" v-bind="{mode: 'international',maxLen: 15}" class="form-control"></vue-tel-input>
                            <span class="text-danger">{{ errors['mobile'] }}</span>
                          </div>
                            <InputField type="password" class="col-md-6" :is-required="true" label="Password" placeholder="" v-model="password" :error-message="errors['password']" :error-messages="errorMessages['password']"></InputField>

                            <InputField type="password" class="col-md-6" :is-required="true" label="Confirm Password" placeholder="" v-model="confirm_password" :error-message="errors['confirm_password']" :error-messages="errorMessages['passwconfirm_passwordord']"></InputField>
                            <div class="form-group col-md-12">
                              <label for="" class="form-label w-100">Gender</label>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="gender" v-model="gender" id="male" value="male">
                                  <label class="form-check-label" for="male">
                                    Male
                                  </label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="gender" v-model="gender" id="female" value="female">
                                  <label class="form-check-label" for="female">
                                    Female
                                  </label>
                                </div>

                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="gender" v-model="gender" id="other" value="other">
                                  <label class="form-check-label" for="other">
                                    Other
                                  </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-outline-primary d-block" data-bs-dismiss="modal"><i class="fa-solid fa-angles-left"></i>Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>
<script setup>
import { ref, onMounted } from 'vue'

import { useRequest } from '@/helpers/hooks/useCrudOpration'
import InputField from '@/vue/components/form-elements/InputField.vue'
import { useField, useForm } from 'vee-validate'
import { VueTelInput } from 'vue3-tel-input'
import * as yup from 'yup'

import { EMPLOYEE_STORE } from '@/vue/constants/users'

const emit = defineEmits(['submit'])

const { storeRequest } = useRequest()


/*
 * Form Data & Validation & Handeling
 */
// Default FORM DATA
const defaultData = () => {
  errorMessages.value = {}
  return {
    first_name: '',
    last_name: '',
    email: '',
    mobile: '',
    password: '',
    confirm_password: '',
    gender: 'male',
    show_in_calender: 1,
    is_manager: 1,
    confirmed: 1
  }
}

onMounted(() => {
  setFormData(defaultData())
})

//  Reset Form
const setFormData = (data) => {
  resetForm({
    values: {
      first_name: data.first_name,
      last_name: data.last_name,
      email: data.email,
      mobile: data.mobile,
      password: data.password,
      confirm_password: data.confirm_password,
      gender: data.gender,
      show_in_calender: data.show_in_calender,
      is_manager: data.is_manager,
      show_in_calender: data.show_in_calender,
      is_manager: data.is_manager,
      confirmed: data.confirmed,
    }
  })
}

let EMAIL_REGX = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;

// Validations
const validationSchema = yup.object({
    first_name: yup.string().required('First Name is required'),
    last_name: yup.string().required('Last Name is required'),
    email: yup.string().required('Email is required').matches(EMAIL_REGX, 'Must be a valid email'),
    mobile: yup.string().required('Contact Number is required'),
    password : yup.string().required('Password is required')
    .min(8, 'Password must be at least 8 characters long'),
      confirm_password : yup.string().required('Current password is required')
      .oneOf([yup.ref('password')], 'Passwords must match')
})

const { handleSubmit, errors, resetForm } = useForm({
  validationSchema
})

const { value: first_name } = useField('first_name')
const { value: last_name } = useField('last_name')
const { value: email } = useField('email')
const { value: password } = useField('password')
const { value: confirm_password } = useField('confirm_password')
const { value: gender } = useField('gender')
const { value: mobile } = useField('mobile')
const { value: show_in_calender } = useField('show_in_calender')
const { value: is_manager } = useField('is_manager')
const { value: confirmed } = useField('confirmed')
confirmed.value = 1
show_in_calender.value = 1
is_manager.value = 1
const errorMessages = ref({})

// phone number
const handleInput = (phone, phoneObject) => {
  // Handle the input event
  if (phoneObject?.formatted) {
    mobile.value = phoneObject.formatted
  }
};

const formSubmit = handleSubmit((value) => {
  storeRequest({ url: EMPLOYEE_STORE, body: value }).then((res) => {
    if(res.status) {
      emit('submit', {type: 'create_manager', value: res.data.id})
      setFormData(defaultData())
      bootstrap.Modal.getInstance(document.getElementById("exampleModal")).hide()
    }
  })
})

</script>
