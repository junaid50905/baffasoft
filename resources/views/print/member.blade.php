<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Member Profile</title>
{{--    <meta name="csrf-token" content="{{ csrf_token() }}">--}}
{{--    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">--}}
{{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">--}}
{{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>--}}

    <style>
        *{
            padding:0;
            margin:0;
            box-sizing: border-box;
        }


        body{
            font-family: sans-serif;
            padding:150px 30px 50px 30px;
        }


        .main-tabile-st{
            width: 100%;
        }
        .act-inact {
            width: 200px;
            float: right;
        }
        .act-inact p{
            background:#ccc;
            width: 90px;
            font-size: 12px;
            float: left;
        }
        .act-inact h5{
            background:#ccc;
            width: 100px;
            font-size: 12px;
            float: left;
        }
        .boder-tab{
            border: 1px solid #959595;
            margin: 0 auto ;
            padding: 20px 15px;
            background: #cccccc30;
            border-radius: 10px;

        }

        .under-dot{
            max-width: 100%;
            padding-left: 10px;
            overflow-x: hidden;
            list-style: none

        }
        /* for page brack */

        .second-box{
            border: 1px solid #959595;
            margin: 20px auto 15px;
            padding: 20px 15px;
            background: #cccccc30;
            border-radius: 10px;

            font-size: 13px;
        }

        .al-right{
            text-align: right;
            padding-right:5px;
        }

        .al-left{
            padding-left: 10px;
        }

        .add-box{
            width: 99%;
            border: 1px solid #959595;
            float: left;
            font-size: 13px;
            height: 16em;
            font-family: sans-serif;
            margin: 5px;
            background: #cccccc30;
        }

        .add-box ul{
            line-height:17px;
            list-style-type: none;
            margin: 0;
            padding: 0;
            font-size: 14px;
            font-family: sans-serif;

        }

        .table-addres{
            width: 100%;
        }

        .table-addres tr td{
            vertical-align: top;
            padding: 15px;

        }

        .therd-box{
            padding: 20px 15px;
            background: #cccccc30;
            border-radius: 10px;

            font-size: 15px;
            float: left;
        }
        .therd-box table{width: 100%; padding: 0; margin: 0;}
        .therd-box caption{
            background-color: #FFF8E1;
            padding: 4px 5px;
            font-size: 15px;
            font-family: sans-serif;
            color: black;
            font-weight: 800;
        }

        .therd-box table tr td{
            border: 1px solid #ccc;
            font-size: 13px;
            color: black;
            background-color: #FFF;
            padding-left: 5px;
            margin: 0;
        }

        .tab-ot-info{
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
            float: left;
        }

        .foot-tb{
            font-size: 13px;
            border: 1px solid #ccc;
            color: black;
            padding: 10px;
            margin-top: 15px;
            text-align: justify;
        }

    </style>

</head>

<body background="{{ url('front/assets/img/frame.jpeg')}}"  style=" background-repeat: no-repeat; background-attachment: fixed; background-size: 100% 100%;">

@php($member_detail = $member ? $member->member_detail : [])
<div class="boder-tab">
    <table class="main-tabile-st">
        <tr>
            <td width="150">Name of Organization</td>
            <td width="1">:</td>
            <td class="under-dot" style="whitespace-wrap:nowrap">{{$member['organization_name']}}</td>
        </tr>
        <tr>
            <td>Membership Number</td>
            <td>:</td>
            <td class="under-dot">{{$member['username']}}</td>
        </tr>
        <tr>
            <td>Place of Enlistmen</td>
            <td>:</td>
            <td class="under-dot">{{$member_detail->place_of_enlistment}}</td>
        </tr>
        <tr>
            <td> Type of the Organization</td>
            <td>:</td>
            <td class="under-dot"> {{$member_detail->firm_type}}, {{$member_detail->type_local}} </td>
        </tr>
        <tr>
            <td> Activity Status</td>
            <td>:</td>
            <td class="under-dot"> {{$member['status']}} </td>
        </tr>
    </table>
</div>

<div style=" font-size: 20px;font-weight: bold; text-align: center;"> Company Owner(s) information</div>

<!-- Company Owner(s) information -->
@foreach($member->company_owners as $company_owner)
<div class="second-box" >
    <table class="main-tabil-st" >

        <tr>
            <td rowspan="11"  width="120" ALIGN= "CENTER"   VALIGN="TOP">
                @if($company_owner->attach_photograph)
                    <img src="{{ baffasoft_url("$company_owner->attach_photograph")}}" style="border: 5px solid white" width="128" height="156" alt="PHOTO">
                @else
                    <img src="{{ baffasoft_url("/assets/img/photo-icon.png")}}">
                @endif
                <div style=" padding-top:10px; ">
                    @if($company_owner->attach_signature)
                        <img style="width: 70%; " src="{{ baffasoft_url("$company_owner->attach_signature")}}" width="200" height="70" alt="Signature">
                    @else
                        <img src="{{ baffasoft_url("/assets/img/sig-icon.png")}}"  width="200" height="70">
                    @endif
                </div>

            </td>
            <td width="130" class="al-right" >Name </td>
            <td width="1">:</td>
            <td class="al-left">{{$company_owner['name']}}</td>
        </tr>
        <tr>
            <td class="al-right" >Designation </td>
            <td>:</td>
            <td class="al-left">{{$company_owner['designation']}}</td>
        </tr>

        <tr>
            <td class="al-right">Nationality </td>
            <td>:</td>
            <td class="al-left">{{$company_owner->nationality ? $company_owner->nationality->name : 'Nothing'}}</td>
        </tr>
        <tr>
            <td class="al-right">NID No </td>
            <td>:</td>
            <td class="al-left">{{$company_owner['nid_no']}}</td>
        </tr>
        <tr>
            <td class="al-right">Educational qualification </td>
            <td>:</td>
            <td class="al-left">{{$company_owner['educational_qualification']}}</td>
        </tr>
        <tr>
            <td class="al-right" >Mobile No </td>
            <td>:</td>
            <td class="al-left">{{$company_owner['mobile_no']}}</td>
        </tr>
        <tr>
            <td class="al-right">Email </td>
            <td>:</td>
            <td class="al-left">{{$company_owner['email']}}</td>
        </tr>
        <tr>
            <td class="al-right">Experience Year </td>
            <td>:</td>
            <td class="al-left">{{$company_owner->experience_year ? $company_owner['experience_year'] . ' Years' : '' }} </td>
        </tr>
        <tr>
            <td class="al-right">Signatory </td>
            <td>:</td>
            <td class="al-left">{{$company_owner['signatory'] == 1 ? 'Yes' : 'No'}}</td>
        </tr>
        <tr>
            <td class="al-right">Authorized Person </td>
            <td>:</td>
            <td class="al-left">{{$company_owner['authorized_person'] == 1 ? 'Yes' : 'No'}}</td>
        </tr>
        <tr>
            <td class="al-right">Nominate For Vote </td>
            <td>:</td>
            <td class="al-left">{{$company_owner['nominate_for_vote'] == 1 ? 'Yes' : 'No'}}</td>
        </tr>

    </table>
</div>
@endforeach
<!-- address -->
<!-- next page -->
<table class="table-addres" style=" margin-top:30px;">
    <tr>
        <td class="add-box">
            <h6>Register Address</h6>
            @php($head_office = $member->head_office)
            <ul>
                <li>{{$head_office->address}}</li>
                <li>Total Floor Area: {{$head_office->floor_area}}</li>
                <li>Telephone No: {{$head_office->telephone_no}}</li>
                <li>Fax No: {{$head_office->fax_no}}</li>
                <li>Mobile No: {{$head_office->mobile_no}}</li>
                <li>E-mail Address: {{$head_office->email_address}}</li>
            </ul>
        </td>

        <td class="add-box">
            <h6>Warehouse Address</h6>
            <ul>
                <li>{{$member_detail->warehouse_office_address}}</li>
                <li>Total Floor Area: {{$member_detail->warehouse_office_floor_area}}</li>
            </ul>
        </td>
        <td class="add-box">
            <h6>Branch Office Address:</h6>
            @php($branch_office = $member->branch_office)
            <ul>
                <li>{{$branch_office->address}}</li>
                <li>Total Floor Area: {{$branch_office->floor_area}}</li>
                <li>Telephone No: {{$branch_office->telephone_no}}</li>
                <li>Fax No: {{$branch_office->fax_no}}</li>
                <li>Mobile No: {{$branch_office->mobile_no}}</li>
                <li>E-mail Address: {{$branch_office->email_address}}</li>
            </ul>
        </td>
    </tr>
</table>
<div class="therd-box" style=" margin-top: 10px;">
    <table>
        <caption>Particulars of Certificate of Registration/Incorporation </caption>
        <tr>
            <td><b>Number :</b> {{ $member_detail->particulars_of_certificate_number }}</td>
            <td><b>Date :</b> {{ $member_detail->particulars_of_certificate_date? $member_detail->particulars_of_certificate_date->format(config('app.bn_date_format')) : '' }}</td>
        </tr>
    </table>
    <table>
        <caption>Date of Establishment of the Firm</caption>
        <tr>
            <td><b>Date : </b>{{ $member_detail->date_of_establishment? $member_detail->date_of_establishment->format(config('app.bn_date_format')) : ''  }}</td>
        </tr>
    </table>
    <table>
        <caption>Trade License</caption>
        <tr>
            <td><b>No. </b>{{ $member_detail->trade_license_number }}</td>
            <td><b>Validity: </b>{{ $member_detail->trade_license_date? $member_detail->trade_license_date->format(config('app.bn_date_format')) : ''  }}</td>
        </tr>
    </table>
    <table>
        <caption>e-TIN No</caption>
        <tr>
            <td><b>No: </b>{{ $member_detail->tin_number }}</td>
        </tr>
    </table>
    <table>
        <caption>VAT Registration Certificate</caption>
        <tr>
            <td><b>No: </b>{{ $member_detail->vat_registration_number }}</td>
        </tr>
    </table>
    <table>
        <caption>Freight Forwarding License No.</caption>
        <tr>
            <td><b>No: </b>{{ $member_detail->ff_license_no }}</td>
        </tr>
    </table>
    <table>
        <caption>Name of Banker</caption>
        <tr>
            <td><b>Name: </b>{{ $member_detail->name_of_banker }}</td>
            <td><b>Banker Address: </b>{{ $member_detail->address_of_banker }}</td>
        </tr>
    </table>
    <table>
        <caption>Membership of Other Trade Organization(s), if any: </caption>
        <tr>
            <td><b>Name :</b>{{ $member_detail->membership_of_other_trade_organization }}</td>
        </tr>
    </table>
    <table>
        <caption>Name of Authorized Person (Director/Partner): </caption>
        <tr>
            <td><b>Name :</b> {{ $member_detail->name_of_authorized_person }}</td>
        </tr>
    </table>

    <table>
        <caption>No. of Appointed Staffs:</caption>
        <tr>
            <td><b>No :</b> {{ $member_detail->no_of_appointed_staff }}</td>
        </tr>
    </table>

    <table >
        <caption>Warehouse, if any: </caption>
        <tr>
            <td><b>Address:</b> {{ $member_detail->warehouse_office_address }}</td>
        </tr>
        <tr>
            <td><b>Total Floor Area:</b> {{ $member_detail->warehouse_office_floor_area }}</td>
        </tr>
    </table>
    <table>
        <caption>Name of the existing member organization(s) of BAFFA (if any)</caption>
        <tr>
            <td><b>Name of the existing member : </b>{{ $member_detail->other_org }}</td>
        </tr>
    </table>
    @php($formatter = new NumberFormatter('en-US', NumberFormatter::ORDINAL))
    <div class="foot-tb">
        <p>The Membership Sub-committee, BAFFA has recommended this application in its meeting held on
            {{ $member_detail->sub_committee_meeting_date? $member_detail->sub_committee_meeting_date->format(config('app.bn_date_format')) : '' }} for Board approval. Accordingly,
            the application was submitted in the
            {{ $member_detail->board_of_directors_meeting_no ? $formatter->format($member_detail->board_of_directors_meeting_no) : '' }}
            Board of Directors meeting held on
            {{ $member_detail->board_of_directors_meeting_date? $member_detail->board_of_directors_meeting_date->format(config('app.bn_date_format')) : '' }}
            and Board has approved the applications.</p>
        <p style="height: 100px;"></p>
        <p>_______________________________________</p>
        <p>Signature with Company Seal</p>
    </div>

</div>
</body>
</html>
