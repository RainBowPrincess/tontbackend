require('./bootstrap');

import Vue from 'vue';
import Vuetify from 'Vuetify';
import VueRouter from 'vue-router';
import {routes} from './router.js';
import Main from './components/MainComp.vue';
import axios from 'axios';
//import 'vuetify/dist/vuetify.min.css'


Vue.use(Vuetify)
//Vue.use(Vuex)
Vue.use(VueRouter)

axios.defaults.baseURL = 'http://lapi.se/api';
Vue.$http = axios;



const router = new VueRouter({
  mode: 'history',
  routes
});




const app = new Vue({
  el: '#app',
  router,

  components:{
  	'main-app': Main

  }
 
})