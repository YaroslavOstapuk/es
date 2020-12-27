<template>
    <div class="main">
        <div class="main-wrapper">
            <div class="main-header">
                <div class="main-header__logo">
                    <img src="logo.png" alt="logo">
                </div>
                <login></login>
                <div class="main-header__product">
                    <span>Product:</span>
                    Ostapuk Yaroslav
                </div>
            </div>
            <div class="main-content">
                <h1 class="main-content__text">
                    Easy Study - сайт для легкого спілкування
                </h1>
                <register></register>
            </div>
        </div>
        <img src="images/book.png" class="main-book" alt="">
        <img src="images/circle.png" class="main-circle" alt="">
        <img src="images/points.png" class="main-points" alt="">
    </div>
</template>

<script>
import Login from "../components/Modals/Login";
import Register from "../components/Modals/Register"
import { getLocalUser } from '../helpers/auth'

export default {
    components: {
        Login,
        Register
    },
    mounted() {
        if (getLocalUser()) {
            this.$router.push({ name: 'groups' });
        }
    },
}
</script>

<style scoped>
body {
    background: #fbe5ee;
}
.main {
    height: 100vh;
    position: relative;
    background: #fbe5ee;
}
.main-book {
    width: 60%;
    position: absolute;
    bottom: 0;
    right: 50%;
    transform: translateX(50%);
    z-index: 900;
}
.main-circle {
    width: 100%;
    max-width: 700px;
    position: absolute;
    bottom: 0;
    right: 50%;
    transform: translateX(50%);
    z-index: 950;
}
.main-points {
    width: 100%;
    height: 100vh;
    position: absolute;
    top: 50%;
    right: 50%;
    transform: translate(50%, -50%);
    z-index: 960;
}
.main-header, .main-content {
    z-index: 1000;
    position: relative;
}
.main-wrapper {
    width: 100%;
    max-width: 1920px;
    margin: 0 auto;
}
.main-header {
    padding: 20px;
    display: flex;
    justify-content: space-between;
}
.main-header__logo img{
    position: relative;
    z-index: 1020;
    width: 70%;
}
.main-content {
    margin-top: 70px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}
.main-content__text {
    margin-bottom: 30px;
}
@media screen and (max-width: 480px) {
    .main-header {
        flex-direction: column;
        align-items: center;
    }
    .main-header__logo img {
        width: 100%;
    }
    .main-header__product {
        margin-top: 20px;
    }
    .main-content__text {
        text-align: center;
    }
    .main-book {
        width: 150%;
    }
    .main {
        overflow: hidden;
    }
}
</style>
