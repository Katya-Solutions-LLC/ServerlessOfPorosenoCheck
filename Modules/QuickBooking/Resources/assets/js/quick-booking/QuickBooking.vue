<template>
  <div class="booking-wizard">
    <div class="container-fluid p-0">
      <div class="widget-layout">
        <div class="non-printable bg-primary rounded">
          <div class="iq-card iq-card-sm widget-tabs">
            <ul class="tab-list">
              <template v-for="(item, index) in setupArray" :key="`items-${index}`">
                <li :class="`${activeCheck(item.id)}  tab-item`" :data-check="`${doneCheck(item.id)}`" v-if="item.is_vissible">
                  <a class="tab-link" :href="`#${item.type}`" :id="`${item.type}-tab`">
                    <h5>{{ item.title }}</h5>
                    <p v-if="item.detail">{{ item.detail }}</p>
                  </a>
                </li>
              </template>
            </ul>
          </div>
        </div>
        <div class="widget-pannel">
          <div id="wizard-tab" class="iq-card iq-card-sm tab-content">
            <template v-for="(item, index) in setupArray" :key="`panel-${index}`">
              <div :id="item.type" :class="`iq-fade iq-tab-pannel ${activeCheck(item.id)}`">
                <TabPanel :type="item.type" :title="item.title" :wizard-next="item.next" :wizard-prev="item.prev" @onClick="nextTabChange" />
              </div>
            </template>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import TabPanel from './TabPanel.vue'

// Setup Array
const setupArray = reactive([

{
    id: 1,
    title: 'Select Service',
    type: 'select-service',
    is_vissible: true,
    detail: 'Select the desired service from the available options.',
    done: false,
    next: 2,
    prev: null
  },

  {
    id: 2,
    title: 'Customer Information',
    type: 'customer-details',
    is_vissible: true,
    detail: "Fill customer's personal details.",
    done: false,
    next: 3,
    prev: 1
  },
  {
    id: 3,
    title: 'Booking Information',
    type: 'select-employee',
    is_vissible: true,
    detail: 'Fill the required booking Information.',
    done: false,
    next: 4,
    prev: 2
  },

  {
    id: 4,
    title: 'Confirmation',
    type: 'select-confirm',
    is_vissible: true,
    detail: 'Confirm your booking.',
    done: false,
    next: 5,
    prev: 3
  },
  {
    id: 5,
    title: 'Confirmation Detail',
    type: 'confirmation-detail',
    is_vissible: false,
    detail: 'Booking details and confirmation.',
    done: false,
    next: null,
    prev: null
  },
])
const currentindex = ref(1)
const activeCheck = (value) => (currentindex.value == value ? 'active' : '')
const doneCheck = (value) => (currentindex.value > value ? true : false)
const nextTabChange = (val) => {
  currentindex.value = val
}
</script>
