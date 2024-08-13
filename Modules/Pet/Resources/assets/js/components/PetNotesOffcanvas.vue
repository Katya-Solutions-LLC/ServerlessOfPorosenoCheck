<template>
    <form>
      <div class="offcanvas offcanvas-end offcanvas-booking" tabindex="-1" id="pet-notes-form" aria-labelledby="form-offcanvasLabel">
        <div class="offcanvas-header border-bottom">
          <h5 class="offcanvas-title" id="form-offcanvasLabel">  


             <span>Notes List</span>
             <!-- <span>{{Username}}</span> -->
         
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
  
        <div class="offcanvas-body">

          <span class="btn btn-sm text-primary border-0 px-0 float-end" data-bs-toggle="offcanvas" data-bs-target="#add-pet-notes-form"  aria-controls="form-offcanvas" > <i class="fa-solid fa-plus"></i> Add Notes</span>
  
          <div class="form-group d-inline-block w-100">
            <div v-if="!IsLoading" class="d-grid">
              <div class="d-flex flex-column">
                <div class="mb-4">
                </div>
              </div>
              <div v-if="NoteList.length > 0" class="list-group list-group-flush">
                 <div  v-for="(item, index) in NoteList" :key="item" >
                  <div v-if="item.is_private==0 || (item.is_private==1 && item.created_by== AuthId()) || role()=='admin' || role()=='demo_admin'" class="list-group-item bg-soft-primary text-body rounded mb-3 border-0 d-flex justify-content-between gap-3">
                  
                    <div>
                      <div class="mb-3">
                        <h6 class="mb-0">Title </h6>
                        <div>{{ item.title }}</div>
                      </div>
                      <div>
                        <h6 class="mb-0">Description </h6>
                        <div>{{ item.description }}</div>
                      </div>
                    </div>

                    <div class="flex-shrink-0">

                      <button v-if="item.created_by==AuthId() || role()=='admin' ||  role()=='demo_admin'" type="button" class="fs-4 text-primary border-0 bg-transparent" data-bs-toggle="offcanvas" data-bs-target="#edit-pet-notes-form" @click="changeId(item.id)"  aria-controls="form-offcanvas" ><i class="icon-Edit"></i></button>
                      <span v-if="item.created_by==AuthId() || role()=='admin' ||  role()=='demo_admin'" class="fs-4 text-danger border-0 bg-transparent" @click="removePetNotes(item.id, 'Are you certain you want to delete it?')"  data-bs-toggle="tooltip"> <i class="icon-delete"></i></span>

                    </div> 
                    </div>      
                 </div> 
             </div>
             <div v-else class="text-center">
                   <p>Notes are not available</p>
             </div>
            </div>
            <div v-else class="text-center"> Proccessing.... </div>
          </div>
        </div>
      </div>
    </form>
    <AddPetsNotes :pet_id="currentId" ></AddPetsNotes>

    <EditPetsNotes :note_id="noteId"></EditPetsNotes>
  
  
  </template>

  <script setup>
  import { ref, onMounted,watch} from 'vue'
  import { GET_PET_NOTES_URL, DELETE_PET_NOTE } from '../constant/pets'
  import { useModuleId, useRequest,useOnOffcanvasHide,useOnOffcanvasShow} from '@/helpers/hooks/useCrudOpration'
  import AddPetsNotes from '../components/AddPetsNotes.vue'
  import EditPetsNotes from '../components/EditPetsNotes.vue'
  import { confirmSwal } from '@/helpers/utilities'

  const props = defineProps({

  id: { type: Number, default: 0 }
})

const noteId = ref(null)
  const changeId = (id) => {

    noteId.value = id
  }

const AuthId = () => {
  return window.auth_id
}
const role = () => {
  return window.auth_role[0]
}

  // Request
  const { deleteRequest, getRequest, updateRequest } = useRequest()

  const Username = ref(null)
  
  const NoteList = ref([])

  const currentId = ref(props.id)

  const IsLoading=ref(false)

watch(
  () => props.id,
  (value) => {
    IsLoading.value=true;
    currentId.value = value
 
    if (value > 0) {
      getRequest({ url: GET_PET_NOTES_URL, id: value }).then((res) => {
        if (res.status && res.data) {

             IsLoading.value=false

            NoteList.value=res.data;
         
            // Username.value = res.data.pet.name + "'s Notes list";
   
        }
      })
    } 
  }
)


const removePetNotes = (value, message) => {
  confirmSwal({title: message}).then((result) => {
    if(!result.isConfirmed) return
    deleteRequest({ url: DELETE_PET_NOTE, id: value }).then((res) => {
      if(res.status) {
        Swal.fire({
          title: 'Deleted',
          text: res.message,
          icon: "success"
        })
        NoteList.value = res.data
        renderedDataTable.ajax.reload(null, false)
       
      }
    })
  })
}


  
  </script>
 
  