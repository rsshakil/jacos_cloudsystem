import Vue from "vue";
import Vuex from "vuex";
import orderModule from "./modules/DATA/orderModule"
import orderDetailsModule from "./modules/DATA/orderDetailsModule"
import defaultModule from "./modules/DEFAULT/defaultModule"
Vue.use(Vuex);
export default new Vuex.Store({
    modules: {
        orderModule,
        orderDetailsModule,
        defaultModule
    }
})
