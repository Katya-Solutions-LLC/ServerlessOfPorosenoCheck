<template>
    <div id="verifyCustomer">
      <form @submit="formSubmit">
        <div class="card-list-data">
          <div class="row">

            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label d-block">{{ $t('booking.lbl_choose_pet') }} <span class="text-danger">*</span></label>
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

            <div class="row col-12 m-0">
              <div class="col-md-12 p-0">
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

            <div class="row col-12 m-0">
              <div class="col-md-3 p-0">
                <div class="form-group">
                  <label class="form-label" for="drop_off_date">{{ $t('booking.lbl_drop_off_date') }} <span class="text-danger">*</span></label>
                  <flat-pickr placeholder="Drop Off Date" id="drop_off_date" class="form-control"  @input="checkTotalAmount" v-model="drop_off_date" :value="drop_off_date" :config="config"></flat-pickr>
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
                <textarea class="form-control" v-model="drop_off_address" id="drop_off_address"></textarea>
                <span v-if="errorMessages['drop_off_address']">
                  <ul class="text-danger">
                    <li v-for="err in errorMessages['drop_off_address']" :key="err">{{ err }}</li>
                  </ul>
                </span>
                <div class="text-danger">{{ errors.drop_off_address }}</div>
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
  import { PET_LIST,FACILITY_LIST,EMPLOYEE_LIST } from '@/vue/constants/booking'
  import { useSelect } from '@/helpers/hooks/useSelect'
  
  const { getRequest, storeRequest, updateRequest, listingRequest } = useRequest()
  const emit = defineEmits(['add_user'])

  const props = defineProps({

  user_id: { type: Number, default: 0 },
  pet_id: { type: Number, default: 0 },

})

  
  onMounted(() => {
    getPetList()
    getFacilityList()
    getemployee()
    setFormData(defaultData())

  })
  
  const defaultData = () => {
    errorMessages.value = {}
    return {
     pet: props.pet_id,
    facility: [],
    drop_off_date: '',
    drop_off_time: '',
    pick_up_date: '',
    pick_up_time: '',
    drop_off_address:'',
    addition_information:'',
    employee_id:'',
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

  const pet_list = ref([])
const getPetList = () => {
  useSelect({ url: PET_LIST, data: { user_id: props.user_id } }, { value: 'id', label: 'name' }).then((data) => (pet_list.value = data))
}

const facility_list = ref([])
const getFacilityList = () => {
  useSelect({ url: FACILITY_LIST }, { value: 'slug', label: 'name' }).then((data) => (facility_list.value = data))
}
const employee = ref({ options: [], list: [] })
const getemployee = (cb) =>
  
  useSelect({ url: EMPLOYEE_LIST }, { value: 'id', label: 'full_name' }).then((data) => {
    employee.value = data
    if (typeof cb == 'function') {
      cb()
    }
  })
  
  const numberRegex = /^\d+$/
  let EMAIL_REGX = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/
  const validationSchema = yup.object({
    first_name: yup
      .string()
      .required('First Name is a required field')
      .test('is-string', 'Only strings are allowed', (value) => {
        // Regular expressions to disallow special characters and numbers
        const specialCharsRegex = /[!@#$%^&*(),.?":{}|<>\-_;'\/+=\[\]\\]/
        return !specialCharsRegex.test(value) && !numberRegex.test(value)
      }),
    last_name: yup
      .string()
      .required('Last Name is a required field')
      .test('is-string', 'Only strings are allowed', (value) => {
        // Regular expressions to disallow special characters and numbers
        const specialCharsRegex = /[!@#$%^&*(),.?":{}|<>\-_;'\/+=\[\]\\]/
        return !specialCharsRegex.test(value) && !numberRegex.test(value)
      }),
    email: yup.string().required('Email is a required field').matches(EMAIL_REGX, 'Must be a valid email'),
    mobile: yup
      .string()
      .required('Phone No is a required field')
      .matches(/^(\+?\d+)?(\s?\d+)*$/, 'Phone Number must contain only digits')
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
  const IS_SUBMITED = ref(false)
  
  // phone number
  const handleInput = (phone, phoneObject) => {
    // Handle the input event
    if (phoneObject?.formatted) {
      mobile.value = phoneObject.formatted
    }
  }
  
  const reset_datatable_close_offcanvas = (res) => {
    if (res.status) {
      window.successSnackbar(res.message)
      setFormData(defaultData())
    } else {
      window.errorSnackbar(res.message)
      errorMessages.value = res.all_message
    }
  }
  
  // Form Submit
  const formSubmit = handleSubmit((values) => {
    storeRequest({ url: STORE_CUSTOMER, body: values }).then((res) => {
      if(res.errors){
    
          alert(res.message)
  
      }else{
  
        emit('add_user', res.data)
  
      }
   
    })
  })
  </script>