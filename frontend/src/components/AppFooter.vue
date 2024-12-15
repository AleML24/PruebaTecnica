<template>
  <v-footer height="40" app color="grey-lighten-3">
    <v-hover>
      <template v-slot:default="{ isHovering, props }">
        <a :href="`https://wa.me/5355406465`" target="_blank" style="text-decoration: none; color: inherit;">
          <v-btn  v-bind="props" variant="flat" :color="isHovering  ? 'green' : 'transparent'" size="small" prepend-icon="mdi-whatsapp">Contactar</v-btn>
        </a>
      </template>
    </v-hover>
    <div class="text-caption text-disabled" style="position: absolute; right: 16px;">
      &copy; {{ (new Date()).getFullYear() }} <span class="d-none d-sm-inline-block">Alejandro Milián Lugo</span>
    </div>
  </v-footer>
</template>

<script setup>

</script>

<style scoped lang="sass">
  .social-link :deep(.v-icon)
    color: rgba(var(--v-theme-on-background), var(--v-disabled-opacity))
    text-decoration: none
    transition: .2s ease-in-out

    &:hover
      color: rgba(25, 118, 210, 1)
</style>
