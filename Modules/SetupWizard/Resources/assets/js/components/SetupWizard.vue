<template>
  <div class="setup-wizard">
    <div class="container-fluid">
      <div class="widget-layout">
        <div class="iq-card iq-card-sm bg-primary widget-tabs">
          <ul class="tab-list">
            <template v-for="(item, index) in setupArray" :key="`items-${index}`">
              <li :class="`${activeCheck(item.id)}  tab-item`" :data-check="`${doneCheck(item.id)}`">
                <a class="tab-link" :href="`#${item.type}`" :id="`${item.type}-tab`">
                  <h5>{{ item.title }}</h5>
                  <p>{{ item.detail }}</p>
                </a>
              </li>
            </template>
          </ul>
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
    title: 'Database Connection',
    type: 'database-connection',
    detail: 'Setup DB For Storing Recoreds.',
    done: false,
    next: 2,
    prev: null
  },
  {
    id: 2,
    title: 'Salon Registration',
    type: 'salon-registration',
    detail: 'Create your salon with name & logo',
    next: 3,
    prev: 1
  },
  {
    id: 3,
    title: 'Admin Registration',
    type: 'admin-registration',
    detail: 'Create admin credantial',
    done: false,
    next: 4,
    prev: 2
  },
  {
    id: 4,
    title: 'Branches',
    type: 'salon-branches',
    detail: 'Make your multiple branch for salon',
    done: false,
    next: 5,
    prev: 3
  },
  {
    id: 5,
    title: 'Services',
    type: 'salon-services',
    detail: 'Give Multiple Services To Customer',
    done: false,
    next: 6,
    prev: 4
  },
  {
    id: 6,
    title: 'Staff',
    type: 'salon-staff',
    detail: 'Add Staff for complete client service',
    next: 7,
    prev: 5
  },
  {
    id: 7,
    title: 'Finished',
    type: 'setup-finished',
    detail: 'Whooya Salon now opened!',
    next: null,
    prev: null
  }
])
const currentindex = ref(1)
const activeCheck = (value) => (currentindex.value == value ? 'active' : '')
const doneCheck = (value) => (currentindex.value > value ? true : false)
const nextTabChange = (val) => (currentindex.value = val)
</script>
