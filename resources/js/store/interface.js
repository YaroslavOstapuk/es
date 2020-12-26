export default {
    state: {
        items: [],
        title: null,
        subtitle: null,
        appBarTitle: null,
        createButtonTitle: null,
        createButtonUrl: null,
    },
    mutations: {
        setItems(state, items) {
            state.items = items;
        },
        setTitle(state, title) {
            state.title = title;
        },
        setSubtitle(state, subtitle) {
            state.subtitle = subtitle;
        },
        setAppBarTitle(state, title) {
            state.appBarTitle = title;
        },
        setCreateButtonTitle(state, title) {
            state.createButtonTitle = title;
        },
        setCreateButtonUrl(state, url) {
            state.createButtonUrl = url;
        },
        clearCreateButtonInfo(state) {
            state.createButtonTitle = null;
            state.createButtonUrl = null;
        }
    },
    getters: {
        items(state) {
            return state.items;
        },
        getTitle(state) {
            return state.title;
        },
        getSubtitle(state) {
            return state.subtitle;
        },
        getAppBarTitle(state) {
            return state.appBarTitle;
        },
        getCreateButtonTitle(state) {
            return state.createButtonTitle;
        },
        getCreateButtonUrl(state) {
            return state.createButtonUrl;
        }
    },
    actions: {
        async fetchMenuItem({commit, dispatch}) {
            try {
                let groups = await axios.get(`${process.env.MIX_APP_URL}/api/v1/groups`);

                const data = groups.data.data;

                let items = data.map(item => {
                    let rObj = {};
                    rObj['name'] = item.name;
                    rObj['avatar'] = item.main_photo.min_avatar;
                    rObj['route'] = {
                        name: 'groupsShow',
                        params: {
                            slug: item.slug
                        }
                    };

                    return rObj;
                });

                commit('setTitle', 'Ваші групи');
                commit('setItems', items);
            } catch (error) {
                commit('setError', error)
            }
        },
        async fetchMenuGroup({commit, dispatch}, slug) {
            commit('setTitle', 'Група');
            let items = [];

            items = [
                {
                    name: 'Події',
                    icon: 'mdi-view-dashboard',
                    route: {
                        name: 'eventsList',
                        params: {
                            slug: slug
                        }
                    }
                },
                {
                    name: 'Питання',
                    icon: 'mdi-image',
                    route: {
                        name: 'questionsList',
                        params: {
                            slug: slug
                        }
                    }
                },
            ]

            commit('setItems', items);
        }
    }
}
