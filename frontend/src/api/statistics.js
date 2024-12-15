import apiClient from "@/plugins/axios";

export const statistics = async () => {
    try {
        console.log('requesting');

        const response = await apiClient.get('/statistics');
        const data = response.data.data.roles_users.map(item => item.users);

        const labels = response.data.data.roles_users.map(item => {
            return item.role.split(" ")
                .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                .join(" ");
        });

        const total = response.data.data.total;

        return { data, labels, total };

    } catch (error) {
        console.log(error);
    }
}
