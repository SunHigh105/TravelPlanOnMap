<template>
  <div>
    <div>InputFormPage</div>
    <router-link to="destinations">DestinationMapping</router-link>
    <router-link to="model_plans">ModelPlanList</router-link>
    <SearchForm />
  </div>
</template>
<script>
import SearchForm from '../molecules/searchForm.vue';

export default {
  components: {
    SearchForm
  },
} 
</script>
