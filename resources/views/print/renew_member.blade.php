<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Renew Member Profile</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }


        body {
            font-family: sans-serif;
            padding: 30px 30px 0px 30px;
        }


        /* mahbub */

        .title img {
            width: 514px;
            margin-left: 16px;
            margin-right: 20px;
            margin-top: 35px;
        }

        .photo_sec img {
            width: 100px;
            border: 1px solid #ccc;
            margin-top: -24px;
        }

        #idOne p {
            font-family: cali-bold;
            font-weight: bold;
            font-size: 18px;
            color: black;
            /* margin-top: 8%; */
            text-decoration: underline;
            text-align: center;
            padding: 0 0 15px 0;
        }


        .data_set p {
            border-bottom: 2px dotted #9d9d9d;
            margin-left: 0px;
            padding: 0px;
            margin-bottom: 0;
            height: 18px;
        }

        .data_set {
            width: 100%;
            color: #000;
            font-size: 13px;
        }

        .data_set td {
            height: 35px;
            width: 100%;
        }

        .data_set td:nth-child(1) {
            font-weight: bold;
            width: 250px;
        }

        .data_set td:nth-child(2) {
            width: 5px;
        }


        .res_tabel-siz {
            margin-top: -34px;
            width: 100%;
            padding: 0;
        }

        .photo_sec {
            text-align: center;
        }

        .attast_but {
            border: 1px solid #000;
            padding: 4px;
            font-size: 11px;
            font-weight: bold;
            border-radius: 6px;
        }

        .sing_tex p {
            padding: 0;
            margin: 0;
            font-size: 12px;
        }

        .sing_tex img {
            text-align: center;
            width: 150px;
            height: 80px;
            margin-left: 20px;
        }

        .date_left {
            text-align: center;
            color: #727272;
            font-size: 14px;
            font-weight: bold;
        }

        .location1 {
            font-size: 10px;
            position: absolute;
            bottom: 20px;
            display: block;

        }

        .bg-a {
            font-size: 12px;
            display: inline;
            border: 1px solid #FF698D;
            background-color: #FF698D;
            color: #fff;
        }


    </style>

</head>

<body>

<div class="row">
    <div class="col-12">
        <table style="margin-bottom:20px;">
            <tr>
                <td style="width: 150px;"><img style="width: 120px;"
                                               src="{{ baffasoft_url("/front/assets/img/id_card/baffa-logo.png")}}"/>
                </td>
                <td style="text-align: right; width: 100%;">
                    <img style="width: 500px; padding-top: 38px;"
                         src="{{ baffasoft_url("/front/assets/img/id_card/id-title.png")}}"/>
                    <!--    </div>-->
                </td>
            </tr>
        </table>
        <table style="width: 100%;" class="">
            <tr>
                <td style="width: 150px; font-size: 13px; text-align:center; ">Date :
                    {{ $renew_member->date_of_renewal? $renew_member->date_of_renewal->format(config('app.bn_date_format')) : '' }}
                </td>
                <td style="text-align:center;" id="idOne">
                    @if($renew_member->structure_change)
                        <p>Membership Structure Change Form</p></td>
                    @else
                        <p>BAFFA MEMBERSHIP RENEWAL FORM - {{$renew_member->submission_year}}</p>
                    @endif
                <td class="photo_sec">
                    @if($contact_person)
                        <img src="{{ baffasoft_url($contact_person['attach_photograph']) }}"/>
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>


<div class="row" style="margin-top: 50px;">
    <div class="col-12-sm">
        <div class=" res_tabel-siz">
            <table class="data_set ">

                <tr>
                    <td>01. Name of Organization</td>
                    <td>:</td>
                    <td><p> {{ $renew_member->firm_name }} </p></td>
                </tr>
                <tr>
                    <td>02. Type of the Organization</td>
                    <td>:</td>
                    @php($firm_type = $renew_member->firm_type == 'Proprietor'
                            ? 'Proprietorship'
                            : ($renew_member->firm_type == 'Partners' ? 'Partnership' : 'Limited Company'))
                    <td><p> {{ $firm_type . ' - ' . $renew_member->type_local }} </p></td>
                </tr>
                <tr>
                    <td>03. Name of the Contact Person</td>
                    <td>:</td>
                    <td><p> {{ $contact_person ? $contact_person->name : ''}} </p></td>
                </tr>
                <tr>
                    <td>04. Designation of the Contact Person</td>
                    <td>:</td>
                    <td><p>{{$renew_member->contact_person_designation}}</p></td>
                </tr>

            </table>

            <table class="data_set">
                <tr>
                    <td>05. Membership Number</td>
                    <td>:</td>
                    <td style="width:200px;"><p> {{$renew_member->membership_number}}</p></td>
                    <td style="width:115px ;padding-left:5px; padding-right: 5px;">Date of Admission :</td>
                    <td style="width:auto;"><p>
                            {{ $renew_member->date_of_admission? $renew_member->date_of_admission->format(config('app.bn_date_format')) : '' }}
                        </p></td>
                </tr>
            </table>
            <table class="data_set ">
                <tr>
                    <td>06. Place of Enlistment</td>
                    <td>:</td>
                    <td><p> {{$renew_member->place_of_enlistment}} </p></td>
                </tr>

                <tr>
                    <td>07. Registered Address</td>
                    <td>:</td>
                    <td><p> {{$renew_member->registered_office? $renew_member->registered_office->address : ''}} </p></td>
                </tr>
                <tr>
                    <td>08. Current Address</td>
                    <td>:</td>
                    <td><p> {{$renew_member->current_office? $renew_member->current_office->address: ''}} </p></td>
                </tr>
                <tr>
                    <td>09. Branch Office Address</td>
                    <td>:</td>
                    <td><p> {{$renew_member->branch_office}} </p></td>
                </tr>
                <tr>
                    <td>10. Telephone No.</td>
                    <td>:</td>
                    <td><p> {{$renew_member->telephone_no}} </p></td>
                </tr>
            </table>
            <table class="data_set ">
                <tr>
                    <td>11. Mobile No.</td>
                    <td>:</td>
                    <td style="width:200px;"><p>{{$renew_member->mobile_no}} </p></td>
                    <td style="width:auto; text-align: center;"><b>Fax No</b> :</td>
                    <td style="width:auto;"><p> {{$renew_member->fax_no}}    </p></td>
                </tr>
                <tr>
                    <td>12. E-mail (for all communication)</td>
                    <td>:</td>
                    <td><p> {{$renew_member->email_address}}</p></td>
                    <td style="width:82px;padding-left: 10px;"><b>Website</b> :</td>
                    <td><p>  {{$renew_member->website}}   </p></td>
                </tr>
            </table>
            <table class="data_set ">
                <tr>
                    <td>13. Freight Forwarders License No</td>
                    <td>:</td>
                    <td style="width:200px;"><p> {{$renew_member->freight_forwarders_license_number}} </p></td>
                    <td style="width:110px; padding-left:2px;"><b>Date of Validity</b> :</td>
                    <td><p>
                            {{ $renew_member->freight_forwarders_license_date? $renew_member->freight_forwarders_license_date->format(config('app.bn_date_format')) : '' }}
                        </p></td>
                </tr>
            </table>
            <table class="data_set ">
                <tr>
                    <td>14.Trade License No</td>
                    <td>:</td>
                    <td style="width:200px;"><p> {{$renew_member->trade_license_number}} </p></td>
                    <td style="width:110px; padding-left:2px;"><b>Date of Validity</b> :</td>
                    <td><p>
                            {{ $renew_member->trade_license_date? $renew_member->trade_license_date->format(config('app.bn_date_format')) : '' }}
                        </p></td>
                </tr>
            </table>
            <table class="data_set ">
                <tr>
                    <td>15. e-TIN No</td>
                    <td>:</td>
                    <td width="50%"><p>  {{$renew_member->tin_number}}   </p></td>
                </tr>

            </table>
            <table class="data_set ">
                <tr>
                    <td>16. Any Change in Company Structure</td>
                    <td>:</td>
                    @php($image = $renew_member->any_change == 1 ? "check.png" : "un-check.png")
                    <td style="width: 30px;"><img style="width: 20px;"
                                                  src="{{ baffasoft_url("/front/assets/img/" . $image)}}"></td>
                    <td style="width: 70px;"> YES</td>
                    @php($image = $renew_member->any_change == 0 ? "check.png" : "un-check.png")
                    <td style="width: 30px;"><img style="width: 20px;"
                                                  src="{{ baffasoft_url("/front/assets/img/" . $image)}}"></td>
                    <td> NO</td>

                </tr>
            </table>

        </div>

    </div>
</div>

<div class="row">
    <div class="col-sm-4 sing_tex" style="margin-top: 20px;">
        @if($contact_person)
            <img src="{{ baffasoft_url($contact_person->attach_signature) }}"/>
        @endif
        <div class="sign-center" style="text-decoration: overline">
            Signature of the Contact Person
        </div>
        <p>Name : {{ $contact_person ? $contact_person->branch_office : '' }} </p>
        <p>Designation : {{ $contact_person ? $contact_person->branch_office : '' }}</p>
    </div>


    <div class="col-sm-12" style="margin-top: 30px;">


        <div class="location1">
            <p><span class="bg-a">Dhaka Office <i class="fas fa-map-marker-alt"></i></span> House No.
                10(Level-2 & 3),Road No.17A Block-E,Banani,Dhaka-1213,Tel.+88028836324-25,Fax:+88
                02222281664,Email:info@baffa-bd.org</p>
            <p><span class="bg-a">Chattagram Office <i class="fas fa-map-marker-alt"></i></span> Anwara
                Trade Center (Level-10),1728,Agrabad C/A Chattagroam, Tel: +8802
                333323453,333323505,Email:admin.ctg@baffa-bd.org</p>
        </div>

    </div>
</div>

</body>
</html>
