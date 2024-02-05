<template>
    <footer class="footer pt-3  ">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-lg-between">
                <div class="col-lg-6 mb-lg-0 mb-4">
                    <div class="copyright text-center text-sm text-muted text-lg-end">
                        © {{new Date().getFullYear()}}
                        BAFFA,
                        developed by
                        <a href="http://www.aamrainfotainment.com" class="font-weight-bold" target="_blank"><img :src="addProjectPath('/front/assets/img/aamra.png')"> infotainment ltd.</a>
                        <!--                                {{ url('front/assets/img/aamra.png') }}-->
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
export default {
    name: "MemberFooter"
}
</script>

<style scoped>

</style>
