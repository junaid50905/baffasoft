@extends('layouts.front')

@section('page-title', trans('Member Dashboard'))

@section('content')
{!! HTML::style('front/assets/css/dashboard-style.css') !!}

<div class="row">

    <div class="col-sm-12 dash">
        <h4>BAFFA Member’s Dashboard</h4>
        <p class="text-center p1">Notification for recent activities</p>
        <div class="box1">
            <p>Activity Status</p>
            @if ($member['status'] === 'Active')
                <p class="p2">Active</p>
                <p class="p2">GatePass Balance: {{$member['gatepass_balance'] ?? ''}}/=</p>
            @else
                <p class="p3">Inactive</p>
            @endif
        </div>
        <h5>GatePass Balance: <span style="color: red">{{$member['gatepass_balance'] ?? ''}}/=</span></h5>
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
                    <p class="ms-4">(a): <i class="far fa-check-square"></i> Proprietorship <i class="far fa-square"></i> Partnership <i class="far fa-square"></i> Limited<br>
                        (b): <i class="far fa-check-square"></i> Local <i class="far fa-square"></i> Joint Venture <i class="far fa-square"></i> 00% Foreign</p>
                </div>


            </div>
        </div>
        <p class="p4">06. Company Owner(s) information:</p>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th>Proprietorship</th>
                    <th>Partnership</th>
                    <th>Limited</th>
                </tr>
                <tr>
                    <td rowspan="3">6.1 Proprietor’s Name: {{$company_owners[0]->name ?? ''}}<br>
                        6.2 NID No: {{$company_owners[0]->nid_no ?? ''}}<br>
                        6.2 Attach NID: {{$company_owners[0]->attach_nid ?? ''}}<br>
                        6.3 Educational qualification: {{$company_owners[0]->educational_qualification ?? ''}}<br>
                        6.3 Attach Educational qualification: {{$company_owners[0]->attach_educational_qualification ?? ''}}<br>
                        6.4 Photograph: {{$company_owners[0]->attach_photograph ?? ''}}<br>
                        6.5 Mobile No: {{$company_owners[0]->mobile_no ?? ''}}<br>
                        6.6 Email: {{$company_owners[0]->email ?? ''}}<br>
                        6.7 Nationality ID:{{$company_owners[0]->nationality_id ?? ''}}<br>
                        6.7 Signature.{{$company_owners[0]->attach_signature ?? ''}}<br>
                        6.7 Experience Certificate.{{$company_owners[0]->attach_experience_certificate ?? ''}}<br>
                    </td>
                    <td>
                        6.1 Managing Partner’s Name<br>
                        6.2 NID No<br>
                        6.3 Educational qualification<br>
                        6.4 Photograph<br>
                        6.5 Mobile No.<br>
                        6.6 Email<br>
                        6.7 Etc.<br>

                    </td>
                    <td>
                        6.1 Chairman’s Name<br>
                        6.2 NID No<br>
                        6.3 Educational qualification<br>
                        6.4 Photograph<br>
                        6.5 Mobile No.<br>
                        6.6 Email<br>
                        6.7 Etc.<br>

                    </td>
                </tr>
                <tr>
                    <td rowspan="2">
                        6.1 Partner’s Name<br>
                        6.2 NID No<br>
                        6.3 Educational qualification<br>
                        6.4 Photograph<br>
                        6.5 Mobile No.<br>
                        6.6 Email<br>
                        6.7 Etc.<br>

                    </td>
                    <td>
                        6.1 Managing Director’s Name<br>
                        6.2 NID No<br>
                        6.3 Educational qualification<br>
                        6.4 Photograph<br>
                        6.5 Mobile No.<br>
                        6.6 Email<br>
                        6.7 Etc.<br>

                    </td>
                </tr>
                <tr>
                    <td>
                        6.1 Director/Share Holder’s Name<br>
                        6.2 NID No<br>
                        6.3 Educational qualification<br>
                        6.4 Photograph<br>
                        6.5 Mobile No.<br>
                        6.6 Email<br>
                        6.7 Etc.<br>

                    </td>
                </tr>
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
                        <td>Arbitration status </td>
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
                        <td>Arbitration status </td>
                        <td>Etc.</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p class="p4">12. Gate Pass: </p>
        <ul>
            <li>12.1 Gate Pass form entry </li>
            <li>12.2 Pay to BAFFA Airport office </li>
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
                by company name or membership no. </li>
            <li>2. Different department personnel will have his/her own department related data on their dashboard.</li>
            <li>3. Report generate </li>
        </ul>
        <h5>For BAFFA Airport officials:</h5>
        <ul>
            <li>1. Can see member’s limited information.</li>
            <li>2. Gate pass printing option</li>
            <li>3. Shade rent status </li>
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

<!-- <div class="row mt-4">
        <div class="col-lg-5 mb-lg-0 mb-4">
            <div class="card z-index-2">
                <div class="card-body p-3">
                    <h6 class="ms-2 mt-4 mb-0"> User Login Information </h6>
                    <br>
                    <div class="container border-radius-lg">
                        <div class="row">
                            <table class="table table-dark">
                                <tbody>
                                <tr>
                                    <th scope="row">ID</th>
                                    <td>{{$member['id'] ?? ''}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">User Name</th>
                                    <td>{{$member['id'] ?? ''}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">E-mail</th>
                                    <td>{{$member['email'] ?? ''}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card z-index-2">
                <div class="card-header pb-0">
                    <h6>User Details</h6>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <table class="table table-light">
                            <tbody>
                            <tr>
                                <th scope="row">Form Submit Date</th>
                                <td>{{$member_details['form_submit_date'] ?? ''}}</td>
                            </tr>
                            <tr>
                                <th scope="row">firm_name</th>
                                <td>{{$member_details['firm_name'] ?? ''}}</td>
                            </tr>
                            <tr>
                                <th scope="row">place_of_enlistment</th>
                                <td>{{$member_details['place_of_enlistment'] ?? ''}}</td>
                            </tr>
                            <tr>
                                <th scope="row">particulars_of_certificate_number</th>
                                <td>{{$member_details['particulars_of_certificate_number'] ?? ''}}</td>
                            </tr>
                            <tr>
                                <th scope="row">particulars_of_certificate_date</th>
                                <td>{{$member_details['particulars_of_certificate_date'] ?? ''}}</td>
                            </tr>

                            <tr>
                                <th scope="row">attach_nid</th>
                                <td><img src="{{$member_details['attach_nid'] ?? ''}}" alt="No Image" width="100" height="100"></td>
                            </tr>
                            <tr>
                                <th scope="row">attach_no_of_appointed_staff</th>
                                <td><img src="{{$member_details['attach_no_of_appointed_staff'] ?? ''}}" alt="No Image" width="100" height="100"></td>
                            </tr>
                            <tr>
                                <th scope="row">attach_id_card_or_passport</th>
                                <td><img src="{{$member_details['attach_id_card_or_passport'] ?? ''}}" alt="Image" width="100" height="100"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

@stop
