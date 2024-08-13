<template>
  <form @submit="formSubmit">
    <div class="offcanvas offcanvas-end offcanvas-booking" tabindex="-1" id="form-offcanvas" aria-labelledby="form-offcanvasLabel">
      <FormHeader :currentId="currentId" :editTitle="editTitle" :createTitle="createTitle"></FormHeader>
      <div class="offcanvas-body">
        <div class="row">
          <div class="col-12">
            <div class="form-group">
              <div class="text-center">
                <img :src="ImageViewer || props.defaultImage" alt="pettype-image" class="img-fluid mb-2 avatar avatar-140 avatar-rounded" />
              </div>
              <label class="form-label" for="pettype_image">{{$t('pet.lbl_pettype_image')}}</label>
              <input type="file" class="form-control" name="pettype_image" id="pettype_image" @change="fileUpload" accept=".jpeg, .jpg, .png, .gif" />
              <span v-if="errorMessages['pettype_image']">
                <ul class="text-danger">
                  <li v-for="err in errorMessages['pettype_image']" :key="err">{{ err }}</li>
                </ul>
              </span>
              <span class="text-danger">{{ errors.pettype_image }}</span>
            </div>

            <div class="form-group">
              <label class="form-label" for="name">{{ $t('pet.lbl_name') }}</label>
              <input type="text" class="form-control" v-model="name" id="name" />
              <span v-if="errorMessages['name']">
                <ul class="text-danger">
                  <li v-for="err in errorMessages['name']" :key="err">{{ err }}</li>
                </ul>
              </span>
              <span class="text-danger">{{ errors.name }}</span>
            </div>
             
            <div class="form-group">
              <div class="d-flex justify-content-between align-items-center">
                <label class="form-label" for="pettype-status">{{ $t('pet.lbl_status') }}</label>
                <div class="form-check form-switch">
                  <input class="form-check-input" :value="status" :checked="status" name="status" id="pettype-status" type="checkbox" v-model="status" />
                </div>
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
import { useField, useForm } from 'vee-validate'
import { EDIT_URL, STORE_URL, UPDATE_URL } from '../constant/pettype'
import { useModuleId, useRequest,useOnOffcanvasHide} from '@/helpers/hooks/useCrudOpration'
import * as yup from 'yup'
import { readFile } from '@/helpers/utilities'

import FormHeader from '@/vue/components/form-elements/FormHeader.vue'
import FormFooter from '@/vue/components/form-elements/FormFooter.vue'
import InputField from '@/vue/components/form-elements/InputField.vue'
import FormElement from '@/helpers/custom-field/FormElement.vue'

// props
const props = defineProps({
  createTitle: { type: String, default: '' },
  editTitle: { type: String, default: '' },
  defaultImage: { type: String, default: 'https://dummyimage.com/600x300/cfcfcf/000000.png' },
})

const { getRequest, storeRequest, updateRequest, listingRequest } = useRequest()

onMounted(() => {

  setFormData(defaultData())
})

// File Upload Function
const ImageViewer = ref(null)
const fileUpload = async (e) => {
  let file = e.target.files[0]
  await readFile(file, (fileB64) => {
    ImageViewer.value = fileB64
  })
  pettype_image.value = file
}

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
    status: 1,
    pettype_image: null,
  }
}

//  Reset Form
const setFormData = (data) => {
  ImageViewer.value = data.pettype_image
  resetForm({
    values: {
      name: data.name,
      status: data.status,
      pettype_image: data.pettype_image,
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
  pettype_image: yup.string()
    .required('Pettype Image is required'),
  name: yup.string()
    .required('Name is a required field')
    .test('is-string', 'Only strings are allowed', (value) => !numberRegex.test(value)),
})

const { handleSubmit, errors, resetForm } = useForm({
  validationSchema
})
const { value: name } = useField('name')
const { value: pettype_image } = useField('pettype_image')
const { value: status } = useField('status')
const errorMessages = ref({})

const categories = ref({
  searchable: true,
  options: [],
  createOption: true,
  closeOnSelect: true
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
      document.getElementById('pettype_image').value = ''
    }
  } catch (error) {
    console.error('Error:', error);
  } finally {
    saveButton.disabled = false;  
  }
});

useOnOffcanvasHide('form-offcanvas', () => setFormData(defaultData()))

</script>
