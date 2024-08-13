<template>
  <form @submit="formSubmit">
    <div class="offcanvas offcanvas-end offcanvas-booking" tabindex="-1" id="form-offcanvas" aria-labelledby="form-offcanvasLabel">
      <FormHeader :currentId="currentId" :editTitle="editTitle" :createTitle="createTitle"></FormHeader>
      <div class="offcanvas-body">
        <div class="row">
          <div class="col-md-12 row">

            <InputField  :is-required="true" label="First Name" placeholder="" v-model="first_name" :error-message="errors['first_name']" :error-messages="errorMessages['first_name']"></InputField>
            <InputField  :is-required="true" label="Last Name" placeholder="" v-model="last_name" :error-message="errors['last_name']" :error-messages="errorMessages['last_name']"></InputField>

            <InputField  :is-required="true" label="Email" placeholder="" v-model="email" :error-message="errors['email']" :error-messages="errorMessages['email']"></InputField>
            <InputField  :is-required="true" label="Phone Number" placeholder="" v-model="mobile" :error-message="errors['mobile']" :error-messages="errorMessages['mobile']"></InputField>


            <div class="form-group col-md-4">
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
      </div>
      <FormFooter></FormFooter>
    </div>
  </form>
</template>
<script setup>
import { ref } from 'vue'
import { EDIT_URL, STORE_URL, UPDATE_URL } from '../../../constants/users'
import { useField, useForm } from 'vee-validate'

import { useModuleId, useRequest } from '@/helpers/hooks/useCrudOpration'
import * as yup from 'yup';
import 'flatpickr/dist/flatpickr.css';
import FormHeader from '@/vue/components/form-elements/FormHeader.vue'
import FormFooter from '@/vue/components/form-elements/FormFooter.vue'
import InputField from '@/vue/components/form-elements/InputField.vue'

// props
defineProps({
  createTitle: { type: String, default: '' },
  editTitle: { type: String, default: '' }
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
    gender: '',

  }
}

//  Reset Form
const setFormData = (data) => {
  resetForm({
    values: {
      first_name: data.first_name,
      last_name: data.last_name,
      email: data.email,
      mobile: data.mobile,
      gender: data.gender,

    }
  })
}

const reset_datatable_close_offcanvas = (res) => {
  if (res.status) {
    window.successSnackbar(res.message)
    renderedDataTable.ajax.reload(null, false)
    bootstrap.Offcanvas.getInstance('#form-offcanvas').hide()
    setFormData(defaultData())
  } else {
    window.errorSnackbar(res.message)
    errorMessages.value = res.all_message
  }
}

// Validations
const validationSchema = yup.object({
  first_name: yup.string().required(),
  last_name: yup.string().required(),
  email: yup.string().required(),
  mobile: yup.string().required(),
 gender: yup.string().required(),

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



// Form Submit
const formSubmit = handleSubmit((values) => {

  if (currentId.value > 0) {
    updateRequest({ url: UPDATE_URL, id: currentId.value, body: values}).then((res) => reset_datatable_close_offcanvas(res))
  } else {
    storeRequest({ url: STORE_URL, body: values, }).then((res) => reset_datatable_close_offcanvas(res))
  }
})


</script>

