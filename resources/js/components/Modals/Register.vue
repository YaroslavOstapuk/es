<template>
    <div>
        <v-dialog
            v-model="dialog"
            max-width="400px"
        >
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                    color="primary"
                    dark
                    large
                    v-bind="attrs"
                    v-on="on"
                >
                    Реєстрація
                </v-btn>
            </template>
            <v-card>
                <v-card-title>
                    <span class="headline">Зареєструватися</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col
                                cols="12"
                            >
                                <v-text-field
                                    v-model="form.email"
                                    label="Email *"
                                    required
                                    :error-messages="errors ? errors.email : ''"
                                ></v-text-field>
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
                                    v-model="form.password"
                                    label="Пароль *"
                                    required
                                    type="password"
                                    :error-messages="errors ? errors.password : ''"
                                ></v-text-field>
                                <v-text-field
                                    v-model="form.password_confirmation"
                                    label="Повторіть пароль *"
                                    required
                                    type="password"
                                    :error-messages="errors ? errors.password_confirmation : ''"
                                ></v-text-field>
                            </v-col>
                            <v-col
                                cols="12"
                                class="d-flex justify-end"
                            >
                                <v-btn
                                    color="blue darken-1"
                                    text
                                    @click="dialog = false"
                                >
                                    Закрити
                                </v-btn>
                                <v-btn
                                    color="success"
                                    :loading="loading"
                                    @click="registerUser"
                                >
                                    Зареєструватися
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex';

export default {
    data: () => ({
        loading: false,
        dialog: false,
        form: {
            email: null,
            name: null,
            surname: null,
            password: null,
            password_confirmation: null,
        },
    }),
    computed: {
        ...mapGetters({
            errors: 'getRegisterError'
        })
    },
    methods: {
        ...mapActions([
            'register'
        ]),
        async registerUser() {
            this.loading = true;
            if (await this.register(this.form)) {
                this.$router.push({ name: 'groups' });
            }
            this.loading = false;
        }
    },
}
</script>

<style lang="scss" scoped>

</style>
