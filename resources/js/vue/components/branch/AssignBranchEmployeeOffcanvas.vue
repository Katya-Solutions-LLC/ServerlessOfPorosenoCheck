<template>
    <form @submit.prevent="formSubmit">
        <div class="offcanvas offcanvas-end offcanvas-booking" tabindex="-1" id="staff-assign-form" aria-labelledby="form-offcanvasLabel">
            <div class="offcanvas-header">
               <h4>Assign Staff</h4>
            </div>
            <div class="offcanvas-body">
                <div class="d-flex flex-column">
                    <div class="mb-4">
                        <Multiselect v-model="assign_ids" placeholder="Select Branch" :value="assign_ids" :canClear="false" v-bind="staffs" @select="selectEmployee" id="employees_ids">
                          <template v-slot:multiplelabel="{ values }">
                            <div class="multiselect-multiple-label">Select Staff</div>
                          </template>
                        </Multiselect>
                    </div>
                    <div v-for="(item, index) in selectedEmployee" :key="item" class="list-group-item d-flex justify-content-between align-items-center">
                      <div class="d-flex justify-between flex-grow-1 gap-2 my-2">
                        <img :src="item.avatar" class="avatar avatar-40 img-fluid rounded-pill" alt="user" />
                        <div class="flex-grow-1 mt-2"> {{ item.name }}</div>
                      </div>
                      <button type="button" @click="removeEmployee(item.employee_id)" class="btn btn-sm text-danger"><i class="fa-regular fa-trash-can"></i></button>
                    </div>
                </div>
            </div>
            <div class="offcanvas-footer">
                <div class="d-grid gap-3 p-3">
                    <button class="btn btn-primary d-block">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Update
                    </button>
                    <button class="btn btn-outline-primary d-block" type="button" data-bs-dismiss="offcanvas">
                        <i class="fa-solid fa-angles-left"></i>
                        Close
                    </button>
                </div>
            </div>
        </div>
    </form>
</template>
<script setup>
import { ref, onMounted } from 'vue'
import { POST_ASSIGN_URL, GET_ASSIGN_URL } from '../../constants/branch'
import { EMPLOYEE_LIST } from '../../constants/branch'
import { useModuleId, useRequest } from '@/helpers/hooks/useCrudOpration'
import {buildMultiSelectObject} from '@/helpers/utilities'

// Request
const {listingRequest, getRequest, updateRequest} = useRequest()

// Vue Form Select START
// Select Option
const staffs = ref({
    mode: 'multiple',
    options: []
})

const selectedEmployee = ref([])
// Vue Form Select END

// Form Values
const assign_ids = ref([])
const branchId = useModuleId(() => {
    getRequest({url: GET_ASSIGN_URL, id: branchId.value}).then((res) => {
        if(res.status && res.data) {
            selectedEmployee.value = res.data
            assign_ids.value = res.data.map((item) => item.employee_id)
        }
    })
}, 'staff_assign')


const staffList = ref([])

onMounted(() => {
    listingRequest({url: EMPLOYEE_LIST}).then((res) => {
        staffList.value = res
        staffs.value.options = buildMultiSelectObject(res, {value: 'id', label: 'name'})
    })
});

// Reload Datatable, SnackBar Message, Alert, Offcanvas Close
const errorMessages = ref([])
const reset_close_offcanvas = (res) => {
    if(res.status) {
        window.successSnackbar(res.message)
        renderedDataTable.ajax.reload(null, false)
        bootstrap.Offcanvas.getInstance('#staff-assign-form').hide()
    } else {
        window.errorSnackbar(res.message)
        errorMessages.value = res.all_message
    }
}

const formSubmit = () => {

    const data =  {users: assign_ids.value}

    updateRequest({url: POST_ASSIGN_URL, id: branchId.value, body: data}).then((res) => reset_close_offcanvas(res))
}

const selectEmployee = (value) => {
    selectedEmployee.value = [...selectedEmployee.value, ...staffList.value.filter((staff) => staff.id === value)]
}
const removeEmployee = (value) => {
  selectedEmployee.value = [...selectedEmployee.value.filter((emp) => emp.employee_id !== value)]
  assign_ids.value = [...assign_ids.value.filter((emp) => emp !== value)]
}

</script>
