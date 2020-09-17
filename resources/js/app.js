/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");
import VueRouter from "vue-router";
// import vueselect from 'vue-select2';
//Routes
import { routes } from "./routes";
//Import Sweetalert2
import Swal from "sweetalert2";
//Import v-from
import { Form, HasError, AlertError } from "vform";
//Import vue multi select
import Multiselect from "vue-multiselect";
import { BootstrapVue, IconsPlugin } from "bootstrap-vue";
// import FlagIcon from 'vue-flag-icon'
// Fabric js 
import { fabric } from 'fabric'
// import VueKonva from 'vue-konva'
import VueBreadcrumbs from 'vue-2-breadcrumbs';
import { Cropper } from 'vue-advanced-cropper'

import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';

window.Fire = new Vue();
Vue.use(VueRouter);
Vue.use(VueBreadcrumbs, {
    template: '        <div v-if="$breadcrumbs.length" aria-label="breadcrumb" class="custm_brd_crumbs">\n' +
        '             <router-link v-for="(crumb, key) in $breadcrumbs" v-if="crumb.meta.breadcrumb" :key="key" class="breadcrumb-item_custom btn btn-primary btn-arrow-right" :to="{ path: getPath(crumb) }">{{ getBreadcrumb(crumb.meta.breadcrumb) }}</router-link>' +
        '        </div>'
});
// Install BootstrapVue
Vue.use(BootstrapVue)
    //     // Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)
    // Vue.use(FlagIcon);
    // Register fabric js globally 
Vue.use(fabric)
Vue.use(Cropper)
    // Vue.use(VueKonva)
    // register globally
Vue.component('multiselect', Multiselect)
    // Vue.use(vueselect);
    //Pagination laravel-vue-pagination
Vue.component('pagination', require('laravel-vue-pagination'));
// spinner register 
Vue.component('spinner', require('vue-simple-spinner'));
Vue.use(Loading, {
    // props
    color: 'red'
}, {
    // slots
})

window.Swal = Swal;
const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: toast => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
    }
});
window.Toast = Toast;

window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
// define a mixin object for global function
import myMixin from "./myMixin";
Vue.mixin(myMixin);

// Permission check directive
Vue.directive("can", function(el, binding, vnode) {
    var given_permission = binding.value;
    if (typeof given_permission == "string") {
        given_permission = [given_permission];
    }
    if (given_permission) {
        var true_array = [];
        var false_array = [];
        for (let i = 0; i < given_permission.length; i++) {
            if (Permissions.indexOf(given_permission[i]) !== -1) {
                true_array.push(true);
            } else {
                false_array.push(false);
            }
        }
        if (true_array.length) {
            return (vnode.elm.hidden = false);
        } else {
            return (vnode.elm.hidden = true);
        }
    }
});

import { VTooltip, VPopover, VClosePopover } from 'v-tooltip'

Vue.directive('tooltip', VTooltip)
Vue.directive('close-popover', VClosePopover)
Vue.component('v-popover', VPopover)



var router = new VueRouter({
    routes: routes,
    linkActiveClass: "active", // active class for non-exact links.
    linkExactActiveClass: "active", // active class for *exact* links.
    mode: "history",
    base: "/jcs"
});
import App from "./components/backend/app.vue";

new Vue({
    router: router,
    render: h => h(App)
}).$mount("#app");