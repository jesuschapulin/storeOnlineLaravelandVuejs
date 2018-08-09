<template>
	<div class="container-fluid" style="padding-top: 4rem;">
		<div class="row pt-0 pb-0">
			<div class="container-fluid bg-purple pt-3 pb-0" style="min-height: 18rem; max-height: 18rem;">
				<div class="row">
					<div class="col-6">
					<h2 class="text-white" id="name-profile">
						
					</h2>
						
					</div>
					<div class="col-6 d-flex justify-content-center">
						<a href="#" class="element-profile btn btn-simple btn-md fa fa-id-card rounded-circle shadow-lg border-gray pt-3"
									v-tooltip.bottom="'ver informacion general'">
							
						</a>
						<a href="#" class="element-profile btn btn-simple btn-md fa fa-hand-holding-usd rounded-circle shadow-lg border-gray pt-3"
									v-tooltip.bottom="'ver informacion de pago'">
							
						</a>
						<a href="#" class="element-profile btn btn-simple btn-md fa fa-list rounded-circle shadow-lg border-gray pt-3"
									v-tooltip.bottom="'ver listas y pedidos'"
									v-on:click.prevent="showLists()">
							
						</a>
					</div>
				</div>
				<div class="row rounded pt-5" v-bind:style="{'margin-top':'0','margin-left':'10rem','margin-right':'7rem'}" id="page_infoGeneral">
					<div v-if="usuario.imagen" class="col-sm-12 col-lg-5 rounded" v-bind:style="{'backgroundImage':'url(/images/users/'+usuario.imagen+')','background-position':'center','background-size':'cover','width':'100%','height':'30rem'}">
					</div>
					<div v-else="usuario.imagen" class="col-sm-12 col-lg-5 rounded" v-bind:style="{'backgroundImage':'url(/images/users/userDefaultImage.png)','background-position':'center','background-size':'cover','width':'100%','height':'30rem'}">
					</div>
					<div class="container col-sm-12 col-lg-7 pt-4" style="background-color: white;">
						
						<form method="POST" v-on:submit.prevent="edit_user()" style="height: 92%;">
							<div class="container d-flex justify-content-end">
								<a href="#" class="btn btn-simple bg-purple btn-md text-white fa 						fa-edit rounded-circle shadow-md pt-2" 
											v-if="stateEdit" 
											v-on:click.prevent="enableEditUser()"
											v-tooltip.top="'Editar información'">
									
								</a>
							</div>
								<div class="input-group mb-3" id="message" 
									v-tooltip.notringger.top.start="{
											content:'Hola y Bienvenido '+usuario.nombre,
											class:'tooltipPurple',
									}">
								  <div class="input-group-prepend">
								    <span  v-if="displayEditProfile" class="input-group-text fa fa-sort-alpha-down"></span>
								  </div>
								  <input type="text" class="form-control" placeholder="nombre" aria-label="email" aria-describedby="basic-addon1" name="" v-model="usuario.nombre" v-bind:disabled="editProfileState">
								</div>
								<span v-if="errorNombre" class="text-danger">{{errorNombre}}</span>

								<div class="input-group mb-3">
								  <div class="input-group-prepend">
								    <span v-if="displayEditProfile" class="input-group-text fa fa-sort-alpha-down"></span>
								  </div>
								  <input type="text" class="form-control" placeholder="Apellido paterno" aria-label="email" aria-describedby="basic-addon1" name="email" v-model="usuario.ap_paterno" v-bind:disabled="editProfileState">
								</div>
								<span v-if="errorApPaterno" class="text-danger">{{errorApPaterno}}</span>

								<div class="input-group mb-3">
								  <div class="input-group-prepend">
								    <span v-if="displayEditProfile" class="input-group-text fa fa-sort-alpha-down"></span>
								  </div>
								  <input type="text" class="form-control" placeholder="Apellido materno" aria-label="email" aria-describedby="basic-addon1" name="" v-model="usuario.ap_materno" v-bind:disabled="editProfileState">
								</div>
								<span v-if="errorApMaterno" class="text-danger">{{errorApMaterno}}</span>
								<div class="input-group mb-3">
								  <div class="input-group-prepend">
								    <span v-if="displayEditProfile" class="input-group-text fa fa-envelope"></span>
								  </div>
								  <input type="email" class="form-control" placeholder="Email" aria-label="" aria-describedby="basic-addon1" name="" v-model="usuario.email" v-bind:disabled="editProfileState">
								</div>
								<span v-if="errorEmail" class="text-danger">{{errorEmail}}</span>
								<div class="input-group mb-3">
								  <div class="input-group-prepend">
								    <span v-if="displayEditProfile" class="input-group-text fa fa-phone"></span>
								  </div>
								  <input type="text" class="form-control" placeholder="Telefono" aria-label="" aria-describedby="basic-addon1" name="" v-model="usuario.telefono" v-bind:disabled="editProfileState">
								</div>
								<span v-if="errorTelefono" class="text-danger">{{errorTelefono}}</span>
								<div class="input-group mb-3">
								  <div class="input-group-prepend">
								    <span v-if="displayEditProfile" class="input-group-text fa fa-sort-alpha-down"></span>
								  </div>
								  <input type="text" class="form-control" placeholder="Nickname" aria-label="" aria-describedby="basic-addon1" name="" v-model="usuario.nickname" v-bind:disabled="editProfileState">
								</div>
								<span v-if="errorNickname" class="text-danger">{{errorNickname}}</span>
								<div class="input-group mb-3">
								  <div class="input-group-prepend">
								    <span v-if="displayEditProfile" class="input-group-text fa fa-key"></span>
								  </div>
								  <input type="password" class="form-control" placeholder="Contraseña" aria-label="" aria-describedby="basic-addon1" name="" v-model="usuario.password" v-bind:disabled="editProfileState">
								</div>
								<span v-if="errorPassword" class="text-danger">{{errorPassword}}</span>
								<div class="input-group mb-3" v-if="displayEditProfile">
								  <div class="input-group-prepend">
								    <span class="input-group-text fa fa-file-image"></span>
								  </div>
								  <input type="file" class="form-control"  name="imageUsuario" id="imageUsuario">
								  
								</div>
								<span v-if="errorImagenUsuario" class="text-danger">{{errorImagenUsuario}}</span>
								<div v-if="displayEditProfile" class="container-fluid d-flex justify-content-center">
									<input type="submit" class="btn btn-primary" name="btn_login" id="btn_login" value="Continuar">
									<br>
									<router-link to="/" class="btn btn-simple" id="hovblue">Cancelar</router-link>
								</div>
								
							</form>
						<div class="row bg-purple">
							<a href="#" class="btn btn-lg rounded-circle fa fa-facebook-f text-white">
							</a>
							<a href="#" class="btn btn-lg rounded-circle fa fa-twitter text-white">
							</a>
						</div>
					</div>
				</div>
				<div class="row rounded pt-5" v-bind:style="{'margin-top':'0','margin-left':'10rem','margin-right':'7rem'}" id="page_lists">
					<span>ver listas</span>
				</div>
			</div>
			<div class="container-fluid" style="min-height: 18rem; max-height: 18rem;"></div>
		</div>
	</div>
</template>

<script>
	import axios from 'axios'
	import jquery from 'jquery'
	import toastr from 'toastr'
	import Vue from 'vue';
	import Tooltip from 'vue-directive-tooltip';
	Vue.use(Tooltip);
	export default{
		data(){
			return{
				displayEditProfile:'',
				stateEdit:'true',
				usuario:{'id_usuario':'',
						'nombre':'',
						'originalName':'',
						'ap_paterno':'',
						'ap_materno':'',
						'email':'',
						'telefono':'',
						'nickname':'',
						'password':'',
						'tipo_usuario':'',
						'imagen':'',
						'facebook':'',
						'twitter':''
				},
				editProfileState:true,
				isEnabled:true,
				errorNombre:'',
				errorApMaterno:'',
				errorApPaterno:'',
				errorEmail:'',
				errorNickname:'',
				errorPassword:'',
				errorTelefono:'',
				errorImagenUsuario:'',

			}
		},
		mounted:function(){
			let vueInstance=this;
			vueInstance.isEnabled=!vueInstance.isEnabled;
			vueInstance.showInfoGeneral();
			var user=vueInstance.$session.get('id_usuario');
			var url="getUser";
			axios.post(url,{user:user}).then(function(response){
				if(response.status===200){
					vueInstance.usuario.id_usuario=response.data.id_usuario;
					vueInstance.usuario.originalName=response.data.nombre;
					vueInstance.usuario.nombre=response.data.nombre;
					vueInstance.usuario.ap_paterno=response.data.ap_paterno;
					vueInstance.usuario.ap_materno=response.data.ap_materno;
					vueInstance.usuario.email=response.data.email;
					vueInstance.usuario.telefono=response.data.telefono;
					vueInstance.usuario.nickname=response.data.nickname;
					vueInstance.usuario.password=response.data.nombre;
					vueInstance.usuario.tipo_usuario=response.data.id_tipo_usuario;
					vueInstance.usuario.imagen=response.data.imagen;
					vueInstance.usuario.facebook=response.data.facebook;
					vueInstance.usuario.twitter=response.data.twitter;
					$("#name-profile").text(response.data.nombre+" "+response.data.ap_paterno+" "+response.data.ap_materno);
				}
			}).catch(error=>{

			});
		},
		methods:{
			edit_user:function(){
				let vueInstance=this;
				const formData = new FormData();
				formData.append('originalName', vueInstance.usuario.originalName);
				formData.append('id_usuario', vueInstance.usuario.id_usuario);
				formData.append('nombre', vueInstance.usuario.nombre);
	            formData.append('ap_paterno', vueInstance.usuario.ap_paterno);
	            formData.append('ap_materno', vueInstance.usuario.ap_materno);
	            formData.append('email', vueInstance.usuario.email);
	            formData.append('telefono', vueInstance.usuario.telefono);
	            formData.append('nickname', vueInstance.usuario.nickname);
	            formData.append('password', vueInstance.usuario.password);
	            if(!vueInstance.usuario.nombre){vueInstance.errorNombre="ingresa un nombre"}else{vueInstance.errorNombre=""}
	            if(!vueInstance.usuario.ap_paterno){vueInstance.errorApPaterno="ingresa un apellido paterno"}else{vueInstance.errorApPaterno=""}
	            if(!vueInstance.usuario.ap_materno){vueInstance.errorApMaterno="ingresa un apellido materno"}else{vueInstance.errorApMaterno=""}
	            if(!vueInstance.usuario.email){vueInstance.errorEmail="ingresa un email"}else{vueInstance.errorEmail=""}
	            if(!vueInstance.usuario.telefono){vueInstance.errorTelefono="ingresa un telefono"}else{vueInstance.errorTelefono=""}
	            if(!vueInstance.usuario.nickname){vueInstance.errorNickname="ingresa un sobrenombre o apodo"}else{vueInstance.errorNickname=""}
	            if(!vueInstance.usuario.password){vueInstance.errorPassword="ingresa una contraseña"}else{vueInstance.errorPassword=""}
	            var url="updateUser";
	        	if(!vueInstance.errorNombre && !vueInstance.errorApPaterno && !vueInstance.errorApMaterno && !vueInstance.errorEmail && !vueInstance.errorTelefono && !vueInstance.errorNickname && !vueInstance.errorPassword){
					if($("#imageUsuario").val()==""){
						formData.append('message','sameImage');
						axios.post(url,formData).then(function(response){
							if(response.status===200){
								if(response.data.messageSuccess){
	            					toastr.success(response.data.messageSuccess);
	            				}
	            				else if(response.data.messageError){
	            					toastr.success(response.data.messageError);
	            				}
							}
						}).catch(error=>{

						});
					}else{
						formData.append('imageUsuario', document.getElementById('imageUsuario').files[0]);
						formData.append('message','');
						axios.post(url,formData).then(function(response){
							if(response.status===200){
								if(response.data.messageSuccess){
	            					toastr.success(response.data.messageSuccess);
	            				}
	            				else if(response.data.messageError){
	            					toastr.success(response.data.messageError);
	            				}
							}
						}).catch(error=>{

						});
					}
				}
	            
	            
			},
			enableEditUser:function(){
				let vueInstance=this;
				vueInstance.displayEditProfile='true';
				vueInstance.editProfileState=false;
				vueInstance.stateEdit='';
			},
			showLists:function(){
				let vueInstance=this;
				$("#page_infoGeneral").hide();
				$("#page_lists").show();
				$(".tooltipPurple").css({'background-color': 'rgba(0,0,0,0)','display': 'none !important','z-index': '0'});
			},
			showInfoGeneral:function(){
				let vueInstance=this;
				$("#page_infoGeneral").show();
				$("#page_lists").hide();
				$(".tooltipPurple").css({'background-color': '#563d7c','display': 'block !important','z-index': '10000'});
			}
		}
	}
</script>
<style>
	.bg-purple{
	background-color: #563d7c;
}
.btn-rounded{
border-style: solid;
border-width: 4px;
border-color: rgba(0,0,0,0);
border-radius: 25px;
}
.tooltipPurple{
	background-color: #563d7c;
	display: block !important;
    z-index: 10000;
}
.border-gray{
	border-style: solid;
	border-width: 1px;
	border-color: rgba(0,0,0,0.1);
}
.element-profile{
	background-color: rgba(0,0,0,0);
	color: white;
}
.element-profile:hover{
	color: #563d7c;
	background-color: white;
}
</style>