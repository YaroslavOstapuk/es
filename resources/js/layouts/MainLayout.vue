<template>
    <v-app id="inspire">

        <drawer :drawer="drawer"></drawer>

        <app-bar @toggle="drawer = !drawer"></app-bar>

        <v-main>
            <v-container fluid>
                <router-view></router-view>
            </v-container>
        </v-main>

        <v-footer app>
        </v-footer>
    </v-app>
</template>

<script>
import Drawer from "../components/Drawer";
import AppBar from "../components/AppBar";
import { mapActions } from 'vuex';

export default {
    data: () => ({
        drawer: true,
        slug: null,
    }),
    components: {
        Drawer,
        AppBar
    },
    methods: {
        ...mapActions(['groupSlug'])
    },
    watch: {
        $route(to, from) {
            if (to.params.slug) {
                this.groupSlug(to.params.slug);
            } else {
                this.groupSlug(to.params.slug);
            }
        }
    },
    mounted() {
        this.groupSlug(this.$route.params.slug);
    }
}
</script>
<style>
</style>
