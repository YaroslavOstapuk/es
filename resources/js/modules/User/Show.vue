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
                    label="Імя *"
                    required
                    :error-messages="errors ? errors.name : ''"
                ></v-text-field>
                <v-text-field
                    v-model="form.surname"
                    label="Прізвище *"
                    required
                    :error-messages="errors ? errors.surname : ''"
                ></v-text-field>
                <v-text-field
                    v-model="form.email"
                    label="Email *"
                    required
                    :error-messages="errors ? errors.email : ''"
                ></v-text-field>
                <v-text-field
                    v-model="form.password"
                    label="Новий пароль"
                    required
                    type="password"
                    :error-messages="errors ? errors.password : ''"
                ></v-text-field>
                <v-text-field
                    v-model="form.password_confirmation"
                    label="Повторіть новий пароль"
                    required
                    type="password"
                    :error-messages="errors ? errors.password_confirmation : ''"
                ></v-text-field>

                <div class="main-photo" v-if="form.main_photo && !form.new_photo">
                    <img :src="form.main_photo.avatar" alt="">
                </div>

                <v-file-input
                    label="Виберіть нове фото (якщо потрібно)"
                    v-model="form.new_photo"
                    truncate-length="15"
                ></v-file-input>

                <div class="btn-store d-flex justify-end">
                    <v-btn
                        tile
                        color="success"
                        :loading="loading"
                        @click="UpdateUserData"
                    >
                        <v-icon left>
                            mdi-pencil
                        </v-icon>
                            Зберегти
                    </v-btn>
                </div>
            </v-col>
        </v-row>
    </div>
</template>

<script>
    import { mapActions, mapGetters, mapMutations } from 'vuex';

    export default {
        data: () => ({
            loader: false,
            loading: false,
            form: {
                name: null,
                surname: null,
                email: null,
                password: null,
                password_confirmation: null,
                main_photo: null,
                new_photo: null,
            }
        }),
        computed: {
            ...mapGetters({
                errors: 'userErrors'
            })
        },
        methods: {
            ...mapActions([
                'fetchMenuItem',
                'getUser',
                'updateUser',
            ]),
            ...mapMutations([
                'setAppBarTitle',
                'clearCreateButtonInfo',
            ]),
            async UpdateUserData() {
                this.loading = true;
                let formData = new FormData();
                formData.append('name', this.form.name ? this.form.name : '');
                formData.append('surname', this.form.surname ? this.form.surname : '');
                formData.append('email', this.form.email ? this.form.email : '');
                formData.append('password', this.form.password ? this.form.password : '');
                formData.append('password_confirmation', this.form.password_confirmation ? this.form.password_confirmation : '');
                formData.append('new_photo', this.form.new_photo ? this.form.new_photo : '');

                this.form = await this.updateUser(formData);

                this.$toast.open({
                    message: 'Дані оновлено!',
                    type: 'info',
                });
                this.loading = false;
            }
        },
        async mounted() {
            this.loader = true;
            await this.fetchMenuItem();
            this.setAppBarTitle('Редагувати профіль');
            this.clearCreateButtonInfo('');
            this.form = await this.getUser();
            this.loader = false;
        }
    }
</script>

<style scoped>

</style>
