<template>
  <InputFormPage
    :count="count"
    @add-destination="addDestination"
    @delete-destination="deleteDestination"
  />
</template>
<script>
import { mapState } from 'vuex';
import { mapMutations } from 'vuex';

import InputFormPage from '@/components/presentationals/inputFormPage.vue'

export default {
  components: {
    InputFormPage,
  },
  computed: {
    ...mapState([
      'count'
    ]),
  },
  methods: {
    ...mapMutations([
      'increment',
      'decrement'
    ]),
    addDestination() {
      this.increment();
    },
    deleteDestination() {
      this.decrement();
    }
  }
} 
</script>
