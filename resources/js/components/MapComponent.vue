<template>
<GmapMap
    :center="center"
    :zoom="zoom"
    map-type-id="roadmap"
    style="width: 1000px; height: 400px"
>
    <!--<GmapMarker
        :key="index"
        v-for="(m, index) in markers"
        :position="m.position"
        :clickable="true"
        :draggable="true"
        @click="center=m.position"
    />-->
</GmapMap>

</template>
<script>
export default {
    data(){
        return{
            center: {
                lat:35.6585805, 
                lng:139.7454329
            },
            zoom: 12,
        }
    },
    mounted(){
        this.getCenter();
    },
    methods:{
        getCenter(){
            
        }
    }
    // computed:{
    //     google: gmapApi
    // }
}
</script>