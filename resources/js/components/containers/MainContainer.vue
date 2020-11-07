<template>
  <MainComponent
    :page-title="pageTitle"
    :nav-links="navLinks"
  />
</template>
<script>
import MainComponent from '@/components/presentationals/MainComponent.vue';

export default {
  components: {
    MainComponent,
  },
  data(){
    return {
      pageTitle: 'Destination Setting',
      navLinks: [
        { path: 'destinations', txt: 'Destination Mapping' },
        { path: 'model_plans', txt: 'Model Plans' },
      ],
    }
  },
  watch: {
    $routes(to, from) {
      
    },
  }
}
</script>
