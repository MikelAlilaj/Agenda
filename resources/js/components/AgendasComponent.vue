<template>
    <router-link :to="'./create'" class="btn btn-primary home-buttons"
        >Add new</router-link
    >
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Date</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(agenda, index) in agendas">
                <th scope="row">{{ ++index }}</th>
                <td>{{ agenda.name }}</td>
                <td>{{ agenda.description }}</td>
                <td>{{ agenda.date }}</td>
                <td>
                    <span v-if="agenda.status == 1">Active</span>
                    <span v-else>Inactive</span>
                </td>
                <td>
                    <router-link
                        :to="'/update/' + agenda.id"
                        class="btn btn-primary"
                        >Update</router-link
                    >
                    <a
                        @click="deleteAgenda(agenda.id)"
                        class="btn btn-danger ml-2"
                        >Delete</a
                    >
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    data() {
        return {
            agendas: [],
        };
    },
    mounted() {
        this.loadAgendas();
    },
    methods: {
        async loadAgendas() {
            try {
                const { data } = await axios.get(`/api/agendas`);
                this.agendas = data.agendas;
            } catch (error) {
                const { statusText } = error.response;
                return alert(statusText);
            }
        },

        async deleteAgenda(id) {
            if (confirm("If you click ok this will be delete"))
                try {
                    const { data } = await axios.delete(`api/delete/` + id);
                    this.loadAgendas();
                    return alert(data.message);
                } catch (error) {
                    const { statusText } = error.response;
                    return alert(statusText);
                }
        },
    },
};
</script>
