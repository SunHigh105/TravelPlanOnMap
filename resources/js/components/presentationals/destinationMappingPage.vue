<template>
  <div class="c-mapping">
    <div class="c-mapping__mapview">
    <GmapMap ref="myMap"
      :center="center"
      :zoom="zoom"
      map-type-id="roadmap"
    >
    </GmapMap>
    </div>
    <div class="c-mapping__list">
      <ul>
        <li v-for="destination in destinationList" :key="destination.index">
          <div>{{ destination.place }}</div>
          <div>{{ destination.time }} {{ destination.distance }}</div>
        </li>
      </ul>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    destinationList: { type: Array, default: () => [] },
  },
  data() {
    return {
      center: {
        lat:35.6585805, 
        lng:139.7454329
      },
      zoom: 12,
    }
  },
}
</script>
