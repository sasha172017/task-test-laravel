/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import VueSession from 'vue-session'

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('tab-currencies', require('./components/CurrenciesComponent.vue').default);
Vue.component('tab-authentication', require('./components/AuthenticationComponent.vue').default);
Vue.component('tab-create', require('./components/CreateComponent.vue').default);
Vue.component('tab-history', require('./components/HistoryComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.use(VueSession)


const app = new Vue({
    el: '#app',
    created: function(){
        if(this.$session.get('token')){
            this.isAuth();
        }else {
            this.tabs.authentication = "Authentication";
        }
    },
    methods: {
        isAuth: function(){
            this.authentication = true;
            this.tabs.authentication = null;
            this.tabs.create = "Create";
        },
        logout: function () {
            this.$session.remove('token');
            this.authentication = false;
            this.tabs.authentication = "Authentication";
            this.tabs.create = null;

        }
    },
    data: {
        authentication: false,
        currentTab: "Currencies",
        tabs: {currencies:"Currencies", history:'History', authentication: null},
    },
    computed: {
        currentTabComponent: function() {
            return "tab-" + this.currentTab.toLowerCase();
        }
    }
});
