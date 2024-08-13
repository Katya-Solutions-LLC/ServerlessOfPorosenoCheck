<template>
    <div id="createPet">
      <form @submit="formSubmit">
        <div class="card-list-data mb-7">

          <div class="row">
            <InputField class="col-md-6" type="text" :is-required="true" :label="$t('quick_booking.name')" placeholder="" v-model="name" :error-message="errors['name']" :error-messages="errorMessages['name']"></InputField>
        
          <div class="form-group col-md-6">
            <label class="form-label" for="pettype_id">{{$t('quick_booking.pet_type')}}<span class="text-danger">*</span> </label>
            <Multiselect v-model="pettype_id" :value="pettype_id" v-bind="pettype" id="pettype_id" @select="changePettype"></Multiselect>
            <span v-if="errorMessages['pettype_id']">
              <ul class="text-danger">
                <li v-for="err in errorMessages['pettype_id']" :key="err">{{ err }}</li>
              </ul>
            </span>
            <span class="text-danger">{{ errors.pettype_id }}</span>
          </div>
  
          <div class="form-group col-md-6">
            <label class="form-label" for="breed">{{$t('quick_booking.breed')}}</label>
            <Multiselect v-model="breed" :value="breed" v-bind="breed_list" id="breed"></Multiselect>
            <span v-if="errorMessages['breed']">
              <ul class="text-danger">
                <li v-for="err in errorMessages['breed']" :key="err">{{ err }}</li>
              </ul>
            </span>
            <span class="text-danger">{{ errors.breed }}</span>
          </div>

          <InputField class="col-md-6" type="text" :label="$t('quick_booking.age')" placeholder="" v-model="age" :error-message="errors['age']" :error-messages="errorMessages['age']"></InputField>
  
        </div>
        </div>
        <div class="card-footer">
          <button class="btn btn-primary iq-text-uppercase">{{$t('quick_booking.submit')}}</button>
        </div>

      </form>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import { useField, useForm } from 'vee-validate'
  import * as yup from 'yup'
  import { useModuleId, useRequest, useOnOffcanvasHide } from '@/helpers/hooks/useCrudOpration'
  import InputField from '@/vue/components/form-elements/InputField.vue'
  import { STORE_PET ,PETTYPE_LIST ,BREED_LIST} from '@/vue/constants/quick_booking'
  import { buildMultiSelectObject } from '@/helpers/utilities'

  const props = defineProps({
  
  user_id: { type: Number, default: 0 }
})
  
  const { getRequest, storeRequest, updateRequest, listingRequest } = useRequest()
  const emit = defineEmits(['add_pet'])

  onMounted(() => {
    getPettypeList()
    setFormData(defaultData())
  })
  
  const defaultData = () => {
    errorMessages.value = {}
    return {
      name: '',
      pettype_id: '',
      breed: '',
      age: '',
     
    }
  }
  
  const setFormData = (data) => {
    resetForm({
      values: {
        name: data.name,
        pettype_id: data.pettype_id,
        breed: data.breed,
        age: data.age,
      }
    })
  }

  const pettype = ref({
  searchable: true,
  options: []
})

const getPettypeList = () => {
  listingRequest({ url: PETTYPE_LIST, data: { id: 0 } }).then((res) => (pettype.value.options = buildMultiSelectObject(res, { value: 'id', label: 'name' })))
}

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

// Validations
const validationSchema = yup.object({
  
  name: yup.string().required('Name is a required field'),
  pettype_id: yup.string().required('Pet type is a required field').matches(/^\d+$/, 'Only numbers are allowed'),

})

const { handleSubmit, errors, resetForm } = useForm({
  validationSchema
})
const { value: name } = useField('name')
const { value: pettype_id } = useField('pettype_id')
const { value: breed } = useField('breed')
const { value: age } = useField('age')

const errorMessages = ref({})

  
  // Form Submit
  const formSubmit = handleSubmit((values) => {
   values.user_id=props.user_id
    storeRequest({ url: STORE_PET, body: values }).then((res) => {
      if(res.errors){
    
          alert(res.message)
  
      }else{
  
        emit('add_pet', res.data)
  
      }
   
    })
  })
  </script>
  