<template>
    <form @submit="formSubmit">
      <div class="offcanvas offcanvas-end offcanvas-booking" tabindex="-1" id="form-offcanvas" aria-labelledby="form-offcanvasLabel">
        <FormHeader :currentId="currentId" :editTitle="editTitle" :createTitle="createTitle"></FormHeader>
        <div class="offcanvas-body">
  
          <div class="form-group">
              <div class="text-center">
                <img :src="ImageViewer || props.defaultImage" alt="blog-image" class="img-fluid mb-2 avatar avatar-140 avatar-rounded" />
              </div>
              <label class="form-label" for="blog_image">{{$t('blog.lbl_blog_image')}}</label>
              <input type="file" class="form-control" name="blog_image" id="blog_image" @change="fileUpload" accept=".jpeg, .jpg, .png, .gif" />
              <span v-if="errorMessages['blog_image']">
                <ul class="text-danger">
                  <li v-for="err in errorMessages['blog_image']" :key="err">{{ err }}</li>
                </ul>
              </span>
              <span class="text-danger">{{ errors.blog_image }}</span>
            </div>

          <InputField class="col-md-12" type="text" :is-required="true" :label="$t('blog.lbl_blog_name')" placeholder="" v-model="name" :error-message="errors['name']" :error-messages="errorMessages['name']"></InputField>
  
          <div class="form-group">
              <label class="form-label" for="tags">{{ $t('blog.lbl_tags') }}</label>
              <Multiselect id="tags" v-model="tags" :multiple="true" :value="tags"
                placeholder="Enter Tags" v-bind="multiSelectOption" :options="tags_list.options" class="form-group">
              </Multiselect>
              <span v-if="errorMessages['tags']">
                <ul class="text-danger">
                  <li v-for="err in errorMessages['tags']" :key="err">{{ err }}</li>
                </ul>
              </span>
              <span class="text-danger">{{ errors.tags }}</span>
            </div>
  
            <div class="form-group">
              <label class="form-label" for="description">{{ $t('blog.lbl_description') }} <span class="text-danger">*</span></label>
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
              <label class="form-label" for="category-status">{{ $t('blog.lbl_status') }}</label>
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
  import { EDIT_URL, STORE_URL, UPDATE_URL} from '../constant/blog'
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

  const multiSelectOption = ref({
    mode: 'tags',
    closeOnSelect: true,
    searchable: true,
    createOption: true
  })

  const tags_list = ref({ options: [], list: [] })

  // const CURRENCY_SYMBOL = ref(window.defaultCurrencySymbol)
  const { getRequest, storeRequest, updateRequest, listingRequest } = useRequest()
  
  // onMounted(() => {
  
  //   setFormData(defaultData())
  // })


  // File Upload Function
const ImageViewer = ref(null)
const fileUpload = async (e) => {
  let file = e.target.files[0]
  await readFile(file, (fileB64) => {
    ImageViewer.value = fileB64
  })
    blog_image.value = file
}
  
  
  // Edit Form Or Create Form
  const currentId = useModuleId(() => {
    // if (currentId.value > 0) {
    //   getRequest({ url: EDIT_URL, id: currentId.value }).then((res) => res.status && setFormData(res.data))

    // } else {
    //   setFormData(defaultData())
    // }
    if (currentId.value > 0) {
    getRequest({ url: EDIT_URL, id: currentId.value }).then((res) => {
        if (res.status && res.data) {
          setFormData(res.data)
          tags_list.value.options = res.data.tags;
        }
      })
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
      tags: [],
      description: '',
      status: 1,
      blog_image: null,
    }
  }
  
  //  Reset Form
  const setFormData = (data) => {
    ImageViewer.value = data.blog_image
    quillInstance.root.innerHTML = data.description
    resetForm({
      values: {
        name: data.name,
        tags: data.tags,
        description: data.description,
        status: data.status,
        blog_image: data.blog_image,  
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
    description: yup.string().required('Description is a required field'),
  })
  
  
  const { handleSubmit, errors, resetForm } = useForm({
    validationSchema
  })
  const { value: name } = useField('name')
  const { value: tags } = useField('tags')
  const { value: description } = useField('description')
  const { value: blog_image } = useField('blog_image')
  const { value: status } = useField('status')
  
  const errorMessages = ref({})
  
  onMounted(() => {
    quillInstance = new Quill(descriptionEditorRef.value, {
      theme: 'snow', // Choose the theme. 'snow' provides a standard toolbar.
      // Add more configuration options here if needed.
    });
    // Bind the Quill editor content to the 'description' data property
    quillInstance.on('text-change', () => {
      description.value = quillInstance.root.innerHTML;
    });
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
        document.getElementById('blog_image').value = '';
      }
    } catch (error) {
      console.error('Error:', error);
    } finally {
      saveButton.disabled = false;  
    }
  });
  
  
  useOnOffcanvasHide('form-offcanvas', () => setFormData(defaultData()))
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
  