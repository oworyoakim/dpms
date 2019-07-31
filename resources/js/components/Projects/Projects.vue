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
            :items="projects"
            item-key="id"
            class="elevation-1"
            v-if="!loading"
        >
            <template v-slot:top>
                <v-toolbar flat color="white">
                    <v-toolbar-title>Projects</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-dialog persistent v-model="dialog" max-width="600px">
                        <template v-slot:activator="{ on }">
                            <v-btn color="primary" dark class="mb-2" v-on="on">New Project</v-btn>
                        </template>
                        <v-card>
                            <v-toolbar color="indigo" dark flat>
                                <v-toolbar-title>New Project</v-toolbar-title>
                            </v-toolbar>
                            <v-card-text>
                                <v-container grid-list-md>
                                    <v-layout wrap>
                                        <v-flex xs12>
                                            <v-text-field
                                                label="Title*"
                                                v-model="projectForm.title"
                                                required
                                            ></v-text-field>
                                        </v-flex>
                                        <v-flex xs12>
                                            <v-textarea label="Description"
                                                        v-model="projectForm.description"
                                            ></v-textarea>
                                        </v-flex>
                                    </v-layout>
                                </v-container>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="red darken-1" text @click="close()">Cancel</v-btn>
                                <v-btn color="info" :disabled="projectForm.title === ''" @click="saveProject()">Save</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-toolbar>
            </template>
            <template v-slot:item.action="{ item }">
                <v-icon small class="mr-2" @click="editProject(item)">edit</v-icon>
            </template>
        </v-data-table>
        <app-toast v-if="msg" :msg="msg"></app-toast>
    </v-layout>
</template>

<script>
    import Form from "../../utils/Form";

    export default {
        created() {
            this.getUsers();
        },
        data() {
            return {
                projects: [],
                headers: [
                    {text: 'Id', align: 'center', sortable: true, value: 'id'},
                    {text: 'Title', value: 'title'},
                    {text: 'User', value: 'user.username', sortable: true},
                    {text: 'Status', value: 'status', sortable: true},
                    {text: 'Actions'},
                ],
                listForm: new Form({
                    status: '',
                    user_id: '',
                }),
                projectForm: new Form({
                    title: '',
                    description: '',
                }),
                project: null,
                dialog: false,
                loading: true,
                msg: null,
            }
        },
        methods: {
            async getUsers() {
                try {
                    this.loading = true;
                    let response = await this.listForm.get('/list-projects');
                    this.projects = response.data;
                    this.loading = false;
                } catch (error) {
                    console.error(error.response.data);
                }
            },
            addProject() {
                this.dialog = true;
                this.project = null;
            },
            editProject(project) {
                this.project = project;
                this.projectForm.title = project.title;
                this.projectForm.description = project.description;
                this.dialog = true;
            },
            close() {
                this.dialog = false;
                this.project = null;
                this.projectForm.reset();
            },
            async saveProject() {
                try {
                    let response;
                    if(this.project){
                        response = await this.projectForm.put('/projects/'+this.project.id);
                    }else{
                        response = await this.projectForm.post('/projects');
                    }
                    this.projectForm.reset();
                    this.project = null;
                    this.getUsers();
                    //console.log(response.data);
                    this.msg = {
                        context: 'success',
                        text: response.data
                    };
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
