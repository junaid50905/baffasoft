<template>
    <div>
        <input type="file" :disabled="name == 'no_upload'" class="form-control" :name="name" :id="name" v-on:change="saveImage">
        <span v-if="temp_image_name">
            <span v-if="temp_image_type.includes('image')">
                <img :src="temp_image" :alt="alt">
            </span>
        </span>
        <span v-if="typeof src === 'string'">
            <a v-if="src.slice(-3) === 'PDF'" :href="assetPath('/'+src)" target="_blank">Attachment</a>
            <img v-else :src="assetPath('/'+src)" :alt="alt">
        </span>
    </div>
</template>

<script>
export default {
    name: "ImageTag",
    props: ['alt', 'name', 'src'],
    watch: {
        src(){
            if(!this.src){
                this.temp_image = null;
                this.temp_image_type = null;
                this.temp_image_name = null;
            }
            if(this.src == 'null'){
                this.src = null
            }
        }
    },
    data: () => ({
        temp_image: null,
        temp_image_type: null,
        temp_image_name: null,
        HTMLcontent: null,
        images: {
            attach_e_tin_certificate: null,
            attach_vat_registration_certificate: null
        }
    }),
    methods: {
        saveImage: function (event) {
            this.temp_image_name = event.target.files[0].name;
            if (this.temp_image_name) {
                this.temp_image_type = event.target.files[0].type;
                const reader = new FileReader
                reader.onload = e => {
                    this.temp_image = e.target.result;
                }
                reader.readAsDataURL(event.target.files[0]);
            }
            this.$emit('saveImage', event);
        }
    }
}
</script>

<style scoped>
img {
    width: 100px;
    height: 100px;
}

</style>
