<template>
    <div class="main-loader">
        <v-progress-circular
            :size="70"
            :width="7"
            color="purple"
            indeterminate
        ></v-progress-circular>
    </div>
</template>

<script>
export default {
name: "Loader"
}
</script>

<style scoped>
.main-loader {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
</style>
