<template>
    <div>
        <main id="printMe">
            <div class="container chklist-form">
                <div class="box1">
                    <div class="logo">
                        <img :src="addProjectPath('/front/assets/img/gate_pass/biman.png')" alt="">
<!--                        <img src="./img/biman.png" alt="">-->
                    </div>
                    <div class="bar-code">
                        <barcode v-bind:value="form.master_airway_bill_no" width="1.5" height="35" margin-top="10"  font-size="14">
                            Bar Code...
                        </barcode>
                        <img style="display: none;" :src="addProjectPath('/front/assets/img/gate_pass/barcoad.png')" alt="">
<!--                        <img src="./img/barcoad.png" alt="">-->
                    </div>
                    <div class="form-no">
                        <p class="namber">
                            <span id="annex_e">Annex-E</span>
                            <span id="form_no_1">Form No. 9-28-172<span id="form_no_2"> (a)</span></span>
                            <span id="receipt_no">{{form.receipt_no ? form.receipt_no : '12345600001' }}</span>
                        </p>
                    </div>
                </div>

                <div class="form-name-tx"><h2>CARGO ACCEPTANCE CHECKLIST</h2></div>
                <div class="cb-details ">
                    <h3>A. CONSIGNMENT BOOKING DETAILS : </h3>
                    <div class="form11">
                        <label>Master Airway bill No.</label> <input class="form-control" disabled type="text"  v-model="form.master_airway_bill_no" name="master_airway_bill_no" style="width:206px">
                        <label>Contents</label>
                        <input class="form-control" type="text"  disabled name="contents" v-model="form.contents" style="width:174px">
                        <label>Weight(approx)</label> <input class="form-control" type="text" disabled name="weight" v-model="form.weight" style="width:89px">

                        <label>Flight No / Date</label> <input class="form-control" type="text"  disabled name="flight_no" v-model="form.flight_no"
                                                               style="width:237px; text-align: left;padding-left: 12px;">
                        <label>Destination</label> <input class="form-control" type="text"  disabled name="destination" v-model="form.destination"
                                                          style="width:157px">
                        <label>Routing</label> <input class="form-control" type="text"  disabled name="routing" v-model="form.routing" style="width:132px">

                        <label>Name of Shipper/Exporter/Forwarding/Agent</label>
                        <input class="form-control" type="text" disabled name="member_id" v-model="form.member.organization_name"
                                                                                        style="width:500px">
                        <label>Shipper’s Invoice No:</label> <input class="form-control" type="text"  disabled name="shipper_invoice_no" v-model="form.shipper_invoice_no"
                                                                    style="width:401px">
                        <label>Date </label> <input class="form-control" type="text"  disabled name="date" v-model="form.date" style="width:197px">
                        <label>Cargo bound for:</label> <input class="form-control" type="text"  disabled name="date" v-model="form.cargo_bound_for" style="width:657px">
<!--                        <div class="car-bond-tic">Cargo bound for (Tick the appropriate box):</div>
                        <div class="car-bond-tic1"><i v-if="form.cargo_bound_for === 'EU'" class="fas fa-check"></i>EU</div>
                        <div class="car-bond-tic1"><i v-if="form.cargo_bound_for === 'USA'" class="fas fa-check"></i>USA</div>
                        <div class="car-bond-tic1"><i v-if="form.cargo_bound_for === 'OTHERS'" class="fas fa-check"></i>OTHERS</div>-->
                    </div>
                </div>

                <div class="box2">
                    <div class="col-half"><h3>B. CARGO SECURITY DECLARATION BY SHIPPER/AGENT: </h3></div>
                    <div class="col-half text-al-cen sign "><input class="form-control" type="text"  disabled name="signature"
                                                                   style="width:374px">
                        <br>Signature & seal of Airline Representative
                    </div>

                    <p class="behave">
                    <div class="boder-s">
                        <p> On behalf of <input class="form-control" type="text"  disabled name="on_behalf_of_member_id" v-model="form.on_behalf_of_member.organization_name" style="width:663px"/>I, the
                            undersigned, hereby declare that the contents of this consignment do not contain any
                            prohibited or illicit items and I am satisfied that the contents are as
                            stated and safe for air carriage. The goods have been secured and protected during all
                            stages of storage and transportation. I understand that a false declaration could lead
                            to legal action being taken.
                        </p>

                        <div class="form1">
                            <label>Signature</label> <input class="form-control" type="text"  disabled name="signature" style="width:360px">
                            <label>Date</label> <input class="form-control" type="text"  disabled name="signature" style="width:304px">
                            <label>Name (Shipper/Agent)</label>
                            <input class="form-control" type="text"  disabled name="agent_name" v-model="form.agent_name" style="width:403px">
                            <label>ID No.</label> <input class="form-control" type="text"  disabled name="agent_id_no" v-model="form.agent_id_no" style="width:178px">
                        </div>
                    </div>
                </div>

                <div class="box44">
                    <div class="col-4"><h3>C. VEHICLE ENTRY PASS: </h3></div>
                    <div class="col-8">
                        <div class="form1">
                            <label>Vehicle No.</label> <input class="form-control" type="text"  disabled name="vehicle_no" v-model="form.vehicle_no"
                                                              style="width:138px">
                            <label>Date of entry:</label> <input class="form-control" type="text"  disabled name="vehicle_date_of_entry" v-model="form.vehicle_date_of_entry"
                                                                 style="width:102px">
                            <label>Time of entry</label> <input class="form-control" type="text"  disabled name="vehicle_time_of_entry" v-model="form.vehicle_time_of_entry"
                                                                style="width:110px">
                        </div>
                    </div>
                    <div class="col-half text-al-cen sign2 ">
                        <input class="form-control" type="text"  disabled name="signature" style="width:362px">
                        <br>Signature & seal of GHA Representative
                    </div>
                    <div class="col-half text-al-cen sign2 ">
                        <input class="form-control" type="text"  disabled name="signature" style="width:362px">
                        <br>Signature of Biman Security Official
                    </div>

                </div>


                <div class="box55">
                    <h3>D. ACCEPTANCE OF CARGO</h3>
                    <div class="gap">
                        <div class="col-4"><h3>a) Accepted as (Tick one)</h3></div>
                        <div class="col-8">
                            <table class="table1">
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

                        <div class="col-4"><h3>b) Special cargo (if any)</h3></div>
                        <div class="col-8">
                            <table class="table1">
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

                        <h3>c) Visual Inspection of Consignment During Acceptance:</h3>
                        <div class="packages">
                            <p>There is no items/packages of consignment that is:</p>
                            <ol>
                                <li><span style="margin-left: 36px;">significantly damaged, or</span></li>
                                <li><span style="margin-left: 32px;">showing evidence of tempering, or</span></li>
                                <li><span style="margin-left: 27px;">with hole, or</span></li>
                                <li><span style="margin-left: 29px;">Boxed/packed with extra jacket;</span><br>
                                    <span style="margin-left: 49px;">to a degree which could have allowed the introduction of a prohibited article.</span>
                                </li>
                            </ol>
                        </div>



                        <div class="box66">
                            <h3>d) Description of consignments</h3>

                            <div class="form2">
                                <label>No. of pieces</label>
                                <input class="form-control" type="text" disabled v-model="form.no_of_piece"
                                                                    name="no_of_piece" style="width:355px">
                                <label>Gross Weight</label> <input class="form-control" disabled type="text" v-model="form.gross_weight"
                                                                   name="gross_weight" style="width:248px">
                                <label>Dimension</label>
                                <span style="margin-left: 23px;">(i)</span>
                                <input class="form-control"type="text"  disabled name="dimensioni" v-model="form.dimensioni" style="width:211px">
                                (ii)
                                <input class="form-control" type="text"  disabled v-model="form.dimensionii" name="dimensionii" style="width:211px">
                                (iii)
                                <input class="form-control" v-model="form.dimensioniii" disabled type="text" name="dimensioniii" style="width:192px">
                                (iV)
                                <input class="form-control" type="text"  disabled name="dimensioniv" v-model="form.dimensioniv" style="width:290px">
                                (V)
                                <input class="form-control" type="text"  disabled name="dimensionv" v-model="form.dimensionv" style="width:209px">
                                (Vi)
                                <input class="form-control" type="text"  disabled name="dimensionvi" v-model="form.dimensionvi" style="width:189px">

                                <label>Volumetric Weight of Entire Goods</label>
                                <input class="form-control" value="327" v-model="form.vwt"
                                                                                        disabled type="text" name="vwt"
                                                                                        style="width:182px">
                                <label>CBM</label>
                                <input class="form-control" value="327" disabled type="text" name="cbm" v-model="form.cbm" style="width:122px">
                                <label>Chargeable Weight</label>
                                <input class="form-control" disabled type="text" v-model="form.chargeable_weight" name="chargeable_weight" style="width:145px">
                                <label>Date/Time of Weight Taken</label>
                                <input class="form-control" disabled type="text" name="weight_taken_date_time" v-model="form.weight_taken_date_time" style="width:606px">
                            </div>
                        </div>


                        <div class="box77">
                            <div class="bottom-sign">

                                <div class="d-flex-bx flex-column">
                                    <input class="form-control" type="text"  disabled name="signature" style="width:90%;">
                                    <p>
                                        <span  style="display: block;letter-spacing: -0.25px;word-spacing: -1px">Signature of Shipper/Agent/Airline</span>
                                        <span  style="padding-top: 6px;display: block;">Rep. with Name and Staff</span>
                                        No. <input class="form-control" type="text"  disabled name="signature" style="width:77%">
                                    </p>

<!--                                    <input class="form-control" type="text"  disabled name="signature" style="width:90%; margin-top:7px;">-->
                                </div>
                                <div class="d-flex-bx flex-column">
                                    <input class="form-control" type="text"  disabled name="signature" style="width:89%">
                                    <p>
                                        Signature of Acceptance Staff <br>
                                        <span  style="padding-top: 6px;display: block;">with Name and Staff</span>
                                        No. <input class="form-control" type="text"  disabled name="signature" style="width:77%">
                                    </p>
<!--                                    <input class="form-control" type="text"  disabled name="signature" style="width:90%">-->
                                </div>
                                <div class="d-flex-bx flex-column">
                                    <input class="form-control" type="text"  disabled name="signature" style="width:89%">
                                    <p>
                                        Signature of Security personnel <br>
                                        <span  style="padding-top: 6px;display: block;word-spacing: -1px;">(Wgt. Checking) with Name and</span>
                                        Staff No. <input class="form-control" type="text"  disabled name="signature" style="width:61%">
                                    </p>
<!--                                    <input class="form-control" type="text"  disabled name="signature" style="width:90%">-->
                                </div>
                                <div class="d-flex-bx flex-column">
                                    <input class="form-control" type="text"  disabled name="signature" style="width:89%">
                                    <p>
                                        Signature of Duty Officer(Cargo <br>
                                        <span  style="padding-top: 6px;display: block;letter-spacing: -0.5px;">Export/ Foreign Carrier) with Name</span>
                                        and Staff No.<input class="form-control" type="text"  disabled name="signature" style="width:53%">
                                    </p>
<!--                                    <input class="form-control" type="text"  disabled name="signature" style="width:100%">-->
                                </div>
                                <div class="d-flex-bx flex-column">
                                    <input class="form-control" type="text"  disabled name="signature" style="width:89%">
                                    <p>Signature of Duty Officer <br>
                                        <span  style="padding-top: 6px;display: block;">(Security) with Name and Staff</span>
                                        No.<input class="form-control" type="text"  disabled name="signature" style="width:77%">
                                    </p>
<!--                                    <input class="form-control" type="text"  disabled name="signature" style="width:100%">-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box88">
                        <div class="text16"><i>Distribution: Copy-1 Biman, Copy-2 CAAB, Copy-3 Agent, Copy-4 Shipper.</i>
                        </div>
                        <div class="text17"><i>Printed at: Biman Ptg. & Pub.</i></div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
import Barcode from 'vue-barcode';
import moment from "moment";
export default {
    name: "GatePassPrint",
    components: {Barcode,moment},
    data() {
        return {
            form: {
                master_airway_bill_no: '',
                date: null,
                vehicle_date_of_entry: null,
                vehicle_time_of_entry: null,
                weight_taken_date_time: null,
                cargo_bound_for: null,
                receipt_no:null
            },
        }
    },
    created() {
        this.getGatePass()
        window.onmousemove = function() {
            // window.close();
        }
    },
    methods: {
        getGatePass() {
            axios.get('/api/gate_pass/' + this.$route.params.id)
                .then(res => {
                    this.form = res.data
                    // this.form.receipt_no = res.data.receipt_no
                    if(res.data.date) this.form.date =  moment(String(res.data.date)).format('DD-MM-YYYY');
                    if(res.data.vehicle_date_of_entry) this.form.vehicle_date_of_entry =  moment(String(res.data.vehicle_date_of_entry)).format('DD-MM-YYYY');
                    if(res.data.vehicle_time_of_entry) this.form.vehicle_time_of_entry =  moment(String(res.data.vehicle_time_of_entry),"hh:mm A").format('HH:mm:ss');
                    if(res.data.weight_taken_date_time) this.form.weight_taken_date_time =  moment(String(res.data.weight_taken_date_time)).format('DD-MM-YYYY HH:mm:ss');

                    // this.form['nationality_id'] = 50
                    // this.form['birth_date'] = '2021-10-18 04:58:34'
                }).catch(error => {
                console.log('Error: ', error.response)
            }).finally(()=>{
                setTimeout(function(){
                    window.print()
                },1000);
            })
        }
    }
}
</script>
<style scoped>

</style>
