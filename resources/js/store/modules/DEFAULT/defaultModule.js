const state = {
    products: [
        { name: 'Order', line: 28 },
        { name: 'Receive', line: 24 },
        { name: 'Return', line: 1 }
    ],

};
const getters = {};
const actions = {};
const mutations = {
    // getbuyerJsonSettingvalue() {
    //     this.paramInfo.component_name = this.$route.name;
    //     axios.post(this.BASE_URL + "api/buyerJsonSetting", this.paramInfo)
    //         .then(({ data }) => {
    //             this.buyer_settings = data.buyer_settings;
    //             this.mes_lis_ord_tra_ins_trade_type_codeList = data.buyer_settings.returns.mes_lis_ret_tra_ins_trade_type_code;
    //             this.mes_lis_shi_lin_qua_sto_reason_codeList = this.buyer_settings.shipments.mes_lis_shi_lin_qua_sto_reason_code;
    //             this.json_temperature_codeList = this.buyer_settings.orders.mes_lis_ord_tra_ins_temperature_code;
    //             this.json_delivery_service_codeList = this.buyer_settings.orders.mes_lis_ord_log_del_delivery_service_code;
    //             this.mes_lis_ord_tra_ins_goods_classification_codeList = data.buyer_settings.orders.mes_lis_ord_tra_ins_goods_classification_code;

    //             this.mes_lis_inv_lin_det_balance_carried_codeList = data.buyer_settings.invoices.mes_lis_inv_lin_det_balance_carried_code;
    //             this.mes_lis_inv_lin_det_pay_code_list = data.buyer_settings.invoices.mes_lis_inv_lin_det_pay_code;

    //             this.ordersJson = this.buyer_settings.orders;
    //             this.shipmentsJson = this.buyer_settings.shipments;
    //             this.receivesJson = this.buyer_settings.receives;
    //             this.corrected_receivesJson = this.buyer_settings.corrected_receives;
    //             this.returnsJson = this.buyer_settings.returns;

    //             this.invoicesJson = this.buyer_settings.invoices;
    //             this.paymentsJson = this.buyer_settings.payments;
    //             this.byr_buyer_category_lists = data.buyer_category_list;
    //             this.byr_buyer_category_lists.unshift({ category_code: '*', category_name: '全て' });
    //         });
    // },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}