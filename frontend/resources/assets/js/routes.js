import Vue from 'vue';
import VueRouter from 'vue-router';
import store from './store.js';
import NProgress from 'nprogress';


import AppHeader from "./pages/partial/menubar";
import FooterApp from "./pages/partial/footer";
import SideBar from "./pages/partial/sidebar";
import Boards from "./pages/users/boards";
import EditBlog from "./pages/users/edit";
import CreateBlog from "./pages/users/create";
import middleware from './middleware.js';

import moment from 'moment';




/*
    Extends Vue to use Vue Router
*/
Vue.use( VueRouter );

/*
    Makes a new VueRouter that we will use to run all of the routes
    for the app.
*/
const router = new VueRouter({
    routes: [
        {
            path: '/',
            name: 'home',
            beforeEnter: (to, from, next) => { middleware.requireAuth(to, from, next);},
            redirect: { name: 'principal' },
        },
        {
            path: '/login',
            name: 'login',
            component: Vue.component( 'Login', require( './pages/partial/LoginForm.vue' ) ),
        },
        {
            path: '/home',
            name: 'principal',
            beforeEnter: (to, from, next) => { middleware.requireAuth(to, from, next);},
            components: {default: Boards, header: AppHeader, sidebar: SideBar, footer: FooterApp}
        },
        {
            path: '/blogs/:id',
            name: 'blogedit',
            beforeEnter: (to, from, next) => { middleware.requireAuth(to, from, next);},
            components: {default: EditBlog, header: AppHeader, sidebar: SideBar, footer: FooterApp}                    
        },
        {
            path: '/blogs/crear',
            name: 'blogcreate',
            beforeEnter: (to, from, next) => { middleware.requireAuth(to, from, next);},
            components: {default: CreateBlog, header: AppHeader, sidebar: SideBar, footer: FooterApp}
                    
        },
    ],
    scrollBehavior: to => {
        if (to.hash) {
            return { selector: to.hash };
        } else {
            return { x: 0, y: 0 };
        }
    }
});


export default router;
