<template>
  <div class="c-input-form">
    <div v-for="n in count" :key="n.index">
      <BaseTxtInput :label="'Destination'" />
      <BaseNumInput 
        :label="'Spent Time(min)'"
        :min="0"
        :max="3600"
        :step="10"
      />
      <span v-if="n != 1 && n === count">
        <BaseBtn 
          :label="'Delete'"
          @delete-destination="deleteDestination"
          :click-event="'delete-destination'"
        />
      </span>
    </div>
    <BaseBtn
      :label="'+ Add Destination'"
      @add-destination="addDestination"
      :click-event="'add-destination'"
    />
    <TimePulldown />
    <BaseBtn :label="'Search'"/>
  </div>
</template>
<script>
import BaseBtn from '@/components/presentationals/bases/BaseBtn.vue';
import BaseTxtInput from '@/components/presentationals/bases/BaseTxtInput.vue';
import BaseNumInput from '@/components/presentationals/bases/BaseNumInput.vue';
import TimePulldown from '@/components/presentationals/TimePulldown.vue';

export default {
  components: {
    BaseBtn,
    BaseTxtInput,
    BaseNumInput,
    TimePulldown,
  },
  props: {
    count: { type: Number, required: true },
  },
  methods: {
    addDestination() {
      this.$emit('add-destination');
    },
    deleteDestination() {
      this.$emit('delete-destination');
    },
  }
} 
</script>
