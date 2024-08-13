<template>


    <div class="col" v-if="user">

      <div class="user-block bg-white p-3 rounded">
        <div class="d-flex align-items-start gap-3 mb-2">
          <img :src="user.profile_image" alt="avatar" class="img-fluid avatar avatar-60 rounded-pill" />
          <div class="flex-grow-1">
            <div class="gap-2 mt-3">
              <h5>{{ user.first_name }} {{ user.last_name }}</h5>
              
            </div>
          </div>
        
        </div>
        <div class="row m-0">
          <label class="col-3 p-0"><i><span class="fst-normal">Phone Number</span></i></label>
          <strong class="col p-0">{{ user.mobile }}</strong>
        </div>
        <div class="row mx-0 mb-3">
          <label class="col-3 p-0"><i><span class="fst-normal">Email</span></i></label>
          <strong class="col p-0">{{ user.email }}</strong>
        </div>
      </div>
    </div>

    <div class="boarding_booking" v-if="booking.service_id==1">

      <BoardingBooking :user_id="booking.user_id" :pet_id="booking.pet"  @boarding_booking="handleBoardingBooking"></BoardingBooking>

    </div>

    <div class="boarding_booking" v-if="booking.service_id==2 && isFinalstep==0">

      <VetBooking :user_id="booking.user_id" :pet_id="booking.pet" :wizardPrev="wizardPrev"  @store_vet_booking="handlevetBooking"></VetBooking>

    </div>

    <div class="boarding_booking" v-if="booking.service_id==3 && isFinalstep==0">

      <GroomingBooking :user_id="booking.user_id" :pet_id="booking.pet" :wizardPrev="wizardPrev"  @store_grooming_booking="handlevetBooking"></GroomingBooking>

    </div>



  <div class="card-footer" v-if="isFinalstep==1">
    <button type="button" class="btn btn-secondary iq-text-uppercase" v-if="wizardPrev" @click="prevTabChange(wizardPrev)">Back</button>
    <button class="btn btn-primary iq-text-uppercase" name="submit" v-if="wizardNext" @click="formSubmit">Submit</button>
  </div>
</template>

<script setup>
import { ref, watch,computed,} from 'vue'
import { useField, useForm } from 'vee-validate'
import { VueTelInput } from 'vue3-tel-input'
import InputField from '@/vue/components/form-elements/InputField.vue'
import * as yup from 'yup'
import { useQuickBooking } from '../../store/quick-booking'
import { buildMultiSelectObject } from '@/helpers/utilities'
import { useRequest } from '@/helpers/hooks/useCrudOpration'
import BoardingBooking from '../../quick-booking/BookingComponent/Bookings/BoardingBooking.vue'
import VetBooking from '../../quick-booking/BookingComponent/Bookings/VetBooking.vue'
import GroomingBooking from '../../quick-booking/BookingComponent/Bookings/GroomingBooking.vue'
import { GET_BOOKING_DATA } from '@/vue/constants/quick_booking'

const {  getRequest } = useRequest()


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
    user_id: '',
    pet: ''
  }
}

const SingleSelectOption = ref({
  closeOnSelect: true,
  searchable: true,
  clearable: false
})

const isFinalstep=ref(0)


const handlevetBooking=(data)=>{

if (data != null) {
  store.updateBookingValues({ key: 'booking_id', value: data.booking_data.id })
  getRequest({ url: GET_BOOKING_DATA, id: data.booking_data.id }).then((res) => {
      if (res.data) {
        store.updateBookingResponse(res.data)

      }
    })

     IS_SUBMITED.value = true
     emit('tab-change', props.wizardNext)

  }else{

 }
}



const validationSchema = yup.object({
  //user_id: yup.string().required('User is required field'),
 // pet: yup.string().required('Selecet Pet is a required Field')
})

const { handleSubmit, errors, resetForm } = useForm({
  validationSchema
})
const { value: user_id } = useField('user_id')
const { value: pet } = useField('pet')

const errorMessages = ref({})
const IS_SUBMITED = ref(false)

const store = useQuickBooking()
const booking = computed(() => store.booking)
const user = computed(() => store.user)



// Form Submit
const emit = defineEmits(['tab-change', 'onReset'])
const prevTabChange = (val) => emit('tab-change', val)
const formSubmit = handleSubmit((values) => {
  IS_SUBMITED.value = true
  emit('tab-change', props.wizardNext)
})

</script>