import Vue from "vue";
import Vuex from "vuex";
import orderModule from "./modules/DATA/orderModule"
import orderDetailsModule from "./modules/DATA/orderDetailsModule"
import itemSearchModule from "./modules/DATA/itemSearchModule"
import defaultModule from "./modules/DEFAULT/defaultModule"
import receiveListModule from "./modules/DATA/receiveListModule"
import receiveDetailListModule from "./modules/DATA/receiveDetailListModule"
Vue.use(Vuex);
export default new Vuex.Store({
    modules: {
        orderModule,
        orderDetailsModule,
        itemSearchModule,
        receiveListModule,
        receiveDetailListModule,
        defaultModule
    }
})
