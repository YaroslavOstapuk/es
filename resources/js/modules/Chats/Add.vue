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
                    label="Назва чату*"
                    :error-messages="errors ? errors.name : ''"
                ></v-text-field>
                <v-text-field
                    v-model="form.description"
                    label="Короткий опис"
                    :error-messages="errors ? errors.description : ''"
                ></v-text-field>
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
        }
    }),
    async mounted() {
        this.loader = true;
        await this.fetchMenuGroup({
            update: false,
            slug: this.$route.params.slug,
        });
        this.setAppBarTitle('Добавити додатковий чат');
        this.clearCreateButtonInfo();
        this.loader = false;
    },
    computed: {
        ...mapGetters({
            errors: 'getOtherChatError'
        })
    },
    methods: {
        ...mapActions([
            'fetchMenuGroup',
            'storeOtherChat'
        ]),
        ...mapMutations([
            'setAppBarTitle',
            'clearCreateButtonInfo'
        ]),
        async addEvent() {
            this.loading = true;

            let otherChat = await this.storeOtherChat({
                slug: this.$route.params.slug,
                data: this.form
            })

            if (otherChat) {
                this.$toast.open({
                    message: 'Додатковий чат створений!',
                    position: 'top-right',
                    type: 'success',
                });

                await this.fetchMenuGroup({
                    update: true,
                    slug: this.$route.params.slug,
                });

                this.$router.push({
                    name: 'groupsShow',
                    params: {
                        slug: this.$route.params.slug,
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
