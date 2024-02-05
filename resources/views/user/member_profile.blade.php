@extends('layouts.app')

@section('page-title', __('My Profile'))
@section('page-heading', __('My Profile'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('My Profile')
    </li>
@stop

@section('content')
    @include('partials.messages')

    <div class="row">
        <div class="col-sm-12" id="edit">
            <div class="row">
                <div class="col-6">
                    <a class="btn btn-primary btn-lg btn-block"
                       href="{{url("/admin/member/$member->id/edit")}}">Edit</a>
                </div>
                <div class="col-6">
                    <button type="button" class="btn btn-secondary btn-lg btn-block" onclick="window.print()">Print
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                {!! HTML::style('front/assets/css/dashboard-style.css') !!}

                <div class="row">
                    <div class="col-sm-12 dash">
                        <h4>BAFFA Member’s Dashboard</h4>
                        <p class="text-center p1">Notification for recent activities</p>
                        <div class="box1">
                            <p>Activity Status</p>
                            @if ($member['status'] === 'Active')
                                <p class="p2">Active</p>
                            @else
                                <p class="p3">Inactive</p>
                            @endif
                        </div>
                        <div class="box2">
                            <p>01. Name of Organization : {{$member['organization_name'] ?? ''}}</p>
                            <p>02. Membership Number : …………………………………</p>
                            <p>03. Date of Admission : {{$member_details['form_submit_date'] ?? ''}}</p>
                            <p>04. Place of Enlistment : {{$member_details['place_of_enlistment'] ?? ''}}</p>
                        </div>
                        <div class="box3">
                            <div class="d-flex">
                                <div class="">
                                    <p>05. Type of the Organization<br>(Please Mark <i class="fas fa-check"></i>)</p>
                                </div>
                                <div class="d-flex flex-column">
                                    <p class="ms-4">(a):
                                        <i class="far @if($member_details['firm_type'] === 'Proprietor') fa-check-square @else fa-square @endif"></i> Proprietorship
                                        <i class="far @if($member_details['firm_type'] === 'Partner') fa-check-square @else fa-square @endif"></i> Partnership
                                        <i class="far @if($member_details['firm_type'] === 'Limited') fa-check-square @else fa-square @endif"></i> Limited
                                        <br>
                                        (b):
                                        <i class="far @if($member_details['type_local'] === 'Local') fa-check-square @else fa-square @endif"></i> Local
                                        <i class="far @if($member_details['type_local'] === 'Joint Venture') fa-check-square @else fa-square @endif"></i> Joint Venture
                                        <i class="far @if($member_details['type_local'] === '100% Foreign') fa-check-square @else fa-square @endif"></i> 100% Foreign
                                        </p>
                                </div>


                            </div>
                        </div>
                        <p class="p4">06. Company Owner(s) information:</p>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    @if ($member_details['firm_type'] === 'Proprietor')
                                        <th>Proprietorship</th>
                                    @elseif($member_details['firm_type'] === 'Partner')
                                        <th>Partnership</th>
                                    @elseif($member_details['firm_type'] === 'Limited')
                                        <th>Limited</th>
                                    @endif
                                </tr>
                                @if ($member_details['firm_type'] === 'Proprietor' or $member_details['firm_type'] === 'Partner')
                                    @foreach($company_owners as $company_owner)
                                        <tr>
                                            <td>6.1 Managing {{$member_details['firm_type']}}’s Name: {{$company_owner->name ?? ''}}<br>
                                                6.2 NID No: {{$company_owner->nid_no ?? ''}}<br>
                                                6.2 Attach NID: {{$company_owner->attach_nid ?? ''}}<br>
                                                6.3 Educational
                                                qualification: {{$company_owner->educational_qualification ?? ''}}<br>
                                                6.3 Attach Educational
                                                qualification: {{$company_owner->attach_educational_qualification ?? ''}}
                                                <br>
                                                6.4 Photograph: {{$company_owner->attach_photograph ?? ''}}<br>
                                                6.5 Mobile No: {{$company_owner->mobile_no ?? ''}}<br>
                                                6.6 Email: {{$company_owner->email ?? ''}}<br>
                                                6.7 Nationality ID:{{$company_owner->nationality_id ?? ''}}<br>
                                                6.7 Signature.{{$company_owner->attach_signature ?? ''}}<br>
                                                6.7 Experience
                                                Certificate.{{$company_owner->attach_experience_certificate ?? ''}}<br>
                                            </td>
                                        </tr>
                                    @endforeach
                                @elseif($member_details['firm_type'] === 'Limited')
                                    @foreach($company_owners as $company_owner)
                                        <tr>
                                            <td>6.1 Partner/Managing Director/Share Holder’s Name: {{$company_owner->name ?? ''}}<br>
                                                6.2 NID No: {{$company_owner->nid_no ?? ''}}<br>
                                                6.2 Attach NID: {{$company_owner->attach_nid ?? ''}}<br>
                                                6.3 Educational
                                                qualification: {{$company_owner->educational_qualification ?? ''}}<br>
                                                6.3 Attach Educational
                                                qualification: {{$company_owner->attach_educational_qualification ?? ''}}
                                                <br>
                                                6.4 Photograph: {{$company_owner->attach_photograph ?? ''}}<br>
                                                6.5 Mobile No: {{$company_owner->mobile_no ?? ''}}<br>
                                                6.6 Email: {{$company_owner->email ?? ''}}<br>
                                                6.7 Nationality ID:{{$company_owner->nationality_id ?? ''}}<br>
                                                6.7 Signature.{{$company_owner->attach_signature ?? ''}}<br>
                                                6.7 Experience
                                                Certificate.{{$company_owner->attach_experience_certificate ?? ''}}<br>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </table>
                        </div>
                        <p class="p4">07. Addresses:</p>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <!-- <tr>
                                    <th colspan="3">07. Addresses:</th>
                                </tr> -->
                                <tr>
                                    <th>Register Address</th>
                                    <th>Current Address</th>
                                    <th>Branch Office Address</th>
                                </tr>
                                <tr>
                                    <td>Address:</td>
                                    <td>Address:</td>
                                    <td>Address:</td>
                                </tr>
                                <tr>
                                    <td>Telephone No:</td>
                                    <td>Telephone No:</td>
                                    <td>Telephone No:</td>
                                </tr>
                                <tr>
                                    <td>Mobile No:</td>
                                    <td>Mobile No:</td>
                                    <td>Mobile No:</td>
                                </tr>
                                <tr>
                                    <td>Fax No:</td>
                                    <td>Fax No:</td>
                                    <td>Fax No:</td>
                                </tr>
                                <tr>
                                    <td>E-mail:</td>
                                    <td>E-mail:</td>
                                    <td>E-mail:</td>
                                </tr>
                            </table>
                        </div>
                        <p class="p4">
                            08. Documents:
                        </p>
                        <p class="p5">8.1 Trade License</p>
                        <table class="table">
                            <thead>

                            </thead>
                            <tbody>
                            <tr>
                                <td>No.</td>
                                <td>Validity</td>
                                <td>Attachment</td>
                            </tr>

                            </tbody>
                        </table>
                        <p class="p5">8.2 Freight Forwarders License No.</p>
                        <table class="table">
                            <thead>

                            </thead>
                            <tbody>
                            <tr>
                                <td>No.</td>
                                <td>Validity</td>
                                <td>Attachment</td>
                            </tr>

                            </tbody>
                        </table>
                        <p class="p5">8.3 e-TIN No</p>
                        <table class="table">
                            <thead>

                            </thead>
                            <tbody>
                            <tr>
                                <td>No.</td>
                                <td>Attachment</td>
                            </tr>

                            </tbody>
                        </table>
                        <p class="p5">8.4 VAT Registration Certificate</p>
                        <table class="table">
                            <thead>

                            </thead>
                            <tbody>
                            <tr>
                                <td>No.</td>
                                <td>Attachment</td>
                            </tr>

                            </tbody>
                        </table>
                        <p class="p5">8.5 Affidavit/Partnership Deed/Memorandum of Article:</p>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>

                                </thead>
                                <tbody>
                                <tr>
                                    <th>Proprietorship</th>
                                    <th>Partnership</th>
                                    <th>Limited</th>
                                </tr>
                                <tr>
                                    <td>Affidavit</td>
                                    <td>Partnership Deed</td>
                                    <td>Memorandum of Article</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <p class="p5">8.6 Other Documents</p>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead></thead>
                                <tbody>
                                <tr>
                                    <td>Attachment</td>
                                    <td>Attachment</td>
                                    <td>Attachment</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <p class="p4">9. Membership Renewal: </p>
                        <p class="p5">9.1 Information:</p>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>

                                </thead>
                                <tbody>
                                <tr>
                                    <td>Year</td>
                                    <td>Renewal Status</td>
                                    <td>Download digital certificate</td>
                                    <td>Payment status</td>
                                </tr>
                                </tbody>


                            </table>
                        </div>
                        <p class="p5">9.2 Application for Membership renewal</p>
                        <p class="p4">10. ID card Information: </p>
                        <p class="p4">10.1 Total________ ID card received from BAFFA in 2021</p>
                        <p>Details</p>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead></thead>
                                <tbody>
                                <tr>
                                    <th>Sl. No.</th>
                                    <th>BAFFA 2021<br>ID Card No.</th>
                                    <th>Last year 2020<br> ID Card No.</th>
                                    <th>Proximity<br> ID No.</th>
                                    <th>Card Holder's<br> Name</th>
                                    <th>Designation</th>
                                    <th>Passport/NID No./<br> Birth Certificate<br> No.</th>
                                </tr>
                                <tr>
                                    <td><br></td>
                                    <td><br></td>
                                    <td><br></td>
                                    <td><br></td>
                                    <td><br></td>
                                    <td><br></td>
                                    <td><br></td>
                                </tr>
                                </tbody>


                            </table>
                        </div>
                        <p class="p5">10.2 Application for new ID card</p>
                        <p class="p4">11. Arbitration History: </p>
                        <p class="p5">11.1 Complain against</p>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>

                                </thead>
                                <tbody>
                                <tr>
                                    <td>Complaining company</td>
                                    <td>Arbitration file date</td>
                                    <td>Arbitration status</td>
                                    <td>Etc.</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <p class="p5">11.2 Complain from</p>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>

                                </thead>
                                <tbody>
                                <tr>
                                    <td>Complain By</td>
                                    <td>Arbitration file date</td>
                                    <td>Arbitration status</td>
                                    <td>Etc.</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <p class="p4">12. Gate Pass: </p>
                        <ul>
                            <li>12.1 Gate Pass form entry</li>
                            <li>12.2 Pay to BAFFA Airport office</li>
                            <li>12.3 Take printout from Airport office after complete payment process.</li>
                        </ul>
                        <p class="p4">14. Shade rent </p>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>

                                </thead>
                                <tbody>
                                <tr>
                                    <th>Year</th>
                                    <th>Month</th>
                                    <th>Amount</th>
                                    <th>Payment Status</th>
                                    <th>Dues</th>
                                    <th>Remarks</th>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <p class="p4">13. Message Box: </p>
                        <p class="p4">14. Others: </p>
                        <p>Request for below items purchase or complimentary copy. </p>
                        <ul>
                            <li>1. Safety Vest</li>
                            <li>2. HBL Sticker</li>
                            <li>3. Directory</li>
                            <li>4. Vehicle Stickier</li>
                            <li>5. Article of Association (BAFFA)</li>
                            <li>6. Etc.</li>
                        </ul>
                        <h4 class="text-center">BAFFA Official’s Dashboard</h4>
                        <h5>For BAFFA Secretariat officials:</h5>
                        <p>Member’s information:</p>
                        <ul>
                            <li>1. All BAFFA members’ information, search
                                by company name or membership no.
                            </li>
                            <li>2. Different department personnel will have his/her own department related data on their
                                dashboard.
                            </li>
                            <li>3. Report generate</li>
                        </ul>
                        <h5>For BAFFA Airport officials:</h5>
                        <ul>
                            <li>1. Can see member’s limited information.</li>
                            <li>2. Gate pass printing option</li>
                            <li>3. Shade rent status</li>
                        </ul>
                        <p>ID card process: </p>
                        <ul>
                            <li>1. Collect ID card for and required documents with declaration form member organization
                            </li>
                            <li>2. Scrutiny the document</li>
                            <li>3. If there have any shortage, we provide checklist.</li>
                            <li>4. If got all documents OK, then submit summary to management for approval.</li>
                            <li>5. After getting approval we provide documents to vendor for print ID cards.</li>

                        </ul>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        @media print {
            #edit, #edit * {
                visibility: hidden;
            }
        }
    </style>

@stop

@section('scripts')
    {!! HTML::script('assets/js/as/btn.js') !!}
    {!! HTML::script('assets/js/as/profile.js') !!}
    {!! JsValidator::formRequest('Vanguard\Http\Requests\User\UpdateDetailsRequest', '#details-form') !!}
    {!! JsValidator::formRequest('Vanguard\Http\Requests\User\UpdateProfileLoginDetailsRequest', '#login-details-form') !!}

    @if (setting('2fa.enabled'))
        {!! JsValidator::formRequest('Vanguard\Http\Requests\TwoFactor\EnableTwoFactorRequest', '#two-factor-form') !!}
    @endif
@stop
