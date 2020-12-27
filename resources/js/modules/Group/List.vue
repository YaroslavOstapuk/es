<template>
    <div>
        <h3 class="text-center mt-15">
            Останні новини сайту!
        </h3>
    </div>
</template>

<script>
import {mapActions, mapMutations} from 'vuex'

export default {
    async mounted() {
        await this.fetchMenuItem();
        this.setAppBarTitle('Новини');
        this.setCreateButtonTitle('Добавити групу');
        this.setCreateButtonUrl({
            name: 'groupsAdd'
        });
    },
    methods: {
        ...mapActions(['fetchMenuItem']),
        ...mapMutations([
            'setAppBarTitle',
            'setCreateButtonTitle',
            'setCreateButtonUrl'
        ])
    },
}
</script>
