q<template>
    <div>
        <div class="card">
            <div class="card-body">
                <main id="printMe">
                    <notifications group="max_print" position="bottom right" />
                    <div class="container chklist-form">
                        <div class="box1 pt-4">
                            <div class="d-flex logo">
                                <img :src="addProjectPath('/front/assets/img/gate_pass/biman-logo.jpg')" alt="">
                                <div class="d-flex flex-column">
                                    <p id="top-right">Form No. 9-28-172</p>
                                    <div class="d-flex bar-code">
                                        <img :src="addProjectPath('/front/assets/img/gate_pass/bar-code.jpg')" alt="">
                                        <p>19050600891</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <p class="text-center form-name">CARGO ACCEPTANCE CHECKLIST</p>
                        <div class="box2">
                            <p id="item-one">AA. CONSIGNMENT BOOKING DETAILS : </p>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="d-flex input1">
                                        <label for="master_airway_bill_no" id="item-1">Master Airway bill
                                            No.</label>
                                        <input disabled class="form-control" name="master_airway_bill_no"
                                               id="master_airway_bill_no" placeholder="" value=""
                                               v-model="form.master_airway_bill_no" required>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-3">
                                    <div class="d-flex">
                                        <label for="contents" id="item-2">Contents</label>
                                        <input disabled name="contents" class="form-control" id="contents"
                                               placeholder="" value="" required>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex">
                                        <label for="weight" id="item-3">Weight(approx)</label>
                                        <input disabled name="weight" class="form-control" id="weight"
                                               placeholder="" value="" required>
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
                                        <input disabled name="flight_no" class="form-control" id="flight_no"
                                               placeholder="" value="" required>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex">
                                        <label for="destination" id="item-5">Destination</label>
                                        <input disabled name="destination" class="form-control" id="destination"
                                               placeholder="" value="" required>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="d-flex">
                                        <label for="routing" id="item-6">Routing</label>
                                        <input disabled name="routing" class="form-control" id="routing"
                                               placeholder="" value="" required>
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
                                        <input disabled name="name_of_shipper" class="form-control"
                                               id="name_of_shipper" placeholder="" required>
                                        <div class="invalid-feedback">
                                            Please provide a valid .
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-8 mb-3">
                                    <div class="d-flex">
                                        <label for="shipper_invoice_no" id="item-8">Shipper’s Invoice
                                            No:</label>
                                        <input disabled name="shipper_invoice_no" class="form-control"
                                               id="shipper_invoice_no" placeholder="" required>
                                        <div class="invalid-feedback">
                                            Please provide a valid .
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="d-flex">
                                        <label for="date" id="item-9">Date </label>
                                        <input disabled name="date" class="form-control" id="date" placeholder=""
                                               v-model="form.date" required>
                                        <div class="invalid-feedback">
                                            Please provide a valid .
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="box2">
                                <div class="d-flex">
                                    <p class="text1">Cargo bound for (Tick the appropriate box):</p>
                                    <div class="table-responsive">
                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <i v-if="form.cargo_bound_for === 'EU'" class="fas fa-check"></i>
                                                    <label>EU</label>

                                                <td>
                                                    <i v-if="form.cargo_bound_for === 'USA'" class="fas fa-check"></i>
                                                    <label>USA</label>

                                                <td>
                                                    <i v-if="form.cargo_bound_for === 'OTHERS'" class="fas fa-check"></i>
                                                    <label>OTHERS</label>
                                                </td>

                                            </tr>
                                            </tbody>

                                        </table>
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
                                <p class="text4"><i>On behav of
                                    <input disabled name="member_id" value="member@baffasoft.com">
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
                                <p class="text6">Name (Shipper/Agent)<input name="agent_name" disabled>ID
                                    No.<input name="agent_id_no"></p>
                            </div>
                            <div class="box5 pt-3">
                                <div class="d-flex">
                                    <p>C. VIHICLE ENRTY PASS:</p>
                                    <p>Vehicle No. <input disabled name="vehicle_no">
                                        Date of entry: <input disabled name="vehicle_date_of_entry"
                                                              v-model="form.vehicle_date_of_entry">
                                        Time of entry <input disabled name="vehicle_time_of_entry"
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
                                                    <i v-if="form.accepted_of_cargo === 'COMAT/MAIL'" class="fas fa-check"></i> COMAT/MAIL
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
                                                    <i v-if="form.special_cargo === 'Over Size'" class="fas fa-check"></i> Over Size
                                                </td>
                                                <td>
                                                    <i v-if="form.special_cargo === 'Live Animal'" class="fas fa-check"></i> Live Animal
                                                </td>
                                                <td>
                                                    <i v-if="form.special_cargo === 'Human Remains'" class="fas fa-check"></i> Human Remains
                                                </td>
                                                <td>
                                                    <i v-if="form.special_cargo === 'COMAT/MAIL'" class="fas fa-check"></i> COMAT/MAIL
                                                </td>
                                                <td>
                                                    <i v-if="form.special_cargo === 'DG'" class="fas fa-check"></i> DG

                                                </td>
                                                <td>
                                                    <i v-if="form.special_cargo === 'Personal Effects'" class="fas fa-check"></i> Personal Effects
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
                                    No. of pieces<input disabled name="no_of_piece">
                                    Gross Weight<input disabled name="gross_weight"></p>
                                <p class="text12">Dimension
                                    (i)<input disabled name="dimension[]">(ii)<input disabled
                                                                                        name="dimension[]">(iii)<input
                                        disabled name="dimension[]"></p>
                                <p class="text13">
                                    (iv)<input disabled name="dimension[]">(V)<input disabled
                                                                                        name="dimension[]">(Vi)<input
                                    disabled name="dimension[]"></p>
                                <p class="text14">Volumetric Weight of Entire Goods<input disabled
                                                                                          name="volumetric_weight">CBM<input
                                    disabled name="cbm">Chargeable
                                    Weight<input disabled name="chargeable_weight"></p>
                                <p class="text15">Date/Time of Weight Taken<input disabled
                                                                                  name="weight_taken_date_time"
                                                                                  v-model="form.weight_taken_date_time">
                                </p>
                            </div>
                            <div class="bottom-sign">
                                <div class="d-flex">
                                    <div class="d-flex flex-column">
                                        <input>
                                        <p>Signature of Shipper/Agent/Airline<br>
                                            Representative with Name and ID No.</p>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <input>
                                        <p>Signature of Acceptance Staff with<br> Name and Staff No.<input></p>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <input>
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
                </main>
                <div class="box12">
                    <div class="d-grid gap-2 col-6 mx-auto pt-3">
                        <button v-print="printObj" type="submit" v-bind:class="[printLoading ? 'disabled btn-secondary' : 'btn-secondary','btn']" id="loader-btn">
                            <span>Print Preview</span>
                            <div id="loader" v-if="printLoading" v-bind:style="{'backgroundImage': 'url(' + addProjectPath('/assets/img/ajax-loader.gif') + ')'}" ></div>
                        </button>
                        <button class="btn btn-secondary" @click="printDoc">Print</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import {publicPath} from "../../../../vue.config";
import print from 'vue-print-nb'
export default {
    name: "GatePassPrint",
    components: {moment,print},
    data(){
        return{
            form: {
                master_airway_bill_no: '',
                date: null,
                vehicle_date_of_entry: null,
                vehicle_time_of_entry: null,
                weight_taken_date_time: null,
                cargo_bound_for:null
            },
            printLoading: false,
            printObj: {
                id: "printMe",
                preview: true,
                previewTitle: 'CARGO ACCEPTANCE CHECKLIST',
                previewPrintBtnLabel: 'Print',
                popTitle: 'Gate Pass Print',
                // extraCss: "https://cdn.bootcdn.net/ajax/libs/animate.css/4.1.1/animate.compat.css, https://cdn.bootcdn.net/ajax/libs/hover.css/2.3.1/css/hover-min.css",
                // extraCss: publicPath+'/assets/css/app.css,'+publicPath+'/front/assets/css/style.css',
                beforeOpenCallback (vue) {
                    this.printLoading = true
                    console.log('beforeOpenCallback')
                },
                openCallback (vue) {
                    this.printLoading = false
                    console.log('openCallback')
                }
                // closeCallback (vue) {
                //     console.log('closeCallback')
                // }
            }

        }
    },
    // data: () => ({
    //     form: {
    //         master_airway_bill_no: 'ssss',
    //         date: new Date().toISOString().slice(0, 10),
    //         vehicle_date_of_entry: new Date().toISOString().slice(0, 10),
    //         vehicle_time_of_entry: new Date().toISOString().slice(11, 16),
    //         weight_taken_date_time: new Date(),
    //     }
    //
    // }),
    created() {
        this.getGatePass()
    },
    methods: {
        getGatePass() {
            axios.get('/api/gate_pass/' + this.$route.params.id)
                .then(res => {
                    this.form = res.data
                    // this.form['nationality_id'] = 50
                    // this.form['birth_date'] = '2021-10-18 04:58:34'
                }).catch(error => {
                console.log('Error: ',error.response)
            })
        },
        updatePrintTimes() {
            axios.put('/api/gate_pass/' + this.$route.params.id,{print_times:1})
                .then(res => {
                    console.log('PrintTimes',res.data);
                    if(res.data > 3){
                        this.$notify({
                            group: 'max_print',
                            type: 'alert',
                            duration: 10000,
                            title: 'Gate Pass Invoice',
                            text: 'Hello user! You already use the maximum Print!'
                        });
                    }else{
                        window.print();
                    }
                }).catch(error => {
                console.log('Error: ',error.response)
            })
        },
        printDoc() {
            this.updatePrintTimes();
        }
    }
}
</script>
<style scoped>
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
@import "~/front/assets/css/style.css";
</style>
