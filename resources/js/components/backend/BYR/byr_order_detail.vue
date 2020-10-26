<template>
  <div>
    <component v-bind:is="component" />
  </div>
</template>
<script>
// './bms_byr_order_detail.vue'

import default_byr_order_detail from './default_byr_order_detail.vue'
import bms_byr_order_detail from '../BMS/bms_byr_order_detail'
export default {
  components: {
    default_byr_order_detail,
     bms_byr_order_detail
  },
  data() {
    return {
      component:"default_byr_order_detail",
    };
  },
  methods: {

  },

  created() {
    this.byr_order_id = this.$route.params.byr_order_id;
    this.order_receive_date = this.$route.params.order_receive_date;
    // console.log(this.order_receive_date);
     axios.post(this.BASE_URL + "api/get_byr_info_by_byr_order_id",{byr_order_id:this.byr_order_id,order_receive_date:this.order_receive_date})
        .then(data => {
          // console.log(data);
          // if(data.data.byr_info.super_code=='OUK'){
          if(this.byr_order_id=='1'){
            this.component = default_byr_order_detail;
          }else{
            this.component = bms_byr_order_detail;
          }
        })
  },
  mounted() {
    console.log("byr order detail page parent loaded");
  }
};
</script>