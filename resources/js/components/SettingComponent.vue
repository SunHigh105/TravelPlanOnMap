<template>
    <div>
        <div class="mypage-header">
            <p class="sub-title">アカウント設定</p>
        </div>
        <div class="mypage-content">
            <p>退会する</p>
            <p>退会すると、登録していたプランも全て削除されます。</p>
            <button type="button" class="alert button">退会する</button>
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
            id: this.login_id,
        }
    },
    methods: {
        
    }
}
</script>