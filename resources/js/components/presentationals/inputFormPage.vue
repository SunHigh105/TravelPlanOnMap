<template>
  <div>
    <div>InputFormPage</div>
    <router-link to="destinations">DestinationMapping</router-link>
    <router-link to="model_plans">ModelPlanList</router-link>
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
import BaseBtn from '@/components/presentationals/atoms/baseBtn.vue';
import BaseTxtInput from '@/components/presentationals/atoms/baseTxtInput.vue';
import BaseNumInput from '@/components/presentationals/atoms/baseNumInput.vue';
import TimePulldown from '@/components/presentationals/timePulldown.vue';

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
