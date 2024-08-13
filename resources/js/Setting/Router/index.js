import { createRouter, createWebHashHistory } from 'vue-router'
import SettingLayout from '@/Setting/SettingLayout.vue'
import GeneralPage from '@/Setting/SectionPages/GeneralPage.vue'
import SocialProfilePage from '@/Setting/SectionPages/SocialProfilePage.vue'
import MetaPage from '@/Setting/SectionPages/MetaPage.vue'
import AnalyticsPage from '@/Setting/SectionPages/AnalyticsPage.vue'
import CustomCodePage from '@/Setting/SectionPages/CustomCodePage.vue'
import CustomizationPage from '@/Setting/SectionPages/CustomizationPage.vue'
import MobilePage from '@/Setting/SectionPages/MobilePage.vue'
import MailPage from '@/Setting/SectionPages/MailPage.vue'
import NotificationSetting from '@/Setting/SectionPages/NotificationSetting.vue'
import IntegrationPage from '@/Setting/SectionPages/IntegrationPage.vue'
import CustomFieldsPage from '@/Setting/SectionPages/CustomFieldsPage.vue'
import CurrencySettingPage from '@/Setting/SectionPages/CurrencySettingPage.vue'
import CommissionPage from '@/Setting/SectionPages/CommissionPage.vue'
import BookingPage from '@/Setting/SectionPages/BookingPage.vue'
import BussinessHours from '@/Setting/SectionPages/BussinessHours.vue'
import GroomingBussinessHours from '@/Setting/SectionPages/GroomingBussinessHours.vue'
import TrainingBussinessHours from '@/Setting/SectionPages/TrainingBussinessHours.vue'
import PaymentMethod from '@/Setting/SectionPages/PaymentMethod.vue'
import LanguagePage from '@/Setting/SectionPages/LanguagePage.vue'
import MiscSettingPage from '@/Setting/SectionPages/MiscSettingPage.vue'
import QuickBooking from '@/Setting/SectionPages/QuickBooking.vue'
import BookingConfiguration from '@/Setting/SectionPages/BookingConfiguration.vue'
import InvoiceSetting from '@/Setting/SectionPages/InvoiceSetting.vue'
import OtherSetting from '@/Setting/SectionPages/OtherSetting.vue'

const routes = [
  {
    path: '/',
    component: SettingLayout,
    children: [
      {
        path: '',
        name: 'Settings.home',
        component: GeneralPage
      },
      {
        path: 'misc-setting',
        name: 'Settings.misc',
        component: MiscSettingPage
      },
      {
        path: 'quick-booking',
        name: 'Settings.quick-booking',
        component: QuickBooking
      },
      {
        path: 'social-profile',
        name: 'Settings.social-profile',
        component: SocialProfilePage
      },
      {
        path: 'meta',
        name: 'Settings.meta',
        component: MetaPage
      },
      {
        path: 'analitics',
        name: 'Settings.analitics',
        component: AnalyticsPage
      },
      {
        path: 'custom-code',
        name: 'Settings.custom-code',
        component: CustomCodePage
      },
      {
        path: 'customization',
        name: 'Settings.customization',
        component: CustomizationPage
      },
      {
        path: 'mobile',
        name: 'Settings.mobile',
        component: MobilePage
      },
      {
        path: 'mail',
        name: 'Settings.mail',
        component: MailPage
      },
      {
        path: 'notificationsetting',
        name: 'Settings.notificationsetting',
        component: NotificationSetting
      },
      {
        path: 'integration',
        name: 'Settings.integration',
        component: IntegrationPage
      },
      {
        path: 'custom-fields',
        name: 'Settings.custom-fields',
        component: CustomFieldsPage
      },
      {
        path: 'currency-settings',
        name: 'Settings.currency-settings',
        component: CurrencySettingPage
      },
      {
        path: 'commission',
        name: 'Settings.commission',
        component: CommissionPage
      },
      {
        path: 'holidays',
        name: 'Settings.holiday',
        component: () => import('@/Setting/SectionPages/HolidayPage.vue')
      },
      {
        path: 'booking',
        name: 'Settings.booking',
        component: BookingPage
      },
      {
        path: 'bussiness-hours',
        name: 'Settings.bussiness-hours',
        component: BussinessHours
      },
      {
        path: 'grooming-bussiness-hours',
        name: 'Settings.grooming-bussiness-hours',
        component: GroomingBussinessHours
      },
      {
        path: 'training-bussiness-hours',
        name: 'Settings.training-bussiness-hours',
        component: TrainingBussinessHours
      },
      {
        path: 'payment-method',
        name: 'Settings.payment-method',
        component: PaymentMethod
      },
      {
        path: 'language-settings',
        name: 'Settings.language-settings',
        component: LanguagePage
      },
      {
        path: 'booking-configuration',
        name: 'Settings.booking-configuration',
        component: BookingConfiguration
      },
      {
        path: 'invoice-setting',
        name: 'Settings.invoice-setting',
        meta: {permission: 'setting_menu_builder'},
        component: InvoiceSetting
      },
      {
        path: 'other-settings',
        name: 'Settings.other-settings',
        meta: {permission: 'setting_menu_builder'},
        component: OtherSetting
      }
    ]
  }
]


export const router = createRouter({
  linkActiveClass: '',
  linkExactActiveClass: 'active',
  history: createWebHashHistory(),
  routes
})

