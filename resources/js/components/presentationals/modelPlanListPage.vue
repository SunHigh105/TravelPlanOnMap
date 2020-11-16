<template>
  <ul class="c-model-plans">
    <li v-for="plan in modelPlans" :key="plan.index" >
      <div>{{ plan.title }}</div>
      <div>{{ plan.author}} {{ plan.created }}</div>
    </li>
  </ul>
</template>
<script>
export default {
  props: {
    modelPlans: { type: Array, default: () => [] },
  },
}
</script>