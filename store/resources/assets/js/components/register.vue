<template>
	<div class="container mt-5" id="page_gegister">
	    	<div class="row">
		    	<div class="card shadow-lg mt-5 rounded col-lg-6 offset-lg-3">
	    			<div class="container mb-2 rounded">
	    				<div class="row d-flex justify-content-center rounded shadow-lg"
	    					 style="background-color: #9c27b0; margin-top:-2rem; height: 4rem;">
	    					<h4 class="text-white">Registro nuevo</h4>
	    				</div>
	    			</div>
			        <form method="POST" v-on:submit.prevent="register_user()">
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text fa fa-user"></span>
						  </div>
						  <input type="text" class="form-control" placeholder="nickname" aria-label="email" aria-describedby="basic-addon1" name="nickname" v-model="usuario.nickname">
						</div>
						<span v-if="errorNickname" class="text-danger">{{errorNickname}}</span>

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
						<div class="container-fluid d-flex justify-content-center">
							<input type="submit" class="btn btn-primary" name="btn_login" id="btn_login" value="Continuar">
							<br>
							<router-link to="/" class="btn btn-simple" id="hovblue">Cancelar</router-link>
						</div>
						
					</form>
				</div>
			</div>
	     </div>
</template>
<script>
	import axios from 'axios'
	import jquery from 'jquery'
	import toastr from 'toastr'
	import Vue from 'vue'
	import VueSession from 'vue-session'
	Vue.use(VueSession)

	export default{
		data(){
			return{
				usuario:{'nickname':'','password':'','email':''},
				errorNickname:'',
				errorEmail:'',
				errorPassword:'',
				errors:[],
			}
		},
		created: function(){
			console.log("registro montado");
		},
		methods:{
			register_user:function(){
				let vueInstance=this;
				if(!vueInstance.usuario.nickname){vueInstance.errorNickname='ingresa un nombre de usuario'}else{vueInstance.errorNickname=''};
				if(!vueInstance.usuario.email){vueInstance.errorEmail='ingresa un email valido'}
					else{vueInstance.errorEmail=''};
				if(!vueInstance.usuario.password){vueInstance.errorPassword='ingresa una contraseña'}
					else{vueInstance.errorPassword=''};
				if(vueInstance.usuario.nickname && vueInstance.usuario.email && vueInstance.usuario.password){
					var url="register_user";
					axios.post(url,{
						nickname: vueInstance.usuario.nickname,
						email: vueInstance.usuario.email,
						password: vueInstance.usuario.password
					}).then(function(response){
						if(response.status===200){
							if(response.data.message){
								toastr.error(response.data.message);
							}else{
								vueInstance.$session.start();
								vueInstance.$session.set('nickname',response.data.nickname);
								vueInstance.$session.set('id_usuario',response.data.id_usuario);
								vueInstance.$session.set('tipo_usuario',response.data.id_tipo_usuario);
								$("#btn_singin").hide();
								$("#usuario_state").show();
								$("#usuario_state").text(vueInstance.usuario.nickname);
								toastr.success('Bienvenido a storeonline '+vueInstance.usuario.nickname);
								vueInstance.$router.push('/')
							}
						}
					}).catch(error=>{
						console.log(error.response.data)
					})


				}		
					
				
			}
		}
	}
</script>
<style>
	#hovblue{
		background-color: white;
		color: #007afe;
	}
	#hovblue:hover{
		background-color: #007afe;
		color: #FFFFFF;
	}
</style>