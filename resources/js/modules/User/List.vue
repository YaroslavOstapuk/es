<template>
    <v-form>
        <loader v-if="loader"></loader>
        <v-row v-else>
            <v-col
                cols="12"
                sm="4"
            >
                <div class="groups">
                    <v-list
                        dense
                        nav
                    >
                        <v-list-item
                            v-for="user in users"
                            :key="user.id"
                            link
                        >
                            <v-list-item-avatar v-if="user.main_photo">
                                <v-img :src="user.main_photo.avatar"></v-img>
                            </v-list-item-avatar>

                            <v-list-item-content>
                                <v-list-item-title>{{ user.name }} {{ user.surname }}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </div>
            </v-col>
        </v-row>
    </v-form>
</template>

<script>
    import {mapActions, mapMutations} from 'vuex'

    export default {
        data: () => ({
            loader: false,
            slug: null,
            users: null,
        }),
        methods: {
            ...mapActions([
                'fetchMenuGroup',
                'getUsers'
            ]),
            ...mapMutations([
                'setAppBarTitle',
                'setCreateButtonTitle',
            ]),
        },
        async mounted() {
            this.loader = true;
            let slug = this.$route.params.slug;
            this.slug = slug;

            await this.fetchMenuGroup({
                update: false,
                slug: slug,
            });

            this.setAppBarTitle('Учасники групи');
            this.setCreateButtonTitle('');

            this.users = await this.getUsers(slug);

            this.loader = false;
        }
    }
</script>

<style scoped>

</style>
