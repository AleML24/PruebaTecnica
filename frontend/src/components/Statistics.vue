<template>
    <div class="bg-transparent px-0 my-2">
        <v-card-title class="text-h5 text-sm-h4 mb-2">
            Estadísticas
        </v-card-title>
        <v-card-text class="h-100">
            <Bar v-if="loading" :data="chartData" :options="chartOptions" />
            <div class="w-100 h-100 d-flex justify-center" v-if="!loading">
                <v-progress-circular indeterminate="" color="primary"></v-progress-circular>
            </div>
        </v-card-text>
    </div>
</template>

<script>
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
} from "chart.js";
import { onMounted, ref } from "vue";
import { Bar, Doughnut } from "vue-chartjs";
import { statistics } from '@/api/statistics'; // Asegúrate de importar correctamente tu API

ChartJS.register(CategoryScale,
    LinearScale,
    BarElement,
    Title,
    Tooltip,
    Legend);

export default {
    components: {
        Bar,
    },
    setup() {
        const loading = ref(false);

        const chartOptions = ref({
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Distribución de Usuarios por Rol',
                },
            },
        });

        const chartData = ref({
            labels: [],
            datasets: [{
                label: "Cantidad de usuarios",
                data: [25, 43, 53],
                backgroundColor: [
                    '#1976D2 ',
                    '#1976D2 ',
                    '#1976D2 '
                ],
                borderWidth: 1,
            }]
        });

        const getData = async () => {
            try {
                const response = await statistics(); // Llama a la API
                if (response && response.data && response.labels) {
                    chartData.value.datasets[0].data = response.data; // Datos numéricos
                    chartData.value.labels = response.labels; // Etiquetas
                } else {
                    console.error("Formato de respuesta inesperado:", response);
                }
            } catch (error) {
                console.error("Error al obtener datos:", error);
            } finally {
                loading.value = true;
            }
        };

        onMounted(getData);

        return {
            chartData,
            chartOptions,
            loading,
        };
    }
}
</script>

<style scoped>
/* Estilos opcionales */
</style>
