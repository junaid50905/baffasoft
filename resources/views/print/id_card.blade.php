<?php
if ($id_card->form_year) {
    $form_year = (int)$id_card->form_year;
} else {
    $form_year = 2021;
}
?>
    <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Card Form </title>
    <link rel="stylesheet" href="{{ url('front/assets/id-card-print/style.css')}}">
</head>
<body>
<table>
    <tr>
        <td style="width: 100px;"></td>
        <td align="center" style="width: 470px;">
            <img style="width: 150px;" src="{{ url('front/assets/id-card-print/img/baffa-logo.png')}}" alt=""><br>
            <img style="width: 100%; margin-top:4px;" src="{{ url('front/assets/id-card-print/img/id-title.png')}}"
                 alt=""><br>
            <!-- <p id="id1">BANGLADESH FREIGHT FORWARDERS ASSOCIATION</p> -->
            <p class="id2"><b>ID CARD FORM - {{$form_year}}</b></p>
        </td>
        <td>
            @if($id_card->card_holder_photograph_attachment)
                <img style="width: 100px; border:1px solid black;"
                     src="{{ baffasoft_url("$id_card->card_holder_photograph_attachment")}}" alt="">
            @else
                <img style="width: 100px; " src="{{ url('front/assets/id-card-print/img/ps-photo.png')}}" alt="">
            @endif
        </td>

    </tr>


</table>
<table class="info-table">
    <tr>
        <td>Date:</td>
        <td>:<input style="width: 340px;" type="text" id="fname" name="fname" value="{{date('Y-m-d', strtotime($id_card->created_at))}}">
        </td>
    </tr>
    <tr>
        <td style="width: 320px;">1. Name of the Card Holder<span class="aster">*</span></td>
        <td>:<input style="width: 340px;" type="text" id="fname" name="fname" value="{{$id_card->card_holder_name}}">
        </td>
    </tr>
    <tr>
        <td style="width: 320px;">2. Card Holder’s Designation<span class="aster">*</span></td>
        <td>:<input style="width: 340px;" type="text" id="fname" name="fname"
                    value="{{$id_card->card_holder_designation}}"></td>
    </tr>
    <tr>
        <td style="width: 320px;">3. Name of the Member Organization(s) <span class="aster">*</span></td>
        <td>:<input style="width: 340px;" type="text" id="fname" name="fname" value="{{implode(',',$organization_names->all())}}"></td>
    </tr>
{{--    <tr>--}}
{{--        <td style="width: 320px;">3. Name of the Member Organization(s) <span class="aster">*</span></td>--}}
{{--        @php($all_names = clone $organization_names)--}}
{{--        @if($organization_names)--}}
{{--            <td>:<input style="width: 340px;" type="text" id="fname" name="fname" value="{{$all_names->shift()}}"></td>--}}
{{--        @else--}}
{{--            <td>:<input style="width: 340px;" type="text" id="fname" name="fname" value=""></td>--}}
{{--        @endif--}}
{{--    </tr>--}}
{{--    @foreach($all_names as $name)--}}
{{--        <tr>--}}
{{--            <td></td>--}}
{{--            <td>:<input style="width: 340px;" type="text" id="fname" name="fname" value="{{$name}}"></td>--}}
{{--        </tr>--}}
{{--    @endforeach--}}
    <tr>
        <td style="width: 320px;">4. BAFFA Membership No. <span class="aster">*</span></td>
        <td>:<input style="width: 340px;" type="text" id="fname" name="fname" value="{{$id_card->memship_no}}"></td>
    </tr>
    <tr>
        <td style="width: 320px;">5. Office Address <span class="aster">*</span></td>
        <td>:<input style="width: 340px;" type="text" id="fname" name="fname" value="{{$id_card->office_address}}"></td>
    </tr>
    <tr>
        <td></td>
        <td>:<input style="width: 340px;" type="text" id="fname" name="fname" value="{{$id_card->office_address}}"></td>
    </tr>
    <tr>
        <td style="width: 320px;">6. Office Telephone No. <span class="aster">*</span></td>
        <td>:<input style="width: 340px;" type="text" id="fname" name="fname" value="{{$id_card->office_telephone}}">
        </td>
    </tr>
    <tr>
        <td style="width: 320px;">7. Date of Birth (above 18 years) <span class="aster">*</span></td>
        <?php
        $dob = $id_card->dob;
        if ($dob) {
            $dob = date("j F, Y", strtotime($dob));
        }
        ?>
        <td>:<input style="width: 340px;" type="text" id="fname" name="fname" value="{{$dob}}"></td>
    </tr>
    <tr>
        <td style="width: 320px;">8.
            {{--            National ID/Passport/Birth Certificate--}}
            {{$id_card->attachment_name}}
            No. <span class="aster">*</span></td>
        <td>:<input style="width: 340px;" type="text" id="fname" name="fname" value="{{$id_card->attachment_number}}">
        </td>
    </tr>
    <tr>
        <td style="width: 320px;">9. Blood Group</td>
        <td>:<input style="width: 340px;" type="text" id="fname" name="fname" value="{{$id_card->blood_group}}"></td>
    </tr>
    <tr>
        <td style="width: 320px;">10. Previous year ({{$form_year - 1}}) ID Card No.</td>
        <td>:<input style="width: 340px;" type="text" id="fname" name="fname"
                    value="{{$id_card->previous_year_id_card_number}}"></td>
    </tr>
    <tr>
        <td style="width: 320px;">11. Police Verification/clearance issue date<span class="aster">*</span></td>
        <td>:<input style="width: 340px;" type="text" id="fname" name="fname" value="{{$id_card->police_verification}}">
        </td>
    </tr>
</table>
<table>
    <tr>
        <td style="width: 320px;">12. Cargo Security Awareness Training Status</td>
        <td>:</td>
        <input type="checkbox" id="" @if($id_card->training_status == 'yes') checked @endif>
        <td style="padding:0 25px">Yes</td>
        <input type="checkbox" id="" @if($id_card->training_status == 'no') checked @endif>
        <td style="padding:0 25px">No</td>
        <td style="padding:0 0 0 30px;">
            Please mark √
        </td>
    </tr>
</table>
@if($id_card->training_status == 'yes')
    <?php
    $day = '';
    $month = '';
    $year = '';
    $training_date = $id_card->training_date;
    if ($training_date) {
        $convert_date = strtotime($training_date);
        $day = date('d', $convert_date);
        $month = date('m', $convert_date);
        $year = date('y', $convert_date);
    }
    ?>
    <table>
        <tr>
            <td style="width: 298px;padding-left:22px;">If “Yes” please mentioned details</td>
            <td>: Training Date</td>
            <td style="padding-left: 32px;">: <input style="width: 40px;text-align:center;" type="text" id="fname"
                                                     name="fname" value="{{$day}}">/
            </td>
            <td style="margin-left: 0;"><input style="width: 40px;margin-left:0;text-align:center;" type="text"
                                               id="fname" name="fname" value="{{$month}}">/
            </td>
            <td style="margin-left: 0;">20
                <input style="width: 40px;margin-left:0;padding-left:4px;text-align:center;" type="text" id="fname"
                       name="fname" value="{{$year}}">
            </td>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td style="width: 320px;"></td>
            <td style="padding-left: 10px;">Valid CAAB ID No.</td>
            <td>: <input style="width: 156px;text-align:center;" type="text" id="fname" name="fname"
                         value="{{$id_card->caab_id_no}}"></td>
        </tr>
    </table>
@endif
<table style="margin-top: 20px;">
    <tr>
        <td style="width: 450px;"></td>
        <td align="center">
            @if($id_card->card_holder_signature_attachment)
                <img style="width:100px;height: 25px" src="{{ baffasoft_url("$id_card->card_holder_signature_attachment") }}"
                     alt="">
            @else
                <img style="width:100px;height: 25px;" src="{{ url('front/assets/id-card-print/img/sign-demo.png')}}"
                     alt="">
            @endif
            <br>
            <input style="width: 190px;" type="text" id="fname" name="fname" value=""><br>Card Holder’s Signature<span
                class="aster">*</span>
        </td>
    </tr>
</table>
<p style="text-align: justify; font-size:12px;">I would like to request to provide the ID card for the following regular
    employee/staff of my/our company for the year {{$form_year}}. In connection with the above, I (undersigned management person)
    do hereby declare that, above person is my/our regular employee and being the employer of mentioned employee, me
    (undersigned management person) and my company will be held fully responsible and liable in case of any
    unlawful/fraudulent activities been carried out by my/our employee by holding BAFFA ID Card at HSIA Cargo Village,
    and in any circumstances BAFFA and any of its Staff/Directors should not be held liable or responsible for such
    unlawful/fraudulent activities.</p>
<table style="margin-top: 20px;line-height:8px;">
    <tr style="padding:0; margin:0;">
        <td style="width: 290px;"></td>
        <td align="center">
            @if($id_card->card_holder_signature_attachment)
                <img style="width:100px; height: 25px; padding:0; margin:0;"
                     src="{{ baffasoft_url("$id_card->signatory_attachment") }}" alt=""><br>
            @else
                <img style="width:100px; height: 25px; padding:0; margin:0;"
                     src="{{ url('front/assets/id-card-print/img/sign-demo.png')}}" alt=""><br>
            @endif
            <input style="width: 288px; padding:0; margin:0;" type="text" id="fname" name="fname" value=""><br>
            <p style="padding:0;margin:0;">Signature of Chairman/MD/ Director<span class="aster">*</span></p><br>
            <p style="padding:0;margin:0;">Managing Partner/Proprietor</p>
        </td>
    </tr>
</table>
<table style="line-height:8px;">
    <tr style="padding:0; margin:0;">
        <td style="width: 290px;"></td>
        <td>
            <p style="padding:0;margin:0;">Name of the Signatory : {{$company_owner_name}}</p><br>
            <p style="padding:0;margin:0;">Designation : {{$id_card->designation}}</p><br>
            <p style="padding: 0; margin-top:-5px;line-height: 14px;">{{ 'Company Name : ' . implode(',',$organization_names->all()) }}</p>
        </td>
    </tr>
</table>
<table style="position:fixed; bottom: 35px;">
    <tr>
        <img style=" width:100%;" src="{{ url('front/assets/id-card-print/img/ftr1.png')}}" alt="">
    </tr>
</table>

</html>
