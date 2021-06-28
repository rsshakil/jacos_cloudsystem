const state = {
    order_lists: {},
    order_lists_length: 0,
    send_cnt: [{ "*": "全て" }, { "!0": "未送信あり" }, { 0: "送信済" }],
    decission_cnt: [{ "*": "全て" }, { "!0": "未確定あり" }, { 0: "確定済" }],
    confirmation_status_list: [{ "*": "全て" }, { "!0": "未確定あり" }, { 0: "確定済" }],
    page_load: 0,
    form:
    // new Form(
    {
        adm_user_id: Globals.user_info_id,
        per_page: 10,
        byr_buyer_id: null,
        page: 1,
        data_order_id: null,
        send_cnt: "*",
        decission_cnt: "*",
        check_datetime: '*',
        temperature: "*",
        category_code: { category_code: '*', category_name: '全て' },
        delivery_date_from: null,
        delivery_date_to: null,
        delivery_service_code: "*",
        mes_lis_ord_par_sel_code: "",
        receive_date_from: null,
        receive_date_to: null,
        sort_by: 'receive_datetime ',
        sort_type: "DESC",
        downloadType: 1,
        page_title: 'order_list',
    }
    // ),

};
const getters = {};
const actions = {};
const mutations = {
    updateFormValue(state, { target, value }) {
        // console.log(target)
        // console.log(value)
        state.form[target] = value;
    },
    updateFieldValue(state, { target, value }) {
        // console.log(target)
        // console.log(value)
        state[target] = value;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}