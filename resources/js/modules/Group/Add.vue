<template>
    <div class="group">
        <v-row>
            <v-col
                md="6"
                cols="12"
            >
                <v-text-field
                    v-model="form.name"
                    label="Назва групи *"
                    :error-messages="errors ? errors.name : ''"
                ></v-text-field>
                <v-text-field
                    v-model="form.description"
                    label="Короткий опис групи"
                ></v-text-field>
                <v-text-field
                    v-model="form.slug"
                    label="Слаг"
                    :error-messages="errors ? errors.slug : ''"
                ></v-text-field>
                <v-file-input
                    v-model="form.main_photo"
                    accept="image/*"
                    label="Фото групи"
                    :error-messages="errors ? errors.main_photo : ''"
                ></v-file-input>
                <div class="btn-store d-flex justify-end">
                    <v-btn
                        tile
                        color="success"
                        :loading="loading"
                        @click="createNewGroup"
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
import {mapActions, mapMutations, mapGetters} from 'vuex'

export default {
    data: () => ({
        loading: false,
        form: {
            name: null,
            description: null,
            slug: null,
            main_photo: null,
        }
    }),
    async mounted() {
        await this.fetchMenuItem();
        this.clearCreateButtonInfo();
        this.setAppBarTitle('Створити нову групу');
    },
    computed: {
        ...mapGetters({
            errors: 'getCreateGroupErrors'
        })
    },
    methods: {
        ...mapActions([
            'fetchMenuItem',
            'storeGroup'
        ]),
        ...mapMutations([
            'setAppBarTitle',
            'clearCreateButtonInfo'
        ]),
        async createNewGroup() {
            this.loading = true;
            let formData = new FormData();
            formData.append('name', this.form.name ? this.form.name : '');
            formData.append('description', this.form.description ? this.form.description : '');
            formData.append('slug', this.form.slug ? this.form.slug : '');
            formData.append('main_photo', this.form.main_photo ? this.form.main_photo : '');

            const group = await this.storeGroup(formData);

            if (group) {
                this.$toast.open('Група успішно створена!', {
                    position: 'top-right',
                    type: 'success'
                });
                this.$router.push({ name: 'groupsEdit', params: { slug: group.data.slug } });
            }

            this.loading = false;
        }
    },
}
</script>

<style scoped>

</style>
