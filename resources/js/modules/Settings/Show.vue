<template>
    <div>
        <v-row>
            <loader v-if="loading"></loader>
            <v-col cols="12" md="4" v-else>
                <v-btn
                    :to="{
                    name: 'groupsEdit',
                    params: {
                        slug: slug,
                    }
                }"
                >
                    Редагувати дані групи
                </v-btn>
                <h4 class="mt-10">Додаткові чати:</h4>
                <h5 class="mt-3" v-if="!chats.length">
                    Додаткових чатів поки не має, але ми легко можете його створити!
                </h5>
                <v-list-item
                    v-else
                    v-for="chat in chats"
                    :key="chat.id"
                    link
                >
                    <v-list-item-icon>
                        <v-icon>mdi-chat</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title>{{ chat.name }}</v-list-item-title>
                    </v-list-item-content>

                    <v-list-item-action @click="deleteGroupChat(chat.id)">
                        <v-icon>mdi-close</v-icon>
                    </v-list-item-action>
                </v-list-item>
                <v-btn class="mt-10"
                       :to="{
                    name: 'chatsAdd',
                    params: {
                        slug: slug,
                    }
                }"
                >
                    Добавити новий додатковий чат
                </v-btn>
            </v-col>
        </v-row>
        <v-row v-if="chats.length">
            <v-col
                cols="12">
                <h4 class="mt-10"> Дати доступ до додаткового чату:</h4>
            </v-col>
        </v-row>
        <v-row v-if="chats.length" class="align-center">
            <v-col cols="12" md="3">
                <v-text-field
                    label="Email"
                    :error-messages="errors ? errors.email : ''"
                    v-model="form.email"
                ></v-text-field>
            </v-col>
            <v-col cols="2" md="1">
                <span>в чат:</span>
            </v-col>
            <v-col cols="12" md="3">
                <v-select
                    :error-messages="errors ? errors.chat_id : ''"
                    v-model="form.chat_id"
                    :items="chats"
                    item-text="name"
                    item-value="id"
                    label="Виберіть чат"
                ></v-select>
            </v-col>
            <v-col cols="3">
                <v-btn @click="inviteUser" :loading="sending">
                    Запросити
                </v-btn>
            </v-col>
        </v-row>
    </div>
</template>

<script>
    import {mapActions, mapMutations, mapGetters} from 'vuex'

    export default {
        data: () => ({
            slug: null,
            loading: false,
            sending: false,
            chats: [],
            form: {
                email: null,
                chat_id: null,
            }
        }),
        async mounted() {
            this.loading = true;

            this.slug = this.$route.params.slug;

            await this.fetchMenuGroup({
                update: false,
                slug: this.slug,
            });

            this.chats = await this.getOtherChat(this.slug);

            this.setAppBarTitle('Налаштування групи');
            this.setCreateButtonTitle('');

            this.loading = false;
        },
        computed: {
            ...mapGetters({
                errors: 'getInviteErrors'
            }),
        },
        methods: {
            ...mapActions([
                'fetchMenuGroup',
                'getOtherChat',
                'deleteChat',
                'invite',
            ]),
            ...mapMutations([
                'setAppBarTitle',
                'setCreateButtonTitle',
                'setCreateButtonUrl'
            ]),
            async deleteGroupChat(chatId) {
                let msg = confirm('Видалити чат?');

                if (msg) {
                    await this.deleteChat(chatId);

                    this.$toast.open({
                        message: 'Чат видалено!',
                        type: 'success',
                    });

                    await this.fetchMenuGroup({
                        update: true,
                        slug: this.slug,
                    });

                    this.chats = await this.getOtherChat(this.slug);
                }
            },
            async inviteUser() {
                this.sending = true;
                let status = await this.invite(this.form);

                if (status.status == 'ok') {
                    this.$toast.open({
                        message: 'Запрошення надіслано!',
                        position: 'top-right',
                        type: 'success',
                    });
                }

                this.form.email = null;
                this.form.chat_id = null;
                this.sending = false;
            }
        }
    }
</script>

<style scoped>

</style>
