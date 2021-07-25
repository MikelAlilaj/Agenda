<template>
 <router-link
        :to="'./create'"
        class="btn btn-primary home-buttons"
      >Add new</router-link>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Date</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(agenda,index) in agendas">
                <th scope="row">{{++index}}</th>
                <td>{{agenda.name}}</td>
                <td>{{agenda.description}}</td>
                <td>{{agenda.date}}</td>
                <td><span v-if="agenda.status == 1">Active</span> <span v-else>Inactive</span> </td>
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
        this.loadAgenda();
    },
    methods: {
         async loadAgenda() {
            const { data } = await  axios.get('/api/agendas');
            this.agendas = data.agendas;
            debugger;
        },
    },
};
</script>
