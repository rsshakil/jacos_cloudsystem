import Vue from "vue";
import Vuex from "vuex";
import orderModule from "./modules/DATA/ORDER/orderModule"
import orderDetailsModule from "./modules/DATA/ORDER/orderDetailsModule"
import itemSearchModule from "./modules/DATA/ORDER/itemSearchModule"
import defaultModule from "./modules/DEFAULT/defaultModule"
import receiveListModule from "./modules/DATA/receiveListModule"
import receiveDetailListModule from "./modules/DATA/receiveDetailListModule"
import returnListModule from "./modules/DATA/RTN/returnListModule"
import returnDetailsModule from "./modules/DATA/RTN/returnDetailsModule"
import invoiceListModule from "./modules/DATA/INVOICE/invoiceListModule"
import invoiceDetailsModule from "./modules/DATA/INVOICE/invoiceDetailsModule"
import paymentListModule from "./modules/DATA/PAYMENT/paymentListModule"
import paymentItemDetailsModule from "./modules/DATA/PAYMENT/paymentItemDetailsModule"
Vue.use(Vuex);
export default new Vuex.Store({
    modules: {
        orderModule,
        orderDetailsModule,
        itemSearchModule,
        receiveListModule,
        receiveDetailListModule,
        returnListModule,
        returnDetailsModule,
        invoiceListModule,
        invoiceDetailsModule,
        paymentListModule,
        paymentItemDetailsModule,
        defaultModule
    }
})