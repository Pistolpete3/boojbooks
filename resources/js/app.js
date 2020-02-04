import draggable from 'vuedraggable'
import App from "./components/App";
import 'es6-promise/auto';
import { store } from './store'
import { routes } from './router'
import Vue from 'vue'
import VueRouter from "vue-router";

require('./bootstrap');
window.Vue = require('vue');

Vue.use(draggable);
Vue.component('books-table', require('./components/Books/BooksTable.vue').default);
Vue.component('book-picker', require('./components/Books/BookPicker.vue').default);
Vue.component('lists-table', require('./components/Lists/ListsTable.vue').default);
Vue.component('pagination', require('./components/Pagination.vue').default);
Vue.component('navbar', require('./components/Navbar.vue').default);
Vue.component('logout', require('./components/Auth/Logout.vue').default);
Vue.component('login', require('./components/Auth/Login.vue').default);
Vue.component('app', require('./components/App.vue').default);
Vue.component('app', require('./components/App.vue').default);
Vue.component('draggable', draggable);

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: routes
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!store.getters.loggedIn) {
            next({name: 'login'})
        } else {
            next()
        }
    } else {
        next()
    }
})

const app = new Vue({
    el: '#app',
    components: { App },
    router: router,
    store: store,
});
