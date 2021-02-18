<template>
  <div class="row">
    <div class="col-12" style="background: #d8e3f0; padding: 10px">
    </div>
    

    <div class="col-12">
      <div class="row">
     
      <div class="col-12">
        <h4 class="page_custom_title">取引先別支払合計</h4>
          <table
          class="table table-striped order_item_details_table table-bordered data_table"
        >
          <thead>
            <tr>
              <th style="cursor: pointer">取引先コード</th>
              <th style="cursor: pointer">受注FAX</th>
              <th></th>
              <th style="cursor: pointer">支払FAX</th>
              <th></th>
              <th>締日登録</th>
            </tr>
          </thead>
          <tbody>
           <tr v-for="(item,index) in cmnConnectOptionList" :key="index">
            <td>{{item.partner_code}}</td>
            <td>{{JSON.parse(item.optional).order.fax.number}}</td>
            <td><label class="switch">
                <input
                  @change="execStatusChange(item)"
                  :id="item.partner_code"
                  type="checkbox"
                  v-model="JSON.parse(item.optional).order.fax.exec"
                />
                <span class="slider round"></span>
              </label></td>
            <td>{{JSON.parse(item.optional).payment.fax.number}}</td>
            <td><label class="switch">
                <input
                  @change="execStatusChange(item)"
                  :id="item.partner_code+1"
                  type="checkbox"
                  v-model="JSON.parse(item.optional).order.fax.exec"
                />
                <span class="slider round"></span>
              </label></td>
              <td><button class="btn btn-primary" @click="updateInvoiceSettingByModal(item)">締日登録</button></td>
           </tr>
          </tbody>
        </table>
        
      </div>
        
      </div>
    </div>
    <b-modal
    :hide-backdrop="true"
      v-model="invoice_update_setting"
      title="締日登録"
      cancel-title="キャンセル"
      ok-title="決定"
      @ok.prevent="update_invoice_json_setting()"
    >
     <h4>請求業務の締日を登録できます</h4>
     <label for="invoicejson_0" class="">締日</label>
     <div class="selectFildlistdata" style="position:relative;">
     <div class="customselectFields" v-for="(input,index) in selectfieldList" :key="input.id">
     <select class="form-control custominvoicejsnslect" v-model="input.value">
        <option v-for="n in 30" :value="n">{{n}}日</option>
        <option value="last">月末</option>
     </select>
     <b-icon @click="removeSelectField(input)" v-if="index!=0" class="customMinusIcon" icon="trash" aria-hidden="true"></b-icon>
      <b-icon @click="addSelectField" v-if="index==0" class="customPlusIcon" icon="plus-square-fill" aria-hidden="true"></b-icon>
    </div>
    </div>
    </b-modal>
  </div>
</template>
<script>
export default {
  data() {
    return {
      cmnConnectOptionList: {},
      byr_buyer_id: null,
      invoice_update_setting:false,
      selectfieldList: [{
          id: 'invoicejson_0',
          value: ''
      }],
      
      form: new Form({
        select_field_per_page_num: 10,
        page: 1,
        adm_user_id: Globals.user_info_id,
        byr_buyer_id: null,
        mes_lis_pay_pay_code: null,
        receive_date_from: null,
        receive_date_to: null,
        mes_lis_buy_name: null,
        mes_lis_pay_per_end_date_from: null,
        mes_lis_pay_per_end_date_to: null,
        check_datetime: null,
        submit_type: "page_load",
        payment_id:'',
      }),
    };
  },
  methods: {
    //get Table data
    getAllCmnConnectOptionalJsons() {
      axios.post(this.BASE_URL + "api/get_partner_fax_list",this.form)
        .then(({ data }) => {
            this.cmnConnectOptionList = data.result;
            console.log(this.cmnConnectOptionList);
        });
    },
   updateInvoiceSettingByModal(item){
     this.invoice_update_setting=true;
   },
     addSelectField() {
            this.selectfieldList.push({
                id: `invoicejson_${++this.selectfieldCounter}`,
                value: '',
            });
        },
        removeSelectField(event) {
            this.selectfieldList.splice(this.selectfieldList.indexOf(event), 1);
        },

        update_invoice_json_setting() {
            console.log(this.selectfieldList);
            var post_data = {
                selected_item: this.selectfieldList,
                user_id: Globals.user_info_id,
            };
            console.log();
            axios
                .post(this.BASE_URL + "api/update_cmn_connects_optional", post_data)
                .then((data) => {
                    console.log(data);
                    this.$root.$emit(
                        "bv::hide::modal",
                        "invoiceJsonSetting",
                        "#invoiceJsonSettingShowHide"
                    );
                    Swal.fire({
                        icon: "success",
                        title: "optional value!",
                        text: "You can successfully added optional value",
                    });
                });


        },
  },

  created() {
    this.byr_buyer_id = this.$session.get("byr_buyer_id");
    this.form.byr_buyer_id = this.byr_buyer_id;
    this.form.payment_id = this.$route.params.payment_id
    this.getAllCmnConnectOptionalJsons();
    //this.getInvoiceJson();
    Fire.$emit("byr_has_selected", this.byr_buyer_id);
    Fire.$emit("permission_check_for_buyer", this.byr_buyer_id);
    Fire.$emit("loadPageTitle", "FAX番号登録");
    
  },
  mounted() {},
};
</script>

