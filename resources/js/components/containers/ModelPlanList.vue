<template>
  <ModelPlanListPage :model-plans="modelPlans" />
</template>
<script>
import ModelPlanListPage from '@/components/presentationals/ModelPlanListPage.vue';
export default {
  components: {
    ModelPlanListPage,
  },
  data() {
    return {
      modelPlans: [],
    }
  },
  mounted() {
    [...Array(5)].map((_, i) => {
      this.modelPlans.push({
        index: i + 1,
        title: `Model Plan ${i + 1}`,
        author: 'hogehoge',
        created: '2020/11/17',
      });
    });
  }
}
</script>