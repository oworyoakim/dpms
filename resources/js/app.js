/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Navbar from "./components/Navbar";
import Toast from "./components/Toast";
import Login from "./components/Auth/Login";
import Home from "./components/Home";
import Projects from "./components/Projects/Projects";
import Users from "./components/Users/Users";
import Roles from "./components/Users/Roles";
import Settings from "./components/Settings/Settings";

require('./bootstrap');

window.Vue = require('vue');

import Vuetify from "vuetify";

Vue.use(Vuetify,{
    icons: {
        iconfont: 'md'
    }
});
Vue.$axios = require('axios');
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('app-login', Login);
Vue.component('app-navbar', Navbar);
Vue.component('app-toast', Toast);
Vue.component('app-home', Home);
Vue.component('app-projects', Projects);
Vue.component('app-users', Users);
Vue.component('app-roles', Roles);
Vue.component('app-settings', Settings);
//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const vuetifyOptions = {
    theme:{
        accent: true,
    }
};

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(vuetifyOptions)
});
