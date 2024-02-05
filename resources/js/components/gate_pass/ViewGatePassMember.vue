<template>
    <div>
        <notifications group="foo" position="bottom right" />
        <div class="card">
            <div class="card-header">
                <div id="notification">
                    <validation-errors :errors="validationErrors" :success="success"
                                       :warning_message="warning_message"></validation-errors>
                </div>
            </div>
            <div class="card-body">
                <div>
                    <button class="btn btn-dark" @click="doBack"><< Back</button>
                </div>
                <main>
                    <div class="container chklist-form">
                        <p class="text-center form-name">CARGO ACCEPTANCE CHECKLIST</p>
                        <div class="box2">
                                <p id="item-one">A. CONSIGNMENT BOOKING DETAILS : </p>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="d-flex input1">
                                            <label for="master_airway_bill_no" id="item-1">Master Airway bill
                                                No.</label>
                                            <input type="text" disabled class="form-control" name="master_airway_bill_no"
                                                   id="master_airway_bill_no" maxlength="11" placeholder="XXXXXXXXXXX"
                                                   v-model="form.master_airway_bill_no" required>
                                        </div>

                                    </div>
                                    <div class="col-md-3">
                                        <div class="d-flex">
                                            <label for="contents" id="item-2">Contents</label>
                                            <input type="text" disabled name="contents" class="form-control" id="contents"
                                                   placeholder="" value="" v-model="form.contents" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex">
                                            <label for="weight" id="item-3">Weight(approx)</label>
                                            <input type="text" disabled name="weight" class="form-control" id="weight"
                                                   placeholder="" value="" v-model="form.weight" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="d-flex input1">
                                            <label for="flight_no" id="item-4">Flight No/Date</label>
                                            <input type="text" disabled name="flight_no" class="form-control" id="flight_no"
                                                   placeholder="" value="" v-model="form.flight_no" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex">
                                            <label for="destination" id="item-5">Destination</label>
                                            <input type="text" disabled name="destination" class="form-control" id="destination"
                                                   placeholder="" value="" v-model="form.destination" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="d-flex">
                                            <label for="routing" id="item-6">Routing</label>
                                            <input type="text" disabled name="routing" class="form-control" id="routing"
                                                   placeholder="" value="" v-model="form.routing" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="d-flex">
                                            <label for="name_of_shipper" id="item-7">Name of
                                                Shipper/Exporter/Forwarding agent
                                            </label>
                                            <input type="text" disabled name="name_of_shipper" class="form-control"
                                                   id="name_of_shipper" placeholder="" v-model="member.organization_name"
                                                   required>
                                            <div class="invalid-feedback">
                                                Please provide a valid .
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <div class="d-flex">
                                            <label for="shipper_invoice_no" id="item-8">Shipper’s Invoice
                                                No:</label>
                                            <input type="text" disabled name="shipper_invoice_no" class="form-control"
                                                   id="shipper_invoice_no" placeholder=""
                                                   v-model="form.shipper_invoice_no" required>
                                            <div class="invalid-feedback">
                                                Please provide a valid .
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="d-flex">
                                            <label for="date" id="item-9">Date </label>
                                            <input type="text" disabled name="date" class="form-control" id="date" placeholder=""
                                                   v-model="form.date" required>
                                            <div class="invalid-feedback">
                                                Please provide a valid .
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="d-flex">
                                            <label for="cargo_bound_for" id="item-10">Cargo bound for: </label>
                                            <input type="text" name="cargo_bound_for" class="form-control"
                                                   id="cargo_bound_for" placeholder="" v-model="form.cargo_bound_for"
                                                   required>
                                            <div class="invalid-feedback">
                                                Please provide a valid .
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box3 pt-4">
                                    <div class="d-flex">
                                        <p>B. CARGO SECURITY DECLARATION BY SHIPPER/AGENT: </p>
                                        <p class="text3">Signature & seal of Airline Representative</p>
                                    </div>
                                </div>
                                <div class="box4">
                                    <p class="text4"><i>

                                    On behav of
                                        <input type="text" disabled name="name_of_shipper" class="form-control"
                                               id="name_of_shipper" placeholder="" v-model="form.on_behalf_of_member.organization_name"
                                               required disabled>
<!--                                    <div class="form-group">-->
<!--                                        <label for="on_behalf_of_member_id">On behav of:</label>-->
<!--                                        <v-select-->
<!--                                            placeholder="On behav of"-->
<!--                                            v-model="form.on_behalf_of_member_id"-->
<!--                                            :options="members"-->
<!--                                            :reduce="members => members.id"-->
<!--                                            label="organization_name" id="on_behalf_of_member_id" name="on_behalf_of_member_id"></v-select>-->
<!--                                    </div>-->

                                    I, the undersigned,
                                    hereby declare that the contents of this
                                    consignment do not
                                    contain
                                    any prohibited or illicit items and I am satisfied that the contents are as
                                    stated and safe
                                    for air carriage. The goods have been secured and protected during all
                                    stages of storage and
                                    transportation. I understand that a false declaration could lead to legal
                                    action being
                                    taken.</i>
                                    </p>
                                    <p class="text5">Signature<input>Date<input></p>
                                    <p class="text6">Name (Shipper/Agent)<input name="agent_name" type="text"
                                                                                v-model="form.agent_name">ID
                                        No.<input name="agent_id_no" v-model="form.agent_id_no"></p>
                                </div>
                                <div class="box5 pt-3">
                                    <div class="d-flex">
                                        <p style="width: 24%">C. VIHICLE ENRTY PASS:</p>
                                        <p>Vehicle No. <input type="text" disabled name="vehicle_no" v-model="form.vehicle_no">
                                            Date of entry: <input type="text" name="vehicle_date_of_entry"
                                                                  v-model="form.vehicle_date_of_entry">
                                            Time of entry <input type="text" name="vehicle_time_of_entry"
                                                                 v-model="form.vehicle_time_of_entry">
                                        </p>

                                    </div>
                                </div>
                                <div class="box6">
                                    <div class="d-flex">
                                        <p>Signature & seal of GHA Representative</p>
                                        <p>Signature of Biman Security Official </p>
                                    </div>
                                </div>
                                <div class="box7">
                                    <p class="text7">D. ACCEPTENCE OF CARGO</p>
                                    <div class="d-flex">
                                        <p>a)Accepted as (Tick one)</p>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <i v-if="form.accepted_of_cargo === 'Unknown'" class="fas fa-check"></i> Unknown
                                                    </td>
                                                    <td>
                                                        <i v-if="form.accepted_of_cargo === 'Exempted'" class="fas fa-check"></i> Exempted
                                                    </td>
                                                    <td>
                                                        <i v-if="form.accepted_of_cargo === 'Transfer'" class="fas fa-check"></i> Transfer
                                                    </td>
                                                    <td>
                                                        <i v-if="form.accepted_of_cargo === 'COMAT/MAIL'" class="fas fa-check"></i>
                                                        COMAT/MAIL
                                                    </td>
                                                </tr>
                                                </tbody>

                                            </table>
                                        </div>

                                    </div>
                                </div>
                                <div class="box8">
                                    <div class="d-flex">
                                        <p>b) Special cargo (if any) </p>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tbody>
                                                <td>
                                                    <i v-if="form.special_cargo === 'Over Size'" class="fas fa-check"></i> Over Size
                                                </td>
                                                <td>
                                                    <i v-if="form.special_cargo === 'Live Animal'" class="fas fa-check"></i> Live Animal
                                                </td>
                                                <td>
                                                    <i v-if="form.special_cargo === 'Human Remains'" class="fas fa-check"></i> Human Remains
                                                </td>
                                                <td>
                                                    <i v-if="form.special_cargo === 'DG'" class="fas fa-check"></i> DG

                                                </td>
                                                <td>
                                                    <i v-if="form.special_cargo === 'Personal Effects'" class="fas fa-check"></i> Personal
                                                    Effects
                                                </td>
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>


                                </div>
                                <div class="box9">
                                    <p class="text8">c) Visual Inspection of Consignment During Acceptance:</p>
                                    <div class="pl-4">
                                        <p>There is no items/packages of consignment that is:</p>
                                        <p>i. significantly damaged, or</p>
                                        <p>ii. showing evidence of tempering, or</p>
                                        <p>iii. with hole, or</p>
                                        <p>iv. Boxed/packed with extra jacket;
                                            to a degree which could have allowed the introduction of a prohibited
                                            article.
                                        </p>
                                    </div>

                                </div>
                                <div class="box10">
                                    <p class="text10">d) Description of consignments</p>
                                    <p class="text11">
                                        No. of pieces<input type="text" disabled name="no_of_piece" v-model="form.no_of_piece">
                                        Gross Weight<input type="text" disabled name="gross_weight" v-model="form.gross_weight">
                                    </p>
                                    <p class="text12">Dimension
                                        (i)<input type="text" disabled name="dimensioni" v-model="form.dimensioni">
                                        (ii)<input type="text" disabled name="dimensionii" v-model="form.dimensionii">
                                        (iii)<input type="text" disabled name="dimensioniii" v-model="form.dimensioniii">
                                    </p>
                                    <p class="text13">
                                        (iv)<input type="text" disabled name="dimensioniv" v-model="form.dimensioniv">
                                        (V)<input type="text" disabled name="dimensionv" v-model="form.dimensionv">
                                        (Vi)<input type="text" disabled name="dimensionvi" v-model="form.dimensionvi"></p>
                                    <p class="text14">
                                        Volumetric Weight of Entire Goods<input type="text" disabled name="vwt" v-model="form.vwt">
                                        CBM<input type="text" disabled name="cbm" v-model="form.cbm">
                                        Chargeable Weight<input type="text" disabled name="chargeable_weight" v-model="form.chargeable_weight"></p>
                                    <p class="text15">
                                        Date/Time of Weight Taken
                                        <input type="text" name="weight_taken_date_time" v-model="form.weight_taken_date_time">
                                    </p>
                                </div>
                                <div class="bottom-sign">
                                    <div class="d-flex">
                                        <div class="d-flex flex-column">
                                            <input style="width: 185px">
                                            <p>Signature of Shipper/Agent/Airline<br> Representative with Name and ID No.<input></p>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <input style="width: 185px">
                                            <p>Signature of Acceptance Staff with<br> Name and Staff No.<input></p>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <input style="width: 185px">
                                            <p>Signature of Security personnel with<br> Name and Staff No.<input></p>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <input>
                                            <p>Signature of Duty Officer with<br>
                                                Name and Staff No.<input></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="box11">
                                    <div class="d-flex">
                                        <p class="text16"><i>Distribution: Copy-1 Biman, Copy-2 CAAB, Copy-3 Agent,
                                            Copy-4 Shipper.</i>
                                        </p>
                                        <p class="text17"><i>Printed at: Biman Ptg. & Pub.</i></p>
                                    </div>
                                </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <link type="text/css" rel="stylesheet" :href="addProjectPath('/front/assets/css/style.css')">
    </div>
</template>

<script>
import ValidationErrors from "../ValidationErrors";
import moment from "moment";
import {publicPath} from "../../../../vue.config";
import vSelect from "vue-select";

export default {
    name: "EditGatePassMember",
    components: {ValidationErrors,moment,vSelect},
    data: () => ({
        isLoggedIn:false,
        is_submit:0,
        members: [],
        member: null,
        loading:false,
        errors: [],
        validationErrors: null,
        success: null,
        warning_message:null,
        created_user_id:null,
        mawb_no: 0,
        form: {
            master_airway_bill_no:'',
            date: new Date().toISOString().slice(0, 10),
            // vehicle_date_of_entry: new Date().toISOString().slice(0, 10),
            // vehicle_time_of_entry: new Date().toISOString().slice(11,16),
            // weight_taken_date_time: new Date(),
        }

    }),
    created() {
        this.getMembers()
        if (window.Laravel.isLoggedin) {
            this.isLoggedIn = true;
            this.member = window.Laravel.user;
            // this.member_name = window.Laravel.user.email
            this.form.created_user_name = this.member.username;
            this.form.member_id = this.member.id;
        }else{
            console.log('Member Not Log In')

        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = publicPath;
        }
        next();
    },
    methods: {
        doBack(){
            console.log('Click')
            this.$router.go(-1)
        },
        getMembers() {
            axios
                .get('/api/members/organizations')
                .then(res => {
                    this.members = res.data
                    this.getGatePass();
                    // this.form.name_of_shipper = this.form.member.organization_name
                }).catch(error => {
                console.error(error.response.data.message)
            })
        },
        getGatePass() {
            axios
                .get('/api/gate_pass/' + this.$route.params.id)
                .then(res => {
                    this.form = res.data
                    this.form.date = new Date(this.form.date).toISOString().slice(0, 10)
                    if(this.form.vehicle_date_of_entry) this.form.vehicle_date_of_entry = new Date(res.data.vehicle_date_of_entry).toISOString().slice(0, 10)
                    // if(this.form.weight_taken_date_time) this.form.weight_taken_date_time = new Date(res.data.weight_taken_date_time).toISOString().slice(0, 19)
                    if(this.form.weight_taken_date_time) this.form.weight_taken_date_time = moment(String(this.form.weight_taken_date_time)).format('YYYY-MM-DDTHH:mm:ss')
                    // console.log(this.form.weight_taken_date_time)
                }).catch(error => {
                console.error('My Error: ' + error)
            })
        }
    }
}
</script>
<style scoped>
.form-control:disabled, .form-control[readonly] {
    background-color: white;
}
#item-1{
    width: 470px !important;
}
.box2 .d-flex {
     font-family: serif !important;
}
input[name="agent_id_no"] {
    width: 30% !important;
}
input[name="vehicle_time_of_entry"] {
    width: 15% !important;
}
input[name="vehicle_no"] {
    width: 16% !important;
}
input[name="weight_taken_date_time"] {
    width: 80% !important;
}
p{
    font-size: 0.9rem;
}
#loader-btn{
    position: relative;
}
#loader-btn #loader{
    /* Loader Div Class */
    position: absolute;
    top:0px;
    right:0px;
    width:100%;
    height:100%;
    background-color:#eceaea;
    background-size: 50px;
    background-repeat:no-repeat;
    background-position:center;
    z-index:10000000;
    opacity: 0.4;
    filter: alpha(opacity=40);
}
/*@import "~/front/assets/css/style.css";*/
</style>
