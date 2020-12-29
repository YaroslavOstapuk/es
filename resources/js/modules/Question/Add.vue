<template>
    <div class="event">
        <v-row>
            <v-col
                md="6"
                cols="12"
            >
                <v-text-field
                    v-model="form.title"
                    label="Заголовок питання"
                    :error-messages="errors ? errors.title : ''"
                ></v-text-field>
                <v-text-field
                    v-model="form.descriptions"
                    label="Короткий опис питання"
                    :error-messages="errors ? errors.descriptions : ''"
                ></v-text-field>
                <v-file-input
                    multiple
                    truncate-length="15"
                    accept="image/*"
                    label="Добавте файл/файли до вашого запитання"
                    v-model="form.photos"
                ></v-file-input>
                <div class="btn-store d-flex justify-end">
                    <v-btn
                        tile
                        color="success"
                        :loading="loading"
                        @click="addQuestion"
                    >
                        <v-icon left>
                            mdi-pencil
                        </v-icon>
                        Створити запитання
                    </v-btn>
                </div>
            </v-col>
        </v-row>
    </div>
</template>

<script>
import {mapActions, mapMutations, mapGetters} from 'vuex';

export default {
    data: () => ({
        loading: false,
        form: {
            title: null,
            descriptions: null,
            photos: null
        }
    }),
    async mounted() {
        await this.fetchMenuGroup(this.$route.params.slug);
        this.setAppBarTitle('Добавити запитання');
        this.clearCreateButtonInfo();
    },
    computed: {
        ...mapGetters({
            errors: 'getQuestionErrors'
        })
    },
    methods: {
        ...mapActions([
            'fetchMenuGroup',
            'storeQuestion'
        ]),
        ...mapMutations([
            'setAppBarTitle',
            'clearCreateButtonInfo'
        ]),
        async addQuestion() {
            this.loading = true;

            let formData = new FormData();
            formData.append('title', this.form.title ? this.form.title : '');
            formData.append('descriptions', this.form.descriptions ? this.form.descriptions : '');

            if (this.form.photos) {
                this.form.photos.forEach(item => {
                    formData.append('photos[]', item);
                });
            }

            let question = await this.storeQuestion({
                slug: this.$route.params.slug,
                data: formData
            });

            this.$toast.open('Запитання створено!', {
                position: 'top-right',
                type: 'success'
            });

            this.loading = false;
        }
    },
}
</script>

<style scoped>

</style>
