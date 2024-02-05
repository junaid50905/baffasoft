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
                        <!--                        </div>-->
                        <div class="table-responsive-xl">
                            <table
                                class="table caption-top align-middle table-sm table-bordered border-secondary">
                                <caption>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-1 text-center pt-2"><span>Date: </span></div>
                                            <div class="col-4">
                                                <input type="text" input-class="form-control" name="form_submit_date"
                                                       v-model="form.form_submit_date" disabled>
<!--                                                <datepicker input-class="form-control" name="form_submit_date"
                                                            v-model="form.form_submit_date" disabled/>-->

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
                                               name="firm_name" v-model="form.firm_name"
                                               autocomplete="firm_name" autofocus>
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
                                        </span>
                                        <span v-if="firmType === 'Partners'">
                                            Attachment of Deed of Agreement
                                        </span>
                                        <span v-if="firmType === 'Limited'">
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
                                                   aria-label="Username"
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
                                        </span>
                                    </td>
                                    <td><input type="file" class="form-control" placeholder="Place"
                                               name="attach_incorporation_certificate" v-on:change="saveImage"></td>
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
                                    <td><input type="number" class="form-control" v-model="form.tin_number"
                                               placeholder="EX: XXXXXXXXXXXX" name="tin_number"></td>
                                </tr>
                                <tr>
                                    <th scope="row">7.2</th>
                                    <td colspan="3">Attested copy of valid e-TIN Certificate and <br>Income Tax
                                        Clearance Certificate:
                                    </td>
                                    <td>
                                        <ImageTag alt="e-TIN Certificate"
                                                  name="attach_e_tin_certificate"
                                                  :src="form.attach_e_tin_certificate" @saveImage="saveImage" />
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">8.1</th>
                                    <td colspan="3">VAT Registration Number:</td>
                                    <td><input type="number" class="form-control"
                                               v-model="form.vat_registration_number"
                                               placeholder="EX: XXXXXXXXXXXX" name="vat_registration_number">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">8.2</th>
                                    <td colspan="3">VAT Registration Certificate (13 digits):</td>
                                    <td><ImageTag alt="attach_vat_registration_certificate"
                                                  name="attach_vat_registration_certificate"
                                                  :src="form.attach_vat_registration_certificate" @saveImage="saveImage" />
                                        </td>
                                </tr>
                                <tr>
                                    <th scope="row">8.3</th>
                                    <td colspan="3">Freight Forwarding License No. (if any):</td>
                                    <td><input type="number" class="form-control"
                                               v-model="form.ff_license_no"
                                               placeholder="EX: XXXXXXXXXXXX" name="ff_license_no">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">8.4</th>
                                    <td colspan="3">Freight Forwarding License Attachment:</td>
                                    <td><ImageTag alt="attach_ff_license_no"
                                                  name="attach_ff_license_no"
                                                  :src="form.attach_ff_license_no" @saveImage="saveImage" /></td>
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
                                    <td><ImageTag alt="attach_bank_solvency_certificate"
                                                  name="attach_bank_solvency_certificate"
                                                  :src="form.attach_bank_solvency_certificate" @saveImage="saveImage" /></td>
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
                                                  @saveImage="saveImage" /></td>
                                </tr>
                                <tr class="company_owner_before">
                                    <th scope="row">11.0</th>
                                    <td colspan="3">Name of Authorized Person (Director/Partner in block
                                        letters):
                                    </td>
                                    <td><input type="text" class="form-control" name="name_of_authorized_person"
                                               v-model="form.name_of_authorized_person">
                                    </td>
                                </tr>
                                <template v-for="n in company_owner">
                                    <!--                        @php($owner_id = 1)-->
                                    <tr class="company_owner_this">
                                        <th scope="row" rowspan="16">12.0</th>
                                        <td rowspan="16" colspan="2">Company Owners Information<br>({{firmType}}):
                                        </td>
                                        <td>Name:</td>
                                        <td><input type="text" class="form-control"
                                                   :name="'company_owner['+n+'][name]'"></td>
                                    </tr>
                                    <tr>
                                        <td>Designation:</td>
                                        <td><input type="text" class="form-control"
                                                   :name="'company_owner['+n+'][designation]'">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Signatory:</td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                       :name="'company_owner['+n+'][signatory]'" :id="'signatory1'+n" value="1">
                                                <label class="form-check-label" :for="'signatory1'+n">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                       :name="'company_owner['+n+'][signatory]'" :id="'signatory2'+n" value="0">
                                                <label class="form-check-label" :for="'signatory2'+n">No</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nominate For Vote:</td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                       :name="'company_owner['+n+'][nominate_for_vote]'" :id="'nominate_for_vote1'+n" value="1">
                                                <label class="form-check-label" :for="'nominate_for_vote1'+n">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                       :name="'company_owner['+n+'][nominate_for_vote]'" :id="'nominate_for_vote2'+n" value="0">
                                                <label class="form-check-label" :for="'nominate_for_vote2'+n">No</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Authorized Person:</td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                       :name="'company_owner['+n+'][authorized_person]'" :id="'authorized_person1'+n" value="1">
                                                <label class="form-check-label" :for="'authorized_person1'+n">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                       :name="'company_owner['+n+'][authorized_person]'" :id="'authorized_person2'+n" value="0">
                                                <label class="form-check-label" :for="'authorized_person2'+n">No</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>NID No:</td>
                                        <td><input type="text" class="form-control"
                                                   :name="'company_owner['+n+'][nid_no]'">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> Attach NID:</td>
                                        <td><input type="file" class="form-control"
                                                   :name="'company_owner['+n+'][attach_nid]'">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Educational Qualification:</td>
                                        <td><input type="text" class="form-control"
                                                   :name="'company_owner['+n+'][educational_qualification]'">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Attach Educational Certificate:</td>
                                        <td><input type="file" class="form-control"
                                                   :name="'company_owner['+n+'][attach_educational_qualification]'">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Photograph:</td>
                                        <td><input type="file" class="form-control"
                                                   :name="'company_owner['+n+'][attach_photograph]'">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Mobile No:</td>
                                        <td><input type="text" class="form-control" placeholder="Mobile No."
                                                   :name="'company_owner['+n+'][mobile_no]'">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Email:</td>
                                        <td><input type="text" class="form-control" placeholder="E-mail Address"
                                                   :name="'company_owner['+n+'][email]'">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nationality:</td>
                                        <td>
                                                <select class="form-select" aria-label="Default" :name="'company_owner['+n+'][nationality_id]'">
                                                    <option v-for="country in countries" :selected="country.id === 50" :key="country.id" :value="country.id">{{country.name}}</option>
                                                </select>
<!--                                        @foreach($countries as $country)-->
<!--                                        <option value="{{$country->id}}"-->
<!--                                                {{$country->id == '50' ? 'selected' : ''}}>-->
<!--                                            {{$country->name}}</option>-->
<!--                                        @endforeach-->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Specific Signature:</td>
                                        <td><input type="file" class="form-control"
                                                   :name="'company_owner['+n+'][attach_signature]'">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Experience Year:</td>
                                        <td><input type="text" class="form-control" placeholder="Experience Year"
                                                   :name="'company_owner['+n+'][experience_year]'">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Attach Experience Certificate:</td>
                                        <td><input type="file" class="form-control"
                                                   :name="'company_owner['+n+'][attach_experience_certificate]'">
                                        </td>
                                    </tr>
                                </template>
                                <tr v-if="firmType !== 'Proprietor'">
                                    <td colspan="5">
                                        <div class="d-grid mx-2"><input type="button" @click="company_owner++"
                                                                        value="Click to Add Owner"
                                                                        class="btn btn-light"></div>
                                    </td>
                                </tr>
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
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" rowspan="7">14.0</th>
                                    <td rowspan="7">Head Office:</td>
                                    <td>(a)</td>
                                    <td>Address:</td>
                                    <td>
                                        <input type="hidden" name="member_address[1][member_address_type]"
                                               value="register">
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
                                    <td><input type="file" class="form-control"
                                               name="member_address[1][attach_office_tenancy_agreement]"
                                               v-on:change="saveImage">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" rowspan="7">15.0</th>
                                    <td rowspan="7">Branch Office, if any:</td>
                                    <td>(a)</td>
                                    <td>Address:</td>
                                    <td>
                                        <input type="hidden" name="member_address[2][member_address_type]"
                                               value="branch">
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
                                    <td>(d)</td>
                                    <td>Fax No:</td>
                                    <td><input type="text" class="form-control" placeholder="Fax no"
                                               name="member_address[2][fax_no]" v-model="form.branch_office_fax_no"></td>
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
                                    <td><input type="file" class="form-control" placeholder="E-mail Address"
                                               name="member_address[2][attach_office_tenancy_agreement]"
                                               v-on:change="saveImage">
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
                                <tr>
                                    <th scope="row">17.0</th>
                                    <td colspan="3">Name of the existing member organization(s) of BAFFA (if any):
                                    </td>
                                    <td><input type="text" class="form-control" name="other_org"
                                               v-model="form.other_org">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">18.0</th>
                                    <td colspan="3">Attested PROPOSED & SECONDED BY:</td>
                                    <td>
                                        <ImageTag alt="attach_proposed_seconded_by"
                                                  name="attach_proposed_seconded_by"
                                                  :src="form.attach_proposed_seconded_by"
                                                  @saveImage="saveImage" />
<!--                                        <input type="file" class="form-control" placeholder="Place"
                                               name="attach_proposed_seconded_by" v-on:change="saveImage">-->
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
<!--                                        <input type="file" class="form-control" placeholder="Place"
                                               name="attach_declaration_undertaking" v-on:change="saveImage">-->
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <div class="d-grid gap-2 col-6 mx-auto pt-3">
                                            <button type="submit" v-bind:class="[loading ? 'disabled btn-secondary' : 'btn-secondary','btn']" id="loader-btn">
                                                <span>Create Member</span>
                                                <div id="loader" v-if="loading" v-bind:style="{'backgroundImage': 'url(' + addProjectPath('/assets/img/ajax-loader.gif') + ')'}" ></div>
                                            </button>
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
import Datepicker from "vuejs-datepicker";
import moment from "moment";
import ImageTag from "../ImageTag";

export default {
    name: "NewMember",
    components: {ValidationErrors, Datepicker, moment, ImageTag},
    data: () => ({
        // return {
        date_of_today: new Date(),
        company_owner: 1,
        errors: [],
        validationErrors: null,
        success: null,
        warning_message:null,
        firmType: 'Proprietor',
        countries:null,
        loading:false,
        form: {
            username: '',
            email: '',
            password: '',
            form_submit_date: new Date().toISOString().slice(0, 10),
            firm_name: '',
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
            // head_office_address: '',
            // head_office_floor_area: '',
            // head_office_telephone_no: '',
            // head_office_fax_no: '',
            // head_office_mobile_no: '',
            // head_office_email_address: '',
            // branch_office_address: '',
            // branch_office_floor_area: '',
            // branch_office_telephone_no: '',
            // branch_office_mobile_no: '',
            // branch_office_email_address: '',
            warehouse_office_address: '',
            warehouse_office_floor_area: '',
            other_org: '',


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
                this.company_owner = 1;
                this.form.type_local = 'Local';
            } else if (this.firmType == 'Limited') {
                this.company_owner = 1;
            } else {
                this.company_owner = 1;
                this.form.type_local = 'Local';
            }
        }
    },
    methods: {
        getCountries(){
            axios
                .get('/api/members/countries')
                .then(res => {
                    this.countries = res.data
                }).catch(error => {
                console.error(error.response.data.message)
            })
        },
        saveImage: function (event) {
            // console.log(event.target.name)
            // console.log(event.target.files[0])
            this.form[event.target.name] = event.target.files[0];
            // this.form.attach_bank_solvency_certificate = event.target.files[0];
            // this.form.attach_vat_registration_certificate = event.target.files[0];
            // this.form.attach_e_tin_certificate = event.target.files[0];
            // this.form.attach_trade_license = event.target.files[0];
            // this.form.attach_seconded_by_signature = event.target.files[0];
            // this.form.attach_proposed_by_signature_of_seconder = event.target.files[0];
            // this.form.attach_no_of_appointed_staff = event.target.files[0];
            // console.log(this.form.attach_id_card_or_passport)
        },
        submitForm: function () {
            this.errors = [];
            if (!this.form.username) this.errors.push(["username", ["Name required."]]);
            if (!this.form.email) this.errors.push(["email", ["Email required."]]);
            if (!this.form.firm_name) this.errors.push(["firm_name", ["Firm name required."]]);
            if (this.errors.length) {
                // this.validationErrors = Object.assign({},this.errors)
                this.validationErrors = Object.fromEntries(this.errors)
            } else {
                // console.log(this.form)
                // console.log(initFromData)
                // if (!this.errors.length) return true;
                this.loading = true;
                this.saveMemberDetails()
            }
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
                headers: { 'content-type': 'multipart/form-data' }
            }
            axios.post("/api/members", data,config).then(res => {
                // console.log(res.data)
                this.reset();
                this.$router.push({ name: "registration", query: { success: this.success } });
            }).catch(error => {
                if (error.response.status == 422) {
                    this.validationErrors = error.response.data.errors;
                }else{
                   this.warning_message = error.response.data.message;
                }
            }).finally(()=>{
                this.loading =  false
            });
        },
        reset: function (){
            this.validationErrors = null;
            this.success = 'Registration Successfully. Now Sign in For Details';
            // this.form = Object.assign({}, initFormData)
            // for(let field in this.formData){
            //     this.formData[field] = null;
            // }
        },
        getMember: function () {
            axios
                .get('/api/members/1')
                .then(res => {
                    if (Object.keys(res.data).length === 0) {
                        this.$router.push({name: "registration", query: {warning_message: 'Please, Try Again !'}});
                    } else {
                        // console.log('Member Login Data', res.data)
                        // this.member = res.data
                        this.form.username = res.data.username
                        this.form.email = res.data.email
                        this.form.password = res.data.password
                    }
                }).catch(error => {
                console.log('Error',error)
            })
            // $.get('mysession',function(response) {
            //     self.sessionsData = response; })
        },
        format_date(value){
            if(value){
                return moment(String(value)).format('YYYY-MM-DD HH:mm:ss')
            }

        }
    }
}
</script>
<style scoped>
td{
    white-space: normal;
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

</style>
