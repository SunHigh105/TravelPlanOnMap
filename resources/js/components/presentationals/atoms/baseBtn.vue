<template>
  <button type="button" @click="handleClick">{{ label }}</button>
</template>
<script>
export default {
  props: {
    label: { type: String, default: 'Submit' },
    clickEvent: { type: String, default: '' },
  },
  methods: {
    handleClick() {
      this.$emit(this.clickEvent);
    }
  },
}
</script>
