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
        { path: '/', txt: 'Destination Setting' },
        { path: '/model_plans', txt: 'Model Plans' },
      ],
    }
  },
  watch: {
    $route() {
      this.navLinks
        .filter(link => link.path === this.$route.path)
        .map(link => {
          this.pageTitle = link.txt;
        });
    },
  }
}
</script>
