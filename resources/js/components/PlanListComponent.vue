<template>
    <div>
        <div class="tabs-panel grid-x grid-padding-x" id="plan-list">
            <div v-if="plans.length === 0">まだモデルプランが登録されていません。</div>
            <div v-for="plan in plans" v-bind:key="plan.id">
                <div class="card cell medium-8">
                    <div class="card-section grid-x">
                        <div class="cell medium-8 plan-title" v-on:click="getPlanDetail(plan.id)">{{ plan.plan_title }}</div>
                        <div class="cell medium-4">{{ plan.created_at }}</div>
                    </div>
                </div>
            </div>
        </div>
        <map-component ref="map"></map-component>
    </div>
</template>

<script>
import Bus from '../bus';
export default { 
    data(){
        return{
            plans: [],
        }
    },
    methods: {
        showPlan(){
            axios.post('api/showPlan').then((response) => {
                this.plans = response.data;
            }).catch((error) => {
                alert('プランの取得に失敗しました。');
            });
        },
        getPlanDetail(id){
            //idからplace取得
            axios.post('api/getPlaces', {plan_id: id})
            .then((response) => {
                let places = response.data;
                // タイトルと出発時刻設定
                let planInfo = {};
                this.plans.forEach(plan => {
                    if(plan.id === id){
                        planInfo.hour = plan.start_time_h;
                        planInfo.minute = plan.start_time_m;
                        planInfo.title = plan.plan_title;
                    }
                });
                //placeList表示
                this.$refs.map.createPlaceLists(planInfo, places, 1);
                // Loading→地図表示
                this.$emit('dispMap');

            }).catch((error) => {
                console.log(error);
                alert('お探しのプランが見つかりませんでした。');
            });
        },
    }
    
}
</script>