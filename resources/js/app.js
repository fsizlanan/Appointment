/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

import VueMask from "v-mask";
import Vue from "vue";
// import socketio from 'socket.io';
// import VueSocketIO from 'vue-socket.io';

window.Vue = require("vue").default;

Vue.use(VueMask);
// Vue.use("~/server.js")
Vue.use(require("vue-resource"));
// Vue.use(require("socket.io-client"));
// Vue.use(require("{express}"));

// export const SocketInstance = socketio('http://localhost:4113');
// Vue.use(VueSocketIO, SocketInstance)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component(
    "appointment-waiting",
    require("./components/Admin/AdminAppointmentWaitingComponent.vue").default
);
Vue.component(
    "appointment-cancel",
    require("./components/Admin/AdminAppointmentCancelComponent.vue").default
);
Vue.component(
    "appointment-item",
    require("./components/Admin/AdminListAppointment.vue").default
);
Vue.component(
    "appointment-list",
    require("./components/Admin/AdminAppointmentComponent.vue").default
);
Vue.component(
    "appointment-today",
    require("./components/Admin/AdminTodayAppointmentComponent.vue").default
);
Vue.component(
    "appointment-last",
    require("./components/Admin/AdminLastAppointmentComponent.vue").default
);
Vue.component(
    "admin-appointment",
    require("./components/Admin/AdminComponent.vue").default
);
Vue.component(
    "admin-working",
    require("./components/Admin/AdminWorkingComponent.vue").default
);
Vue.component(
    "admin-working-item",
    require("./components/Admin/AdminWorkingItemComponent.vue").default
);
Vue.component(
    "admin-appointment-modal",
    require("./components/Admin/AdminAppointmentModal.vue").default
);

Vue.component(
    "appointment-form",
    require("./components/RandevuFormComponent.vue").default
);
Vue.component(
    "appointment-datail",
    require("./components/RandevuDetailComponent.vue").default
);

Vue.component("pagination", require("laravel-vue-pagination"));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app"
});
