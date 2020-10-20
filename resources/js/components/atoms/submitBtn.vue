<template>
  <button type="button">{{ label }}</button>
</template>
<script>
export default {
  props: {
    label: { type: String, default: 'Submit' },
  },
}
</script>
