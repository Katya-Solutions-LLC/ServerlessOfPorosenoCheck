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
                    <label class="form-label d-block"> {{$t('quick_booking.veterinary')}}<span class="text-danger">*</span>
                      </label>
                    <Multiselect id="veterinary_type" v-model="veterinary_type" :value="veterinary_type"
                      @select="getServiceList" placeholder="Select veterinary category" v-bind="SingleSelectOption"
                      :options="veterinary_type_list.options" class="form-group"></Multiselect>
                    <span class="text-danger">{{ errors.veterinary_type }}</span>
                  </div>  
                </div>
  
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label d-block">{{ $t('quick_booking.service') }} <span class="text-danger">*</span></label>
                    <Multiselect id="service_id" v-model="service_id" :value="service_id" placeholder="Select service"
                      @select="checkTotalAmount" :options="service_list.options" v-bind="SingleSelectOption"
                      class="form-group"></Multiselect>
                    <span class="text-danger">{{ errors.service_id }}</span>
                  </div>
                </div>
  
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">{{$t('quick_booking.vet')}}<span class="text-danger">*</span> </label>
                      <Multiselect id="employee_id" v-model="employee_id" :value="employee_id" placeholder="Select Vet"
                        v-bind="SingleSelectOption" :options="vet_list.options" class="form-group"></Multiselect>
                      <span class="text-danger">{{ errors.employee_id }}</span>
                    </div>  
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
  import { VETERINARY_TYPE_LIST,VETERINARY_SERVICE_LIST,VET_LIST,TAX_DATA,SERVICE_PRICE,BOOKING_STORE_URL} from '@/vue/constants/quick_booking'
  import { useSelect } from '@/helpers/hooks/useSelect'
  import FlatPickr from 'vue-flatpickr-component'
  import moment from 'moment'
  
  const { getRequest, storeRequest, updateRequest, listingRequest } = useRequest()

  const emit = defineEmits(['store_vet_booking'])

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
  let serviceid = service_id.value

  getVetList(serviceid)

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
    getVeterinaryTypeList()
    gettaxData()
    setFormData(defaultData())
  })

  const vet_list = ref([])
const getVetList = (value) => {
  useSelect({ url: VET_LIST, data: { service_id: value } }, { value: 'id', label: 'full_name' }).then((data) => (vet_list.value = data))
}

const veterinary_type_list = ref([])
const getVeterinaryTypeList = () => {
  useSelect({ url: VETERINARY_TYPE_LIST }, { value: 'id', label: 'name' }).then((data) => (veterinary_type_list.value = data))
}

const service_list = ref([])
const getServiceList = () => {
  let veterinarytype = veterinary_type.value
  useSelect({ url: VETERINARY_SERVICE_LIST, data: { veterinarytype: veterinarytype } }, { value: 'id', label: 'name' }).then((data) => (service_list.value = data))
}
  
  const defaultData = () => {
    errorMessages.value = {}
    return {

         id: null,
         date: '',
         time: '',
         pet: props.pet_id,
         veterinary_type: '',
         employee_id: '',
         service_id: '',
         reason: '',
         addition_information: '',
         user_id:props.user_id,
         medical_report: null,
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
  veterinary_type: yup.string().required('Veterinary Type is required'),
  employee_id: yup.string().required('Vat is required'),
  service_id: yup.string().required('Service is required')
})

const { handleSubmit, errors, resetForm } = useForm({ validationSchema })
const { value: id } = useField('id')
const { value: date } = useField('date')
const { value: time } = useField('time')
const { value: pet } = useField('pet')
const { value: veterinary_type } = useField('veterinary_type')
const { value: employee_id } = useField('employee_id')
const { value: service_id } = useField('service_id')
const { value: reason } = useField('reason')
const { value: addition_information } = useField('addition_information')
const { value: user_id } = useField('user_id')
const { value: start_date_time } = useField('start_date_time')
const { value: medical_report } = useField('medical_report')


const errorMessages = ref({})

  const IS_SUBMITED = ref(false)


  // Form Submit
  const formSubmit = handleSubmit((values) => {
    values.type = 'veterinary'
    values.pet=props.pet_id
    values.user_id=props.user_id
    values.reason=''
    values.addition_information=''
    values.medical_report=''

    storeRequest({ url: BOOKING_STORE_URL, body: values }).then((res) => {
      if(res.errors){

         alert(res.message)

      }else{
  
        emit('store_vet_booking', res.data)
  
      }
   
    })
  })
  </script>