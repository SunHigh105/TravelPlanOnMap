<template>
  <div>
    <span>{{ count }}</span>
    <div v-for="n in count" :key="n.index">
      <SearchInput />
      <span v-if="n != 1 && n === count">
        <button @click="deleteDestination()">Delete</button>
      </span>
    </div>
    <button type="button" @click="addDestination()">+ Add Destination</button>
    <TimePulldown />
    <SubmitBtn :label="'Search'"/>
  </div>
</template>
<script>
import { mapState } from 'vuex';
import { mapMutations } from 'vuex';

import SearchInput from '../atoms/searchInput.vue';
import SubmitBtn from '../atoms/submitBtn.vue';
import TimePulldown from '../atoms/timePulldown.vue';

export default {
  components: {
    SearchInput,
    SubmitBtn,
    TimePulldown,
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
