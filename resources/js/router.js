import Home from './components/Home.vue';
import New from './components/New.vue';
import Archive from './components/Archive.vue';

export const routes = [
		{ 	
			path: '',
			//name: 'home', 
	    	//component: Payment,
	    	component: Home
		},
		{ 	
			path: '/new',
			//name: 'home', 
	    	//component: Payment,
	    	component: New
		},
		{ 	
			path: '/archive',
			//name: 'home', 
	    	//component: Payment,
	    	component: Archive
		},

		]