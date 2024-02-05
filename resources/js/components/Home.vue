<template>
    <div>
        <router-view name="sidebar"></router-view>
        <navbar v-if="window.Laravel" @setUsername="setUsername"/>
        <router-view :username="username" :role="role"></router-view>
        <router-view name="helper"></router-view>
    </div>
</template>

<script>
import Navbar from "./Navbar";
export default {
    name: "Home",
    components: {Navbar},
    data: () => ({
        window:window,
        username:null,
        role:null
    }),
    methods: {
        setUsername({role,username}) {
            this.role = role
            this.username = username
        }
    }
}
</script>

<style scoped>
</style>
<style>
@import "vue-select/dist/vue-select.css";
/*@import "vue-select/dist/vue-select.css";*/
#notification .alert {
    position: fixed;
    top: 72px;
    left: 0px !important;
    z-index: 1001;
}
</style>
<!--Copy From CancelIdCardForm.vue-->
<style>
@media print {
    #navbarBlur,.footer,#sidenav-main{
        display: none !important;
    }
}
</style>
<!--Copy From ViewTrainingDG.vue-->
<style>
@media print {
    body, page {
        margin: 0;
        box-shadow: none;
    }
    .sidebar{
        display: none !important;
    }
    .content-page{
        margin-left: 0px !important;
    }
    #printPDF {
        visibility: hidden;
        margin: 0;
        size: A4;
        margin: -7.5%;
    }
}
</style>
