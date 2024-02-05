<!DOCTYPE html>
<html>
<head>
    <title>MONEY RECEIPT - baffa-bd.org</title>
    <link rel="stylesheet" href="{{ url('front/assets/money-collection-print/style.css')}}">
</head>
<style type="text/css">
</style>
<body>
<div class="head-title text-center">
    <div class="header-mony">
        <div class="logo-recid">
            <img src="{{ url('front/assets/money-collection-print/baffa-logo.png')}}" alt=""></div>
        <div class="sl-number"><p>Sl. No.</p> <span>{{$money_collection->voucher_no}}</span></div>
    </div>
    <div class="header-2nd">
        <h2>Bangladesh Freight Forwarders Association</h2>
        <p><b>Dhaka Office:</b> House No. 10 (Level-2 & 3), Road No. 17A, Block-E, Banani, Dhaka-1213, Tel: +88
            028836374-25,
            07222281663, Fax: +88 02222281664, Email Info@baffa-bd.org<br>
            <b>Chattogram Office:</b> Anwar Trade Center
            (Level-10), 1728 Agrabad C/A, Chattogram, Tel: +88 02333323453, 333373505, 333326519, Ermall:
            admin.ctg@baffa-bd.org
        </p>
    </div>
</div>


<div id="fast-tb">
    <table class="tablet-st">
        <?php
        $check_date = '';
        if ($money_collection->payment_type != 'Cash' && $money_collection->payment_chq_date)
            $check_date = date('d.m.y', strtotime($money_collection->payment_chq_date));
        $training_date = strtotime($money_collection->transaction_date);
        $day = date('d', $training_date);
        $month = date('m', $training_date);
        $year = date('Y', $training_date);
        ?>
        <tr>
            <td style="width: 200px;"><p class="cls5">MONEY RECEIPT</p></td>
            <td style="padding-left:20px;"><p class="cls6"> {{substr($day, 0, 1)}} </p></td>
            <td><p class="cls6"> {{substr($day, 1, 1)}} </p></td>
            <td style="padding-left: 10px"><p class="cls6"> {{substr($month, 0, 1)}} </p></td>
            <td><p class="cls6"> {{substr($month, 1, 1)}} </p></td>
            <td style="padding-left: 10px"><p class="cls6"> {{substr($year, 0, 1)}} </p></td>
            <td><p class="cls6"> {{substr($year, 1, 1)}} </p></td>
            <td><p class="cls6"> {{substr($year, 2, 1)}} </p></td>
            <td><p class="cls6"> {{substr($year, 3, 1)}} </p></td>

        </tr>

    </table>
</div>


<div class="tab-stt">

    <table width="600" class="ar-table">
        <tr>
            <td style="width: 464px;"></td>
            <td class="bod-lef boder2"><b>TAKA</b></td>
        </tr>
        <tr>
            <td>
                <div class="u-line"><span class="in_lin">Received frome</span> {{$organization_name}}</div>
                <div class="u-line"><span
                        class="in_lin">In Payment of </span> {{$money_collection->receipt_description}} </div>
            </td>
            <td valign="top" class="bod-lef boder2">
                <div class="taka-box">  {{$money_collection->amount}}</div>
            </td>
        </tr>

        <tr>
            <td align="right">TOTAL TAKA</td>
            <td align="center" class="eqal">{{$money_collection->amount}}  </td>
        </tr>
        @php($digit = new \NumberFormatter("en", NumberFormatter::SPELLOUT))
        <tr>
            <td colspan="2" class="eqal">
                <div class="u-line"><span
                        class="in_lin">Taka (in word) </span> {{strtoupper($digit->format($money_collection->amount))}}
                </div>
            </td>
        </tr>
    </table>
</div>

<!-- 2nd part -->


<div class="mt-10 last-sec">
    <table class="table mt-30">
        <tr>
            <td style="width:115px;"> Mode of receipt :</td>
            <td colspan="3"
                style="width:200px; border-bottom: 1px solid #ccc;"> {{$money_collection->payment_type}}  </td>
        </tr>
        <tr>
            <td>PO/D.D/Chq. No.</td>
            <td style="width:300px; border-bottom: 1px solid #ccc;">   {{$money_collection->payment_chq_no}} </td>
            <td>Date:</td>
            <td style="border-bottom: 1px solid #ccc; width:158px;">{{$check_date}}</td>
        </tr>
        <tr>
            <td>Bank</td>
            <td colspan="2" style="border-bottom:1px solid #ccc; "> {{$money_collection->payment_bank}} </td>
        </tr>
        <tr>
            <td colspan="3" style=" vertical-align: bottom;">Cheque acknowledge subject to realization</td>
            <td align="center" style="border-bottom:1px solid #ccc;"></td>
        </tr>
        <tr>
            <td colspan="3"></td>

            <td align="center"> Authorised Signature</td>
        </tr>

    </table>
</div>

<div class="foot-color"></div>
</html>
