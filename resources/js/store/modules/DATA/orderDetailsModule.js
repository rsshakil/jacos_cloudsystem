const state = {
    form: {
        data_order_id: null,
        byr_buyer_id: null,
        adm_user_id: Globals.user_info_id,
        order_info: [],
        downloadType: 1,
        printingStatus: "*",
        situation: "*",
        fixedSpecial: "*",
        deliveryDestnation: "",
        deliveryCode: "",
        deliveryDate: "",
        deliveryName: "",
        mes_lis_shi_tra_trade_number: null,
        send_datetime: '*',
        sort_by: 'data_shipment_voucher_id',
        sort_type: "ASC",
        page_title: 'order_detail_list',
        adm_user_id: Globals.user_info_id,
        byr_buyer_id: null,
        par_shi_code: null,
        par_rec_code: null,
        order_item_code: null,
        page: 1,
        per_page: 10,
        data_count: false,
        send_data: false,
        shipment_download_type: 'pdf'
    },
    // form: {
    //     adm_user_id: Globals.user_info_id,
    //     byr_buyer_id: null,
    //     data_order_id: null,
    //     page_title: 'order_detail_list',
    //     per_page: 10,
    //     page: 1,
    //     sort_by: 'data_shipment_voucher_id',
    //     sort_type: "ASC",
    //     downloadType: 1,
    //     order_info: [],
    //     par_shi_code: null,
    //     mes_lis_shi_tra_trade_number: null,
    //     par_rec_code: null,
    //     order_item_code: null,
    //     fixedSpecial: "*",
    //     printingStatus: "*",
    //     situation: "*",
    //     send_datetime: '*',
    //     data_count: false,
    //     send_data: false,
    //     shipment_download_type: 'pdf'
    // }

};
const getters = {
    getFormData(state) {
        return state.form
    },
};
const actions = {};
const mutations = {
    // formValuesStore(state, payload) {
    //     state.form = payload;
    // },
    updateFieldValue(state, { target, value, data_for }) {
        // console.log(data_for)
        // console.log(target)
        // console.log(value)
        if (data_for == 'form') {
            state.form[target] = value;
        } else {
            state[target] = value;
        }
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
