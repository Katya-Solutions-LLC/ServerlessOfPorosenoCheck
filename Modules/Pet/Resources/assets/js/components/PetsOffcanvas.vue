<template>
  <form @submit="formSubmit">
    <div class="offcanvas offcanvas-end offcanvas-booking" tabindex="-1" id="pet-form-offcanvas" aria-labelledby="form-offcanvasLabel">
      <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="form-offcanvasLabel">
         
            <span>Edit Pet</span>
        
         
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
        </button>
      </div>
      <div class="offcanvas-body">

        <div class="form-group">
              <div class="text-center">
                <img :src="ImageViewer || props.defaultImage" alt="pet-image" class="img-fluid mb-2 avatar avatar-140 avatar-rounded" />
                <!-- <input type="button" class="btn btn-soft-danger mb-3" name="remove" value="Remove" @click="removeLogo()" v-if="ImageViewer" /> -->
              </div>
             
              <label class="form-label" for="pet_image">{{$t('pet.lbl_pet_image')}}</label>
              <input type="file" ref="profileInpuRef" class="form-control" id="pet_image" @change="fileUpload" accept=".jpeg, .jpg, .png, .gif" />
              <span v-if="errorMessages['pet_image']">
                <ul class="text-danger">
                  <li v-for="err in errorMessages['pet_image']" :key="err">{{ err }}</li>
                </ul>
              </span>
              <span class="text-danger">{{ errors.pet_image }}</span>
        </div>

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

        <div class="form-group">
          <label class="form-label" for="breed">{{ $t('pet.lbl_breed') }} <span class="text-danger">*</span> </label>
          <Multiselect v-model="breed" :value="breed" v-bind="breed_list" id="breed"></Multiselect>
          <span v-if="errorMessages['breed']">
            <ul class="text-danger">
              <li v-for="err in errorMessages['breed']" :key="err">{{ err }}</li>
            </ul>
          </span>
          <span class="text-danger">{{ errors.breed }}</span>
        </div>




        <div class="form-group">
          <label class="form-label" for="name">{{ $t('pet.lbl_date_of_birth') }}</label>
          <flat-pickr v-model="date_of_birth" :config="config" class="form-control" />
        </div>

        <InputField class="col-md-12" type="text" :label="$t('pet.lbl_age')" placeholder="" v-model="age" :error-message="errors['age']" :error-messages="errorMessages['age']"></InputField>

        <div class="form-group col-md-4">
            <label for="" class="form-label w-100">{{ $t('customer.lbl_gender') }}</label>
            <div class="d-flex mt-2">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" v-model="gender" id="male" value="male" />
                <label class="form-check-label" for="male"> Male </label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" v-model="gender" id="female" value="female" />
                <label class="form-check-label" for="female"> Female </label>
              </div>

              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" v-model="gender" id="other" value="other" />
                <label class="form-check-label" for="other"> Other </label>
              </div>
            </div>
        </div>

        <div class="col-md-12">
          <div class="row">
            <InputField class="col-md-6" type="text" :label="$t('pet.lbl_weight')" placeholder="" v-model="weight" :error-message="errors['weight']" :error-messages="errorMessages['weight']"></InputField>
            <div class="col-md-6">
              <label class="form-label" for="weight_unit">{{$t('pet.lbl_weight_unit')}}</label>
              <select class="form-select" v-model="weight_unit">
                <option value="kg">kg</option>
                <option value="g">g</option>
                <option value="mg">mg</option>
              </select>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="row">
            <InputField class="col-md-6" type="text" :label="$t('pet.lbl_height')" placeholder="" v-model="height" :error-message="errors['height']" :error-messages="errorMessages['height']"></InputField>
            <div class="col-md-6">
              <label class="form-label" for="height_unit">{{$t('pet.lbl_height_unit')}}</label>
              <select class="col-md-12 form-select" v-model="height_unit">
                <option value="cm">cm</option>
                <option value="m">m</option>
                <option value="ft">ft</option>
              </select>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label" for="user_id">{{ $t('pet.lbl_user') }} <span class="text-danger">*</span> </label>
          <Multiselect v-model="user_id" :value="user_id" v-bind="userlist" id="user_id" @select="changeuser" :disabled="user_id !=''"></Multiselect>
          <span v-if="errorMessages['user_id']">
            <ul class="text-danger">
              <li v-for="err in errorMessages['user_id']" :key="err">{{ err }}</li>
            </ul>
          </span>
          <span class="text-danger">{{ errors.user_id }}</span>
        </div>

        <div class="form-group col-md-12">
              <label class="form-label" for="additional_info">{{$t('pet.lbl_additional_info')}}</label>
              <textarea class="form-control" v-model="additional_info" id="additional_info"></textarea>
              <span v-if="errorMessages['additional_info']">
                <ul class="text-danger">
                  <li v-for="err in errorMessages['additional_info']" :key="err">{{ err }}</li>
                </ul>
              </span>
              <span class="text-danger">{{ errors.additional_info }}</span>
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
import { ref, onMounted,watch} from 'vue'
import { EDIT_URL, STORE_URL, UPDATE_URL, PETTYPE_LIST, USER_LIST,BREED_LIST } from '../constant/pets'
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
  editTitle: { type: String, default: 'Edit pet' },
  defaultImage: { type: String, default: 'https://dummyimage.com/600x300/cfcfcf/000000.png' },
  id: { type: Number, default: 0 }
})
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
  pet_image.value = file
}


const removeImage = ({ imageViewerBS64, changeFile }) => {
  imageViewerBS64.value = null
  changeFile.value = null
}

const config = ref({
  dateFormat: 'Y-m-d',
  static: true,
  maxDate: 'today'
})

const currentId = ref(props.id)

watch(
  () => props.id,
  (value) => {
    currentId.value = value
    if (value > 0) {
      getRequest({ url: EDIT_URL, id: value }).then((res) => {
        if (res.status && res.data) {
          breed_list.value.options = buildMultiSelectObject(res.data.breed_list, { value: 'id', label: 'name' })
          setFormData(res.data)
         
        }
      })
    } else {
      setFormData(defaultData())
    }
  }
)



// Edit Form Or Create Form
// const currentId = useModuleId(() => {
//   if (currentId.value > 0) {
//     getRequest({ url: EDIT_URL, id: currentId.value }).then((res) =>{
//       if(res.data){

//         breed_list.value.options = buildMultiSelectObject(res.data.breed_list, { value: 'id', label: 'name' })
        
//         setFormData(res.data)
//       }
//     })

//   } else {
//     setFormData(defaultData())
//   }
// })

/*
 * Form Data & Validation & Handeling
 */
// Default FORM DATA
const defaultData = () => {
  errorMessages.value = {}
  return {
    name: '',
    petype_id: '',
    breed: '',
    size: '',
    date_of_birth: '',
    age: '',
    gender: 'male',
    weight: '',
    height: '',
    weight_unit: '',
    height_unit: '',
    user_id: '',
    additional_info: '',
    status: 1,
    pet_image: null,
  }
}

//  Reset Form
const setFormData = (data) => {
  ImageViewer.value = data.pet_image
  console.log(ImageViewer.value);
  resetForm({
    values: {
      name: data.name,
      pettype_id: data.pettype_id,
      breed: data.breed_id,
      size: data.size,
      date_of_birth: data.date_of_birth,
      age: data.age,
      gender: data.gender,
      weight: data.weight,
      height: data.height,
      weight_unit: data.weight_unit,
      height_unit: data.height_unit,
      user_id: data.user_id,
      additional_info: data.additional_info,
      status: data.status,
      pet_image: data.pet_image,
    }
  })
}

// Reload Datatable, SnackBar Message, Alert, Offcanvas Close
const reset_datatable_close_offcanvas = (res) => {
  if (res.status) {
    window.successSnackbar(res.message)
    renderedDataTable.ajax.reload(null, false)
    bootstrap.Offcanvas.getInstance('#pet-form-offcanvas').hide()
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
  pettype_id: yup.string().required('Pet type is a required field').matches(/^\d+$/, 'Only numbers are allowed'),
  breed: yup.string().required('Breed is a required field'),
  user_id: yup.string().required('User is a required field').matches(/^\d+$/, 'Only numbers are allowed'),
  weight: yup.string().nullable().matches(/^\d*(\.\d+)?$/, 'Only numbers are allowed'),
  height: yup.string().nullable().matches(/^\d*(\.\d+)?$/, 'Only numbers are allowed'),

})


const { handleSubmit, errors, resetForm } = useForm({
  validationSchema
})
const { value: name } = useField('name')
const { value: pettype_id } = useField('pettype_id')
const { value: breed } = useField('breed')
const { value: size } = useField('size')
const { value: date_of_birth } = useField('date_of_birth')
const { value: age } = useField('age')
const { value: gender } = useField('gender')
const { value: weight } = useField('weight')
const { value: height } = useField('height')
const { value: weight_unit } = useField('weight_unit')
const { value: height_unit } = useField('height_unit')
const { value: user_id } = useField('user_id')
const { value: additional_info } = useField('additional_info')
const { value: status } = useField('status')
const { value: pet_image } = useField('pet_image')

const errorMessages = ref({})

const pettype = ref({
  searchable: true,
  options: []
})
const userlist = ref({
  searchable: true,
  options: []
})

const breed_list = ref({
  searchable: true,
  options: []
})

const changePettype = () => {

  let pet_id=0

  if(pettype_id.value>0){

   pet_id=pettype_id.value

  }

  listingRequest({ url: BREED_LIST, data: { id: pet_id} }).then((res) => {
    if(res !=''){
      breed.value=''
      breed_list.value.options = buildMultiSelectObject(res, { value: 'id', label: 'name' })

    }else{
      breed.value=''
      breed_list.value.options =[]
    }


  })
}


const removeLogo = () => removeImage({ imageViewerBS64: ImageViewer, changeFile: pet_image })

const getPettypeList = () => {
  listingRequest({ url: PETTYPE_LIST, data: { id: 0 } }).then((res) => (pettype.value.options = buildMultiSelectObject(res, { value: 'id', label: 'name' })))
}

const getUserList = () => {
  listingRequest({ url: USER_LIST, data: { id: 0 } }).then((res) => (userlist.value.options = buildMultiSelectObject(res, { value: 'id', label: 'first_name' })))
}

onMounted(() => {
  getPettypeList()
  getUserList()
  //changePettype()
  setFormData(defaultData())
})

// Form Submit
const formSubmit = handleSubmit((values) => {
  if (currentId.value > 0) {
    updateRequest({ url: UPDATE_URL, id: currentId.value, body: values, type: 'file' }).then((res) => reset_datatable_close_offcanvas(res))
  } else {
    storeRequest({ url: STORE_URL, body: values, type: 'file' }).then((res) => reset_datatable_close_offcanvas(res))
    document.getElementById('pet_image').value = ''
  }
})


useOnOffcanvasHide('form-offcanvas', () => setFormData(defaultData()))
</script>

<style >
.flatpickr-wrapper{
  width: 100% !important;
  display: block;
}
</style>  