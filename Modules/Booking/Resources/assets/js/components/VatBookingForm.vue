<template>
  <form>
    <div :class="`offcanvas offcanvas-end offcanvas-booking`" data-bs-scroll="true" tabindex="-1" id="form-offcanvas" aria-labelledby="offcanvasBookingForm">
      <template v-if="SINLGE_STEP == 'MAIN' && status == 'completed'">
        <InvoiceComponent :booking_id="id"></InvoiceComponent>
      </template>
      <template v-else-if="SINLGE_STEP == 'MAIN' && status != 'checkout'">
        <div class="offcanvas-header">
          <BookingHeader :booking_id="id" :currentId="currentId" :editTitle="editTitle" :createTitle="createTitle" :status="status" :is_paid="is_paid" @statusUpdate="updateStatus"></BookingHeader>
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
              <strong v-else>{{ moment().format(' HH:mm') }}</strong>
            </div>
          </div>
        </div>
        <div class="offcanvas-body border-top">
          <div class="form-group">
            <div class="d-flex justify-content-between align-items-center">
              <label class="form-label d-block" v-if="!selectedCustomer"
                >{{ $t('booking.lbl_choose_customer') }} <span class="text-danger">*</span>
              </label>
              <span v-if="!selectedCustomer">
                <button type="button" data-bs-toggle="offcanvas" data-bs-target="#customer-form-offcanvas" class="btn btn-sm text-primary border-0 px-0 float-end"><i class="fa-solid fa-plus"></i> {{ $t('booking.addnew') }}</button>
              </span>
            </div>
            <div class="user-block bg-white p-3 rounded" v-if="selectedCustomer">
              <div class="d-flex align-items-start gap-3 mb-2">
                <img :src="selectedCustomer.profile_image" alt="avatar" class="img-fluid avatar avatar-60 rounded-pill" />
                <div class="flex-grow-1">
                  <div class="gap-2">
                    <h5>{{ selectedCustomer.full_name }}</h5>
                    <p class="m-0">{{ $t('booking.lbl_pgroom') }} {{ moment(selectedCustomer.created_at).format('MMMM YYYY') }}</p>
                  </div>
                </div>
                <button type="button" v-if="status !== 'check_in' && !is_paid" @click="removeCustomer()" class="btn btn-sm text-danger"><i class="fa-regular fa-trash-can"></i></button>
              </div>
              <div class="row m-0">
                <label class="col-3 p-0"
                  ><i
                    ><span class="fst-normal">{{ $t('booking.lbl_phone') }}</span></i
                  ></label
                >
                <strong class="col p-0">{{ selectedCustomer.mobile }}</strong>
              </div>
              <div class="row mx-0 mb-3">
                <label class="col-3 p-0"
                  ><i
                    ><span class="fst-normal">{{ $t('booking.lbl_e-mail') }}</span></i
                  ></label
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
                  <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label d-block"
                      >{{ $t('booking.lbl_choose_pet') }} <span class="text-danger">*</span>
                    </label>
                    <button type="button" class="btn text-primary btn-sm float-end px-0" data-bs-toggle="offcanvas" data-bs-target="#PetFromOffcanvas" aria-controls="form-offcanvas"><i class="fa-solid fa-plus"></i> {{ $t('booking.addpet') }}</button>
                  </div>
                  <Multiselect id="pet" v-model="pet" :value="pet" placeholder="Select Pet" v-bind="SingleSelectOption" :options="pet_list.options" class="form-group"></Multiselect>
                  <span class="text-danger">{{ errors.pet }}</span>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label class="form-label d-block" for="date">{{ $t('booking.lbl_date') }} <span class="text-danger">*</span></label>
                  <flat-pickr placeholder="Date" id="date" class="form-control" v-model="date" :value="date" :config="config"></flat-pickr>
                  <span class="text-danger">{{ errors.date }}</span>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label class="form-label" for="time">{{ $t('booking.lbl_time') }} <span class="text-danger">*</span></label>
                  <flat-pickr placeholder="Time" id="time" class="form-control" v-model="time" :value="time" :config="config_time"></flat-pickr>
                  <span class="text-danger">{{ errors.time }}</span>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label d-block"
                      >{{ $t('booking.lbl_veterinary_typedata') }} <span class="text-danger">*</span> 
                    </label>
                    <button type="button" class="btn text-primary btn-sm float-end px-0" data-bs-toggle="offcanvas" data-bs-target="#category-offcanvas" aria-controls="form-offcanvas"><i class="fa-solid fa-plus"></i> {{ $t('booking.addtype') }}</button>
                  </div>
                  <Multiselect id="veterinary_type" v-model="veterinary_type" :value="veterinary_type" @select="getServiceList" placeholder="Select veterinary category" v-bind="SingleSelectOption" :options="veterinary_type_list.options" class="form-group"></Multiselect>
                  <span class="text-danger">{{ errors.veterinary_type }}</span>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label d-block"
                    >{{ $t('booking.lbl_service') }} <span class="text-danger">*</span> <button type="button" class="btn text-primary btn-sm float-end px-0" data-bs-toggle="offcanvas" data-bs-target="#PetFromOffcanvas" aria-controls="form-offcanvas"><i class="fa-solid fa-plus"></i> {{ $t('booking.addtype') }}</button></label
                  >
                  <Multiselect id="service_id" v-model="service_id" :value="service_id" placeholder="Select service" @select="checkTotalAmount" :options="service_list.options" v-bind="SingleSelectOption" class="form-group"></Multiselect>
                  <span class="text-danger">{{ errors.service_id }}</span>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">{{ $t('booking.lbl_vet') }} <span class="text-danger">*</span> </label>
                  <Multiselect id="employee_id" v-model="employee_id" :value="employee_id" placeholder="Select Vet" v-bind="SingleSelectOption" :options="vet_list.options" class="form-group"></Multiselect>
                  <span class="text-danger">{{ errors.employee_id }}</span>
                </div>
              </div>

              <InputField class="col-md-6" type="text" :label="$t('booking.lbl_reason')" placeholder="" v-model="reason" :error-message="errors['reason']" :error-messages="errorMessages['reason']"></InputField>
            </div>

            <div class="form-group col-md-12">
              <div class="d-flex justify-content-between align-items-center">
                <label class="form-label" for="medical_report">{{ $t('booking.lbl_medical_report') }} </label>
                <a href="javascript:void(0)" v-if="medical_report" class="text-danger" @click="removeImage">{{ $t('booking.remove') }}</a>
              </div>
              <input type="file" class="form-control" id="medical_report" ref="refInput" @change="fileUpload" accept=".jpeg, .jpg, .png, .gif, .pdf" />
              <span v-if="errorMessages['medical_report']">
                <ul class="text-danger">
                  <li v-for="err in errorMessages['medical_report']" :key="err">{{ err }}</li>
                </ul>
              </span>
              <span class="text-danger">{{ errors.medical_report }}</span>
            </div>

            <div class="form-group col-md-12">
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
        <div class="offcanvas-footer border-top">
          <div class="form-group m-0 p-3 d-flex justify-content-center bg-soft-primary rounded align-items-center">
            <label for="">
              <h6 class="mb-0 pe-2 me-2 border-end">{{ $t('booking.amount') }}</h6>
            </label>
            <span id="totalAmountSpan" class="fw-bold">{{ formatCurrencyVue(totalAmount) }}</span>
            <small class="text-body ps-1">(Included {{ formatCurrencyVue(totalTaxAmount) }} tax)</small>
          </div>
          <div class="d-grid d-md-flex gap-3 pt-5">
            <div class="d-grid d-md-flex gap-3 p-3">
              <button class="btn btn-primary d-flex align-items-center gap-2 fw-600" id="save-button" @click="formSubmit" :disabled="totalAmount < 1">
                {{ $t('booking.btn_save') }}
                <i class="icon-disk"></i>
              </button>
              <button class="btn btn-soft-primary d-block fw-600" type="button" data-bs-dismiss="offcanvas">
                {{ $t('booking.btn_cancle') }}
                <i class="icon-Arrow---Right-2"></i>
              </button>
            </div>
          </div>
        </div>
      </template>
    </div>
  </form>

  <PetFromOffcanvas createTitle="Create Pet"></PetFromOffcanvas>
  <CategoryFormOffcanvas createTitle="Create new Category / Sub Category"></CategoryFormOffcanvas>
  <ServiceFormOffcanvas createTitle="Create Service"></ServiceFormOffcanvas>
  <CustomeFormOffcanvas createTitle="Create Customer"></CustomeFormOffcanvas>
</template>
<script setup>
import { ref, computed } from 'vue'
import FlatPickr from 'vue-flatpickr-component'
import { useBookingStore } from '../store/booking'
import { EDIT_URL, STORE_URL, UPDATE_URL } from '../constant/booking'
import InputField from '@/vue/components/form-elements/InputField.vue'
import { readFile } from '@/helpers/utilities'

// Select Options List Request
import { CUSTOMER_LIST, TAX_DATA, PET_LIST, VETERINARY_TYPE_LIST, VET_LIST, VETERINARY_SERVICE_LIST, SERVICE_PRICE } from '../constant/booking'

import { useField, useForm } from 'vee-validate'
import * as yup from 'yup'

import { useRequest, useModuleId, useOnOffcanvasHide, useOnOffcanvasShow } from '@/helpers/hooks/useCrudOpration'

// Element Component
import BookingHeader from './BookingFormElements/BookingHeader.vue'
import BookingStatus from './BookingFormElements/BookingStatus.vue'
import InvoiceComponent from './Forms/InvoiceComponent.vue'
import PetFromOffcanvas from './Forms/PetFromOffcanvas.vue'
import CategoryFormOffcanvas from './Forms/CategoryFormOffcanvas.vue'
import ServiceFormOffcanvas from './Forms/ServiceFormOffcanvas.vue'
import CustomeFormOffcanvas from './Forms/CustomeFormOffcanvas.vue'

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

// Event Emits
//const emit = defineEmits(['onSubmit'])

const formatCurrencyVue = (value) => {
  if (window.currencyFormat !== undefined) {
    return window.currencyFormat(value)
  }
  return value
}

const currentId = useModuleId(() => {
  if (currentId.value > 0) {
    getRequest({ url: EDIT_URL, id: currentId.value }).then((res) => {
      if (res.data) {
        totalAmount.value = res.data.veterinary.price

        setFormData(res.data)
      }
    })
  } else {
    totalAmount.value = 0
    totalTaxAmount.value = 0
    setFormData(defaultData())
  }
})

const tax_data = ref([])

const gettaxData = () => {
  const tax_type = 'services'
  listingRequest({ url: TAX_DATA , data: { tax_type: tax_type } }).then((res) => {
    tax_data.value = res.data
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
  totalTaxAmount.value = tax_amount
  const total_amount = amount + tax_amount
  return total_amount
}

const checkTotalAmount = () => {
  let serviceid = service_id.value

  getVetList(serviceid)

  listingRequest({ url: SERVICE_PRICE, data: { serviceid: serviceid } }).then((res) => {
    if (res.data) {
      let amount = res.data.default_price
      let total_amount = taxCalculation(amount)
      totalAmount.value = total_amount
    }
  })
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
        branch_id: null
      }
    }
  }
})
const IS_SUBMITED = ref(false)
const filterStatus = (value) => {
  if (props.statusList) {
    return props.statusList[value]
  }
  return { is_disabled: false }
}

const current_date = ref(moment().format('YYYY-MM-DD'))
const config = ref({
  dateFormat: 'Y-m-d',
  static: true,
  // minDate: 'today'
})

// Vee-Validation Validations
const validationSchema = yup.object({
  user_id: yup.string().required('Customer is required field'),
  date: yup.string().required('Date is required'),
  time: yup.string().required('Time is required'),
  pet: yup.string().required('Pet is a required Field'),
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

// Default FORM DATA
const defaultData = () => {
  errorMessages.value = {}
  return {
    id: null,
    date: '',
    time: '',
    pet: '',
    veterinary_type: '',
    employee_id: '',
    service_id: '',
    reason: '',
    addition_information: '',
    user_id: '',
    medical_report: null,
    start_date_time: ''
  }
}

//  Reset Form
const setFormData = (data) => {
  ImageViewer.value = data.medical_report
  resetForm({
    values: {
      date: data.date,
      time: data.time,
      pet: data.pet_id,
      veterinary_type: data.veterinary_type,
      employee_id: data.employee_id,
      service_id: data.service_id,
      reason: data.reason,
      addition_information: data.booking_extra_info,
      user_id: data.user_id,
      medical_report: data.medical_report,
      start_date_time: data.start_date_time
    }
  })
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

const customer = ref({ options: [], list: [] })
useOnOffcanvasHide('form-offcanvas', () => setFormData(defaultData()))
useOnOffcanvasShow('form-offcanvas', () => {
  getCustomers()
  // getPetList()
  getVeterinaryTypeList()
  getVetList()
  gettaxData()
  // getServiceList()
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
  if (_.isString(value)) {
    newCustomerData.value = {
      first_name: value.split(' ')[0] || '',
      last_name: value.split(' ')[1] || ''
    }
    bootstrap.Modal.getOrCreateInstance($('#exampleModal')).show()
    user_id.value = null
  }
}

// Select Options
const singleSelectOption = ref({
  closeOnSelect: true,
  searchable: true
})


//  Customer Select & Unselect & Selected Values
const selectedCustomer = computed(() => customer.value.list.find((customer) => customer.id == user_id.value) ?? null)

const removeCustomer = () => {
  user_id.value = null
}

const formSubmit = handleSubmit(async (values) => {
  const saveButton = document.getElementById('save-button');
  saveButton.disabled = true; 

  values.type = 'veterinary'

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
    totalAmount.value = 0
    setFormData(defaultData())
  } else {
    window.errorSnackbar(res.message)
    errorMessages.value = res.all_message
  }
}

const store = useBookingStore()
const SINLGE_STEP = computed(() => store.singleStep)

const updateStatus = (data) => {
  setFormData(data)
  emit('onSubmit')
}
</script>

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
