import Vue from 'vue';
import VueRouter from 'vue-router';
import store from './store.js';

Vue.use( VueRouter );

function proceed (to, from, next) {
        if( store.getters.getIsLoggedIn() == true ){
            next();
        }else{
            next('/login');
        }
}

export default {
	requireAuth (to, from, next) {
        store.dispatch( 'loadToken');
        proceed(to, from, next);
	},
}
