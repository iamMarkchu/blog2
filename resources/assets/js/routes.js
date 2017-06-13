export default 
[
	{ 
		path: '/',
		component: require('./components/Home.vue')
	},
	{
		path: '/article',
		component: require('./components/Article/Index.vue')	
	},
	{
		path: '/article/add',
		component: require('./components/Article/Add.vue')	
	},
	{
		path: '/article/:id/edit',
		name: 'article-edit',
		component: require('./components/Article/Edit.vue')	
	},
];