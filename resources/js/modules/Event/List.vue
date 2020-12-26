<template>
    <div class="group">
        <v-row>
            <v-col
                cols="12"
            >
                <v-alert
                    v-if="events"
                    v-for="event in events"
                    :type="new Date(event.expire_at) < new Date() ? 'error' : 'success'"
                    prominent
                    :key="event.id"
                >
                    <v-row align="center" class="text-center">
                        <v-col class="grow">
                            <div>
                                {{ event.name }}
                            </div>
                            <div>
                                {{ event.description }}
                            </div>
                        </v-col>
                        <v-col class="grow">
                            <div>
                                <div>Дата початку:</div>
                                <div>
                                    {{ format(event.start_at) }}
                                </div>
                            </div>
                        </v-col>
                        <v-col class="grow">
                            <div>
                                <div>Дата завершення:</div>
                                <div>
                                    {{ format(event.expire_at) }}
                                </div>
                            </div>
                        </v-col>
                        <v-col class="d-flex flex-row">
                            <v-btn
                            :to="{
                                name: 'eventsEdit',
                                params: {
                                    slug: slug,
                                    id: event.id,
                                    }
                                }"
                            >
                                Редагувати
                            </v-btn>
                            <v-btn @click="remove(event.id)" class="ml-2">
                                Видалити
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-alert>
                <span v-else>
                    Подій поки не має!
                </span>
            </v-col>
        </v-row>
    </div>
</template>

<script>
import {mapActions, mapMutations} from 'vuex'
import {format, parseISO} from 'date-fns'

export default {
    data: () => ({
        events: [],
        slug: null,
    }),
    async mounted() {
        this.slug = this.$route.params.slug;

        await this.fetchMenuGroup(this.slug);
        let events = await this.getEvents(this.slug);

        if (events) {
            this.events = events.data;
        }

        this.setAppBarTitle('Події в групі');
        this.setCreateButtonTitle('Добавити подію');
        this.setCreateButtonUrl({
            name: 'eventsAdd',
            params: {
                slug: this.slug
            }
        });
    }   ,
    methods: {
        ...mapActions([
            'fetchMenuGroup',
            'getEvents',
            'deleteEvent'
        ]),
        ...mapMutations([
            'setAppBarTitle',
            'setCreateButtonTitle',
            'setCreateButtonUrl'
        ]),
        async remove(id) {
            await this.deleteEvent(id);
            let events = await this.getEvents(this.slug);
            this.events = events.data;
        },
        format(dataTime) {
            let date = parseISO(dataTime, 'yyyy-MM-dd HH:mm:ss', new Date());

            return format(date, 'yyyy-MM-dd HH:mm');
        }
    },
}
</script>
