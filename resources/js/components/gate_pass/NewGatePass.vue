<template>
    <div>
        <notifications group="foo" position="bottom right"/>
        <div class="card">
            <div class="card-header">
                <div id="notification">
                    <validation-errors :errors="validationErrors" :success="success"
                                       :warning_message="warning_message"></validation-errors>
                </div>
            </div>
            <div class="card-body">
                <main>
                    <div class="container chklist-form">
<!--                        <div class="box1 pt-4">-->
<!--                            <div class="d-flex logo">-->
<!--                                <img :src="addProjectPath('/front/assets/img/gate_pass/biman-logo.jpg')" alt="">-->
<!--                                <div class="d-flex flex-column">-->
<!--                                    <p id="top-right">Form No. 9-28-172</p>-->
<!--                                    <div class="d-flex bar-code">-->
<!--                                        <img :src="addProjectPath('/front/assets/img/gate_pass/bar-code-0.jpg')" alt="">-->
<!--                                        <p>XXXXXXXX-&#45;&#45;&#45;&#45;</p>-->
<!--                                    </div>-->
<!--                                </div>-->

<!--                            </div>-->
<!--                        </div>-->
                        <p class="text-center form-name">NEW CARGO FORM</p>
                        <div class="box2">
                            <form class="needs-validation" @submit.prevent="submitForm" role="form" id="gate-pass-form"
                                  novalidate autocomplete="off">
                                <p id="item-one">A. CONSIGNMENT BOOKING DETAILS : </p>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="d-flex input1">
                                            <label for="master_airway_bill_no" id="item-1">Master Airway bill
                                                No.</label>
                                            <input type="text" class="form-control"
                                                   id="master_airway_bill_no" name="master_airway_bill_no"
                                                   @keypress="validateNumber" @blur="checkUnique"
                                                   onpaste="return false;" ondrop="return false;" autocomplete="off"
                                                   maxlength="11" placeholder="XXXXXXXXXXX" required
                                                   v-model="form.master_airway_bill_no" >
                                            <span v-if="form.master_airway_bill_no" style="padding-left: 10px;">
                                                <span v-if="validation">
                                                    <div v-if="mawb_no == 0" class="valid-feedback" style="display:block">
                                                        Looks good!
                                                    </div>
                                                    <div v-else class="invalid-feedback" style="display:block">
                                                        MAWB already exists
                                                    </div>
                                                </span>
                                                <div v-else class="invalid-feedback" style="display:block">
                                                MAWB Must be 11 Digit & Numeric value.
                                                </div>
                                            </span>

                                        </div>

                                    </div>
                                    <div class="col-md-3">
                                        <div class="d-flex">
                                            <label for="contents" id="item-2">Contents</label>
                                            <input type="text" name="contents" class="form-control" id="contents"
                                                   placeholder="" value="" v-model="form.contents" required >
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex">
                                            <label for="weight" id="item-3">Weight(approx)</label>
                                            <input type="text" name="weight" class="form-control" id="weight"
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
                                            <input type="text" name="flight_no" class="form-control" id="flight_no"
                                                   placeholder="" value="" v-model="form.flight_no" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex">
                                            <label for="destination" id="item-5">Destination</label>
                                            <input type="text" name="destination" class="form-control" id="destination"
                                                   placeholder="" value="" v-model="form.destination" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="d-flex">
                                            <label for="routing" id="item-6">Routing</label>
                                            <input type="text" name="routing" class="form-control" id="routing"
                                                   placeholder="" value="" v-model="form.routing" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                    </div>
                                    <div v-if="first_payment" class="form-group col-md-12 mb-3">
                                        <label for="member_id">Name of Shipper/Exporter/Forwarding agent:</label>
                                        <v-select
                                            placeholder="Name of Shipper/Exporter/Forwarding agent"
                                            v-model="form.member_id"
                                            @input="setSelected"
                                            :options="members"
                                            :reduce="members => members.id"
                                            label="organization_name" id="member_id" name="member_id"></v-select>
                                    </div>
                                    <div v-else class="col-md-12 mb-3">
                                        <div class="d-flex">
                                            <label for="name_of_shipper" id="item-7">Name of
                                                Shipper/Exporter/Forwarding agent
                                            </label>
                                            <input type="text" name="name_of_shipper" class="form-control"
                                                   id="name_of_shipper" placeholder="" v-model="form.member.organization_name"
                                                   required disabled>
                                            <div class="invalid-feedback">
                                                Please provide a valid .
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <div class="d-flex">
                                            <label for="shipper_invoice_no" id="item-8">Shipper’s Invoice
                                                No:</label>
                                            <input type="text" name="shipper_invoice_no" class="form-control"
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
                                            <input type="date" name="date" class="form-control" id="date" placeholder=""
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
<!--                                <div class="box2">
                                    <div class="d-flex">
                                        <p class="text1">Cargo bound for (Tick the appropriate box):</p>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <label for="cargo_bound_for_a">EU</label>
                                                        <input id="cargo_bound_for_a" name="cargo_bound_for" v-model="form.cargo_bound_for"
                                                               type="radio" value="EU"></td>
                                                    <td>
                                                        &lt;!&ndash;                                                    <i class="fas fa-check"></i> &ndash;&gt;
                                                        <label for="cargo_bound_for_b">USA</label>
                                                        <input id="cargo_bound_for_b" name="cargo_bound_for" v-model="form.cargo_bound_for"
                                                               type="radio" value="USA"></td>
                                                    <td>
                                                        <label for="cargo_bound_for_c">OTHERS</label>
                                                        <input id="cargo_bound_for_c" name="cargo_bound_for" v-model="form.cargo_bound_for"
                                                               type="radio" value="OTHERS">
                                                    </td>

                                                </tr>
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>-->
                                <div class="box3 pt-4">
                                    <div class="d-flex">
                                        <p>B. CARGO SECURITY DECLARATION BY SHIPPER/AGENT: </p>
                                        <p class="text3">Signature & seal of Airline Representative</p>
                                    </div>
                                </div>
                                <div class="box4">
                                    <p class="text4"><i>

                                        <!--                                                                                On behav of-->
                                        <!--                                        <select name="member_id" id="member_id">-->
                                        <!--                                            <option v-for="member in members" :key="member.id" :value="member.id">{{member.email}}</option>-->
                                        <!--                                        </select>-->
                                        <input type="hidden" name="is_active" value=1>
                                    <div class="form-group">
                                        <label for="on_behalf_of_member_id">On behav of:</label>
                                        <v-select
                                            placeholder="On behav of"
                                            v-model="form.on_behalf_of_member_id"
                                            :options="members"
                                            :reduce="members => members.id"
                                            label="organization_name" id="on_behalf_of_member_id" name="on_behalf_of_member_id"></v-select>
                                    </div>

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
                                        <p>C. VIHICLE ENRTY PASS:</p>
                                        <p>Vehicle No. <input type="text" name="vehicle_no" v-model="form.vehicle_no">
                                            Date of entry: <input type="date" name="vehicle_date_of_entry"
                                                                  v-model="form.vehicle_date_of_entry">
                                            Time of entry <input type="time" name="vehicle_time_of_entry"
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
                                                        <label for="Unknown">Unknown</label>
                                                        <input id="Unknown" name="accepted_of_cargo" value="Unknown" v-model="form.accepted_of_cargo"
                                                               type="radio">
                                                    </td>
                                                    <td>
                                                        <label for="Exempted">Exempted</label>
                                                        <input id="Exempted" name="accepted_of_cargo" value="Exempted" v-model="form.accepted_of_cargo"
                                                               type="radio">
                                                    </td>
                                                    <td>
                                                        <label for="Transfer">Transfer</label>
                                                        <input id="Transfer" name="accepted_of_cargo" value="Transfer" v-model="form.accepted_of_cargo"
                                                               type="radio">
                                                    </td>
                                                    <td>
                                                        <label for="COMAT_MAIL">COMAT/MAIL</label>
                                                        <input id="COMAT_MAIL" name="accepted_of_cargo" v-model="form.accepted_of_cargo"
                                                               value="COMAT/MAIL" type="radio">
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
                                                <tr>
                                                    <td>
                                                        <label for="Over_Size">Over Size</label>
                                                        <input id="Over_Size" name="special_cargo" value="Over Size" v-model="form.special_cargo"
                                                               type="radio">
                                                    </td>
                                                    <td>
                                                        <label for="Live_Animal">Live Animal</label>
                                                        <input id="Live_Animal" name="special_cargo" value="Live Animal" v-model="form.special_cargo"
                                                               type="radio">
                                                    </td>
                                                    <td>
                                                        <label for="Human_Remains">Human Remains</label>
                                                        <input id="Human_Remains" name="special_cargo" v-model="form.special_cargo"
                                                               value="Human Remains" type="radio">
                                                    </td>
                                                    <td>
                                                        <label for="DG">DG</label>
                                                        <input id="DG" name="special_cargo" value="DG" type="radio" v-model="form.special_cargo">
                                                    </td>
                                                    <td>
                                                        <label for="Personal_Effects">Personal Effects</label>
                                                        <input id="Personal_Effects" name="special_cargo" v-model="form.special_cargo"
                                                               value="Personal Effects" type="radio">
                                                    </td>
                                                </tr>
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
                                        No. of pieces<input type="text" name="no_of_piece" v-model="form.no_of_piece">
                                        Gross Weight<input type="text" name="gross_weight" v-model="form.gross_weight">
                                    </p>
                                    <p class="text12">Dimension
                                        (i)<input type="text" name="dimensioni" v-model="form.dimensioni">
                                        (ii)<input type="text" name="dimensionii" v-model="form.dimensionii">
                                        (iii)<input type="text" name="dimensioniii" v-model="form.dimensioniii">
                                    </p>
                                    <p class="text13">
                                        (iv)<input type="text" name="dimensioniv" v-model="form.dimensioniv">
                                        (V)<input type="text" name="dimensionv" v-model="form.dimensionv">
                                        (Vi)<input type="text" name="dimensionvi" v-model="form.dimensionvi"></p>
                                    <p class="text14">
                                        Volumetric Weight of Entire Goods<input type="text" name="vwt" v-model="form.vwt">
                                        CBM<input type="text" name="cbm" v-model="form.cbm">
                                        Chargeable Weight<input type="text" name="chargeable_weight" v-model="form.chargeable_weight"></p>
                                    <p class="text15">
                                        Date/Time of Weight Taken
                                        <input type="datetime-local" name="weight_taken_date_time" v-model="form.weight_taken_date_time">
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
                                <div class="box12">
                                    <div class="d-grid gap-2 col mx-auto pt-3">
                                        <button type="submit" style="width: 100%; font-size: 20px;"
                                                v-bind:class="[loading ? 'disabled btn-secondary' : 'btn-secondary','btn']"
                                                id="loader-btn">
                                            <span>SAVE</span>
                                            <div id="loader" v-if="loading"
                                                 v-bind:style="{'backgroundImage': 'url(' + addProjectPath('/assets/img/ajax-loader.gif') + ')'}"></div>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </main>
                <GatePassPaymentModal
                    @loading="loading = false"
                    @saveGatePass="saveGatePass"
                    :openingBalance="openingBalance"
                    :user_id="user.id"
                    :selected_member_id="selected_member_id"
                    :selected_id_no="selected_id_no"
                />
            </div>
        </div>
        <link type="text/css" rel="stylesheet" :href="addProjectPath('/front/assets/css/style.css')">
    </div>
</template>

<script>
import ValidationErrors from "../ValidationErrors";
import moment from "moment";
import vSelect from "vue-select";
import GatePassPaymentModal from "./GatePassPaymentModal";

export default {
    name: "NewGatePass",
    components: {GatePassPaymentModal, ValidationErrors, moment, vSelect},
    data: () => ({
        openingBalance: 0.00,
        selected_member_id: null,
        selected_id_no: null,
        members: [],
        loading: false,
        errors: [],
        validationErrors: null,
        success: null,
        warning_message:null,
        isLoggedIn: false,
        user: null,
        created_user_id:null,
        updated_user_id:null,
        first_payment: true,
        mawb_no: 1,
        validation: false,
        form: {
            member_id: null,
            master_airway_bill_no: null,
            date: new Date().toISOString().slice(0, 10),
            // vehicle_date_of_entry: new Date().toISOString().slice(0, 10),
            // vehicle_time_of_entry: new Date().toISOString().slice(11,19),
            // weight_taken_date_time: new Date().toISOString().slice(0,19),
        }

    }),
    created() {
        this.getMembers()
        if (window.Laravel.isLoggedin) {
            this.isLoggedIn = true;
            this.user = window.Laravel.user;
            this.created_user_id = this.user.id;
            // this.member_name = window.Laravel.user.email
        } else {
            console.log('Member Not Log In')

        }
    },
    methods: {
        validateNumber(evt){
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                evt.preventDefault();
            }
        },
        checkUnique(value){
            var mawb = this.form.master_airway_bill_no
            if(/^([0-9]+)$/.test(mawb)){
                if(/^([0-9]{11})$/.test(mawb)){
                    this.validation = true;
                    axios
                        .get('/api/check_mawb_gate_pass?mawb=' + mawb +'&id=' + this.$route.params.id)
                        .then(res => {
                            // console.log(res.data)
                            this.mawb_no = res.data
                        }).catch(error => {
                        console.error(error)
                    })
                }else{
                    this.validation = false;
                }
            }else{
                this.validation = false
                // this.form.master_airway_bill_no = ''; // Null The MAWB if anything without number
                // console.log(mawb);
                // console.log(/^([0-9]+)$/.test(mawb));
            }
        },
        setSelected(value) {
            this.loading = true;
            console.log('Value: ', value)
            if (value) {
                axios
                    .get('/api/members/' + value + '/edit')
                    .then(res => {
                        this.selected_member_id = value
                        this.openingBalance = res.data.data.gatepass_balance
                        this.totalRows = this.members.length
                    }).catch(error => {
                    console.error(error)
                }).finally(() => {
                    this.loading = false
                });
            } else {
                console.log('Set a Name')
            }
            //  trigger a mutation, or dispatch an action
        },
        getMembers() {
            axios
                .get('/api/members/organizations')
                .then(res => {
                    this.members = res.data
                }).catch(error => {
                console.error(error.response.data.message)
            })
        },
        submitForm: function () {
            this.errors = [];
            if (this.mawb_no > 0) this.errors.push(["MAWB", ["MAWB No. can't be Duplicate"]]);
            if (!this.validation) this.errors.push(["master_airway_bill", ["MAWB No. Must be 11 Digit & Numeric value."]]);
            if (!this.form.master_airway_bill_no) this.errors.push(["master_airway_bill_no", ["Bill No. required."]]);
            if (!this.form.member_id) this.errors.push(["member_id", ["Name of Shipper/Exporter/Forwarding agent required."]]);
            if (!this.form.on_behalf_of_member_id) this.errors.push(["on_behalf_of_member_id", ["On Behalf OF required."]]);

            if (!this.form.contents) this.errors.push(["contents", ["Content. required."]]);
            if (!this.form.weight) this.errors.push(["weight", ["Weight. required."]]);
            if (!this.form.flight_no) this.errors.push(["flight_no", ["Flight No. required."]]);
            if (!this.form.destination) this.errors.push(["destination", ["Destination. required."]]);
            if (!this.form.routing) this.errors.push(["routing", ["Routing. required."]]);
            if (this.errors.length) {
                // this.validationErrors = Object.assign({},this.errors)
                this.validationErrors = Object.fromEntries(this.errors)
            } else {
                this.validationErrors = null
                    this.loading = true;
                this.$bvModal.show('modal-make-payment')
                // this.saveGatePass()
            }
        },
        saveGatePass: function (done) {
            // const data = new FormData();
            let myForm = document.getElementById('gate-pass-form');
            let data = new FormData(myForm);
            data.set('date', moment(String(this.form.date)).format('YYYY-MM-DD'));
            if(this.form.vehicle_date_of_entry) data.set('vehicle_date_of_entry', moment(String(this.form.vehicle_date_of_entry)).format('YYYY-MM-DD'));
            if(this.form.vehicle_time_of_entry) data.set('vehicle_time_of_entry', moment(String(this.form.vehicle_time_of_entry), "hh:mm A").format('HH:mm:ss'));
            if(this.form.weight_taken_date_time) data.set('weight_taken_date_time', moment(String(this.form.weight_taken_date_time)).format('YYYY-MM-DD HH:mm:ss'));
            if(this.created_user_id) data.set('created_user_id', this.created_user_id);
            if(this.updated_user_id) data.set('updated_user_id', this.updated_user_id);
            // data.set('is_active', 1);
            data.append('member_id', this.form.member_id);
            data.append('on_behalf_of_member_id', this.form.on_behalf_of_member_id);

            axios.post("/api/gate_pass", data).then(res => {
                this.success = 'Gate-Pass Updated Successfully';
                this.selected_id_no = res.data.id
                // this.$bvModal.show('modal-make-payment')
                // this.$router.push({name: "all-gate-pass", query: {success: this.success}});
            }).catch(error => {
                if (error.response.status == 422) {
                    this.validationErrors = error.response.data.errors;
                } else {
                   this.warning_message = error.response.data.message;
                }
                console.error(error)
                this.$nextTick(() => {
                    this.$bvModal.hide('modal-make-payment')
                })
            }).finally(() => {
                this.loading = false
                done();
            });
        },
        reset: function () {
            this.validationErrors = null;
            this.$notify({
                group: 'foo',
                type: 'success',
                duration: 10000,
                title: 'Gate Pass',
                text: 'Hello Member! Gate Pass Saved Successfully!'
            });
            // this.form = Object.assign({}, initFormData)
            // for(let field in this.formData){
            //     this.formData[field] = null;
            // }
        }
    }
}
</script>
<style scoped>
#loader-btn {
    position: relative;
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
