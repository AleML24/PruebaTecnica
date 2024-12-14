<template>
  <v-container max-width="1000px">
    <v-row justify="space-between">
      <v-col cols="12" md="7">
        <v-text-field variant="solo-filled" name="name" v-model="userFilter" label="Buscar usuario" id="id"
          append-inner-icon="mdi-magnify" hide-details @keypress="searchUser"
          @click:append-inner="getData"></v-text-field>
      </v-col>
      <v-col cols="12" md="3">
        <v-select variant="solo-filled" :items="filters" v-model="rolFilter" label="Rol" prepend-inner-icon="mdi-filter"
          clearable></v-select>
      </v-col>
    </v-row>
    <v-data-table-server :headers="headers" :items="items" :items-length="totalItems" :items-per-page="itemsPerPage"
      :options.sync="pagination" :loading="loading" @update:options="getData" />
  </v-container>
</template>

<script>
import { index } from '@/api/users';
import { onMounted, ref, watch } from 'vue';
export default {

  setup() {
    const headers = [
      { title: "Nombre", value: "name" },
      { title: "Correo", value: "email" },
      { title: "Rol", value: "role" },
    ]
    const items = ref([])
    const totalItems = ref(0)
    const loading = ref(false)
    const pagination = ref({ page: 1, itemsPerPage: 10 })
    const filters = [
      { title: "Manager", value: "manager" },
      { title: "Revisor", value: "revisor" },
      { title: "Comprador", value: "comprador" },
    ]
    const rolFilter = ref(null)
    const userFilter = ref(null)
    const itemsPerPage = ref(10)

    const getData = async ({ page, itemsPerPage }) => {
      pagination.value.page = page ?? pagination.value.page
      pagination.value.itemsPerPage = itemsPerPage ?? pagination.value.itemsPerPage
      loading.value = true

      const { data, meta } = await index(pagination.value.page, pagination.value.itemsPerPage, rolFilter.value, userFilter.value)
      items.value = data
      totalItems.value = meta.total
      loading.value = false
    }



    const searchUser = async (event) => {
      if (event.key === 'Enter') {
        let page = pagination.value.page
        let itemsPerPage = pagination.value.itemsPerPage
        await getData({ page, itemsPerPage });
      }
    }

    watch(rolFilter, async () => {
      let page = pagination.value.page
      let itemsPerPage = pagination.value.itemsPerPage
      await getData({ page, itemsPerPage });
    })

    return {
      headers,
      items,
      totalItems,
      loading,
      pagination,
      filters,
      rolFilter,
      getData,
      searchUser,
      userFilter,
      itemsPerPage
    }
  }
}
</script>
