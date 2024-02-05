<template>
    <div>
        <notifications group="foo" position="bottom right"/>
        <div class="card">
            <div class="card-header">
                <router-link :to="{name: 'id-card-print',params: { id: $route.params.id }}" target="_blank"
                             class="btn btn-secondary btn-lg btn-block"
                             title="Print ID Card Form"
                             data-toggle="tooltip" data-placement="top"
                > Print ID Card Form</router-link>
                <router-link :to="{name: 'id-card-print2',params: { id: $route.params.id }}" target="_blank"
                             class="btn btn-info btn-lg btn-block"
                             title="Print Reference Form"
                             data-toggle="tooltip" data-placement="top"
                > Print Declaration Form</router-link>
<!--                <button type="button" class="btn btn-secondary btn-lg btn-block" onclick="window.print()">Print-->
<!--                </button>-->
            </div>
            <div class="card-body">
                <main id="printMe">
                        <div class="container">
                            <div class="boxNew">
                                <div class="logoNew">
                                    <img :src="addProjectPath('/front/assets/img/id_card/baffa-logo.png')" alt="">
                                    <img src="img/baffa-logo.png" alt="">
                                </div>
                                <div class="title">
                                    <img :src="addProjectPath('/front/assets/img/id_card/id-title.png')" alt="">
                                    <img src="img/id-title.png" alt="">
                                    <p id="idOne">ID CARD FORM-2022</p>
                                </div>
                                <div class="form-new">
                                    <img :src="addProjectPath('/front/assets/img/id_card/pp.png')" alt="">
                                    <!--                                <img src="img/pp.png" alt="">-->
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
                                    <dd><span class="lower_border">{{form.card_holder_designation}}</span></dd>
                                    </dt>
                                    <dd><span class="lower_border">{{form.organization_name}}</span></dd>
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
                                        <br>
                                        <span id="idTwo"></span>No.
                                        <span class="required">*</span>
                                    </dt>
                                    <dd>
                                        <span class="lower_border">{{form.attachment_number}}</span>
                                    </dd>
                                    <br>
                                    <dt>9.<span></span>Blood Group<span class="required">*</span></dt>
                                    <dd>
                                        <span class="lower_border">{{form.blood_group}}</span>
                                    </dd>
                                    <br>
                                    <dt>10.<span id="id3"></span>Previous year (2021) ID Card No.<span
                                        class="required">*</span></dt>
                                    <dd><span class="lower_border">{{form.previous_year_id_card_number}}</span></dd>
                                    <br>
                                    <dt>11.<span id="id3"></span>Police Verification/clearance issue date<span
                                        class="required">*</span>
                                    </dt>
                                    <dd><span class="lower_border">{{form.police_verification}}</span></dd>
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
                                            <span class="lower_border" style="width: 36%">{{form.training_date | date_format}}</span>
                                            <!--                                        _______/______/20_______-->
                                        </dd>

                                        <dt class="dt-dot">.</dt>
                                        <dd>Valid CAAB ID No. :
                                            <span class="lower_border" style="width: 31%">{{form.caab_id_no}}</span>
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                            <div class="sign-field">
                                <div class="first-sign">
                                    <div>
                                        <span class="lower_border" style="width: 100%">
                                            <img v-if="form.signature" class="attach_image" :src="assetPath('/'+form.signature)" alt="">
                                        </span>
                                    </div>
                                    <div>
                                        <b>Seal & Signature of Chairman/MD/ Director<span class="required">*</span></b>
                                    </div>
                                    <div>
                                        <b>Managing Partner/Proprietor</b>
                                    </div>
                                </div>
                                <div class="second-sign">
                                    <div>
                                        <span class="lower_border" style="width: 100%">
                                        <img v-if="form.card_holder_signature" class="attach_image" :src="assetPath('/'+form.card_holder_signature)" alt="">
                                        </span>
                                    </div>
                                    <div>
                                        <b>Card Holder’s Signature<span class="required">*</span></b>
                                    </div>
                                </div>
                            </div>
                            <div class="req">
                                <p><b><u>REQUIREMENTS FOR ID CARD:</u></b></p>
                                <ol>
                                    <li>2 (two) copies prescribed Application Form (enclosed) for each ID card duly filled
                                        up.
                                    </li>
                                    <li>2 (two) photocopies of Police Verification/Clearance Certificate’s <span
                                        class="red-text">(Police
                            Verification/Clearance Certificate issue date must be after 31st December 2020, that means
                            not
                            more than two years old).</span></li>
                                    <li>2 (two) photocopies of National ID/Passport/Birth certificate.</li>
                                    <li>“Declaration” from the Chairman/Managing Director/Director/Managing
                                        Partner/Proprietor on the
                                        Letterhead Pad of the member company. (Sample of declaration is enclosed).
                                    </li>
                                    <li>2 (two) recent passport size color photographs for each applicant.</li>
                                    <li>Tk. 1,000/- (Taka one thousand) only has to be deposited to BAFFA for each ID card
                                        through an
                                        A/C Payee Cheque/ Pay Order to be drawn in favour of <span class="baffa">“Bangladesh Freight
                            Forwarders
                            Association”.</span></li>
                                    <li>BAFFA Annual Subscription of Tk. 5,000/-(Taka five thousand) only for the year 2022
                                        and other
                                        dues (if any) to the member company, which has to be paid before taking delivery of
                                        ID Card 2022
                                        from the secretariat through an A/C Payee Cheque/Pay Order to be drawn in favour of
                                        <span
                                            class="baffa">“Bangladesh Freight Forwarders
                            Association”.</span></li>
                                    <li>During received the new ID Card-2022, deposit your existing ID Card-2021 (if
                                        applicable).
                                    </li>
                                </ol>
                                <p><b>N.B: ID card Holder’s Photographs, Valid Police Verification/ Clearance Certificate,
                                    National ID/
                                    Passport/ Birth Certificate must be attested by the Chairman/ Managing Director/
                                    Director/ Managing
                                    Partner/ Proprietor of the Company/Firm along with his/her official stamp/seal.</b></p>
                            </div>
                            <div class="ftr1">
                                <img src="img/ftr1.png" alt="">
                            </div>
                        </div>
                </main>
            </div>
        </div>
        <link type="text/css" rel="stylesheet" :href="addProjectPath('/front/assets/css/id-card-style.css')">
    </div>
</template>

<script>
import ValidationErrors from "../ValidationErrors";
import moment from "moment";

export default {
    name: "ViewIDCard",
    components: {ValidationErrors, moment},
    data: () => ({
        members: [],
        loading: false,
        errors: [],
        validationErrors: null,
        success: null,
        warning_message:null,
        isLoggedIn: false,
        user: null,
        form: {
            card_holder_name: '',
            training_status: 'yes',
            attachment_name: 'National ID',
            dob: new Date().toISOString().slice(0, 10),
            training_date: new Date().toISOString().slice(0, 10)
        }

    }),
    created: function () {
        this.getMember()
        // this.getCountries()
        // if(this.member.email){
        //     console.log(this.member)
        // }else {
        //     console.log('sorry')
        // }
    },
    filters: {
        date_format: function (value) {
            if (value) {
                return moment(String(value)).format('DD/MM/YYYY')
            }
        }
    },
    methods: {
        getMember: function () {
            axios.get('/api/id_card/' + this.$route.params.id )
                .then(res => {
                    this.form = res.data
                    // this.form.username = res.data.data['username']
                    // this.form.email = res.data.data.email
                    // this.form.first_name = res.data.data.first_name
                    // this.form.status = res.data.data.status
                    // if (res.data.data['member_detail']) {
                    //     this.firmType = res.data.data['member_detail']['firm_type']
                    //     this.tempForm = res.data.data['member_detail']
                    //     Object.keys(this.tempForm).forEach((item) => {
                    //         if (this.tempForm[item]) {
                    //             this.form[item] = this.tempForm[item]
                    //         }
                    //     });
                    // }
                }).catch(error => {
                console.error('Error', error.response)
            })
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
@media print {
    .card-header, .card-header * {
        visibility: hidden;
    }
    body, page {
        margin: 0;
        box-shadow: 0;
    }


}
</style>
