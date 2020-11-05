<template>
  <label>{{ label }}
    <input type="number" :min="min" :max="max" :step="step">
  </label>
</template>
<script>
export default {
  props: {
    label: { type: String, default: '' },
    min: { type: Number, default: 0 },
    max: { type: Number, default: 10000 },
    step: { type: Number, default: 1 },
  },
}
</script>