<template>
  <label>{{ label }}
    <input type="text">
  </label>
</template>
<script>
export default {
  props: {
    label: { type: String, default: '' },
  },
}
</script>
