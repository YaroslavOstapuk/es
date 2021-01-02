<template>
    <div class="group">
        <loader v-if="loader"></loader>
        <v-row v-else>
            <v-col
            cols="12"
            >
                <h3 v-if="!questions.length" class="text-center mt-15">
                    Запитання поки ніхто незадав!
                </h3>
                <v-card v-else>
                <v-list
                two-line
                >
                <template v-for="(question, index) in questions">
                    <v-divider
                        v-if="index != 0"
                        :inset="true"
                    ></v-divider>
                    <v-list-item
                        :key="index"
                        :to="{
                            name: 'questionsShow',
                            params: {
                                slug: slug,
                                id: question.id
                            }
                        }"
                        link
                        exact
                    >
                        <v-list-item-avatar>
                            <!-- <img :src="item.avatar"> -->
                        </v-list-item-avatar>
                        <v-list-item-content>
                            <v-list-item-title v-html="question.title"></v-list-item-title>
                            <v-list-item-subtitle v-html="question.descriptions"></v-list-item-subtitle>
                        </v-list-item-content>
                        <v-list-item-action class="mr-10 question-status" :class="colorStatus(question.status)">
                            {{ getMessageStatus(question.status) }}
                        </v-list-item-action>
                        <v-list-item-action>
                            <v-icon>mdi-message-text</v-icon>
                        </v-list-item-action>
                    </v-list-item>
                </template>
                </v-list>
            </v-card>
            </v-col>
        </v-row>
    </div>
</template>

<script>
import {mapActions, mapMutations} from 'vuex'

export default {
    data: () => ({
        questions: [],
        slug: null,
        loader: false,
    }),
    async mounted() {
        this.loader = true;
        let slug = this.$route.params.slug;
        this.slug = slug;

        await this.fetchMenuGroup({
            update: false,
            slug: slug,
        });
        let questions = await this.getQuestions(slug);

        if (questions) {
            this.questions = questions.data;
        }

        this.setAppBarTitle('Запитання');
        this.setCreateButtonTitle('Добавити своє запитання');
        this.setCreateButtonUrl({
            name: 'questionsAdd',
            params: {
                slug: slug
            }
        });
        this.loader = false;
    },
    methods: {
        ...mapActions([
            'fetchMenuGroup',
            'getQuestions'
        ]),
        ...mapMutations([
            'setAppBarTitle',
            'setCreateButtonTitle',
            'setCreateButtonUrl'
        ]),
        getMessageStatus(status) {
            if (status == 0) {
                return 'Нове запитання!';
            }
            if (status == 1) {
                return 'Вирішено!';
            }
            if (status == 2) {
                return 'Закрито!';
            }
        },
        colorStatus(status) {
            if (status == 0) {
                return 'question-green';
            }
            if (status == 1) {
                return 'question-orange';
            }
            if (status == 2) {
                return 'question-red';
            }
        }
    },
}
</script>

<style scoped>
    .question-status {
        width: 150px;
        font-size: 15px;
    }
    .question-green {
        color: #27a343;
    }
    .question-orange {
        color: #c2b925;
    }
    .question-red {
        color: #ff0000;
    }
</style>
