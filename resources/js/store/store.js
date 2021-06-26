import Vue from "vue";
import Vuex from "vuex";
import orderModule from "./modules/orderModule"
Vue.use(Vuex);
export default new Vuex.Store({
    modules: {
        orderModule
    }
})
