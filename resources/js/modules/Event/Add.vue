<template>
    <div class="event">
        <loader v-if="loader"></loader>
        <v-row v-else>
            <v-col
                md="6"
                cols="12"
            >
                <v-text-field
                    v-model="form.name"
                    label="Назва події"
                    :error-messages="errors ? errors.name : ''"
                ></v-text-field>
                <v-text-field
                    v-model="form.description"
                    label="Короткий опис події"
                    :error-messages="errors ? errors.description : ''"
                ></v-text-field>
                <v-datetime-picker
                    label="Дата та час початку події"
                    v-model="form.start_at"
                    :errors="errors ? errors.start_at : ''"
                >
                    <template slot="dateIcon">
                        <v-icon>fas fa-calendar</v-icon>
                    </template>
                    <template slot="timeIcon">
                        <v-icon>fas fa-clock</v-icon>
                    </template>
                </v-datetime-picker>
                <v-datetime-picker
                    label="Дата та час кінця події"
                    v-model="form.expire_at"
                    :errors="errors ? errors.expire_at : ''"
                >
                    <template slot="dateIcon">
                        <v-icon>fas fa-calendar</v-icon>
                    </template>
                    <template slot="timeIcon">
                        <v-icon>fas fa-clock</v-icon>
                    </template>
                </v-datetime-picker>
                <div class="btn-store d-flex justify-end">
                    <v-btn
                        tile
                        color="success"
                        :loading="loading"
                        @click="addEvent"
                    >
                        <v-icon left>
                            mdi-pencil
                        </v-icon>
                        Створити
                    </v-btn>
                </div>
            </v-col>
        </v-row>
    </div>
</template>

<script>
import {mapActions, mapMutations, mapGetters} from 'vuex';
import '@fortawesome/fontawesome-free/css/all.css';

export default {
    data: () => ({
        loading: false,
        loader: false,
        form: {
            name: null,
            description: null,
            start_at: null,
            expire_at: null,
        }
    }),
    async mounted() {
        this.loader = true;
        await this.fetchMenuGroup({
            update: false,
            slug: this.$route.params.slug,
        });
        this.setAppBarTitle('Добавити подію');
        this.clearCreateButtonInfo();
        this.loader = false;
    },
    computed: {
        ...mapGetters({
            errors: 'getEventErrors'
        })
    },
    methods: {
        ...mapActions([
            'fetchMenuGroup',
            'storeEvent'
        ]),
        ...mapMutations([
            'setAppBarTitle',
            'clearCreateButtonInfo'
        ]),
        async addEvent() {
            this.loading = true;

            let event = await this.storeEvent({
                slug: this.$route.params.slug,
                data: this.form
            })

            if (event) {
                this.$toast.open({
                    message: 'Подія успішно створена!',
                    position: 'top-right',
                    type: 'success'
                });

                this.$router.push({
                    name: 'eventsEdit',
                    params: {
                        slug: this.$route.params.slug,
                        id: event.data.id
                    }
                })
            }

            this.loading = false;
        }
    },
}
</script>

<style scoped>

</style>
