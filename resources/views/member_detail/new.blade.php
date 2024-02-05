@extends('layouts.front_login')

@section('page-title', trans('Register'))

@section('content')

    <nav
        class="navbar navbar-expand-lg position-absolute top-0 z-index-3 w-100 shadow-none my-3  navbar-transparent mt-4">
        <div class="container">
            <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 text-white" href="../pages/dashboards/default.html">
                <img src="{{ url('front/assets/img/logo.png') }}" alt="{{ setting('app_name') }}" height="50">
            </a>
            <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false"
                    aria-label="Toggle navigation">
        <span class="navbar-toggler-icon mt-2">
          <span class="navbar-toggler-bar bar1"></span>
          <span class="navbar-toggler-bar bar2"></span>
          <span class="navbar-toggler-bar bar3"></span>
        </span>
            </button>
            <div class="collapse navbar-collapse w-100 pt-3 pb-2 py-lg-0" id="navigation">
                <ul class="navbar-nav navbar-nav-hover mx-auto">
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link me-2" href="{{ url('register') }}">
                            <i class="fas fa-user-circle opacity-6 text-dark me-1"></i>
                            Sign Up
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-2" href="{{ url('login') }}">
                            <i class="fas fa-key opacity-6 text-dark me-1"></i>
                            Sign In
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
    <section class="min-vh-100 mb-8">
        <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg"
             style="background-image: url('{{ url('front/assets/img/curved-images/curved14.jpg') }}');">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 text-center mx-auto">
                        <h1 class="text-white mb-2 mt-5">Welcome!</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">


            <div class="row mt-lg-n10 mt-md-n11 mt-n10">
                <div class="col-xl-auto col-lg-auto col-md-auto mx-auto">
                    <div class="card z-index-0">
                        <div class="card-header text-center pt-4">
                            <h5>MEMBERSHIP APPLICATION FORM</h5>
                        </div>
                        <div class="card-body">
                            @include('partials.messages')
{{--                            @if(session()->has('message'))--}}
{{--                                <div class="alert alert-seccess">--}}
{{--                                    {{session('message')}}--}}
{{--                                </div>--}}
{{--                            @endif--}}
                            {{Form::open(['route'=>'member-details.store','class'=>'contact-form form-horizontal','method'=>'POST','name'=>'newMember','files' => true])}}
                            <input type="hidden" name="email" value={{$member_data['email']}}>
                            <input type="hidden" name="username" value={{$member_data['username']}}>
                            <input type="hidden" name="password" value={{$member_data['password']}}>
                            {{--                                <input type="hidden" name="updated_at" value="{{}}">--}}
                            {{--                            <form role="form text-left">--}}
                            <div class="table-responsive-xl">
                                <table
                                    class="table caption-top align-middle table-sm table-bordered border-secondary">
                                    <caption>
                                        <div class="form-group">
                                            <div>
                                                <div class="row">
                                                    <div class="col-1 text-center pt-2"><span>Date: </span></div>
                                                    <div class="col-4"><input type="date" name="form_submit_date" id="submitDate"
                                                                                 class="form-control"></div>
                                                </div>


                                            </div>
                                        </div>
                                    </caption>
                                    {{--                                        <caption>(Please put “” tick mark where necessary)</caption>--}}
                                    <tbody>
                                    <tr>
                                        <th width="2%" scope="row">1.0</th>
                                        <td width="50%" colspan="3">Name of the Firm (In Block Letters):</td>
                                        <td width="40%">
                                            <input type="text"
                                                   class="form-control @error('firm_name') is-invalid @enderror"
                                                   name="firm_name" value="{{old('firm_name')}}"
                                                   autocomplete="firm_name" autofocus>
                                            @error('firm_name') {{--@if($error->has('firm_name'))--}}
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{$message}}</strong>{{-- @error->first('firm_name') --}}
                                                </span>
                                            @enderror
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2.0</th>
                                        <td colspan="3">Place of Enlistment/Registration:</td>
                                        <td><input type="text" class="form-control" name="place_of_enlistment"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row" rowspan="2">3.0</th>
                                        <td rowspan="2" colspan="2">Type of the Firm</td>
                                        <td>(a)</td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                       name="firm_type_a" id="inlineRadio1" value="Proprietorship">
                                                <label class="form-check-label"
                                                       for="inlineRadio1">Proprietorship</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                       name="firm_type_a" id="inlineRadio2" value="Partnership">
                                                <label class="form-check-label"
                                                       for="inlineRadio2">Partnership</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                       name="firm_type_a" id="inlineRadio3" value="Limited Company">
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
                                                       name="firm_type_b" id="inlineRadio4" value="Local">
                                                <label class="form-check-label" for="inlineRadio4">Local</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                       name="firm_type_b" id="inlineRadio5" value="Joint Venture">
                                                <label class="form-check-label" for="inlineRadio5">Joint
                                                    Venture</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                       name="firm_type_b" id="inlineRadio6" value="100% Foreign">
                                                <label class="form-check-label" for="inlineRadio6">100%
                                                    Foreign</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">4.0</th>
                                        <td colspan="3">Particulars of Certificate of Registration/Incorporation <br>
                                            (Number and Date):
                                        </td>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Number"
                                                       aria-label="Username" name="particulars_of_certificate_number">
                                                <span class="input-group-text">|</span>
                                                <input type="date" class="form-control"
                                                       name="particulars_of_certificate_date">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">5.0</th>
                                        <td colspan="3">Date of Establishment of the Firm:</td>
                                        <td><input type="date" class="form-control"
                                                   placeholder="Date of Establishment" name="date_of_establishment">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">6.0</th>
                                        <td colspan="3">Trade License Number and Date with Validity:</td>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control"
                                                       placeholder="Trade License Number" name="trade_license_number">
                                                <span class="input-group-text">|</span>
                                                <input type="date" class="form-control" name="trade_license_date">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">7.0</th>
                                        <td colspan="3">12-digit TIN Number:</td>
                                        <td><input type="number" class="form-control"
                                                   placeholder="EX: XXXXXXXXXXXX" name="tin_number"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">8.0</th>
                                        <td colspan="3">VAT Registration Number:</td>
                                        <td><input type="number" class="form-control"
                                                   placeholder="EX: XXXXXXXXXXXX" name="vat_registration_number"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">9.0</th>
                                        <td colspan="3">Name and Address of Banker:</td>
                                        <td>
                                                <textarea class="form-control" id="exampleFormControlTextarea1"
                                                          rows="3" name="name_and_address_of_banker"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">10.0</th>
                                        <td colspan="3">Membership of Other Trade Organization(s), if any:</td>
                                        <td><input type="text" class="form-control" placeholder="Membership"
                                                   name="membership_of_other_trade_organization"></td>
                                    </tr>
                                    <tr class="company_owner_before">
                                        <th scope="row">11.0</th>
                                        <td colspan="3">Name of Authorized Person (Director/Partner in block
                                            letters):
                                        </td>
                                        <td><input type="text" class="form-control" name="name_of_authorized_person">
                                            <input type="button" value="Click" id="addcolumn" >
                                        </td>
                                    </tr>
                                    @php($owner_id = 1)
{{--                                    @foreach([1,2] as $owner_id)--}}
                                    <tr class="company_owner_this">
                                        <th scope="row" rowspan="9">12.0</th>
                                        <td rowspan="9">Company Owners Information<br>(Directors/Partners/Proprietor):</td>
                                        <td>(a)</td>
                                        <td>Name:</td>
                                        <td><input type="text" class="form-control" placeholder="Address"
                                                   name="company_owner[{{$owner_id}}][name]"></td>
                                    </tr>
                                    <tr>
                                        <td>(b)</td>
                                        <td>NID No:</td>
                                        <td><input type="text" class="form-control" placeholder="Total Floor Area"
                                                   name="company_owner[{{$owner_id}}][nid_no]">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>(c)</td>
                                        <td> Attach NID:</td>
                                        <td><input type="file" class="form-control" name="company_owner[{{$owner_id}}][attach_nid]">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>(d)</td>
                                        <td>Educational Qualification:</td>
                                        <td><input type="text" class="form-control" placeholder="Total Floor Area"
                                                   name="company_owner[{{$owner_id}}][educational_qualification]">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>(e)</td>
                                        <td>Photograph:</td>
                                        <td><input type="file" class="form-control"
                                                   name="company_owner[{{$owner_id}}][photograph]">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>(f)</td>
                                        <td>Mobile No:</td>
                                        <td><input type="text" class="form-control" placeholder="Mobile No."
                                                   name="company_owner[{{$owner_id}}][mobile_no]">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>(g)</td>
                                        <td>Email:</td>
                                        <td><input type="text" class="form-control" placeholder="E-mail Address"
                                                   name="company_owner[{{$owner_id}}][email]" value="{{old("company_owner.$owner_id.email")}}" autocomplete="company_owner.{{$owner_id}}.email">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>(h)</td>
                                        <td>nationality:</td>
                                        <td>
                                            <select name="company_owner[{{$owner_id}}][nationality_id]" class="form-select" aria-label="Default select example">
                                                @foreach($countries as $country)
                                                    <option value="{{$country->id}}"
                                                        {{$country->id == '50' ? 'selected' : ''}}>
                                                        {{$country->name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>(i)</td>
                                        <td>Specific Signature:</td>
                                        <td><input type="file" class="form-control"
                                                   name="company_owner[{{$owner_id}}][attach_signature]">
                                        </td>
                                    </tr>
{{--                                    @endforeach--}}
                                    <tr>
                                        <th scope="row">13.0</th>
                                        <td colspan="3">No. of Appointed Staffs: (Attach Details)</td>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control"
                                                       placeholder="No. of Appointed Staffs"
                                                       name="no_of_appointed_staff">
                                                <span class="input-group-text">|</span>
                                                <input type="file" class="form-control"
                                                       placeholder="Attach Details" name="attach_no_of_appointed_staff">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" rowspan="6">14.0</th>
                                        <td rowspan="6">Head Office:</td>
                                        <td>(a)</td>
                                        <td>Address:</td>
                                        <td><input type="text" class="form-control" placeholder="Address"
                                                   name="head_office_address"></td>
                                    </tr>
                                    <tr>
                                        <td>(b)</td>
                                        <td>Total Floor Area:</td>
                                        <td><input type="text" class="form-control" placeholder="Total Floor Area"
                                                   name="head_office_floor_area">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>(c)</td>
                                        <td>Telephone No:</td>
                                        <td><input type="text" class="form-control" placeholder="Telephone No"
                                                   name="head_office_telephone_no"></td>
                                    </tr>
                                    <tr>
                                        <td>(d)</td>
                                        <td>Fax No:</td>
                                        <td><input type="text" class="form-control" placeholder="Fax no"
                                                   name="head_office_fax_no"></td>
                                    </tr>
                                    <tr>
                                        <td>(e)</td>
                                        <td>Mobile No:</td>
                                        <td><input type="text" class="form-control" placeholder="Mobile No"
                                                   name="head_office_mobile_no"></td>
                                    </tr>
                                    <tr>
                                        <td>(f)</td>
                                        <td>E-mail Address:</td>
                                        <td><input type="text" class="form-control" placeholder="E-mail Address"
                                                   name="head_office_email_address">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" rowspan="5">15.0</th>
                                        <td rowspan="5">Branch Office, if any:</td>
                                        <td>(a)</td>
                                        <td>Address:</td>
                                        <td><input type="text" class="form-control" placeholder="Address"
                                                   name="branch_office_address"></td>
                                    </tr>
                                    <tr>
                                        <td>(b)</td>
                                        <td>Total Floor Area:</td>
                                        <td><input type="text" class="form-control" placeholder="Total Floor Area"
                                                   name="branch_office_floor_area">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>(c)</td>
                                        <td>Telephone No:</td>
                                        <td><input type="text" class="form-control" placeholder="Telephone No"
                                                   name="branch_office_telephone_no"></td>
                                    </tr>
                                    <tr>
                                        <td>(e)</td>
                                        <td>Mobile No :</td>
                                        <td><input type="text" class="form-control" placeholder="Mobile No"
                                                   name="branch_office_mobile_no"></td>
                                    </tr>
                                    <tr>
                                        <td>(f)</td>
                                        <td>E-mail Address:</td>
                                        <td><input type="text" class="form-control" placeholder="E-mail Address"
                                                   name="branch_office_email_address">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" rowspan="2">16.0</th>
                                        <td rowspan="2">Warehouse, if any</td>
                                        <td>(a)</td>
                                        <td>Address:</td>
                                        <td><input type="text" class="form-control" placeholder="Address"
                                                   name="warehouse_office_address"></td>
                                    </tr>
                                    <tr>
                                        <td>(b)</td>
                                        <td>Total Floor Area:</td>
                                        <td><input type="text" class="form-control" placeholder="Total Floor Area"
                                                   name="warehouse_office_floor_area">
                                        </td>
                                    </tr>
                                    <tr>
                                    <tr>
                                        <th scope="row">17.0</th>
                                        <td colspan="3"><b>PROPOSED BY</b></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">17.1</th>
                                        <td colspan="3">Name of the Proposing BAFFA Member Company:</td>
                                        <td><input type="text" class="form-control" name="proposed_by_company"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">17.2</th>
                                        <td colspan="3">Name in full and designation of the Proposer:</td>
                                        <td><input type="text" class="form-control"
                                                   name="proposed_by_name_and_designation"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">17.3</th>
                                        <td colspan="3">BAFFA Membership No.:</td>
                                        <td><input type="text" class="form-control" name="proposed_by_membership_no">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">17.4</th>
                                        <td colspan="3">Forwarding License No.:</td>
                                        <td><input type="text" class="form-control"
                                                   name="proposed_by_forwarding_license_no"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">17.5</th>
                                        <td colspan="3">Signature of the Seconder:</td>
                                        <td><input type="file" class="form-control"
                                                   name="attach_proposed_by_signature_of_seconder"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">17.6</th>
                                        <td colspan="3">Date & Place:</td>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input type="date" class="form-control" placeholder="Date"
                                                       name="proposed_by_date">
                                                <span class="input-group-text">|</span>
                                                <input type="text" class="form-control" placeholder="Place"
                                                       name="proposed_by_place">
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
                                        <td><input type="text" class="form-control" name="seconded_by_company"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">18.2</th>
                                        <td colspan="3">Name in full & designation of the Seconder:</td>
                                        <td><input type="text" class="form-control"
                                                   name="seconded_by_name_and_designation"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">18.3</th>
                                        <td colspan="3">BAFFA Membership No.:</td>
                                        <td><input type="text" class="form-control" name="seconded_by_membership_no">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">18.4</th>
                                        <td colspan="3">Forwarding License No.:</td>
                                        <td><input type="text" class="form-control"
                                                   name="seconded_by_forwarding_license_no"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">18.5</th>
                                        <td colspan="3">Signature of the Seconder:</td>
                                        <td><input type="file" class="form-control" name="attach_seconded_by_signature">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">18.6</th>
                                        <td colspan="3">Date & Place:</td>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input type="date" class="form-control" placeholder="Date"
                                                       name="seconded_by_date">
                                                <span class="input-group-text">|</span>
                                                <input type="text" class="form-control" placeholder="Place"
                                                       name="seconded_by_place">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">19.0</th>
                                        <td colspan="3"><b>Attested:</b></td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">19.1</th>
                                        <td colspan="3">Attested copy of valid and up-to-date Trade License:</td>
                                        <td><input type="file" class="form-control" placeholder="Place"
                                                   name="attach_trade_license"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">19.2</th>
                                        <td colspan="3">Attested copy of valid e-TIN Certificate and <br>Income Tax
                                            Clearance Certificate:
                                        </td>
                                        <td><input type="file" class="form-control" placeholder="Place"
                                                   name="attach_e_tin_certificate"></td>
                                    </tr>
                                    {{--                                        <tr>--}}
                                    {{--                                            <th scope="row">19.3</th>--}}
                                    {{--                                            <td colspan="3">Attested copy of Office Tenancy Agreement or Land Ownership--}}
                                    {{--                                                document:--}}
                                    {{--                                            </td>--}}
                                    {{--                                            <td><input type="file" class="form-control" placeholder="Place"></td>--}}
                                    {{--                                        </tr>--}}
                                    <tr>
                                        <th scope="row">19.3</th>
                                        <td colspan="3">Attested copy of valid Bank Solvency Certificate:</td>
                                        <td><input type="file" class="form-control" placeholder="Place"
                                                   name="attach_bank_solvency_certificate"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">19.4</th>
                                        <td colspan="3">VAT Registration Certificate (13 digits):</td>
                                        <td><input type="file" class="form-control" placeholder="Place"
                                                   name="attach_vat_registration_certificate"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">19.5</th>
                                        <td colspan="3">Two (2) Copies of passport size photographs of each
                                            applicant and <br>all other Proprietor/Partners/ Directors along <br>with
                                            present and permanent addresses of each.
                                        </td>
                                        <td><input type="file" class="form-control" placeholder="Place"
                                                   name="attach_photograph"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">19.6</th>
                                        <td colspan="3">Copies of National ID Card or valid Passport of <br>
                                            Proprietor/Partners/ Directors.
                                        </td>
                                        <td><input type="file" class="form-control" placeholder="Place"
                                                   name="attach_id_card_or_passport"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            <div class="d-grid gap-2 col-6 mx-auto pt-3" style="position: relative">
                                                <button type="submit" class="btn btn-secondary">
                                                    <span>Create Member</span>
                                                    <div class="loader" ></div>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            {{Form::close()}}
                        </div>
                    </div>
                    <table>
                        <tr class="dd_b">
                            <td>aa</td>
                            <td>bb</td>
                            <td>cc</td>
                        </tr>
                        <tr class="dd_tr">
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
    <footer class="footer py-2">
        <div class="container">
            <div class="row">
                <div class="col-8 mx-auto text-center mt-1">
                    <p class="mb-0 text-secondary small">
                        Copyright ©
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                        BAFFA, developed by <a href="http://www.aamrainfotainment.com" class="font-weight-bold"
                                               target="_blank"><img src="{{ url('front/assets/img/aamra.png') }}">
                            infotainment ltd.</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <style>
        .loader{  /* Loader Div Class */
            position: absolute;
            top:0px;
            right:0px;
            width:100%;
            height:100%;
            background-color:#eceaea;
            /*background-image: url(http://localhost/baffasoft/front/assets/img/curved-images/curved14.jpg);*/
{{--            background-image: url('{{ url('front/assets/img/curved-images/curved14.jpg') }}');--}}
            background-image: url('{{ url('assets/img/ajax-loader.gif') }}');
            background-size: 50px;
            background-repeat:no-repeat;
            background-position:center;
            z-index:10000000;
            opacity: 0.4;
            filter: alpha(opacity=40);
        }
    </style>

@stop
@section('scripts')
    <script !src="">
        $('#addcolumn').click(function (){
            console.log('hhhh')
            console.log('Yes Here I am ...')
            var company_owner_before  = $('.company_owner_before'),
                parentTR = $('.company_owner_this');
            parentTR.clone().insertAfter(company_owner_before)
        })
        $(document).ready(function (){
            function addColumn(){
                console.log('Click')
            }
            var count = 2
            function dynamic_field(number){
                var html = '<tr>';
                html += '<td>ppp</td>';
                html += '</tr>';
            }
            // if (count > 1){
            //     console.log('Yes Here I am ...')
            //     var company_owner_before  = $('.company_owner_before'),
            //         parentTR = $('.company_owner_this');
            //     parentTR.clone().insertAfter(company_owner_before)
            // }
            if (count > 1){
                console.log('Yes Here I am ...')
                var company_owner_before  = $('.dd_b'),
                    parentTR = $('.dd_tr');
                parentTR.clone().insertAfter(company_owner_before)
            }

        });
    </script>
{{--    {!! JsValidator::formRequest('Vanguard\Http\Requests\Member\MemberDetailRequest', '#registration-form') !!}--}}
@stop


