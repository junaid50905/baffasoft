<template>
    <div class="container">
        <div class="row justify-content-center">
            <!-- <img :src="addProjectPath('/front/assets/img/frome.jpg')"
                  alt=""
                  style="border: 5px solid white"
                  width="150"
                  height="150" /> -->
            <div class="col-sm-3 text-right" v-if="checkAccess('edit_member')">
                <router-link
                    :to="{ name: 'edit-member', params: { id: $route.params.id } }"
                    class="btn btn-outline-primary btn-lg btn-block"
                >EDIT</router-link>
<!--                <button type="button" class="btn btn-outline-primary btn-lg btn-block">EDIT</button>-->
            </div>
            <div class="col-sm-3">
                <a class="btn btn-outline-primary btn-lg btn-block" target="_blank"
                   :href="addProjectPath('/print_member/'+ $route.params.id)">Print</a>
<!--                <button type="button" class="btn btn-outline-primary btn-lg btn-block">Print</button>-->
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="round_box table-responsive">
                    <table class="table table-borderless table-sm table-condensed">
                        <tbody>
                        <tr>
                            <td class="w-200">Name of Organization</td>
                            <td class="w-10">:</td>
                            <td>{{ form.organization_name }}</td>
                        </tr>
                        <tr>
                            <td>Membership Number</td>
                            <td>:</td>
                            <td>{{ form.username }}</td>
                        </tr>
                        <tr>
                            <td>Place of Enlistmen</td>
                            <td>:</td>
                            <td>{{ form.place_of_enlistment }}</td>
                        </tr>
                        <tr>
                            <td>Type of the Organization</td>
                            <td>:</td>
                            <td>{{ firmTypeLabel }} - {{form.type_local}}, <a id="printPDF" :href="assetPath('/' + form.attach_article)" target="_blank">{{ firmAttachmentLabel}}</a></td>
                        </tr>
                        <tr>
                            <td>Activity Status</td>
                            <td>:</td>
                            <td>{{ form.status }}</td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12">
                <h3 class="text-center">Company Owner(s) information</h3>
                <div class="round_box table-responsive-sm" v-for="company_owner in form.company_owners">
                    <table class="table table-borderless table-sm m-0 table-condensed">
                        <tbody>
                        <tr>
                            <td rowspan="11" class="w-200 pic-siz">
                                <img v-if="company_owner.attach_photograph !== null"
                                    :src="addProjectPath('/' + company_owner.attach_photograph)"
                                    alt="PHOTO" style="border: 5px solid white" width="128" height="156"/>
                                <img v-else :src="addProjectPath('/assets/img/photo-icon.png')"/>
                                <div class="sig">
                                    <img v-if="company_owner.attach_signature !== null"
                                        :src="addProjectPath('/' + company_owner.attach_signature)"
                                        alt="Signature" width="200" height="70"/>
                                    <img v-else :src="addProjectPath('/assets/img/sig-icon.png')"  width="200" height="70"/>
                                </div>
                            </td>
                            <td class="w-300 text-right">Name</td>
                            <td class="w-10">:</td>
                            <td>{{ company_owner.name }}</td>
                        </tr>
                        <tr>
                            <td class="w-300 text-right">Designation</td>
                            <td>:</td>
                            <td>{{ company_owner.designation }}</td>
                        </tr>
                        <tr>
                            <td class="w-300 text-right">Nationality</td>
                            <td>:</td>
                            <td>{{ company_owner.nationality_name }}</td>
                        </tr>
                        <tr>

                            <td class="w-300 text-right">NID No</td>
                            <td>:</td>
                            <td>{{ company_owner.nid_no }}
                                <span v-if="company_owner.attach_nid !== null">
                                    <b> - </b><a :href="assetPath('/' + company_owner.attach_nid)"
                                                 target="_blank">See the Attached NID</a>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="w-300 text-right">Educational qualification</td>
                            <td>:</td>
                            <td>{{ company_owner.educational_qualification }}
                                <span v-if="company_owner.attach_educational_qualification !== null">
                                    <b> - </b><a :href="assetPath('/' + company_owner.attach_educational_qualification)"
                                                 target="_blank">See the Educational Certificate</a>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="w-300 text-right">Mobile No</td>
                            <td>:</td>
                            <td>{{ company_owner.mobile_no }}</td>
                        </tr>
                        <tr>
                            <td class="w-300 text-right">Email</td>
                            <td>:</td>
                            <td>{{ company_owner.email }}</td>
                        </tr>
                        <tr>
                            <td class="w-300 text-right">Experience Year</td>
                            <td>:</td>
                            <td>
                                <span v-if="company_owner.experience_year">
                                    {{ company_owner.experience_year }} Years
                                </span>
                                <span v-if="company_owner.attach_experience_certificate !== null">
                                    <a :href="assetPath('/' + company_owner.attach_experience_certificate)"
                                   target="_blank">(See the Experience Certificate)</a>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="w-300 text-right">Signatory</td>
                            <td>:</td>
                            <td>{{ company_owner.signatory == 1 ? 'Yes' : 'No' }}</td>
                        </tr>
                        <tr>
                            <td class="w-200 text-right">Authorized Person</td>
                            <td>:</td>
                            <td>{{ company_owner.authorized_person  == 1 ? 'Yes' : 'No' }}</td>
                        </tr>
                        <tr>
                            <td class="w-200 text-right">Nominate For Vote</td>
                            <td>:</td>
                            <td>{{ company_owner.nominate_for_vote  == 1 ? 'Yes' : 'No' }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-sm-4 addres_box">
                <h5>Register Address</h5>
                <ul class="list-inline ">
                    <li>{{ form.head_office_address }}</li>
                    <li><b>Total Floor Area:</b> {{ form.head_office_floor_area }}</li>
                    <li><b>Telephone No:</b> {{ form.head_office_telephone_no }}</li>
                    <li><b>Fax No:</b> {{ form.head_office_fax_no }}</li>
                    <li><b>Mobile No:</b> {{ form.head_office_mobile_no }}</li>

                    <li><b>E-mail Address:</b> {{ form.head_office_email_address }}</li>
                    <li><b>Land document:</b>
                        <span v-if="form.head_office_attach_office_tenancy_agreement">
                            <a :href="assetPath( '/' + form.head_office_attach_office_tenancy_agreement)
                                "target="_blank">See Attachment</a>
                        </span>
                    </li>
                </ul>

            </div>
            <div class="col-sm-4 addres_box">
                <h5>Warehouse Address</h5>
                <ul class="list-inline">
                    <li>{{ form.warehouse_office_address }}</li>
                    <li><b>Total Floor Area:</b> {{ form.warehouse_office_floor_area }}</li>
                </ul>

            </div>
            <div class="col-sm-4 addres_box">
                <h5>Branch Office Address:</h5>
                <ul class="list-inline ">
                    <li>{{ form.branch_office_address }}</li>
                    <li><b>Total Floor Area:</b> {{ form.branch_office_floor_area }}</li>
                    <li><b>Telephone No:</b> {{ form.branch_office_telephone_no }}</li>
                    <li><b>Fax No:</b> {{ form.branch_office_fax_no }}</li>
                    <li><b>Mobile No:</b> {{ form.branch_office_mobile_no }}</li>

                    <li><b>E-mail Address:</b> {{ form.branch_office_email_address }}</li>
                    <li><b>Land document:</b>
                        <span v-if="form.branch_office_attach_office_tenancy_agreement">
                            <a :href="assetPath( '/' + form.branch_office_attach_office_tenancy_agreement)
                                "target="_blank">See Attachment</a>
                        </span>
                    </li>
                </ul>

            </div>

        </div>


        <!-- last table -->
        <div class="row">
            <div class="col-12-lg last_tab_set table-responsive-sm">

                <table class="star_1 table">
                    <caption> Particulars of Certificate of Registration/Incorporation</caption>
                    <tr>
                        <td><b>Number:</b> {{ form.particulars_of_certificate_number }}</td>
                        <td><b>Date :</b> {{ form.particulars_of_certificate_date | date_format }}</td>
                    </tr>
                </table>
                <table class="star_1 table" v-if="firmType !== 'Proprietor'">
                    <caption>
                        <span v-if="firmType === 'Partners'"> Approval of Registration </span>
                        <span v-if="firmType === 'Limited'"> Incorporation Certificate </span>
                    </caption>
                    <tr>
                        <td><span v-if="form.attach_incorporation_certificate">
                      <a :href="assetPath('/' + form.attach_incorporation_certificate)"
                         target="_blank">See the Attachment</a></span>
                            <span v-else><b>N/A</b></span>
                        </td>
                    </tr>
                </table>
                <table class="star_1 table">
                    <caption> Date of Establishment of the Firm</caption>
                    <tr>
                        <td><b>Date of Establishment of the Firm:</b>{{ form.date_of_establishment | date_format }}</td>
                    </tr>
                </table>
                <table class="star_1 table">
                    <caption> Trade License</caption>
                    <tr>
                        <td><b>No. </b>{{ form.trade_license_number }}</td>
                        <td><b>Validity: </b>{{ form.trade_license_date | date_format }}</td>
                        <td><b>Attachment: </b><span v-if="form.attach_trade_license"><a
                            :href="assetPath('/' + form.attach_trade_license)"
                            target="_blank">Trade License</a></span><span v-else><b>N/A</b></span></td>
                    </tr>
                </table>
                <table class="star_1 table">
                    <caption> e-TIN No</caption>
                    <tr>
                        <td><b>No: </b>{{ form.tin_number }}</td>
                        <td><b>Attachment: </b><span v-if="form.attach_e_tin_certificate"><a
                            :href="assetPath('/' + form.attach_e_tin_certificate)"
                            target="_blank">e-TIN Certificate</a></span><span v-else><b>N/A</b></span></td>
                    </tr>
                </table>
                <table class="star_1 table">
                    <caption> VAT Registration Certificate</caption>
                    <tr>
                        <td><b>No: </b>{{ form.vat_registration_number }}</td>
                        <td><b>Attachment: </b><span v-if="form.attach_vat_registration_certificate"><a
                            :href="assetPath('/' + form.attach_vat_registration_certificate)"
                            target="_blank">VAT Registration Certificate</a></span><span v-else><b>N/A</b></span></td>
                    </tr>
                </table>
                <table class="star_1 table">
                    <caption> Freight Forwarding License No.</caption>
                    <tr>
                        <td><b>No: </b>{{ form.ff_license_no }}</td>
                        <td><b>Attachment: </b><span v-if="form.attach_ff_license_no"><a
                            :href="assetPath('/' + form.attach_ff_license_no)"
                            target="_blank">Freight Forwarding License</a></span><span v-else><b>N/A</b></span></td>
                    </tr>
                </table>
                <table class="star_1 table">
                    <caption> Name of Banker</caption>
                    <tr>
                        <td><b>Name: </b>{{ form.name_of_banker }}</td>
                        <td><b>Banker Address: </b>{{ form.address_of_banker }}</td>
                        <td><b>Attachment: </b><span v-if="form.attach_bank_solvency_certificate"><a
                            :href="assetPath('/' + form.attach_bank_solvency_certificate)"
                            target="_blank">Bank Solvency Certificate</a></span><span v-else><b>N/A</b></span></td>
                    </tr>
                </table>
                <table class="star_1 table">
                    <caption> Membership of Other Trade Organization(s), if any</caption>
                    <tr>
                        <td><b>Name :</b>{{ form.membership_of_other_trade_organization }}</td>
                        <td><b>Attachment: </b><span v-if="form.attach_membership_of_other_trade_organization"><a
                            :href="assetPath('/' + form.attach_membership_of_other_trade_organization)"
                            target="_blank">Membership Certificate</a></span><span v-else><b>N/A</b></span></td>
                    </tr>
                </table>
                <table class="star_1 table">
                    <caption> Name of Authorized Person (Director/Partner)</caption>
                    <tr>
                        <td><b>Name :</b> {{ form.name_of_authorized_person }}</td>
                    </tr>
                </table>
                <table class="star_1 table">
                    <caption> No. of Appointed Staffs</caption>
                    <tr>
                        <td><b>No :</b> {{ form.no_of_appointed_staff }}</td>
                        <td><b>Attachment: </b><span v-if="form.attach_no_of_appointed_staff"><a
                            :href="assetPath('/' + form.attach_no_of_appointed_staff)"
                            target="_blank">Appointed Staffs</a></span><span v-else><b>N/A</b></span></td>
                    </tr>
                </table>
                <table class="star_1 table">
                    <caption> Warehouse, if any</caption>
                    <tr>
                        <td><b>Address:</b> {{ form.warehouse_office_address }}</td>
                    </tr>
                    <tr>
                        <td><b>Total Floor Area:</b> {{ form.warehouse_office_floor_area }}</td>
                    </tr>
                </table>
                <table class="star_1 table">
                    <caption> Name of the existing member organization(s) of BAFFA (if any)</caption>
                    <tr>
                        <td><b>Name of the existing member:</b> {{ form.other_org }}</td>
                    </tr>
                </table>
                <table class="star_1 table">
                    <caption> Attested</caption>
                    <tr>
                        <td><b>Attested PROPOSED & SECONDED BY : </b>
                            <span v-if="form.attach_proposed_seconded_by"><a
                                :href="assetPath('/' + form.attach_proposed_seconded_by)"
                                target="_blank">See the Attachment</a></span><span v-else><b>N/A</b></span>
                        </td>
                        <td><b>Attested DECLARATION & UNDERTAKING : </b>
                            <span v-if="form.attach_declaration_undertaking"><a
                                :href="assetPath('/' + form.attach_declaration_undertaking)"
                                target="_blank">See the Attachment</a></span><span v-else><b>N/A</b></span>
                        </td>
                    </tr>
                </table>
                <table class="star_1 table">
                    <caption> Enclosed Documents</caption>
                    <tr>
                        <td><b>INSPECTION REPORT : </b>
                            <span v-if="form.attach_inspection_report"><a
                                :href="assetPath('/' + form.attach_inspection_report)"
                                target="_blank">See the Attachment</a></span><span v-else><b>N/A</b></span>
                        </td>
                        <td><b>CHECKLIST : </b>
                            <span v-if="form.attach_checklist"><a
                                :href="assetPath('/' + form.attach_checklist)"
                                target="_blank">See the Attachment</a></span><span v-else><b>N/A</b></span>
                        </td>
                    </tr>
                </table>
                <div class="fooot">
                    <p>The Membership Sub-committee, BAFFA has recommended this application in its meeting held
                        on <span style="color: green">{{ form.sub_committee_meeting_date | date_format}}</span>
                        for Board approval. Accordingly, the application was submitted in the
                        <span style="color: red" v-if="form.board_of_directors_meeting_no">
                            {{ form.board_of_directors_meeting_no | getOrdinal }}
                        </span>
                        Board of Directors meeting held on
                        <span style="color: green">{{ form.board_of_directors_meeting_date | date_format}}</span>
                        and Board has approved the applications.</p>
                </div>
            </div>
        </div>

    </div>


</template>

<script>
import moment from "moment/moment";

export default {
    name: "ViewMember",
    data: () => ({
        // return {
        date_of_today: new Date(),
        company_owner: 1,
        errors: [],
        validationErrors: null,
        success: null,
        warning_message: null,
        firmType: "Proprietor",
        firmTypeLabel: null,
        firmAttachmentLabel: null,
        countries: null,
        loading: false,
        tempForm: [],
        form: {
            status: "",
        },
        member: null,
        member_detail: null,
    }),
    created: function () {
        this.getMember();
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
                return moment(String(value)).format("DD-MM-YYYY");
            }
        },
        nth: function (n){
            return ["St","Nb","Rd"][((n+90)%100-10)%10-1]||"Th"
        },
        getOrdinal: function (n){
            return moment.localeData().ordinal(n)
        }
    },
    methods: {
        getMember: function () {
            axios
                .get("/api/members/" + this.$route.params.id + "/edit")
                .then((res) => {
                    this.form.organization_name = res.data.data["organization_name"];
                    this.form.username = res.data.data["username"];
                    this.form.email = res.data.data.email;
                    this.form.first_name = res.data.data.first_name;
                    this.form.status = res.data.data.status;
                    if (res.data.data["member_detail"]) {
                        this.firmType = res.data.data["member_detail"]["firm_type"];
                        if (this.firmType == 'Proprietor')
                            this.firmTypeLabel = 'Proprietorship';
                        else if (this.firmType == 'Partners')
                            this.firmTypeLabel = 'Partnership';
                        else if (this.firmType == 'Limited')
                            this.firmTypeLabel = 'Limited';
                        if (this.firmType == 'Proprietor')
                            this.firmAttachmentLabel = 'Attachment of Affidavit';
                        else if (this.firmType == 'Partners')
                            this.firmAttachmentLabel = 'Attachment of Deed of Agreement';
                        else if (this.firmType == 'Limited')
                            this.firmAttachmentLabel = 'Memorandum & Articles of Association and Forms X & XII';
                        /*
                        if(this.form.type_local === 'Local')
                        if(this.form.type_local === 'Joint Venture')
                        if(this.form.type_local === '100% Foreign')*/

                        this.tempForm = res.data.data["member_detail"];
                        Object.keys(this.tempForm).forEach((item) => {
                            if (this.tempForm[item]) {
                                this.form[item] = this.tempForm[item];
                            }
                        });

                    }
                    if (res.data.data["company_owners"]) {
                        this.form.company_owners = res.data.data["company_owners"];
                    }
                    if (res.data.data["member_address"]) {
                        this.tempForm = res.data.data["member_address"];
                        this.tempForm.forEach((value, index) => {
                            // arr.push(value);
                            if (value["member_address_type"] == "register") {
                                this.form.head_office_address = value["address"];
                                this.form.head_office_floor_area = value["floor_area"];
                                this.form.head_office_telephone_no = value["telephone_no"];
                                this.form.head_office_fax_no = value["fax_no"];
                                this.form.head_office_mobile_no = value["mobile_no"];
                                this.form.head_office_email_address = value["email_address"];
                                this.form.head_office_website = value["website"];
                                this.form.head_office_attach_office_tenancy_agreement =
                                    value["attach_office_tenancy_agreement"];
                            } else if (value["member_address_type"] == "branch") {
                                this.form.branch_office_address = value["address"];
                                this.form.branch_office_floor_area = value["floor_area"];
                                this.form.branch_office_telephone_no = value["telephone_no"];
                                this.form.branch_office_fax_no = value["fax_no"];
                                this.form.branch_office_mobile_no = value["mobile_no"];
                                this.form.branch_office_email_address = value["email_address"];
                                this.form.branch_office_website = value["website"];
                                this.form.branch_office_attach_office_tenancy_agreement =
                                    value["attach_office_tenancy_agreement"];
                            }
                        });
                    }
                })
                .catch((error) => {
                    console.error("Error", error.response);
                });
        },
    },
};
</script>

<style scoped>
.w-200 {
    width: 200px;
}

.w-300 {
    width: 200px;
}

.w-10 {
    width: 10px;
    text-align: center;
}

.pic-siz img {
    width: 150px;
}

.round_box {
    border: 1px solid #ccc;
    padding: 30px;
    margin: 44px 0;
    border-radius: 13px;
    background: #fdfdfd;
}

.round_box th, td {
    padding: 1px;
}

.pic-siz .sig {
    width: 77%;
    text-align: center;
    padding-top: 20px;
}

.pic-siz .sig img {
    width: 70%;
}

.addres_box {
    border: 1px solid #ccc;
    padding: 20px;
    vertical-align: top;
}

.list-inline li {
    display: block;
    list-style-type: none;
}

.last_tab_set {
    background: #ededed;
    padding: 5px;
    margin-top: 20px;
}

.star_1 tr td {
    border: 1px solid #ccc;
    padding: 10px;
    background: #fff;
}


.star_1 caption {
    color: #000000;
    text-align: left;
    caption-side: top;
    background: #fff3ce;
    padding: 10px 10px;
    font-weight: 800;
}

.fooot {
    margin-top: 13px;
    width: 100%;
    padding: 20px;
    border: 1px solid #ccc;
}

/* responsiv */


</style>
