<template>
<div>
     <div class="row">
        <div class="col-12" v-role="['Slr','Byr']">
            <div v-for="order_item in slr_order_list" :key="order_item.byr_buyer_id">
                 <b-button variant="outline-primary">{{order_item.buyer_name}} &nbsp &nbsp {{order_item.total_order}}件</b-button>
            </div>
        </div>
    </div>
</div>

</template>

<script>
    export default {

        data(){
            return {
               'byr_slr_list':'',
               slr_order_list:null,
            }
        },
        methods:{
            loadData(){
                axios.post(this.myLang.base_url+'api/get_byr_slr_data',{user_id:this.myLang.user_info_id})
                .then(({data})=>{
                    // console.log("Hi");
                    console.log(data);
                    this.slr_order_list=data.slr_order_info;
                })
            }
            
        },
          created() {
      
      console.log('created jacos management log');
  },
        mounted() {
            this.init();
            console.log('Home Component mounted.')
            this.loadData();
        }
    }
</script>