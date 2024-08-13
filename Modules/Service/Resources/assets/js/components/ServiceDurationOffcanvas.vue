<template>
    <form @submit="formSubmit">
      <div class="offcanvas offcanvas-end offcanvas-booking" tabindex="-1" id="form-offcanvas" aria-labelledby="form-offcanvasLabel">
        <FormHeader :currentId="currentId" :editTitle="editTitle" :createTitle="createTitle"></FormHeader>
        <div class="offcanvas-body">
  
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label" for="hours">{{ $t('service.lbl_hours') }} <span class="text-danger">*</span></label>
                  <flat-pickr placeholder="Hours" id="hours" class="form-control" v-model="hours" :value="hours" :config="config_hours"></flat-pickr>
                  <span class="text-danger">{{ errors.hours }}</span>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label" for="minutes">{{ $t('service.lbl_minutes') }} <span class="text-danger">*</span></label>
                  <flat-pickr placeholder="Minutes" id="minutes" class="form-control" v-model="minutes" :value="minutes" :config="config_minutes"></flat-pickr>
                  <span class="text-danger">{{ errors.minutes }}</span>
                </div>
              </div>
  
            </div>
          </div>

          <InputField class="col-md-12" type="text" :is-required="true" :label="$t('service.lbl_price')" placeholder="" v-model="price" :error-message="errors['price']" :error-messages="errorMessages['price']"></InputField>
  
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
  import FlatPickr from 'vue-flatpickr-component'
  import { EDIT_URL, STORE_URL, UPDATE_URL} from '../constant/serviceduration'
  import { useField, useForm } from 'vee-validate'
  import InputField from '@/vue/components/form-elements/InputField.vue'
  
  import { useModuleId, useRequest, useOnOffcanvasHide } from '@/helpers/hooks/useCrudOpration'
  import * as yup from 'yup'
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
  })
  // const CURRENCY_SYMBOL = ref(window.defaultCurrencySymbol)
  const { getRequest, storeRequest, updateRequest, listingRequest } = useRequest()
  
  // flatepicker
const config_hours = ref({
  dateFormat: 'H',
  time_24hr: true,
  enableTime: true,
  noCalendar: true,
  defaultHour: '00', // Update default hour to 9
})
const config_minutes = ref({
  dateFormat: 'i',
  time_24hr: true,
  enableTime: true,
  noCalendar: true,
  defaultMinute: '30'
})
  
  
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
      hours: '00',
      minutes: '30',
      price: '',
      status: 1,
    }
  }
  
  //  Reset Form
  const setFormData = (data) => {
    resetForm({
      values: {
        hours: data.hours,
        minutes: data.minutes,
        price: data.price,
        status: data.status,
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
    hours: yup.string().required('Hours is required'),
    minutes: yup.string().required('Minutes is required'),
    price: yup.string().required('Price is a required field').matches(/^[1-9]\d*(\.\d+)?$/, 'Only numbers greater than 0 are allowed'),
  })
  

  const { handleSubmit, errors, resetForm } = useForm({
    validationSchema
  })
  const { value: hours } = useField('hours')
  const { value: minutes } = useField('minutes')
  const { value: price } = useField('price')
  const { value: status } = useField('status')
  
  const errorMessages = ref({})
  
  const pettype = ref({
    searchable: true,
    createOption: true,
    options: []
  })
  
  
  onMounted(() => {
    setFormData(defaultData())
  })
  
  // Form Submit
const formSubmit = handleSubmit(async (values) => {
  const saveButton = document.getElementById('save-button');
  saveButton.disabled = true; 

  values.custom_fields_data = JSON.stringify(values.custom_fields_data);

  try {
    if (currentId.value > 0) {
      await updateRequest({ url: UPDATE_URL, id: currentId.value, body: values, type: 'file' }).then((res) => reset_datatable_close_offcanvas(res))
    } else {
      await storeRequest({ url: STORE_URL, body: values, type: 'file' }).then((res) => reset_datatable_close_offcanvas(res))
      document.getElementById('feature_image').value = '';
    }
  } catch (error) {
    console.error('Error:', error);
  } finally {
    saveButton.disabled = false;  
  }
});

  
  
  useOnOffcanvasHide('form-offcanvas', () => setFormData(defaultData()))
  </script>
  