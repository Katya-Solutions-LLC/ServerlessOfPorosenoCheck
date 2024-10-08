import { createApp } from "vue";
import { createI18n } from "vue-i18n";
import { createPinia } from 'pinia';
import VueformMultiselect from "@vueform/multiselect";
import "@vueform/multiselect/themes/default.css";

export const InitApp = (component) => {
  const pinia = createPinia();

  let app
  if(component != undefined) {
    app = createApp(component);
  } else {
    app = createApp();
  }
    /**
     *
     * !Usage : $t('{key_name}')
     */
    const i18n = createI18n({
        legacy: false,
        locale: "en",
        globalInjection: true,
        messages: {en: window.localMessagesUpdate} || {},
    });

    window.i18n = i18n

    app.use(pinia);
    app.use(i18n);
    app.config.globalProperties.msg = "hello";
    app.component("Multiselect", VueformMultiselect);
    return app;
};
