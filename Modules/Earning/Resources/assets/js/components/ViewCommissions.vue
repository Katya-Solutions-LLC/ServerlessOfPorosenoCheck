<template>
  <form @submit.prevent="formSubmit">
    <div class="offcanvas offcanvas-end offcanvas-booking" tabindex="-1" id="view_commission_list" aria-labelledby="form-offcanvasLabel">
      <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="form-offcanvasLabel">  
        
        <span>{{Username}}</span>
       
        </h5>

        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>

      </div>


        <div class="list-group list-group-flush">
          <div v-for="(item, index) in commissions" :key="item" class="list-group-item d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center flex-grow-1 gap-2 my-2">
        
              <div class="flex-grow-1"> {{ item.get_commission.title}} </div>

              <div class="flex-grow-1" v-if="item.get_commission.commission_type=='percentage'"> {{ item.get_commission.commission_value}}%</div>

              <div class="flex-grow-1" v-else> {{formatCurrencyVue(item.get_commission.commission_value)}}</div>
      
            </div>
            
          </div>
          </div>

    
       
      
    </div>
  </form>


  
</template>
<script setup>
import { ref, onMounted } from 'vue'
import { GET_EMPLOYEE_COMMISSSION_URL } from '../constant/earning'
import { useModuleId, useRequest,useOnOffcanvasHide,useOnOffcanvasShow} from '@/helpers/hooks/useCrudOpration'
import { confirmSwal } from '@/helpers/utilities'



// Request
const { deleteRequest, getRequest, listingRequest} = useRequest()

const props=defineProps({
  type: { type: String, default: '' },
})
const formatCurrencyVue = window.currencyFormat

const commissions = ref([])

const Username = ref(null)

const EmployeeId = useModuleId(() => {

  const commissionType = document.querySelector('[data-assign-event="assign_commssions"]').dataset.assignCommissionType;
   
  listingRequest({ url: GET_EMPLOYEE_COMMISSSION_URL, data: { id: EmployeeId.value, type: commissionType }}).then((res) => {
    if (res.status && res.data) {

      commissions.value = res.data.commissions_data
      Username.value = res.data.full_name + "'s Commissions list"

      EmployeeId.value = 0
    }
  })
 // getRequest({ url: EDIT_URL, id: UserId.value }).then((res) => res.status && (pets.value = res.data))
}, 'assign_commssions')


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