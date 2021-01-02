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
                <div class="main-photo" v-if="form.photo && !form.main_photo">
                    <img :src="form.photo" alt="">
                </div>
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
                        Зберігти зміни
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
            photo: null,
        }
    }),
    async mounted() {
        await this.fetchMenuItem();
        this.clearCreateButtonInfo();
        this.setAppBarTitle('Редагувати групу');

        let group = await this.getGroup(this.$route.params.slug);
        this.form.name = group.data.name;
        this.form.description = group.data.description;
        this.form.slug = group.data.slug;
        this.form.photo = group.data.main_photo.avatar;
    },
    computed: {
        ...mapGetters({
            errors: 'getCreateGroupErrors'
        })
    },
    methods: {
        ...mapActions([
            'fetchMenuItem',
            'updateGroup',
            'getGroup'
        ]),
        ...mapMutations([
            'setAppBarTitle',
            'clearCreateButtonInfo'
        ]),
        async createNewGroup() {
            this.loading = true;
            let formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('name', this.form.name ? this.form.name : '');
            formData.append('description', this.form.description ? this.form.description : '');
            formData.append('slug', this.form.slug ? this.form.slug : '');
            formData.append('main_photo', this.form.main_photo ? this.form.main_photo : '');

            const group = await this.updateGroup({
                slug: this.$route.params.slug,
                data: formData
            });

            this.$toast.open({
                message: 'Дані оновлено!',
                type: 'info',
            });

            this.loading = false;
        }
    },
}
</script>

<style scoped>

</style>
