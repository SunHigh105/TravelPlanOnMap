import Vue from 'vue';
import VueRouter from 'vue-router';
import InputForm from '@/components/containers/searchForm.vue';
import DestinationMapping from '@/components/containers/DestinationList.vue';
import ModelPlanList from '@/components/presentationals/ModelPlanListPage.vue';

Vue.use(VueRouter)

const router = new VueRouter({
  mode: 'history',
  routes: [
    { path: '/', component: InputForm },
    { path: '/destinations', component: DestinationMapping },
    { path: '/model_plans', component: ModelPlanList },
  ]
});

export default router;
