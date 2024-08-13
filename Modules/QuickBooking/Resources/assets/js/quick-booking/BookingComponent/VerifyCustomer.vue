<template>
  <div id="verifyCustomer">
    <form @submit="formSubmit">
    <div class="gap-2 align-items-center">

        <div class="verify_email">
            <InputField :is-required="true" :label="$t('quick_booking.lbl_Email')" placeholder="" v-model="email" :error-message="errors['email']" :error-messages="errorMessages['email']"></InputField>
            <button class="btn btn-primary iq-text-uppercase" >{{$t('quick_booking.lbl_verify')}}</button>
         </div>

    </div>
 
    </form>
  </div>
  </template>

<script setup>
import { ref, onMounted } from 'vue'
import { useField, useForm } from 'vee-validate'
import * as yup from 'yup'
import { useModuleId, useRequest,useOnOffcanvasHide } from '@/helpers/hooks/useCrudOpration'
import InputField from '@/vue/components/form-elements/InputField.vue'
import { VERIFY_CUSTOMER } from '@/vue/constants/quick_booking'
import { useQuickBooking } from '../../store/quick-booking'


const { getRequest, storeRequest, updateRequest, listingRequest } = useRequest()
const emit = defineEmits(['verify_user'])

onMounted(() => {
  setFormData(defaultData())
})

const defaultData = () => {
  errorMessages.value = {}
  return {
    email: '',
 
  }
}


const setFormData = (data) => {
  resetForm({
    values: {
      email: data.email,
    
    }
  })
}

// Reload Datatable, SnackBar Message, Alert, Offcanvas Close
const reset_datatable_close_offcanvas = (res) => {
  if (res.status) {
    renderedDataTable.ajax.reload(null, false)
    bootstrap.Offcanvas.getInstance('#verifyCustomer').hide()
    setFormData(defaultData())
  } else {
    window.errorSnackbar(res.message)
    errorMessages.value = res.all_message
  }
}

let EMAIL_REGX = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/
// Validations
const validationSchema = yup.object({

    email: yup.string().required('Email is a required field').matches(EMAIL_REGX, 'Must be a valid email'),

})

const { handleSubmit, errors, resetForm } = useForm({
  validationSchema
})
const { value: email } = useField('email')

const errorMessages = ref({})

const store = useQuickBooking()

// Form Submit
const formSubmit = handleSubmit((values) => {

 storeRequest({ url: VERIFY_CUSTOMER, body: values }).then((res) => {

  store.updateUserValues({ key: 'email', value: values.email})

  emit('verify_user', res.data)

 })
 
})




</script>