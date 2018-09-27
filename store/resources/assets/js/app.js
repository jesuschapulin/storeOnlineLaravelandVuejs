require('./bootstrap');
window.Vue = require('vue');

import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

let productosComponent= require('./components/productos.vue');
let dashboardComponent=require('./components/dashboard/dashboard.vue');
let loginComponent= require('./components/login.vue');
let registerComponent=require('./components/register.vue');
let barra= require('./components/barra.vue');
let Profile= require('./components/perfil.vue');
let pedidos=require('./components/pedidos.vue');

const routes = [
	  { path: '/', component:productosComponent},
  	{ path: '/Login', component: loginComponent },
  	{ path: '/Register', component: registerComponent},
  	{ path: '/Dashboard', component:dashboardComponent},
  	{ path: '/Profile', component:Profile},
    { path: '/Pedidos',component:pedidos}
]

const router = new VueRouter({
  	mode:'history',
  	routes
})
const app = new Vue({
    el: '#app',
    router,
    components:{barra}
});
