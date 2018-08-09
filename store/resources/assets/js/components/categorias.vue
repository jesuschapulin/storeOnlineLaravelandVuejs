<template>
	<div class="sidevar  card col-lg-1 pl-0 pr-0">
	  <div class="list-group">
		  <a href="#" v-bind:style="" v-on:click.prevent="" class="opt-dash list-group-item list-group-item-action fa fa-boxes">
		    categorias
		  </a>
	  </div>
	</div>
</template>
<script>
	export default{
		data(){
			return{
				
			}
		},
		created: function(){
			console.log("categorias montadas");
		},
		methods:{

		}
	}
</script>