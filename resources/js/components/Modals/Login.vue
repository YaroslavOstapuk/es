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
                    v-bind="attrs"
                    v-on="on"
                >
                    Вхід
                </v-btn>
            </template>
            <v-card>
                <v-card-title>
                    <span class="headline">Вхід</span>
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
                                    v-model="form.password"
                                    label="Пароль *"
                                    required
                                    type="password"
                                    :error-messages="errors ? errors.password : ''"
                                ></v-text-field>
                            </v-col>
                            <v-col>
                                <span v-if="existingUser" class="red--text">Такого користувача не існує</span>
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
                                    @click="singIn"
                                >
                                    Увійти
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
import {mapActions, mapGetters} from 'vuex'

export default {
    data: () => ({
        dialog: false,
        form: {
            email: null,
            password: null,
        },
        loading: false,
    }),
    computed: {
        ...mapGetters({
            errors: 'getLoginError',
            existingUser: 'getNonExistentUser',
        })
    },
    methods: {
        ...mapActions([
            'login'
        ]),
        async singIn() {
            this.loading = true;
            if (await this.login(this.form)) {
                this.$router.push({ name: 'groups' });
            }
            this.loading = false;
        }
    },
}
</script>

<style lang="scss" scoped>

</style>
