<template>
  <v-container max-width="1000px">
    <users-list></users-list>
    <v-divider></v-divider>
    <statistics></statistics>
  </v-container>
</template>

<script>
import UsersList from '@/components/UsersList.vue';
import Statistics from '../components/Statistics.vue';
export default {
  components: { UsersList, Statistics }
}
</script>
