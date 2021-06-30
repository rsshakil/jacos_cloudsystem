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
        byr_buyer_id: null,
        data_order_id: null,
        per_page: 10,
        page: 1,
        downloadType: 1,
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
        page_title: 'order_list',
    }
    // ),

};
const getters = {};
const actions = {};
const mutations = {
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
