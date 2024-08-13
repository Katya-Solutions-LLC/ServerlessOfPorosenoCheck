<template>
  <form>
    <div :class="`offcanvas offcanvas-end offcanvas-booking`" data-bs-scroll="true" tabindex="-1" id="form-offcanvas" aria-labelledby="offcanvasBookingForm">
     
        <div class="offcanvas-header">
          <BookingHeader :currentId="currentId" :booking_id="id" :editTitle="editTitle" :createTitle="createTitle" :status="status" :is_paid="is_paid" @statusUpdate="updateStatus"></BookingHeader>
        </div>
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
            <!-- data-bs-toggle="modal" data-bs-target="#exampleModal" -->
            <div class="d-flex justify-content-between align-items-center">
              <label class="form-label d-block" v-if="!selectedCustomer"
                >{{ $t('booking.lbl_choose_customer') }} <span class="text-danger">*</span>
              </label>
              <span v-if="!selectedCustomer">
                <button type="button" data-bs-toggle="offcanvas" data-bs-target="#customer-form-offcanvas" class="btn btn-sm text-primary border-0 px-0 float-end"><i class="fa-solid fa-plus"></i> {{ $t('booking.addnew') }}</button>
              </span>
            </div>
            <!-- <label class="form-label d-block" v-if="!selectedCustomer"
              >{{ $t('booking.lbl_choose_customer') }} <span class="text-danger">*</span>
              <button type="button" data-bs-toggle="offcanvas" data-bs-target="#customer-form-offcanvas" class="btn btn-sm text-primary border-0 px-0 float-end"><i class="fa-solid fa-plus"></i> {{ $t('booking.addnew') }}</button>
            </label> -->
            
            <div class="user-block bg-white p-3 rounded" v-if="selectedCustomer">
              <div class="d-flex align-items-start gap-4 mb-2">
                <img :src="selectedCustomer.profile_image" alt="avatar" class="img-fluid avatar avatar-60 rounded-pill" />
                <div class="flex-grow-1">
                  <div class="gap-2">
                    <h5>{{ selectedCustomer.full_name }}</h5>
                    <p class="m-0">{{ $t('booking.lbl_pgroom') }} {{ moment(selectedCustomer.created_at).format('MMMM YYYY') }}</p>
                  </div>
                </div>
                <button type="button" v-if="status !== 'check_in' && !is_paid" @click="removeCustomer()" class="text-danger bg-transparent border-0"><i class="fa-regular fa-trash-can"></i></button>
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
                    <button type="button" data-bs-toggle="offcanvas" data-bs-target="#PetFromOffcanvas" class="btn btn-sm text-primary px-0 float-end"><i class="fa-solid fa-plus"></i> {{ $t('booking.addpet') }}</button>
                  </div>
                  <Multiselect id="pet" v-model="pet" :value="pet" placeholder="Select Pet" v-bind="SingleSelectOption" :options="pet_list.options" class="form-group"></Multiselect>
                  <div class="text-danger">{{ errors.pet }}</div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">{{ $t('booking.lbl_care_taker') }} <span class="text-danger">*</span> </label>
                  <Multiselect id="employee_id" v-model="employee_id" :value="employee_id" placeholder="Select Care Taker" v-bind="SingleSelectOption" :options="employee.options" class="form-group"></Multiselect>
                  <div class="text-danger">{{ errors.employee_id }}</div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="form-label" for="service">{{ $t('booking.lbl_add_facility') }} </label>
                  <Multiselect id="facility" v-model="facility" :multiple="true" :value="facility" placeholder="Select Facility" v-bind="multiSelectOption" :options="facility_list.options" class="form-group"> </Multiselect>
                  <span v-if="errorMessages['facility']">
                    <ul class="text-danger">
                      <li v-for="err in errorMessages['facility']" :key="err">{{ err }}</li>
                    </ul>
                  </span>
                  <div class="text-danger">{{ errors.facility }}</div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label class="form-label" for="drop_off_date">{{ $t('booking.lbl_drop_off_date') }} <span class="text-danger">*</span></label>
                  <flat-pickr placeholder="Drop Off Date" id="drop_off_date" class="form-control" @input="checkTotalAmount" v-model="drop_off_date" :value="drop_off_date" :config="config"></flat-pickr>
                  <div class="text-danger">{{ errors.drop_off_date }}</div>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label class="form-label" for="drop_off_time">{{ $t('booking.lbl_drop_off_time') }} <span class="text-danger">*</span></label>
                  <flat-pickr placeholder="Drop Off Time" id="drop_off_time" class="form-control" v-model="drop_off_time" :value="drop_off_time" :config="config_time"></flat-pickr>
                  <div class="text-danger">{{ errors.drop_off_time }}</div>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label class="form-label" for="pick_up_date">{{ $t('booking.lbl_pick_up_date') }} <span class="text-danger">*</span></label>
                  <flat-pickr placeholder="Pick Up Date" id="pick_up_date" @input="checkTotalAmount" class="form-control" v-model="pick_up_date" :value="pick_up_date" :config="config"></flat-pickr>
                  <div class="text-danger">{{ errors.pick_up_date }}</div>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label class="form-label" for="pick_up_time">{{ $t('booking.lbl_pick_up_time') }} <span class="text-danger">*</span></label>
                  <flat-pickr placeholder="Pick Up Time" id="pick_up_time" class="form-control" v-model="pick_up_time" :value="pick_up_time" :config="config_time"></flat-pickr>
                  <div class="text-danger">{{ errors.pick_up_time }}</div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-md-6">
                <label class="form-label" for="drop_off_address">{{ $t('booking.lbl_drop_off_pick_off_address') }}<span class="text-danger">*</span></label>
                <textarea class="form-control" v-model="drop_off_address" id="drop_off_address" disabled></textarea>
                <!-- <span v-if="errorMessages['drop_off_address']">
                  <ul class="text-danger">
                    <li v-for="err in errorMessages['drop_off_address']" :key="err">{{ err }}</li>
                  </ul>
                </span>
                <div class="text-danger">{{ errors.drop_off_address }}</div> -->
              </div>

              <div class="form-group col-md-6">
                <label class="form-label" for="addition_information">{{ $t('booking.lbl_addition_information') }}</label>
                <textarea class="form-control" v-model="addition_information" id="addition_information"></textarea>
                <span v-if="errorMessages['addition_information']">
                  <ul class="text-danger">
                    <li v-for="err in errorMessages['addition_information']" :key="err">{{ err }}</li>
                  </ul>
                </span>
                <div class="text-danger">{{ errors.addition_information }}</div>
              </div>
            </div>
          </div>
        </div>

        <div class="offcanvas-footer border-top">
          <div class="form-group m-0 p-3 d-flex justify-content-center bg-soft-primary rounded align-items-center">
            <label for=""
              ><h6 class="mb-0 pe-2 me-2 border-gray border-end">{{ $t('booking.amount') }}</h6>
            </label>
            <span id="totalAmountSpan" class="fw-bold">{{ formatCurrencyVue(totalAmount) }}</span>
            <small class="text-body ps-1">({{ formatCurrencyVue(totalTaxAmount) }} {{ $t('booking.tax_included') }})</small>
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
    
    </div>
  </form>

  <CustomerCreate :data="newCustomerData" @submit="externalFormCreation"></CustomerCreate>
  <PetFromOffcanvas createTitle="Create Pet"></PetFromOffcanvas>
  <CustomeFormOffcanvas createTitle="Create Customer"></CustomeFormOffcanvas>
</template>
<script setup>
import { ref, reactive, watch, onMounted, computed } from 'vue'
import FlatPickr from 'vue-flatpickr-component'
import { EDIT_URL, STORE_URL, UPDATE_URL } from '../constant/booking'
// Select Options List Request
import { EMPLOYEE_LIST, CUSTOMER_LIST, PET_LIST, BOOKING_PRICE, FACILITY_LIST, TAX_DATA, GET_ADDRESS } from '../constant/booking'
import { useField, useForm } from 'vee-validate'
import * as yup from 'yup'
import { useRequest, useModuleId, useOnOffcanvasHide, useOnOffcanvasShow } from '@/helpers/hooks/useCrudOpration'

// Modals
import CustomerCreate from '@/vue/components/Modal/CustomerCreate.vue'

// Element Component
import BookingHeader from './BookingFormElements/BookingHeader.vue'
import { useSelect } from '@/helpers/hooks/useSelect'
import PetFromOffcanvas from './Forms/PetFromOffcanvas.vue'
import CustomeFormOffcanvas from './Forms/CustomeFormOffcanvas.vue'
import moment from 'moment'

const { getRequest, storeRequest, updateRequest, listingRequest } = useRequest()
// Event Emits
const emit = defineEmits(['onSubmit'])

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
        totalAmount.value = res.data.amount

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

  listingRequest({ url: TAX_DATA, data: { tax_type: tax_type } }).then((res) => {
    tax_data.value = res.data
  })
}

const drop_off_address = ref()

const getAddress = () => {
  listingRequest({ url: GET_ADDRESS }).then((res) => {
    drop_off_address.value = res['address_line_1']+',\n'
                            +res['country']+',\n'
                            +res['state']+',\n'
                            +res['city']+'-'+res['postal_code']
  })
}

// Select Options
const singleSelectOption = ref({
  closeOnSelect: true,
  searchable: true
})

const pet_boarding_amount = ref(0)
const getBookingprice = () => {
  const type = 'pet_boarding_amount'

  listingRequest({ url: BOOKING_PRICE, data: { type: type } }).then((res) => {
    if (res.data) {
      pet_boarding_amount.value = res.data.val
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
  totalTaxAmount.value = tax_amount
  const total_amount = amount + tax_amount
  return total_amount
}

const checkTotalAmount = () => {
  if (drop_off_date.value != undefined && pick_up_date.value != undefined) {
    let startDate = new Date(drop_off_date.value)
    let endDate = new Date(pick_up_date.value)
    let difference = endDate.getTime() - startDate.getTime()

    if (difference > 1) {
      let TotalDays = Math.ceil(difference / (1000 * 3600 * 24)) + 1
      let amount = TotalDays * pet_boarding_amount.value
      let total_amount = taxCalculation(amount)
      totalAmount.value = total_amount
    } else {
      totalAmount.value = 0
      totalTaxAmount.value = 0
    }
  } else {
    totalAmount.value = 0
    totalTaxAmount.value = 0
  }
}

// Props
const props = defineProps({
  statusList: { type: Object },
  // bookingType: { type: String, default: 'GLOBAL_BOOKING' },
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

// flatepicker
const config_time = ref({
  dateFormat: 'H:i',
  time_24hr: true,
  enableTime: true,
  noCalendar: true,
  defaultHour: '00', // Update default hour to 9
  defaultMinute: '30'
})

const SingleSelectOption = ref({
  closeOnSelect: true,
  searchable: true,
  clearable: false
})

const pet_list = ref([])
const getPetList = (value) => {
  useSelect({ url: PET_LIST, data: { user_id: value } }, { value: 'id', label: 'name' }).then((data) => (pet_list.value = data))
}

const facility_list = ref([])
const getFacilityList = () => {
  useSelect({ url: FACILITY_LIST }, { value: 'slug', label: 'name' }).then((data) => (facility_list.value = data))
}

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
  user_id: yup.string().required('Customer is required'),
  pet: yup.string().required('Selecet Pet is a required Field'),
  drop_off_date: yup.string().required('Drop off Date is required'),
  drop_off_time: yup.string().required('Drop off Time is required'),
  pick_up_date: yup
    .string()
    .required('Pick Up Date is required')
    .when('drop_off_date', (dropOffDate, schema) => {
      return schema.test({
        name: 'pickUpDate',
        message: 'Pick Up Date must be after Drop Off Date',
        test: function (pickUpDate) {
          return !dropOffDate || !pickUpDate || new Date(pickUpDate) > new Date(dropOffDate);
        },
      });
    }),
  // pick_up_date: yup.string().required('Pick Up Date is required'),
  pick_up_time: yup.string().required('Pick Up Time is required'),
  // drop_off_address: yup.string().required('Address is required'),
  // pick_up_address: yup.string().required('Pick Up Address is required'),
  employee_id: yup.string().required('Care Taker is required')
})

const { handleSubmit, errors, resetForm } = useForm({ validationSchema })
const { value: id } = useField('id')
const { value: pet } = useField('pet')
const { value: facility } = useField('facility')
const { value: drop_off_date } = useField('drop_off_date')
const { value: drop_off_time } = useField('drop_off_time')
const { value: pick_up_date } = useField('pick_up_date')
const { value: pick_up_time } = useField('pick_up_time')
const { value: user_id } = useField('user_id')
// const { value: drop_off_address } = useField('drop_off_address')
const { value: addition_information } = useField('addition_information')
const { value: employee_id } = useField('employee_id')
const { value: start_date_time } = useField('start_date_time')
// const { value: pick_up_address } = useField('pick_up_address')

const errorMessages = ref({})

// Default FORM DATA
const defaultData = () => {
  errorMessages.value = {}
  return {
    id: null,
    pet: '',
    facility: [],
    drop_off_date: '',
    drop_off_time: '',
    pick_up_date: '',
    pick_up_time: '',
    // drop_off_address: '',
    addition_information: '',
    employee_id: '',
    user_id: ''
    // pick_up_address:'',
  }
}

//  Reset Form

const setFormData = (data) => {
  resetForm({
    values: {
      start_date_time: data.start_date_time,
      user_id: data.user_id,
      pet: data.pet_id,
      employee_id: data.employee_id,
      facility: data.facility,
      drop_off_date: data.dropoff_date,
      drop_off_time: data.dropoff_time,
      pick_up_date: data.pickup_date,
      pick_up_time: data.pickup_time,
      
      dropoff_address: data.dropoff_address,
      addition_information: data.booking_extra_info
      //  pick_up_address:data.pickup_address,
    }
  })
}

const multiSelectOption = ref({
  mode: 'tags',
  closeOnSelect: true,
  searchable: true
})

const employee = ref({ options: [], list: [] })
const customer = ref({ options: [], list: [] })

useOnOffcanvasHide('form-offcanvas', () => setFormData(defaultData()))

onMounted(() => {

  getCustomers()
  getemployee()
  //getPetList()
  gettaxData()
  getBookingprice()
  getFacilityList()
  getAddress()

})



const getCustomers = (cb) =>
  useSelect({ url: CUSTOMER_LIST }, { value: 'id', label: 'full_name' }).then((data) => {
    customer.value = data
    if (typeof cb == 'function') {
      cb()
    }
  })

const getemployee = (cb) =>
  useSelect({ url: EMPLOYEE_LIST }, { value: 'id', label: 'full_name' }).then((data) => {
    employee.value = data
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
// const slotSelect = () => {
//   resetServiceTime()
// }
// const removeSlot = () => {
//   resetServiceTime()
// }

//  Customer Select & Unselect & Selected Values
const selectedCustomer = computed(() => customer.value.list.find((customer) => customer.id == user_id.value) ?? null)
// const selectedEmployee = computed(() => employee.value.list.find((employee) => employee.id == employee_id.value) ?? null)
// const addCustomer = () => {}

const removeCustomer = () => {
  user_id.value = null
  services_id.value = []
  selectedService.value = []
}

const formSubmit = handleSubmit(async (values) => {
  const saveButton = document.getElementById('save-button');
  saveButton.disabled = true; 

  values.type = 'boarding'

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
