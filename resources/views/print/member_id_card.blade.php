<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member ID Card </title>
    <link href='https://fonts.googleapis.com/css?family=Roboto Condensed' rel='stylesheet'>
    {{--    <link rel="stylesheet" href="{{ url('front/assets/id-card-print/member_style.css')}}">--}}
    <style type="text/css">
        body {
            font-family: 'Roboto Condensed', sans-serif;
        }
    </style>
</head>
<body>
<!-- Updated -->

<!-- back side -->
<style>
.font-side{
   border: 0.5px dotted #ccc;
   padding:0 ;
   margin:0 ;
   height:326px;
   width:206px;
   position: relative;
}
</style>

<div class="font-side">
<table>

<img style="position: absolute; width:206px; margin-top:20px; margin-left:-2px;" src="{{ url('front/assets/id-card-print/img/4.png')}}" alt="">
  <tr>
    <td colspan = "2" style="text-align: center; vertical-align: middle;  margin:0; padding:0px; position: relative;" >
    <img style="width:40%;" src="{{ url('front/assets/id-card-print/img/id-logo.png')}}" alt="">
    <p style="padding:0; margin:0 0 5px 0; font-size:11px;">Bangladesh Freight Forwarders Association </p>
        @if($id_card->card_holder_photograph_attachment)
            <img style="width:100px; hight:100px; border: 6px solid #795548; border-radius:100%; background:#fff; padding:0 ; margin:0;" src="{{ baffasoft_url($id_card->card_holder_photograph_attachment)}}" alt="">
        @else
            <img style="width:100px; hight:100px; border: 6px solid #795548; border-radius:100%; background:#fff; padding:0 ; margin:0;" src="{{ url('front/assets/id-card-print/img/id-img.png')}}" alt="">
        @endif
    </td>
  </tr>
</table>

<table style="padding:0; margin:0px 10px 5px 15px; color:#fff; width: 185px;">
    <tr>
        <td colspan = "2" style="padding:0; margin:0; font-size:10px; line-height: 9px; " ><b> {{$id_card->card_holder_name}}</b></td>
    </tr>
    <tr>
    <td colspan = "2" style="padding:0; margin:0; font-size:10px; line-height: 9px;" >{{$id_card->card_holder_designation}} </td>
    </tr>
    <tr>
    <td colspan = "2" style="padding:0; margin:0; font-size:9px;line-height: 9px;" ><b>ID NO: {{$id_card->id_card_number}} </b></td>
    </tr>

    <tr>
        <td style="padding:0; margin:0; font-size:9px;line-height:8px; vertical-align:top; width: 40px;">Company :</td>
        <td style="padding:0; margin:0; font-size:9px; line-height:8px; vertical-align:top;">
            {{$organization_names}}
{{--            <span>3PL Global Ltd.</span>  <span>4PL Logistics BD Ltd. </span> <span>A 2 Z Logistics Solutions My Company</span>--}}
        </td>
    </tr>
    <tr>
    <td colspan = "2" style="padding:0; margin:0; font-size:9px;line-height: 8px;" >Membership No. {{$id_card->memship_no}}</td>
    </tr>
    <tr>
    <td colspan = "2" style="padding:0; margin:0; font-size:9px;line-height: 8px;" >Emergency Contact: {{$id_card->office_telephone}}</td>
    </tr>
    <tr>
    <td colspan = "2" style="padding:0; margin:0; font-size:9px;line-height: 8px;" >Expire: 31-12-{{$id_card->form_year}}</td>
    </tr>
    <tr>

    <td colspan = "2" style="padding:0; margin:0; font-size:9px;line-height: 8px;" ><img style="padding:0; margin-left:-9px; width:4%;" src="{{ url('front/assets/id-card-print/img/icon-blood-w.png')}}" alt=""> Blood : {{$id_card->blood_group}}</td>
    </tr>
</table>

</div>

<br>


<!-- back side -->
<style>
.back-side{
   border: 0.5px dotted #ccc;
   padding:0 ;
   margin:0 ;
   height:326px;
   width:206px "
}
</style>

 <div class="back-side">
<table style=" border-spacing: 0; border-collapse: collapse;">
<tbody>
  <tr>
    <td colspan = "2" style="text-align:center; vertical-align: middle;  margin:0; padding:10px; " >
        <h6 style=" margin:0; padding:0px;text-align:center;">This card is the property of BAFFA and is non-transferable.</h5>
        <p style="font-size:9px;line-height: 8px;" >
        <img style="width:50%; padding:0 ; margin:-5px 0 0 0 ;" src="{{ url('front/assets/id-card-print/img/id-logo.png')}}" alt=""> <br>
         Bangladesh Freight Forwarders Association <br>
   <span style="color:#f15523;">Tel:</span> +88 02 8836324-25, 02222281663 <br>
   <span style="color:#f15523;">Email:</span> info@baffa-bd.org </p>
    </td>
  </tr>

    <tr>
        <td colspan = "2" style="text-align: center; padding: 0;">
        <div style="width:206px; background: url('{{ url('front/assets/id-card-print/img/bg-boder.png')}}');padding-bottom:5px;margin-left:0px; ">
        <img style="width:30%; padding-bottom:5px;" src="{{ url('front/assets/id-card-print/img/qr.png')}}" alt="">
        <p style="font-size:7px; padding:0 ; margin:0; line-height: 8px;">in case of lost your id card please inform to</p>
        <p style="font-size:9px;padding:0 ; margin:0;line-height: 8px;"> Bangladesh Freight Forwarders Association</p>
        <p style="font-size:5px;padding:0 ; margin:0;line-height: 8px;">House No.10,Level:2&3, Road No. 17A Block-E, Banani, Dhaka-1213, Bangladesh.</p>
         </div>
    </td>
    </tr>
    <tr>
            <td style="text-align: center; vertical-align: middle; padding:0 8px 6px 10px;">
                @if($id_card->card_holder_signature_attachment)
                    <img style="width:50%; padding:3 ; margin:0 ;height: 42px;" src="{{ baffasoft_url($id_card->card_holder_signature_attachment)}}" alt=""><br>
                @else
                    <img style="width:50%; padding:3 ; margin:0 ;height: 42px;opacity: 0" src="{{ url('front/assets/id-card-print/img/holder-sg.png')}}" alt=""><br>
                @endif
                <p style="font-size:6px; padding:0 ; margin:0;  border-top: 1px solid #000; width:90%;"> Card Holder's Signature</p>
            </td>
            <td style="text-align: center; vertical-align: middle; padding: 0 8px 6px 10px;">
               <img style="width:50%; padding:3 ; margin:0;" src="{{ url('front/assets/id-card-print/img/prer-sg.png')}}" alt=""><br>
               <p style="font-size:7px; paddin-left:10px ; margin:0;  border-top: 1px solid #000; width:90%; text-align: center;"> President</p>
            </td>
    </tr>

</tbody>
    <tfoot>
    <tr style="margin-top:10px" >
       <td colspan = "2" style="background:color:#000; width:206px; border-top: 2px solid #f15523; text-align: center; height:22px; padding:0;  margin:0; ">
        <p style="font-size:10px; color:#fff;padding: 0;margin:0; line-height:10px;">www.baffa-bd.org</p>
    </td>

    </tr>
  </tfoot>
</table>
</div>





</body>
</html>
