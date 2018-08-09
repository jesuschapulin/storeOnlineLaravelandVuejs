<template>
        <nav class="shadow-lg navbar navbar-expand-lg navbar-light bg-light" id="barrita">
		  <a class="navbar-brand" href="#">Store</a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>

		  <div class="collapse navbar-collapse" id="navbarSupportedContent">
		  	<ul class="navbar-nav ml-auto">
		    	<li class="nav-item active">
			        <router-link class="nav-link" to="/"><span class="fa fa-home"></span> inicio</router-link>
			    </li>
			    <!--<li class="nav-item">
			        <router-link class="nav-link" to="/productos"><span class="fa fa-home"></span> productos</router-link>
			    </li>-->
		    </ul>
		    <ul class="navbar-nav">
		     
		      <li class="nav-item dropdown">
		        <a class="nav-link dropdown-toggle fa fa-male" href="#" id="usuario_state" name="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> {{user_nickname}}
		        </a>
                <router-link to="/Login" class="btn btn-primary text-black" id="btn_singin" style="display: none;">Entrar</router-link>
		        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
		        	<router-link v-bind:style="{'display':stateSession}" class="dropdown-item" to="/Profile">
		        		<span class="fa fa-id-badge"> Perfil</span>
		        	</router-link>
		        	<router-link v-bind:style="{'display':stateSession}" class="dropdown-item" to="listas">
		        		<span class="fa fa-edit"> listas</span>
		        	</router-link>
		        	<router-link v-bind:style="{'display':stateSession}" class="dropdown-item" to="pedidos">
		        		<span class="fa fa-shipping-fast"> Mis pedidos</span>
		        	</router-link>
		        	<router-link v-bind:style="{'display':stateSession}" class="dropdown-item" to="favoritos">
		        		<span class="fa fa-star"> Mis favoritos</span>
		        	</router-link>
				  
		          <!-- <div class="dropdown-divider"></div> -->
		          
		          <a class="dropdown-item fa fa-sign-out-alt" href="#" v-on:click="closeSession()"> Cerrar sesion</a>
		        </div>
		      </li>
		    </ul>
		    
		  </div>
		</nav>
</template>
<script>
	import jquery from 'jquery'
	
	export default{
		props:[
			//'usuario_state'
		],
		data(){
			return{
				user_nickname:'',
				listas:[],
				stateSession:'block',
			}
		},
		mounted: function(){
			
			this.check_state();

		},
		methods:{
			check_state: function(){
				let vueInstance=this;
				$(document).ready(function(event){
					if (!vueInstance.$session.exists()){
				      	console.log("session no existe");
				      	$("#usuario_state").hide();
				      	$("#btn_singin").show();
				    }else{
				    	if(vueInstance.$session.get('tipo_usuario')=='1'){
					    	$("#usuario_state").show();
					      	$("#btn_singin").hide();
					    	vueInstance.user_nickname=vueInstance.$session.get('nickname');
					    	vueInstance.stateSession='block';
					    	console.log("session existe "+vueInstance.user_nickname);
					    }else if(vueInstance.$session.get('tipo_usuario')=='2'){
					    	$("#usuario_state").show();
					      	$("#btn_singin").hide();
					    	vueInstance.user_nickname=vueInstance.$session.get('nickname');
					    	console.log("session existe "+vueInstance.user_nickname);
					    	vueInstance.stateSession='none';
					    	vueInstance.$router.push('/Dashboard');
					    }
				    }
				    
				    
			    });
			},
			closeSession: function(){
				console.log("sesion cerrada");
				$("#usuario_state").hide();
				$("#btn_singin").show();
				this.user_nickname='';
		      	this.$session.destroy();
		      	this.$router.go('/');
		    }

		}
		
	}
</script>
<style>
	#btn_singin{
		background: rgba(0,0,0,0);
		border-style: solid;
		border-width: 3px;
		border-color: #563d7c;
		color: #563d7c;
	}
	#btn_singin:hover{
		background-color: #563d7c;
		color: white;
	}
	#barrita{
		position: fixed;
	    z-index: 1;
	    top: 0;
	    width: 100%;
	}
	.dropdown-item{
		color: #9c27b0;
	}
	.dropdown-item:hover{
		color: #FFFFFF;
		background-color: #9c27b0;
	}
	.nav-item{
		background-color: rgba(0,0,0,0);
	}
	.nav-item:hover{
		background-color: rgba(0,0,0,0.4);
	}
	
</style>