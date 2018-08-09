<template>
	<div class="container-fluid">
		<div class="row">
			<div class="sidevar  card col-lg-2 pl-0 pr-0">
			  <h5 class="text-center">Dashboard</h5>
			  <div class="list-group">
				  <a href="#" v-bind:style="activeProductos" v-on:click.prevent="getProductsDash()" class="opt-dash list-group-item list-group-item-action fa fa-boxes">
				    productos
				  </a>
				  <a href="#" v-bind:style="activeCategorias" v-on:click.prevent="getCategoriasDash()" class="opt-dash list-group-item list-group-item-action">categorias</a>
				  <a href="#" v-bind:style="activeListas" v-on:click.prevent="getListasDash()" class="opt-dash list-group-item list-group-item-action">listas</a>
				  <a href="#" v-bind:style="activePedidos" v-on:click.prevent="getPedidosDash" class="opt-dash list-group-item list-group-item-action">pedidos</a>
				  <a href="#" v-bind:style="activeInventario" v-on:click.prevent="getInventarioDash()" class="opt-dash list-group-item list-group-item-action disabled">inventario</a>
				</div>
			</div>
			<div class="col-lg-10 offset-lg-2 pl-3 dash-padding">
				<div class="row" id="pageProducts" v-bind:style="{'display':displayProducts}">
					<div class="col-12 d-flex justify-content-center">
						<a href="#" class="btn btn-simple btn-md bg-purple text-white fa fa-plus rounded-circle" v-on:click.prevent="showFormNewProduct()" v-tooltip.bottom="'Agregar un producto nuevo'">
							
						</a>
					</div>
					<div class="card col-sm-12 col-lg-3 pl-0 pr-0" v-for="producto in productos" style="display: inline-block;">
						<img style="width: 100%; height: 15rem; margin: 0;" v-bind:style="{'backgroundImage':'url(/images/'+producto.imagen+')','background-position':'center','background-size':'cover'}"/>
					  <div class="card-body pl-2 mt-0">
					    <h5 class="card-title text-center">{{producto.nombre}}</h5>
					    <p class="card-text text-black">
					    	Precio por unidad: $<span class="text-success"><b>{{producto.precio_unitario}}.00</b></span>
					    </p>
					    <p class="card-text text-black">
					    	Precio por volumen: $<span class="text-warning"><b>{{producto.precio_volumen}}.00</b></span>
					    </p>
					    <p class="card-text">
					    	Gramage: <b>{{producto.gramage}} {{producto.tipo_peso}}</b>
					    </p>
					    <p class="card-text">
					    	Cantidad disponible: <b>{{producto.cantidad_disponible}}</b>
					    </p>
					    <div class="btn-group">
						  
						</div>
					  </div>
					  <div class="container-fluid d-flex justify-content-center">
							<a href="#" class="bt btn-simple btn-success btn-lg fa fa-sync" v-tooltip.bottom="'actualizar producto: '+producto.nombre" v-on:click.prevent="actualizarProduct(producto)"></a>
							<a href="#" class="bt btn-simple" v-on:click.prevent=""></a>
							<a href="#" class="bt btn-simple" v-on:click.prevent=""></a>
					  </div>
					</div>
				</div>
				<div class="row pt-5" id="pageFormNewProduct" v-bind:style="{'display': displayFormNewProduct}">
			    	<div class="card shadow-lg mt-4 rounded col-lg-6 offset-lg-3">
		    			<div class="row mb-2 pl-4 pr-4">
		    				<div class="col-12 rounded shadow-lg" style="background-color: #9c27b0; margin-top:-2rem; height: 4rem;">
		    					<h4 class="text-center" style="color: white">{{tittleForm}}</h4>
		    				</div>
		    			</div>
				        <form class="pt-2" method="POST" v-on:submit.prevent="registerProduct(estateUpdateProduct)">
							<div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text fa fa-sort-alpha-down"></span>
							  </div>
							  <input type="text" class="form-control" placeholder="nombre" aria-label="" aria-describedby="basic-addon1" name="nombre" v-model="producto.nombre">
							</div>
							<span v-if="errorNameProduct" class="text-danger">{{errorNameProduct}}</span>

							<div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text fa fa-dollar-sign"></span>
							  </div>
							  <input type="text" class="form-control" placeholder="precio unitario" aria-label="" aria-describedby="basic-addon1" name="precio_unitario" v-model="producto.precio_unitario">
							</div>
							<span v-if="errorPrecioUnitario" class="text-danger">{{errorPrecioUnitario}}</span>

							<div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text fa fa-dollar-sign"></span>
							  </div>
							  <input type="text" class="form-control" placeholder="precio por volumen" aria-label="" aria-describedby="basic-addon1" name="precio_volumen" v-model="producto.precio_volumen">
							</div>
							<span v-if="errorPrecioVolumen" class="text-danger">{{errorPrecioVolumen}}</span>

							<div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text fa fa-boxes"></span>
							  </div>
							  <div class="btn-group">
								  
								  <button type="button" class="btn btn-simple dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								    <span class="">{{catego}}</span>
								  </button>
								  <div class="dropdown-menu">
								    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalConfirmAddToList" v-for="catego in categorias" v-on:click.prevent="setvalueCat(catego)">{{catego.descripcion}}
								    </a>
								    <a href="#" class="dropdown-item fa fa-plus-circle" data-toggle="modal" data-target="#modalConfirmAction" v-on:click.prevent="createCategoria()">
								    	crear categoria
								    </a>
								  </div>
								</div>
							</div>
							<span v-if="errorCategoria" class="text-danger">{{errorCategoria}}</span>
							
							<div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text fa fa-anchor"></span>
							  </div>
							  <input type="text" class="form-control" placeholder="gramage" aria-label="" aria-describedby="basic-addon1" name="precio_volumen" v-model="producto.gramage"/>
							  <div class="btn-group">
								  
								  <button type="button" class="btn btn-simple dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								    <span class="">{{producto.tipo_peso}}</span>
								  </button>
								  <div class="dropdown-menu">
								    <a class="dropdown-item" href="#"  v-on:click.prevent="producto.tipo_peso='gr'" id="opt_gr">gr
								    </a>
								    <a href="#" class="dropdown-item" v-on:click.prevent="producto.tipo_peso='ml'" id="opt_ml">
								    	ml
								    </a>
								    <a href="#" class="dropdown-item" v-on:click.prevent="producto.tipo_peso='kg'" id="opt_kg">
								    	kg
								    </a>
								  </div>
								</div>
							</div>
							<span v-if="errorGramage" class="text-danger">{{errorGramage}}</span>
							<span v-if="errorTipo_peso" class="text-danger">{{errorTipo_peso}}</span>

							<div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text fa fa-file-image"></span>
							  </div>
							  <input type="file" class="form-control"  name="imageProduct" id="imageProduct">
							  <img style="width: 100%; height: 15rem; margin: 0;" v-if="updateProduct" v-bind:style="{'backgroundImage':'url(/images/'+producto.imagen+')','background-position':'center','background-size':'cover'}"/>
							</div>
							<span v-if="errorImagenProducto" class="text-danger">{{errorImagenProducto}}</span>

							<div class="container-fluid d-flex justify-content-center">
								<input type="submit" class="btn btn-primary" name="btn_login" id="btn_login" value="Continuar">
								<br>
								<a href="#" class="btn btn-simple" id="hovblue" v-on:click.prevent="cancelRegisterProduct()">Cancelar</a>
							</div>
							
						</form>
					</div>
				</div>
				
			</div>
		</div>
		<div class="modal" tabindex="-1" role="dialog" id="modalConfirmAction">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title">{{modalConfirm.tittle}}</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			      	<h2 v-if="modalConfirm.message=='confirm'">{{modalConfirm.descripcion}}</h2>
			        <form method="POST" v-on:submit.prevent="confirmAction()">
			        	<div v-bind:style="{'display':formDataCategoria}">
			        		<div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text fa fa-sort-alpha-down"></span>
							  </div>
							  <input type="text" class="form-control" placeholder="nombre" aria-label="" aria-describedby="basic-addon1" name="nombre" v-model="categoria.nombre">
							</div>
							<span v-if="errorNameCategoria" class="text-danger">{{errorNameCategoria}}</span>
							<div class="input-group mb-3">
								  <div class="input-group-prepend">
								    <span class="input-group-text fa fa-file-image"></span>
								  </div>
								  <input type="file" class="form-control"  name="imageCategoria" id="imageCategoria">
								  
							</div>
							<span v-if="errorImagenCategoria" class="text-danger">{{errorImagenCategoria}}</span>
			        	</div>
			        	
						<div class="row">
							<div class="col-12 d-flex justify-content-end">
								<input type="submit" class="btn btn-primary" value="Continuar"/>
			        			<button type="button" class="btn btn-simple" data-dismiss="modal">Cancelar</button>
							</div>
						</div>
			        </form>
			      </div>
			    </div>
			  </div>
			</div>
	</div>
</template>
<script>
	import jquery from 'jquery';
	import toastr from 'toastr';
	import axios from 'axios';
	import Vue from 'vue';
	import Tooltip from 'vue-directive-tooltip';
	Vue.use(Tooltip);

	export default{
		data(){
			return{
				activeProductos:{},
				activeCategorias:{},
				activeListas:{},
				activePedidos:{},
				activeInventario:{},
				formDataCategoria:'none',
				modalConfirm:{'tittle':'','acction':'','message':'','descripcion':'','estate':''},
				categoria:{'nombre':'','imagen':''},
				productos:[],
				categorias:[],
				estateUpdateProduct:'register',
				catego:'categoria',
				producto:{'nombre':'','precio_unitario':'','precio_volumen':'','categoria':'','gramage':'','imagen':'','tipo_peso':'seleccione tipo de peso','originalName':''},
				displayProducts:'none',
				displayFormNewProduct:'none',
				updateProduct:'',
				tittleForm:'',
				errorNameProduct:'',
				errorPrecioUnitario:'',
				errorPrecioVolumen:'',
				errorCategoria:'',
				errorGramage:'',
				errorImagenProducto:'',
				errorTipo_peso:'',
				errorNameCategoria:'',
				errorImagenCategoria:'',
			}
		},
		created: function(){
		},
		methods:{
			getProductsDash: function(){
				let vueInstance=this;
				
				vueInstance.activeCategorias={};
				vueInstance.activeListas={};
				vueInstance.activePedidos={};
				vueInstance.activeInventario={};
				vueInstance.activeProductos={'background-color':'#563d7c','color':'white'}
				vueInstance.displayProducts='block';
				vueInstance.displayFormNewProduct='none';
				var url="getProductsDash";
				axios.get(url).then(function(response){
					vueInstance.productos=response.data;
				}).catch(error=>{

				});
			},
			confirmAction: function(){
				let vueInstance=this;
				
						
				if(vueInstance.modalConfirm.acction=="createCategoria"){
					
					if(!vueInstance.categoria.nombre){vueInstance.errorNameCategoria="Ingresa un nombre para la categoria"}else{vueInstance.errorNameCategoria=''}
					if($("#imageCategoria").val()==""){vueInstance.errorImagenCategoria="Selecciona una imagen para la categoria"}else{vueInstance.errorImagenCategoria=""}
					if(!vueInstance.errorNameCategoria && !vueInstance.errorImagenCategoria){
						vueInstance.modalConfirm.tittle='confirmar nueva categoria';
						vueInstance.modalConfirm.message='confirm';
						vueInstance.modalConfirm.descripcion='Está usted segúro que desea crear esta lista ?';
						vueInstance.formDataCategoria='none';
						vueInstance.modalConfirm.acction='';
						
						vueInstance.confirmAction();
						vueInstance.modalConfirm.estate='confirmCategoria';
					}

				}
				else if(vueInstance.modalConfirm.estate=="confirmCategoria"){
						const formData=new FormData();
						formData.append('nombre', vueInstance.categoria.nombre);
	            		formData.append('imageCategoria',document.getElementById('imageCategoria').files[0]);
						//console.log(formData);
						var url="createCategoria";
						axios.post(url,formData).then(function(response){
							if(response.status===200){
								if(response.data.messageSuccess){
									toastr.success(response.data.messageSuccess);
									vueInstance.getCategorias();
									vueInstance.catego=vueInstance.categoria.nombre;
									$("#modalConfirmAction").modal("hide");
								}else if(response.data.messageError){
									toastr.error(response.data.messageError);
									vueInstance.modalConfirm.acction='createCategoria';
									vueInstance.modalConfirm.tittle='Crear nueva categoria';
									vueInstance.modalConfirm.message='createCategoria';
									vueInstance.modalConfirm.estate='';
									vueInstance.formDataCategoria='block';
								}
							}
						}).catch(error=>{

						});
					}
				
				
			},
			createCategoria:function(){
				let vueInstance=this;
				vueInstance.modalConfirm.acction='createCategoria';
				vueInstance.modalConfirm.tittle='Crear nueva categoria';
				vueInstance.modalConfirm.message='createCategoria';
				vueInstance.modalConfirm.estate='';
				vueInstance.formDataCategoria='block';
			},
			showFormNewProduct: function(){
				let vueInstance=this;
				vueInstance.tittleForm="Registrar Producto";
				vueInstance.displayProducts='none';
				vueInstance.displayFormNewProduct='block';
				vueInstance.estateUpdateProduct='register';
				vueInstance.getCategorias();

			},
			setvalueCat: function(catego){
				let vueInstance=this;
				vueInstance.producto.categoria=catego.descripcion;
				vueInstance.catego=catego.descripcion;
			},
			actualizarProduct:function(producto){
				let vueInstance=this;
				vueInstance.producto.nombre=producto.nombre;
				vueInstance.producto.precio_unitario=producto.precio_unitario;
				vueInstance.producto.precio_volumen=producto.precio_volumen;
				vueInstance.catego=producto.id_categorias_productos;
				vueInstance.producto.gramage=producto.gramage;
				vueInstance.producto.tipo_peso=producto.tipo_peso;
				vueInstance.producto.imagen=producto.imagen;
				vueInstance.producto.originalName=producto.nombre;
				vueInstance.updateProduct="true";
				vueInstance.tittleForm="Actualizar Producto";
				vueInstance.getCategorias();
				var url='get_categoria';
				axios.post(url,{id_categoria:vueInstance.catego}).then(function(response){
					vueInstance.catego=response.data.descripcion;
					vueInstance.producto.categoria=response.data.descripcion;
				}).catch(error=>{

				});
				vueInstance.estateUpdateProduct='update';
				vueInstance.displayProducts='none';
				vueInstance.displayFormNewProduct='block';
			},
			cancelRegisterProduct:function(){
				let vueInstance=this;
				vueInstance.displayProducts='block';
				vueInstance.displayFormNewProduct='none';
				vueInstance.producto.nombre='';
				vueInstance.producto.precio_unitario='';
				vueInstance.producto.categoria='';
				vueInstance.producto.precio_volumen='';
				vueInstance.catego='categoria';
				vueInstance.producto.gramage='gramage';
				vueInstance.producto.tipo_peso='seleccione tipo de peso';
				vueInstance.producto.imagen='';
				vueInstance.updateProduct="";
				vueInstance.tittleForm="Registrar Producto";
				vueInstance.estateUpdateProduct='register';
			},
			registerProduct:function(){
				let vueInstance=this;
				if(vueInstance.estateUpdateProduct=="register"){
	            	const formData = new FormData();
	            	formData.append('nombre', vueInstance.producto.nombre);
	            	formData.append('precio_unitario', vueInstance.producto.precio_unitario);
	            	formData.append('precio_volumen', vueInstance.producto.precio_volumen);
	            	formData.append('categoria', vueInstance.producto.categoria);
	            	formData.append('gramage', vueInstance.producto.gramage);
	            	formData.append('tipo_peso', vueInstance.producto.tipo_peso);
	            	formData.append('imageProduct', document.getElementById('imageProduct').files[0]);
	            	
	            	if(vueInstance.producto.tipo_peso=="seleccione tipo de peso"){vueInstance.errorTipo_peso="seleccione un tipo de peso"}else{vueInstance.errorTipo_peso=""}
	            	if(!vueInstance.producto.nombre){vueInstance.errorNameProduct="ingresa un nombre"}else{vueInstance.errorNameProduct=""}
	            	if(!vueInstance.producto.precio_unitario){vueInstance.errorPrecioUnitario="ingresa un precio por unidad"}else{vueInstance.errorPrecioUnitario=""}
	            	if(!vueInstance.producto.precio_volumen){vueInstance.errorPrecioVolumen="ingresa un precio por volumen"}else{vueInstance.errorPrecioVolumen=""}
	            	if(!vueInstance.producto.precio_unitario){vueInstance.errorPrecioUnitario="ingresa un precio por unidad"}else{vueInstance.errorPrecioUnitario=""}
	            	if(!vueInstance.producto.categoria){vueInstance.errorCategoria="selecciona una categoria"}else{vueInstance.errorCategoria=""}
	            	if(!vueInstance.producto.gramage){vueInstance.errorGramage="ingresa el peso del producto"}else{vueInstance.errorGramage=""}
	            	if(!vueInstance.errorNameProduct && !vueInstance.errorPrecioUnitario && !vueInstance.errorPrecioVolumen && !vueInstance.errorCategoria && !vueInstance.errorGramage && !vueInstance.errorTipo_peso){
	            		var url="registerNewProduct";
	            		axios.post(url,formData).then(function(response){
	            			if(response.status===200){
	            				if(response.data.messageSuccess){
	            					toastr.success(response.data.messageSuccess);
	            					vueInstance.producto.nombre="";
	            					vueInstance.producto.precio_unitario="";
	            					vueInstance.producto.precio_volumen="";
	            					vueInstance.producto.categoria="";
	            					vueInstance.producto.gramage="";
	            					$("#imageProduct").val("");
									vueInstance.getProductsDash();
									vueInstance.displayProducts='block';
									vueInstance.displayFormNewProduct='none';
									vueInstance.estateUpdateProduct='register';
	            				}else if(response.data.messageError){
	            					toastr.error(response.data.messageError);
	            				}
	            			}
	            		}).catch(error=>{
	            			console.log(error.response.data)
	            		});
	            		
	            	}
	            }else if(vueInstance.estateUpdateProduct=="update"){
	            	const formData = new FormData();
	            	formData.append('originalName',vueInstance.producto.originalName);
	            	formData.append('nombre', vueInstance.producto.nombre);
	            	formData.append('precio_unitario', vueInstance.producto.precio_unitario);
	            	formData.append('precio_volumen', vueInstance.producto.precio_volumen);
	            	formData.append('categoria', vueInstance.producto.categoria);
	            	formData.append('gramage', vueInstance.producto.gramage);
	            	formData.append('tipo_peso', vueInstance.producto.tipo_peso);
	            	
	            	if(vueInstance.producto.tipo_peso=="seleccione tipo de peso"){vueInstance.errorTipo_peso="seleccione un tipo de peso"}else{vueInstance.errorTipo_peso=""}
	            	if(!vueInstance.producto.nombre){vueInstance.errorNameProduct="ingresa un nombre"}else{vueInstance.errorNameProduct=""}
	            	if(!vueInstance.producto.precio_unitario){vueInstance.errorPrecioUnitario="ingresa un precio por unidad"}else{vueInstance.errorPrecioUnitario=""}
	            	if(!vueInstance.producto.precio_volumen){vueInstance.errorPrecioVolumen="ingresa un precio por volumen"}else{vueInstance.errorPrecioVolumen=""}
	            	if(!vueInstance.producto.precio_unitario){vueInstance.errorPrecioUnitario="ingresa un precio por unidad"}else{vueInstance.errorPrecioUnitario=""}
	            	if(!vueInstance.producto.categoria){vueInstance.errorCategoria="selecciona una categoria"}else{vueInstance.errorCategoria=""}
	            	if(!vueInstance.producto.gramage){vueInstance.errorGramage="ingresa el peso del producto"}else{vueInstance.errorGramage=""}
	            	if(!vueInstance.errorNameProduct && !vueInstance.errorPrecioUnitario && !vueInstance.errorPrecioVolumen && !vueInstance.errorCategoria && !vueInstance.errorGramage && !vueInstance.errorTipo_peso){
	            		var url="updateProduct";
	            		if($("#imageProduct").val()==""){
	            			formData.append('message', 'sameImage');
		            		axios.post(url,formData).then(function(response){
		            			if(response.status===200){
		            				if(response.data.messageSuccess){
		            					toastr.success(response.data.messageSuccess);
		            					vueInstance.producto.nombre="";
		            					vueInstance.producto.precio_unitario="";
		            					vueInstance.producto.precio_volumen="";
		            					vueInstance.producto.categoria="";
		            					vueInstance.producto.gramage="";
		            					$("#imageProduct").val("");
										vueInstance.getProductsDash();
										vueInstance.displayProducts='block';
										vueInstance.displayFormNewProduct='none';
										vueInstance.estateUpdateProduct='register';
		            				}else if(response.data.messageError){
		            					toastr.error(response.data.messageError);
		            				}
		            			}
		            		}).catch(error=>{
		            			console.log(error.response.data)
		            		});
	            		
	            		}else{
	            			formData.append('message', '');
	            			formData.append('imageProduct', document.getElementById('imageProduct').files[0]);
		            		axios.post(url,formData).then(function(response){
		            			if(response.status===200){
		            				if(response.data.messageSuccess){
		            					toastr.success(response.data.messageSuccess);
		            					vueInstance.producto.nombre="";
		            					vueInstance.producto.precio_unitario="";
		            					vueInstance.producto.precio_volumen="";
		            					vueInstance.producto.categoria="";
		            					vueInstance.producto.gramage="";
		            					$("#imageProduct").val("");
										vueInstance.getProductsDash();
										vueInstance.displayProducts='block';
										vueInstance.displayFormNewProduct='none';
										vueInstance.estateUpdateProduct='register';
		            				}else if(response.data.messageError){
		            					toastr.error(response.data.messageError);
		            				}
		            			}
		            		}).catch(error=>{
		            			console.log(error.response.data)
		            		});
	            		}
	            	}
	            }
			},
			getCategorias: function(){
				let vueInstance=this;
				var url="getCategorias";
				axios.get(url).then(function(response){
					if(response.status===200){
						vueInstance.categorias=response.data;
					}
				}).catch(error=>{

				});
			},
			getCategoriasDash: function(){
				let vueInstance=this;
				vueInstance.activeListas={};
				vueInstance.activeProductos={};
				vueInstance.activePedidos={};
				vueInstance.activeInventario={};
				vueInstance.activeCategorias={'background-color':'#563d7c','color':'white'}
			},
			getListasDash: function(){
				let vueInstance=this;
				vueInstance.activeCategorias={};
				vueInstance.activeProductos={};
				vueInstance.activePedidos={};
				vueInstance.activeInventario={};
				vueInstance.activeListas={'background-color':'#563d7c','color':'white'}
			},
			getPedidosDash: function(){
				let vueInstance=this;
				vueInstance.activeCategorias={};
				vueInstance.activeListas={};
				vueInstance.activeProductos={};
				vueInstance.activeInventario={};
				vueInstance.activePedidos={'background-color':'#563d7c','color':'white'}
			},
			getInventarioDash: function(){
				let vueInstance=this;
				vueInstance.activeCategorias={};
				vueInstance.activeListas={};
				vueInstance.activePedidos={};
				vueInstance.activeProductos={};
				vueInstance.activeInventario={'background-color':'#563d7c','color':'white'}
			}
		}
	}

</script>
<style>
.opt-dash:hover{
	background-color: #563d7c;
	color: white;
}
.sidevar {

    height: 100%;
    position: fixed;
    z-index: 1;
    top: 3.5rem;
    left: 0;
    overflow-x: hidden;
    padding-top: 20px;
}

.classnull{
    padding: 6px 8px 6px 16px;
    text-decoration: none;
    font-size: 25px;
    color: #818181;
    display: block;
}

.classnull:hover {
    color: #f1f1f1;
}

.column {
    margin-left: 160px; /* Same as the width of the sidevar */
    padding: 3.5rem 4.5rem;
}
.dash-padding{
	padding-top: 3.5rem;
}
.bg-purple{
	background-color: #563d7c;
}
@media screen and (max-width: 370px) {
    .sidevar {width: 0rem;}
}
</style>