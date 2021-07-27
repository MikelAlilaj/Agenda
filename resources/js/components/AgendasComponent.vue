<template>
    <div class="col-md-12">
        <div style="float: left; width: 200px">
            <router-link :to="'./create'" class="btn btn-primary home-buttons"
                >Add new</router-link
            >
        </div>
        <div style="float: left; width: 200px">
            <a @click="exportDataFile()" class="btn btn-success ml-2">Export</a>
        </div>
        <div
            class="large-12 medium-12 small-12 cell"
            style="float: left; width: 100px"
        >
            <h6>Import json file</h6>
            <input
                type="file"
                accept="application/JSON"
                @change="onFile"
                class="inputFile"
                ref="file"
            />
        </div>
    </div>
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
import FileSaver from "file-saver";
export default {
    data() {
        return {
            agendas: [],
            agendasExport: [],
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

        onFile(e) {
            let files = e.target.files;
            if (!files.length) return;
            var fileName = files[0].name;
            var jsonName = fileName.substring(fileName.length - 4);

            jsonName === "json"
                ? this.readFile(files[0])
                : alert("This form Support Only Json File");
        },

        readFile(file) {
            let reader = new FileReader();
            reader.onload = (e) => {
                try {
                    let dataFile = JSON.parse(e.target.result);
                    this.sendDataFile(dataFile);
                } catch (error) {
                    this.$refs.file.value = null;
                    return alert(
                        "Required Json Format Please check your file and try again"
                    );
                }
            };
            reader.readAsText(file);
        },

        async sendDataFile(dataFile) {
            try {
                const { data } = await window.axios.post(
                    `/api/import`,
                    dataFile
                );
                this.loadAgendas();
                this.$refs.file.value = null;
                return alert(data.message);
            } catch (error) {
                const { statusText } = error.response;
                this.$refs.file.value = null;
                return alert(statusText);
            }
        },

        async exportDataFile() {
            try {
                const { data } = await axios.get(`/api/export`);
                this.agendasArray = data.agendasArray;
                var agendaFile = new Blob([JSON.stringify(this.agendasArray)], {
                    type: "text/plain;charset=utf-8",
                });
                FileSaver.saveAs(agendaFile, "agendas.json");
            } catch (error) {
                const { statusText } = error.response;
                return alert(statusText);
            }
        },
    },
};
</script>
