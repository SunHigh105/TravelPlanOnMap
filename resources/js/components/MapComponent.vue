<template>
</template>
<script>
export default {
    data(){
        return {
            params: this.$parent.items
        }
    },
    created: function(){
        console.log(this.params);
    },
    // mounted(){
    //     this.getParams();
    // },
    computed:{
        getParams: function(){
            console.log(this.params);
        }
    },
    watch:{
        params: function(){
            console.log(this.params);
        }
        
    }
    // data(){
    //     return{
    //         center: {
    //             lat:35.6585805, 
    //             lng:139.7454329
    //         },
    //         zoom: 12,
    //     }
    // },
    // mounted(){
    //     this.getCenter();
    // },
    // methods:{
    //     getCenter(){

    //     }
    // }
    // computed:{
    //     google: gmapApi
    // }
}
</script>