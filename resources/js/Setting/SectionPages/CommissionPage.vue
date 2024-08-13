<template>
  <CardTitle title="Commission" icon="fa-solid fa-bars">
    <button class="btn btn-primary d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#exampleModal" aria-controls="form-modal" @click="changeId(0)"><i class="icon-add-new"></i> {{  $t('messages.new') }}</button>
  </CardTitle>
  <CommissionForm :id="tableId" @onSubmit="fetchTableData()"></CommissionForm>
  <div class="table-responsive">
    <table class="table table-condensed">
      <thead>
        <tr>
          <th>{{ $t('commission.lbl_sr_no') }}</th>
          <th>{{ $t('commission.lbl_title') }}</th>
          <th>{{ $t('commission.lbl_value') }}</th>
          <th>{{ $t('commission.lbl_type') }}</th>
          <th>{{ $t('commission.lbl_action') }}</th>
        </tr>
      </thead>
      <template v-if="tableList !== null && tableList.length !== 0">
        <tbody>
          <tr v-for="(item, index) in tableList" :key="index">
            <th>{{ index + 1 }}</th>
            <th>{{ item.title }}</th>
            <th>  <span v-if="item.commission_type === 'percentage'">
                {{ item.commission_value }}%
              </span>
              <span v-else>

                {{formatCurrencyVue(item.commission_value)}}

              </span>
            </th>
            <th class="text-capitalize">{{ item.commission_type }}</th>
            <th>
              <button type="button" class="fs-4 text-primary border-0 bg-transparent me-2" data-bs-toggle="modal" data-bs-target="#exampleModal" @click="changeId(item.id)" aria-controls="form-offcanvas"><i class="icon-Edit"></i></button>
              <button type="button" class="fs-4 text-danger border-0 bg-transparent" @click="destroyData(item.id, 'Are you certain you want to delete it?')" data-bs-toggle="tooltip"><i class="icon-delete"></i></button>
            </th>
          </tr>
        </tbody>
      </template>
      <template v-else>
        <!-- Render message when tableList is null or empty -->
        <tr class="text-center">
          <td colspan="9" class="py-3">Data is not available in this Table</td>
        </tr>
      </template>
    </table>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import CardTitle from '@/Setting/Components/CardTitle.vue'
import { LISTING_URL, DELETE_URL } from '@/vue/constants/commission'
import { useRequest } from '@/helpers/hooks/useCrudOpration'
import CommissionForm from './Forms/CommissionForm.vue'
import { confirmSwal } from '@/helpers/utilities'
import SubmitButton from './Forms/SubmitButton.vue'
const tableId = ref(null)
const changeId = (id) => {
  tableId.value = id
}
const formatCurrencyVue = window.currencyFormat

onMounted(() => {
  fetchTableData()
})

// Request
const { getRequest, deleteRequest } = useRequest()

// Define variables
const tableList = ref(null)

const fetchTableData = () => {
  getRequest({ url: LISTING_URL }).then((res) => {
    if (res.status) {
      tableList.value = res.data
      tableId.value = 0
    }
  })
}

const destroyData = (id, message) => {
  confirmSwal({ title: message }).then((result) => {
    if (!result.isConfirmed) return
    deleteRequest({ url: DELETE_URL, id }).then((res) => {
      if (res.status) {
        Swal.fire({
          title: 'Deleted',
          text: res.message,
          icon: 'success'
        })
        fetchTableData()
      }
    })
  })
}
</script>
