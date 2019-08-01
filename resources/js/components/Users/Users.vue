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
            :items="users"
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
                                <v-container grid-list-lg>
                                    <v-layout wrap>
                                        <v-flex xl4 lg6 md6 sm6 xs12>
                                            <v-text-field
                                                label="First Name*"
                                                v-model="form.first_name"
                                                required
                                            ></v-text-field>
                                        </v-flex>
                                        <v-flex xl4 lg6 md6 sm6 xs12>
                                            <v-text-field
                                                label="Last Name*"
                                                v-model="form.last_name"
                                                required
                                            ></v-text-field>
                                        </v-flex>
                                        <v-flex xl4 lg6 md6 sm6 xs12>
                                            <v-text-field
                                                label="Email Address"
                                                v-model="form.email"
                                                type="email"
                                            ></v-text-field>
                                        </v-flex>
                                        <v-flex xl4 lg6 md6 sm6 xs12>
                                            <v-select
                                                :items="roles"
                                                label="Role*"
                                                item-text="name"
                                                item-value="id"
                                                v-model="form.role_id"
                                            ></v-select>
                                        </v-flex>
                                        <v-flex xl4 lg6 md6 sm6 xs12>
                                            <v-text-field
                                                label="Username*"
                                                v-model="form.username"
                                                required
                                            ></v-text-field>
                                        </v-flex>
                                        <v-flex xl4 lg6 md6 sm6 xs12>
                                            <v-text-field
                                                label="Password*"
                                                type="password"
                                                v-model="form.password"
                                                required
                                            ></v-text-field>
                                        </v-flex>
                                        <v-flex xl4 lg6 md6 sm6 xs12>
                                            <v-text-field
                                                label="Confirm Password*"
                                                type="password"
                                                v-model="form.cpassword"
                                                required
                                            ></v-text-field>
                                        </v-flex>
                                    </v-layout>
                                </v-container>
                            </v-card-text>

                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="red darken-1" text @click="close()">Cancel</v-btn>
                                <v-btn color="info" :disabled="userFormInvalid" @click="saveUser()">Save</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-toolbar>
            </template>

            <template v-slot:item.action="{ item }">
                <v-icon small class="mr-2" @click="editUser(item)">edit</v-icon>
            </template>
        </v-data-table>
        <app-toast v-if="msg" :msg="msg"></app-toast>
    </v-layout>
</template>

<script>
    import Form from "../../utils/Form";

    export default {
        props: ['roles'],
        created() {
            this.getUsers();
        },
        mounted() {
            console.log('Roles', this.roles);
        },
        data() {
            return {
                users: [],
                headers: [
                    {text: 'First Name', value: 'firstName', sortable: false},
                    {text: 'Last Name', value: 'lastName', sortable: true},
                    {text: 'Email', value: 'email', sortable: false},
                    {text: 'Username', value: 'username', sortable: true},
                    {text: 'Role', value: 'role.name', sortable: true},
                    {text: 'Actions'},
                ],
                listForm: new Form({}),
                form: new Form({
                    first_name: '',
                    last_name: '',
                    role_id: '',
                    email: '',
                    username: '',
                    password: '',
                    cpassword: '',
                }),
                user: null,
                dialog: false,
                loading: true,
                msg: null,
                errors: [],
            }
        },
        computed:{
            userFormInvalid() {
                this.errors = [];
                if (!this.form.first_name) {
                    this.errors.push("First name is required.");
                }
                if (!this.form.last_name) {
                    this.errors.push("Last name is required.");
                }
                if (!this.form.username) {
                    this.errors.push("Username name is required.");
                }
                if (!this.form.password) {
                    this.errors.push("Password is required.");
                }
                if (this.form.password !== this.form.cpassword) {
                    this.errors.push("Passwords do not match.");
                }
                if (this.form.email && !this.validEmail(this.form.email)) {
                    this.errors.push('Provide a valid email address.');
                }
                return this.errors.length > 0;
            },
        },
        methods: {
            async getUsers() {
                try {
                    this.loading = true;
                    let response = await this.listForm.get('/list-users');
                    this.users = response.data;
                    this.loading = false;
                } catch (error) {
                    console.error(error.response.data);
                }
            },
            addUser() {
                this.dialog = true;
                this.user = null;
            },
            editUser(user) {
                this.user = user;
                this.form.first_name = user.firstName;
                this.form.last_name = user.lastName;
                this.form.email = user.email;
                this.dialog = true;
            },
            close() {
                this.dialog = false;
                this.user = null;
                this.form.reset();
            },
            validEmail: function (email) {
                var reg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return reg.test(email);
            },
            async saveUser() {
                try {
                    let response;
                    if (this.user) {
                        response = await this.form.put('/users/' + this.user.id);
                    } else {
                        response = await this.form.post('/users');
                    }
                    this.form.reset();
                    this.user = null;
                    this.getUsers();
                    this.dialog = false;
                    //console.log(response.data);
                    this.msg = {
                        context: 'success',
                        text: response.data
                    };
                } catch (error) {
                    console.log(error.response.data);
                }
            },
        }
    }
</script>

<style scoped>

</style>
