<template>
    <v-navigation-drawer
        app
        v-model="drawer"
    >
        <v-list-item>
            <v-list-item-content>
                <v-list-item-title class="title">
                    {{ getTitle }}
                </v-list-item-title>
                <v-list-item-subtitle>
                    {{ getSubtitle }}
                </v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>

        <v-divider></v-divider>

        <v-list
            dense
            nav
        >
            <v-list-item
                v-for="item in items"
                :key="item.title"
                :to="item.route"
                link
            >
                <v-list-item-avatar v-if="item.avatar">
                    <v-img :src="item.avatar"></v-img>
                </v-list-item-avatar>

                <v-list-item-icon v-if="item.icon">
                    <v-icon v-text="item.icon"></v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>{{ item.name }}</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-list-item
                :to="{ name: 'groupsSearch' }"
            >
                <v-list-item-content>
                    <v-list-item-title>Пошук групи</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-list-item
                :to="{ name: 'groups' }"
            >
                <v-list-item-content>
                    <v-list-item-title>Мої групи</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list>
        <template v-slot:append>
            <div class="pa-2">
                <v-btn block class="mb-2" v-if="getActiveGroupSlug" @click="unsubscribe">
                    Відписатись від групи
                </v-btn>
                <v-btn block @click="logout">
                    Вийти
                </v-btn>
            </div>
        </template>
    </v-navigation-drawer>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
    props: {
        drawer: {
        }
    },
    computed: {
        ...mapGetters([
            'items',
            'getTitle',
            'getSubtitle',
            'getActiveGroupSlug',
        ])
    },
    methods: {
        ...mapActions(['unsubscribeFromGroup', 'logoutInApp']),

        async unsubscribe() {
            let unsubscribe = await this.unsubscribeFromGroup({
                slug: this.getActiveGroupSlug
            })

            if (unsubscribe.status == 'ok') {
                this.$toast.open('Ви відписались від групи!', {
                    position: 'top-right',
                    type: 'default',
                });

                this.$router.push({ name: 'groups' });
            }
        },
        async logout() {
            await this.logoutInApp();

            this.$toast.open('Ви вийшли з системи!', {
                position: 'top-right',
                type: 'info',
            });

            this.$router.push({ name: 'home' });
        }
    }
}
</script>

<style scoped>

</style>
