<template>
<div>
     <div class="row">
        <div class="col-12">
            <button class="btn btn-primary">Byr1</button>
        </div>
    </div>
</div>

</template>

<script>
    export default {

        data(){
            return {
               'byr_slr_list':'',
            }
        },
        methods:{
            
        },
          created() {
      
      console.log('created jacos management log');
  },
        mounted() {
            this.init();
            console.log('Home Component mounted.')
        }
    }
</script>