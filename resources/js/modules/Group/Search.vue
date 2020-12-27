<template>
    <v-form>
        <v-row>
            <v-col
                cols="12"
                sm="4"
            >
                <v-text-field
                    v-model="search"
                    label="Назва групи"
                    clearable
                ></v-text-field>
                <h3 v-if="!groups.length && start">
                    Таких груп не існує!
                </h3>
                <div class="groups" v-else>
                    <v-list
                        dense
                        nav
                    >
                        <v-list-item
                            v-for="group in groups"
                            :key="group.title"
                            link
                        >
                            <v-list-item-avatar v-if="group.main_photo">
                                <v-img :src="group.main_photo.avatar"></v-img>
                            </v-list-item-avatar>

                            <v-list-item-content>
                                <v-list-item-title>{{ group.name }}</v-list-item-title>
                            </v-list-item-content>

                            <v-list-item-content v-if="!group.is_subscribers">
                                <v-btn
                                    @click="subscribe(group.id)"
                                >
                                    Підписатись
                                </v-btn>
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
        start: false,
        search: null,
        groups: [],
    }),
    async mounted() {
        await this.fetchMenuItem();
        this.setAppBarTitle('Пошук групи');
        this.setCreateButtonTitle('');
    },
    watch: {
        async search() {
            this.start = true;

            let groups =  await this.searchGroup(this.search);

            if (groups.data) {
                this.groups = groups.data;
            }
        }
    },
    methods: {
        ...mapActions([
            'fetchMenuItem',
            'searchGroup',
            'subscribeToGroup'
        ]),
        ...mapMutations([
            'setAppBarTitle',
            'setCreateButtonTitle',
        ]),
        async subscribe(groupId) {
            let subscribe = await this.subscribeToGroup({
                group_id: groupId,
            });

            if (subscribe.status == 'ok') {
                this.$toast.open('Ви успішно підписались!', {
                    position: 'top-right',
                    type: 'success'
                });
                await this.fetchMenuItem();
                this.start = false;
                this.groups = [];
            }
        }
    },
}
</script>

<style scoped>

</style>
