<template>
  <MappingPage :destination-list="destinationList" />
</template>
<script>
import MappingPage from '@/components/presentationals/DestinationMappingPage.vue';
export default {
  components: {
    MappingPage,
  },
  data() {
    return {
      destinationList: [],
    }
  },
  mounted() {
    [...Array(5)].map((_, i) => {
      this.destinationList.push({
        index: i + 1,
        place: `Destination_${i}`,
        time: `${(i + 1) * 10}(min)`,
        distance: `${(i + 1) * 10}(km)`,
      });
    });
  },
}
</script>
