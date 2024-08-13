<template>
  <div class="offcanvas-body">
    <div class="form-group d-flex align-items-center justify-content-between">
      <label for="">Subtotal: </label>
      <strong>{{ formatCurrencyVue(subtotal) }}</strong>
    </div>
    <div class="form-group d-flex align-items-center justify-content-between" v-for="(tax, index) in taxes" :key="index">
      <template v-if="tax.type == 'percent'">
        <label for="">{{ tax.title }}: {{  tax.value+'%' }}</label>
        <strong>+ {{ currency_symbol }} {{ calculatePercentAmount(tax.value) }}</strong>
      </template>
      <template v-else>
        <label for="">{{ tax.title }}: </label>
        <strong>+ {{ formatCurrencyVue(tax.value) }}</strong>
      </template>
    </div>
    <div class="form-group row">
      <div class="col-8">
      <label for="">Tips: <span class="gap-1" @click="addTip(18)">18%</span> <span class="gap-1" @click="addTip(20)">20%</span> <span class="gap-1" @click="addTip(22)">22%</span></label>
    </div>
      <div class="col-4">
        <div class="row">
          <div class="col-md-9 p-0"> <input type="number" min="0" @input="checkTip"  class="form-control" pattern="[0-9]+" v-model="data.tip" /></div>
          <div class="col-md-1 p-2 "> <strong>{{ currency_symbol }}</strong></div>
        </div>
      </div>
    </div>
    <hr>
    <div class="form-group d-flex align-items-center justify-content-between">
      <label for="">Final Total: </label>
      <strong>{{ finalAmount }}</strong>
    </div>
    <div class="d-grid gap-3 grid-cols-2">
      <template v-for="(item, index) in PAYMENT_METHODS_OPTIONS" :key="index">
        <!-- <div class="d-flex gap-3 form-check col-6"> -->
          <input type="radio" class="form-check-input btn-check" :id="`${item.id}-payment-method`" autocomplete="off" :value="item.id" v-model="data.payment_method" :checked="data.payment_method == item.id" />
          <label class="btn btn-border mb-0" :for="`${item.id}-payment-method`">{{ item.text }}</label>
        <!-- </div> -->
      </template>
    </div>
  </div>
</template>
<script setup>
import { ref, reactive, computed, onMounted } from 'vue'
import {PAYMENT_CREATE_URL} from '../../constant/booking'
import { useRequest } from '@/helpers/hooks/useCrudOpration'

const { listingRequest } = useRequest()

const props = defineProps({
  bookingId: {tyepe: [String, Number], required: true},
  bookingStatus: {tyepe: [String, Number], required: true},
})
const emit = defineEmits(['updatePaymentData'])
const taxes = ref([])
const data = reactive({
  booking_amount: 0,
  payment_method: 'cash',
  final_amount: 0,
  tip: 0,
  taxes: []
})
const PAYMENT_METHODS_OPTIONS = ref([])
const addTip = (tipPercentage) => {
  data.tip = calculatePercentAmount(tipPercentage)
}
const checkTip = (value) => {
  if(Number(value.target.value) < 0) {
    return data.tip = 0
  }
}

const formatCurrencyVue = window.currencyFormat

onMounted(() => {
  listingRequest({url: PAYMENT_CREATE_URL, data: {booking_id: props.bookingId}}).then((res) => {
    if(res.status) {
      data.booking_amount = res.data.booking_amounts.amount
      data.currency = res.data.booking_amounts.currency
      taxes.value = res.data.tax
      PAYMENT_METHODS_OPTIONS.value = res.data.PAYMENT_METHODS
      data.taxes = taxes.value.map((tx) => {
        return {
          name: tx.title,
          type: tx.type,
          percent: tx.type == 'percent' ? tx.value : 0,
          tax_amount: tx.type != 'percent' ? tx.value : 0
        }
      })
    }
  })
})

const calculatePercentAmount = (percent) => {
  const percentAmount = (data.booking_amount * percent) / 100;

  return percentAmount
}
const subtotal = computed(() => {
  return data.booking_amount;
});

const currency_symbol = computed(() => {
  return data.currency;
});


const taxAmount = computed(() => {
  let totalTaxAmount = 0;
  for (const tax of data.taxes) {
    if (tax.type === 'percent') {
      totalTaxAmount += (data.booking_amount * tax.percent) / 100;
    } else {
      totalTaxAmount += tax.tax_amount;
    }
  }
  return totalTaxAmount.toFixed(2);
});
const finalAmount = computed(() => {

  const tip_amount = String(data.tip).replace('$', '')
  submitPayment()
  return window.currencyFormat((
    Number(subtotal.value) +
    Number(taxAmount.value) +
    Number(tip_amount)
  ));
});
const submitPayment = () => {
  emit('updatePaymentData', data)
}
</script>
