<template>
	
	<v-container>
		<v-layout>
			<v-flex>
				<div class="title">Här kommer nya ordrar</div>
			</v-flex>
		</v-layout>
		<v-layout row>
			<v-flex xs12>
			<!-- <ul>
				<li v-for="order in ordrar">{{ order.id }}</li>
			</ul> -->

			<v-list-tile v-for="(order, index) in ordrar" :key="order.id" @click="">
            <v-list-tile-action>
              <v-checkbox v-model="delivered[index]"></v-checkbox>
            </v-list-tile-action>

            <v-list-tile-content @click="delivered(index)">
              <v-list-tile-title>Order ||  {{order.id}} ||  {{index}}</v-list-tile-title>
              <v-list-tile-sub-title>{{order.created_at}}</v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>
         </v-flex>
		</v-layout>
	</v-container>
</template>
<script>
	export default{

			data(){

				return{
					ordrar:[],
					delivered:{}
				}
			},

		 mounted() {
		 	
     			this.getNewOrders();
		 },
		methods:{

			async getNewOrders(){
				// console.log('getorders')

				try{
					const or = await axios.get('/orders')
					console.log('Logga ordrar', or.data.orders)
					// const ordrar = or.data
					this.ordrar = or.data.orders

				}catch(error){
					console.log(error)
				}

			}
		},
		delivered(i){
			console.log(i)

		}
		
	}

</script>