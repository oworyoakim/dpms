<template>
    <v-app id="inspire">
        <v-content>
            <v-container fluid fill-height>
                <v-layout align-center justify-center>
                    <v-flex xs12 sm8 md4>
                        <v-card class="elevation-12">
                            <v-toolbar color="indigo" dark flat>
                                <v-toolbar-title>Account Login</v-toolbar-title>
                            </v-toolbar>
                            <v-card-text>
                                <v-alert dense outlined text v-if="loginError" type="error">{{loginError}}</v-alert>
                                <v-form>
                                    <v-text-field
                                        label="Username"
                                        v-model="form.username"
                                        type="text"
                                        prepend-icon="account_circle"
                                    ></v-text-field>
                                    <v-text-field
                                        :type="showPassword ? 'text' : 'password'"
                                        label="Password"
                                        v-model="form.password"
                                        prepend-icon="lock"
                                        :append-icon="showPassword ? 'visibility' : 'visibility_off'"
                                        @click:append="showPassword = !showPassword"
                                        @keyup.enter="login()"
                                    ></v-text-field>
                                </v-form>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="primary" @click="login()" :disabled="!(form.username && form.password)">
                                    Login
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
    import Form from "../../utils/Form";

    export default {
        name: "Login",
        data() {
            return {
                showPassword: false,
                form: new Form({
                    username: '',
                    password: ''
                }),
                loginError: '',
            };
        },
        methods: {
            async login() {
                try {
                    if (!this.form.username) {
                        return;
                    }
                    let response = await this.form.post('/login');
                    console.log(response.data);
                    location.reload();
                } catch (error) {
                    console.log(error.response);
                    this.loginError = error.response.data;
                }
            }
        }
    }
</script>

<style scoped>

</style>
