<template>
    <div class="group">
        <v-row>
            <v-col
                cols="12"
            >
                <h3 v-if="!events.length" class="text-center mt-15">
                    Важливих подій поки не має!
                </h3>
                <v-alert
                    v-else
                    v-for="event in events"
                    :type="new Date(event.expire_at) < new Date() ? 'error' : 'success'"
                    prominent
                    :key="event.id"
                    class="pa-0 pl-6"
                >
                    <v-row align="center" class="text-center">
                        <v-col cols="4">
                            <div>
                                {{ event.name }}
                            </div>
                            <div>
                                {{ event.description }}
                            </div>
                        </v-col>
                        <v-col cols="4">
                            <div>
                                <div>Дата початку:</div>
                                <div>
                                    {{ format(event.start_at) }}
                                </div>
                            </div>
                        </v-col>
                        <v-col cols="4">
                            <div>
                                <div>Дата завершення:</div>
                                <div>
                                    {{ format(event.expire_at) }}
                                </div>
                            </div>
                        </v-col>
                    </v-row>
                </v-alert>
            </v-col>
        </v-row>
    </div>
</template>

<script>
import {mapActions, mapMutations} from 'vuex'
import {format, parseISO} from 'date-fns'

export default {
    data: () => ({
        group: null,
        events: []
    }),
    async mounted() {
        const slug = this.$route.params.slug;
        const group = await this.getGroup(slug);
        this.group = group.data;

        let events = await this.getEvents(slug);
        this.events = events.data;

        await this.fetchMenuGroup({
            update: true,
            slug: slug,
        });

        this.setAppBarTitle(`Група "${this.group.name}"`);
        this.clearCreateButtonInfo();
    },
    methods: {
        ...mapActions([
            'fetchMenuGroup',
            'getGroup',
            'getEvents',
        ]),
        ...mapMutations([
            'setAppBarTitle',
            'setTitle',
            'clearCreateButtonInfo',
        ]),
        format(dataTime) {
            let date = parseISO(dataTime, 'yyyy-MM-dd HH:mm:ss', new Date());

            return format(date, 'yyyy-MM-dd HH:mm');
        }
    },
}
</script>

<style scoped>

</style>
