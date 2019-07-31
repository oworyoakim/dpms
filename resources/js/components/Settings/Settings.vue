<template>
    <v-layout child-flex>
        <div v-if="loading" class="text-center">
            <v-progress-circular
                :size="50"
                color="primary"
                indeterminate
            ></v-progress-circular>
        </div>
        <v-card v-if="!loading">
            <v-card-title color="indigo" dark flat>
                <h3>Settings</h3>
            </v-card-title>
            <v-card-text>
                <v-flex xs12>
                    <v-text-field
                        label="Company Name"
                        v-model="form.company_name"
                    ></v-text-field>
                    <v-text-field
                        label="Company Email"
                        v-model="form.company_email"
                    ></v-text-field>
                </v-flex>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="info" v-if="Object.keys(form.originalData).length > 0" @click="saveSettings()">Save
                </v-btn>
            </v-card-actions>
            <app-toast v-if="msg" :msg="msg"></app-toast>
        </v-card>
    </v-layout>
</template>

<script>
    import Form from "../../utils/Form";

    export default {
        props: ['settings'],
        created() {
            //console.log(this.settings);
            this.form = new Form(this.settings);
            this.getSettings();
        },
        data() {
            return {
                loading: true,
                form: null,
                errors: [],
                msg: null,
            };
        },
        methods: {
            async getSettings() {
                try {
                    this.loading = false;
                } catch (error) {
                    console.error(error);
                }
            },
            async saveSettings() {
                try {
                    //this.loading = true;
                    let response = await this.form.post('/settings');
                    this.msg = {context: 'success', text: response.data};
                    //location.reload();
                } catch (error) {
                    //this.loading = false;
                    console.error(error.response.data);
                }
            },
        },
    }
</script>

<style scoped>

</style>
