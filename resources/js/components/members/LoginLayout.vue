<template>
    <div>
        <nav
            class="navbar navbar-expand-lg position-absolute top-0 z-index-3 w-100 shadow-none my-3  navbar-transparent mt-4">
            <div class="container">
                <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 text-white" :href="addProjectPath('/')">
                    <img :src="addProjectPath('/front/assets/img/logo.png')" height="50">
                </a>
            </div>
        </nav>
        <!-- End Navbar -->
        <section class="min-vh-100 mb-8">
            <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg"
                 v-bind:style="{'backgroundImage': 'url(' + addProjectPath('/front/assets/img/curved-images/curved14.jpg') + ')'}">
                <span class="mask bg-gradient-dark opacity-6"></span>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 text-center mx-auto">
                            <h1 class="text-white mb-2 mt-5">Welcome !</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row mt-lg-n10 mt-md-n11 mt-n10">
                    <router-view></router-view>
                </div>
            </div>
        </section>
        <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
        <footer class="footer py-2">
            <div class="container">
                <div class="row">
                    <div class="col-8 mx-auto text-center mt-1">
                        <p class="mb-0 text-secondary small">
                            Copyright © 2021 BAFFA, developed by <a href="http://www.aamrainfotainment.com"
                                                                    class="font-weight-bold" target="_blank"><img
                            :src="addProjectPath('/front/assets/img/aamra.png')"> infotainment ltd.</a>
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<script>
export default {
    name: "MembersHome"
}
</script>

<style scoped>

</style>
