<template>
  <template v-if="bookingData">
    <div class="offcanvas-header">

        <h4>Sale #{{ bookingData.id }} <span class="text-capitalize">({{ bookingData.status }})</span></h4>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>

    </div>
    <div class="offcanvas-body">
      <div class="">
        <div class="d-flex align-items-start gap-3 mb-2">
          <img :src="bookingData.user_profile_image" alt="avatar" class="img-fluid avatar avatar-60 rounded-pill" />
          <div class="flex-grow-1">
            <div class="gap-2">
              <strong>{{ bookingData.user_name }}</strong>
              <p class="m-0">
                <small>Client since {{ moment(bookingData.user_created).format('MMMM YYYY') }}</small>
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div v-for="(service, index) in bookingData.services" :key="index" class="py-2">
          <div class="d-flex flex-column gap-1">
            <div class="d-flex align-items-center justify-content-between">
              <h6 class="m-0">{{ service.service_name }}</h6>
              <div class="d-flex gap-3">
                <p class="m-0">{{ formatCurrencyVue(service.service_price) }}</p>
              </div>
            </div>
            <p class="m-0">
              <label><i>With</i></label> <strong>{{ bookingData.employee_name }}</strong>
            </p>
          </div>
        </div>
      </div>
      <div class="border-top border-bottom py-3">
        <div class="d-flex justify-content-between align-items-center">
          <span>Payment Type</span>
          <span class="badge bg-primary"><strong>{{ bookingTransaction.transaction_type }}</strong></span>
        </div>
        <div class="d-flex justify-content-between align-items-center">
          <span>Subtotal</span>
          <span><strong>{{ formatCurrencyVue(servicesTotal) }}</strong></span>
        </div>
        <div class="d-flex justify-content-between align-items-center" v-for="(tax, index) in bookingTransaction.tax_percentage" :key="index">
          <template v-if="tax.type == 'percent'">
            <span>{{ tax.name }}: {{ tax.percent }}% </span>
            <span><strong>{{ formatCurrencyVue(calculatePercentAmount(tax.percent)) }}</strong></span>
          </template>
          <template v-else>
            <span>{{ tax.name }}: </span>
            <span><strong>{{ formatCurrencyVue(tax.tax_amount) }}</strong></span>
          </template>
        </div>
        <div class="d-flex justify-content-between align-items-center">
          <span>Tip Amount</span>
          <span><strong>{{ formatCurrencyVue(bookingTransaction.tip_amount) }}</strong></span>
        </div>
      </div>
      <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
        <h6 class="m-0">Final Total:</h6>
        <span><strong>{{ formatCurrencyVue(finalAmount) }}</strong></span>
      </div>
      <div class="py-3">
        <p><strong>Booking Detail</strong></p>
        <div>
          <h6><i class="fa-regular fa-clock"></i> Booked On {{ bookingData.created_at }}</h6>
        </div>
        <div class="">
          <h6><i class="fa-regular fa-user"></i> Booked By {{ bookingData.created_by_name }}</h6>
        </div>
        <div class="mt-4">
          <h6><i class="fa-regular fa-clock"></i> Updated On {{ bookingData.updated_at }}</h6>
        </div>
        <div class="">
          <h6><i class="fa-regular fa-user"></i> Updated By {{ bookingData.updated_by_name }}</h6>
        </div>
      </div>
    </div>
  </template>
  <template v-else>
    <div class="offcanvas-header">
      <div>
        <h4>Sale #0 <span class="text-capitalize">(___________)</span></h4>
      </div>
    </div>
  </template>
</template>
<script setup>
import {ref, onMounted, computed} from 'vue'
import {BOOKING_DETAIL} from '../../constant/booking'
import { useRequest } from '@/helpers/hooks/useCrudOpration'
import * as moment from 'moment'

const { getRequest } = useRequest()
const props = defineProps({
  booking_id: {required: true}
})
const formatCurrencyVue = window.currencyFormat
const bookingData = ref(null)
const servicesTotal = ref(0)
const bookingTransaction = ref(null)
const calculatePercentAmount = (percent) => {
  const percentAmount = (servicesTotal.value * percent) / 100;
  return percentAmount
}
const taxAmount = computed(() => {
  let totalTaxAmount = 0;
  if(bookingTransaction.value !== null) {
      for (const tax of bookingTransaction.value.tax_percentage) {
      if (tax.type === 'percent') {
        totalTaxAmount += (servicesTotal.value * tax.percent) / 100;
      } else {
        totalTaxAmount += tax.tax_amount;
      }
    }
    return totalTaxAmount.toFixed(2);
  }
  return totalTaxAmount.toFixed(2);
});
const finalAmount = computed(() => {
  return (
    Number(servicesTotal.value) +
    Number(taxAmount.value) +
    Number(bookingTransaction.value.tip_amount)
  );
});
onMounted(() => {
  getRequest({url: BOOKING_DETAIL, id: props.booking_id}).then((res) => {
    if(res.status) {
      bookingData.value = res.data.booking
      servicesTotal.value = res.data.services_total_amount
      bookingTransaction.value = res.data.booking_transaction
    }
  })
})
</script>
