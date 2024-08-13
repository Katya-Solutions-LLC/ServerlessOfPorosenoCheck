<template>
  <form @submit="formSubmit">
    <div>
      <CardTitle title="Integration" icon="fa-solid fa-sliders"></CardTitle>
    </div>
    <!-- <div class="form-group">
      <div class="d-flex justify-content-between align-items-center">
        <label class="form-label" for="category-is_google_login">{{ $t('setting_integration_page.lbl_google_login') }} </label>
        <div class="form-check form-switch">
          <input class="form-check-input" :true-value="1" :false-value="0" :value="is_google_login" :checked="is_google_login == 1 ? true : false" name="is_google_login" id="category-is_google_login" type="checkbox" v-model="is_google_login" />
        </div>
      </div>
    </div>
    <div v-if="is_google_login == 1">
      <div class="row">
        <div class="col-md-6">
          <InputField class="col-md-12" type="text" :is-required="true" :label="$t('setting_integration_page.lbl_secret_key')" placeholder="" v-model="google_secretkey" :error-message="errors['google_secretkey']" :error-messages="errorMessages['google_secretkey']"></InputField>
        </div>
        <div class="col-md-6">
          <InputField class="col-md-12" type="text" :is-required="true" :label="$t('setting_integration_page.lbl_public_key')" placeholder="" v-model="google_publickey" :error-message="errors['google_publickey']" :error-messages="errorMessages['google_publickey']"></InputField>
        </div>
      </div>
    </div> -->
    <!-- <div class="form-group">
      <div class="d-flex justify-content-between align-items-center">
        <label class="form-label" for="category-is_one_signal_notification">{{ $t('setting_integration_page.lbl_onesignal') }} </label>
        <div class="form-check form-switch">
          <input class="form-check-input" :true-value="1" :false-value="0" :value="is_one_signal_notification" :checked="is_one_signal_notification == 1 ? true : false" name="is_one_signal_notification" id="category-is_one_signal_notification" type="checkbox" v-model="is_one_signal_notification" />
        </div>
      </div>
    </div>
    <div v-if="is_one_signal_notification == 1">
      <div class="row">
        <div class="col-md-4">
          <InputField class="col-md-12" type="text" :is-required="true" :label="$t('setting_integration_page.lbl_api_key')" placeholder="" v-model="onesignal_app_id" :error-message="errors['onesignal_app_id']" :error-messages="errorMessages['onesignal_app_id']"></InputField>
        </div>
        <div class="col-md-4">
          <InputField class="col-md-12" type="text" :is-required="true" :label="$t('setting_integration_page.lbl_rest_api_key')" placeholder="" v-model="onesignal_rest_api_key" :error-message="errors['onesignal_rest_api_key']" :error-messages="errorMessages['onesignal_rest_api_key']"></InputField>
        </div>
        <div class="col-md-4">
          <InputField class="col-md-12" type="text" :is-required="true" :label="$t('setting_integration_page.lbl_channel_id')" placeholder="" v-model="onesignal_channel_id" :error-message="errors['onesignal_channel_id']" :error-messages="errorMessages['onesignal_channel_id']"></InputField>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <InputField class="col-md-12" type="text" :is-required="true" :label="$t('setting_integration_page.lbl_employee_api_key')" placeholder="" v-model="employee_onesignal_app_id" :error-message="errors['employee_onesignal_app_id']" :error-messages="errorMessages['employee_onesignal_app_id']"></InputField>
        </div>
        <div class="col-md-4">
          <InputField class="col-md-12" type="text" :is-required="true" :label="$t('setting_integration_page.lbl_employee_rest_api_key')" placeholder="" v-model="employee_onesignal_rest_api_key" :error-message="errors['employee_onesignal_rest_api_key']" :error-messages="errorMessages['employee_onesignal_rest_api_key']"></InputField>
        </div>
        <div class="col-md-4">
          <InputField class="col-md-12" type="text" :is-required="true" :label="$t('setting_integration_page.lbl_employee_channel_id')" placeholder="" v-model="employee_onesignal_channel_id" :error-message="errors['employee_onesignal_channel_id']" :error-messages="errorMessages['employee_onesignal_channel_id']"></InputField>
        </div>
      </div>
    </div> -->
    <div class="form-group">
      <div class="d-flex justify-content-between align-items-center">
        <label class="form-label" for="category-is_custom_webhook_notification">{{ $t('setting_integration_page.lbl_webhook') }} </label>
        <div class="form-check form-switch">
          <input class="form-check-input" :true-value="1" :false-value="0" :value="is_custom_webhook_notification" :checked="is_custom_webhook_notification == 1 ? true : false" name="is_custom_webhook_notification" id="category-is_custom_webhook_notification" type="checkbox" v-model="is_custom_webhook_notification" />
        </div>
      </div>
    </div>
    <div v-if="is_custom_webhook_notification == 1">
      <div class="row">
        <div class="col-md-6">
          <InputField class="col-md-12" type="text" :is-required="true" :label="$t('setting_integration_page.lbl_custom_webhook_content_key')" placeholder="" v-model="custom_webhook_content_key" :error-message="errors['custom_webhook_content_key']" :error-messages="errorMessages['custom_webhook_content_key']"></InputField>
        </div>
        <div class="col-md-6">
          <InputField class="col-md-12" type="text" :is-required="true" :label="$t('setting_integration_page.lbl_custom_webhook_url')" placeholder="" v-model="custom_webhook_url" :error-message="errors['custom_webhook_url']" :error-messages="errorMessages['custom_webhook_url']"></InputField>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="d-flex justify-content-between align-items-center">
        <label class="form-label" for="category-is_map_key">{{ $t('setting_integration_page.lbl_google') }}</label>
        <div class="form-check form-switch">
          <input class="form-check-input" :true-value="1" :false-value="0" :value="is_map_key" :checked="is_map_key == 1 ? true : false" name="is_map_key" id="category-is_map_key" type="checkbox" v-model="is_map_key" />
        </div>
      </div>
    </div>
    <div v-if="is_map_key == 1">
      <div class="row">
        <div class="col-md-6">
          <InputField class="col-md-12" type="text" :is-required="true" :label="$t('setting_integration_page.lbl_google_key')" placeholder="" v-model="google_maps_key" :error-message="errors['google_maps_key']" :error-messages="errorMessages['google_maps_key']"></InputField>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="d-flex justify-content-between align-items-center">
        <label class="form-label" for="category-is_application_link">{{ $t('setting_integration_page.lbl_application') }}</label>
        <div class="form-check form-switch">
          <input class="form-check-input" :true-value="1" :false-value="0" :value="is_application_link" :checked="is_application_link == 1 ? true : false" name="is_application_link" id="category-is_application_link" type="checkbox" v-model="is_application_link" />
        </div>
      </div>
    </div>
    <div v-if="is_application_link == 1">
      <div class="row">
        <div class="col-md-6">
          <InputField class="col-md-12" type="text" :is-required="true" :label="$t('setting_integration_page.lbl_playstore')" placeholder="" v-model="customer_app_play_store" :error-message="errors['customer_app_play_store']" :error-messages="errorMessages['customer_app_play_store']"></InputField>
        </div>
        <div class="col-md-6">
          <InputField class="col-md-12" type="text" :is-required="true" :label="$t('setting_integration_page.lbl_appstore')" placeholder="" v-model="customer_app_app_store" :error-message="errors['customer_app_app_store']" :error-messages="errorMessages['customer_app_app_store']"></InputField>
        </div>
      </div>

        <div class="row">
        <div class="col-md-6">
          <InputField class="col-md-12" type="text" :is-required="true" :label="$t('setting_integration_page.lbl_emp_playstore')" placeholder="" v-model="employee_app_play_store" :error-message="errors['employee_app_play_store']" :error-messages="errorMessages['employee_app_play_store']"></InputField>
        </div>
        <div class="col-md-6">
          <InputField class="col-md-12" type="text" :is-required="true" :label="$t('setting_integration_page.lbl_emp_appstore')" placeholder="" v-model="employee_app_app_store" :error-message="errors['employee_app_app_store']" :error-messages="errorMessages['employee_app_app_store']"></InputField>
        </div>
      </div>
    </div>

    <div class="form-group">
      <div class="d-flex justify-content-between align-items-center">
        <label class="form-label" for="category-isForceUpdate">{{ $t('setting_integration_page.lbl_isforceupdate') }}</label>
        <div class="form-check form-switch">
          <input class="form-check-input" :true-value="1" :false-value="0" :value="isForceUpdate" :checked="isForceUpdate == 1 ? true : false" name="isForceUpdate" id="category-isForceUpdate" type="checkbox" v-model="isForceUpdate" />
        </div>
      </div>
    </div>
    <div v-if="isForceUpdate == 1">
      <div class="row">
        <div class="col-md-6">
          <InputField class="col-md-12" type="text" :is-required="true" :label="$t('setting_integration_page.lbl_minimum_version_code')" placeholder="" v-model="minimum_force_update_code" :error-message="errors['minimum_force_update_code']" :error-messages="errorMessages['minimum_force_update_code']"></InputField>
        </div>
        <div class="col-md-6">
          <InputField class="col-md-12" type="text" :is-required="true" :label="$t('setting_integration_page.lbl_latest_version_code')" placeholder="" v-model="latest_version_update_code" :error-message="errors['latest_version_update_code']" :error-messages="errorMessages['latest_version_update_code']"></InputField>
        </div>
      </div>
    </div>

    <div class="form-group">
      <div class="d-flex justify-content-between align-items-center">
        <label class="form-label" for="category-isForceUpdateEmployee">{{ $t('setting_integration_page.lbl_isforceupdate_employee') }}</label>
        <div class="form-check form-switch">
          <input class="form-check-input" :true-value="1" :false-value="0" :value="isForceUpdateEmployee" :checked="isForceUpdateEmployee == 1 ? true : false" name="isForceUpdateEmployee" id="category-isForceUpdateEmployee" type="checkbox" v-model="isForceUpdateEmployee" />
        </div>
      </div>
    </div>
    <div v-if="isForceUpdateEmployee == 1">
      <div class="row">
        <div class="col-md-6">
          <InputField class="col-md-12" type="text" :is-required="true" :label="$t('setting_integration_page.lbl_minimum_version_code')" placeholder="" v-model="employee_minimum_force_update_code" :error-message="errors['employee_minimum_force_update_code']" :error-messages="errorMessages['employee_minimum_force_update_code']"></InputField>
        </div>
        <div class="col-md-6">
          <InputField class="col-md-12" type="text" :is-required="true" :label="$t('setting_integration_page.lbl_latest_version_code')" placeholder="" v-model="employee_latest_version_update_code" :error-message="errors['employee_latest_version_update_code']" :error-messages="errorMessages['employee_latest_version_update_code']"></InputField>
        </div>
      </div>
    </div>

    <div class="form-group">
      <div class="d-flex justify-content-between align-items-center">
        <label class="form-label" for="category-zoom">{{ $t('setting_integration_page.lbl_zoom') }} </label>
        <div class="form-check form-switch">
          <input class="form-check-input" :true-value="1" :false-value="0" :value="is_zoom" :checked="is_zoom == 1 ? true : false" name="is_zoom" id="category-is_zoom" type="checkbox" v-model="is_zoom" />
        </div>
      </div>
    </div>
    <div v-if="is_zoom == 1">
      <div class="row">
        <div class="col-md-4">
          <InputField class="col-md-12" type="text" :is-required="true" :label="$t('setting_integration_page.lbl_account_id')" placeholder="" v-model="account_id" :error-message="errors['account_id']" :error-messages="errorMessages['account_id']"></InputField>
        </div>
        <div class="col-md-4">
          <InputField class="col-md-12" type="text" :is-required="true" :label="$t('setting_integration_page.lbl_client_id')" placeholder="" v-model="client_id" :error-message="errors['client_id']" :error-messages="errorMessages['client_id']"></InputField>
        </div>
        <div class="col-md-4">
          <InputField class="col-md-12" type="text" :is-required="true" :label="$t('setting_integration_page.lbl_client_secret')" placeholder="" v-model="client_secret" :error-message="errors['client_secret']" :error-messages="errorMessages['client_secret']"></InputField>
        </div>
      </div>
    </div>

    <SubmitButton :IS_SUBMITED="IS_SUBMITED"></SubmitButton>
  </form>
</template>
<script setup>
import { ref, watch } from 'vue'
import CardTitle from '@/Setting/Components/CardTitle.vue'
import * as yup from 'yup'
import { useField, useForm } from 'vee-validate'
import { STORE_URL, GET_URL } from '@/vue/constants/setting'
import { useRequest } from '@/helpers/hooks/useCrudOpration'
import { onMounted } from 'vue'
import { createRequest } from '@/helpers/utilities'
import SubmitButton from './Forms/SubmitButton.vue'
import InputField from '@/vue/components/form-elements/InputField.vue'
const { storeRequest } = useRequest()
const IS_SUBMITED = ref(false)
//  Reset Form
const setFormData = (data) => {
  resetForm({
    values: {
      is_google_login: data.is_google_login || 0,
      is_one_signal_notification: data.is_one_signal_notification || 0,
      is_custom_webhook_notification: data.is_custom_webhook_notification || 0,
      is_map_key: data.is_map_key  || 0,
      google_secretkey: data.google_secretkey || '',
      google_publickey: data.google_publickey || '',
      onesignal_app_id: data.onesignal_app_id  || '',
      onesignal_rest_api_key: data.onesignal_rest_api_key  || '',
      onesignal_channel_id: data.onesignal_channel_id  || '',
      employee_onesignal_app_id: data.employee_onesignal_app_id  || '',
      employee_onesignal_rest_api_key: data.employee_onesignal_rest_api_key  || '',
      employee_onesignal_channel_id: data.employee_onesignal_channel_id  || '',
      google_maps_key: data.google_maps_key  || '',
      is_application_link: data.is_application_link  || '',
      customer_app_play_store: data.customer_app_play_store  || '',
      customer_app_app_store: data.customer_app_app_store  || '',
      employee_app_play_store: data.employee_app_play_store  || '',
      employee_app_app_store: data.employee_app_app_store  || '',
      custom_webhook_content_key: data.custom_webhook_content_key  || '',
      custom_webhook_url: data.custom_webhook_url  || '',
      isForceUpdate: data.isForceUpdate  || 0,
      minimum_force_update_code: data.minimum_force_update_code  || '',
      latest_version_update_code: data.latest_version_update_code  || '',
      isForceUpdateEmployee: data.isForceUpdateEmployee  || 0,
      employee_minimum_force_update_code: data.employee_minimum_force_update_code  || '',
      employee_latest_version_update_code: data.employee_latest_version_update_code  || '',
      is_zoom: data.is_zoom  || 0,
      account_id: data.account_id  || '',
      client_id: data.client_id  || '',
      client_secret: data.client_secret  || '',
    }
  })
}
//validation
const validationSchema = yup.object({
  // google_secretkey: yup.string().test('google_secretkey' , 'Must be a valid Google key', function(value){
  //   if(this.parent.is_google_login == '1' && !value) {
  //     return false;
  //   }
  //   return true
  // }),
  // google_publickey: yup.string().test("Must be a valid Google Publickey", function(value){
  //   if(this.parent.is_google_login == '1' && !value) {
  //     return false;
  //   }
  //   return true
  // }),
  onesignal_app_id: yup.string().test('onesignal_app_id','Must be a valid App ID', function(value) {
    if(this.parent.is_one_signal_notification == '1' && !value) {
      return false;
    }
    return true
  }),
  onesignal_rest_api_key: yup.string().test('onesignal_rest_api_key', "Must be a valid Rest Key", function(value) {
    if(this.parent.is_one_signal_notification == '1' && !value) {
      return false;
    }
    return true
  }),
  onesignal_channel_id: yup.string().test('onesignal_channel_id', "Must be a valid Channel ID", function(value) {
    if(this.parent.is_one_signal_notification == '1' && !value) {
      return false;
    }
    return true
  }),

  employee_onesignal_app_id: yup.string().test('employee_onesignal_app_id','Must be a valid App ID', function(value) {
    if(this.parent.is_one_signal_notification == '1' && !value) {
      return false;
    }
    return true
  }),
  employee_onesignal_rest_api_key: yup.string().test('employee_onesignal_rest_api_key', "Must be a valid Rest Key", function(value) {
    if(this.parent.is_one_signal_notification == '1' && !value) {
      return false;
    }
    return true
  }),
  employee_onesignal_channel_id: yup.string().test('employee_onesignal_channel_id', "Must be a valid Channel ID", function(value) {
    if(this.parent.is_one_signal_notification == '1' && !value) {
      return false;
    }
    return true
  }),
  google_maps_key: yup.string().test('google_maps_key', "Must be a valid Google MapKey", function(value) {
    if(this.parent.is_map_key == '1' && !value) {
      return false;
    }
    return true
  }),
  customer_app_play_store: yup.string().test('customer_app_play_store',"Must be a valid Customer Playstore App Key", function(value) {
    if(this.parent.is_application_link == '1' && !value) {
      return false;
    }
    return true
  }),
  customer_app_app_store: yup.string().test('customer_app_app_store',"Must be a valid Customer App Key", function(value) {
    if(this.parent.is_application_link == '1' && !value) {
      return false;
    }
    return true
  }),

   employee_app_play_store: yup.string().test('employee_app_play_store',"Must be a valid Employee Playstore App Key", function(value) {
    if(this.parent.is_application_link == '1' && !value) {
      return false;
    }
    return true
  }),
  employee_app_app_store: yup.string().test('employee_app_app_store',"Must be a valid Employee App Key", function(value) {
    if(this.parent.is_application_link == '1' && !value) {
      return false;
    }
    return true
  }),
  custom_webhook_content_key: yup.string().test('custom_webhook_content_key',"Must be a valid wbhook content key", function(value) {
    if(this.parent.is_custom_webhook_notification == '1' && !value) {
      return false;
    }
    return true
  }),
  custom_webhook_url: yup.string().test('custom_webhook_url',"Must be a valid wbhook URL", function(value) {
    if(this.parent.is_custom_webhook_notification == '1' && !value) {
      return false;
    }
    return true
  }),
  minimum_force_update_code: yup.string().test('mimimum_version_code', "Minimum version code for Android is Required", function(value) {
    if(this.parent.isForceUpdate == '1' && !value) {
      return false;
    }
    return true
  }),
  latest_version_update_code: yup.string().test('latest_version_update_code', "Latest version code for Android is Required", function(value) {
    if(this.parent.isForceUpdate == '1' && !value) {
      return false;
    }
    return true
  }),

  employee_minimum_force_update_code: yup.string().test('mimimum_version_code', "Minimum version code for Android is Required", function(value) {
    if(this.parent.isForceUpdateEmployee == '1' && !value) {
      return false;
    }
    return true
  }),
  employee_latest_version_update_code: yup.string().test('latest_version_update_code', "Latest version code for Android is Required", function(value) {
    if(this.parent.isForceUpdateEmployee == '1' && !value) {
      return false;
    }
    return true
  }),

  account_id: yup.string().test('account_id', "Zoom Account ID is Required", function(value) {
    if(this.parent.is_zoom == '1' && !value) {
      return false;
    }
    return true
  }),

  client_id: yup.string().test('client_id', "Zoom Client ID is Required", function(value) {
    if(this.parent.is_zoom == '1' && !value) {
      return false;
    }
    return true
  }),

  client_secret: yup.string().test('client_secret', "Zoom Client Secret key is Required", function(value) {
    if(this.parent.is_zoom == '1' && !value) {
      return false;
    }
    return true
  }),

})
const { handleSubmit, errors, resetForm, validate } = useForm({validationSchema})
const errorMessages = ref({})
const { value: is_google_login } = useField('is_google_login')
const { value: is_one_signal_notification } = useField('is_one_signal_notification')
const { value: is_custom_webhook_notification } = useField('is_custom_webhook_notification')
const { value: google_secretkey } = useField('google_secretkey')
const { value: google_publickey } = useField('google_publickey')
const { value: onesignal_app_id } = useField('onesignal_app_id')
const { value: onesignal_rest_api_key } = useField('onesignal_rest_api_key')
const { value: onesignal_channel_id } = useField('onesignal_channel_id')
const { value: employee_onesignal_app_id } = useField('employee_onesignal_app_id')
const { value: employee_onesignal_rest_api_key } = useField('employee_onesignal_rest_api_key')
const { value: employee_onesignal_channel_id } = useField('employee_onesignal_channel_id')
const { value: is_map_key } = useField('is_map_key')
const { value: is_application_link } = useField('is_application_link')
const { value: google_maps_key } = useField('google_maps_key')
const { value: customer_app_play_store } = useField('customer_app_play_store')
const { value: customer_app_app_store } = useField('customer_app_app_store')
const { value: employee_app_play_store } = useField('employee_app_play_store')
const { value: employee_app_app_store } = useField('employee_app_app_store')
const { value: custom_webhook_content_key} = useField('custom_webhook_content_key')
const { value: custom_webhook_url } = useField('custom_webhook_url')
const { value: isForceUpdate } = useField('isForceUpdate')
const { value: minimum_force_update_code } = useField('minimum_force_update_code')
const { value: latest_version_update_code } = useField('latest_version_update_code')
const { value: isForceUpdateEmployee } = useField('isForceUpdateEmployee')
const { value: employee_minimum_force_update_code } = useField('employee_minimum_force_update_code')
const { value: employee_latest_version_update_code } = useField('employee_latest_version_update_code')
const { value: is_zoom } = useField('is_zoom')
const { value: account_id } = useField('account_id')
const { value: client_id } = useField('client_id')
const { value: client_secret } = useField('client_secret')


watch(() => is_map_key.value, (value) => {
  if(value == '0') {
    google_maps_key.value = ''
  }
}, {deep: true})
watch(() => is_google_login.value, (value) => {
  if(value == '0') {
    google_secretkey.value = ''
    google_publickey.value = ''
  }
}, {deep: true})
watch(() => isForceUpdate.value, (value) => {
  if(value == '0') {
    minimum_force_update_code.value = ''
    latest_version_update_code.value = ''
  }
}, {deep: true})
watch(() => isForceUpdateEmployee.value, (value) => {
  if(value == '0') {
    employee_minimum_force_update_code.value = ''
    employee_latest_version_update_code.value = ''
  }
}, {deep: true})
watch(() => is_custom_webhook_notification.value, (value) => {
  if(value == '0') {
    custom_webhook_content_key.value = ''
    custom_webhook_url.value = ''
  }
}, {deep: true})
watch(() => is_one_signal_notification.value, (value) => {
  if(value == '0') {
    onesignal_app_id.value = ''
    onesignal_rest_api_key.value = ''
    onesignal_channel_id.value = ''
    employee_onesignal_app_id.value = ''
    employee_onesignal_rest_api_key.value = ''
    employee_onesignal_channel_id.value = ''
  }
}, {deep: true})

watch(() => is_zoom.value, (value) => {
  if(value == '0') {
    account_id.value = ''
    client_id.value = ''
    client_secret.value = ''
  }
}, {deep: true})
// message
const display_submit_message = (res) => {
  IS_SUBMITED.value = false
  if (res.status) {
    window.successSnackbar(res.message)
  } else {
    window.errorSnackbar(res.message)
    errorMessages.value = res.errors
  }
}

//fetch data
const data = [
  'is_google_login',
  'is_one_signal_notification',
  'is_mobile_notification',
  'is_map_key',
  'is_application_link',
  'is_custom_webhook_notification',
  'isForceUpdate',
  'isForceUpdateEmployee',
  'is_zoom',
]

const zoom_key = [
  'account_id',
  'client_id',
  'client_secret',
]

const onesignal_key = [
  'onesignal_app_id',
  'onesignal_rest_api_key',
  'onesignal_channel_id',
  'employee_onesignal_app_id',
  'employee_onesignal_rest_api_key',
  'employee_onesignal_channel_id',
]

const custom_webhook_key = [
  'custom_webhook_content_key',
  'custom_webhook_url'
]

const customer_app = [
  'customer_app_play_store',
  'customer_app_app_store',
  'employee_app_play_store',
  'employee_app_app_store',
]
const google_map_key = [
  'google_maps_key',
]
const google_login_key = [
  'google_secretkey',
  'google_publickey',
]
const versions_key = [
  'minimum_force_update_code',
  'latest_version_update_code',
  'employee_minimum_force_update_code',
  'employee_latest_version_update_code',
]
onMounted(() => {

  const customData = [
    ...data,
    ...onesignal_key,
    ...custom_webhook_key,
    ...customer_app,
    ...google_map_key,
    ...google_login_key,
    ...versions_key,
    ...zoom_key,
  ].join(",")

  createRequest(GET_URL(customData)).then((response) => {
    setFormData(response)
  })
})

//Form Submit
const formSubmit = handleSubmit((values) => {
  IS_SUBMITED.value = true
  const newValues = {}
  Object.keys(values).forEach((key) => {
    if(values[key] !== '') {
      newValues[key] = values[key] || ''
    }
  })
  storeRequest({
    url: STORE_URL, 
    body: newValues
  }).then((res) => display_submit_message(res))
})

defineProps({
  label: { type: String, default: '' },
  modelValue: { type: String, default: '' },
  placeholder: { type: String, default: '' },
  errorMessage: { type: String, default: '' },
  errorMessages: { type: Array, default: () => [] }
})
</script>
