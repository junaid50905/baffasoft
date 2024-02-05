<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member ID Card </title>
    <link href='https://fonts.googleapis.com/css?family=Roboto Condensed' rel='stylesheet'>

    <link rel="stylesheet" href="{{ url('front/assets/id-card-print/voter_print.css')}}">

</head>
<body>
<!-- Updated -->

<!-- back side -->


<div class="font-side">

    <div class="V-card-head">
        <img style="width:100%; margin:0;margin-left:1px; padding:0; "
             src="{{ url('front/assets/id-card-print/img/head-1.png')}}" alt="">
        <h3 class="ele-titel">Election {{$election_name}} </h3>
    </div>
    <div class="vright-head">
        <img style="width:66%;" src="{{ url('front/assets/id-card-print/img/v-id-card.png')}}" alt="">
    </div>

    <!-- votar images & QR  -->
    <div class="id-img-qr">
        @if($voter_image && $voter_image !== 'null')
            <img class="voter-frame" src="{{ baffasoft_url($voter_image)}}" alt="">
        @else
            <img class="voter-frame" src="{{ url('images/no-image.jpg')}}" alt="">
        @endif
        <img class="voter-qr"
             src="data:image/png;base64,{{ DNS1D::getBarcodePNG($bar_code, 'C39+',1,53,array(1,1,1), true) }}"
             alt="barcode"/>
    </div>
    <!-- votar infoation -->
    <div class="votar-info">
        <h3>{{$company_owner_name}}</h3>
        @if($voter_name)
            <h5>{{$voter_name}}</h5>
        @else
            <h5> -------- </h5>
        @endif
        <span>Voter No: {{$voter_number}}</span>
        <!-- signeture chirman -->
        @if($election_chairman_signature && $election_chairman_signature !== 'null')
            <img class="voterot-sig" src="{{ url($election_chairman_signature)}}" alt="">
        @else
            <img class="voterot-sig" src="{{ url('images/no-image.jpg')}}" alt="" style="height:20px;">
        @endif

        <div class="voterot-sig-tex">
            <h5>{{$election_chairman}}</h5>
            <h6>Chairman</h6>
            <p>Election Board, BAFFA</p>
        </div>

    </div>
</div>


</body>
</html>




