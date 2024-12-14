import apiClient from "@/plugins/axios";

export const index = async (page = 1, perPage = 10, rolFilter = null, userFilter = null) => {
    let data = null
    let meta = null

    try {
        const response = await apiClient.get('/user', { params: { page, perPage, role: rolFilter, name: userFilter } })

        data = response.data.data
        meta = response.data.meta

        return { data, meta }

    } catch (error) {
        console.log(error);
    }
}