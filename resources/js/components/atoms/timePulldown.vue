<template>
  <div>
    <label>出発時刻</label>
    <select>
      <option v-for="h in 23" :key="h.index" :value="h">{{ h }}</option>
    </select>
    <select>
      <option v-for="t in 5" :key="t.index" :value="t * 10">{{ t * 10 }}</option>
    </select>
  </div>
</template>
<script>

</script>
