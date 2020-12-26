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

export default {
    data: () => ({
        drawer: true
    }),
    components: {
        Drawer,
        AppBar
    }
}
</script>
<style>
</style>
