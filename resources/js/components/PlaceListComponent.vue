<template>
    <div id="list">
        <div class="card">
        <div class="card-section">
            <div class="distance"></div>
            <div class="duration"></div>
        </div>
        </div>
        <div class="card">
        <div class="card-divider">
            <span class="button secondary deleteButton">Delete</span>
        </div>
        <div class="card-section">
            <p>住所：</p>
            <p>滞在時間：分</p>
        </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>