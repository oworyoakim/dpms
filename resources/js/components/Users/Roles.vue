<template>
    <v-layout child-flex>
        <div v-if="loading" class="text-center">
            <v-progress-circular
                :size="50"
                color="primary"
                indeterminate
            ></v-progress-circular>
        </div>
        <v-data-table
            :headers="headers"
            :items="roles"
            item-key="id"
            class="elevation-1"
            v-if="!loading"
        >
            <template v-slot:top>
                <v-toolbar flat color="white">
                    <v-toolbar-title>Users</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-dialog persistent v-model="dialog" max-width="600px">
                        <template v-slot:activator="{ on }">
                            <v-btn color="primary" dark class="mb-2" v-on="on">New User</v-btn>
                        </template>
                        <v-card>
                            <v-toolbar color="indigo" dark flat>
                                <v-toolbar-title>New User</v-toolbar-title>
                            </v-toolbar>
                            <v-card-text>
                                <v-container grid-list-md>
                                    <v-layout wrap>
                                        <v-flex xs12>
                                            <v-text-field
                                                label="Name*"
                                                v-model="form.name"
                                                @keyup="setSlug()"
                                                required
                                            ></v-text-field>
                                        </v-flex>
                                        <v-flex xs12>
                                            <v-text-field
                                                label="Slug*"
                                                v-model="form.slug"
                                                readonly
                                            ></v-text-field>
                                        </v-flex>
                                        <v-divider></v-divider>
                                        <v-flex xs12>
                                            <h4>Role Permissions</h4>
                                        </v-flex>
                                    </v-layout>
                                </v-container>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="red darken-1" text @click="close()">Cancel</v-btn>
                                <v-btn color="info" :disabled="form.name" @click="saveRole()">Save</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-toolbar>
            </template>
            <template v-slot:item.action="{ item }">
                <v-icon small class="mr-2" @click="editRole(item)">edit</v-icon>
            </template>
        </v-data-table>
    </v-layout>
</template>

<script>
    import Form from "../../utils/Form";

    export default {
        props: ['permissions'],
        created() {
            this.getRoles();
        },
        mounted(){
            console.log('Permissions',this.permissions);
        },
        data() {
            return {
                roles: [],
                headers: [
                    {text: 'Name', value: 'name', sortable: false},
                    {text: 'Slug', value: 'slug', sortable: true},
                    {text: 'Actions'},
                ],
                listForm: new Form({}),
                form: new Form({
                    name: '',
                    slug: '',
                    permissions: [],
                }),
                role: null,
                dialog: false,
                loading: true,
                errors: [],
            }
        },
        methods: {
            async getRoles() {
                try {
                    this.loading = true;
                    let response = await this.listForm.get('/list-roles');
                    this.roles = response.data;
                    this.loading = false;
                } catch (error) {
                    console.error(error.response.data);
                }
            },
            setSlug(){
                if(!!this.form.name){
                    let name = this.form.name;
                    this.form.slug = name.toLowerCase().split(' ').join('-');
                }
            },
            addRole() {
                this.dialog = true;
                this.role = null;
            },
            editRole(role) {
                this.role = role;
                this.form.name = role.name;
                this.form.slug = role.slug;
                this.dialog = true;
            },
            close() {
                this.dialog = false;
                this.role = null;
                this.form.reset();
            },
            async saveRole() {
                try {
                    let response;
                    if (this.role) {
                        response = await this.form.put('/roles/' + this.user.id);
                    } else {
                        response = await this.form.post('/roles');
                    }
                    this.form.reset();
                    this.role = null;
                    this.getRoles();
                    console.log(response.data);
                    this.dialog = false;
                } catch (error) {
                    console.log(error.response.data);
                }
            },
        }
    }
</script>

<style scoped>

</style>
