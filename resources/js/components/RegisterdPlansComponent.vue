<template>
    <div>
        <div v-if="plans.length === 0">登録されているプランはありません。</div>
        <div v-else>
            <div class="mypage-header">
                <p class="sub-title">登録済みプラン</p>
                <p class="plan-count">{{ plans.length }}件</p>
            </div>
            <table class="unstriped">
                <thead>
                    <tr>
                        <th>プラン名</th>
                        <th>投稿日</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="plan in plans" v-bind:key="plan.id">
                        <td class="plan-title">{{ plan.plan_title }}</td>
                        <td>{{ plan.created_at }}</td>
                        <td><button type="button" class="button">編集</button></td>
                        <td><button type="button" class="alert button">削除</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
export default{
    props:{
        login_id: String
    },
    data(){
        return{
            plans: [],
            id: this.login_id,
        }
    },
    mounted(){
        this.showRegisterdPlans(this.id);
    },
    methods: {
        showRegisterdPlans(id){
            axios.post('api/showRegisterdPlans', {'user_id' : id})
            .then((response) => {
                this.plans = response.data;
            }).catch((error) => {
                console.log(error);
                alert('プランの取得に失敗しました。');
            });

        },
        editPlan(){

        },
        deletePlan(){

        }
    }
}
</script>