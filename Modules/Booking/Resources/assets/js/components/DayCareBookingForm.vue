<template>
  <form>
    <div :class="`offcanvas offcanvas-end offcanvas-booking`" data-bs-scroll="true" tabindex="-1" id="form-offcanvas" aria-labelledby="offcanvasBookingForm">
      <template v-if="SINLGE_STEP == 'MAIN' && status == 'completed'">
        <InvoiceComponent :booking_id="id"></InvoiceComponent>
      </template>
      <template v-else-if="SINLGE_STEP == 'MAIN' && status != 'checkout'">
        <div class="offcanvas-header">
          <BookingHeader :booking_id="id"  :currentId="currentId" :editTitle="editTitle" :createTitle="createTitle" :status="status" :is_paid="is_paid" @statusUpdate="updateStatus"></BookingHeader>
        </div>
        <BookingStatus v-if="id" :status="status" :booking_id="id" :status-list="statusList" :employee_id="employee_id" @statusUpdate="updateStatus"></BookingStatus>
        <div>
          <div class="d-flex text-center date-time d-none">
            <div class="col-6 py-3">
              <i>On</i> <strong v-if="start_date_time && start_date_time !== 'Invalid date'">{{ moment(start_date_time).format('D, MMM YYYY') }}</strong>
              <strong v-else> {{ moment(current_date).format('D, MMM YYYY') }}</strong>
            </div>
            <div class="col-6 py-3">
              <i>At</i> <strong v-if="start_date_time && start_date_time !== 'Invalid date'">{{ moment(start_date_time).format('HH:mm') }}</strong>
              <strong v-else>{{moment().format(' HH:mm')}}</strong>
            </div>
          </div>
        </div>
      
        <div class="offcanvas-body border-top">
      
          <div class="form-group">
            <!-- data-bs-toggle="modal" data-bs-target="#exampleModal" -->
            <div class="d-flex justify-content-between align-items-center">
              <label class="form-label d-block" v-if="!selectedCustomer"
                >{{ $t('booking.lbl_choose_customer') }} <span class="text-danger">*</span>
              </label>
              <span v-if="!selectedCustomer">
                <button type="button" data-bs-toggle="offcanvas" data-bs-target="#customer-form-offcanvas" class="btn btn-sm text-primary border-0 px-0 float-end"><i class="fa-solid fa-plus"></i> {{ $t('booking.addnew') }}</button>
              </span>
            </div>
            <div class="user-block bg-white p-3 rounded" v-if="selectedCustomer">
              <div class="d-flex align-items-start gap-4 mb-2">
                <img :src="selectedCustomer.profile_image" alt="avatar" class="img-fluid avatar avatar-60 rounded-pill" />
                <div class="flex-grow-1">
                  <div class="gap-2">
                    <h5>{{ selectedCustomer.full_name }}</h5>
                    <p class="m-0">
                      {{$t('booking.lbl_pgroom')}} {{ moment(selectedCustomer.created_at).format('MMMM YYYY') }}
                    </p>
                  </div>
                </div>
                <button type="button" v-if="status !== 'check_in' && !is_paid" @click="removeCustomer()" class="text-danger bg-transparent border-0"><i class="fa-regular fa-trash-can"></i></button>
              </div>
              <div class="row m-0">
                <label class="col-3 p-0"
                  ><i><span class="fst-normal">{{ $t('booking.lbl_phone') }}</span></i></label
                >
                <strong class="col p-0">{{ selectedCustomer.mobile }}</strong>
              </div>
              <div class="row mx-0 mb-3">
                <label class="col-3 p-0"
                  ><i><span class="fst-normal">{{ $t('booking.lbl_e-mail') }}</span></i></label
                >
                <strong class="col p-0">{{ selectedCustomer.email }}</strong>
              </div>
            </div>
            <Multiselect id="user_id" v-else v-model="user_id" placeholder="Select Customer" :disabled="is_paid || filterStatus(status).is_disabled" :value="user_id" v-bind="singleSelectOption" :options="customer.options" @select="customerSelect" class="form-group"></Multiselect>
            <span class="text-danger">{{ errors.user_id }}</span>
          </div>

          <div v-if="selectedCustomer">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label d-block" for="date">{{ $t('booking.lbl_date') }} <span class="text-danger">*</span></label>
                  <flat-pickr placeholder="Date" id="date" class="form-control d-block" @input="checkTotalAmount" v-model="date" :value="date" :config="config"></flat-pickr>
                  <span class="text-danger">{{ errors.date }}</span>
                </div>
              </div>

              <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center">
                  <label class="form-label d-block">{{ $t('booking.lbl_choose_pet') }} <span class="text-danger">*</span>
                  </label>
                  <button type="button" data-bs-toggle="offcanvas" data-bs-target="#PetFromOffcanvas" class="btn btn-sm text-primary px-0 float-end"><i class="fa-solid fa-plus"></i> {{$t('booking.addpet')}}</button> 
                </div>
                <Multiselect id="pet" v-model="pet" :value="pet" placeholder="Select Pet" v-bind="SingleSelectOption" :options="pet_list.options" class="form-group"></Multiselect>
                <span class="text-danger">{{ errors.pet }}</span>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label class="form-label" for="drop_off_time">{{ $t('booking.lbl_drop_off_time') }} <span class="text-danger">*</span></label>
                  <flat-pickr placeholder="Drop Off Time" id="drop_off_time" class="form-control" v-model="drop_off_time" :value="drop_off_time" :config="config_time"></flat-pickr>
                  <span class="text-danger">{{ errors.drop_off_time }}</span>
                </div>
              </div>
              
              <div class="col-md-3">
                <div class="form-group">
                  <label class="form-label" for="pick_up_time">{{ $t('booking.lbl_pick_up_time') }} <span class="text-danger">*</span></label>
                  <flat-pickr placeholder="Pick Up Time" id="pick_up_time" class="form-control" v-model="pick_up_time" :value="pick_up_time" :config="config_time"></flat-pickr>
                  <span class="text-danger">{{ errors.pick_up_time }}</span>
                </div>
              </div>

              <div class="col-md-6 form-group">
                <label class="form-label">{{ $t('booking.lbl_daycare_taker') }} <span class="text-danger">*</span> </label>
                <Multiselect id="employee_id" v-model="employee_id" :value="employee_id" placeholder="Select DayCare Taker" v-bind="SingleSelectOption" :options="daycare_taker_list.options" class="form-group"></Multiselect>
                <span class="text-danger">{{ errors.employee_id }}</span>
              </div>
            </div>

            <div class="row">
              <InputField class="col-md-6" type="text" :label="$t('booking.lbl_favorite_activity')" placeholder="Favorite Activity" v-model="favorite_activity" :error-message="errors['favorite_activity']" :error-messages="errorMessages['favorite_activity']"></InputField>
              <InputField class="col-md-6" type="text" :label="$t('booking.lbl_favorite_food')" placeholder="Favorite Food" v-model="favorite_food" :error-message="errors['favorite_food']" :error-messages="errorMessages['favorite_food']"></InputField>
            </div>

            <div class="row">
              <div class="form-group col-md-6">
                <label class="form-label" for="address">{{ $t('booking.lbl_address') }} <span class="text-danger">*</span></label>
                <textarea class="form-control" v-model="address" id="address" disabled></textarea>
                <!-- <span v-if="errorMessages['address']">
                  <ul class="text-danger">
                    <li v-for="err in errorMessages['address']" :key="err">{{ err }}</li>
                  </ul>
                </span>
                <span class="text-danger">{{ errors.address }}</span> -->
              </div>

              <div class="col-md-6 form-group">
                <label class="form-label" for="addition_information">{{ $t('booking.lbl_addition_information') }}</label>
                <textarea class="form-control" v-model="addition_information" id="addition_information"></textarea>
                <span v-if="errorMessages['addition_information']">
                  <ul class="text-danger">
                    <li v-for="err in errorMessages['addition_information']" :key="err">{{ err }}</li>
                  </ul>
                </span>
                <span class="text-danger">{{ errors.addition_information }}</span>
              </div>
            </div>

          </div>
        </div>


        <div class="offcanvas-footer border-top">
          <div class="form-group m-0 p-3 d-flex justify-content-center bg-soft-primary rounded align-items-center">
            <label for="">
              <h6 class="mb-0 pe-2 me-2 border-end">{{ $t('booking.amount') }} </h6>
            </label>
            <span id="totalAmountSpan" class="fw-bold">{{ formatCurrencyVue(totalAmount) }}</span>
            <small class="text-body ps-1">({{$t('booking.included')}} {{ formatCurrencyVue(totalTaxAmount) }} {{$t('booking.tax')}})</small>
          </div>
          <div class="d-grid d-md-flex gap-3 pt-5">
          
          
          <div class="d-grid d-md-flex gap-3 p-3">
            <button class="btn btn-primary  d-flex align-items-center gap-2 fw-600" id="save-button" @click="formSubmit"
              :disabled="totalAmount < 1">
              {{$t('booking.btn_save')}}
              <i class="icon-disk"></i>
            </button>
            <button class="btn btn-soft-primary d-block fw-600" type="button" data-bs-dismiss="offcanvas">
              {{$t('booking.btn_cancle')}}
              <i class="icon-Arrow---Right-2"></i>
            </button>
          </div>
        </div>
        </div>
      </template>
      
    </div>
  </form>

</template>
<script setup>
import { ref, computed } from 'vue'
import FlatPickr from 'vue-flatpickr-component'
import { useBookingStore } from '../store/booking'
import { EDIT_URL, STORE_URL, UPDATE_URL} from '../constant/booking'
import InputField from '@/vue/components/form-elements/InputField.vue'
import { readFile } from '@/helpers/utilities'

// Select Options List Request
import { CUSTOMER_LIST, PET_LIST, DAYCARE_TAKER_LIST,TAX_DATA,BOOKING_PRICE, GET_ADDRESS} from '../constant/booking'


import { useField, useForm } from 'vee-validate'
import * as yup from 'yup'

import { useRequest, useModuleId, useOnOffcanvasHide, useOnOffcanvasShow } from '@/helpers/hooks/useCrudOpration'


// Element Component
import BookingHeader from './BookingFormElements/BookingHeader.vue'
import BookingStatus from './BookingFormElements/BookingStatus.vue'
import InvoiceComponent from './Forms/InvoiceComponent.vue'

import { useSelect } from '@/helpers/hooks/useSelect'
import moment from 'moment'

const { getRequest, storeRequest, updateRequest, listingRequest } = useRequest()

// File Upload Function
const ImageViewer = ref(null)
const fileUpload = async (e) => {
  let file = e.target.files[0]
  await readFile(file, (fileB64) => {
    ImageViewer.value = fileB64
  })
  medical_report.value = file
}

// Select Options
const singleSelectOption = ref({
  closeOnSelect: true,
  searchable: true
})

const address = ref()

const getAddress = () => {
  listingRequest({ url: GET_ADDRESS }).then((res) => {
    address.value = res['address_line_1']+',\n'
                            +res['country']+',\n'
                            +res['state']+',\n'
                            +res['city']+'-'+res['postal_code']
  })
}


const formatCurrencyVue = (value) => {
  if(window.currencyFormat !== undefined) {
    return window.currencyFormat(value)
  }
  return value
}
// Props
const props = defineProps({
  statusList: { type: Object },
  bookingType: { type: String, default: 'GLOBAL_BOOKING' },
  createTitle: { type: String, default: '' },
  editTitle: { type: String, default: '' },
  bookingData: {
    default: () => {
      return {
        id: 0,
        employee_id: null,
        start_date_time: null,
       // branch_id: null
      }
    }
  }
})
const IS_SUBMITED = ref(false)
const filterStatus = (value) => {
  if(props.statusList) {
    return props.statusList[value]
  }
  return {is_disabled: false}
}

const current_date = ref(moment().format('YYYY-MM-DD'))
const config = ref({
  dateFormat: 'Y-m-d',
  static: true,
  // minDate: 'today',
})

const currentId = useModuleId(() => {
  if (currentId.value > 0) {
     getRequest({ url: EDIT_URL, id: currentId.value }).then((res) => {
      if(res.data) {

          totalAmount.value=res.data.price
      
         setFormData(res.data)
         }
      })
     } else {

      totalAmount.value=0  
      totalTaxAmount.value=0
     setFormData(defaultData())
   }
 })

// Vee-Validation Validations
const validationSchema = yup.object({
  user_id: yup.string().required('Customer is required field'),
  pet: yup.string().required('Selecet Pet is a required Field'),
  date: yup.string().required('Date is required'),
  drop_off_time: yup.string().required('Drop off Time is required'),
  pick_up_time: yup.string().required('Pick Up Time is required'),
  // address: yup.string().required('Address is required'),
  employee_id:yup.string().required('Day Care Taker is required'),
})

const { handleSubmit, errors, resetForm } = useForm({ validationSchema })

const { value: pet } = useField('pet')
const { value: date } = useField('date')
const { value: drop_off_time } = useField('drop_off_time')
const { value: pick_up_time } = useField('pick_up_time')
const { value: user_id } = useField('user_id')
const { value: addition_information } = useField('addition_information')
const { value: employee_id } = useField('employee_id')
// const { value: address } = useField('address')
const { value: favorite_activity } = useField('favorite_activity')
const { value: favorite_food } = useField('favorite_food')
const { value: start_date_time } = useField('start_date_time')
const { value: status } = useField('status')


status.value = 'pending'

const errorMessages = ref({})

// Default FORM DATA
const defaultData = () => {
  errorMessages.value = {}
  return {
    pet: '',
    date: '',
    drop_off_time: '',
    pick_up_time: '',
    // address:'',
    addition_information:'',
    employee_id:'',
    user_id:'',
    favorite_activity:'',
    favorite_food:'',
  }
}

//  Reset Form
const setFormData = (data) => {

  resetForm({
    values: {

         pet: data.pet_id,
         date: data.date,
         drop_off_time: data.dropoff_time,
         pick_up_time: data.pickup_time,
         address:data.address,
         addition_information:data.booking_extra_info,
         employee_id:data.employee_id,
         user_id:data.user_id,
         favorite_activity:data.food,
         favorite_food:data.activity,
    }
  })
}


const tax_data=ref([])

const gettaxData =()=>{
 const tax_type = 'services'
 listingRequest({ url: TAX_DATA, data: { tax_type: tax_type } }).then((res) => {
   tax_data.value=res.data;
 })
}

const pet_daycare_amount=ref(0)
const getBookingprice=()=>{

  const type = 'pet_daycare_amount'

  listingRequest({ url: BOOKING_PRICE, data: { type: type } }).then((res) => {
   if (res.data) {
    const type = 'pet_daycare_amount'
     pet_daycare_amount.value = res.data.val
  
   }
 })

}
const totalAmount = ref(0)
const totalTaxAmount = ref(0)

const taxCalculation = (amount) => {

   let tax_amount = 0
   if (tax_data.value && Array.isArray(tax_data.value)) {
     tax_data.value.forEach((item) => {
       if (item.type === 'fixed') {
         tax_amount += item.value
       } else if (item.type === 'percentage') {
         tax_amount += amount * (item.value / 100)
       }
     })
   }
   totalTaxAmount.value=tax_amount;
   const total_amount = amount + tax_amount
   return total_amount
}

const checkTotalAmount = () => {
if(date.value !=''){

  const type = 'pet_daycare_amount'
  let pet_daycare_amount = 0

  listingRequest({ url: BOOKING_PRICE, data: { type: type } }).then((res) => {
    if (res.data) {
      pet_daycare_amount = res.data.val
      let amount =parseFloat(pet_daycare_amount)
      let total_amount = taxCalculation(amount);
      totalAmount.value = total_amount;
    }
  })
 }
   totalAmount.value = 0
}

const formSubmit = handleSubmit(async (values) => {
  const saveButton = document.getElementById('save-button');
  saveButton.disabled = true; 

  values.type = 'daycare'

  try {
    if (currentId.value > 0) {
      await updateRequest({ url: UPDATE_URL, id: currentId.value, body: values }).then((res) => reset_datatable_close_offcanvas(res))
    } else {
      await storeRequest({ url: STORE_URL, body: values }).then((res) => reset_datatable_close_offcanvas(res))
      document.getElementById('feature_image').value = '';
    }
  } catch (error) {
    console.error('Error:', error);
  } finally {
    saveButton.disabled = false;  
  }
});

const reset_datatable_close_offcanvas = (res) => {
if (res.status) {
 window.successSnackbar(res.message)
 renderedDataTable.ajax.reload(null, false)
 bootstrap.Offcanvas.getInstance('#form-offcanvas').hide()
   totalAmount.value=0
 setFormData(defaultData())
} else {
 window.errorSnackbar(res.message)
 errorMessages.value = res.all_message
}
}

// flatepicker
const config_time = ref({
  dateFormat: 'H:i',
  time_24hr: true,
  enableTime: true,
  noCalendar: true,
  defaultHour: '00', // Update default hour to 9
  defaultMinute: '30'
})

// Select Options
const SingleSelectOption = ref({
  closeOnSelect: true,
  searchable: true,
  clearable: false
})


const pet_list = ref([])
const getPetList = (value) => {
  useSelect({ url: PET_LIST, data: { user_id: value } }, { value: 'id', label: 'name' }).then((data) => (pet_list.value = data))
}

const daycare_taker_list = ref([])
const getDaycareTakerList = () => {
  useSelect({ url: DAYCARE_TAKER_LIST }, { value: 'id', label: 'full_name' }).then((data) => (daycare_taker_list.value = data))
}

const customer = ref({ options: [], list: [] })

useOnOffcanvasHide('form-offcanvas', () => setFormData(defaultData()))
useOnOffcanvasShow('form-offcanvas', () => {

  getCustomers()
  //getPetList()
  gettaxData()
  getBookingprice()
  getDaycareTakerList()
  getAddress()
  
})

const getCustomers = (cb) =>
  useSelect({ url: CUSTOMER_LIST }, { value: 'id', label: 'full_name' }).then((data) => {
    customer.value = data
    if (typeof cb == 'function') {
      cb()
    }
  })
  

const newCustomerData = ref(null)
const customerSelect = (value) => {
  getPetList(value)
  if(_.isString(value)) {
    newCustomerData.value = {
      first_name: value.split(" ")[0] || '',
      last_name: value.split(" ")[1] || ''
    }
    bootstrap.Modal.getOrCreateInstance($('#exampleModal')).show()
    user_id.value = null
  }
}

const selectedCustomer = computed(() => customer.value.list.find((customer) => customer.id == user_id.value) ?? null)

const removeCustomer = () => {
  user_id.value = null
  services_id.value = []
  selectedService.value = []
}


const store = useBookingStore()
const SINLGE_STEP = computed(() => store.singleStep)

const updateStatus = (data) => {
  setFormData(data)
  emit('onSubmit')
}


</script>

<style >
.flatpickr-wrapper{
  width: 100% !important;
  display: block;
}
</style> 

<style scoped>
.offcanvas {
  box-shadow: none;
}
.service-duration {
  position: absolute;
  /* padding: 2px 8px; */
  bottom: -16px;
  border-radius: 0;
  border-bottom-left-radius: 4px;
  border-bottom-right-radius: 4px;
  right: 0;
}

.border-br-radius-0 {
  border-bottom-right-radius: 0;
}

[dir='rtl'] .border-br-radius-0 {
  border-bottom-left-radius: 0;
}
.date-time {
  border-top: 1px solid var(--bs-border-color);
}
.date-time > div:not(:first-child) {
  border-left: 1px solid var(--bs-border-color);
}
.list-group-flush > .list-group-item {
  color: var(--bs-body-color);
}

@media only screen and (min-width: 768px) {
  .offcanvas {
    width: 80%;
  }
}

@media only screen and (min-width: 1280px) {
  .offcanvas {
    width: 60%;
  }
}
</style>
