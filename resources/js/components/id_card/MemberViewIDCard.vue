<template>
    <div>
        <main id="printMe">
            <div>
                <button class="btn btn-dark" @click="doBack"><< Back</button>
            </div>
            <div class="container">
                <div class="boxNew">
                    <div class="logoNew">
                        <img :src="addProjectPath('/front/assets/img/id_card/baffa-logo.png')" alt="">
                        <img src="img/baffa-logo.png" alt="">
                    </div>
                    <div class="title">
                        <img :src="addProjectPath('/front/assets/img/id_card/id-title.png')" alt="">
                        <img src="img/id-title.png" alt="">
                        <p id="idOne">ID CARD FORM - {{form.form_year}}</p>
                    </div>
                    <div class="form-new">
                        <img v-if="form.card_holder_photograph_attachment" :src="assetPath('/'+form.card_holder_photograph_attachment)" alt="">
                        <img v-else :src="addProjectPath('/front/assets/img/id_card/pp.png')" alt="">
                        <!-- <p>Card Holder's<br>Passport Size<br>Photograph</p> -->
                    </div>
                </div>
                <div class="form-field">
                    <dl>
                        <dt>1.<span></span>Name of the Card Holder<span class="required">*</span></dt>
                        <dd>
                            <input type="hidden" name="member_id" value="1">
                            <span class="lower_border">{{form.card_holder_name}}</span>
                        </dd>
                        <br>
                        <dt>2.<span></span>Card Holder’s Designation<span class="required">*</span></dt>
                        <dd><span class="lower_border">{{form.card_holder_designation}}</span></dd>
                        <br>
                        <dt>3.<span></span>Name of the Member Organization(s)<span class="required">*</span>
                        </dt>
                        <dd><span class="lower_border">{{form.members.toString()}}</span></dd>
                        <br>
                        <dt>4.<span></span>BAFFA Membership No.<span class="required">*</span></dt>
                        <dd><span class="lower_border">{{form.memship_no}}</span></dd>
                        <br>
                        <dt>5.<span></span>Office Address<span class="required">*</span></dt>
                        <dd><span class="lower_border">{{form.office_address}}</span></dd>
                        <br>
                        <dt>6.<span></span>Office Telephone No.<span class="required">*</span></dt>
                        <dd><span class="lower_border">{{form.office_telephone}}</span></dd>
                        <br>
                        <dt>7.<span></span>Date of Birth (above 18 years)<span class="required">*</span></dt>
                        <dd><span class="lower_border">{{form.dob | date_format}}</span></dd>
                        <br>
                        <dt>8.<span></span>{{form.attachment_name}}
                            <!--                                        National ID/Passport/Birth Certificate-->
<!--                            <br>-->
<!--                            <span id="idTwo"></span>-->
                            No.
                            <span class="required">*</span>
                        </dt>
                        <dd>
                            <span class="lower_border" v-if="form.attachment_file">
                                <a :href="assetPath('/'+form.attachment_file)" target="_blank">
                                {{form.attachment_number}}
                                </a>
                                <a class="btn btn-secondary text-right pl-5" :href="assetPath('/'+form.attachment_file)" target="_blank">
                                See the Attachment
                                </a>

                            </span>
                            <span class="lower_border" v-else>{{form.attachment_number}}</span>
                        </dd>
                        <br>
                        <dt>9.<span></span>Blood Group<span class="required">*</span></dt>
                        <dd>
                            <span class="lower_border">{{form.blood_group}}</span>
                        </dd>
                        <br>
                        <dt>10.<span id="id3"></span>Previous year ({{form.form_year - 1}}) ID Card No.<span
                            class="required">*</span></dt>
                        <dd><span class="lower_border">{{form.previous_year_id_card_number}}</span></dd>
                        <br>
                        <dt>11.<span id="id3"></span>Police Verification/clearance issue date<span
                            class="required">*</span>
                        </dt>
                        <dd><span class="lower_border">
                            <span v-if="form.police_verification_attachment">
                                <a :href="assetPath('/'+form.police_verification_attachment)" target="_blank">
                                {{form.police_verification}}
                                </a>
                                <a class="btn btn-secondary text-right pl-5" :href="assetPath('/'+form.police_verification_attachment)" target="_blank">
                                See the Attachment
                                </a>
                            </span>
                            <span v-else>{{form.police_verification}}</span>
                        </span></dd>
                        <br>
                        <dt>12.<span id="id3"></span>Cargo Security Awareness Training Status</dt>
                        <dd>
                                        <span id="id4">
                                            <span v-if="form.training_status == 'yes'">√</span>
                                        </span>
                            <label for="training_status1">Yes</label>
                            <span id="id4">
                                            <span v-if="form.training_status == 'no'">√</span>
                                        </span>
                            <label for="training_status2">No</label>
                            <span id="id4"></span><b>(Please mark √)</b>
                        </dd>
                        <br>
                        <div v-if="form.training_status == 'yes'">
                            <dt><span id="id4"></span>If “Yes” please mentioned details<span
                                class="required">*</span></dt>
                            <dd>Training Date :
                                <span class="lower_border" style="width: 32%">{{form.training_date | date_format}}</span>
                                <!--                                        _______/______/20_______-->
                            </dd>

                            <dt class="dt-dot">.</dt>
                            <dd>Valid CAAB ID No. :
                                <span class="lower_border" style="width: 23%">{{form.caab_id_no}}</span>
                            </dd>
                        </div>
                    </dl>
                </div>
                <div class="sign-field">

                    <div class="second-sign">
                        <img class="sign-img1" v-if="form.card_holder_signature_attachment"  :src="assetPath('/'+form.card_holder_signature_attachment)" alt="">
                        <div>
                            _____________________
                        </div>
                        <div>
                            Card Holder’s Signature<span class="required">*</span>
                        </div>
                    </div>
                </div>
<!--                <div class="sign-field">-->
<!--                    <div class="first-sign">-->
<!--                        <div>-->
<!--                            <span class="lower_border" style="width: 100%">-->
<!--                                 <img v-if="form.signature"  class="attach_image" :src="addProjectPath('/'+form.signature)" alt="">-->
<!--                            </span>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <b>Seal & Signature of Chairman/MD/ Director<span class="required">*</span></b>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <b>Managing Partner/Proprietor</b>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="second-sign">-->
<!--                        <div>-->
<!--                            <span class="lower_border" style="width: 100%"><img  v-if="form.card_holder_signature_attachment"  class="attach_image" :src="addProjectPath('/'+form.card_holder_signature_attachment)" alt=""></span>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <b>Card Holder’s Signature<span class="required">*</span></b>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
                <p class="class4">I would like to request to provide the ID card for the following regular
                employee/staff of my/our company for the year {{form.form_year}}. In connection with the above, I (undersigned
                management person) do hereby declare that, above person is my/our regular employee and being the
                employer of mentioned employee, me (undersigned management person) and my company will be held fully
                responsible and liable in case of any unlawful/fraudulent activities been carried out by my/our
                employee by holding BAFFA ID Card at HSIA Cargo Village, and in any circumstances BAFFA and any of
                its Staff/Directors should not be held liable or responsible for such unlawful/fraudulent
                activities.</p>
                <div class="sign-field">
                    <div class="first-sign">
                        <img class="sign-img1"  v-if="form.signatory_attachment"  :src="assetPath('/'+form.signatory_attachment)" alt="">
                        <div>
                            _____________________________________
                        </div>
                        <div class="sign-center">
                            Signature of Chairman/MD/ Director<span class="required">*</span>
                        </div>
                        <div class="sign-center">
                            Managing Partner/Proprietor
                        </div>
                    </div>
                </div>


                <div class="signature">
                    <!-- <p>_________________</p>
                    <div class="d-flex">
                        <p>Signature & Date</p>
                        <p>:</p>
                    </div> -->
                    <div class="d-flex">
                        <p>Name of the Signatory: </p>
                        <p>: {{form.company_owner.name}}</p>
                    </div>
                    <div class="d-flex">
                        <p>Designation</p>
                        <p>: {{form.designation}}</p>
                    </div>
                    <div class="d-flex">
                        <p>Company Name</p>
                        <p>:</p>
                        <ol>
                            <li v-for="member in form.members">{{member}}</li>
                        </ol>
                    </div>
                </div>

<!--                <div class="req">-->
<!--                    <p><b><u>REQUIREMENTS FOR ID CARD:</u></b></p>-->
<!--                    <ol>-->
<!--                        <li>2 (two) copies prescribed Application Form (enclosed) for each ID card duly filled-->
<!--                            up.-->
<!--                        </li>-->
<!--                        <li>2 (two) photocopies of Police Verification/Clearance Certificate’s <span-->
<!--                            class="red-text">(Police-->
<!--                            Verification/Clearance Certificate issue date must be after 31st December 2020, that means-->
<!--                            not-->
<!--                            more than two years old).</span></li>-->
<!--                        <li>2 (two) photocopies of National ID/Passport/Birth certificate.</li>-->
<!--                        <li>“Declaration” from the Chairman/Managing Director/Director/Managing-->
<!--                            Partner/Proprietor on the-->
<!--                            Letterhead Pad of the member company. (Sample of declaration is enclosed).-->
<!--                        </li>-->
<!--                        <li>2 (two) recent passport size color photographs for each applicant.</li>-->
<!--                        <li>Tk. 1,000/- (Taka one thousand) only has to be deposited to BAFFA for each ID card-->
<!--                            through an-->
<!--                            A/C Payee Cheque/ Pay Order to be drawn in favour of <span class="baffa">“Bangladesh Freight-->
<!--                            Forwarders-->
<!--                            Association”.</span></li>-->
<!--                        <li>BAFFA Annual Subscription of Tk. 5,000/-(Taka five thousand) only for the year 2022-->
<!--                            and other-->
<!--                            dues (if any) to the member company, which has to be paid before taking delivery of-->
<!--                            ID Card 2022-->
<!--                            from the secretariat through an A/C Payee Cheque/Pay Order to be drawn in favour of-->
<!--                            <span-->
<!--                                class="baffa">“Bangladesh Freight Forwarders-->
<!--                            Association”.</span></li>-->
<!--                        <li>During received the new ID Card-2022, deposit your existing ID Card-2021 (if-->
<!--                            applicable).-->
<!--                        </li>-->
<!--                    </ol>-->
<!--                    <p><b>N.B: ID card Holder’s Photographs, Valid Police Verification/ Clearance Certificate,-->
<!--                        National ID/-->
<!--                        Passport/ Birth Certificate must be attested by the Chairman/ Managing Director/-->
<!--                        Director/ Managing-->
<!--                        Partner/ Proprietor of the Company/Firm along with his/her official stamp/seal.</b></p>-->
<!--                </div>-->
<!--                <div class="ftr1">-->
<!--                    <img :src="addProjectPath('/front/assets/img/id_card/ftr1.png')" alt="">-->
<!--                                                    <img src="img/ftr1.png" alt="">-->
<!--                </div>-->
            </div>
        </main>
        <link type="text/css" rel="stylesheet" :href="addProjectPath('/front/assets/css/id-card-style.css')">
    </div>
</template>

<script>
import moment from "moment";
import ValidationErrors from "../ValidationErrors";

export default {
    name: "MemberViewIDCard",
    components: {moment},
    data() {
        return {
            form: {
                card_holder_name: '',
                training_status: 'yes',
                attachment_name: 'National ID',
                dob: new Date().toISOString().slice(0, 10),
                training_date: new Date().toISOString().slice(0, 10),
                members:[],
                member:[],
                company_owner:[]
            },
        }
    },
    created() {
        this.getGatePass()
    },
    filters: {
        date_format: function (value) {
            if (value) {
                return moment(String(value)).format('DD/MM/YYYY')
            }
        }
    },
    methods: {
        getGatePass() {
            axios.get('/api/id_cards/' + this.$route.params.id)
                .then(res => {
                    this.form = res.data
                    this.form.members = this.form.members.map(v => v.organization_name);
                }).catch(error => {
                console.log('Error: ', error.response)
            }).finally(()=>{
                setTimeout(function(){
                    // window.print()
                },1000);
            })
        },
        doBack(){
            console.log('Click')
            this.$router.go(-1)
        }
    }
}
</script>
<style scoped>
.attach_image{
    width:150px;
    height:25px;
}
.lower_border {
    display: inline-block;
    width: 49%;
    border: none;
    border-bottom: 1px solid black;
    padding: 5px 10px;
    outline: none;
}
.signature p {
    margin: 0;
}

.signature .d-flex {
    display: flex;
    justify-content: left;
    padding-right: 145px;
    margin-top: 4px;
}
.signature .d-flex > p:first-child{
    width: 236px;
}
.ftr1 img {
    width: 100%;
    margin-top: 20px;
}
.class4 {
    margin-top: 20px;
}
.sign-img1 {
    width: 100px;
}
</style>
