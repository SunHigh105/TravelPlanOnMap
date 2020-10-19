import Vue from 'vue';
import VueRouter from 'vue-router';
import InputForm from './components/pages/inputFormPage.vue';
import DestinationMapping from './components/pages/destinationMappingPage.vue';
import ModelPlanList from './components/pages/ModelPlanListPage.vue';

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
