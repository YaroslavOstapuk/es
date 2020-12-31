<template>
    <v-row class="no-gutters elevation-4">
        <loader v-if="loader"></loader>
        <v-col v-else
            cols="auto"
            class="flex-grow-1 flex-shrink-0"
            ref="block"
        >
            <v-responsive
                class="overflow-y-hidden fill-height"
            >
                <v-card
                    flat
                    class="d-flex flex-column fill-height"
                >
                    <div v-if="question">
                        <v-card-title>
                            {{ question.title }}
                        </v-card-title>

                        <v-card-text>
                            {{ question.descriptions }}
                        </v-card-text>

                        <p v-for="photo in question.photos" class="add-photos">
                            <a :href="photo.url" target="_blank">{{ photo.name }}</a>
                        </p>
                    </div>

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
                                            <span class="custom-chip-name">{{ msg.user.name }}</span>
                                            <p class="custom-chip-message">{{ msg.message }}</p>
                                        </v-chip>
                                        <span class="custom-chip-time">10:49</span>
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
                        <v-btn @click="sendMessage" :loading="loading">
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
        loader: false,
        loading: false,
        question: [],
        messages: [],
        message: {
            text: "",
        }
    }),
    watch: {
        messages() {
            setTimeout(() => {
                window.scrollTo(0,document.body.scrollHeight);
            });
        }
    },
    async mounted() {
        this.loader = true;
        await this.fetchMenuGroup(this.$route.params.slug);
        let answers = await this.getAnswers(this.$route.params.id);
        this.messages = answers.data;
        this.question = await this.getQuestion(this.$route.params.id);

        this.setAppBarTitle('Питання');
        this.setCreateButtonTitle('');
        this.loader = false;
    },
    computed: {
        ...mapGetters({
            user: 'currentUser'
        })
    },
    methods: {
        ...mapActions([
            'fetchMenuGroup',
            'getAnswers',
            'sendAnswers',
            'getQuestion',
        ]),
        ...mapMutations([
            'setAppBarTitle',
            'setCreateButtonTitle',
            'setCreateButtonUrl'
        ]),
        clearMessage() {
            this.message.text = ''
        },
        async sendMessage() {
            if (this.message.text) {
                this.loading = true;
                await this.sendAnswers({
                    id: this.$route.params.id,
                    data: {
                        message: this.message.text
                    }
                });
                this.message.text = '';
                let answers = await this.getAnswers(this.$route.params.id);
                this.messages = answers.data;
                this.loading = false;
            }
        }
    }
}
</script>

<style>
.custom-chip-style {
    background: #e0e0e05e !important;
    margin-top: 5px;
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
.custom-chip-style .v-chip__content {
    display: flex;
    flex-direction: column;
    align-items: end;
}
.custom-chip-style .v-chip__content p {
    margin-bottom: 0;
}
.custom-chip-time {
    margin: 0 5px;
}
.custom-chip-name {
    font-weight: 600;
    margin-bottom: 5px;
}
.custom-chip-message {
    font-size: 16px;
}
.add-photos {
    padding: 0 16px;
}
</style>
