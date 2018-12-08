<template>

	<v-container>
		<v-layout row>
		<app-header></app-header>
		</v-layout>
		<v-layout>
			
		</v-layout>
		<v-layout row>
			
			<router-view></router-view>
		</v-layout>
		
	</v-container>
	
	
	
</template>

<script>
import Header from './Header.vue';
	export default{

		//name: 'main-app',

		components:{

			'app-header': Header
		}
	}

</script>