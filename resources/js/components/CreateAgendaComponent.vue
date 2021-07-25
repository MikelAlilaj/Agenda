<template>
    <div class="col-md-6">
        <router-link :to="'./'" class="btn btn-primary home-buttons"
            >Go Back</router-link
        >
    </div>
    <br />
    <div>
        <form v-on:submit.prevent="onSubmit"
        >
            <div class="col-md-6">
                <div class="form-group">
                    <label>Name</label>
                    <input
                        v-model="form.name"
                        type="text"
                        class="form-control"
                    />
                    <span class="text-danger" v-if="v$.form.name.$error">
                        Required </span
                    ><br />
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea
                        v-model="form.description"
                        class="form-control"
                        rows="3"
                    ></textarea>
                    <span class="text-danger" v-if="v$.form.description.$error">
                        Required </span
                    ><br />
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select v-model="form.status" class="form-control">
                        <option value="">Select Status</option>
                        <option value="1">Active</option>
                        <option value="2">Inactive</option>
                    </select>
                    <span class="text-danger" v-if="v$.form.status.$error">
                        Required </span
                    ><br />
                </div>

                <div class="form-group">
                    <label>Date:</label>
                    <input
                        v-model="form.date"
                        type="date"
                        class="form-control"
                        data-date-format="yy/mm/dd"
                    />
                    <span class="text-danger" v-if="v$.form.date.$error">
                        Required</span
                    >
                    <br />
                </div>
            </div>

            <div class="col-md-12">
                <input
                    class="btn btn-primary"
                    type="submit"
                />
            </div>
        </form>
    </div>
</template>
<script>
import useValidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";

export default {
    data() {
        return {
            v$: useValidate(),
            form: {
                name: "",
                description: "",
                status: "",
                date: "",
            },
        };
    },
    validations: {
        form: {
            name: {
                required,
            },
            description: {
                required,
            },
            status: {
                required,
            },
            date: {
                required,
            },
        },
    },
    methods: {
        async onSubmit() {
            this.v$.$validate();

            if (this.v$.form.$error) return;

            try {
                const { data } = await window.axios.post(
                    `/api/agendas/add-new`,
                    this.form
                );
                this.$router.push({ path: `./` });
                return alert(data.message);
            } catch (error) {
                const { statusText } = error.response;
                return alert(statusText);
            }
        },
    },
};
</script>
