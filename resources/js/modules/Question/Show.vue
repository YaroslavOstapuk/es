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
                            <div :class="{ 'd-flex flex-row-reverse align-center': msg.me }">
                                <v-menu offset-y>
                                    <template v-slot:activator="{ on }">
                                        <v-avatar>
                                            <img
                                                src="https://cdn.vuetifyjs.com/images/john.jpg"
                                                alt="John"
                                            >
                                        </v-avatar>
                                        <v-chip
                                            class="custom-chip-style"
                                        >
                                            {{ msg.content }}
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
                    <v-card-text class="flex-shrink-1">
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
                            hide-input
                            multiple
                            truncate-length="15"
                        ></v-file-input>
                    </v-card-text>
                </v-card>
            </v-responsive>
        </v-col>
    </v-row>
</template>

<script>
export default {
    data: () => ({
        messages: [
            {
                content: "lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum  lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum  lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum ",
                me: true,
                created_at: "11:11am"
            },
            {
                content: "dolor",
                me: false,
                created_at: "11:11am"
            },
            {
                content: "dolor",
                me: false,
                created_at: "11:11am"
            },
            {
                content: "dolor",
                me: false,
                created_at: "11:11am"
            },
            {
                content: "dolor",
                me: true,
                created_at: "11:11am"
            },
            {
                content: "dolor",
                me: false,
                created_at: "11:12am"
            },
            {
                content: "dolor",
                me: false,
                created_at: "11:14am"
            }
        ],
        message: {
            text: "",
        }
    }),
    methods: {
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
.container {
    padding: 0px;
}
</style>
