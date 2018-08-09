<template>
	    <div class="container mt-5" id="page_login">
	    	<div class="row">
		    	<div class="card shadow-lg mt-5 rounded col-lg-6 offset-lg-3">
	    			<div class="container mb-5 rounded shadow-lg panel">
	    				<div class="row d-flex justify-content-center rounded shadow-lg"
	    					 style="background-color: #9c27b0; margin-top:-2rem; height: 4rem;">
	    					<h4 class="text-white">Entrar</h4>
	    				</div>
	    			</div>
			        <form method="POST" v-on:submit.prevent="check_usuario()">
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text fa fa-user"></span>
						  </div>
						  <input type="email" class="form-control" placeholder="email" aria-label="email" aria-describedby="basic-addon1" name="email" v-model="usuario.email">
						</div>
						<span v-if="errorEmail" class="text-danger">{{errorEmail}}</span>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text fa fa-key"></span>
						  </div>
						  <input type="password" class="form-control" placeholder="password" aria-label="email" aria-describedby="basic-addon1" name="password" v-model="usuario.password">
						</div>
						<span v-if="errorPassword" class="text-danger">{{errorPassword}}</span>	
							<div class="row">
								<div class="col-12 d-flex justify-content-center">
									<input type="submit" class="btn btn-primary btn-lg" name="btn_login" id="btn_login" value="Continuar">
								</div>
								<router-link to="/Register" class="text-info ml-auto" align-selft="right">no tienes cuenta, registrate aqui</router-link>
							</div>
					</form>
				</div>
			</div>
	     </div>
</template>

<script>
	import axios from 'axios'
	import VueRouter from 'vue-router'
	import jquery from 'jquery'
	import Vue from 'vue'
	import VueSession from 'vue-session'
	Vue.use(VueSession)

	import toastr from 'toastr'

    export default {
    	data(){
    		return{
    			usuario:{'email':'','nickname':'','password': ''},
    			errors:[],
    			errorEmail:'',
    			errorPassword:'',
    			res:[],
    		}
    	},
    	
        created(){
            console.log("checando usuario");
        },
        methods:{
        	check_usuario: function(){
        		let vueInstance=this;
        		if(!vueInstance.usuario.email){vueInstance.errorEmail='ingresa una direccion de email'}else{vueInstance.errorEmail=''}
        		if(!vueInstance.usuario.password){vueInstance.errorPassword='ingresa una contraseña'}else{vueInstance.errorPassword=''}
        		if(vueInstance.usuario.email && vueInstance.usuario.password){
	        		var url_login='check_usuario';
					axios.post(url_login,{
						email:vueInstance.usuario.email,
						password:vueInstance.usuario.password
					}).then(function(response){
						
						
						if(response.status===200){
							if(response.data.messageError){
								toastr.error(response.data.messageError);
							}else{
								vueInstance.usuario.nickname=response.data.nickname;
								vueInstance.$session.start();
								vueInstance.$session.set('nickname',response.data.nickname);
								vueInstance.$session.set('id_usuario',response.data.id_usuario);
								vueInstance.$session.set('tipo_usuario',response.data.id_tipo_usuario);
								if(vueInstance.$session.get('tipo_usuario')=='1'){
									$("#btn_singin").hide();
									$("#usuario_state").show();
									$("#usuario_state").text( vueInstance.usuario.nickname);
									toastr.success('Bienvenido a storeonline '+vueInstance.usuario.nickname);
									vueInstance.$router.go('/');
								}else if(vueInstance.$session.get('tipo_usuario')=='2'){
									$("#btn_singin").hide();
									$("#usuario_state").show();
									$("#usuario_state").text(vueInstance.usuario.nickname);
									toastr.success('Bienvenido a storeonline '+vueInstance.usuario.nickname);
									vueInstance.$router.go('/Dashboard');
								}
							}
						}
					}).catch(error=>{
						
					});
				}
        	}
        	
        }
    }
</script>
<style>

</style>
