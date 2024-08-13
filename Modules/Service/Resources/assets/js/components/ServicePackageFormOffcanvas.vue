<template>
  <form @submit="formSubmit">
    <div class="offcanvas offcanvas-end offcanvas-booking" tabindex="-1" id="form-offcanvas" aria-labelledby="form-offcanvasLabel">
      <FormHeader :currentId="currentId" :editTitle="editTitle" :createTitle="createTitle"></FormHeader>
      <div class="offcanvas-body">
        <div class="row">
          <InputField class="col-md-12" type="text" :is-required="true" :label="$t('service_package.lbl_name')" placeholder="" v-model="name" :error-message="errors['name']" :error-messages="errorMessages['name']"></InputField>
          <div class="col-12">
            <div class="form-group">
              <label class="form-label" for="employee_id"> {{ $t('service_package.lbl_select_staff') }} <span class="text-danger">*</span> </label>
              <Multiselect :selectConfig="singleSelectOption" v-model="employee_id" value="employee_id" v-bind="employee" @click="getServiceList()"></Multiselect>
              <span v-if="errorMessages['employee_id']">
                <ul class="text-danger">
                  <li v-for="err in errorMessages['employee_id']" :key="err">{{ err }}</li>
                </ul>
              </span>
              <span class="text-danger">{{ errors.employee_id }}</span>
            </div>
          </div>

          <div class="col-12">
            <div class="form-group">
              <label class="form-label" for="name">{{ $t('service_package.lbl_package_type') }}</label>
              <select class="form-select" v-model="package_type">
                <option value="single">{{$t('service_package.lbl_single')}}</option>
                <option value="multiple">{{ $t('service_package.lbl_multiple') }}</option>
              </select>
              <span>
                <ul class="text-danger"></ul>
              </span>
              <span class="text-danger"></span>
            </div>
          </div>

          <div class="col-12" v-if="package_type === 'single'">
            <div class="form-group">
              <div class="">
                <label class="form-label" for="category_id">{{ $t('service_package.lbl_category') }}</label>
                <Multiselect v-model="category_id" :value="category_id" v-bind="categories" @click="getServiceList()" :allow-empty="true" id="category_id"></Multiselect>
                <span v-if="errorMessages['category_id']">
                  <ul class="text-danger">
                    <li v-for="err in errorMessages['category_id']" :key="err">{{ err }}</li>
                  </ul>
                </span>
                <span class="text-danger">{{ errors.category_id }}</span>
              </div>
            </div>
          </div>

          <div class="col-12" v-if="package_type === 'single'">
            <div class="form-group" v-if="subCategories.options.length > 0">
              <label class="form-label" for="sub_category_id">{{ $t('service_package.lbl_sub_category') }}</label>
              <Multiselect v-model="sub_category_id" :value="sub_category_id" v-bind="subCategories" id="sub_category_id"></Multiselect>
            </div>
          </div>

          <div class="col-12">
            <div class="form-group">
              <label class="form-label" for="name">{{ $t('service_package.lbl_select_service') }}</label>
              <Multiselect class="mb-3" v-model="service_id" :value="service_id" v-bind="serviceOptions"></Multiselect>
              <span v-if="errorMessages['service_id']">
            <ul class="text-danger">
              <li v-for="err in errorMessages['service_id']" :key="err">{{ err }}</li>
            </ul>
          </span>
          <span class="text-danger">{{ errors.service_id }}</span>
            </div>
          </div>

          <div class="col-12">
            <div class="form-group">
              <label class="form-label" for="name">{{ $t('service_package.lbl_start_at') }}</label>
              <flat-pickr v-model="start_at" :config="config" class="form-control" />
              <span v-if="errorMessages['start_at']">
                <ul class="text-danger">
                  <li v-for="err in errorMessages['start_at']" :key="err">{{ err }}</li>
                </ul>
              </span>
              <span class="text-danger">{{ errors.start_at }}</span>
            </div>
          </div>

          <div class="col-12">
            <div class="form-group">
              <label class="form-label" for="name">{{ $t('service_package.lbl_End At') }}</label>
              <flat-pickr v-model="end_at" :config="config" class="form-control" />
              <span v-if="errorMessages['end_at']">
                <ul class="text-danger">
                  <li v-for="err in errorMessages['end_at']" :key="err">{{ err }}</li>
                </ul>
              </span>
              <span class="text-danger">{{ errors.end_at }}</span>
            </div>
          </div>
          <InputField class="col-md-12" type="number" :is-required="true" :label="$t('service_package.lbl_price')"  placeholder="" v-model="price" :error-message="errors['price']" :error-messages="errorMessages['price']"></InputField>
          <div class="col-12">
            <div class="form-group">
              <label class="form-label" for="name">{{ $t('service_package.lbl_image') }}</label>
              <input type="file" @change="fileUpload" class="form-control" />
              <span>
                <ul class="text-danger"></ul>
              </span>
              <span class="text-danger"></span>
            </div>
          </div>

          <div class="col-12">
            <div class="form-group">
              <label class="form-label" for="name">{{ $t('service_package.lbl_description') }}</label>
              <textarea class="form-control" v-model="description"></textarea>
              <span>
                <ul class="text-danger"></ul>
              </span>
              <span class="text-danger"></span>
            </div>
          </div>

          <div class="form-group">
            <div class="d-flex justify-content-between align-items-center">
              <label class="form-label" for="category-status">{{ $t('service_package.lbl_status') }}</label>
              <div class="form-check form-switch">
                <input class="form-check-input" :value="status" :checked="status" name="status" id="category-status" type="checkbox" v-model="status" />
              </div>
            </div>
          </div>

          <FormFooter></FormFooter>
        </div>
      </div>
    </div>
  </form>
</template>

<script setup>
import { buildMultiSelectObject } from '@/helpers/utilities'
import { ref, onMounted } from 'vue'
import { STORE_URL, EDIT_URL, UPDATE_URL, SERVICE_LIST, CATEGORY_LIST, EMPLOYEE_LIST } from '../constant/servicepackage'
import { useField, useForm } from 'vee-validate'
import { useModuleId, useRequest, useOnOffcanvasHide }
 from '@/helpers/hooks/useCrudOpration'
import { readFile } from '@/helpers/utilities'
import flatPickr from 'vue-flatpickr-component'
import InputField from '@/vue/components/form-elements/InputField.vue'
import 'flatpickr/dist/flatpickr.css'
import * as yup from 'yup'

import FormHeader from '@/vue/components/form-elements/FormHeader.vue'
import FormFooter from '@/vue/components/form-elements/FormFooter.vue'

// flatPicker date formate set
const config = ref({
  dateFormat: 'Y-m-d H:i:S'
})

const { getRequest, storeRequest, listingRequest, updateRequest} = useRequest()

// props
const props = defineProps({
  createTitle: { type: String, default: '' },
  editTitle: { type: String, default: '' },
  employee_id: 0
})

/*
 * Form Data & Validation & Handeling
 */
const numberRegex = /^\d+$/;
const validationSchema = yup.object({
  name: yup
    .string()
    .required('Name is a required field')
    .test('is-string', 'Only strings are allowed', (value) => {
      // Regular expressions to disallow special characters and numbers
      const specialCharsRegex = /[!@#$%^&*(),.?":{}|<>\-_;'\/+=\[\]\\]/;
      return !specialCharsRegex.test(value) && !numberRegex.test(value);
    }),
  price: yup.string()
    .required('Price is a required field')
    .matches(/^\d+$/, 'Only numbers are allowed'),
  employee_id: yup.string()
    .matches(/^\d+$/, 'Select Staff'),
    service_id: yup
    .mixed()
    .test('is-string-or-array', 'Service is a required field', function(value) {
      if (typeof value === 'string' && value !== '') {
        return true;
      }
      if (Array.isArray(value) && value.length > 0) {
        return true;
      }
      return false;
    })
    .required('Service is a required field')
})

const formType = { type: 'file' }
const { handleSubmit, errors, resetForm } = useForm({ validationSchema })
const { value: name } = useField('name')
const { value: price } = useField('price')
const { value: description } = useField('description')
const { value: package_type } = useField('package_type')
const { value: status } = useField('status')
const { value: employee_id } = useField('employee_id')
const { value: start_at } = useField('start_at')
const { value: end_at } = useField('end_at')
const { value: category_id } = useField('category_id')
const { value: sub_category_id } = useField('sub_category_id')
const { value: service_id } = useField('service_id')
const { value: feature_image } = useField('feature_image')

const serviceList = ref({})

const serviceOptions = ref({
  mode: 'tags',
  //createOption: true,
  options: []
})

/* get staff wise all services */

const getServiceList = (cb = null) => {
  listingRequest({ url: SERVICE_LIST, data: {employee_id: employee_id.value, category_id: category_id.value} }).then((res) => {
    serviceList.value = res
    serviceOptions.value.options = buildMultiSelectObject(res, {
      value: 'id',
      label: 'name'
    })
    if (typeof cb == 'function') {
      cb()
    }
  })
}

/* get category wise all service get */

const categories = ref({
  searchable: true,
  options: [],
  createOption: true,
  closeOnSelect: true
})

/* get subcategory */
const subCategories = ref({
  searchable: true,
  createOption: true,
  options: []
})

const getCategoryList = () => {
  listingRequest({ url: CATEGORY_LIST, data: { id: 0 } }).then((res) => (categories.value.options = buildMultiSelectObject(res, { value: 'id', label: 'name' })))
}

const changeCategory = (value) => {
  sub_category_id.value = null
  listingRequest({ url: CATEGORY_LIST, data: { id: value } }).then((res) => (subCategories.value.options = buildMultiSelectObject(res, { value: 'id', label: 'name' })))
}

// select staff
const employee = ref({
  searchable: true,
  options: [],
  closeOnSelect: true
})

/* list staff */
const getStaff = () => {
  listingRequest({ url: EMPLOYEE_LIST, data: { id: 0 } }).then((response) => (employee.value.options = buildMultiSelectObject(response, { value: 'id', label: 'name' })))
}

onMounted(() => {
  getCategoryList()
  getStaff()
  getServiceList()
  changeCategory()
  setFormData(defaultData())
})

const ImageViewer = ref(null)
// upload image
const fileUpload = async (e) => {
  let file = e.target.files[0]
  await readFile(file, (fileB64) => {
    ImageViewer.value = fileB64
  })
  feature_image.value = file
}

// Default FORM DATA, Error Message
const errorMessages = ref({})

const defaultData = () => {
  errorMessages.value = {}
  return {
    name: '',
    price: '',
    package_type: 'single',
    description: '',
    status: 1,
    employee_id: '',
    category_id: '',
    sub_category_id: '',
    start_at: '',
    end_at: '',
    service_id: []
  }
}

//  Reset Form
const setFormData = (data) => {
  ImageViewer.value = data.feature_image
  resetForm({
    values: {
      name: data.name,
      price: data.price,
      package_type: data.package_type,
      description: data.description,
      status: data.status,
      employee_id: data.employee_id,
      category_id: data.category_id || 0,
      sub_category_id: data.sub_category_id,
      start_at: data.start_at,
      end_at: data.end_at,
      service_id: data.service_id,
      feature_image: null
    }
  })
}

// Create and EditForm
const currentId = useModuleId(() => {
  subCategories.value.options = []
  if (currentId.value > 0) {
    getRequest({ url: EDIT_URL, id: currentId.value }).then((res) => {
      if (res.status) {
        setFormData(res.data)
        changeCategory(category_id.value)
        if (res.data.sub_category_id.value != '') {
          sub_category_id.value = res.data.sub_category_id
        }
      }
    })
  } else {
    setFormData(defaultData())
  }
})

// Select Options
const singleSelectOption = ref({
  closeOnSelect: true,
  searchable: true
})

/* form submit with data*/
const formSubmit = handleSubmit((values) => {
  if (currentId.value > 0) {

    updateRequest({ url: UPDATE_URL, id: currentId.value, body: values, ...formType }).then((res) => reset_datatable_close_offcanvas(res))
  } else {
    storeRequest({ url: STORE_URL, body: values, ...formType }).then((res) => reset_datatable_close_offcanvas(res))
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

useOnOffcanvasHide('form-offcanvas', () => setFormData(defaultData()))
</script>
