<template>
    <div>
        <!--loading-->
        <div class="loading-bg" v-bind:style="loaderStyle">
            <div>Searching...</div>
        </div>
        <div class="grid-container">
            <ul class="tabs" data-tabs id="example-tabs">
                <li class="tabs-title is-active"><a href="#input-form" aria-selected="true">目的地の設定</a></li>
                <li class="tabs-title" v-on:click="changePlanList();"><a href="#plan-list">モデルプラン</a></li>
            </ul>
            <div class="tabs-content" data-tabs-content="example-tabs">
                <form-component 
                    ref="form"
                    @dispMap="dispMap"
                    @hiddenMap="hiddenMap"
                    :login_id="this.id">
                </form-component>
                <planlist-component 
                    ref="plan"
                    @dispMap="dispMap"
                    @hiddenMap="hiddenMap"
                ></planlist-component>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        login_id: String
    },
    data(){
        return{
            id: this.login_id,
            loaderStyle: {
                "display": "none" 
            },
        }
    },
    methods: {
        dispForm(){
            this.popupStyle["display"] = "block";
            this.outputs = [];
            this.markers = [];
        },
        dispLoader(){
            //Loadingを3秒表示
            this.loaderStyle["display"] = "block";
            // setTimeout(this.hiddenForm, 3000);
            setTimeout(this.hiddenLoader, 3000);
        },
        hiddenLoader(){
            this.loaderStyle["display"] = "none";
        },
        //プラン一覧に切り替え
        changePlanList(){
            // plan-componentのshowPlan()を実行
            this.$refs.plan.showPlan();
        },
        //地図表示
        dispMap(){
            this.dispLoader();
        },
        //地図非表示
        hiddenMap(){
            this.dispForm();
        }
    }
}
</script>