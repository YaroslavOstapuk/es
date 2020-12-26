<template>
    <v-app-bar app>
        <v-app-bar-nav-icon @click="$emit('toggle')"></v-app-bar-nav-icon>

        <v-toolbar-title>{{ getAppBarTitle }}</v-toolbar-title>

        <v-spacer></v-spacer>

        <v-btn
            v-if="getCreateButtonTitle && getCreateButtonUrl"
            tile
            color="success"
            :to="getCreateButtonUrl"
        >
            <v-icon left>
                mdi-pencil
            </v-icon>
            {{ getCreateButtonTitle }}
        </v-btn>

    </v-app-bar>
</template>

<script>
import {mapGetters} from 'vuex'

export default {
    computed: {
        ...mapGetters([
            'getAppBarTitle',
            'getCreateButtonTitle',
            'getCreateButtonUrl'
        ])
    },
}
</script>

<style scoped>

</style>
