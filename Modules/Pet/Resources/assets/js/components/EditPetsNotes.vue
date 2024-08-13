<template>
    <form @submit.prevent="formSubmit">
        <div class="offcanvas offcanvas-end offcanvas-booking" id="edit-pet-notes-form" aria-labelledby="form-offcanvasLabel">

            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="form-offcanvasLabel">
                  <span>Edit Pet Note</span>             
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                </button>
              </div>
        
    
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

                    <div class="form-group">
                      <div class="d-flex justify-content-between align-items-center">
                        <label class="form-label" for="category-status">{{ $t('pet.lbl_private') }}</label>
                        <div class="form-check form-switch">
                          <input class="form-check-input" :value="is_private" :checked="is_private" name="is_private" id="pet-is_private" type="checkbox" v-model="is_private" />
                        </div>
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
  import { ref,onMounted,watch } from 'vue'
  
  import { useField, useForm} from 'vee-validate'
  import { useModuleId, useRequest } from '@/helpers/hooks/useCrudOpration'
  import { EDIT_PET_NOTE_URL,UPDATE_PET_NOTE_URL} from '../constant/pets'
  import * as yup from 'yup'
  import FormHeader from '@/vue/components/form-elements/FormHeader.vue'
  import InputField from '@/vue/components/form-elements/InputField.vue'
  import FormFooter from '@/vue/components/form-elements/FormFooter.vue'
  
  // props
  const props=defineProps({

   note_id: { type: Number, default: 0 }

  })
  
  const {getRequest,updateRequest} = useRequest()


  const currentId = ref(props.note_id)

  watch(
    () => props.note_id,
    (value) => {
        console.log(props.note_id)
      currentId.value = value
      if (value > 0) {
        getRequest({ url: EDIT_PET_NOTE_URL, id: value }).then((res) => {
            console.log(res.data)
          if (res.status && res.data) {
             setFormData(res.data) 
          }
        })
      } else {
        setFormData(defaultData())
      }
    }
  )


  // Validations
  const validationSchema = yup.object({
      title: yup.string().required('Title is a required field'),
      description: yup.string().required('Description is a required field'),
     
    })
    
    const defaultData = () => {
      errorMessages.value = {}
      return {
          title: '',
          description: '',
          is_private: 0
      }
    }
    
    const setFormData = (data) => {
      resetForm({
        values: {
          title: data.title,
          description: data.description,
          is_private: data.is_private,
        }
      })
    }
  
  
  const { handleSubmit, errors,resetForm } = useForm({
    validationSchema
  })
  
  const { value: title } = useField('title')
  const { value: description } = useField('description')
  const { value: is_private } = useField('is_private')
  const errorMessages = ref({})
    
  
  // Form Submit
  const formSubmit = handleSubmit((values) => {
  if (currentId.value > 0) {

    updateRequest({ url: UPDATE_PET_NOTE_URL, id: currentId.value, body: values }).then((res) => reset_datatable_close_offcanvas(res))
  } 
})
  // Reload Datatable, SnackBar Message, Alert, Offcanvas Close
  const reset_datatable_close_offcanvas = (res) => {
    if (res.status) {
      window.successSnackbar(res.message)
      renderedDataTable.ajax.reload(null, false)
      bootstrap.Offcanvas.getInstance('#edit-pet-notes-form').hide()
      setFormData(defaultData())
     
    } else {
      setFormData(defaultData())
      window.errorSnackbar(res.message)
      errorMessages.value = res.all_message
    }
  }
  
  
  </script>