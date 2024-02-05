<template>
    <div>
        <!--    <div v-if="validationErrors">-->
        <!--      <ul class="alert alert-danger">-->
        <!--        <li v-for="(value, index) in validationErrors">{{ index }}. {{ value }} </li>-->
        <!--      </ul>-->
        <!--    </div>-->
        <!--        <div class="alert alert-success alert-notification alert-dismissible fade show " v-if="success">-->
        <!--            <i class="fa fa-check"></i>-->
        <!--            {{ success }}-->
        <!--            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>-->
        <!--        </div>-->
        <!--        <div class="alert alert-danger alert-notification alert-dismissible fade show " v-if="errors">-->
        <!--            <b>Please correct the following error(s):</b>-->
        <!--            <ul class="list-unstyled mb-0">-->
        <!--                <li v-for="(value, key, index) in errors" :key="key">{{ index + 1 }}. {{ value[0] }}</li>-->
        <!--            </ul>-->
        <!--            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>-->
        <!--        </div>-->
        <!--        <div class="alert alert-danger alert-notification alert-dismissible fade show " v-if="message">-->
        <!--            <ul class="list-unstyled mb-0">-->
        <!--                <li>{{ message }}</li>-->
        <!--            </ul>-->
        <!--            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>-->
        <!--        </div>-->
        <b-alert v-model="showSuccess" variant="success" dismissible>
            {{ success }}
        </b-alert>
        <b-alert v-model="showErrors" variant="danger" dismissible>
            <b>Please correct the following error(s):</b>
            <ul class="list-unstyled mb-0">
                <li v-for="(value, key, index) in errors" :key="key">{{ index + 1 }}. {{ value[0] }}</li>
            </ul>
        </b-alert>
        <b-alert v-model="showMessage" variant="warning" dismissible>
            <ul class="list-unstyled mb-0">
                <li>{{ warning_message }}</li>
            </ul>
        </b-alert>
    </div>
</template>

<script>
export default {
    name: "ValidationErrors",
    props: ['errors', 'success','warning_message'],
    watch: {
        errors(){
            if(this.errors){
                this.showErrors = true
            }else{
                this.showErrors = false
            }
        },
        success(){
            if(this.success){
                this.showSuccess = true
            }
        },
        warning_message(){
            if(this.warning_message){
                this.showMessage = true
            }
        }
    },
    data: () => ({
        // message:this.warning_message,
        showSuccess: false,
        showErrors: false,
        showMessage: false,
    }),
    methods: {
        countDownChanged(dismissCountDown) {
            this.dismissCountDown = dismissCountDown
        }
    },
    created: function (){
        if(this.errors){
            this.showErrors = true
        }
        if(this.success){
            this.showSuccess = true
        }
        if(this.warning_message){
            this.showMessage = true
        }
    },
    computed: {
        // validationErrors() {
        //     let errors = Object.values(this.errors);
        //     errors = errors.flat();
        //     return errors;
        // }
    }
}
</script>

<style>
.alert-dismissible .close {
    position: absolute;
    top: 0;
    right: 0;
    padding: 0.75rem 1.25rem;
    color: inherit;
}
button.close {
    padding: 0;
    background-color: transparent;
    border: 0;
    -webkit-appearance: none;
}
.close {
    float: right;
    font-size: 1.5rem;
    font-weight: 700;
    line-height: 1;
    color: #000;
    text-shadow: 0 1px 0 #fff;
    opacity: .5;
}
</style>
