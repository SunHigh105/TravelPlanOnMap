import Vue from 'vue';

const Bus = new Vue({
    methods: {
        test(){
            console.log('this is a test.');
        }
    }
});

export default Bus;