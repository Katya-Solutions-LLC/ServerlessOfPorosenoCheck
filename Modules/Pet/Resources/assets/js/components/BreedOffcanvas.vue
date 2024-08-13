<template>
  <form @submit="formSubmit">
    <div class="offcanvas offcanvas-end offcanvas-booking" tabindex="-1" id="form-offcanvas" aria-labelledby="form-offcanvasLabel">
      <FormHeader :currentId="currentId" :editTitle="editTitle" :createTitle="createTitle"></FormHeader>
      <div class="offcanvas-body">

        <InputField class="col-md-12" type="text" :is-required="true" :label="$t('pet.lbl_name')" placeholder="" v-model="name" :error-message="errors['name']" :error-messages="errorMessages['name']"></InputField>

        <div class="form-group">
          <label class="form-label" for="pettype_id">{{ $t('pet.lbl_pettype') }} <span class="text-danger">*</span> </label>
          <Multiselect v-model="pettype_id" :value="pettype_id" v-bind="pettype" id="pettype_id" @select="changePettype"></Multiselect>
          <span v-if="errorMessages['pettype_id']">
            <ul class="text-danger">
              <li v-for="err in errorMessages['pettype_id']" :key="err">{{ err }}</li>
            </ul>
          </span>
          <span class="text-danger">{{ errors.pettype_id }}</span>
        </div>

        <div class="form-group col-md-12">
              <label class="form-label" for="description">{{$t('pet.lbl_description')}}</label>
              <textarea class="form-control" v-model="description" id="description"></textarea>
              <span v-if="errorMessages['description']">
                <ul class="text-danger">
                  <li v-for="err in errorMessages['description']" :key="err">{{ err }}</li>
                </ul>
              </span>
              <span class="text-danger">{{ errors.description }}</span>
        </div>

        <div class="form-group">
          <div class="d-flex justify-content-between align-items-center">
            <label class="form-label" for="category-status">{{ $t('pet.lbl_status') }}</label>
            <div class="form-check form-switch">
              <input class="form-check-input" :value="status" :checked="status" name="status" id="pet-status" type="checkbox" v-model="status" />
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
import { EDIT_URL, STORE_URL, UPDATE_URL, PETTYPE_LIST} from '../constant/breed'
import { useField, useForm } from 'vee-validate'
import InputField from '@/vue/components/form-elements/InputField.vue'

import { useModuleId, useRequest, useOnOffcanvasHide } from '@/helpers/hooks/useCrudOpration'
import * as yup from 'yup'
import flatPickr from 'vue-flatpickr-component'
import 'flatpickr/dist/flatpickr.css'
import { buildMultiSelectObject } from '@/helpers/utilities'
import { readFile } from '@/helpers/utilities'
import FormHeader from '@/vue/components/form-elements/FormHeader.vue'
import FormFooter from '@/vue/components/form-elements/FormFooter.vue'
import FormElement from '@/helpers/custom-field/FormElement.vue'

// props
const props = defineProps({
  createTitle: { type: String, default: '' },
  editTitle: { type: String, default: '' },
//   defaultImage: { type: String, default: 'https://dummyimage.com/600x300/cfcfcf/000000.png' },
})
// const CURRENCY_SYMBOL = ref(window.defaultCurrencySymbol)
const { getRequest, storeRequest, updateRequest, listingRequest } = useRequest()

// onMounted(() => {

//   setFormData(defaultData())
// })


// Edit Form Or Create Form
const currentId = useModuleId(() => {
  if (currentId.value > 0) {
    getRequest({ url: EDIT_URL, id: currentId.value }).then((res) => res.status && setFormData(res.data))
  } else {
    setFormData(defaultData())
  }
})

/*
 * Form Data & Validation & Handeling
 */
// Default FORM DATA
const defaultData = () => {
  errorMessages.value = {}
  return {
    name: '',
    petype_id: '',
    description: '',
    status: 1,
    // pet_image: null,
  }
}

//  Reset Form
const setFormData = (data) => {
//   ImageViewer.value = data.pet_image
  resetForm({
    values: {
      name: data.name,
      pettype_id: data.pettype_id,
      description: data.description,
      status: data.status,
    //   pet_image: data.pet_image,
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


const numberRegex = /^\d+$/
const decimalRegex = /^\d+(\.\d+)?$/
// Validations
const validationSchema = yup.object({
  name: yup.string().required('Name is a required field'),
  pettype_id: yup.string().required('pet type is a required field').matches(/^\d+$/, 'Only numbers are allowed'),
})


const { handleSubmit, errors, resetForm } = useForm({
  validationSchema
})
const { value: name } = useField('name')
const { value: pettype_id } = useField('pettype_id')
const { value: description } = useField('description')
const { value: status } = useField('status')
// const { value: pet_image } = useField('pet_image')

const errorMessages = ref({})

const pettype = ref({
  searchable: true,
  createOption: true,
  options: []
})

const getPettypeList = () => {
  listingRequest({ url: PETTYPE_LIST, data: { id: 0 } }).then((res) => (pettype.value.options = buildMultiSelectObject(res, { value: 'id', label: 'name' })))
}

onMounted(() => {
  getPettypeList()
  setFormData(defaultData())
})

// Form Submit
const formSubmit = handleSubmit(async (values) => {
  const saveButton = document.getElementById('save-button');
  saveButton.disabled = true; 

  try {
    if (currentId.value > 0) {
      await updateRequest({ url: UPDATE_URL, id: currentId.value, body: values, type: 'file' }).then((res) => reset_datatable_close_offcanvas(res))
    } else {
      await storeRequest({ url: STORE_URL, body: values, type: 'file' }).then((res) => reset_datatable_close_offcanvas(res))
    }
  } catch (error) {
    console.error('Error:', error);
  } finally {
    saveButton.disabled = false;  
  }
});


useOnOffcanvasHide('form-offcanvas', () => setFormData(defaultData()))
</script>
