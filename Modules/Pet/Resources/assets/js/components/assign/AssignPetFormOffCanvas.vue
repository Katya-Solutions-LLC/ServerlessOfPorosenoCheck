<template>
  <form @submit.prevent="formSubmit">
    <div class="offcanvas offcanvas-end offcanvas-booking" tabindex="-1" id="pet-assign-form" aria-labelledby="form-offcanvasLabel">
      <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="form-offcanvasLabel">  
           

         
            <span>{{Username}}</span>
       
        </h5>
        <button type="button" class="btn-close" @click="reset_datatable_close_offcanvas()" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>

      <div class="offcanvas-body">

        <div v-if="!IsLoading" class="form-group">
          <div class="d-grid">
            <div class="d-flex flex-column">
              <div class="mb-4">

              </div>
            </div>
            <div v-if="selectedpets.length > 0" class="list-group list-group-flush">
              <div v-for="(item, index) in selectedpets" :key="item" class="list-group-item d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center flex-grow-1 gap-2 my-2">
                  <img :src="item.pet_image" class="avatar avatar-40 img-fluid rounded-pill" alt="user" />
                  <div class="flex-grow-1"> {{ item.name }} ({{ item.breed ? item.breed.name : '-' }})</div>
                </div>
                <button  type="button" class="fs-4 text-info border-0 bg-transparent" data-bs-toggle="offcanvas" data-bs-target="#pet-notes-form"    @click="changeId(item.id)"  aria-controls="form-offcanvas" ><i class="icon-page"></i></button>
                <button v-if="role() === 'admin' || role() === 'demo_admin'" type="button" class="fs-4 text-primary border-0 bg-transparent" data-bs-toggle="offcanvas" data-bs-target="#pet-form-offcanvas"    @click="changeId(item.id)"  aria-controls="form-offcanvas" ><i class="icon-Edit"></i></button>
                <button v-if="role() === 'admin' || role() === 'demo_admin'" class="fs-4 text-danger border-0 bg-transparent" @click="removePet(item.id, 'Are you certain you want to delete it?')"  data-bs-toggle="tooltip"> <i class="icon-delete"></i></button>
             
              </div>
            </div>
            <div v-else class="text-center">
              <p>Pet are not available</p>
          </div>
          </div>
        </div>
        <div v-else class="text-center"> Proccessing.... </div>
      </div>
    </div>
  </form>
  <PetsOffcanvas :id="petId"></PetsOffcanvas>
  <PetNotesOffcanvas :id="petId"></PetNotesOffcanvas>

  
</template>
<script setup>
import { ref, onMounted } from 'vue'
import { GET_USER_PET_URL, EDIT_URL, STORE_URL, UPDATE_URL,DELETE_PET } from '../../constant/pets'
// import { POST_EMPLOYEE_ASSIGN_URL, GET_EMPLOYEE_ASSIGN_URL, EDIT_URL, EMPLOYEE_LIST, BRANCH_LIST } from '../../constant/service'
import { useModuleId, useRequest,useOnOffcanvasHide,useOnOffcanvasShow} from '@/helpers/hooks/useCrudOpration'
import { confirmSwal } from '@/helpers/utilities'
import { useSelect } from '@/helpers/hooks/useSelect'
import FormHeader from '@/vue/components/form-elements/FormHeader.vue'
import PetsOffcanvas from '../../components/PetsOffcanvas.vue'
import PetNotesOffcanvas from '../../components/PetNotesOffcanvas.vue'



// Request
const { deleteRequest, getRequest, updateRequest } = useRequest()

const props=defineProps({
  type: { type: String, default: '' },
})

const role = () => {
  return window.auth_role[0]
}

const petId = ref(null)
  const changeId = (id) => {

    petId.value = id
  }

const IsLoading=ref(false)

// Vue Form Select START
const branch = ref({ options: [], list: [] })
const pets = ref({ options: [], list: [] })
const selectedpets = ref([])
// Vue Form Select END
// Select Options
const singleSelectOption = ref({
  mode: 'multiple',
  closeOnSelect: false,
  searchable: true
})
// Form Values
const assign_ids = ref([])

const Username = ref(null)

const UserId = useModuleId(() => {
  IsLoading.value=true;

  reset_datatable_close_offcanvas()

  getRequest({ url: GET_USER_PET_URL, id: UserId.value }).then((res) => {
    if (res.status && res.data) {

      selectedpets.value = res.data.user_pet
      assign_ids.value = res.data.user_pet.map((item) => item.id)
      pets.value = res.data.all_pet
      Username.value = res.data.user_name + "'s pet list"
      IsLoading.value=false;
      petId.value = 0
    }
  })
 // getRequest({ url: EDIT_URL, id: UserId.value }).then((res) => res.status && (pets.value = res.data))
}, 'assign_pet')


const removePet = (value, message) => {

      confirmSwal({title: message}).then((result) => {
        if(!result.isConfirmed) return
        deleteRequest({ url: DELETE_PET, id: value }).then((res) => {
          if(res.status) {
            Swal.fire({
              title: 'Deleted',
              text: res.message,
              icon: "success"
            })
            selectedpets.value = res.data
            assign_ids.value = res.data.map((item) => item.id)
            renderedDataTable.ajax.reload(null, false)
           
          }
        })
      })
    }

const reset_datatable_close_offcanvas = () => {

      selectedpets.value = []
      Username.value = ''
      petId.value = 0
  
}


// const removePet = (value) => {

//   getRequest({ url: DELETE_PET, id: value }).then((res) => {
//     if (res.status && res.data) {

//       selectedpets.value = res.data
//       assign_ids.value = res.data.map((item) => item.id)
//       window.successSnackbar(res.message)
//       renderedDataTable.ajax.reload(null, false)

//     }
//   })
// }

</script>
