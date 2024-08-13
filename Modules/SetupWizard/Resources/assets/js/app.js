import { InitApp } from '@/helpers/main'

import SetupWizard from './components/SetupWizard.vue'

const app = InitApp()

app.component('setup-wizard', SetupWizard)

app.mount('[data-render="setup-app"]');
