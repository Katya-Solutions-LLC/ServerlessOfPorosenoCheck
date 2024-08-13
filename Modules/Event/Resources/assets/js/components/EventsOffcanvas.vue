<template>
    <form @submit="formSubmit">
      <div class="offcanvas offcanvas-end offcanvas-booking" tabindex="-1" id="form-offcanvas" aria-labelledby="form-offcanvasLabel">
        <FormHeader :currentId="currentId" :editTitle="editTitle" :createTitle="createTitle"></FormHeader>
        <div class="offcanvas-body">
  
          <div class="form-group">
              <div class="text-center">
                <img :src="ImageViewer || props.defaultImage" alt="event-image" class="img-fluid mb-2 avatar avatar-140 avatar-rounded" />
              </div>
              <label class="form-label" for="event_image">{{$t('event.lbl_event_image')}}</label>
              <input type="file" class="form-control" name="event_image" id="event_image" @change="fileUpload" accept=".jpeg, .jpg, .png, .gif" />
              <span v-if="errorMessages['event_image']">
                <ul class="text-danger">
                  <li v-for="err in errorMessages['event_image']" :key="err">{{ err }}</li>
                </ul>
              </span>
              <span class="text-danger">{{ errors.event_image }}</span>
            </div>

          <InputField class="col-md-12" type="text" :is-required="true" :label="$t('event.lbl_title')" placeholder="" v-model="name" :error-message="errors['name']" :error-messages="errorMessages['name']"></InputField>
  
          
          <div class="form-group">
            <label class="form-label" for="date">{{ $t('event.lbl_date') }} <span class="text-danger">*</span></label>
              <flat-pickr placeholder="Date" id="date" class="form-control" v-model="date" :value="date" :config="config"></flat-pickr>
            <div class="text-danger">{{ errors.date }}</div>
          </div>
          <!-- <div class="form-group">
            <label class="form-label" for="date">{{ $t('event.lbl_date') }}</label>
            <flat-pickr v-model="date" :config="config" class="form-control" />
          </div> -->

          <div class="form-group">
            <label class="form-label" for="user_id">{{ $t('event.lbl_organizer_name') }} <span class="text-danger">*</span> </label>
            <Multiselect v-model="user_id" :value="user_id" v-bind="userlist" id="user_id" @select="changeuser"></Multiselect>
            <span v-if="errorMessages['user_id']">
              <ul class="text-danger">
                <li v-for="err in errorMessages['user_id']" :key="err">{{ err }}</li>
              </ul>
            </span>
            <span class="text-danger">{{ errors.user_id }}</span>
          </div>

          <div class="form-group col-md-12">
            <label class="form-label" for="location">{{ $t('event.lbl_location') }}</label>
            <textarea class="form-control" v-model="location" id="location"></textarea>
            <span v-if="errorMessages['location']">
              <ul class="text-danger">
                <li v-for="err in errorMessages['location']" :key="err">{{ err }}</li>
              </ul>
            </span>
            <div class="text-danger">{{ errors.location }}</div>
          </div>
  
          <div class="form-group">
            <label class="form-label" for="description">{{ $t('event.lbl_description') }}</label>
            <!-- Add Quill editor here -->
            <div ref="descriptionEditorRef"></div>
            <span v-if="errorMessages['description']">
              <ul class="text-danger">
                <li v-for="err in errorMessages['description']" :key="err">{{ err }}</li>
              </ul>
            </span>
            <span class="text-danger">{{ errors.description }}</span>
          </div>
  
          <div class="form-group">
            <div class="d-flex justify-content-between align-items-center">
              <label class="form-label" for="category-status">{{ $t('event.lbl_status') }}</label>
              <div class="form-check form-switch">
                <input class="form-check-input" :value="status" :checked="status" name="status" id="blog-status" type="checkbox" v-model="status" />
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
  import { EDIT_URL, STORE_URL, UPDATE_URL, USER_LIST} from '../constant/event'
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
  import 'quill/dist/quill.core.css';
  import 'quill/dist/quill.snow.css';

  import Quill from 'quill'; // Import Quill

  const descriptionEditorRef = ref(null);

  // Quill setup
  let quillInstance;
  
  // props
  const props = defineProps({
    createTitle: { type: String, default: '' },
    editTitle: { type: String, default: '' },
    defaultImage: { type: String, default: 'https://dummyimage.com/600x300/cfcfcf/000000.png' },
  })
  // const CURRENCY_SYMBOL = ref(window.defaultCurrencySymbol)
  const { getRequest, storeRequest, updateRequest, listingRequest } = useRequest()
  
  // onMounted(() => {
  
  //   setFormData(defaultData())
  // })

const config = ref({
  dateFormat: 'Y-m-d',
  static: true,
  minDate: 'today',
})

  // File Upload Function
const ImageViewer = ref(null)
const fileUpload = async (e) => {
  let file = e.target.files[0]
  await readFile(file, (fileB64) => {
    ImageViewer.value = fileB64
  })
  event_image.value = file
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
      date: new Date().toISOString().substr(0, 10),
      user_id: '',
      location: '',
      description: '',
      status: 1,
      event_image: null,
    }
  }
  
  //  Reset Form
  const setFormData = (data) => {
    ImageViewer.value = data.event_image
    quillInstance.root.innerHTML = data.description
    resetForm({
      values: {
        name: data.name,
        date: data.date,
        user_id: data.user_id,
        location: data.location,
        description: data.description,
        status: data.status,
        event_image: data.event_image,
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
    name: yup.string().required('Title is a required field'),
    user_id: yup.string().required('Organizer Name is required field'),
    date: yup.string().required('Date is required'),
      description:yup.string().nullable().test('no-script-tags', 'The Description field cannot contain script tags.', function(value) {
      const scriptTagRegex = /<script\b[^>]*>(.*?)/is;
      return !scriptTagRegex.test(value);
    }),
  })
  
  
  const { handleSubmit, errors, resetForm } = useForm({
    validationSchema
  })
  const { value: name } = useField('name')
  const { value: date } = useField('date')
  const { value: user_id } = useField('user_id')
  const { value: location} = useField('location')
  const { value: description } = useField('description')
  const { value: event_image } = useField('event_image')
  const { value: status } = useField('status')
  
  const errorMessages = ref({})
  
  const pettype = ref({
    searchable: true,
    createOption: true,
    options: []
  })

  const userlist = ref({
    searchable: true,
    createOption: false,
    options: []
  })

  const getUserList = () => {
    listingRequest({ url: USER_LIST, data: { id: 0 } }).then((res) => (userlist.value.options = buildMultiSelectObject(res, { value: 'id', label: 'first_name' })))
  }

  
  onMounted(() => {
    quillInstance = new Quill(descriptionEditorRef.value, {
      theme: 'snow', // Choose the theme. 'snow' provides a standard toolbar.
      // Add more configuration options here if needed.
    });
    // Bind the Quill editor content to the 'description' data property
    quillInstance.on('text-change', () => {
      description.value = quillInstance.root.innerHTML;
    });
    getUserList();
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
        document.getElementById('event_image').value = '';
      }
    } catch (error) {
      console.error('Error:', error);
    } finally {
      saveButton.disabled = false;  
    }
  });
  
  
  useOnOffcanvasHide('form-offcanvas', () => setFormData(defaultData()))
  </script>

<style >
.flatpickr-wrapper{
  width: 100% !important;
  display: block;
}
</style> 
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