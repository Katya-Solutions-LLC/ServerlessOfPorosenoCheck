<template>
  <form @submit="formSubmit">
    <div class="offcanvas offcanvas-end offcanvas-booking" tabindex="-1" id="form-offcanvas" aria-labelledby="form-offcanvasLabel">
      <FormHeader :currentId="currentId" :editTitle="editTitle" :createTitle="createTitle"></FormHeader>
      <div class="offcanvas-body">
        <div class="row">
          <div class="col-12">
            <div class="form-group">
              <InputField class="col-md-12" :is-required="true" :label="$t('tax.lbl_title')"  placeholder="" v-model="title" :error-message="errors.title" :error-messages="errorMessages['title']"></InputField>
              <InputField class="col-md-12" :is-required="true" :label="$t('tax.lbl_value')"  placeholder="" v-model="value" :error-message="errors.value" :error-messages="errorMessages['value']"></InputField>
            </div>
          </div>

          <div class="col-12">
            <div class="form-group">
              <label class="form-label" for="name">{{ $t('tax.lbl_select_type') }}<span class="text-danger">*</span></label>
              <select class="form-select" v-model="type">
                <option value="percentage">{{$t('tax.percent')}}</option>
                <option value="fixed">{{$t('tax.fixed')}}</option>
              </select>
              <span v-if="errorMessages['type']">
                <ul class="text-danger">
                  <li v-for="err in errorMessages['type']" :key="err">{{ err }}</li>
                </ul>
              </span>
              <span class="text-danger">{{ errors.type }}</span>
            </div>
          </div>

          <div class="col-12">
            <label class="form-label" for="module_type">{{ $t('tax.lbl_module_type') }}</label>
            <Multiselect id="module_type" v-model="module_type" :value="module_type" v-bind="module_type_data" class="form-group"></Multiselect>
            <span class="text-danger">{{ errors.module_type_data }}</span>
          </div>

          <div class="form-group ">
              <div class="d-flex justify-content-between align-items-center">
                <label class="form-label" for="category-status">{{ $t('tax.lbl_status') }}</label>
                <div class="form-check form-switch m-2">
                  <input class="form-check-input" :value="status" :true-value="1" :false-value="0" :checked="status" name="status" id="category-status" type="checkbox" v-model="status" />
                </div>
              </div>
            </div>
        </div>
      </div>
      <FormFooter></FormFooter>
    </div>
  </form>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { EDIT_URL, STORE_URL, UPDATE_URL } from '../constant/tax'
import { useField, useForm } from 'vee-validate'
import InputField from '@/vue/components/form-elements/InputField.vue'
import { useModuleId, useRequest,useOnOffcanvasHide } from '@/helpers/hooks/useCrudOpration'
import * as yup from 'yup'
import { buildMultiSelectObject } from '@/helpers/utilities'
import FormHeader from '@/vue/components/form-elements/FormHeader.vue'
import FormFooter from '@/vue/components/form-elements/FormFooter.vue'

// props
const props = defineProps({
  createTitle: { type: String, default: '' },
  editTitle: { type: String, default: '' }
})

const { getRequest, storeRequest, updateRequest, listingRequest } = useRequest()

onMounted(() => {
  setFormData(defaultData())
})

// Edit Form Or Create Form
const currentId = useModuleId(() => {
  if (currentId.value > 0) {
    getRequest({ url: EDIT_URL, id: currentId.value }).then((res) => {
      if (res.status) {
        setFormData(res.data)
      }
    })
  } else {
    setFormData(defaultData())
  }
})

// Default FORM DATA
const defaultData = () => {
  errorMessages.value = {}
  return {
    title: '',
    value: '',
    type: '',
    module_type_data: null,
    status: true
  }
}

const module_type_data = ref({
  searchable: true,
  options: [
    { label: 'Products', value: 'products' },
    { label: 'Services', value: 'services' },

  ],
  closeOnSelect: true,
  createOption: true,
  removeSelected: false
})

const setFormData = (data) => {
  resetForm({
    values: {
      title: data.title,
      value: data.value,
      type: data.type,
      module_type: data.module_type,
      status: data.status
    }
  })
}

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

const numberRegex = /^\d+$/;
// Validations
const validationSchema = yup.object({
  title: yup.string()
    .required('Title is a required field')
    .test('is-string', 'Only strings are allowed', (value) => !numberRegex.test(value)),
  value: yup.string()
    .required('Value is a required field')
    .matches(/^\d+$/, 'Only numbers are allowed'),
  type: yup.string().required('Type is a required field'),
})

const { handleSubmit, errors, resetForm } = useForm({
  validationSchema
})
const { value: title } = useField('title')
const { value: value } = useField('value')
const { value: type } = useField('type')
const { value: status } = useField('status')
const { value: module_type } = useField('module_type')
const errorMessages = ref({})

// Form Submit
const formSubmit = handleSubmit(async (values) => {
  const saveButton = document.getElementById('save-button');
  saveButton.disabled = true; 

  try {
    if (currentId.value > 0) {
      await updateRequest({ url: UPDATE_URL, id: currentId.value, body: values }).then((res) => reset_datatable_close_offcanvas(res))
    } else {
      await storeRequest({ url: STORE_URL, body: values }).then((res) => reset_datatable_close_offcanvas(res))
    }
  } catch (error) {
    console.error('Error:', error);
  } finally {
    saveButton.disabled = false;  
  }
});

useOnOffcanvasHide('form-offcanvas', () => setFormData(defaultData()))
</script>
