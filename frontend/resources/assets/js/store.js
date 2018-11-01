require('es6-promise').polyfill();

/*
    Imports Vue and Vuex
*/
import Vue from 'vue'
import Vuex from 'vuex'

/*
    Initializes Vuex on Vue.
*/
Vue.use( Vuex );

/*
  Exports our data store.
*/

import { users } from './modules/users.js';


export default new Vuex.Store({
    modules: {
    	users
    },
});
