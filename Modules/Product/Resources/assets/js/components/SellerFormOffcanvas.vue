<template>
    <form @submit.prevent="formSubmit">
      <div class="offcanvas offcanvas-end offcanvas-booking" tabindex="-1" id="seller-form" aria-labelledby="form-offcanvasLabel">
        <div class="offcanvas-header border-bottom">
          <h5 class="offcanvas-title" id="form-offcanvasLabel">  
      
              <span>Seller List</span>
         
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
              <div v-if="sellers.length > 0" class="list-group list-group-flush">
                <div v-for="item in sellers" :key="item" class="list-group-item d-flex justify-content-between align-items-center">
                  <div class="d-flex align-items-center flex-grow-1 gap-2 my-2">
                    <img :src="item.profile_image" class="avatar avatar-40 img-fluid rounded-pill" alt="user" />
                    <div class="flex-grow-1"> {{ item.first_name }} {{ item.last_name }}</div>
                  </div>
               
                </div>
              </div>
               
            </div>
          </div>
          <div v-else class="text-center"> Proccessing.... </div>
           
        </div>
      </div>
    </form>
   
  
    
  </template>
  <script setup>
  import { ref, onMounted } from 'vue'
  import { GET_SELLER_URL } from '../constant/product'
  import { useModuleId, useRequest,useOnOffcanvasHide,useOnOffcanvasShow} from '@/helpers/hooks/useCrudOpration'
  import { confirmSwal } from '@/helpers/utilities'
  import { useSelect } from '@/helpers/hooks/useSelect'
  import FormHeader from '@/vue/components/form-elements/FormHeader.vue'
  
  
  
  // Request
  const { deleteRequest, getRequest, updateRequest } = useRequest()
  
  const props=defineProps({
    type: { type: String, default: '' },
  })
  
  const role = () => {
    return window.auth_role[0]
  }
  
  const IsLoading=ref(false)

  // Vue Form Select START
 
  const sellers = ref([])
  // Vue Form Select END
  // Select Options
  const singleSelectOption = ref({
    mode: 'multiple',
    closeOnSelect: false,
    searchable: true
  })
  // Form Values
  
  const orderId = useModuleId(() => {
    IsLoading.value=true;
  
    reset_datatable_close_offcanvas()
  
    getRequest({ url: GET_SELLER_URL, id: orderId.value }).then((res) => {
      if (res.status && res.data) {

        sellers.value = res.data.seller_data
        IsLoading.value=false;
      }
    })
  }, 'seller_list')
  
  
  const reset_datatable_close_offcanvas = () => {
  
      sellers.value = []
    
  }
  </script>
  