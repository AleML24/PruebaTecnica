<template>
  <v-app class="app">
    <AppBar />
    <v-main class="main">
      <router-view />
      <AppFooter />
    </v-main>
  </v-app>
</template>

<script setup>

import AppBar from '@/components/AppBar.vue';

</script>

<style>
.app {
  height: 100dvh;
  overflow-y: hidden;
  scrollbar-width: none;
}

.main {
  height: 100%;
  overflow-y: auto;
  scrollbar-width: thin;
  background-color: #fafafae5 !important;
}
</style>