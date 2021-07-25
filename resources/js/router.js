import { createWebHistory, createRouter } from 'vue-router';
import AgendasComponent from './components/AgendasComponent.vue';
import CreateAgendaComponent from './components/CreateAgendaComponent.vue';

const routes = [
	{
		path: '/',
		name: 'AgendasComponent',
		component: AgendasComponent,
	},
    {
		path: '/create',
		name: 'CreateAgendaComponent',
		component: CreateAgendaComponent,
	},
];

const router = createRouter({
	history: createWebHistory(),
	routes
});

export default router;
