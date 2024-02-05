<template>
    <b-container class="bv-example-row">
        <div class="d-flex flex-row justify-content-around">
            <div><h3>Voter ID Card Casting</h3></div>
            <div><h5>Location : {{location}}</h5></div>
        </div>
<!--        <b-row>
            <b-col></b-col>
            <b-col align-self="center"><h1>Voter ID Card Casting</h1></b-col>
            <b-col align-self="center"><h5>Location : {{location}}</h5></b-col>
        </b-row>-->
        <b-row class="mt-2">
            <b-col>
                <input type="text" v-model="bar_code" placeholder="Scan your Barcode"
                       autocomplete="off" class="form-control" maxlength="12"
                       @keyup="checkExist" @blur="preventEvent"
                       onpaste="return false;" ondrop="return false;">
<!--                <b-form-input v-model="bar_code" autocomplete="off"
                              @keyup="checkExist" @paste="preventEvent"
                              @ondrop="preventEvent" maxlength="12"
                              placeholder="Scan your Barcode"></b-form-input>-->
            </b-col>
        </b-row>
        <b-row class="mb-2"><b-col></b-col></b-row>
        <b-row>
            <b-col v-if="voter.member.organization_name">
                <b-card no-body class="overflow-hidden" >
                    <b-row no-gutters>
                        <b-col md="3">
                            <validation-errors :errors="validationErrors" :success="success"
                                               :warning_message="warning_message"></validation-errors>
                            <div>
                                <b-button block variant="primary" @click="doCasting()">Vote Cast</b-button>
                            </div>
                            <b-card-img v-if="voter.voter_image" width="250" height="300" :src="addProjectPath('/'+voter.voter_image)" alt="Image" class="rounded-0"></b-card-img>
                            <img v-else width="250" height="300" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2275%22%20height%3D%2275%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20%25%7Bw%7D%20%25%7Bh%7D%22%20preserveAspectRatio%3D%22none%22%3E%3Crect%20width%3D%22100%25%22%20height%3D%22100%25%22%20style%3D%22fill%3A%23777%3B%22%3E%3C%2Frect%3E%3C%2Fsvg%3E" alt="HEX shorthand color image (#777)" class="m1">

                        </b-col>
                        <b-col md="9">
                            <b-card-body :title="voter.member.organization_name">
                                <b-card-text>
                                    <p><b>Voter Number: </b>{{voter.voter_number}}</p>
                                    <p><b>Voter Name: </b>{{voter.voter_name}}</p>
                                    <p><b>Designation: </b>{{voter.voter_designation}}</p>
                                    <p><b>Company Location: </b>{{voter.voter_location}}</p>
                                    <p><b>Address: </b>{{voter.voter_address}}</p>
                                    <p><b>Tel: </b>{{voter.voter_tel}}</p>
                                    <p><b>Mobile: </b>{{voter.voter_mob}}</p>
                                    <p><b>Fax: </b>{{voter.voter_fax}}</p>
                                    <p><b>Manager Name: </b>{{voter.manager_name}}</p>
                                </b-card-text>
                            </b-card-body>
                        </b-col>
                    </b-row>
                </b-card>
            </b-col>
            <b-col v-else id="loader-btn">
                <div id="loader" v-if="loading"
                     v-bind:style="{'backgroundImage': 'url(' + addProjectPath('/assets/img/ajax-loader.gif') + ')'}"></div>
            </b-col>
        </b-row>
    </b-container>
<!--    <div class="container">
        <h4 class="mt-5">Vote Casting</h4>

        <form class="" action="">
            <input type="text"  id="barcodeInput" placeholder="Barcode" onkeyup="checkBarCode(this)">
        </form>
        <table class="table mt-5"></table>
    </div>-->
</template>

<script>
import ValidationErrors from "../ValidationErrors";

export default {
    name: "VoteCasting",
    components: {ValidationErrors},
    props: ['location'],
    data: () => ({
        success:null,
        warning_message:null,
        validationErrors:null,
        loading: false,
        bar_code: '',
        voter:{
            voter_name:null,
            voter_image:null,
            member: {
                organization_name: null
            }
        }
    }),
    methods: {
        preventEvent: function(evt){
            evt.preventDefault();
            console.log('on paste', evt)
            return false;
        },
        doCasting: function(){
            // alert(this.voter)
            this.loading = true;
            axios
                .put('/api/voter/' + this.voter.id + '?vote_casting_location='+ this.location)
                .then(res => {
                    // this.showMessage = true;
                    let responce = res.data;
                    if (responce.includes('Casted')){
                        this.warning_message = responce
                    }else if(responce.includes('Casting')){
                        this.success = responce
                    }
                    // this.getVoters();
                }).catch(error => {
                console.error(error)
            }).finally(() => {
                this.loading = false
            });

        },
        checkBarCode: function (bar_code){
            this.loading = true;
            axios
                // .get('/api/election/' + this.$route.params.election_id + '/voter/' + bar_code)
                .get('/api/election/voter/' + bar_code)
                .then(res => {
                    // this.showMessage = true;
                    if(res.data && res.data.member && res.data.member.organization_name)
                        this.voter = res.data;
                    // this.getVoters();
                }).catch(error => {
                console.error(error)
            }).finally(() => {
                this.loading = false
            });
            console.log('BarCode ='+bar_code);
        },
        checkExist(){
            setTimeout(() => {
                if(this.bar_code) {
                    // console.log('Length',this.bar_code.length);
                    if (this.bar_code.length >= 10 && this.bar_code.length <= 12) {
                        this.checkBarCode(this.bar_code)
                    }
                }
            }, 1000, setTimeout(() => this.bar_code = '', 1500));
        }
    }
}
</script>


<style scoped>
#loader-btn {
    position: relative;
    height: 200px;
}

#loader-btn #loader {
    /* Loader Div Class */
    position: absolute;
    top: 0px;
    right: 0px;
    width: 100%;
    height: 100%;
    background-color: #eceaea;
    background-size: 50px;
    background-repeat: no-repeat;
    background-position: center;
    z-index: 10000000;
    opacity: 0.4;
    filter: alpha(opacity=40);
}
</style>
