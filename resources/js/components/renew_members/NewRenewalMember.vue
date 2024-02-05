<template>
    <div>
        <div class="col-xl-auto col-lg-auto col-md-auto mx-auto">
            <div class="card z-index-0">
                <div class="card-header text-center pt-4">
                    <h5 v-if="structure_change">Membership Structure Change Form</h5>
                    <h5 v-else>BAFFA MEMBERSHIP RENEWAL FORM - <span>{{currentYear}}</span></h5>
                </div>
                <div class="card-body">
                    <div id="notification">
                        <validation-errors
                            :errors="validationErrors"
                            :success="success"
                            :warning_message="warning_message"
                        ></validation-errors>
                    </div>
                    <!--  @include('partials/messages')-->
                    <form
                        @submit.prevent="submitForm"
                        role="form"
                        id="renewal-form"
                        autocomplete="off"
                        enctype="multipart/form-data"
                        class="mt-3"
                    >
                        <!--                @include('partials.messages')-->
                        <!--                {{Form::open(['route'=>'member-details.store','class'=>'contact-form form-horizontal','method'=>'POST','name'=>'newMember','files' => true])}}-->
                        <!--                        <div v-if="member">-->
                        <input type="hidden" name="email" v-model="form.email"/>
                        <input type="hidden" name="username" v-model="form.username"/>
                        <input type="hidden" name="password" v-model="form.password"/>
                        <!--                        </div>-->
                        <div class="table-responsive-xl">
                            <table
                                class="table caption-top align-middle table-sm table-bordered border-secondary"
                            >
                                <caption>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-1 text-center pt-2"><span>Date: </span></div>
                                            <div class="col-4">
                                                <input type="text" name="date_of_renewal"
                                                       v-model="form.date_of_renewal" disabled>
<!--                                                <datepicker
                                                    input-class="form-control"
                                                    name="date_of_renewal"
                                                    v-model="form.date_of_renewal"
                                                />-->
                                            </div>
                                        </div>
                                    </div>
                                </caption>
                                <!--                                <caption>(Please put “” tick mark where necessary)</caption>-->
                                <tbody>
                                <tr v-if="!structure_change">
                                    <th scope="row"></th>
                                    <td colspan="3">Any Change in Company Structure:</td>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="any_change"
                                                v-model="form.any_change"
                                                id="any_change1"
                                                value="1"
                                                @change="changeEvent"
                                            />
                                            <label class="form-check-label" for="any_change1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                v-model="form.any_change"
                                                name="any_change"
                                                id="any_change2"
                                                value="0"
                                                @change="changeEvent"
                                            />
                                            <label class="form-check-label" for="any_change2">No</label>
                                        </div>
                                        <!--<input type="text" v-model="form.place_of_enlistment" class="form-control" name="place_of_enlistment">-->
                                    </td>
                                </tr>
                                <tr>
                                    <th width="2%" scope="row">01.0</th>
                                    <td width="40%" colspan="3">Name of the organization:</td>
                                    <td width="40%">
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="firm_name"
                                            v-model="form.firm_name"
                                            v-if="!structuralChange"
                                        />
                                        <span v-else>{{form.firm_name}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" rowspan="2">02.</th>
                                    <td rowspan="2" colspan="2">Type of the Organization</td>
                                    <td>(a)</td>
                                    <td v-if="!structuralChange">
                                        <div class="form-check form-check-inline">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="firm_type"
                                                v-model="firmType"
                                                id="inlineRadio1"
                                                value="Proprietor"
                                            />
                                            <label class="form-check-label" for="inlineRadio1"
                                            >Proprietorship</label
                                            >
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                v-model="firmType"
                                                name="firm_type"
                                                id="inlineRadio2"
                                                value="Partners"
                                            />
                                            <label class="form-check-label" for="inlineRadio2"
                                            >Partnership</label
                                            >
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                v-model="firmType"
                                                name="firm_type"
                                                id="inlineRadio3"
                                                value="Limited"
                                            />
                                            <label class="form-check-label" for="inlineRadio3"
                                            >Limited Company</label
                                            >
                                        </div>
                                    </td>
                                    <td v-else>{{firmType}}</td>
                                </tr>
                                <tr>
                                    <td>(b)</td>
                                    <td v-if="!structuralChange">
                                        <div class="form-check form-check-inline">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                v-model="firmTypeLocal"
                                                name="type_local"
                                                id="inlineRadio4"
                                                value="Local"
                                            />
                                            <label class="form-check-label" for="inlineRadio4">Local</label>
                                        </div>
                                        <div v-if="firmType == 'Limited'" class="form-check form-check-inline">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                v-model="firmTypeLocal"
                                                name="type_local"
                                                id="inlineRadio5"
                                                value="Joint Venture"
                                            />
                                            <label class="form-check-label" for="inlineRadio5"
                                            >Joint Venture</label
                                            >
                                        </div>
                                        <div v-if="firmType == 'Limited'" class="form-check form-check-inline">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                v-model="firmTypeLocal"
                                                name="type_local"
                                                id="inlineRadio6"
                                                value="100% Foreign"
                                            />
                                            <label class="form-check-label" for="inlineRadio6"
                                            >100% Foreign</label
                                            >
                                        </div>
                                    </td>
                                    <td v-else>{{firmTypeLocal}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">03.</th>
                                    <td colspan="3">Name of the Contact Person:</td>
                                    <td>
<!--                                        <v-select
                                            class="lower_border"
                                            style="display: inline-block"
                                            v-model="contact_person"
                                            :options="company_owners"
                                            label="name"
                                        />-->
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="contact_person_name"
                                            v-model="form.contact_person_name"
                                            autocomplete="contact_person_name"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">04.</th>
                                    <td colspan="3">Designation of the Contact Person:</td>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="contact_person_designation"
                                                v-model="form.contact_person_designation"
                                                id="designation1"
                                                value="Chairman"
                                            />
                                            <label class="form-check-label" for="designation1"
                                            >Chairman</label
                                            >
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="contact_person_designation"
                                                v-model="form.contact_person_designation"
                                                id="designation2"
                                                value="Managing Director"
                                            />
                                            <label class="form-check-label" for="designation2"
                                            >Managing Director</label
                                            >
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="contact_person_designation"
                                                v-model="form.contact_person_designation"
                                                id="designation3"
                                                value="Director"
                                            />
                                            <label class="form-check-label" for="designation3"
                                            >Director</label
                                            >
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="contact_person_designation"
                                                v-model="form.contact_person_designation"
                                                id="designation4"
                                                value="Proprietor"
                                            />
                                            <label class="form-check-label" for="designation4"
                                            >Proprietor</label
                                            >
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="contact_person_designation"
                                                v-model="form.contact_person_designation"
                                                id="designation5"
                                                value="Managing Partner"
                                            />
                                            <label class="form-check-label" for="designation5"
                                            >Managing Partner</label
                                            >
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="contact_person_designation"
                                                v-model="form.contact_person_designation"
                                                id="designation6"
                                                value="Others"
                                            />
                                            <label class="form-check-label" for="designation6">Others</label
                                            >&emsp;
                                            <input
                                                v-if="form.contact_person_designation == 'Others'"
                                                type="text"
                                                v-model="form.contact_person_designation_other"
                                                class="form-control"
                                                name="contact_person_designation_other"
                                            />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" rowspan="2">05.</th>
                                    <td colspan="3">Membership Number:</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="membership_number"
                                            v-model="form.username"
                                            autocomplete="membership_number"
                                            disabled
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">Date of Admission:</td>
                                    <td>
                                        <datepicker
                                            input-class="form-control"
                                            name="date_of_admission"
                                            v-model="form.date_of_admission"
                                            disabled
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">06.</th>
                                    <td colspan="3">Place of Enlistment:</td>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="place_of_enlistment"
                                                v-model="form.place_of_enlistment"
                                                id="place_of_enlistment1"
                                                value="Dhaka"
                                                disabled
                                            />
                                            <label class="form-check-label" for="place_of_enlistment1"
                                            >Dhaka</label
                                            >
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                v-model="form.place_of_enlistment"
                                                name="place_of_enlistment"
                                                id="place_of_enlistment2"
                                                value="Chattogram"
                                                disabled
                                            />
                                            <label class="form-check-label" for="place_of_enlistment2"
                                            >Chattogram</label
                                            >
                                        </div>
                                        <!--<input type="text" v-model="form.place_of_enlistment" class="form-control" name="place_of_enlistment">-->
                                    </td>
                                </tr>
                                <!--                                <tr>
                                                  <th scope="row">7.0</th>
                                                  <td colspan="3">Registered/Head Office:</td>
                                                  <td>
                                                      <textarea name="registered_office" id="registered_office" cols="50" rows="3"></textarea>
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <th scope="row">8.0</th>
                                                  <td colspan="3">Current Office:</td>
                                                  <td>
                                                      <textarea name="current_office" id="current_office" cols="50" rows="3"></textarea>
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <th scope="row">9.0</th>
                                                  <td colspan="3">Branch Office:</td>
                                                  <td>
                                                      <textarea name="branch_office" id="branch_office" cols="50" rows="3"></textarea>
                                                  </td>
                                              </tr>-->

                                <tr>
                                    <th scope="row" rowspan="6">07.</th>
                                    <td rowspan="6">Registered/Head Office:</td>
                                    <td>(a)</td>
                                    <td>Address:</td>
                                    <td>
                                        <input
                                            type="hidden"
                                            name="member_address[1][id]"
                                            v-model="form.head_office_id"
                                        />
                                        <input
                                            type="hidden"
                                            name="member_address[1][member_address_type]"
                                            value="register"
                                        />
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Address"
                                            name="member_address[1][address]"
                                            v-model="form.head_office_address"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>(b)</td>
                                    <td>Total Floor Area:</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Total Floor Area"
                                            name="member_address[1][floor_area]"
                                            v-model="form.head_office_floor_area"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>(c)</td>
                                    <td>Telephone No:</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Telephone No"
                                            name="member_address[1][telephone_no]"
                                            v-model="form.head_office_telephone_no"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>(d)</td>
                                    <td>Fax No:</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Fax no"
                                            name="member_address[1][fax_no]"
                                            v-model="form.head_office_fax_no"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>(e)</td>
                                    <td>Mobile No:</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Mobile No"
                                            name="member_address[1][mobile_no]"
                                            v-model="form.head_office_mobile_no"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>(f)</td>
                                    <td>E-mail Address:</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="E-mail Address"
                                            name="member_address[1][email_address]"
                                            v-model="form.head_office_email_address"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" rowspan="6">08.</th>
                                    <td rowspan="6">Current Office Address:</td>
                                    <td>(a)</td>
                                    <td>Address:</td>
                                    <td>
                                        <input
                                            type="hidden"
                                            name="member_address[2][id]"
                                            v-model="form.current_office_id"
                                        />
                                        <input
                                            type="hidden"
                                            name="member_address[2][member_address_type]"
                                            value="current"
                                        />
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Address"
                                            name="member_address[2][address]"
                                            v-model="form.current_office_address"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>(b)</td>
                                    <td>Total Floor Area:</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Total Floor Area"
                                            name="member_address[2][floor_area]"
                                            v-model="form.current_office_floor_area"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>(c)</td>
                                    <td>Telephone No:</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Telephone No"
                                            name="member_address[2][telephone_no]"
                                            v-model="form.current_office_telephone_no"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>(d)</td>
                                    <td>Fax No:</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Fax no"
                                            name="member_address[2][fax_no]"
                                            v-model="form.current_office_fax_no"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>(e)</td>
                                    <td>Mobile No:</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Mobile No"
                                            name="member_address[2][mobile_no]"
                                            v-model="form.current_office_mobile_no"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>(f)</td>
                                    <td>E-mail Address:</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="E-mail Address"
                                            name="member_address[2][email_address]"
                                            v-model="form.current_office_email_address"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" rowspan="5">09.</th>
                                    <td rowspan="5">Branch Office, if any:</td>
                                    <td>(a)</td>
                                    <td>Address:</td>
                                    <td>
                                        <input
                                            type="hidden"
                                            name="member_address[3][id]"
                                            v-model="form.branch_office_id"
                                        />
                                        <input
                                            type="hidden"
                                            name="member_address[3][member_address_type]"
                                            value="branch"
                                        />
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Address"
                                            name="member_address[3][address]"
                                            v-model="form.branch_office_address"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>(b)</td>
                                    <td>Total Floor Area:</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Total Floor Area"
                                            name="member_address[3][floor_area]"
                                            v-model="form.branch_office_floor_area"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>(c)</td>
                                    <td>Telephone No:</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Telephone No"
                                            name="member_address[3][telephone_no]"
                                            v-model="form.branch_office_telephone_no"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>(e)</td>
                                    <td>Mobile No :</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Mobile No"
                                            name="member_address[3][mobile_no]"
                                            v-model="form.branch_office_mobile_no"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>(f)</td>
                                    <td>E-mail Address:</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="E-mail Address"
                                            name="member_address[3][email_address]"
                                            v-model="form.branch_office_email_address"
                                        />
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row">10.</th>
                                    <td colspan="3">Telephone No<br/>(for all communication):</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Telephone No"
                                            name="telephone_no"
                                            v-model="form.telephone_no"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" rowspan="2">11.</th>
                                    <td colspan="3">Mobile No<br/>(for all communication):</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Mobile No"
                                            name="mobile_no"
                                            v-model="form.mobile_no"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">Fax No<br/>(for all communication):</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Fax no"
                                            name="fax_no"
                                            v-model="form.fax_no"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" rowspan="2">12.</th>
                                    <td colspan="3">E-mail Address<br/>(for all communication):</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="E-mail Address"
                                            name="email_address"
                                            v-model="form.email_address"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">Website:</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Website"
                                            name="website"
                                            v-model="form.website"
                                        />
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row" rowspan="2">13.</th>
                                    <td colspan="3">
                                        Freight Forwarders License No. and Date with Validity:
                                    </td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input
                                                type="text"
                                                class="form-control"
                                                v-model="form.ff_license_no"
                                                placeholder="Trade License Number"
                                                name="freight_forwarders_license_number"
                                            />
                                            <span class="input-group-text">|</span>
                                            <datepicker
                                                input-class="form-control"
                                                name="freight_forwarders_license_date"
                                                v-model="form.freight_forwarders_license_date"
                                            />
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3">Attached Freight Forwarders License:</td>
                                    <td>
                                        <ImageTag
                                            alt="attach_ff_license_no"
                                            name="attach_ff_license_no"
                                            :src="form.attach_ff_license_no"
                                            @saveImage="saveImage"
                                        />
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row" rowspan="2">14.</th>
                                    <td colspan="3">Trade License Number and Date with Validity:</td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input
                                                type="text"
                                                class="form-control"
                                                v-model="form.trade_license_number"
                                                placeholder="Trade License Number"
                                                name="trade_license_number"
                                            />
                                            <span class="input-group-text">|</span>
                                            <datepicker
                                                input-class="form-control"
                                                name="trade_license_date"
                                                v-model="form.trade_license_date"
                                            />
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3">Attached Trade License:</td>
                                    <td>
                                        <ImageTag
                                            alt="attach_trade_license"
                                            name="attach_trade_license"
                                            :src="form.attach_trade_license"
                                            @saveImage="saveImage"
                                        />
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row" rowspan="2">15.</th>
                                    <td colspan="3">12-digit e-TIN No:</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.tin_number"
                                            placeholder="EX: XXXXXXXXXXXX"
                                            name="tin_number"
                                        />
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3">Attached e-TIN No:</td>
                                    <td>
                                        <ImageTag
                                            alt="attach_e_tin_certificate"
                                            name="attach_e_tin_certificate"
                                            :src="form.attach_e_tin_certificate"
                                            @saveImage="saveImage"
                                        />
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="5">
                                        <div class="d-grid gap-2 col-6 mx-auto pt-3">
                                            <button
                                                type="submit"
                                                v-bind:class="[
                            loading ? 'disabled btn-secondary' : 'btn-secondary',
                            'btn',
                          ]"
                                                id="loader-btn"
                                            >
                                                <span>Submit</span>
                                                <div
                                                    id="loader"
                                                    v-if="loading"
                                                    v-bind:style="{
                              backgroundImage:
                                'url(' +
                                addProjectPath('/assets/img/ajax-loader.gif') +
                                ')',
                            }"
                                                ></div>
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
import {publicPath} from "../../../../vue.config";
import vSelect from "vue-select";

export default {
    name: "NewRenewalMember",
    components: {vSelect, ValidationErrors, Datepicker, moment, ImageTag},
    props: ["is_member",'structure_change'],
    data: () => ({
        isLoggedIn: false,
        user: false,
        url: "",
        date_of_today: new Date(),
        errors: [],
        validationErrors: null,
        success: null,
        warning_message: null,
        firmName: "",
        firmType: "",
        firmTypeLocal: "",
        structuralChange:true,
        countries: null,
        loading: false,
        tempForm: [],
        // currentYear: new Date().getFullYear(), // 2020
        company_owners: [],
        contact_person: [],


        // images: {
        //     attach_trade_license: null,
        //     attach_e_tin_certificate: null,
        //     attach_ff_license_no: null,
        // },
        form: {
            contact_person_id: null,
            contact_person_name: "",
            contact_person_photo: "",
            contact_person_designation: "Chairman",
            date_of_renewal: new Date().toISOString().slice(0, 10),
            date_of_admission: null,
            freight_forwarders_license_date: new Date().toISOString().slice(0, 10),
            trade_license_date: new Date().toISOString().slice(0, 10),
            attach_trade_license: null,
            attach_e_tin_certificate: null,
            attach_ff_license_no: null,
            any_change: '0',
            structure_change: '0',
            last_renew_year:null
        },
    }),
    created: function () {
        if (window.Laravel.isLoggedin) {
            this.isLoggedIn = true;
            this.user = window.Laravel.user;
            this.getMember();
        } else {
            console.log("Member Not Log In");
        }
        if(this.structure_change){
            this.form.any_change = '1'
            this.form.structure_change = '1'
            this.structuralChange = false
        }
    },
    computed: {
        currentYear() {
            let dt = new Date();
            dt.setMonth(dt.getMonth() + 1)
            return dt.getFullYear();
        }
    },
    watch: {
        firmType() {
            if (this.firmType == 'Partners') {
                this.firmTypeLocal = 'Local';
            } else if (this.firmType == 'Limited') {
            } else {
                this.firmTypeLocal = 'Local';
            }
        }
    },
    methods: {
        changeEvent(event) {
            console.log('Selected Value :' + event.target.value)
            this.structuralChange = this.form.any_change == '0' ? true : false;
            this.form.firm_name = this.firmName;
            // this.form.firm_type = this.firmType;
            // this.form.type_local = this.firmTypeLocal;
        },
        saveImage: function (event) {
            // if(this.form.attach_e_tin_certificate)
            //     console.log(this.form.attach_e_tin_certificate.name)
            // else
            //     alert('222')
            // alert('Srry')
            // console.log(event.target.name)
            this.form[event.target.name] = event.target.files[0];
        },
        submitForm: function () {
            this.errors = [];
            // if (!this.form.username) this.errors.push(["username", ["Name required."]]);
            // if (!this.form.email) this.errors.push(["email", ["Email required."]]);
            if (!this.form.firm_name) this.errors.push(["firm_name", ["Firm Name required."]]);
            if (this.errors.length) {
                // this.validationErrors = Object.assign({},this.errors)
                this.validationErrors = Object.fromEntries(this.errors);
            } else {
                // console.log(this.form)
                // console.log(initFromData)
                // if (!this.errors.length) return true;
                this.loading = true;
                this.saveMemberDetails();
            }
        },
        saveMemberDetails: function () {
            // const data = new FormData();
            let myForm = document.getElementById("renewal-form");
            let data = new FormData(myForm);
            data.set("date_of_renewal", this.format_date(this.form.date_of_renewal));
            data.set("date_of_admission", this.format_date(this.form.date_of_admission));

            data.set("submission_year", this.currentYear);
            data.set("firm_name", this.form.firm_name); // Correct
            data.set("firm_type", this.firmType);
            data.set("type_local", this.firmTypeLocal);
            data.set("membership_number", this.form.username);
            data.set("date_of_admission", this.form.date_of_admission);
            data.set("place_of_enlistment", this.form.place_of_enlistment);
            data.set("any_change", this.form.any_change);
            data.set("structure_change", this.form.structure_change);
            data.set("contact_person_name", this.form.contact_person_name);
            if(typeof this.form.attach_e_tin_certificate == 'string')
                data.set("attach_e_tin_certificate", this.form.attach_e_tin_certificate);
            if(typeof this.form.attach_trade_license == 'string')
                data.set("attach_trade_license", this.form.attach_trade_license);
            if(typeof this.form.attach_ff_license_no == 'string')
                data.set("attach_ff_license_no", this.form.attach_ff_license_no);


            if(this.contact_person){
                // data.set("contact_person_id", this.contact_person.id);
                // data.set("contact_person_name", this.contact_person.name);
                // data.set("contact_person_photo", this.contact_person.attach_photograph);
            }

            data.set(
                "freight_forwarders_license_date",
                this.format_date(this.form.freight_forwarders_license_date)
            );
            data.set("trade_license_date", this.format_date(this.form.trade_license_date));
            if (!this.is_member) data.set("member_id", this.$route.params.id);
            else data.set("member_id", this.user.id);
            // data.set('attach_trade_license', this.form.attach_trade_license);
            // data.append('username', this.form.username);
            // data.append('email', this.form.email);
            // data.append('password', this.form.password);
            // console.log(this.form)
            const config = {
                headers: {
                    //'content-type': 'multipart/form-data' }
                    "content-type": "multipart/form-data",
                    accept: "application/json",
                },
            };
            axios
                .post("/api/renew_member", data, config)
                .then((res) => {
                    // axios.post("/api/members/renew/" + this.$route.params.id, data, config).then(res => {
                    console.log(res.data);
                    this.reset();
                    // window.location.href = publicPath + "/profile/member/" + this.$route.params.id;
                    // window.location =
                    if (!this.is_member)
                        this.$router.push({
                            name: "view-renewal-member",
                            params: {id: res.data},
                            query: {success: this.success},
                        });
                    else
                        this.$router.push({
                            name: "view-renewal-member-for-member",
                            params: {id: res.data},
                            query: {success: this.success},
                        });
                })
                .catch((error) => {
                    if (error.response.status == 422) {
                        this.validationErrors = error.response.data.errors;
                    } else {
                        this.warning_message = error.response.data.message;
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        reset: function () {
            this.validationErrors = null;
            this.success = "Member Renew Successfully";
            this.company_owners = [];

            // this.form = Object.assign({}, initFormData)
            // for(let field in this.formData){
            //     this.formData[field] = null;
            // }
        },
        getMember: function () {
            if (!this.is_member) {
                this.url = "/api/members/" + this.$route.params.id + "/edit";
            } else {
                this.url = "/api/members/" + this.user.id + "/edit";
            }
            axios
                .get(this.url)
                .then((res) => {
                    if (Object.keys(res.data.data).length === 0) {
                        this.$router.push({
                            name: "registration",
                            query: {warning_message: "Please, Try Again !"},
                        });
                    } else {
                        console.log('Member Login Data', res.data.data)
                        // this.form.firm_name = res.data.data["organization_name"];
                        this.form.username = res.data.data["username"];
                        this.form.email = res.data.data.email;
                        this.form.first_name = res.data.data.first_name;
                        this.form.status = res.data.data.status;
                        this.company_owners = res.data.data.company_owners;
                        if (res.data.data["member_detail"]) {
                            // this.firmType = res.data.data["member_detail"]["firm_type"];
                            if(res.data.data["member_detail"]["form_submit_date"])
                                this.form.date_of_admission = new Date(res.data.data["member_detail"]["form_submit_date"]).toISOString().slice(0, 10);
                            this.tempForm = res.data.data["member_detail"];
                            Object.keys(this.tempForm).forEach((item) => {
                                if (this.tempForm[item]) {
                                    this.form[item] = this.tempForm[item];
                                }
                            });
                            this.form.firm_name = res.data.data["organization_name"];
                            this.firmName = this.form.firm_name;
                            this.firmType = this.form["firm_type"];
                            this.firmTypeLocal = this.form["type_local"];
                            this.last_renew_year = this.form["last_renew_year"];
                        }
                        if (res.data.data["member_address"]) {
                            this.tempForm = res.data.data["member_address"];
                            this.tempForm.forEach((value, index) => {
                                // arr.push(value);
                                if (value["member_address_type"] == "register") {
                                    this.form.head_office_id = value["id"];
                                    this.form.head_office_address = value["address"];
                                    this.form.head_office_floor_area = value["floor_area"];
                                    this.form.head_office_telephone_no = value["telephone_no"];
                                    this.form.head_office_fax_no = value["fax_no"];
                                    this.form.head_office_mobile_no = value["mobile_no"];
                                    this.form.head_office_email_address = value["email_address"];
                                    this.form.head_office_website = value["website"];
                                } else if (value["member_address_type"] == "branch") {
                                    this.form.branch_office_id = value["id"];
                                    this.form.branch_office_address = value["address"];
                                    this.form.branch_office_floor_area = value["floor_area"];
                                    this.form.branch_office_telephone_no = value["telephone_no"];
                                    this.form.branch_office_fax_no = value["fax_no"];
                                    this.form.branch_office_mobile_no = value["mobile_no"];
                                    this.form.branch_office_email_address = value["email_address"];
                                    this.form.branch_office_website = value["website"];
                                } else if (value["member_address_type"] == "current") {
                                    this.form.current_office_id = value["id"];
                                    this.form.current_office_address = value["address"];
                                    this.form.current_office_floor_area = value["floor_area"];
                                    this.form.current_office_telephone_no = value["telephone_no"];
                                    this.form.current_office_fax_no = value["fax_no"];
                                    this.form.current_office_mobile_no = value["mobile_no"];
                                    this.form.current_office_email_address = value["email_address"];
                                    this.form.current_office_website = value["website"];
                                }
                            });
                        }
                    }
                })
                .catch((error) => {
                    console.error("Error", error);
                }).finally(()=>{
                    // console.log(this.form.last_renew_year)
                    // console.log(this.currentYear)
                    // this.member_name = window.Laravel.user.email
                if(!this.structure_change){
                    if(this.last_renew_year >= this.currentYear){
                        this.$router.push({
                            name: 'all-renew-members-for-member',query: {warning_message: "You have already completed the registration for the current Year!"}
                        });
                    }
                }
            });
        },
        format_date(value) {
            if (value) {
                return moment(String(value)).format("YYYY-MM-DD HH:mm:ss");
            }
        },
    },
};
</script>
<style scoped>
img {
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
.lower_border {
    //width: -webkit-fill-available;
    min-width: 300px;
    border: none;
    /*border-bottom: 1px solid black;*/
    padding: 5px 10px;
    outline: none;
}
</style>
