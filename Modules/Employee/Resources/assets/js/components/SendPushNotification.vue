<template>
    <form @submit.prevent="formSubmit">
      <div class="offcanvas offcanvas-end offcanvas-booking" id="send_push_notification" aria-labelledby="form-offcanvasLabel">
        <FormHeader :createTitle="createTitle"></FormHeader>
  
        <div class="offcanvas-body">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <InputField type="text" class="col-md-12" :is-required="true" :label="$t('booking.lbl_title')"
                  placeholder="" v-model="title" :error-message="errors['title']"
                  :error-messages="errorMessages['title']"></InputField>
  
                  <div class="form-group col-md-12">
                    <label class="form-label" for="description">{{ $t('booking.lbl_description') }} <span class="text-danger">*</span></label>
                    <textarea class="form-control" v-model="description" id="description"></textarea>
                    <span v-if="errorMessages['description']">
                      <ul class="text-danger">
                        <li v-for="err in errorMessages['description']" :key="err">{{ err }}</li>
                      </ul>
                    </span>
                    <div class="text-danger">{{ errors.description }}</div>
                  </div>
              </div>
            </div>
          </div>
        </div>
        <div class="offcanvas-footer border-top">
            <div class="d-grid d-md-flex gap-3 p-3">

              <button v-if="IsLoading==true" class="btn btn-primary d-flex align-items-center gap-1" id="save-button">
                Sending....
              </button>      

              <button v-else class="btn btn-primary d-flex align-items-center gap-1" id="save-button">
                Send
                <i class="fa-regular fa-paper-plane"></i>
              </button> 
              <button class="btn btn-soft-primary d-flex align-items-center gap-1" type="button" data-bs-dismiss="offcanvas">
                Cancel
                <i class="icon-Arrow---Right-2"></i>
              </button>
            </div>
          </div>
      </div>
    </form>
  </template>
  <script setup>
  import { ref } from 'vue'
  
  import { useField, useForm } from 'vee-validate'
  import { useModuleId, useRequest,useOnOffcanvasHide} from '@/helpers/hooks/useCrudOpration'
  import { SEND_PUSH_NOTIFICATION } from '../constant/employee'
  import * as yup from 'yup'
  import FormHeader from '@/vue/components/form-elements/FormHeader.vue'
  import InputField from '@/vue/components/form-elements/InputField.vue'
  
  // props
  defineProps({
    createTitle: { type: String, default: '' }
  })
  
  const { storeRequest } = useRequest()
  
  const currentId = useModuleId(() => {

    setFormData(defaultData())
  }, 'employee_assign')
  
  // Validations
  const validationSchema = yup.object({
    title: yup.string().required('Title is a required field'),
    description: yup.string().required('Description is a required field'),
   
  })
  
  const defaultData = () => {
    errorMessages.value = {}
    return {
        title: '',
        description: ''
    }
  }
  
  const setFormData = (data) => {
    resetForm({
      values: {
        title: '',
        description: ''
      }
    })
  }
  
  const { handleSubmit, errors, resetForm } = useForm({
    validationSchema
  })

  const IsLoading=ref(false);
  
  const { value: title } = useField('title')
  const { value: description } = useField('description')
  const errorMessages = ref({})
  
  // Form Submit
  const formSubmit = handleSubmit((values) => {
    IsLoading.value=true
    values.employee_id = currentId.value
    storeRequest({ url: SEND_PUSH_NOTIFICATION, body: values }).then((res) => reset_datatable_close_offcanvas(res))
  })
  // Reload Datatable, SnackBar Message, Alert, Offcanvas Close
  const reset_datatable_close_offcanvas = (res) => {
 
    if (res.status) {
      IsLoading.value=false
      window.successSnackbar(res.message)
      renderedDataTable.ajax.reload(null, false)
      bootstrap.Offcanvas.getInstance('#send_push_notification').hide()
      setFormData(defaultData())
      currentId.value = 0
    } else {
      setFormData(defaultData())
      currentId.value = 0
      IsLoading.value=false
      bootstrap.Offcanvas.getInstance('#send_push_notification').hide()
      window.errorSnackbar(res.message)
      errorMessages.value = res.all_message
    }
  }
  useOnOffcanvasHide('send_push_notification', () => setFormData(defaultData()))
  </script>
  