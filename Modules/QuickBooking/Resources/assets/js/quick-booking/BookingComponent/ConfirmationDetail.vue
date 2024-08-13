<template>
  <div class="card-list-data" v-if="booking">
    <div class="row">
      <div class="col-sm-6">
        <div class="confirmation-info-section">
          <h6 class="text-primary text-uppercase fw-bold mb-3">{{$t('quick_booking.Customer_info')}}</h6>
          <div class="iq-card bg-soft-primary text-body p-3">
            <div class="iq-card-body">

              <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-2">{{$t('quick_booking.name')}}:</h6>
                <p class="mb-2">{{ user.first_name }} {{ user.last_name }}</p>
              </div>

              <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-2">{{$t('quick_booking.number')}}:</h6>
                <p class="mb-2">{{ user.mobile }}</p>
              </div>

              <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-2">{{$t('quick_booking.lbl_Email')}}:</h6>
                <p class="mb-2">{{ user.email }}</p>
              </div>

            </div>
          </div>
        </div>

        <div class="confirmation-info-section" v-if="booking_details != null">
          <h6 class="text-primary text-uppercase fw-bold mb-3 mt-2">{{$t('quick_booking.Employee_Details')}}</h6>
          <div class="iq-card bg-soft-primary text-body p-3">
            <div class="iq-card-body">

              <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-2">{{$t('quick_booking.Employee')}}:</h6>
                <p class="mb-2">{{ booking_details.employee.first_name }} {{ booking_details.employee.last_name }}</p>
              </div>

              <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-2">{{$t('quick_booking.number')}}:</h6>
                <p class="mb-2">{{ booking_details.employee.mobile }}</p>
              </div>

              <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-2">{{$t('quick_booking.lbl_Email')}}:</h6>
                <p class="mb-2">{{ booking_details.employee.email }}</p>
              </div>

            </div>
          </div>
        </div>

        <div class="confirmation-info-section" v-if="booking_details != null">
          <h6 class="text-primary text-uppercase fw-bold mb-3 mt-2">{{$t('quick_booking.Petinfo')}}</h6>
          <div class="iq-card bg-soft-primary text-body p-3">
            <div class="iq-card-body">

              <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-2">{{$t('quick_booking.name')}}:</h6>
                <p class="mb-2">{{ booking_details.pet.name }}</p>
              </div>

              <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-2">{{$t('quick_booking.pet_type')}}:</h6>
                <p class="mb-2">{{ booking_details.pet.pettype.name }}</p>
              </div>

              <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-2">{{$t('quick_booking.age')}}:</h6>
                <p class="mb-2">{{ booking_details.pet.age }}</p>
              </div>

            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6" v-if="booking_details != null">
        <!-- <h6 class="text-primary text-uppercase fw-bold mb-3">Employee Details</h6>
                <div class="iq-card iq-card-border p-3">

                
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="m-0">Employee :</p>
                        <h6 class="m-0">{{booking_details.employee.first_name}} {{booking_details.employee.last_name}}</h6>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <p class="m-0">Email :</p>
                        <h6 class="m-0">{{booking_details.employee.email}} </h6>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <p class="m-0">Phone Number :</p>
                        <h6 class="m-0">{{booking_details.employee.mobile}} </h6>
                    </div>

                </div> -->

        <div class="col-sm-12" v-if="booking_details != null">
          <h6 class="text-primary text-uppercase fw-bold mb-3">{{$t('quick_booking.Appointment_summary')}}</h6>
          <div class="iq-card iq-card-border p-3">
            <div class="d-flex justify-content-between align-items-center">
              <p class="m-0">{{$t('quick_booking.Services_Type')}} :</p>
              <h6 class="m-0">{{ booking_details.booking_type }}</h6>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
              <p class="m-0">{{$t('quick_booking.date')}} :</p>
              <h6>
                <span id="dateOfAppointment">{{ moment(booking_details.date).format('D, MMM YYYY') }}</span>
              </h6>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
              <p class="m-0">{{$t('quick_booking.time')}} :</p>
              <h6 class="m-0">
                <span>{{ moment(booking_details.time, 'HH:mm').format('hh:mm A') }}</span>
              </h6>
            </div>
            <div v-if="booking_details.booking_type == 'veterinary'">
              <div class="iq-card bg-soft-primary text-body p-3 mt-4 mb-0 shadow-none">
                <div class="iq-card-body">
                  <h6>{{$t('quick_booking.Services')}}</h6>
                  <div class="services_list">
                    <div class="d-flex justify-content-between align-items-center mt-2">
                      <p class="m-0">{{ booking_details.veterinary.service.name }}</p>
                    </div>
                  </div>
                  <div class="d-flex gap-5" >
                    <p>{{$t('quick_booking.Service_Amount')}}:</p>
                    <h5>{{ formatCurrencyVue(booking_details.veterinary.service.default_price) }}</h5>
                  </div>
                  </div>
                <div class="iq-card-body">
                  <h6>{{$t('quick_booking.Taxes')}}</h6>
                  <template v-if="booking_details.tax != ''">
                    <div class="d-flex align-items-center justify-content-between" v-for="(tax, index) in booking_details.tax" :key="index">
                      <template v-if="tax.type == 'percentage'">
                        <p>{{ tax.title }}: {{ tax.value + '%' }}</p>
                        <h6>{{ formatCurrencyVue(calculatePercentAmount(tax.value, booking_details.veterinary.service.default_price)) }}</h6>
                      </template>
                      <template v-else>
                        <p>{{ tax.title }}:</p>
                        <h6>{{ formatCurrencyVue(tax.value) }}</h6>
                      </template>
                    </div>
                  </template>
                </div>
              </div>
            </div>

            <div v-else-if="booking_details.booking_type == 'grooming'">

                <div class="iq-card bg-soft-primary text-body p-3 mt-4 mb-0 shadow-none">
                    <div class="iq-card-body">
                      <h6>{{$t('quick_booking.Services')}}</h6>
                      <div class="services_list">
                        <div class="d-flex justify-content-between align-items-center mt-2">
                          <p class="m-0">{{ booking_details.grooming.service_name }}</p>
                        </div>
                      </div>
                      <div class="d-flex gap-5">
                        <p>{{$t('quick_booking.Service_Amount')}}:</p>
                        <h5>{{ formatCurrencyVue(booking_details.grooming.price) }}</h5>
                      </div>
                    </div>
                    <div class="iq-card-body">
                      <h6>{{$t('quick_booking.Taxes')}}</h6>
                      <template v-if="booking_details.tax != ''">
                        <div class="d-flex align-items-center justify-content-between" v-for="(tax, index) in booking_details.tax" :key="index">
                          <template v-if="tax.type == 'percentage'">
                            <p>{{ tax.title }}: {{ tax.value + '%' }}</p>
                            <h6>{{ formatCurrencyVue(calculatePercentAmount(tax.value, booking_details.grooming.price)) }}</h6>
                          </template>
                          <template v-else>
                            <p>{{ tax.title }}:</p>
                            <h6>{{ formatCurrencyVue(tax.value) }}</h6>
                          </template>
                        </div>
                      </template>
                    </div>
                  </div>
               
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <h5>{{$t('quick_booking.Total_Price')}}</h5>
                <h5 class="text-primary services-total">{{ formatCurrencyVue(booking_details.total_amount) }}</h5>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card-footer non-printable">
    <div class="d-flex flex-wrap gap-1 justify-content-center">
      <button type="button" class="btn btn-primary d-flex gap-3" @click="reset">
        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        <span>{{$t('quick_booking.book_appointments')}}</span>
      </button>
      <button type="button" class="btn btn-secondary d-flex gap-3" @click="print">
        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
        </svg>
        <span>{{$t('quick_booking.Print_PDF')}}</span>
      </button>
    </div>
  </div>
</template>

<script setup>
import { computed, watch, onMounted, ref } from 'vue'
import { useQuickBooking } from '../../store/quick-booking'
import moment from 'moment'
const props = defineProps({
  wizardNext: {
    default: '',
    type: [String, Number]
  },
  wizardPrev: {
    default: '',
    type: [String, Number]
  }
})
const emit = defineEmits(['tab-change', 'onReset'])
const reset = () => {
  emit('onReset')
}
const print = () => {
  window.print()
}
const formatCurrencyVue = (value) => {
  if (window.currencyFormat !== undefined) {
    return window.currencyFormat(value)
  }
  return value
}

const calculatePercentAmount = (percent, amount) => {
  const percentAmount = (amount * percent) / 100
  return percentAmount
}

const currency_symbol = computed(() => {
  return window.defaultCurrencySymbol || ''
})

const store = useQuickBooking()
const booking = computed(() => store.booking)

const user = computed(() => store.user)

const booking_details = computed(() => store.bookingResponse)
</script>
