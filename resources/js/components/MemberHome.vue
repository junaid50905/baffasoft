<template>
    <div>
<!--        <router-view name="sidebar"></router-view>-->
        <sidebar v-if="window.Laravel" @setUsername="setUsername"/>
        <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
            <router-view :username="username" :role="role"></router-view>
            <member-footer></member-footer>
        </main>
<!--        <router-view name="helper"></router-view>-->
    </div>
</template>

<script>
import Sidebar from "./MemberSidebar";
import MemberFooter from "./MemberFooter";
export default {
    name: "MemberHome",
    components: {MemberFooter, Sidebar},
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
.main-content{
    //z-index:1000
}
</style>
