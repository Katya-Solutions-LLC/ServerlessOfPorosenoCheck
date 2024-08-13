<template>
  <div class="add_customer" v-if="userVerify == 1">
    <VerifyCustomer @verify_user="handleverifyUserResponse"></VerifyCustomer>
  </div>
  <div class="add_customer" v-if="userVerify == 0">
    <CreateCustomer @add_user="handleUserResponse"></CreateCustomer>
  </div>

  <div class="view_customer" v-if="userVerify == 2 && isAddpet==0">
    <div class="col" v-if="userData">
    

      <div class="user-block bg-white p-3 rounded">
        <div class="d-flex align-items-start gap-3 mb-2">
          <img :src="userData.profile_image" alt="avatar" class="img-fluid avatar avatar-60 rounded-pill" />
          <div class="flex-grow-1">
            <div class="gap-2 mt-3">
              <h5>{{ userData.first_name }} {{ userData.last_name }}</h5>
            </div>
          </div>
          <button type="button"  @click="removeCustomer()"
            class="btn btn-sm text-danger">{{$t('quick_booking.remove')}}</button>
        </div>
        <div class="row m-0">
          <label class="col-3 p-0"><i><span class="fst-normal">{{$t('quick_booking.lbl_phone_number')}}</span></i></label>
          <strong class="col p-0">{{ userData.mobile }}</strong>
        </div>
        <div class="row mx-0 mb-3">
          <label class="col-3 p-0"><i><span class="fst-normal">{{$t('quick_booking.lbl_Email')}}</span></i></label>
          <strong class="col p-0">{{ userData.email }}</strong>
        </div>
      </div>
    </div>

    <div class="col-md-12">
      <div class="form-group">
        <label class="form-label d-block"
          >{{$t('quick_booking.choose_pet')}}<span class="text-danger">*</span>
          <button type="button" @click="addpet()" class="btn btn-sm text-primary px-0 float-end"><i class="fa-solid fa-plus"></i>{{$t('quick_booking.add_pet')}} </button>
        </label>
        <Multiselect id="pet" v-model="pet" :value="pet" placeholder="Select Pet" v-bind="SingleSelectOption" :options="petList.options" class="form-group"></Multiselect>
        <div class="text-danger">{{ errors.pet }}</div>
      </div>
    </div>
  </div>

  <div v-if="isAddpet == 1">
    <Createpet :user_id="userData.id"  @add_pet="handlePetResponse"></Createpet>
  </div>
  <div class="card-footer" v-if="isFinalstep == 1  && isAddpet==0">
    <button type="button" class="btn btn-secondary iq-text-uppercase" v-if="wizardPrev" @click="prevTabChange(wizardPrev)">{{$t('quick_booking.back')}}</button>
    <button class="btn btn-primary iq-text-uppercase" name="submit" v-if="wizardNext" @click="formSubmit">{{$t('quick_booking.submit')}}</button>
  </div>
</template>

<script setup>
import { ref, watch,onMounted } from 'vue'
import { useField, useForm } from 'vee-validate'
import { VueTelInput } from 'vue3-tel-input'
import InputField from '@/vue/components/form-elements/InputField.vue'
import * as yup from 'yup'
import { useQuickBooking } from '../../store/quick-booking'
import { buildMultiSelectObject } from '@/helpers/utilities'

import VerifyCustomer from '../../quick-booking/BookingComponent/VerifyCustomer.vue'
import CreateCustomer from '../../quick-booking/BookingComponent/CreateCustomer.vue'
import Createpet from '../../quick-booking/BookingComponent/Createpet.vue'

const props = defineProps({
  wizardNext: {
    default: '',
    type: [String, Number]
  },
  wizardPrev: {
    default: '',
    type: [String, Number]
  }
})
/*
 * Form Data & Validation & Handeling
 */
// Default FORM DATA
const defaultData = () => {
  errorMessages.value = {}
  return {
    pet: ''
  }
}

onMounted(() => {

  userVerify.value = 1
  isFinalstep.value = 0
 
})

const SingleSelectOption = ref({
  closeOnSelect: true,
  searchable: true,
  clearable: false
})

const removeCustomer=()=>{

  userVerify.value = 1 // show customer info
  isFinalstep.value=0
    userId.value = ''
    store.updateBookingValues({ key: 'user_id', value: '' })
    store.updateUserValues({ key: 'email', value: ''})
    store.updateUserValues({ key: 'first_name', value: '' })
    store.updateUserValues({ key: 'last_name', value:'' })
    store.updateUserValues({ key: 'mobile', value: '' })
    store.updateUserValues({ key: 'gender', value: ''})
    store.updateUserValues({ key: 'profile_image', value: '' })
    userData.value = ''

}

const userVerify = ref(1) // open verify canvas

const isFinalstep = ref(0) // open create customer

const userId = ref(0)

const userData = ref('')
const petList = ref([])

const handleverifyUserResponse = (data) => {

  if (data != null) {
    userVerify.value = 2 // show customer info
    userId.value = data.id
    store.updateBookingValues({ key: 'user_id', value: data.user.id })
    store.updateUserValues({ key: 'email', value: data.user.email })
    store.updateUserValues({ key: 'first_name', value: data.user.first_name })
    store.updateUserValues({ key: 'last_name', value: data.user.last_name })
    store.updateUserValues({ key: 'mobile', value: data.user.mobile })
    store.updateUserValues({ key: 'gender', value: data.user.gender })
    store.updateUserValues({ key: 'profile_image', value: data.user.profile_image })
    userData.value = data.user
    isFinalstep.value = 1
    petList.value.options = buildMultiSelectObject(data.pet, { value: 'id', label: 'name' })
  } else {
    userVerify.value = 0
  }
}

const handleUserResponse = (data) => {

  if (data != null) {
    userVerify.value = 2
    userId.value = data.user.id
    userData.value = data.user
    store.updateBookingValues({ key: 'user_id', value: data.user.id })
    store.updateUserValues({ key: 'email', value: data.user.email })
    store.updateUserValues({ key: 'first_name', value: data.user.first_name })
    store.updateUserValues({ key: 'last_name', value: data.user.last_name })
    store.updateUserValues({ key: 'mobile', value: data.user.mobile })
    store.updateUserValues({ key: 'gender', value: data.user.gender })
    store.updateUserValues({ key: 'profile_image', value: data.user.profile_image })
    petList.value.options = buildMultiSelectObject(data.pet, { value: 'id', label: 'name' })
    isFinalstep.value = 1
  } else {
    userVerify.value = 0
  }
}

const isAddpet = ref(0)

const addpet = () => {
  isAddpet.value = 1
}

const handlePetResponse=(data)=>{


if (data != null) {
  petList.value.options = buildMultiSelectObject(data.user_pet, { value: 'id', label: 'name' })
  isAddpet.value = 0
} else {
  isAddpet.value = 1
}


}

const validationSchema = yup.object({
  //user_id: yup.string().required('User is required field'),
  pet: yup.string().required('Selecet Pet is a required Field')
})

const { handleSubmit, errors, resetForm } = useForm({
  validationSchema
})
const { value: user_id } = useField('user_id')
const { value: pet } = useField('pet')

const errorMessages = ref({})
const IS_SUBMITED = ref(false)

// phone number
const handleInput = (phone, phoneObject) => {
  // Handle the input event
  if (phoneObject?.formatted) {
    mobile.value = phoneObject.formatted
  }
}

// Form Submit
const emit = defineEmits(['tab-change', 'onReset'])
const prevTabChange = (val) => emit('tab-change', val)
const formSubmit = handleSubmit((values) => {
  IS_SUBMITED.value = true
  emit('tab-change', props.wizardNext)
})
const store = useQuickBooking()
watch(
  () => store.bookingResponse,
  (value) => {
    IS_SUBMITED.value = false
    resetForm(defaultData())
  },
  { deep: true }
)
watch(
  () => user_id.value,
  (value) => {
    store.updateBookingValues({ key: 'user_id', value: value })
  },
  { deep: true }
)

watch(
  () => pet.value,
  (value) => {
    store.updateBookingValues({ key: 'pet', value: value })
  },
  { deep: true }
)
</script>
