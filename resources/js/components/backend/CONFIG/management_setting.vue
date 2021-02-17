<template>
  <div class="row">
    <div class="col-12" style="background: #d8e3f0; padding: 10px">
    </div>
    

    <div class="col-12">
      <div class="row">
      <div class="col-3">
      <h4 class="page_custom_title">締日登録</h4>
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
      </div>
      <div class="col-9">
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
            </tr>
          </thead>
          <tbody>
           <tr v-for="(item,index) in cmnConnectOptionList" :key="index">
            <td>{{item.partner_code}}</td>
            <td>{{JSON.parse(item.optional).order.fax.number}}</td>
            <td><b-button-group size="sm">
      <b-button
        v-for="(btn, idx) in buttons"
        :key="idx"
        :pressed.sync="btn.state"
        :variant="btn.className"
        @click="updateStatus(btn,idx)"
      >
        {{ btn.caption }}
      </b-button>
    </b-button-group></td>
            <td>{{JSON.parse(item.optional).payment.fax.number}}</td>
            <td><b-button-group size="sm">
      <b-button
        v-for="(btn, idx) in buttons"
        :key="idx"
        :pressed.sync="btn.state"
        :variant="btn.className"
        @click="updateStatus(btn,idx)"
      >
        {{ btn.caption }}
      </b-button>
    </b-button-group></td>
           </tr>
          </tbody>
        </table>
        
      </div>
        
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      cmnConnectOptionList: {},
      byr_buyer_id: null,
     buttons: [
          { caption: 'On', state: true,className:'primary' },
          { caption: 'Off', state: false,className:'secondary' }
        ],
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
    updateStatus(btn,idx){
      if(idx==0){
      btn.status = true;
      btn.className = 'primary';
      this.buttons[1].status='false';
      this.buttons[1].className='secondary';
      }else{
        btn.status = true;
        btn.className = 'primary';
        this.buttons[0].status='false';
      this.buttons[0].className='secondary';
      }
    },
    
  },

  created() {
    this.byr_buyer_id = this.$session.get("byr_buyer_id");
    this.form.byr_buyer_id = this.byr_buyer_id;
    this.form.payment_id = this.$route.params.payment_id
    this.getAllCmnConnectOptionalJsons();
    this.getInvoiceJson();
    Fire.$emit("byr_has_selected", this.byr_buyer_id);
    Fire.$emit("permission_check_for_buyer", this.byr_buyer_id);
    Fire.$emit("loadPageTitle", "FAX番号登録");
    
  },
  mounted() {},
};
</script>
<style scoped>
.toggle__button {
    vertical-align: middle;
    user-select: none;
    cursor: pointer;
}
.toggle__button input[type="checkbox"] {
    opacity: 0;
    position: absolute;
    width: 1px;
    height: 1px;
}
.toggle__button .toggle__switch {
    display:inline-block;
    height:12px;
    border-radius:6px;
    width:40px;
    background: #BFCBD9;
    box-shadow: inset 0 0 1px #BFCBD9;
    position:relative;
    margin-left: 10px;
    transition: all .25s;
}

.toggle__button .toggle__switch::after, 
.toggle__button .toggle__switch::before {
    content: "";
    position: absolute;
    display: block;
    height: 18px;
    width: 18px;
    border-radius: 50%;
    left: 0;
    top: -3px;
    transform: translateX(0);
    transition: all .25s cubic-bezier(.5, -.6, .5, 1.6);
}

.toggle__button .toggle__switch::after {
    background: #4D4D4D;
    box-shadow: 0 0 1px #666;
}
.toggle__button .toggle__switch::before {
    background: #4D4D4D;
    box-shadow: 0 0 0 3px rgba(0,0,0,0.1);
    opacity:0;
}
</style>
