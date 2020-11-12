<template>
  <div>
    <header class="l-header">
      Travel Plan Map
    </header>
    <nav class="l-navigation">
      <ul>
        <li v-for="link in navLinks" :key="link.path">
          <router-link
            :to="link.path"
          >{{ link.txt }}
          </router-link>
        </li>
      </ul>
    </nav>
    <div class="l-container">
      <h1 class="l-container__title">{{ pageTitle }}</h1>
      <router-view />
    </div>
    <footer class="l-footer">
      footer
    </footer>
  </div>
</template>
<script>
export default {
  props: {
    pageTitle: { type: String, required: true },
    navLinks: { type: Array, required: true },
  },
}
</script>