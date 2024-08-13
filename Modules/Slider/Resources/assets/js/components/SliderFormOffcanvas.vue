<template>
  <form @submit="formSubmit">
    <div class="offcanvas offcanvas-end offcanvas-booking" tabindex="-1" id="form-offcanvas" aria-labelledby="form-offcanvasLabel">
      <FormHeader :currentId="currentId" :editTitle="editTitle" :createTitle="createTitle"></FormHeader>
      <div class="offcanvas-body">
        <InputField class="col-md-12" type="text" :is-required="true" :label="$t('slider.lbl_name')" placeholder="" v-model="name" :error-message="errors['name']" :error-messages="errorMessages['name']"></InputField>
        <InputField class="col-md-12" type="text" :is-required="false" :label="$t('slider.lbl_link')" placeholder="" v-model="link"></InputField>

        <div class="col-12">
          <div class="form-group">
            <label class="form-label">{{ $t('slider.lbl_type') }}<span class="text-danger">*</span></label>
            <Multiselect id="type" v-model="type" :value="type" v-bind="singleSelectOption" :options="module_types.options" @select="linkSelect" class="form-group"></Multiselect>
            <span class="text-danger">{{ errors.type }}</span>
          </div>
        </div>

        <div class="col-12">
          <div class="form-group">
            <label class="form-label">{{ $t('slider.lbl_link_id') }}</label>
            <Multiselect id="link_id" v-model="link_id" :value="link_id" v-bind="singleSelectOption" :options="modules_data.options" class="form-group"></Multiselect>
            <span class="text-danger">{{ errors.link_id }}</span>
          </div>
        </div>

        <div class="form-group col-md-12">
          <label class="form-label" for="feature_image">{{ $t('slider.lbl_feature_image') }}</label>
          <input type="file" class="form-control" id="feature_image" @change="fileUpload" accept=".jpeg, .jpg, .png, .gif" />
          <span v-if="errorMessages['feature_image']">
            <ul class="text-danger">
              <li v-for="err in errorMessages['feature_image']" :key="err">{{ err }}</li>
            </ul>
          </span>
          <span class="text-danger">{{ errors.feature_image }}</span>
        </div>

        <div class="form-group d-none">
          <div class="d-flex justify-content-between align-items-center">
            <label class="form-label" for="slider-status">{{ $t('slider.lbl_status') }}</label>
            <div class="form-check form-switch">
              <input class="form-check-input" :value="status" :checked="status" name="status" id="slider-status" type="checkbox" v-model="status" />
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
import { CATEGORY_LIST, SERVICE_LIST, TYPE_LIST, STORE_URL, EDIT_URL, UPDATE_URL } from '../constant/slider'
import { useField, useForm } from 'vee-validate'
import InputField from '@/vue/components/form-elements/InputField.vue'
import { useModuleId, useRequest,useOnOffcanvasHide } from '@/helpers/hooks/useCrudOpration'
import * as yup from 'yup'
import { readFile } from '@/helpers/utilities'
import FormHeader from '@/vue/components/form-elements/FormHeader.vue'
import FormFooter from '@/vue/components/form-elements/FormFooter.vue'
import { useSelect } from '@/helpers/hooks/useSelect'

// props
defineProps({
  createTitle: { type: String, default: '' },
  editTitle: { type: String, default: '' },
  customefield: { type: Array, default: () => [] }
})

const { getRequest, storeRequest, updateRequest, listingRequest } = useRequest()

const singleSelectOption = ref({
  closeOnSelect: true,
  searchable: true,
  clearable: false
})

const module_types = ref({ options: [], list: [] })
const modules_data = ref({ options: [], list: [] })
const errorMessages = ref({})

useOnOffcanvasHide('form-offcanvas', () => setFormData(defaultData()))

onMounted(() => {
  useSelect({ url: TYPE_LIST }, { value: 'id', label: 'name' }).then((data) => (module_types.value = data))
  setFormData(defaultData())
})

const getList = () => {
  const typeId = type.value
  if (typeId === 'category') {
    getCategoryLIst()
  } else if (typeId === 'service') {
    getServiceList()
  }
}

const getServiceList = () => {
  useSelect({ url: SERVICE_LIST, data: { type: type.value } }, { value: 'id', label: 'name' }).then((data) => (modules_data.value = data))
}

const getCategoryLIst = () => {
  useSelect({ url: CATEGORY_LIST, data: { type: type.value } }, { value: 'id', label: 'name' }).then((data) => (modules_data.value = data))
}

const linkSelect = () => {
  getList()
}
const currentId = useModuleId(() => {
  if (currentId.value > 0) {
    getRequest({ url: EDIT_URL, id: currentId.value }).then((res) => {
      if(res.status) {
        setFormData(res.data)
        linkSelect()
      }
    })
  } else {
    setFormData(defaultData())
  }
})

// File Upload Function
const ImageViewer = ref(null)
const fileUpload = async (e) => {
  let file = e.target.files[0]
  await readFile(file, (fileB64) => {
    ImageViewer.value = fileB64
  })
  feature_image.value = file
}

// Default FORM DATA
const defaultData = () => {
  errorMessages.value = {}
  return {
    name: '',
    type: '',
    link: '',
    link_id: '',
    status: 1,
    feature_image: null
  }
}

//  Reset Form
const setFormData = (data) => {
  ImageViewer.value = data.feature_image
  resetForm({
    values: {
      name: data.name,
      type: data.type,
      link: data.link,
      link_id: data.link_id,
      status: data.status,
      feature_image: data.feature_image
    }
  })
}

const numberRegex = /^\d+$/
const validationSchema = yup.object({
  name: yup
    .string()
    .required('Name is a required field')
    .test('is-string', 'Only strings are allowed', (value) => !numberRegex.test(value)),
  type: yup.string().required('Type is a required field'),
  // link_id: yup.string().required("Link Id is a required field")
})

const { handleSubmit, errors, resetForm } = useForm({
  validationSchema
})

const { value: name } = useField('name')
const { value: link } = useField('link')
const { value: type } = useField('type')
const { value: link_id } = useField('link_id')
const { value: status } = useField('status')
const { value: feature_image } = useField('feature_image')

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
