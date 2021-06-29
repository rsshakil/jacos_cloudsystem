const state = {
    // byr_buyer_id: null,
    adm_user_id: Globals.user_info_id,
    // data_order_id: null,
    // rows: 100,
    // currentPage: 1,
    // // today: new Date().toISOString().slice(0, 10),
    // sortKey: "",
    // reverse: true,
    // order_by: "asc",
    // order_detail_lists: {},
    // order_info: {},
    // order_date: "",
    // order_detail_list: [],
    // order_detail_list_length: 0,
    // show_hide_col_list: [],
    // expected_delivery_date: "",
    // status: "",
    // edit_order_modal: false,
    // order_search_modal1: false,
    // order_search_modal2: false,
    // order_search_modal3: false,
    // order_search_modal1List: [],
    // order_search_modal2List: [],
    // order_search_modal3List: [],
    // selected: [],
    // selectedNum: 0,
    // select_field_page_num: 0,
    // select_field_per_page_num: 10,
    // isCheckAll: false,
    // fixedSpecialOptionList: [
    //     { "01": "定番" },
    //     { "02": "準特価" },
    //     { "03": "特売" },
    // ],
    // situationOptionList: ["未確定あり", "確定済"],
    // printingStatusOptionList: ["未印刷あり", "印刷済"],
    // deliveryDestnationOptionList: ["店舗", "物流センター"],
    // send_datetime_options: ["未送信あり", "送信済"],
    // date_null: false,
    // null_selected: [],
    // not_null_selected: [],
    // null_selected_message: false,
    param_data: [],
    // item_search_q: [],
    page_reload: 0,
    form: {
        adm_user_id: Globals.user_info_id,
        byr_buyer_id: null,
        data_order_id: null,
        per_page: 10,
        page: 1,
        downloadType: 1,
        order_info: [],
        // printingStatus: "*",
        // situation: "*",
        // fixedSpecial: "*",
        // deliveryDestnation: "",
        // deliveryCode: "",
        // deliveryDate: "",
        // deliveryName: "",
        // mes_lis_shi_tra_trade_number: null,
        // send_datetime: '*',
        // sort_by: 'data_shipment_voucher_id',
        // sort_type: "ASC",
        // page_title: 'order_detail_list',
        // adm_user_id: Globals.user_info_id,
        // byr_buyer_id: null,
        // par_shi_code: null,
        // par_rec_code: null,
        // order_item_code: null,
        // page: 1,
        // per_page: 10,
        // data_count: false,
        // send_data: false,
        // shipment_download_type: 'pdf'
    }

};
const getters = {};
const actions = {};
const mutations = {
    updateFieldValue(state, { target, value, data_for }) {
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
