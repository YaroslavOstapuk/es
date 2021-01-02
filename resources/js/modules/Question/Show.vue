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
                    <div class="custom-select">
                        <v-select
                            :items="items"
                            label="Статус запитання"
                            solo
                            v-model="status"
                            @change="changeStatus"
                        ></v-select>
                    </div>
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
                                            <span v-if="msg.photos" v-for="photo in msg.photos">
                                                <a :href="photo.url" target="_blank">
                                                    <v-img
                                                        :src="photo.url"
                                                        max-height="150"
                                                        max-width="250"
                                                    >
                                                    </v-img>
                                                </a>
                                            </span>
                                        </v-chip>
                                        <span class="custom-chip-time">{{ format(msg.created_at) }}</span>
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
                            accept="image/*"
                            class="file_loader"
                            v-model="photos"
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
import {format, parseISO} from 'date-fns'

export default {
    data: () => ({
        loader: false,
        loading: false,
        question: [],
        messages: [],
        photos: [],
        message: {
            text: "",
        },
        items: [
            'Нове запитання',
            'Вирішене',
            'Закрите'
        ],
        status: null,
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
        await this.fetchMenuGroup({
            update: false,
            slug: this.$route.params.slug,
        });

        let answers = await this.getAnswers(this.$route.params.id);
        this.messages = answers.data;
        let question = await this.getQuestion(this.$route.params.id);
        this.question = question;
        this.status = this.items[question.status];

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
            'change'
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

                let formData = new FormData();
                formData.append('message', this.message.text ? this.message.text : '');

                if (this.photos) {
                    this.photos.forEach(item => {
                        formData.append('photos[]', item);
                    });
                }

                await this.sendAnswers({
                    id: this.$route.params.id,
                    data: formData
                });

                this.message.text = '';
                this.photos = [];
                let answers = await this.getAnswers(this.$route.params.id);
                this.messages = answers.data;
                this.loading = false;
            }
        },
        getStatusId(statusName) {
            if (statusName == 'Нове запитання') {
                return 0;
            } else if (statusName == 'Вирішене') {
                return 1;
            } else {
                return 2;
            }
        },
        async changeStatus() {
            await this.change({
                id: this.$route.params.id,
                data: {
                    status: this.getStatusId(this.status),
                }
            });
            this.$toast.open({
                message: 'Статус оновлено!',
                position: 'top-right',
                type: 'success'
            });
        },
        format(dataTime) {
            let date = parseISO(dataTime, 'yyyy-MM-dd HH:mm:ss', new Date());

            return format(date, 'HH:mm');
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
.custom-select {
    padding-left: 16px;
    padding-top: 16px;
    max-width: 300px;
}
.custom-select .v-text-field__details {
    display: none;
}
</style>
