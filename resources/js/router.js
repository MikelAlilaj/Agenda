import { createWebHistory, createRouter } from 'vue-router';
import AgendasComponent from './components/AgendasComponent.vue';
import CreateAgendaComponent from './components/CreateAgendaComponent.vue';
import UpdateAgendaComponent from './components/UpdateAgendaComponent.vue';

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
    {
		path: '/update/:id',
		name: 'UpdateAgendaComponent',
		component: UpdateAgendaComponent,
	},
];

const router = createRouter({
	history: createWebHistory(),
	routes
});

export default router;
