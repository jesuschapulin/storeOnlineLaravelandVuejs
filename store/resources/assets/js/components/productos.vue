<template>
		<div class="container-fluid pl-0" id="page_productos">
			<h4 class="text-center">Productos</h4>
			<div class="row">
					<div class="sidevar  card col-lg-1 pl-0 pr-0">
					  <div class="list-group" v-for="categoria in categorias">
						  <div class="card-categoria">
						  	<a href="#" style="height: 4rem;"
						  				v-on:click.prevent=""
						  				class="opt-dash list-group-item list-group-item-action" v-bind:style="{'backgroundImage':'url(/images/logos/'+categoria.imagen+')','background-position':'center','background-size':'cover'}"
						  				v-tooltip.right="'ver productos de \n'+categoria.descripcion"
						  				>
						   </a>
						   <span href="#" class="opt-dash-tittle">{{categoria.descripcion}}</span>
						  </div>
					  </div>
					</div>
				<div class="col-sm-12 col-md-11 col-lg-11 offset-lg-1">
					<div class="row">
						<div class="card col-sm-12 col-lg-3 pl-0 pr-0 ml-1" v-for="producto in productos">
							<img style="width: 100%; height: 10rem;" v-bind:style="{'backgroundImage':'url(/images/'+producto.imagen+')','background-position':'center','background-size':'cover'}"/>
						  <div class="card-body pl-4">
						    <h5 class="card-title text-center">{{producto.nombre}}</h5>
						    <p class="card-text text-black">
						    	Precio por unidad: $<span class="text-success"><b>{{producto.precio_unitario}}.00</b></span>
						    </p>
						    <p class="card-text text-black">
						    	Precio por volumen: $<span class="text-warning"><b>{{producto.precio_volumen}}.00</b></span>
						    </p>
						    <p class="card-text">
						    	Gramage: <b>{{producto.gramage}} grms</b>
						    </p>
						    
						    <div class="btn-group d-flex justify-content-center">
							  <button type="button" class="btn btn-success fa fa-cart-plus" v-bind:style="{'display': estate}" v-tooltip.bottom="'agregar a lista'">
							  </button>
							  <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-on:click.prevent="getLists(producto)" v-bind:style="{'display': estate}">
							    <span class="sr-only">Toggle Dropdown</span>
							  </button>

							  <div class="dropdown-menu">
							    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalConfirmAddToList" v-for="lista in listas" v-on:click.prevent="getProductosList(lista)">{{lista.nombre}}
							    </a>
							    <a href="#" class="dropdown-item fa fa-plus-circle" data-toggle="modal" data-target="#modalCreateList">
							    	crear lista
							    </a>
							  </div>
							</div>
						  </div>
						</div>
					</div>
				</div>
				<div class="modal" tabindex="-1" role="dialog" id="modalConfirmAddToList">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title">Confirmar para agregar a lista</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
				      <div class="modal-body">
				        <table class="table table-striped">
						  <thead>
						    <tr>
						      <th scope="col">producto</th>
						      <th scope="col">precio</th>
						      <th scope="col">cantidad</th>
						      <th scope="col">total</th>
						    </tr>
						  </thead>
						  <tbody>
						    <tr v-for="productos in productosList">
						      <td>{{productos.producto}}</td>
						      <td>{{productos.precio}}</td>
						      <td>{{productos.cantidad}}</td>
						      <td>{{productos.total}}</td>
						    </tr>
						    <tr>
						    	<td></td>
						    	<td></td>
						    	<td></td>
						    	<td>
							    	<span class="">Total neto<b class="ml-1">{{totalNeto}}</b></span>
								</td>
							</tr>
						  </tbody>
						</table>
				      </div>
				      <form method="POST" v-on:submit.prevent="addToList()">
				      	
				      	
				      	<div class="input-group mb-3">
				      		<div class="row">
				      			<div class="col-12">
				      				<label>producto:</label>
						  			<b class="ml-1">{{newAddProducto.nameProduct}}</b>
						  		</div>
						  		<div class="col-8 offset-3" style="height: 4rem;" v-bind:style="{'backgroundImage':'url(/images/'+newAddProducto.imagen+')','background-position':'center','background-size':'cover'}">
						  			
						  		</div>
				      		</div>
						  
						  <a href="#" class="ml-1 btn btn-outline-info pt-3 mt-4 mb-3" v-on:click.prevent="lessProduct()">-</a>
						  <a href="#" class="ml-1 btn btn-outline-info pt-3 mt-4 mb-3" v-on:click.prevent="moreProduct()">+</a>
						  <label class="ml-1">precio:</label>
						  <b class="ml-1">{{newAddProducto.precioProduct}}</b>
						  <label class="ml-1">cantidad:</label>
						  <b class="ml-1">{{newAddProducto.cantidadProduct}}</b>
						  <label class="ml-1">total:</label>
						  <b class="ml-1">{{newAddProducto.totalProduct}}</b>
						</div>
					    <div class="row">
							<div class="col-12 d-flex justify-content-center">
								<input type="submit" class="btn btn-primary" value="Continuar"/>
			        			<button type="button" class="btn btn-simple" data-dismiss="modal">Cancelar</button>
							</div>
						</div>
					  </form>
				    </div>
				  </div>
				</div>
				<div class="modal" tabindex="-1" role="dialog" id="modalCreateList">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title">crear lista</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
				      <div class="modal-body">
				        <form method="POST" v-on:submit.prevent="createList()">
				        	<label for="">Nombre de la lista</label>
				        	<div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text fa fa-sort-alpha-down"></span>
							  </div>
							  <input type="text" class="form-control" placeholder="nombre" aria-label="nameList" aria-describedby="basic-addon1" name="nameList" v-model="nameList">
							</div>
							<span v-if="errorNameList" class="text-danger">{{errorNameList}}</span>
							<div class="input-group mb-3">
							    <div class="row">
					      			<div class="col-12">
					      				<label>producto:</label>
							  			<b class="ml-1">{{newAddProducto.nameProduct}}</b>
							  		</div>
							  		<div class="col-8 offset-3" style="height: 4rem;" v-bind:style="{'backgroundImage':'url(/images/'+newAddProducto.imagen+')','background-position':'center','background-size':'cover'}">
							  			
							  		</div>
				      			</div>
							  <a href="#" class="ml-1 btn btn-outline-info pt-3" v-on:click.prevent="lessProduct()">-</a>
							  <a href="#" class="ml-1 btn btn-outline-info pt-3" v-on:click.prevent="moreProduct()">+</a>
							  <label class="ml-1">precio:</label>
							  <b class="ml-1">{{newAddProducto.precioProduct}}</b>
							  <label class="ml-1">cantidad:</label>
							  <b class="ml-1">{{newAddProducto.cantidadProduct}}</b>
							  <label class="ml-1">total:</label>
							  <b class="ml-1">{{newAddProducto.totalProduct}}</b>
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
		</div>
</template>
<script>
	import axios from 'axios'
	import jquery from 'jquery'
	import toastr from 'toastr'
	import Vue from 'vue';
	import Tooltip from 'vue-directive-tooltip';
	Vue.use(Tooltip);

	import categorias from './categorias';
	export default{
		data(){
			return{
				productos: [],
				categorias:[],
				listas:[],
				estate:'block',
				color:'red',
				errorNameList:'',
				nameList:'',
				totalNeto:'',
				newAddProducto:{'id_usuario':'',
								'id_lista':'',
								'id_producto':'',
								'nameProduct':'',
								'precioProduct':'',
								'cantidadProduct':'1',
								'totalProduct':'',
								'imagen':''
				},
				productosList:[],
			}
		},
		created: function(){
			this.get_productos();
			this.getCategorias();
			console.log("llamando productos");
		},
		methods:{
			get_productos: function(){
				let vueInstance=this;
				var url_productos='get_productos';
				axios.get(url_productos).then(function(response){
					vueInstance.productos=response.data
				});
				if (!vueInstance.$session.exists()){
			      	console.log("session no existe en productos");
			      	vueInstance.estate='none';
			    }else{
			    	console.log("session  existe en productos");
			    	vueInstance.newAddProducto.id_usuario=vueInstance.$session.get("id_usuario");
			    	vueInstance.estate='block';
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
			getLists: function(producto){
				var url="getLists";
				let vueInstance=this;
				vueInstance.newAddProducto.id_producto=producto.id_producto;
				vueInstance.newAddProducto.nameProduct=producto.nombre;
				vueInstance.newAddProducto.precioProduct=producto.precio_unitario;
				vueInstance.newAddProducto.totalProduct=producto.precio_unitario;
				vueInstance.newAddProducto.cantidadProduct=1;
				vueInstance.newAddProducto.imagen=producto.imagen;
				axios.post(url,{
					id_usuario:vueInstance.$session.get("id_usuario")
				}).then(function(response){
					if(response.status===200){
						vueInstance.listas=response.data;
					}
				}).catch(error=>{

				});
			},
			moreProduct:function(){
				let vueInstance=this;
				var cont=vueInstance.newAddProducto.cantidadProduct;
				cont++;
				vueInstance.newAddProducto.cantidadProduct=cont;
				vueInstance.newAddProducto.totalProduct=(vueInstance.newAddProducto.precioProduct*vueInstance.newAddProducto.cantidadProduct);
			},
			lessProduct:function(){
				let vueInstance=this;
				var cont=vueInstance.newAddProducto.cantidadProduct;
				cont--;
				vueInstance.newAddProducto.cantidadProduct=cont;
				vueInstance.newAddProducto.totalProduct=(vueInstance.newAddProducto.precioProduct*vueInstance.newAddProducto.cantidadProduct);

			},
			getProductosList:function(lista){
				let vueInstance=this;
				var url="getProductosList";
				vueInstance.newAddProducto.id_lista=lista.id_lista;
				axios.post(url,{
					id_usuario:vueInstance.newAddProducto.id_usuario,
					id_lista:vueInstance.newAddProducto.id_lista
				}).then(function(response){
					if(response.status===200){
						vueInstance.productosList=response.data;
						vueInstance.totalNeto=vueInstance.productosList[0].totalNeto;
					}
				})

			},
			addToList:function(){
				let vueInstance=this;
				var url="addProductList";
				axios.post(url,{
					id_usuario:vueInstance.newAddProducto.id_usuario,
					id_producto:vueInstance.newAddProducto.id_producto,
					cantidad:vueInstance.newAddProducto.cantidadProduct,
					total:vueInstance.newAddProducto.totalProduct,
					id_lista:vueInstance.newAddProducto.id_lista
				}).then(function(response){
					if(response.status===200){
						if(response.data.messageError){
							toastr.error(response.data.messageError);
						}else if(response.data.messageSuccess){
							toastr.success(response.data.messageSuccess);
							$("#modalConfirmAddToList").modal("hide");
						}
					}
				}).catch(error=>{

				});
			},
			createList: function(){
				let vueInstance=this;
				var url="createList";
				if(!vueInstance.nameList){
					vueInstance.errorNameList='ingresa un nombre para la lista';
				}else{
					vueInstance.errorNameList=''
					axios.post(url,{
						id_producto:vueInstance.newAddProducto.id_producto,
						cantidad:vueInstance.newAddProducto.cantidadProduct,
						id_usuario:vueInstance.newAddProducto.id_usuario,
						nameList:vueInstance.nameList
					}).then(function(response){
						if(response.status===200){
							if(response.data.messageError){
								toastr.error(response.data.messageError);
							}else{
								toastr.success(response.data.messageSuccess);
								$("#modalCreateList").modal("hide");
								vueInstance.nameList='';
							}
						}
					}).catch(error=>{

					});
				}
			}
		},
		components:{'categoriasComponent':categorias}
	}
</script>
<style>
	#page_productos{
		margin-top: 4rem;
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
	.card-categoria{
		background-color: rgba(0,0,0,0);
	}
	.card-categoria:hover{
		
		background-color: rgba(0,0,0,8);
		
	}
	.card-categoria:hover .opt-dash{
		background-color: rgba(0,0,0,8);
		opacity: 0.5;

	}
	.card-categoria:hover .opt-dash-tittle{
		color: white;
		display: inline-block;
		position: fixed;
    	z-index: 10000;
		margin-top: -2.5rem;
		margin-left: .5rem;
	}
	.opt-dash-tittle{
		display: none;
	}
	@media screen and (max-width: 370px) {
    .sidevar {width: 0rem;}
	}
</style>