export default {
    state: {
        items: [],
        title: null,
        subtitle: null,
        appBarTitle: null,
        activeGroupSlug: null,
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
        setActiveGroupSlug(state, payload) {
            state.activeGroupSlug = payload;
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
        getActiveGroupSlug(state) {
            return state.activeGroupSlug;
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
        groupSlug({commit, dispatch}, payload) {
            commit('setActiveGroupSlug', payload);
        },

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
        async fetchMenuGroup({commit, dispatch}, payload) {

            if (!payload.update && this.getters['items'].length) {
                return;
            }

            let primaryChat = await dispatch('primaryChat', payload.slug);

            let chats = await dispatch('getOtherChat', payload.slug);

            commit('setTitle', 'Група');
            let items = [];

            items = [
                {
                    name: 'Події',
                    icon: 'mdi-view-dashboard',
                    route: {
                        name: 'eventsList',
                        params: {
                            slug: payload.slug
                        }
                    }
                },
                {
                    name: 'Питання',
                    icon: 'mdi-image',
                    route: {
                        name: 'questionsList',
                        params: {
                            slug: payload.slug
                        }
                    }
                },
                {
                    name: 'Загальний чат',
                    icon: 'mdi-chat',
                    route: {
                        name: 'chatsShow',
                        params: {
                            slug: payload.slug,
                            id: primaryChat.id,
                        }
                    }
                },
            ]

            let chatsInMenu = [];

            if (chats.length) {
                chats.forEach(function (item) {
                    chatsInMenu.push({
                        name: item.name,
                        icon: 'mdi-chat',
                        route: {
                            name: 'chatsShow',
                            params: {
                                slug: payload.slug,
                                id: item.id,
                            }
                        }
                    });
                });
            }

            items = items.concat(chatsInMenu);

            items.push({
                name: 'Учасники',
                icon: 'mdi-account-circle',
                route: {
                    name: 'usersList',
                    params: {
                        slug: payload.slug
                    }
                }
            });

            items.push({
                name: 'Налаштування',
                icon: 'mdi-settings',
                route: {
                    name: 'groupsSetting',
                    params: {
                        slug: payload.slug
                    }
                }
            });

            commit('setItems', items);
        }
    }
}
