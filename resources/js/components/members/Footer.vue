<template>
    <div>
        <footer v-for="n in company_owner" class="footer py-2">
            <div class="container">
                <div class="row">
                    <div class="col-8 mx-auto text-center mt-1">
                        <p class="mb-0 text-secondary small">
                            Copyright © {{today_value}} {{firmType}} - {{n}} - BAFFA, developed by <a href="http://www.aamrainfotainment.com" class="font-weight-bold" target="_blank"><img :src="addProjectPath('/front/assets/img/aamra.png')"> infotainment ltd.</a>
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<script>
export default {
    name: "Footer",
    props:['firmType'],
    watch: {
        firmType(){
            if(this.firmType == 'partnership'){
                this.company_owner = 2
            }else if(this.firmType == 'limited'){
                this.company_owner = 3
            }else{
                this.company_owner = 1
            }
            console.log('Hy...')
            console.log(this.company_owner)
        }
    },
    data(){
        return{
            today_value:'2022222',
            company_owner:1
        }
    }
}
</script>

<style scoped>

</style>
