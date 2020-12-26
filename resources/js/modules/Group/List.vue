<template>
    <div>
        Останні новини сайту!
    </div>
</template>

<script>
import {mapActions, mapMutations} from 'vuex'

export default {
    async mounted() {
        await this.fetchMenuItem();
        this.setAppBarTitle('Події в групі');
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
