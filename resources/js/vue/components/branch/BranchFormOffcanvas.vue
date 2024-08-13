<template>
  <form @submit="formSubmit">
    <div class="offcanvas offcanvas-end offcanvas-booking" tabindex="-1" id="form-offcanvas" aria-labelledby="form-offcanvasLabel">
      <FormHeader :currentId="currentId" :editTitle="editTitle" :createTitle="createTitle"></FormHeader>
      <div class="offcanvas-body">
        <div class="row">
          <div class="col-12 row">

            <InputField class="col-md-12" :is-required="true" :label="$t('branch.lbl_branch_name')" placeholder="" v-model="name" :error-message="errors.name" :error-messages="errorMessages['name']"></InputField>

            <!-- <div class="form-group col-md-6">
              <label class="form-label">{{ $t('branch.lbl_branch_for') }}</label>
              <div class="btn-group w-100" role="group" aria-label="Basic example">
                <template v-for="(item, index) in BRANCH_FOR_OPTIONS" :key="index">
                  <input type="radio" class="btn-check" name="branch_for" :id="`${item.id}-for`" :value="item.id" autocomplete="off" v-model="branch_for" :checked="branch_for == item.id" />
                  <label class="btn btn-outline-primary" :for="`${item.id}-for`">{{ item.text }}</label>
                </template>
              </div>
            </div> -->
            <!-- <div class="form-group col-md-6">
              <div class="d-flex justify-content-between">
                <label for="manager_id">{{ $t('branch.lbl_select_manager') }} <span class="text-danger">*</span></label>
                <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-sm text-primary"><i class="fa-solid fa-plus"></i> Create New</button>
              </div>
              <Multiselect v-model="manager_id" :value="manager_id" :options="manager.options" v-bind="singleSelectOption" id="manager_id"></Multiselect>
               <span v-if="errorMessages['manager_id']">
                <ul class="text-danger">
                  <li v-for="err in errorMessages['manager_id']" :key="err">{{ err }}</li>
                </ul>
              </span>
              <span class="text-danger">{{ errors.manager_id }}</span>
            </div> -->

            <div class="form-group col-md-12">
              <label class="form-label" for="services">{{ $t('branch.lbl_select_service') }}</label>
              <Multiselect v-model="service_id" :value="service_id" :options="service.options" v-bind="multiselectOption" id="services"></Multiselect>
            </div>
            <div class="form-group col-md-6">
              <label class="form-label"> {{ $t('branch.lbl_contact_number') }} <span class="text-danger">*</span> </label>
              <vue-tel-input type="number" :value="contact_number" @input="handleInput" v-bind="{mode: 'international',maxLen: 15}" class="form-control"></vue-tel-input>
              <span class="text-danger">{{ errors['contact_number'] }}</span>
            </div>
            <InputField class="col-md-6" :is-required="true" :label="$t('branch.lbl_contact_email')" placeholder="" v-model="contact_email" :error-message="errors.contact_email" :error-messages="errorMessages['contact_email']"></InputField>
            <InputField class="col-md-6" :is-required="true" :label="$t('branch.lbl_shop_number')" placeholder="" v-model="address_line_1" :error-message="errors['address.address_line_1']" :error-messages="errorMessages['address_line_1']"></InputField>
            <InputField class="col-md-6" :label="$t('branch.lbl_landmark')" placeholder="" v-model="address_line_2" :error-message="errors['address.address_line_2']" :error-messages="errorMessages['address_line_2']"></InputField>
            <InputField class="col-md-2" :is-required="true" :label="$t('branch.lbl_country')" placeholder="" v-model="country" :error-message="errors['address.country']" :error-messages="errorMessages['country']"></InputField>
            <InputField class="col-md-2" :is-required="true" :label="$t('branch.lbl_state')" placeholder="" v-model="state" :error-message="errors['address.state']" :error-messages="errorMessages['state']"></InputField>
            <InputField class="col-md-2" :is-required="true" :label="$t('branch.lbl_city')" placeholder="" v-model="city" :error-message="errors['address.city']" :error-messages="errorMessages['city']"></InputField>
            <InputField class="col-md-2" type="number" :is-required="true" :label="$t('branch.lbl_postal_code')" placeholder="" v-model="postal_code" :error-message="errors['address.postal_code']" :error-messages="errorMessages['postal_code']"></InputField>
            <InputField class="col-md-2" :is-required="true" :label="$t('branch.lbl_lat')" placeholder="" v-model="latitude" :error-message="errors['address.latitude']" :error-messages="errorMessages['latitude']"></InputField>
            <InputField class="col-md-2" :is-required="true" :label="$t('branch.lbl_long')" placeholder="" v-model="longitude" :error-message="errors['address.longitude']" :error-messages="errorMessages['longitude']"></InputField>


              <div class="form-group col-md-6">
              <label class="form-label" for="payment-method">{{ $t('branch.lbl_payment_method') }} <span class="text-danger">*</span></label>
              <div class="d-flex w-100 gap-3" role="group" aria-label="Basic checkbox toggle button group">
                <template v-for="(item, index) in PAYMENT_METHODS_OPTIONS" :key="index">
                  <div class="d-flex gap-3 form-check">
                    <input type="checkbox" class="form-check-input" :id="`${item.id}-payment-method`" autocomplete="off" :value="item.id" v-model="payment_method" :checked="payment_method.includes(item.id)" />
                    <label class="form-label mb-0" :for="`${item.id}-payment-method`">{{ item.text }}</label>
                  </div>
                </template>
              </div>
              <span class="text-danger">{{ errors.payment_method }}</span>
            </div>

             <div class="form-group col-md-6">
              <label class="form-label" for="feature_image">{{ $t('branch.lbl_feature_image') }}</label>
              <input type="file" class="form-control" id="feature_image" @change="fileUpload" accept=".jpeg, .jpg, .png, .gif" />
              <span v-if="errorMessages['feature_image']">
                <ul class="text-danger">
                  <li v-for="err in errorMessages['feature_image']" :key="err">{{ err }}</li>
                </ul>
              </span>
              <span class="text-danger">{{ errors.feature_image }}</span>
            </div>


            <div class="form-group col-md-12">
              <label class="form-label" for="description">{{$t('branch.lbl_description')}}</label>
              <textarea class="form-control" v-model="description" id="description"></textarea>
              <span v-if="errorMessages['description']">
                <ul class="text-danger">
                  <li v-for="err in errorMessages['description']" :key="err">{{ err }}</li>
                </ul>
              </span>
              <span class="text-danger">{{ errors.description }}</span>
            </div>
            <!-- <InputField class="col-md-12" :is-required="true" :label="$t('branch.lbl_description')" placeholder="" v-model="description" :error-message="errors.description" :error-messages="errorMessages['description']"></InputField> -->

            <div v-for="field in customefield" :key="field.id">
              <FormElement v-model="custom_fields_data" :name="field.name" :label="field.label" :type="field.type" :required="field.required" :options="field.value"  :field_id="field.id"  ></FormElement>            </div>

            <div class="form-group col-md-2 ">
              <div class="d-flex gap-3">
                <label class="form-label" for="category-status">{{$t('branch.lbl_status')}}</label>
                <div class="form-check form-switch">
                  <input class="form-check-input" :value="status" :checked="status" name="status" id="category-status" type="checkbox" v-model="status" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <FormFooter></FormFooter>
    </div>
  </form>
  <!-- <EmployeeCreate @submit="updateManagerDetail"></EmployeeCreate> -->
</template>
<script setup>
import { ref, reactive, onMounted } from 'vue'
import { EDIT_URL, STORE_URL, UPDATE_URL, SERVICE_LIST} from '../../constants/branch'
import { useField, useForm } from 'vee-validate'
import { readFile } from '@/helpers/utilities'
import { useModuleId, useRequest,useOnOffcanvasHide } from '@/helpers/hooks/useCrudOpration'
import { VueTelInput } from 'vue3-tel-input'
import * as yup from 'yup'
import { useSelect } from '@/helpers/hooks/useSelect'
import FormHeader from '@/vue/components/form-elements/FormHeader.vue'
import FormFooter from '@/vue/components/form-elements/FormFooter.vue'
import InputField from '@/vue/components/form-elements/InputField.vue'
// Modals
import EmployeeCreate from '@/vue/components/Modal/EmployeeCreate.vue'
import FormElement from '@/helpers/custom-field/FormElement.vue'

// props
const props = defineProps({
  createTitle: { type: String, default: '' },
  editTitle: { type: String, default: '' },
  selectData: { type: String },
  customefield: { type: Array, default: () => [] }
})

const parseSelectData = JSON.parse(props.selectData)

const { getRequest, storeRequest, updateRequest } = useRequest()

const BRANCH_FOR_OPTIONS = reactive(parseSelectData['BRANCH_FOR'] || [])

const PAYMENT_METHODS_OPTIONS = reactive(parseSelectData['PAYMENT_METHODS'])

const singleSelectOption = ref({
  closeOnSelect: true,
  searchable: true
})
const multiselectOption = ref({
  mode: 'tags',
  searchable: true
})

const service = ref({ options: [], list: [] })
// const manager = ref({ options: [], list: [] })

const getServiceList = (cb = null) => {
  useSelect({ url: SERVICE_LIST }, { value: 'id', label: 'name' }).then((data) => (service.value = data))
}

// const getManagerList = (cb = null) => {
//   useSelect({ url: EMPLOYEE_LIST, data: { role: 'manager' } }, { value: 'id', label: 'name' }).then((data) => {
//       manager.value = data
//       if(typeof cb == 'function') {
//         cb()
//       }
//     }
//   )
// }

useOnOffcanvasHide('form-offcanvas', () => setFormData(defaultData()))

onMounted(() => {
  getServiceList()
  // getManagerList()
  setFormData(defaultData())
})

const numberRegex = /^\d+$/;

/*
 * Form Data & Validation & Handeling
 */

 const EMAIL_REGX = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;

const validationSchema = yup.object({
  name: yup.string()
    .required('Branch Name is a required field'),
  contact_number: yup.string().required('Contact Number is a required field').matches(/^(\+?\d+)?(\s?\d+)*$/, 'Phone Number must contain only digits'),
  contact_email: yup.string().required('Email is a required field').matches(EMAIL_REGX, 'Must be a valid email'),
  address: yup.object({
    address_line_1: yup.string().required('Address is a required field'),
    postal_code: yup.string().required('Postal Code is a required field'),
    city: yup.string().required('City is a required field'),
    latitude: yup.string().required('Latitude is a required field'),
    longitude: yup.string().required('Longitude is a required field'),
    state: yup.string().required('State is a required field'),
    country: yup.string().required('Country is a required field'),
    // manager_id: yup.string().required('Manager is a required field'),
  })
})

// how to add contact_email validation first letter accept only not digit if first letter then add valid email validation in vue

const { handleSubmit, errors, resetForm } = useForm({
  validationSchema,
  initialValues: {
    payment_method: ['cash']
  }
})

const { value: name } = useField('name')
const { value: postal_code } = useField('address.postal_code')
const { value: address_line_1 } = useField('address.address_line_1')
const { value: address_line_2 } = useField('address.address_line_2')
const { value: country } = useField('address.country')
const { value: state } = useField('address.state')
const { value: city } = useField('address.city')
const { value: latitude } = useField('address.latitude')
const { value: longitude } = useField('address.longitude')
const { value: status } = useField('status')
const { value: branch_for } = useField('branch_for')
const { value: payment_method } = useField('payment_method')
const { value: manager_id } = useField('manager_id')
const { value: service_id } = useField('service_id')
const { value: contact_email } = useField('contact_email')
const { value: contact_number } = useField('contact_number')
const { value: feature_image } = useField('feature_image')
const { value: description } = useField('description')
const { value: custom_fields_data } = useField('custom_fields_data')

// const updateManagerDetail = (e) => {
//   switch (e.type) {
//     case 'create_manager':
//       getManagerList(() => manager_id.value = e.value)
//         break;

//     default:
//       break;
//   }
// }

branch_for.value = 'both'

// Default FORM DATA, Error Message
const errorMessages = ref({})

// File Upload Function
const ImageViewer = ref(null)
const fileUpload = async (e) => {
  let file = e.target.files[0]
  await readFile(file, (fileB64) => {
    ImageViewer.value = fileB64
  })
  feature_image.value = file
}

// Function to delete Images
const removeImage = () => {
  ImageViewer.value = null
  feature_image.value = null
}

const defaultData = () => {
  errorMessages.value = {}
  return {
    name: '',
    contact_email:'',
    contact_number:'',
    feature_image: null,
    address: {
      postal_code: '',
      city: '',
      latitude: '',
      longitude: '',
      state: '',
      country: '',
      address_line_1: '',
      address_line_2: ''
    },
    description:'',
    manager_id: null,
    status: true,
    branch_for: 'both',
    service_id: [],
    payment_method: ['cash'],
    custom_fields_data: {}
  }
}

//  Reset Form
const setFormData = (data) => {
  ImageViewer.value = data.feature_image
  resetForm({
    values: {
      name: data.name,
      contact_email:data.contact_email,
      contact_number:data.contact_number,
      feature_image: data.feature_image,
      address: {
        postal_code: data.address.postal_code,
        city: data.address.city,
        latitude: data.address.latitude,
        longitude: data.address.longitude,
        state: data.address.state,
        country: data.address.country,
        address_line_1: data.address.address_line_1,
        address_line_2: data.address.address_line_2
      },
      status: data.status,
      description: data.description,
      branch_for: data.branch_for,
      manager_id: data.manager_id,
      service_id: data.service_id,
      payment_method: data.payment_method,
      custom_fields_data: data.custom_field_data
    }
  })
}

// phone number
const handleInput = (phone, phoneObject) => {
  // Handle the input event
  if (phoneObject?.formatted) {
    contact_number.value = phoneObject.formatted
  }
};

// Edit Form Or Create Form
const currentId = useModuleId(() => {
  if (currentId.value > 0) {
    getRequest({ url: EDIT_URL, id: currentId.value }).then((res) => res.status && setFormData(res.data))
  } else {
    setFormData(defaultData())
  }
})

const formSubmit = handleSubmit((values) => {
  if(props.customefield > 0) {
    values.custom_fields_data = JSON.stringify(values.custom_fields_data)
  }

  if (currentId.value > 0) {
    // Convert address object to JSON string
    values.address = JSON.stringify(values.address);
    updateRequest({ url: UPDATE_URL, id: currentId.value, body: values, type: 'file' }).then((res) => reset_datatable_close_offcanvas(res))
  } else {
    // Convert address object to JSON string
    values.address = JSON.stringify(values.address);
    storeRequest({ url: STORE_URL, body: values, type: 'file' }).then((res) => reset_datatable_close_offcanvas(res))
  }
})

// Reload Datatable, SnackBar Message, Alert, Offcanvas Close
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
</script>

<style scoped>
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

