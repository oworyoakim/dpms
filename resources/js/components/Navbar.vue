<template>
    <div>
        <v-navigation-drawer v-model="drawer" app dark color="indigo">
            <v-list dark color="indigo">
                <v-list-item>
                    <v-list-item-avatar>
                        <img src="https://randomuser.me/api/portraits/men/81.jpg">
                    </v-list-item-avatar>
                    <v-list-item-content>
                        <v-list-item-title v-if="user">{{user.username}}</v-list-item-title>
                        <v-list-item-subtitle v-if="role">{{role.name}}</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item @click="goToPage()">
                    <v-list-item-action>
                        <v-icon>home</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Dashboard</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item @click="goToPage('projects')">
                    <v-list-item-action>
                        <v-icon>settings</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Projects</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item @click="goToPage('users')">
                    <v-list-item-action>
                        <v-icon>person</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Users</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item @click="goToPage('settings')">
                    <v-list-item-action>
                        <v-icon>settings</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Settings</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
            <template v-slot:append>
                <v-divider></v-divider>
                <v-list>
                    <v-list-item @click="logout()">
                        <v-list-item-action>
                            <v-icon>logout</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>Logout</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </template>
        </v-navigation-drawer>
        <v-app-bar app color="indigo" dark>
            <v-icon @click.stop="drawer = !drawer">menu</v-icon>
        </v-app-bar>
    </div>
</template>

<script>
    import Form from "../utils/Form";

    export default {
        created(){
            this.getUserData();
        },
        data() {
            return {
                drawer: true,
                form: new Form({}),
                user: null,
                role: null,
            };
        },
        methods: {
            async getUserData(){
                try {
                    let response = await this.form.get('/user-info');
                    this.user = response.data.user;
                    this.role = response.data.role;
                }catch (error) {
                    console.error(error.response.data);
                }
            },
            goToPage(link = '') {
                window.location.href = baseUrl + '/' + link;
            },
            async logout() {
                try {
                    await this.form.post('/logout');
                    location.reload();
                } catch (error) {
                    console.log(error.response.data);
                    this.moveTo('login');
                }
            },
        }
    }
</script>

<style scoped>

</style>
