<template>
    <v-app>
        <v-card width="600" class="mx-auto mt-10 panel-bg-teal">
            <v-card-title color="purple">
                <h1>Login</h1>
            </v-card-title>
            <v-spacer></v-spacer>
            <v-card-text>
                <v-form>
                    <v-text-field
                        label="Username"
                        v-model="form.username"
                    />
                    <v-text-field
                        :type="showPassword ? 'text' : 'password'"
                        label="Password"
                        v-model="form.password"
                    />
                </v-form>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
                <v-btn color="info" @click="login()" :disabled="!(form.username && form.password)">Login</v-btn>
            </v-card-actions>
        </v-card>
    </v-app>
</template>

<script>
    import Form from "../utils/Form";

    export default {
        name: "Login",
        data(){
            return {
                showPassword: false,
                form: new Form({
                    username: '',
                    password: ''
                }),
            };
        },
        methods:{
            async login(){
                try{
                   let response = await this.form.post('/login');
                   console.log(response.data);
                }catch (error) {
                    console.log(error.response);
                }
            }
        }
    }
</script>

<style scoped>

</style>
