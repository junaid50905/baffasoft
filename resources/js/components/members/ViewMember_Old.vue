<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header" id="edit">
                    <div class="row">
                        <div class="col" v-if="checkAccess('edit_member')">
                            <!--                                <router-link
                                                                :to="{ name: 'edit-member', params: { id: row.item.id } }"
                                                                class="btn btn-sm"
                                                                title="Modify Member"
                                                            ><i class="fas fa-user-edit text-info"></i
                                                            ></router-link>-->
                            <router-link
                                :to="{ name: 'edit-member', params: { id: $route.params.id } }"
                                class="btn btn-primary btn-sm btn-block"
                            >EDIT</router-link>
                        </div>
                        <div class="col">
                            <button
                                type="button"
                                id="printPDF"
                                class="btn btn-primary btn-sm btn-block"
                                onclick="window.print()"
                            >
                                Print
                            </button>
                            <!--                            <a class="btn btn-primary btn-sm btn-block" target="_blank"
                                                           :href="addProjectPath('/print_member/'+ $route.params.id)">Print</a>-->
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-sm-12 dash">
                            <div class="box1">
                                <p>Activity Status</p>
                                <p class="p2" v-if="form.status === 'Active'">Active</p>
                                <p class="p3" v-else>Inactive</p>
                            </div>
                            <div class="box2">
                                <p>01. Name of Organization : {{ form.organization_name }}</p>
                                <p>Membership Number : {{ form.username }}</p>
                                <p>02. Place of Enlistment : {{ form.place_of_enlistment }}</p>
                            </div>
                            <div class="box3">
                                <div class="d-flex">
                                    <div class="">
                                        <p>
                                            03. Type of the Organization
                                        </p>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <p class="ms-4">
                                            (a): {{ firmTypeLabel }}
                                            <br/>
                                            (b): {{form.type_local}}
                                            <br/>
                                            (c): <a id="printPDF" :href="assetPath('/' + form.attach_article)" target="_blank">{{ firmAttachmentLabel}}</a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <p class="p4">Company Owner(s) information:</p>
                            <div class="table-responsive">
                                <table class="table table-bordered">

                                    <tr v-for="company_owner in form.company_owners">
                                        <td>
                    <span class="name">
                      Name:
                      {{ company_owner.name }}<br/>
                    </span>
                                            <span class="name">
                      Designation : {{ company_owner.designation }}<br
                                            /></span>

                                            <span class="name">
                      Nationality:
                      {{ company_owner.nationality_name }} <br/>
                    </span>

                                            <span class="name"> NID no: {{ company_owner.nid_no }}<br/></span>
                                            <span class="name" v-if="company_owner.attach_nid"
                                            >Attached NID no:
                      <a
                          style="padding-left: 50px"
                          id="printPDF"
                          :href="assetPath('/' + company_owner.attach_nid)"
                          target="_blank"
                      >See the Attachment
                      </a>
                      <br
                      /></span>

                                            <span
                                                class="name"
                                                v-if="company_owner.attach_educational_qualification"
                                            >Educational Certificate :
                      <a
                          style="padding-left: 50px"
                          id="printPDF"
                          :href="
                          assetPath('/' + company_owner.attach_educational_qualification)
                        "
                          target="_blank"
                      >See the Attachment
                      </a>
                      <br
                      /></span>
                                            <span class="name">
                      Educational qualification:
                      {{ company_owner.educational_qualification }} <br
                                            /></span>
                                            <span class="name">
                      Mobile No: {{ company_owner.mobile_no }}<br
                                            /></span>
                                            <span class="name"> Email: {{ company_owner.email }}<br/></span>
                                            <span class="name">
                      Experience Year: {{ company_owner.experience_year }}<br
                                            /></span>
                                            <span class="name">
                      Signatory: {{ company_owner.signatory }}<br
                                            /></span>
                                            <span class="name">
                      Authorized Person: {{ company_owner.authorized_person }}<br
                                            /></span>
                                            <span class="name">
                      Nominate For Vote: {{ company_owner.nominate_for_vote }}<br
                                            /></span>

                                            <span
                                                class="name"
                                                v-if="company_owner.attach_experience_certificate !== null"
                                            >Experience :
                      <a
                          style="padding-left: 50px"
                          id="printPDF"
                          :href="
                          assetPath('/' + company_owner.attach_experience_certificate)
                        "
                          target="_blank"
                      >See the Attachment
                      </a>
                      <br/></span
                                            ><br/>
                                            <p class="signature-title">Signature:</p>
                                            <span class="image">
                      <a href="#" target="_blank">
                        <img
                            v-if="company_owner.attach_photograph !== null"
                            :src="addProjectPath('/' + company_owner.attach_photograph)"
                            alt=""
                            style="border: 5px solid white"
                            width="150"
                            height="150"
                        />
                        <img
                            v-else
                            :src="addProjectPath('/images/no-image.jpg')"
                            alt=""
                            style="border: 5px solid white"
                            width="150"
                            height="150"
                        />
                      </a>
                    </span>
                                            <!-- <br /> -->

                                            <span class="sig-title">
                      <img
                          v-if="company_owner.attach_signature !== null"
                          class="signature"
                          :src="addProjectPath('/' + company_owner.attach_signature)"
                          alt=""
                      />
                      <img
                          v-else
                          class="signature"
                          :src="addProjectPath('/images/no-image.jpg')"
                          alt=""
                      />
                    </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <div class="card">
                                        <div class="container">
                                            <table class="table table-bordered">
                      <span class="add">Register Address</span
                      ><br/>
                                                <span> {{ form.head_office_address }}<br/> </span>

                                                <span>Total Floor Area: {{ form.head_office_floor_area }}</span
                                                ><br/>
                                                <span>Telephone No: {{ form.head_office_telephone_no }}</span
                                                ><br/>
                                                <span>Fax No: {{ form.head_office_fax_no }}</span
                                                ><br/>
                                                <span>Mobile No: {{ form.head_office_mobile_no }}</span
                                                ><br/>
                                                <span>E-mail Address: {{ form.head_office_email_address }}</span
                                                ><br/>
                                                <span>Land document:</span>
                                                <span
                                                    class="name"
                                                    v-if="form.head_office_attach_office_tenancy_agreement"
                                                >
                        <a
                            style="padding-left: 50px"
                            id="printPDF"
                            :href="
                            assetPath(
                              '/' + form.head_office_attach_office_tenancy_agreement
                            )
                          "
                            target="_blank"
                        >See Attachment
                        </a>
                        <br
                        /></span>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card">
                                        <div class="container">
                                            <span class="add">Warehouse Address</span><br/>
                                            <span>{{ form.warehouse_office_address }}</span
                                            ><br/>
                                            <span>Total Floor Area: {{ form.warehouse_office_floor_area }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card">
                                        <div class="container">
                                            <td>
                                                <span class="add">Branch Office Address: </span><br/>
                                                <span> {{ form.branch_office_address }}<br/> </span>

                                                <span>Total Floor Area: {{ form.branch_office_floor_area }}</span
                                                ><br/>
                                                <span>Telephone No: {{ form.branch_office_telephone_no }}</span
                                                ><br/>
                                                <span>Fax No: {{ form.branch_office_fax_no }}</span
                                                ><br/>
                                                <span>Mobile No: {{ form.branch_office_mobile_no }}</span
                                                ><br/>
                                                <span>E-mail Address: {{ form.branch_office_email_address }}</span
                                                ><br/>
                                                <span>Land document:</span>
                                                <span v-if="form.branch_office_attach_office_tenancy_agreement">
                        <a
                            style="padding-left: 50px"
                            id="printPDF"
                            :href="
                            assetPath(
                              '/' + form.branch_office_attach_office_tenancy_agreement
                            )
                          "
                            target="_blank"
                        >See Attachment
                        </a>
                      </span>
                                            </td>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="p5">
                                4.1 Particulars of Certificate of Registration/Incorporation :
                            </p>
                            <table class="table">
                                <thead></thead>
                                <tbody>
                                <tr>
                                    <td>Number:&nbsp;{{ form.particulars_of_certificate_number }}</td>
                                    <td>
                                        Date :&nbsp;{{ form.particulars_of_certificate_date | date_format }}
                                    </td>
                                    <!-- <td>
                                                    Date :&nbsp;{{
                                                      date("d-m-Y", strtotime(form.particulars_of_certificate_date))
                                                    }}
                                                  </td> -->
                                </tr>
                                </tbody>
                            </table>

                            <span v-if="firmType !== 'Proprietor'">
              <p class="p5">
                4.2
                <span v-if="firmType === 'Partners'"> Approval of Registration </span>
                <span v-if="firmType === 'Limited'"> Incorporation Certificate </span>
              </p>
              <table class="table">
                <thead></thead>
                <tbody>
                  <tr>
                    <span v-if="form.attach_incorporation_certificate">
                      <a
                          style="padding-left: 50px"
                          id="printPDF"
                          :href="assetPath('/' + form.attach_incorporation_certificate)"
                          target="_blank"
                      >See the Attachment
                      </a></span
                    >
                  </tr>
                </tbody>
              </table>
            </span>

                            <p class="p5">5. Date of Establishment of the Firm :</p>
                            <table class="table">
                                <thead></thead>
                                <tbody>
                                <tr>
                                    <td>
                                        Date of Establishment of the Firm:&nbsp;{{
                                            form.date_of_establishment | date_format
                                        }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <!-- <p class="p4">Documents:</p> -->

                            <p class="p5">6. Trade License</p>
                            <table class="table">
                                <thead></thead>
                                <tbody>
                                <tr>
                                    <td>No.&nbsp;&nbsp;{{ form.trade_license_number }}</td>
                                    <td>Validity : &nbsp;{{ form.trade_license_date | date_format }}</td>
                                    <td>
                    <span v-if="form.attach_trade_license">
                      <a :href="assetPath('/' + form.attach_trade_license)"target="_blank">See the Attachment</a>
                    </span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <p class="p5">7.1 e-TIN No</p>
                            <table class="table">
                                <thead></thead>
                                <tbody>
                                <tr>
                                    <td>No.&nbsp;{{ form.tin_number }}</td>
                                    <td>
                    <span v-if="form.attach_e_tin_certificate">
                      <a
                          style="padding-left: 50px"
                          id="printPDF"
                          :href="assetPath('/' + form.attach_e_tin_certificate)"
                          target="_blank"
                      >See the Attachment
                      </a>
                    </span>
                                        <!-- {{form.attach_e_tin_certificate}} -->
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <p class="p5">8.0 VAT Registration Certificate</p>
                            <table class="table">
                                <thead></thead>
                                <tbody>
                                <tr>
                                    <td>No.&nbsp;{{ form.vat_registration_number }}</td>
                                    <td>
                    <span v-if="form.attach_vat_registration_certificate">
                      <a
                          style="padding-left: 50px"
                          id="printPDF"
                          :href="assetPath('/' + form.attach_vat_registration_certificate)"
                          target="_blank"
                      >See the Attachment
                      </a>
                    </span>
                                        <!-- {{form.attach_vat_registration_certificate}} -->
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <p class="p5">8.1 Freight Forwarding License No.</p>
                            <table class="table">
                                <thead></thead>
                                <tbody>
                                <tr>
                                    <td>No.&nbsp;{{ form.ff_license_no }}</td>
                                    <td>
                    <span v-if="form.attach_ff_license_no">
                      <a
                          style="padding-left: 50px"
                          id="printPDF"
                          :href="assetPath('/' + form.attach_ff_license_no)"
                          target="_blank"
                      >See the Attachment
                      </a>
                    </span>
                                        <!-- {{form.attach_vat_registration_certificate}} -->
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <p class="p5">9.1 Name of Banker:</p>
                            <table class="table">
                                <thead></thead>
                                <tbody>
                                <tr>
                                    <td>No.&nbsp;{{ form.name_of_banker }}</td>
                                    <td>Banker Address: &nbsp;&nbsp;{{ form.address_of_banker }}</td>
                                    <td>
                    <span v-if="form.attach_bank_solvency_certificate">
                      <a
                          style="padding-left: 50px"
                          id="printPDF"
                          :href="assetPath('/' + form.attach_bank_solvency_certificate)"
                          target="_blank"
                      >See the Attachment
                      </a>
                    </span>
                                        <!-- {{form.attach_e_tin_certificate}} -->
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <p class="p5">10.1 Membership of Other Trade Organization(s), if any: :</p>
                            <table class="table">
                                <thead></thead>
                                <tbody>
                                <tr>
                                    <td>Name.&nbsp;{{ form.membership_of_other_trade_organization }}</td>
                                    <!-- <td>No.&nbsp;{{ form.no_of_appointed_staff }}</td> -->
                                    <td>
                    <span v-if="form.attach_membership_of_other_trade_organization">
                      <a
                          style="padding-left: 50px"
                          id="printPDF"
                          :href="
                          assetPath(
                            '/' + form.attach_membership_of_other_trade_organization
                          )
                        "
                          target="_blank"
                      >See the Attachment
                      </a>
                    </span>
                                        <!-- {{form.attach_e_tin_certificate}} -->
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <p class="p5">11.1 Name of Authorized Person (Director/Partner):</p>
                            <table class="table">
                                <thead></thead>
                                <tbody>
                                <tr>
                                    <td>Name.&nbsp;{{ form.name_of_authorized_person }}</td>
                                    <!-- <td>No.&nbsp;{{ form.no_of_appointed_staff }}</td> -->
                                    <!-- <td>
                                                    <span v-if="form.attach_no_of_appointed_staff">
                                                      <a
                                                        style="padding-left: 50px"
                                                        id="printPDF"
                                                        :href="assetPath('/' + form.attach_no_of_appointed_staff)"
                                                        target="_blank"
                                                        >See the Attachment
                                                      </a>
                                                    </span>
                                                    {{form.attach_e_tin_certificate}}
                                                  </td> -->
                                </tr>
                                </tbody>
                            </table>

                            <!-- <p class="p5">12. Name and Nationality of Directors/Partners/Proprietor :</p>
                            <table class="table">
                              <thead></thead>
                              <tbody>
                                <tr>
                                  <td>No.&nbsp;{{ form.no_of_appointed_staff }}</td>
                                  <td>
                                    Attach Nationality :
                                    <span v-if="form.attach_nid">
                                      <a
                                        style="padding-left: 50px"
                                        id="printPDF"
                                        :href="assetPath('/' + form.attach_nid)"
                                        target="_blank"
                                        >See the Attachment
                                      </a>
                                    </span>
                                  </td>
                                </tr>
                              </tbody>
                            </table> -->

                            <p class="p5">13. No. of Appointed Staffs:</p>
                            <table class="table">
                                <thead></thead>
                                <tbody>
                                <tr>
                                    <td>No.&nbsp;{{ form.no_of_appointed_staff }}</td>
                                    <td>
                    <span v-if="form.attach_no_of_appointed_staff">
                      <a
                          style="padding-left: 50px"
                          id="printPDF"
                          :href="assetPath('/' + form.attach_no_of_appointed_staff)"
                          target="_blank"
                      >See the Attachment
                      </a>
                    </span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <p class="p5">16.Warehouse, if any:</p>
                            <table class="table">
                                <thead></thead>
                                <tbody>
                                <tr>
                                    <td>Address. &nbsp;{{ form.warehouse_office_address }}</td>
                                    <td>Total Floor Area.&nbsp;{{ form.warehouse_office_floor_area }}</td>
                                </tr>
                                </tbody>
                            </table>

                            <p class="p5">
                                17.Name of the existing member organization(s) of BAFFA (if any):
                            </p>
                            <table class="table">
                                <thead></thead>
                                <tbody>
                                <tr>
                                    <td>Name of the existing member.&nbsp;{{ form.other_org }}</td>
                                </tr>
                                </tbody>
                            </table>

                            <p class="p5">19.1 Attested:</p>
                            <table class="table">
                                <thead></thead>
                                <tbody>
                                <tr>
                                    <td>
                                        Attested PROPOSED & SECONDED BY:&nbsp;
                                        <span v-if="form.attach_proposed_seconded_by">
                      <a
                          style="padding-left: 50px"
                          id="printPDF"
                          :href="assetPath('/' + form.attach_proposed_seconded_by)"
                          target="_blank"
                      >See the Attachment
                      </a>
                    </span>
                                    </td>
                                    <td>
                                        Attested DECLARATION & UNDERTAKING:&nbsp;
                                        <span v-if="form.attach_declaration_undertaking">
                      <a
                          style="padding-left: 50px"
                          id="printPDF"
                          :href="assetPath('/' + form.attach_declaration_undertaking)"
                          target="_blank"
                      >See the Attachment
                      </a>
                    </span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <p class="p5">20.0 Enclosed Documents:</p>
                            <table class="table">
                                <thead></thead>
                                <tbody>
                                <tr>
                                    <td>
                                        INSPECTION REPORT:&nbsp;
                                        <span v-if="form.attach_inspection_report">
                      <a
                          style="padding-left: 50px"
                          id="printPDF"
                          :href="assetPath('/' + form.attach_inspection_report)"
                          target="_blank"
                      >See the Attachment
                      </a>
                    </span>
                                    </td>
                                    <td>
                                        CHECKLIST:&nbsp;
                                        <span v-if="form.attach_checklist">
                      <a
                          style="padding-left: 50px"
                          id="printPDF"
                          :href="assetPath('/' + form.attach_checklist)"
                          target="_blank"
                      >See the Attachment
                      </a>
                    </span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <div class="footer">
                                <p>
                                    The Membership Sub-committee, BAFFA (Dhaka) has recommended this
                                    application in its meeting held on
                                    <span style="color: green">{{ form.sub_committee_meeting_date | date_format}}</span>
                                    for Board approval. Accordingly, the application was submitted in the
                                    <span style="color: red">{{ form.board_of_directors_meeting_no }}Th</span>
                                    Board of Directors meeting held on
                                    <span style="color: red">{{
                                            form.board_of_directors_meeting_date | date_format
                                        }}</span>
                                    and Board has approved the applications.
                                </p>
                                <p>
                                    Therefore, membership certificate of this organization is submitted
                                    herewith for kind signature.
                                </p>
                                <!-- <p>04. Date of Admission : {{ form.form_submit_date }}</p> -->
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row">

            </div>
        </div>
        <div class="col-md-12">

        </div>
        <link
            type="text/css"
            rel="stylesheet"
            :href="addProjectPath('/front/assets/css/view-member.css')"
        />
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
.card-body {
    padding: 1rem;
    background-color: #ededed;
}
@media print {
    #edit,
    #edit * {
        visibility: hidden;
    }

    #printPDF {
        visibility: hidden;
        size: A4;
    }
}
</style>
