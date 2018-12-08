<template>
<v-card>
	<v-layout>
		<v-flex xs2>
			 <v-checkbox label="" v-model="checkbox1"></v-checkbox>
		</v-flex>
		<v-flex xs10>
			fredrik Ohlqvist
		</v-flex>
	</v-layout>
</v-card>	
</template>
<script>
	export default{

		data(){

			return{
				checkbox1: false

			}
		}

	}

</script>