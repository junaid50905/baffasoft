<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner ID Card </title>
    <link href='https://fonts.googleapis.com/css?family=Roboto Condensed' rel='stylesheet'>

    {{--    <link rel="stylesheet" href="{{ url('front/assets/id-card-print/member_style.css')}}">--}}
    <style type="text/css">
        body {
            font-family: 'Roboto Condensed', sans-serif;
        }
    </style>
</head>
<style type="text/css">
    body {
        font-family: 'Roboto Condensed', sans-serif;
    }
</style>

<body>
<!-- <table style="height:500px;border: 1px solid #000; padding:0 !important;">
    <table>
        <tr>
{{--            <td><img style="width: 310px;margin-top:0; padding-top:0;" src="{{ url('front/assets/id-card-print/img/6.png')}}" alt=""></td>--}}
        </tr>
    </table>
    <table>
        <tr>
            <td>
{{--                <img style="z-index:1;width:110px; position: fixed; top: 163px;left: 94px; border: 8px solid #795548;border-radius:50%;background:#304ffe;" src="{{ url('front/assets/id-card-print/img/id-img.png')}}" alt="">--}}
            </td>
        </tr>
    </table>
    <table style="padding-left:10px;line-height:12px;">
        <table>
            <table>
                <table>
{{--                    <tr><input style="text-transform:uppercase;color:orangered; padding:0; margin:0;width: 250px; font-size:19px;background-color:transparent;font-weight:bold;border:none;" type="text" id="fname" name="fname" value="{{$id_card->card_holder_name}}"></tr>--}}
                </table>
                <table>
{{--                    <tr><input style="padding:0; margin:0;width: 170px;font-size: 16px;font-weight:bold;background-color:transparent;color:black;border:none;" type="text" id="fname" name="fname" value="{{$id_card->card_holder_designation}}"></tr>--}}
                </table>
            </table>
        </table>
        <table>
            <tr style="width: 110px;font-size:12px;color:#000;font-weight:normal;">
                <td style="width: 50px;">Company:</td>
{{--                @if($organization_names)--}}
{{--                    <td>{{$organization_names->shift()}}</td>--}}
{{--                @else--}}
                    <td></td>
{{--                @endif--}}
            </tr>
        </table>
{{--        @foreach($organization_names as $organization_name)--}}
            <table>
                <td style="width: 55px;"></td>
{{--                <td style="font-size: 12px;">{{$organization_name}}</td>--}}
            </table>
{{--        @endforeach--}}
        <table>
            <tr style="width: 110px;font-size:14px;color:orangered;">
                <td>Membership No:</td>
{{--                <td>{{$id_card->memship_no}}</td>--}}
            </tr>
            <tr style="width: 110px;font-size:16px;color:#000;">
                <td>ID NO:</td>
{{--                <td>{{$id_card->id_card_number}}</td>--}}
            </tr>
            <tr style="width: 110px;font-size:14px;color:#000;">
                <td style="color:orangered;">Expire:</td>
{{--                <td>{{'31-12-'.$id_card->form_year}}</td>--}}
            </tr>
            <tr style="width: 110px;font-size:14px;color:#000;">
{{--                <td><img style="width: 13px;" src="{{ url('front/assets/id-card-print/img/7.png')}}" alt="">Blood:</td>--}}
{{--                <td style="color:orangered;">{{$id_card->blood_group}}</td>--}}
            </tr>
            <tr style="width: 110px;font-size:14px;color:#000;">
                <td style="color:orangered;">Contact:</td>
                <td>{{$id_card->office_telephone}}</td>
            </tr>
        </table>
        <table>
            <tr>
                <td>
                    <img style="width:120px;left:74px;position: fixed;top:20px;" src="{{ url('front/assets/id-card-print/img/1.png')}}" alt="">
                </td>
            </tr>
        </table>

        <table>
            <tr>
                <td>
                    <p style="width: 170px;position:fixed;top: 63px;left: 110px;line-height:15px;">Bangladesh Freight Forwarders Association</p>
                </td>
            </tr>
        </table>

    </table>
    <table>
        <tr>
            <td><img style="position:fixed; top:497px;width:190px;height:12px;padding-left:30px;" src="{{ url('front/assets/id-card-print/img/8.png')}}" alt=""></td>
        </tr>
    </table>

<!-- <table style="margin-top:50px; padding-top:0;z-index:-1000;">
            <tr>
                <td>
                    <img style="padding:0; margin:0; width:289px; height:220px;" src="{{ url('front/assets/id-card-print/img/4.png')}}" alt="">
                </td>
            </tr>
        </table>
</table> -->

<!-- font side id  -->

<style>
.front-a-side{
   border: 0.5px dotted #ccc;
   padding:0 ;
   margin:0 ;
   height:326px;
   width:206px;
   font-family: 'Roboto Condensed', sans-serif;
}

.front-a-side img{
    width: 100%;
}

</style>
<div class="front-a-side">
      <div  style="text-align: center;">
        <img style="width:80%;" src="{{ url('front/assets/id-card-print/img/woner-bg.png')}}" alt="">
    </div>
    <div style="text-align: center; margin-top:-60px; padding: 0;">
        @if($id_card->card_holder_photograph_attachment)
            <img style="width:40%;  border: 4px solid #795548; border-radius:50%; background:#fff;" src="{{ baffasoft_url($id_card->card_holder_photograph_attachment)}}" alt="">
        @else
            <img style="width:40%;  border: 4px solid #795548; border-radius:50%; background:#fff;" src="{{ url('front/assets/id-card-print/img/id-img.png')}}" alt="">
         @endif
    </div>
   <div style="margin:0 15px 0 20px;padding:0;" >
    <h6 style="font-size:11px;margin:0;padding:0; color:#f15523;">{{$id_card->card_holder_name}}</h6>
    <p style="font-size:8px;margin:0;padding:0;font-weight:bold;">{{$id_card->card_holder_designation}}</p>

<table>
    <tr>
        <td style="font-size:8px;margin:5px 0 ;padding:0;vertical-align:top;  line-height: 0.8;">Company:</td>
        <td style="font-size:8px;margin:0;padding:0;vertical-align:top;  line-height: 0.8;">
            {{$organization_names}}
{{--            XPRESS GLOBAL LOGISTICS LTD, XPRESS GLOBAL LOGISTICS LTD, FRIGHT MANAGMENT LTD. FRIGHT MANAGMENT LTD.--}}
        </td>
    </tr>
    <tr>
        <td colspan = "2"  style="font-size:8px;margin:0;padding:0;vertical-align:top; color:#f15523;">Membership No.: {{$id_card->memship_no}}</td>
    </tr>
    <tr>
        <td colspan = "2"  style="font-size:8px;margin:0;padding:0;vertical-align:top;font-weight:bold;">ID NO: {{$id_card->id_card_number}}</td>
    </tr>
    <tr>
        <td colspan = "2"  style="font-size:8px;margin:0;padding:0;vertical-align:top;color:#f15523; ">Expire : 31-12-{{$id_card->form_year}}</td>
    </tr>

    <tr>
        <td colspan = "2"  style="font-size:8px;margin:0;padding:0;vertical-align:top;">
        <img style="width:4%; margin-left:-8px;padding-right:1px; " src="{{ url('front/assets/id-card-print/img/icon-blood.png')}}" alt=""> Blood :<span style="color:#f15523;"> {{$id_card->blood_group}}</span> </td>
    </tr>
    <tr>
        <td colspan = "2"  style="font-size:8px; margin:0; padding:0; vertical-align:top;"><span style="color:#f15523;">Contact:</span> {{$id_card->office_telephone}}</td>
    </tr>
</table>
   </div>

 <div style="text-align: center;  margin-top:18px">
 <img style="width:50%; " src="{{ url('front/assets/id-card-print/img/id-uline.png')}}" alt="">
</div>

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
    <td colspan = "2" style="text-align: center; vertical-align: middle;  margin:0; padding:0px 10px; " >
        <h6 style=" margin-top:8px; padding:0px;">This card is the property of BAFFA and is non-transferable.</h5>
        <p style="font-size:9px;" ><img style="width:50%; padding:0 ; margin:-20px 0 0 0 ;" src="{{ url('front/assets/id-card-print/img/id-logo.png')}}" alt=""> <br>
         Bangladesh Freight Forwarders Association <br>
   <span style="color:#f15523;">Tel:</span> +88 02 8836324-25, 02222281663 <br>
   <span style="color:#f15523;">Email:</span> info@baffa-bd.org </p>
    </td>
  </tr>

    <tr>
        <td colspan = "2" style="text-align: center; padding: 0;">
        <div style="width:206px;margin:0; background: url('{{ url('front/assets/id-card-print/img/2nd-bg.png')}}') no-repeat;padding-bottom:5px;  ">
        <img style="width:30%; padding-bottom:5px;" src="{{ url('front/assets/id-card-print/img/qr.png')}}" alt="">
        <p style="font-size:7px; padding:0 ; margin:0;">in case of lost your id card please inform to</p>
        <p style="font-size:9px;padding:0 ; margin:0;"> Bangladesh Freight Forwarders Association</p>
        <p style="font-size:5px;padding:0 ; margin:0;">House No.10,Level:2&3, Road No. 17A Block-E, Banani, Dhaka-1213, Bangladesh.</p>
         </div>
    </td>
    </tr>
    <tr>
            <td style="text-align: center; vertical-align: middle; padding:0 8px 4px 10px;">
                @if($id_card->card_holder_signature_attachment)
                    <img style="width:50%; padding:3 ; margin:0 ;height: 42px;" src="{{ baffasoft_url($id_card->card_holder_signature_attachment)}}" alt="">
                @else
                    <img style="width:50%; padding:3 ; margin:0 ;height: 42px;opacity: 0" src="{{ url('front/assets/id-card-print/img/holder-sg.png')}}" alt="">
                @endif
                <br>

                <p style="font-size:6px; padding:0 ; margin:0;  border-top: 1px solid #000; width:90%;"> Card Holder's Signature</p>
            </td>
            <td style="text-align: center; vertical-align: middle; padding:0 8px 4px 10px;">
               <img style="width:50%; padding:3 ; margin:0;" src="{{ url('front/assets/id-card-print/img/prer-sg.png')}}" alt=""><br>
               <p style="font-size:7px; padding:0 ; margin:0;  border-top: 1px solid #000; width:80%; text-align: center;"> President</p>
            </td>
    </tr>

</tbody>
    <tfoot>
    <tr>
       <td colspan = "2" style="background:color:#000; border-top: 2px solid #f15523;text-align: center;height: 22px;padding: 0;margin:0; ">
        <p style="font-size:10px; color:#fff;padding: 0;margin:0; line-height:10px;">www.baffa-bd.org</p>
    </td>

    </tr>
  </tfoot>
</table>
</div>




</body>

</html>
