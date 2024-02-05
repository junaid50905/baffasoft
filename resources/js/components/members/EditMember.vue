<template>
    <div>
        <div class="col-xl-auto col-lg-auto col-md-auto mx-auto">
            <div class="card z-index-0">
                <div class="card-header text-center pt-4">
                    <h5>MEMBERSHIP APPLICATION FORM</h5>
                </div>
                <div class="card-body">
                    <div id="notification">
                        <validation-errors :errors="validationErrors" :success="success"
                                           :warning_message="warning_message"></validation-errors>
                    </div>
                    <!--  @include('partials/messages')-->
                    <form @submit.prevent="submitForm" role="form" id="registration-form" autocomplete="off"
                          enctype="multipart/form-data" class="mt-3">
                        <!--                @include('partials.messages')-->
                        <!--                {{Form::open(['route'=>'member-details.store','class'=>'contact-form form-horizontal','method'=>'POST','name'=>'newMember','files' => true])}}-->
                        <!--                        <div v-if="member">-->
                        <input type="hidden" name="email" v-model="form.email">
                        <input type="hidden" name="username" v-model="form.username">
                        <input type="hidden" name="password" v-model="form.password">
                        <input type="hidden" name="status" v-model="form.status">
                        <!--                        </div>-->
                        <div class="table-responsive-xl">
                            <table
                                class="table caption-top align-middle table-sm table-bordered border-secondary">
                                <caption>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-1 text-center pt-2"><span>Date: </span></div>
                                            <div class="col-4">
                                                <datepicker input-class="form-control" name="form_submit_date"
                                                            v-model="form.form_submit_date"
                                                />

                                            </div>
                                        </div>
                                    </div>
                                </caption>
                                <!--                                <caption>(Please put “” tick mark where necessary)</caption>-->
                                <tbody>
                                <tr>
                                    <th width="2%" scope="row">1.0</th>
                                    <td width="40%" colspan="3">Name of the Firm (In Block Letters):</td>
                                    <td width="40%">
                                        <input type="text"
                                               class="form-control"
                                               name="organization_name" v-model="form.organization_name"
                                               autocomplete="organization_name" :disabled="true">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">2.0</th>
                                    <td colspan="3">Place of Enlistment/Registration:</td>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                   name="place_of_enlistment" v-model="form.place_of_enlistment"
                                                   id="place_of_enlistment1"
                                                   value="Dhaka">
                                            <label class="form-check-label"
                                                   for="place_of_enlistment1">Dhaka</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                   v-model="form.place_of_enlistment"
                                                   name="place_of_enlistment" id="place_of_enlistment2"
                                                   value="Chattogram">
                                            <label class="form-check-label"
                                                   for="place_of_enlistment2">Chattogram</label>
                                        </div>
                                        <!--<input type="text" v-model="form.place_of_enlistment" class="form-control" name="place_of_enlistment">-->
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" rowspan="2">3.0</th>
                                    <td rowspan="2" colspan="2">Type of the Firm</td>
                                    <td>(a)</td>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                   name="firm_type" v-model="firmType" id="inlineRadio1"
                                                   value="Proprietor">
                                            <label class="form-check-label"
                                                   for="inlineRadio1">Proprietorship</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" v-model="firmType"
                                                   name="firm_type" id="inlineRadio2" value="Partners">
                                            <label class="form-check-label"
                                                   for="inlineRadio2">Partnership</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" v-model="firmType"
                                                   name="firm_type" id="inlineRadio3" value="Limited">
                                            <label class="form-check-label" for="inlineRadio3">Limited
                                                Company</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>(b)</td>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                   v-model="form.type_local"
                                                   name="type_local" id="inlineRadio4" value="Local">
                                            <label class="form-check-label" for="inlineRadio4">Local</label>
                                        </div>
                                        <div v-if="firmType == 'Limited'" class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                   v-model="form.type_local"
                                                   name="type_local" id="inlineRadio5" value="Joint Venture">
                                            <label class="form-check-label" for="inlineRadio5">Joint
                                                Venture</label>
                                        </div>
                                        <div v-if="firmType == 'Limited'" class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                   v-model="form.type_local"
                                                   name="type_local" id="inlineRadio6" value="100% Foreign">
                                            <label class="form-check-label" for="inlineRadio6">100%
                                                Foreign</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">3.1</th>
                                    <td colspan="3">
                                        <span v-if="firmType === 'Proprietor'">
                                            Attachment of Affidavit
<!--                                            Affidavit for Proprietorship Firm.-->
                                        </span>
                                        <span v-if="firmType === 'Partners'">
                                            Attachment of Deed of Agreement
<!--                                            Partnership Deed Agreement & approval of Form-I of Registrar<br> of Joint Stock Companies and Firms (RJSC)-->
                                        </span>
                                        <span v-if="firmType === 'Limited'">
                                            <!-- Attachment of Memorandum of Articles & Form X & XII -->
                                        Memorandum & Articles of Association and Forms X & XII
                                        </span>
                                        <br>
                                        ({{ firmType }}).
                                    </td>
                                    <td>
                                        <ImageTag alt="attach_article"
                                                  name="attach_article"
                                                  :src="form.attach_article" @saveImage="saveImage" />
                                    </td>
                                </tr>
                                <tr v-if="firmType !== 'Proprietor'">
                                    <th scope="row">4.0</th>
                                    <td colspan="3">
                                        <span v-if="firmType === 'Partners'">
                                            Certificate of Registration (Number and Date):
                                        </span>
                                        <span v-if="firmType === 'Limited'">
                                            Certificate of Incorporation (Number and Date):
                                        </span>
                                    </td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input type="text" v-model="form.particulars_of_certificate_number"
                                                   class="form-control" placeholder="Number"
                                                   name="particulars_of_certificate_number">
                                            <span class="input-group-text">|</span>
                                            <datepicker input-class="form-control"
                                                        name="particulars_of_certificate_date"
                                                        v-model="form.particulars_of_certificate_date"
                                            />
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="firmType !== 'Proprietor'">
                                    <th scope="row">4.1</th>
                                    <td colspan="3">
                                        <span v-if="firmType === 'Partners'">
                                            Approval of Form-1 of Registrar of Joint Stock Companies and Firms (RJSC)
                                        </span>
                                        <span v-if="firmType === 'Limited'">
                                            Incorporation Certificate
<!--                                            Attach In-Corporation Certificate-->
                                        </span>
                                    </td>
                                    <td>
                                        <ImageTag alt="Certificate"
                                                  name="attach_incorporation_certificate"
                                                  :src="form.attach_incorporation_certificate" @saveImage="saveImage" />
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">5.0</th>
                                    <td colspan="3">Date of Establishment of the Firm:</td>
                                    <td>
                                        <datepicker input-class="form-control" name="date_of_establishment"
                                                    v-model="form.date_of_establishment"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">6.1</th>
                                    <td colspan="3">Trade License Number and Date with Validity:</td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control"
                                                   v-model="form.trade_license_number"
                                                   placeholder="Trade License Number"
                                                   name="trade_license_number">
                                            <span class="input-group-text">|</span>
                                            <datepicker input-class="form-control" name="trade_license_date"
                                                        v-model="form.trade_license_date"
                                            />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">6.2</th>
                                    <td colspan="3">Attested copy of valid and up-to-date Trade License:</td>
                                    <td>
                                        <ImageTag alt="Trade License"
                                                  name="attach_trade_license"
                                                  :src="form.attach_trade_license" @saveImage="saveImage" />
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">7.1</th>
                                    <td colspan="3">12-digit TIN Number:</td>
                                    <td><input type="text" class="form-control" v-model="form.tin_number"
                                               placeholder="EX: XXXXXXXXXXXX" name="tin_number"></td>
                                </tr>
                                <tr>
                                    <th scope="row">7.2</th>
                                    <td colspan="3">Attested copy of valid e-TIN Certificate and <br>Income Tax
                                        Clearance Certificate:
                                    </td>
                                    <td>
<!--                                        <input type="file" class="form-control" placeholder="Place"
                                               name="attach_e_tin_certificate" v-on:change="saveImage">
                                        <img v-if="images.attach_e_tin_certificate" :src="images.attach_e_tin_certificate" alt="e-Tin Certificate">
                                        <img v-if="typeof form.attach_e_tin_certificate === 'string'" :src="assetPath('/'+form.attach_e_tin_certificate)" alt="e-Tin Certificate">-->
                                        <ImageTag alt="e-TIN Certificate"
                                                  name="attach_e_tin_certificate"
                                                  :src="form.attach_e_tin_certificate" @saveImage="saveImage" />
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">8.1</th>
                                    <td colspan="3">VAT Registration Number:</td>
                                    <td><input type="text" class="form-control"
                                               v-model="form.vat_registration_number"
                                               placeholder="EX: XXXXXXXXXXXX" name="vat_registration_number">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">8.2</th>
                                    <td colspan="3">VAT Registration Certificate (13 digits):</td>
                                    <td>
                                        <ImageTag alt="attach_vat_registration_certificate"
                                                  name="attach_vat_registration_certificate"
                                                  :src="form.attach_vat_registration_certificate" @saveImage="saveImage" />
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">8.3</th>
                                    <td colspan="3">Freight Forwarding License No. (if any):</td>
                                    <td><input type="text" class="form-control"
                                               v-model="form.ff_license_no"
                                               placeholder="EX: XXXXXXXXXXXX" name="ff_license_no">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">8.4</th>
                                    <td colspan="3">Freight Forwarding License Attachment:</td>
                                    <td>
                                        <ImageTag alt="attach_ff_license_no"
                                                  name="attach_ff_license_no"
                                                  :src="form.attach_ff_license_no" @saveImage="saveImage" />
                                        </td>
                                </tr>
                                <tr>
                                    <th scope="row">9.1</th>
                                    <td colspan="3">Name of Banker:</td>
                                    <td>
                                                <input class="form-control" type="text" name="name_of_banker"
                                                          v-model="form.name_of_banker"></input>
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row">9.2</th>
                                    <td colspan="3">Address of Banker:</td>
                                    <td>
                                                <textarea class="form-control" id="exampleFormControlTextarea1"
                                                          rows="3" name="address_of_banker"
                                                          v-model="form.address_of_banker"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">9.3</th>
                                    <td colspan="3">Bank Solvency Certificate:</td>
                                    <td>
                                        <ImageTag alt="attach_bank_solvency_certificate"
                                                  name="attach_bank_solvency_certificate"
                                                  :src="form.attach_bank_solvency_certificate" @saveImage="saveImage" />
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">10.1</th>
                                    <td colspan="3">Membership of Other Trade Organization(s), if any:</td>
                                    <td><input type="text" class="form-control" placeholder="Membership"
                                               v-model="form.membership_of_other_trade_organization"
                                               name="membership_of_other_trade_organization"></td>
                                </tr>
                                <tr>
                                    <th scope="row">10.2</th>
                                    <td colspan="3">Membership of Other Trade Organization(s) Attachment, if any:</td>
                                    <td><ImageTag alt="attach_membership_of_other_trade_organization"
                                                  name="attach_membership_of_other_trade_organization"
                                                  :src="form.attach_membership_of_other_trade_organization"
                                                  @saveImage="saveImage" />
                                    </td>
                                </tr>
                                <tr class="company_owner_before">
                                    <th scope="row">11.0</th>
                                    <td colspan="3">Name of Authorized Person (Director/Partner in block
                                        letters):
                                    </td>
                                    <td><input type="text" class="form-control" name="name_of_authorized_person"
                                               v-model="form.name_of_authorized_person">
<!--                                    <ul>-->
<!--                                        <li v-for="(val,name,index) in company_owners">-->
<!--                                            {{val}}-{{name}}&#45;&#45;{{index}}-->
<!--                                        </li>-->
<!--                                    </ul>-->
                                    </td>
                                </tr>

<!--                                <template v-for="(company_owner,n) in company_owners">
                                    <tr class="company_owner_this">
                                        <th scope="row" rowspan="11">12.0</th>
                                        <td rowspan="11">Company Owners Information<br>({{ firmType }}):
                                        </td>
                                        <td>(a)</td>
                                        <td>Name:</td>
                                        <td>
                                            <input type="hidden" :name="'company_owner['+n+'][id]'" :value="company_owner.id">
                                            <input type="text" class="form-control" placeholder="Address"
                                                   :name="'company_owner['+n+'][name]'"
                                                   v-model="company_owner['name']"
                                        ></td>
                                    </tr>
                                    <tr>
                                        <td>(b)</td>
                                        <td>NID No:</td>
                                        <td><input type="text" class="form-control"
                                                   placeholder="Total Floor Area"
                                                   :name="'company_owner['+n+'][nid_no]'"
                                                   v-model="company_owner['nid_no']"
                                        >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>(c)</td>
                                        <td> Attach NID:</td>
                                        <td><input type="file" class="form-control"
                                                   :name="'company_owner['+n+'][attach_nid]'"
                                        >
                                            <img :src="assetPath('/'+company_owner['attach_nid'])" alt="Trade License">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>(d)</td>
                                        <td>Educational Qualification:</td>
                                        <td><input type="text" class="form-control"
                                                   placeholder="Total Floor Area"
                                                   :name="'company_owner['+n+'][educational_qualification]'"
                                                   v-model="company_owner['educational_qualification']"
                                        >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>(e)</td>
                                        <td>Attach Educational Qualification:</td>
                                        <td><input type="file" class="form-control"
                                                   :name="'company_owner['+n+'][attach_educational_qualification]'"
                                        >
                                            <img :src="assetPath('/'+company_owner['attach_educational_qualification'])" alt="Trade License">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>(f)</td>
                                        <td>Photograph:</td>
                                        <td><input type="file" class="form-control"
                                                   :name="'company_owner['+n+'][attach_photograph]'"
                                        >
                                            <img :src="assetPath('/'+company_owner['attach_photograph'])" alt="Trade License">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>(g)</td>
                                        <td>Mobile No:</td>
                                        <td><input type="text" class="form-control" placeholder="Mobile No."
                                                   :name="'company_owner['+n+'][mobile_no]'"
                                                   v-model="company_owner['mobile_no']"
                                        >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>(h)</td>
                                        <td>Email:</td>
                                        <td><input type="text" class="form-control" placeholder="E-mail Address"
                                                   :name="'company_owner['+n+'][email]'"
                                                   v-model="company_owner['email']"
                                        >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>(i)</td>
                                        <td>nationality:</td>
                                        <td>
                                            <select class="form-select form-control" aria-label="Default"
                                                    :name="'company_owner['+n+'][nationality_id]'">
                                                <option v-for="country in countries" :selected="country.id === company_owner['name']"
                                                        :key="country.id" :value="country.id">{{ country.name }}
                                                </option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>(j)</td>
                                        <td>Specific Signature:</td>
                                        <td><input type="file" class="form-control"
                                                   :name="'company_owner['+n+'][attach_signature]'"
                                        >
                                            <img :src="assetPath('/'+company_owner['attach_signature'])" alt="Trade License">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>(k)</td>
                                        <td>Attach Experience Certificate:</td>
                                        <td><input type="file" class="form-control"
                                                   :name="'company_owner['+n+'][attach_experience_certificate]'">
                                            <img :src="assetPath('/'+company_owner['attach_experience_certificate'])" alt="Trade License">
                                        </td>
                                    </tr>
                                </template>-->
                                <tr>
                                    <th scope="row">13.0</th>
                                    <td colspan="2">No. of Appointed Staffs: <br>(Attach Details)</td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control"
                                                   placeholder="No. of Appointed Staffs"
                                                   name="no_of_appointed_staff"
                                                   v-model="form.no_of_appointed_staff">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <ImageTag alt="attach_no_of_appointed_staff"
                                                      name="attach_no_of_appointed_staff"
                                                      :src="form.attach_no_of_appointed_staff"
                                                      @saveImage="saveImage" />
<!--                                            <input type="file" class="form-control" v-on:change="saveImage"
                                                   placeholder="Attach Details"
                                                   name="">
                                            <a :href="assetPath('/'+form.attach_no_of_appointed_staff)" >Attachment</a>
                                            <img :src="assetPath('/'+form.attach_no_of_appointed_staff)" />-->
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" rowspan="7">14.0</th>
                                    <td rowspan="7">Head Office:</td>
                                    <td>(a)</td>
                                    <td>Address:</td>
                                    <td>
                                        <input type="hidden" name="member_address[1][id]" v-model="form.head_office_id">
                                        <input type="hidden" name="member_address[2][member_address_type]" value="register">
                                        <input type="text" class="form-control" placeholder="Address"
                                               name="member_address[1][address]" v-model="form.head_office_address">
                                    </td>
                                </tr>
                                <tr>
                                    <td>(b)</td>
                                    <td>Total Floor Area:</td>
                                    <td><input type="text" class="form-control" placeholder="Total Floor Area"
                                               name="member_address[1][floor_area]"
                                               v-model="form.head_office_floor_area">
                                    </td>
                                </tr>
                                <tr>
                                    <td>(c)</td>
                                    <td>Telephone No:</td>
                                    <td><input type="text" class="form-control" placeholder="Telephone No"
                                               name="member_address[1][telephone_no]"
                                               v-model="form.head_office_telephone_no"></td>
                                </tr>
                                <tr>
                                    <td>(d)</td>
                                    <td>Fax No:</td>
                                    <td><input type="text" class="form-control" placeholder="Fax no"
                                               name="member_address[1][fax_no]" v-model="form.head_office_fax_no"></td>
                                </tr>
                                <tr>
                                    <td>(e)</td>
                                    <td>Mobile No:</td>
                                    <td><input type="text" class="form-control" placeholder="Mobile No"
                                               name="member_address[1][mobile_no]"
                                               v-model="form.head_office_mobile_no"></td>
                                </tr>
                                <tr>
                                    <td>(f)</td>
                                    <td>E-mail Address:</td>
                                    <td><input type="text" class="form-control" placeholder="E-mail Address"
                                               name="member_address[1][email_address]"
                                               v-model="form.head_office_email_address">
                                    </td>
                                </tr>
                                <tr>
                                    <td>(g)</td>
                                    <td>Office Tenancy agreement or Land Ownership document:</td>
                                    <td><ImageTag alt="attach_office_tenancy_agreement"
                                        name="member_address[1][attach_office_tenancy_agreement]"
                                        :src="form.attach_office_tenancy_agreement_1"
                                        @saveImage="saveImage" />


                                        <!-- <input type="text" class="form-control" placeholder="E-mail Address"
                                               name="member_address[1][attach_office_tenancy_agreement]"
                                               v-model="form.attach_office_tenancy_agreement"> -->
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" rowspan="6">15.0</th>
                                    <td rowspan="6">Branch Office, if any:</td>
                                    <td>(a)</td>
                                    <td>Address:</td>
                                    <td>
                                        <input type="hidden" name="member_address[2][id]" v-model="form.branch_office_id">
                                        <input type="hidden" name="member_address[2][member_address_type]" value="branch">
                                        <input type="text" class="form-control" placeholder="Address"
                                               name="member_address[2][address]"
                                               v-model="form.branch_office_address"></td>
                                </tr>
                                <tr>
                                    <td>(b)</td>
                                    <td>Total Floor Area:</td>
                                    <td><input type="text" class="form-control" placeholder="Total Floor Area"
                                               name="member_address[2][floor_area]"
                                               v-model="form.branch_office_floor_area">
                                    </td>
                                </tr>
                                <tr>
                                    <td>(c)</td>
                                    <td>Telephone No:</td>
                                    <td><input type="text" class="form-control" placeholder="Telephone No"
                                               name="member_address[2][telephone_no]"
                                               v-model="form.branch_office_telephone_no"></td>
                                </tr>
                                <tr>
                                    <td>(e)</td>
                                    <td>Mobile No :</td>
                                    <td><input type="text" class="form-control" placeholder="Mobile No"
                                               name="member_address[2][mobile_no]"
                                               v-model="form.branch_office_mobile_no"></td>
                                </tr>
                                <tr>
                                    <td>(f)</td>
                                    <td>E-mail Address:</td>
                                    <td><input type="text" class="form-control" placeholder="E-mail Address"
                                               name="member_address[2][email_address]"
                                               v-model="form.branch_office_email_address">
                                    </td>
                                </tr>
                                <tr>
                                    <td>(g)</td>
                                    <td>Office Tenancy agreement or Land Ownership document:</td>
                                    <td><ImageTag alt="attach_office_tenancy_agreement"
                                        name="member_address[2][attach_office_tenancy_agreement]"
                                        :src="form.attach_office_tenancy_agreement_2"
                                        @saveImage="saveImage" />

                                        <!-- <input type="file" class="form-control" placeholder="E-mail Address"
                                               name="member_address[2][attach_office_tenancy_agreement]"
                                               v-model="form.attach_office_tenancy_agreement" > -->
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" rowspan="2">16.0</th>
                                    <td rowspan="2">Warehouse, if any</td>
                                    <td>(a)</td>
                                    <td>Address:</td>
                                    <td><input type="text" class="form-control" placeholder="Address"
                                               name="warehouse_office_address"
                                               v-model="form.warehouse_office_address"></td>
                                </tr>
                                <tr>
                                    <td>(b)</td>
                                    <td>Total Floor Area:</td>
                                    <td><input type="text" class="form-control" placeholder="Total Floor Area"
                                               name="warehouse_office_floor_area"
                                               v-model="form.warehouse_office_floor_area">
                                    </td>
                                </tr>
                                <!--                                <tr>
                                                                <tr>
                                                                    <th scope="row">17.0</th>
                                                                    <td colspan="3"><b>PROPOSED BY</b></td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">17.1</th>
                                                                    <td colspan="3">Name of the Proposing BAFFA Member Company:</td>
                                                                    <td><input type="text" class="form-control" name="proposed_by_company"
                                                                               v-model="form.proposed_by_company"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">17.2</th>
                                                                    <td colspan="3">Name in full and designation of the Proposer:</td>
                                                                    <td><input type="text" class="form-control"
                                                                               v-model="form.proposed_by_name_and_designation"
                                                                               name="proposed_by_name_and_designation"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">17.3</th>
                                                                    <td colspan="3">BAFFA Membership No.:</td>
                                                                    <td><input type="text" class="form-control" name="proposed_by_membership_no"
                                                                               v-model="form.proposed_by_membership_no">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">17.4</th>
                                                                    <td colspan="3">Forwarding License No.:</td>
                                                                    <td><input type="text" class="form-control"
                                                                               v-model="form.proposed_by_forwarding_license_no"
                                                                               name="proposed_by_forwarding_license_no"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">17.5</th>
                                                                    <td colspan="3">Signature of the Seconder:</td>
                                                                    <td><input type="file" class="form-control" v-on:change="saveImage"
                                                                               name="attach_proposed_by_signature_of_seconder"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">17.6</th>
                                                                    <td colspan="3">Date & Place:</td>
                                                                    <td>
                                                                        <div class="input-group mb-3">
                                                                            <datepicker input-class="form-control" name="proposed_by_date"
                                                                                        v-model="form.proposed_by_date"
                                                                            />
                                                                            <span class="input-group-text">|</span>
                                                                            <input type="text" class="form-control" placeholder="Place"
                                                                                   name="proposed_by_place" v-model="form.proposed_by_place">
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">18.0</th>
                                                                    <td colspan="3"><b>SECONDED BY:</b></td>
                                                                    <td>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">18.1</th>
                                                                    <td colspan="3">Name of the Seconding BAFFA Member Company:</td>
                                                                    <td><input type="text" class="form-control" name="seconded_by_company"
                                                                               v-model="form.seconded_by_company"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">18.2</th>
                                                                    <td colspan="3">Name in full & designation of the Seconder:</td>
                                                                    <td><input type="text" class="form-control"
                                                                               v-model="form.seconded_by_name_and_designation"
                                                                               name="seconded_by_name_and_designation"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">18.3</th>
                                                                    <td colspan="3">BAFFA Membership No.:</td>
                                                                    <td><input type="text" class="form-control" name="seconded_by_membership_no"
                                                                               v-model="form.seconded_by_membership_no">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">18.4</th>
                                                                    <td colspan="3">Forwarding License No.:</td>
                                                                    <td><input type="text" class="form-control"
                                                                               name="seconded_by_forwarding_license_no"
                                                                               v-model="form.seconded_by_forwarding_license_no"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">18.5</th>
                                                                    <td colspan="3">Signature of the Seconder:</td>
                                                                    <td><input type="file" class="form-control"
                                                                               name="attach_seconded_by_signature" v-on:change="saveImage">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">18.6</th>
                                                                    <td colspan="3">Date & Place:</td>
                                                                    <td>
                                                                        <div class="input-group mb-3">
                                                                            <datepicker input-class="form-control" name="seconded_by_date"
                                                                                        v-model="form.seconded_by_date"
                                                                            />
                                                                            <span class="input-group-text">|</span>
                                                                            <input type="text" class="form-control" placeholder="Place"
                                                                                   name="seconded_by_place" v-model="form.seconded_by_place">
                                                                        </div>
                                                                    </td>
                                                                </tr>-->
                                <tr>
                                    <th scope="row">17.0</th>
                                    <td colspan="3">Name of the existing member organization(s) of BAFFA (if any):
                                    </td>
                                    <td><input type="text" class="form-control" name="other_org"
                                               v-model="form.other_org">
                                    </td>
                                </tr>
<!--                                <tr>
                                    <th scope="row">19.0</th>
                                    <td colspan="3"><b>Attested:</b></td>
                                    <td>
                                    </td>
                                </tr>-->

                                <tr>
                                    <th scope="row">18.0</th>
                                    <td colspan="3">Attested PROPOSED & SECONDED BY:</td>
                                    <td>
                                        <ImageTag alt="attach_proposed_seconded_by"
                                                  name="attach_proposed_seconded_by"
                                                  :src="form.attach_proposed_seconded_by"
                                                  @saveImage="saveImage" />
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">19.0</th>
                                    <td colspan="3">Attested DECLARATION & UNDERTAKING:</td>
                                    <td>
                                        <ImageTag alt="attach_declaration_undertaking"
                                                  name="attach_declaration_undertaking"
                                                  :src="form.attach_declaration_undertaking"
                                                  @saveImage="saveImage" />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <div v-if="only_edit == 'Yes'" class="d-grid gap-2 col-6 mx-auto pt-3">
                                            <button type="submit" v-on:click="doCompleted"
                                                    v-bind:class="[loading ? 'disabled btn-primary' : 'btn-primary','btn']"
                                                    id="loader-btn">
                                                <span>Update Member</span>
                                            </button>
                                            <div id="loader" v-if="loading"
                                                 v-bind:style="{'backgroundImage': 'url(' + addProjectPath('/assets/img/ajax-loader.gif') + ')'}"></div>
                                        </div>
                                        <div v-else-if="only_edit == 'No'" class="d-grid gap-2 col-6 mx-auto pt-3">
                                            <button type="submit"
                                                    v-bind:class="[loading ? 'disabled btn-primary' : 'btn-primary','btn']"
                                                    id="loader-btn">
                                                <span>Save Member</span>
                                            </button>
                                            <button type="submit" v-on:click="doActive"
                                                    v-bind:class="[loading ? 'disabled btn-secondary' : 'btn-secondary','btn']"
                                                    id="loader-btn">
                                                <span>Save & Submit</span>
                                            </button>
                                            <div id="loader" v-if="loading"
                                                 v-bind:style="{'backgroundImage': 'url(' + addProjectPath('/assets/img/ajax-loader.gif') + ')'}"></div>
                                        </div>
                                        <div v-else class="d-grid gap-2 col-6 mx-auto pt-3">
                                            <button type="submit"
                                                    v-bind:class="[loading ? 'disabled btn-primary' : 'btn-primary','btn']"
                                                    id="loader-btn">
                                                <span>Save Active Member</span>
                                            </button>
                                            <div id="loader" v-if="loading"
                                                 v-bind:style="{'backgroundImage': 'url(' + addProjectPath('/assets/img/ajax-loader.gif') + ')'}"></div>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <!--                            <div class="box-footer">-->
                            <!--                                <button type="submit" v-bind:class="[loading ? 'disabled btn-secondary' : 'btn-primary','btn']" id="loader-btn">-->
                            <!--                                  <span>Create Member</span>-->
                            <!--                                <div id="loader" v-if="loading" v-bind:style="{'backgroundImage': 'url(' + addProjectPath('/assets/img/ajax-loader.gif') + ')'}" ></div>-->
                            <!--                                </button>-->
                            <!--                            </div>-->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ValidationErrors from "../ValidationErrors";
import ImageTag from "../ImageTag";
import Datepicker from "vuejs-datepicker";
import moment from "moment";
import {publicPath} from "../../../../vue.config";


export default {
    name: "EditMember",
    components: {ValidationErrors, Datepicker, moment, ImageTag},
    props: ['only_edit'],
    data: () => ({
        // return {
        date_of_today: new Date(),
        // company_owner: 1,
        errors: [],
        validationErrors: null,
        success: null,
        warning_message:null,
        firmType: 'Proprietor',
        countries: null,
        loading: false,
        tempForm: [],
        company_owners:null,
        images:{
            attach_article: null,
            attach_incorporation_certificate: null,
            attach_trade_license: null,
            attach_e_tin_certificate: null,
            attach_vat_registration_certificate: null,
            attach_ff_license_no: null,
            attach_bank_solvency_certificate: null,
            attach_membership_of_other_trade_organization: null,
            attach_no_of_appointed_staff: null,
            attach_office_tenancy_agreement_1: null,
            attach_office_tenancy_agreement_2: null,
            attach_proposed_seconded_by: null,
            attach_declaration_undertaking: null,
        },
        form: {
            username: '',
            email: '',
            password: '',
            organization_name: '',
            status: '',
            form_submit_date: new Date().toISOString().slice(0, 10),
            place_of_enlistment: 'Dhaka',
            type_local: 'Local',
            particulars_of_certificate_number: '',
            particulars_of_certificate_date: new Date().toISOString().slice(0, 10),
            date_of_establishment: new Date().toISOString().slice(0, 10),
            trade_license_number: '',
            trade_license_date: new Date().toISOString().slice(0, 10),
            tin_number: '',
            vat_registration_number: '',
            name_and_address_of_banker: '',
            membership_of_other_trade_organization: '',
            name_of_authorized_person: '',
            no_of_appointed_staff: '',
            other_org: '',

            warehouse_office_address: '',
            warehouse_office_floor_area: '',

            attach_article: null,
            attach_incorporation_certificate: null,
            attach_trade_license: null,
            attach_e_tin_certificate: null,
            attach_vat_registration_certificate: null,
            attach_ff_license_no: null,
            attach_bank_solvency_certificate: null,
            attach_membership_of_other_trade_organization: null,
            attach_no_of_appointed_staff: null,
            attach_office_tenancy_agreement_1: null,
            attach_office_tenancy_agreement_2: null,
            attach_proposed_seconded_by: null,
            attach_declaration_undertaking: null,
        }
        // }
    }),
    created: function () {
        if(!this.checkAccess('edit_member'))
            this.$router.push({ name: 'staff_home'});
        this.getMember()
        this.getCountries()
        // if(this.member.email){
        //     console.log(this.member)
        // }else {
        //     console.log('sorry')
        // }
    },
    watch: {
        firmType() {
            if (this.firmType == 'Partners') {
                // this.company_owner = 2;
                this.form.type_local = 'Local';
            } else if (this.firmType == 'Limited') {
                // this.company_owner = 3;
            } else {
                // this.company_owner = 1;
                this.form.type_local = 'Local';
            }
        }
    },
    methods: {
        getCountries() {
            axios
                .get('/api/members/countries')
                .then(res => {
                    this.countries = res.data
                }).catch(error => {
                console.error(error.response.data.message)
            })
        },
        saveImage: function (event) {
            this.form[event.target.name] = event.target.files[0];
        },
        submitForm: function () {
            this.errors = [];
            // if (!this.form.username) this.errors.push(["username", ["Name required."]]);
            // if (!this.form.email) this.errors.push(["email", ["Email required."]]);
            if (!this.form.organization_name) this.errors.push(["organization_name", ["Firm Name required."]]);
            if (this.errors.length) {
                // this.validationErrors = Object.assign({},this.errors)
                this.validationErrors = Object.fromEntries(this.errors)
            } else {
                this.loading = true;
                this.saveMemberDetails()
            }
        },
        doActive() {
            this.form.status = 'Verified'
        },
        doCompleted() {
            this.form.status = 'Renew_Done'
        },
        saveMemberDetails: function () {
            // const data = new FormData();
            let myForm = document.getElementById('registration-form');
            let data = new FormData(myForm);
            data.set('form_submit_date', this.format_date(this.form.form_submit_date));
            data.set('particulars_of_certificate_date', this.format_date(this.form.particulars_of_certificate_date));
            data.set('date_of_establishment', this.format_date(this.form.date_of_establishment));
            data.set('trade_license_date', this.format_date(this.form.trade_license_date));
            // data.set('attach_trade_license', this.form.attach_trade_license);
            // data.append('username', this.form.username);
            // data.append('email', this.form.email);
            // data.append('password', this.form.password);
            // console.log(this.form)
            const config = {
                headers: { //'content-type': 'multipart/form-data' }
                    'content-type': 'multipart/form-data',
                    'accept': 'application/json'
                }
            }
            axios.post("/api/members/" + this.$route.params.id, data, config).then(res => {
                // console.log(res.data)
                // window.location.href = publicPath + "/profile/member/" + this.$route.params.id;
                this.reset();
                this.$router.push({ name: "view-member", params: { id: this.$route.params.id }, query: { success: this.success } });
            }).catch(error => {
                if (error.response.status == 422) {
                    this.validationErrors = error.response.data.errors;
                } else {
                   this.warning_message = error.response.data.message;
                }
            }).finally(() => {
                this.loading = false
            });
        },
        reset: function () {
            this.validationErrors = null;
            this.success = 'Member Updated Successfully';
            // this.form = Object.assign({}, initFormData)
            // for(let field in this.formData){
            //     this.formData[field] = null;
            // }
        },
        getMember: function () {
            axios.get('/api/members/' + this.$route.params.id + '/edit')
                .then(res => {
                    if (Object.keys(res.data.data).length === 0) {
                        this.$router.push({name: "registration", query: {warning_message: 'Please, Try Again !'}});
                    } else {
                        console.log('Member Login Data', res.data.data)
                        this.form.username = res.data.data['username']
                        this.form.email = res.data.data.email
                        this.form.organization_name = res.data.data.organization_name
                        this.form.status = res.data.data.status
                        if (res.data.data['member_detail']) {
                            this.firmType = res.data.data['member_detail']['firm_type']
                            this.tempForm = res.data.data['member_detail']
                            Object.keys(this.tempForm).forEach((item) => {
                                if (this.tempForm[item]) {
                                    this.form[item] = this.tempForm[item]
                                }
                            });
                        }
                        if (res.data.data['company_owners']) {
                            this.company_owners = res.data.data['company_owners']
                        }
                        if (res.data.data['member_address']) {
                            this.tempForm = res.data.data['member_address']
                            this.tempForm.forEach((value, index) => {
                                // arr.push(value);
                                if (value['member_address_type'] == "register") {
                                    this.form.head_office_id = value['id'];
                                    this.form.head_office_address = value['address'];
                                    this.form.head_office_floor_area = value['floor_area'];
                                    this.form.head_office_telephone_no = value['telephone_no'];
                                    this.form.head_office_fax_no = value['fax_no'];
                                    this.form.head_office_mobile_no = value['mobile_no'];
                                    this.form.head_office_email_address = value['email_address'];
                                    this.form.head_office_website = value['website'];
                                    this.form.attach_office_tenancy_agreement_1 = value['attach_office_tenancy_agreement'];
                                } else if (value['member_address_type'] == 'branch') {
                                    this.form.branch_office_id = value['id'];
                                    this.form.branch_office_address = value['address'];
                                    this.form.branch_office_floor_area = value['floor_area'];
                                    this.form.branch_office_telephone_no = value['telephone_no'];
                                    this.form.branch_office_fax_no = value['fax_no'];
                                    this.form.branch_office_mobile_no = value['mobile_no'];
                                    this.form.branch_office_email_address = value['email_address'];
                                    this.form.branch_office_website = value['website'];
                                    this.form.attach_office_tenancy_agreement_2 = value['attach_office_tenancy_agreement'];
                                }
                                // console.log(value);
                                // console.log(index);
                            });
                        }
                    }
                }).catch(error => {
                console.error('Error', error)
            })
        },
        format_date(value) {
            if (value) {
                return moment(String(value)).format('YYYY-MM-DD HH:mm:ss')
            }

        }
    }
}
</script>
<style scoped>
img{
    width: 100px;
    height: 80px;
}
caption {
    caption-side: top;
}

td {
    white-space: normal;
}

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
