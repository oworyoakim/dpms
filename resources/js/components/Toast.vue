<template>
    <v-snackbar
        v-model="snackbar"
        :color="msg.context"
        top
        multi-line
        right
    >
        {{ msg.text }}
        <v-btn dark text @click="snackbar = false">Close</v-btn>
    </v-snackbar>
</template>

<script>

    export default {
        props: ['msg'],
        data() {
            return {
                snackbar: true,
                timeout: 5000,
            };
        }
    }
</script>

<style scoped>

</style>
