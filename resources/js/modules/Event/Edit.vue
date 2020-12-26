<template>
    <div class="event">
        <v-row>
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
                        Зберігти зміни
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
        form: {
            _method: 'PUT',
            name: null,
            description: null,
            start_at: null,
            expire_at: null,
        }
    }),
    async mounted() {
        await this.fetchMenuGroup(this.$route.params.slug);
        this.setAppBarTitle('Редагувати подію');
        this.clearCreateButtonInfo();

        let event = await this.getEvent(this.$route.params.id);

        this.form.name = event.data.name;
        this.form.description = event.data.description;
        this.form.start_at = event.data.start_at;
        this.form.expire_at = event.data.expire_at;
    },
    computed: {
        ...mapGetters({
            errors: 'getEventErrors'
        })
    },
    methods: {
        ...mapActions([
            'fetchMenuGroup',
            'updateEvent',
            'getEvent'
        ]),
        ...mapMutations([
            'setAppBarTitle',
            'clearCreateButtonInfo'
        ]),
        async addEvent() {
            this.loading = true;

            let event = await this.updateEvent({
                id: this.$route.params.id,
                data: this.form
            })

            this.loading = false;
        }
    },
}
</script>

<style scoped>

</style>
