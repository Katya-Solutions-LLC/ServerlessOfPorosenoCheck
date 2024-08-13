<template>
    <div id="verifyCustomer">
      <form @submit="formSubmit">
        <div class="card-list-data">
          <div class="row">

            <div class="row">
            
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label" for="date">{{$t('quick_booking.date')}}<span
                        class="text-danger">*</span></label>
                    <flat-pickr placeholder="Date" id="date" class="form-control" v-model="date" :value="date"
                      :config="config"></flat-pickr>
                    <span class="text-danger">{{ errors.date }}</span>
                  </div>
                </div>
  
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label" for="time">{{$t('quick_booking.time')}}<span
                        class="text-danger">*</span></label>
                    <flat-pickr placeholder="Time" id="time" class="form-control" v-model="time" :value="time"
                      :config="config_time"></flat-pickr>
                    <span class="text-danger">{{ errors.time }}</span>
                  </div>
                </div>
              </div>
  
              <div class="row">
                
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label d-block">{{ $t('quick_booking.service') }} <span class="text-danger">*</span></label>
                    <Multiselect id="service" v-model="service" :value="service" placeholder="Select service"
                      @select="checkTotalAmount" :options="service_list.options" v-bind="SingleSelectOption"
                      class="form-group"></Multiselect>
                    <span class="text-danger">{{ errors.service }}</span>
                  </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">{{$t('quick_booking.groomer')}}<span class="text-danger">*</span> </label>
                      <Multiselect id="employee_id" v-model="employee_id" :value="employee_id" placeholder="Select Groomer"
                        v-bind="SingleSelectOption" :options="vet_list.options" class="form-group"></Multiselect>
                      <span class="text-danger">{{ errors.employee_id }}</span>
                    </div>  
                  </div>
              </div>
          </div>
          <div class="form-group m-0 p-3 d-flex justify-content-center bg-soft-primary rounded align-items-center">
            <label for="">
              <h6 class="mb-0 pe-2 me-2 border-end">{{$t('quick_booking.total_amount')}}</h6>
            </label>
            <span id="totalAmountSpan" class="fw-bold">{{ formatCurrencyVue(totalAmount) }}</span>
            <span class="text-body ps-1">({{$t('quick_booking.included')}} {{ formatCurrencyVue(totalTaxAmount) }} {{$t('quick_booking.tax')}})</span>
          </div>
          <!-- <button type="button" class="btn btn-secondary iq-text-uppercase" v-if="wizardPrev" @click="prevTabChange(wizardPrev)">Back</button> -->
         
        </div>
        <div class="card-footer">
          <button class="btn btn-primary iq-text-uppercase">{{$t('quick_booking.submit')}}</button>
        </div>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import { useField, useForm } from 'vee-validate'
  import * as yup from 'yup'
  import { useModuleId, useRequest, useOnOffcanvasHide } from '@/helpers/hooks/useCrudOpration'
  import InputField from '@/vue/components/form-elements/InputField.vue'
  import { GROOMING_SERVICE_LIST,GROOMER_LIST,TAX_DATA,SERVICE_PRICE,BOOKING_STORE_URL} from '@/vue/constants/quick_booking'
  import { useSelect } from '@/helpers/hooks/useSelect'
  import FlatPickr from 'vue-flatpickr-component'
  import moment from 'moment'
  
  const { getRequest, storeRequest, updateRequest, listingRequest } = useRequest()

  const emit = defineEmits(['store_grooming_booking'])

  const props = defineProps({

  user_id: { type: Number, default: 0 },
  pet_id: { type: Number, default: 0 },
  wizardPrev: {
    default: '',
    type: [String, Number]
  }

})

const formatCurrencyVue = (value) => {
  if (window.currencyFormat !== undefined) {
    return window.currencyFormat(value)
  }
  return value
}


const prevTabChange = (val) => emit('tab-change', val)


const tax_data = ref([])

const gettaxData = () => {

  listingRequest({ url: TAX_DATA }).then((res) => {
    tax_data.value = res.data;
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
      } else if (item.type === 'percent') {
        tax_amount += amount * (item.value / 100)
      }
    })
  }
  totalTaxAmount.value = tax_amount;
  const total_amount = amount + tax_amount
  return total_amount
}

const checkTotalAmount = () => {
  let serviceid = service.value

  getGroomerList(serviceid)

  listingRequest({ url: SERVICE_PRICE, data: { serviceid: serviceid } }).then((res) => {
    if (res.data) {
      let amount = res.data.default_price
      let total_amount = taxCalculation(amount);
      totalAmount.value = total_amount;
    }
  })

}

const current_date = ref(moment().format('YYYY-MM-DD'))
const config = ref({
  dateFormat: 'Y-m-d',
  static: true,
  minDate: 'today'
})

const config_time = ref({
  dateFormat: 'H:i',
  time_24hr: true,
  enableTime: true,
  noCalendar: true,
  defaultHour: '00', // Update default hour to 9
  defaultMinute: '30'
})

  onMounted(() => {
    getServiceList()
    gettaxData()
    setFormData(defaultData())
  })

  const vet_list = ref([])
const getGroomerList = (value) => {
  useSelect({ url: GROOMER_LIST, data: { service_id: value } }, { value: 'id', label: 'full_name' }).then((data) => (vet_list.value = data))
}


const service_list = ref([])
const getServiceList = () => {
  useSelect({ url: GROOMING_SERVICE_LIST }, { value: 'id', label: 'name' }).then((data) => (service_list.value = data))
}
  
  const defaultData = () => {
    errorMessages.value = {}
    return {

         id: null,
         date: '',
         time: '',
         pet: props.pet_id,
         employee_id: '',
         service: '',
         addition_information: '',
         user_id:props.user_id,
         start_date_time: ''
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


// Vee-Validation Validations
const validationSchema = yup.object({
  date: yup.string().required('Date is required'),
  time: yup.string().required('Time is required'),
  employee_id: yup.string().required('Groomer is required'),
  service: yup.string().required('Services is required'),
})

const { handleSubmit, errors, resetForm } = useForm({ validationSchema })
const { value: user_id } = useField('user_id')
const { value: pet } = useField('pet')
const { value: date } = useField('date')
const { value: time } = useField('time')
const { value: employee_id } = useField('employee_id')
const { value: status } = useField('status')
const { value: service } = useField('service')
const { value: addition_information } = useField('addition_information')

status.value = 'pending'


const errorMessages = ref({})

  const IS_SUBMITED = ref(false)


  // Form Submit
  const formSubmit = handleSubmit((values) => {
    values.type = 'grooming'
    values.pet=props.pet_id
    values.user_id=props.user_id
    values.addition_information=''

    storeRequest({ url: BOOKING_STORE_URL, body: values }).then((res) => {
      if(res.errors){

         alert(res.message)

      }else{
  
        emit('store_grooming_booking', res.data)
  
      }
   
    })
  })
  </script>