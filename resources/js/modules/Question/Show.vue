<template>
    <v-row class="no-gutters elevation-4">
        <v-col
            cols="auto"
            class="flex-grow-1 flex-shrink-0"
        >
            <v-responsive
                class="overflow-y-hidden fill-height"
            >
                <v-card
                    flat
                    class="d-flex flex-column fill-height"
                >
                    <v-card-title>
                        Тема чату
                    </v-card-title>
                    <v-card-text class="flex-grow-1 overflow-y-auto">
                        <template v-for="(msg, i) in messages">
                            <div :class="{ 'd-flex flex-row-reverse align-center': user.id === msg.user.id }">
                                <v-menu offset-y>
                                    <template v-slot:activator="{ on }">
                                        <v-avatar>
                                            <img
                                                :src="msg.user.main_photo.avatar"
                                                alt="John"
                                            >
                                        </v-avatar>
                                        <v-chip
                                            class="custom-chip-style"
                                        >
                                            {{ msg.message }}
                                            <sub
                                                class="ml-2"
                                                style="font-size: 0.5rem;"
                                            >{{ msg.created_at }}</sub>
                                        </v-chip>
                                    </template>
                                </v-menu>
                            </div>
                        </template>
                    </v-card-text>
                    <v-col cols="8" sm="5" class="d-flex align-center">
                        <v-text-field
                            v-model="message.text"
                            clear-icon="mdi-close-circle"
                            clearable
                            label="Повідомлення"
                            type="text"
                            @click:append-outer="sendMessage"
                            @click:clear="clearMessage"
                        ></v-text-field>
                        <v-file-input
                            class="file_loader"
                            hide-input
                            multiple
                        ></v-file-input>
                        <v-btn @click="sendMessage">
                            <v-icon>
                                mdi-send
                            </v-icon>
                        </v-btn>
                    </v-col>
                </v-card>
            </v-responsive>
        </v-col>
    </v-row>
</template>

<script>
import {mapActions, mapMutations, mapGetters} from 'vuex'

export default {
    data: () => ({
        messages: [],
        message: {
            text: "",
        }
    }),
    async mounted() {
        await this.fetchMenuGroup(this.$route.params.slug);
        let answers = await this.getAnswers(this.$route.params.id);
        this.messages = answers.data;

        this.setAppBarTitle('Новини');
        this.setCreateButtonTitle('Добавити групу');
        this.setCreateButtonUrl({
            name: 'groupsAdd'
        });
    },
    computed: {
        ...mapGetters({
            user: 'currentUser'
        })
    },
    methods: {
        ...mapActions([
            'fetchMenuGroup',
            'getAnswers'
        ]),
        ...mapMutations([
            'setAppBarTitle',
            'setCreateButtonTitle',
            'setCreateButtonUrl'
        ]),
        clearMessage() {
            this.message.text = ''
        },
        sendMessage() {

        }
    }
}
</script>

<style>
.custom-chip-style {
    padding: 10px;
    height: auto !important;
    white-space: normal;
    max-width: 400px;
}
.file_loader {
    padding: 0px;
    margin: 0px;
    flex: unset;
}
</style>
