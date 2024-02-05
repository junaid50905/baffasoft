<template>
    <div class="container">
            <link
                type="text/css"
                rel="stylesheet"
                :href="addProjectPath('/front/assets/css/re-newal-form-style.css')"
            />
            <div class="row">
                <div class="col-sm-12 d-grid " style="padding-top: 38px;" v-if="!is_member">
                    <a style="width: 23%;margin: 0 auto;" class="btn btn-outline-primary btn-sm btn-block" target="_blank"
                       :href="addProjectPath('/print_renew_member/'+ $route.params.id)">Print</a>
                </div>
                <div class="col-sm-3">
                    <img style="width: 152px;"
                         :src="addProjectPath('/front/assets/img/id_card/baffa-logo.png')"
                         alt=""

                    />
                </div>
                <div class="col-sm-9">
                    <img style="width: 554px; padding-top: 38px;" :src="addProjectPath('/front/assets/img/id_card/id-title.png')" alt=""/>
                </div>
            </div>
            <div class="row" style="margin-top: 25px;">

                <div class="col-sm-3 date_left">Date : {{formData.date_of_renewal}}</div>
                <div class="col-sm-6" id="idOne">
                    <p v-if="formData.structure_change">Membership Structure Change Form</p>
                    <p v-else >BAFFA MEMBERSHIP RENEWAL FORM - {{formData.submission_year}}</p>
                </div>
                <div class="col-sm-3 photo_sec">
                    <img v-if="contact_person.attach_photograph" :src="assetPath('/'+contact_person.attach_photograph)" alt=""  alt="Contact Person Photo"/>
                    <img v-else :src="addProjectPath('/assets/img/photo-icon.png')"/>
                </div>

            </div>

            <div class="row" style="margin-top: 25px;">
                <div class="col-12">
                    <div class=" res_tabel-siz">
                        <table class="data_set ">

                            <tr>
                                <td width="306px">01. Name of Organization</td>
                                <td width="5px">:</td>
                                <td> <p> {{ formData.firm_name }} </p></td>
                            </tr>
                            <tr>
                                <td>02. Type of the Organization </td>
                                <td>:</td>
                                <td><p> {{ firmTypeLabel + ' - ' + formData.type_local }} </p></td>
                            </tr>
                            <tr>
                                <td>03. Name of the Contact Person</td>
                                <td>:</td>
                                <td><p> {{contact_person.name}}</p></td>
                            </tr>
                            <tr>
                                <td>04. Designation of the Contact Person</td>
                                <td>:</td>
                                <td><p>{{formData.contact_person_designation}}</p></td>
                            </tr>

                        </table>

                        <table class="data_set ">
                            <tr>
                                <td width="306px">05. Membership Number</td>
                                <td width="5px">:</td>
                                <td><p> {{formData.membership_number}}</p></td>
                                <td style="width: 150px;padding-left: 10px;">Date of Admission :</td>
                                <td> <p>{{formData.date_of_admission}}</p></td>
                            </tr>
                        </table>
                        <table class="data_set ">
                            <tr>
                                <td width="306px">06. Place of Enlistment</td>
                                <td width="5px">:</td>
                                <td> <p> {{formData.place_of_enlistment}} </p></td>
                            </tr>

                            <tr>
                                <td width="306px">07. Registered Address</td>
                                <td width="5px">:</td>
                                <td> <p style="height: fit-content;">
                                    <span v-if="formData.registered_office">
                                        <span v-if="formData.registered_office.address">{{formData.registered_office.address}}</span>
<!--                                        <span v-if="formData.registered_office.floor_area">{{formData.registered_office.floor_area}},</span>
                                        <span v-if="formData.registered_office.telephone_no">{{formData.registered_office.telephone_no}},</span>
                                        <span v-if="formData.registered_office.fax_no">{{formData.registered_office.fax_no}},</span>
                                        <span v-if="formData.registered_office.mobile_no">{{formData.registered_office.mobile_no}},</span>
                                        <span v-if="formData.registered_office.email_address">{{formData.registered_office.email_address}},</span>
                                        <span v-if="formData.registered_office.website">{{formData.registered_office.website}}</span>-->
                                    </span></p></td>
                            </tr>
                            <tr>
                                <td width="306px">08. Current Address</td>
                                <td width="5px">:</td>
                                <td> <p style="height: fit-content;">
                                    <span v-if="formData.current_office">
                                        <span v-if="formData.current_office.address">{{formData.current_office.address}}</span>
<!--                                        <span v-if="formData.current_office.floor_area">{{formData.current_office.floor_area}},</span>
                                        <span v-if="formData.current_office.telephone_no">{{formData.current_office.telephone_no}},</span>
                                        <span v-if="formData.current_office.fax_no">{{formData.current_office.fax_no}},</span>
                                        <span v-if="formData.current_office.mobile_no">{{formData.current_office.mobile_no}},</span>
                                        <span v-if="formData.current_office.email_address">{{formData.current_office.email_address}},</span>
                                        <span v-if="formData.current_office.website">{{formData.current_office.website}}</span>-->
                                    </span>
                                     </p></td>
                            </tr>
                            <tr>
                                <td width="306px">09. Branch Office Address</td>
                                <td width="5px">:</td>
                                <td><p style="height: fit-content;">
                                    <span v-if="formData.branch_office">
                                        <span v-if="formData.branch_office.address">{{formData.branch_office.address}}</span>
<!--                                        <span v-if="formData.branch_office.floor_area">{{formData.branch_office.floor_area}},</span>
                                        <span v-if="formData.branch_office.telephone_no">{{formData.branch_office.telephone_no}},</span>
                                        <span v-if="formData.branch_office.fax_no">{{formData.branch_office.fax_no}},</span>
                                        <span v-if="formData.branch_office.mobile_no">{{formData.branch_office.mobile_no}},</span>
                                        <span v-if="formData.branch_office.email_address">{{formData.branch_office.email_address}},</span>
                                        <span v-if="formData.branch_office.website">{{formData.branch_office.website}}</span>-->
                                    </span></p>
                                </td>
                            </tr>
                            <tr>
                                <td width="306px">10. Telephone No. </td>
                                <td width="5px">:</td>
                                <td><p> {{formData.telephone_no}} </p></td>
                            </tr>
                        </table>
                        <table class="data_set ">
                            <tr>
                                <td width="306px">11. Mobile No.</td>
                                <td width="5px">:</td>
                                <td><p> {{formData.mobile_no}}</p></td>
                                <td style="width:82px;padding-left: 10px;"><b>Fax No</b> :</td>
                                <td> <p>   {{formData.fax_no}}  </p></td>
                            </tr>
                            <tr>
                                <td width="306px">12. E-mail (for all communication)</td>
                                <td width="5px">:</td>
                                <td><p> {{formData.email_address}} </p></td>
                                <td style="width:82px;padding-left: 10px;"><b>Website</b> :</td>
                                <td> <p>  {{formData.website}}   </p></td>
                            </tr>
                        </table>
                        <table class="data_set ">
                            <tr>
                                <td width="306px">13. Freight Forwarders License No</td>
                                <td width="5px">:</td>
                                <td style="width:28%;">
                                    <p> {{formData.freight_forwarders_license_number}}
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <a v-if="formData.attach_ff_license_no !== null"
                                           class="attast_but"
                                           :href="assetPath('/' + formData.attach_ff_license_no)"
                                           target="_blank"
                                        >See Attachment
                                        </a>
                                    </p>

                                </td>
                                <td style="width:16%;padding-left:10px;"><b>Date of Validity</b> :</td>
                                <td> <p>  {{formData.freight_forwarders_license_date}}   </p></td>
                            </tr>
                        </table>
                        <table class="data_set ">
                            <tr>
                                <td width="306px">14.Trade License No</td>
                                <td width="5px">:</td>
                                <td><p> {{formData.trade_license_number}} </p></td>
                                <td style="width:14%;padding-left: 10px;">
                                    <a v-if="formData.attach_trade_license !== null"
                                       class="attast_but"
                                       :href="assetPath('/' + formData.attach_trade_license)"
                                       target="_blank"
                                    >See Attachment
                                    </a></td>
                                <td style="width:16%;padding-left: 10px;"><b>Date of Validity</b> :</td>
                                <td style="width: 12%;"> <p>  {{formData.trade_license_date}}  </p></td>
                            </tr>
                        </table>
                        <table class="data_set ">
                            <tr>
                                <td width="306px">15. e-TIN No</td>
                                <td width="5px">:</td>
                                <td width= "50%"><p>   {{formData.tin_number}}  </p></td>
                                <td style="text-align: center;">
                                    <a v-if="formData.attach_e_tin_certificate !== null"
                                       class="attast_but"
                                       :href="assetPath('/' + formData.attach_e_tin_certificate)"
                                       target="_blank"
                                    >See Attachment
                                    </a></td>
                            </tr>

                        </table>
                        <table class="data_set ">
                            <tr>
                                <td width="306">16. Any Change in Company Structure</td>
                                <td width="5px">:</td>
                                <td style="width: 40px;">
                                    <i v-bind:class="[ formData.any_change == '1' ? 'fa-check-square' : 'fa-square', 'far',]" style="font-size:24px; padding-left: 10px;"></i></td>
                                <td style="width: 40px;"> YES  </td>
                                <td style="width: 40px;">
                                    <i v-bind:class="[formData.any_change == '0' ? 'fa-check-square' : 'fa-square','far',]" style="font-size:24px;padding-left: 10px;"></i></td>
                                <td> NO </td>

                            </tr>
                        </table>

                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-sm-4 sing_tex" style="margin-top: 43px;">
                    <img class="sign-img1" v-if="contact_person.attach_signature" :src="assetPath('/'+contact_person.attach_signature)" alt="" width="150" height="80" alt="Signature"/>
                    <div class="sign-center" style="text-decoration: overline">
                        Signature of the Contact Person
                    </div>
                    <p>Name : {{contact_person.name}}</p>
                    <p>Designation : {{contact_person.designation}}</p>
                </div>


                <div class="col-sm-12"  style="margin-top: 43px;">
                    <h6>THE FOLLOWING DOCUMENTS ARE REQUIRED FOR BAFFA MEMBERSHIP RENEWAL</h6>
                    <ol style="font-size: 14px;">
                        <li>Duly filled up BAFFA membership renewal form.</li>
                        <li>Please Upload Trade License and Freight Forwarders License.</li>
                        <li>Please Upload all Shareholder Directors/Partners/Proprietor’s NID card or Passport (if NID not available).</li>
                        <li>Please Upload e-TIN Certificate.</li>
                        <li>Updated Form-XII for Limited Company & updated partnership deed for Partnership Company. If there has been a structural change, please upload these in the Freight Forwarders License attachment area together with the valid Freight Forwarders License.</li>
                        <li>Recent photograph of the contact person or owners.</li>
                        <li>Annual Subscription Fee Tk. 5,000/= (five thousand) A/C Payee Cheque/Pay Order in favors of <b>“Bangladesh Freight Forwarders Association”</b>.</li>
                    </ol>

                    <div class="location1">
                        <span class="bg-a">Dhaka Office <i class="fas fa-map-marker-alt"></i></span> House No.
                        10(Level-2 & 3),Road No.17A Block-E,Banani,Dhaka-1213,Tel.+88028836324-25,Fax:+88
                        02222281664,Email:info@baffa-bd.org
                    </div>
                    <div class="location1">
                        <span class="bg-a">Chattagram Office <i class="fas fa-map-marker-alt"></i></span> Anwara
                        Trade Center (Level-10),1728,Agrabad C/A Chattagroam, Tel: +8802
                        333323453,333323505,Email:admin.ctg@baffa-bd.org
                    </div>
                </div>
            </div>
    </div>
</template>


<script>
export default {
    name: "ViewRenewalMember",
    props: ["is_member"],
    data: () => ({
        firmType: "Proprietor",
        firmTypeLabel: null,
        formData: {},
        contact_person: {
            attach_photograph: null
        }
    }),
    created: function () {
        this.getMember();
    },
    methods: {
        getMember: function () {
            axios
                .get("/api/renew_member/" + this.$route.params.id)
                .then((res) => {
                    this.formData = res.data.data;
                    this.firmType = this.formData.firm_type;
                    if (this.firmType == 'Proprietor')
                        this.firmTypeLabel = 'Proprietorship';
                    else if (this.firmType == 'Partners')
                        this.firmTypeLabel = 'Partnership';
                    else if (this.firmType == 'Limited')
                        this.firmTypeLabel = 'Limited';
                    if(this.formData.contact_person)
                        this.contact_person = this.formData.contact_person;
                })
                .catch((error) => {
                    console.error("Error", error.response);
                });
        },
    },
};
</script>

<style scoped>
</style>
