export const routes = [
    {
        path: '/',
        name: 'home',
        meta: {layout: 'empty'},
        component: () => import('./modules/Home.vue')
    },
    {
        path: '/groups',
        name: 'groups',
        meta: {layout: 'main'},
        component: () => import('./modules/Group/List.vue')
    },
    {
        path: '/groups/add',
        name: 'groupsAdd',
        meta: {layout: 'main'},
        component: () => import('./modules/Group/Add.vue')
    },
    {
        path: '/search',
        name: 'groupsSearch',
        meta: {layout: 'main'},
        component: () => import('./modules/Group/Search.vue')
    },
    {
        path: '/groups/:slug',
        name: 'groupsShow',
        meta: {layout: 'main'},
        component: () => import('./modules/Group/Show.vue')
    },
    {
        path: '/groups/:slug/edit',
        name: 'groupsEdit',
        meta: {layout: 'main'},
        component: () => import('./modules/Group/Edit.vue')
    },
    {
        path: '/groups/:slug/events',
        name: 'eventsList',
        meta: {layout: 'main'},
        component: () => import('./modules/Event/List.vue')
    },
    {
        path: '/groups/:slug/events/add',
        name: 'eventsAdd',
        meta: {layout: 'main'},
        component: () => import('./modules/Event/Add.vue')
    },
    {
        path: '/groups/:slug/events/:id/edit',
        name: 'eventsEdit',
        meta: {layout: 'main'},
        component: () => import('./modules/Event/Edit.vue')
    },
    {
        path: '/groups/:slug/questions',
        name: 'questionsList',
        meta: {layout: 'main'},
        component: () => import('./modules/Question/List.vue')
    },
    {
        path: '/groups/:slug/questions/add',
        name: 'questionsAdd',
        meta: {layout: 'main'},
        component: () => import('./modules/Question/Add')
    },
    {
        path: '/groups/:slug/questions/:id',
        name: 'questionsShow',
        meta: {layout: 'main'},
        component: () => import('./modules/Question/Show')
    },
    {
        path: '/groups/:slug/users',
        name: 'usersList',
        meta: {layout: 'main'},
        component: () => import('./modules/User/List')
    },
    {
        path: '/groups/:slug/settings',
        name: 'groupsSetting',
        meta: {layout: 'main'},
        component: () => import('./modules/Settings/Show')
    },
    {
        path: '/users',
        name: 'usersShow',
        meta: {layout: 'main'},
        component: () => import('./modules/User/Show')
    },
    {
        path: '/groups/:slug/chats/add',
        name: 'chatsAdd',
        meta: {layout: 'main'},
        component: () => import('./modules/Chats/Add')
    },
    {
        path: '/groups/:slug/chats/:id',
        name: 'chatsShow',
        meta: {layout: 'main'},
        component: () => import('./modules/Chats/Show')
    },
];
