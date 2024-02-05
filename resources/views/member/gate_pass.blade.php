@extends('layouts.front')

@section('page-title', trans('Member Gate Pass'))

@section('content')
{!! HTML::style('front/assets/css/style.css') !!}
<div class="row mt-4">
    <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="card z-index-2">
            <div class="card-body p-3">
                <main>
                    <div class="container chklist-form">
                        <div class="box1 pt-4">
                            <div class="d-flex logo">
                                <img src="{{url('front/assets/img/gate_pass/biman-logo.jpg')}}" alt="">
                                <div class="d-flex flex-column">
                                    <p id="top-right">Form No. 9-28-172</p>
                                    <div class="d-flex bar-code">
                                        <img src="{{url('front/assets/img/gate_pass/bar-code.jpg')}}" alt="">
                                        <p>19050600891</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <p class="text-center form-name">CARGO ACCEPTANCE CHECKLIST</p>
                        <div class="box2">
                            <p id="item-one">A. CONSIGNMENT BOOKING DETAILS : </p>
                            <form class="needs-validation" novalidate>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="d-flex input1">
                                            <label for="validationCustom01" id="item-1">Master Airway bill
                                                No.</label>
                                            <input type="text" class="form-control" id="validationCustom01" placeholder="" value="" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-3">
                                        <div class="d-flex">
                                            <label for="validationCustom01" id="item-2">Contents</label>
                                            <input type="text" class="form-control" id="validationCustom01" placeholder="" value="" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex">
                                            <label for="validationCustom01" id="item-3">Weight(approx)</label>
                                            <input type="text" class="form-control" id="validationCustom01" placeholder="" value="" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="d-flex input1">
                                            <label for="validationCustom01" id="item-4">Flight No/Date</label>
                                            <input type="text" class="form-control" id="validationCustom01" placeholder="" value="" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex">
                                            <label for="validationCustom01" id="item-5">Destination</label>
                                            <input type="text" class="form-control" id="validationCustom01" placeholder="" value="" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="d-flex">
                                            <label for="validationCustom01" id="item-6">Routing</label>
                                            <input type="text" class="form-control" id="validationCustom01" placeholder="" value="" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="d-flex">
                                            <label for="validationCustom05" id="item-7">Name of
                                                Shipper/Exporter/Forwarding agent
                                            </label>
                                            <input type="text" class="form-control" id="validationCustom05" placeholder="" required>
                                            <div class="invalid-feedback">
                                                Please provide a valid .
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <div class="d-flex">
                                            <label for="validationCustom05" id="item-8">Shipper’s Invoice
                                                No:</label>
                                            <input type="text" class="form-control" id="validationCustom05" placeholder="" required>
                                            <div class="invalid-feedback">
                                                Please provide a valid .
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="d-flex">
                                            <label for="validationCustom05" id="item-9">Date </label>
                                            <input type="text" class="form-control" id="validationCustom05" placeholder="" required>
                                            <div class="invalid-feedback">
                                                Please provide a valid .
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                            <div class="box2">
                                <div class="d-flex">
                                    <p class="text1">Cargo bound for (Tick the appropriate box):</p>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td>EU</td>
                                                    <td><i class="fas fa-check"></i> USA</td>
                                                    <td>OTHERS</td>

                                                </tr>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="box3 pt-4">
                                <div class="d-flex">
                                    <p>B. CARGO SECURITY DECLARATION BY SHIPPER/AGENT: </p>
                                    <p class="text3">Signature & seal of Airline Representative</p>
                                </div>
                            </div>
                            <div class="box4">
                                <p class="text4"><i>On behav of
                                        <input> I, the undersigned, hereby declare that the contents of this
                                        consignment do not
                                        contain
                                        any prohibited or illicit items and I am satisfied that the contents are as
                                        stated and safe
                                        for air carriage. The goods have been secured and protected during all
                                        stages of storage and
                                        transportation. I understand that a false declaration could lead to legal
                                        action being
                                        taken.</i>
                                </p>
                                <p class="text5">Signature<input>Date<input></p>
                                <p class="text6">Name (Shipper/Agent)<input>ID No.<input></p>
                            </div>
                            <div class="box5 pt-3">
                                <div class="d-flex">
                                    <p>C. VIHICLE ENRTY PASS:</p>
                                    <p>Vehicle No. <input> Date of entry: <input> Time of entry <input></p>

                                </div>
                            </div>
                            <div class="box6">
                                <div class="d-flex">
                                    <p>Signature & seal of GHA Representative</p>
                                    <p>Signature of Biman Security Official </p>
                                </div>
                            </div>
                            <div class="box7">
                                <p class="text7">D. ACCEPTENCE OF CARGO</p>
                                <div class="d-flex">
                                    <p>a)Accepted as (Tick one)</p>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td><i class="fas fa-check"></i> Unknown</td>
                                                    <td>Exempted</td>
                                                    <td>Transfer</td>
                                                    <td>COMAT/MAIL</td>
                                                </tr>
                                            </tbody>

                                        </table>
                                    </div>

                                </div>
                            </div>
                            <div class="box8">
                                <div class="d-flex">
                                    <p>b) Special cargo (if any) </p>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td>Over Size</td>
                                                    <td>Live Animal</td>
                                                    <td>Human Remains</td>
                                                    <td>COMAT/MAIL</td>
                                                    <td>DG</td>
                                                    <td>Personal Effects</td>
                                                </tr>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>


                            </div>
                            <div class="box9">
                                <p class="text8">c) Visual Inspection of Consignment During Acceptance:</p>
                                <div class="pl-4">
                                    <p>There is no items/packages of consignment that is:</p>
                                    <p>i. significantly damaged, or</p>
                                    <p>ii. showing evidence of tempering, or</p>
                                    <p>iii. with hole, or</p>
                                    <p>iv. Boxed/packed with extra jacket;
                                        to a degree which could have allowed the introduction of a prohibited
                                        article.
                                    </p>
                                </div>

                            </div>
                            <div class="box10">
                                <p class="text10">d) Description of consignments</p>
                                <p class="text11">No. of pieces<input>Gross Weight<input></p>
                                <p class="text12">Dimension
                                    (i)<input>(ii)<input>(iii)<input></p>
                                <p class="text13">
                                    (iv)<input>(V)<input>(Vi)<input></p>
                                <p class="text14">Volumetric Weight of Entire Goods<input>CBM<input>Chargeable
                                    Weight<input></p>
                                <p class="text15">Date/Time of Weight Taken<input></p>
                            </div>
                            <div class="bottom-sign">
                                <div class="d-flex">
                                    <div class="d-flex flex-column">
                                        <input>
                                        <p>Signature of Shipper/Agent/Airline<br>
                                            Representative with Name and ID No.</p>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <input>
                                        <p>Signature of Acceptance Staff with<br> Name and Staff No.<input></p>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <input>
                                        <p>Signature of Security personnel with<br> Name and Staff No.<input></p>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <input>
                                        <p>Signature of Duty Officer with<br>
                                            Name and Staff No.<input></p>
                                    </div>
                                </div>
                            </div>
                            <div class="box11">
                                <div class="d-flex">
                                    <p class="text16"><i>Distribution: Copy-1 Biman, Copy-2 CAAB, Copy-3 Agent,
                                            Copy-4 Shipper.</i>
                                    </p>
                                    <p class="text17"><i>Printed at: Biman Ptg. & Pub.</i></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>

            </div>
        </div>
    </div>
</div>

@stop
