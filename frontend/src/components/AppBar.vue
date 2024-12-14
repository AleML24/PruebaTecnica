<template>
    <v-app-bar>
        <v-app-bar-title>
            <div class="d-flex align-center">
                <v-icon>mdi-view-dashboard</v-icon>
                Dashboard
            </div>
        </v-app-bar-title>

        <div class="d-sm-none">
            <v-menu>
                <template v-slot:activator="{ props }">
                    <v-btn icon="mdi-menu" v-bind="props">
                    </v-btn>
                </template>
                <v-list>
                    <v-list-item @click="$router.push('/')" class="fuente text-center">
                        <div class="d-flex align-center justify-between">
                            <v-icon size="x-small" class="mr-2">mdi-table-of-contents</v-icon> Usuarios
                        </div>
                    </v-list-item>
                    <v-divider></v-divider>
                    <v-list-item @click="$router.push('/estadisticas')" class="text-center w-100">
                        <div class="d-flex align-center justify-between">
                            <v-icon size="x-small" class="mr-2">mdi-chart-bar</v-icon> Estadísticas
                        </div>
                    </v-list-item>
                </v-list>
            </v-menu>
        </div>

    </v-app-bar>
</template>