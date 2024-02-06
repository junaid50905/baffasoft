@extends('layouts.app')

@section('page-title', __('Update user profile'))
@section('page-heading', __('Update user profile'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('Update user profile')
    </li>
@stop

@section('content')

@include('partials.messages')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="form-group">

                    @php
                        $profile_info = $user->userProfile
                    @endphp

                    <form action="{{ route('user.update.profile', $user->id) }}" method="POST">
                    @csrf


                    @if ($profile_info)
                    <div class="row">
                        <div class="col-md-3">
                            <label>Department</label>
                            <select class="form-control" name="department_id">
                                <option value="1" {{ $profile_info->department_id == '1' ? 'selected' : '' }}>Protocol & Public Relation</option>
                                <option value="2" {{ $profile_info->department_id == '2' ? 'selected' : '' }}>Office Support Staff</option>
                                <option value="3" {{ $profile_info->department_id == '3' ? 'selected' : '' }}>Courier</option>
                                <option value="4" {{ $profile_info->department_id == '4' ? 'selected' : '' }}>Operation and Customer Care</option>
                                <option value="5" {{ $profile_info->department_id == '5' ? 'selected' : '' }}>Commercial</option>
                                <option value="6" {{ $profile_info->department_id == '6' ? 'selected' : '' }}>Accounts</option>
                                <option value="7" {{ $profile_info->department_id == '7' ? 'selected' : '' }}>HR & Admin</option>
                                <option value="8" {{ $profile_info->department_id == '8' ? 'selected' : '' }}>Aviation</option>
                                <option value="9" {{ $profile_info->department_id == '9' ? 'selected' : '' }}>Enginnering</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Place of Posting</label>
                            <select class="form-control" name="place_of_posting">
                                <option value="HSIA" {{ $profile_info->place_of_posting == 'HSIA' ? 'selected' : '' }}>HSIA</option>
                                <option value="Headoffice, Dhaka" {{ $profile_info->place_of_posting == 'Headoffice, Dhaka' ? 'selected' : '' }}>Headoffice, Dhaka</option>
                                <option value="Chattogram" {{ $profile_info->place_of_posting == 'Chattogram' ? 'selected' : '' }}>Chattogram</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Designation</label>
                            <input type="text" name="designation" class="form-control" value="{{ $profile_info->designation }}"/>
                        </div>
                        <div class="col-md-3">
                            <label>Job Status</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="job_status" id="probation" value="probation" {{ $profile_info->job_status == 'probation' ? 'checked' : '' }}>
                                <label class="form-check-label" for="probation">
                                    Probation
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="job_status" id="permanent" value="permanent" {{ $profile_info->job_status == 'permanent' ? 'checked' : '' }}>
                                <label class="form-check-label" for="permanent">
                                    Permanent
                                </label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label>Joining Data</label>
                            <input type="date" name="joining_date" class="form-control" value="{{ $profile_info->joining_date }}"/>
                        </div>
                        <div class="col-md-3">
                            <label>Confirmation Data</label>
                            <input type="date" name="confirmation_date" class="form-control" value="{{ $profile_info->confirmation_date }}"/>
                        </div>
                        <div class="col-md-3">
                            <label>Father's Name</label>
                            <input type="text" name="father_name" class="form-control" value="{{ $profile_info->father_name }}"/>
                        </div>
                        <div class="col-md-3">
                            <label>Mother's Name</label>
                            <input type="text" name="mother_name" class="form-control" value="{{ $profile_info->mother_name }}"/>
                        </div>
                        <div class="col-md-3">
                            <label>Emergancy Contact</label>
                            <input type="text" name="emergancy_contact" class="form-control" value="{{ $profile_info->emergancy_contact }}">
                        </div>
                        <div class="col-md-3">
                            <label>Blood Group</label>
                            <input type="text" name="blood_group" class="form-control" value="{{ $profile_info->blood_group }}"/>
                        </div>
                        <div class="col-md-3">
                            <label>Last Education</label>
                            <input type="text" name="last_education" class="form-control" value="{{ $profile_info->last_education }}"/>
                        </div>
                        <div class="col-md-3">
                            <label>Year of Experience</label>
                            <input type="text" name="years_of_experience" class="form-control" value="{{ $profile_info->years_of_experience }}"/>
                        </div>
                        <div class="col-md-6">
                            <label>Present Address</label>
                            <input type="text" name="present_address" class="form-control" value="{{ $profile_info->present_address }}">
                        </div>
                        <div class="col-md-6">
                            <label>Permanent Address</label>
                            <input type="text" name="permanent_address" class="form-control" value="{{ $profile_info->permanent_address }}"/>
                        </div>
                        <div class="col-md-6">
                            <label>Date of Promotion</label>
                            <textarea class="form-control" name="date_of_promotion" rows="3">{{ $profile_info->date_of_promotion }}</textarea>
                        </div>
                    </div>
                    @else
                    <div class="row">
                        <div class="col-md-3">
                            <label>Department</label>
                            <select class="form-control" name="department_id">
                                <option value="1">Protocol & Public Relation</option>
                                <option value="2">Office Support Staff</option>
                                <option value="3">Courier</option>
                                <option value="4">Operation and Customer Care</option>
                                <option value="5">Commercial</option>
                                <option value="6">Accounts</option>
                                <option value="7">HR & Admin</option>
                                <option value="8">Aviation</option>
                                <option value="9">Enginnering</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Place of Posting</label>
                            <select class="form-control" name="place_of_posting">
                                <option value="HSIA">HSIA</option>
                                <option value="Headoffice, Dhaka">Headoffice, Dhaka</option>
                                <option value="Chattogram">Chattogram</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Designation</label>
                            <input type="text" name="designation" class="form-control"/>
                        </div>
                        <div class="col-md-3">
                            <label>Job Status</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="job_status" id="probation" value="probation">
                                <label class="form-check-label" for="probation">
                                    Probation
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="job_status" id="permanent" value="permanent">
                                <label class="form-check-label" for="permanent">
                                    Permanent
                                </label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label>Joining Data</label>
                            <input type="date" name="joining_date" class="form-control"/>
                        </div>
                        <div class="col-md-3">
                            <label>Confirmation Data</label>
                            <input type="date" name="confirmation_date" class="form-control" />
                        </div>
                        <div class="col-md-3">
                            <label>Father's Name</label>
                            <input type="text" name="father_name" class="form-control"/>
                        </div>
                        <div class="col-md-3">
                            <label>Mother's Name</label>
                            <input type="text" name="mother_name" class="form-control"/>
                        </div>
                        <div class="col-md-3">
                            <label>Emergancy Contact</label>
                            <input type="text" name="emergancy_contact" class="form-control"/>
                        </div>
                        <div class="col-md-3">
                            <label>Blood Group</label>
                            <input type="text" name="blood_group" class="form-control"/>
                        </div>
                        <div class="col-md-3">
                            <label>Last Education</label>
                            <input type="text" name="last_education" class="form-control"/>
                        </div>
                        <div class="col-md-3">
                            <label>Year of Experience</label>
                            <input type="text" name="years_of_experience" class="form-control"/>
                        </div>
                        <div class="col-md-6">
                            <label>Present Address</label>
                            <input type="text" name="present_address" class="form-control"/>
                        </div>
                        <div class="col-md-6">
                            <label>Permanent Address</label>
                            <input type="text" name="permanent_address" class="form-control"/>
                        </div>
                        <div class="col-md-6">
                            <label>Date of Promotion</label>
                            <textarea class="form-control" name="date_of_promotion" rows="3"></textarea>
                        </div>
                    </div>
                    @endif

                    <button type="submit" class="btn btn-dark mt-2">Save</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

@stop

@section('scripts')
    {!! HTML::script('assets/js/as/btn.js') !!}
    {!! HTML::script('assets/js/as/profile.js') !!}
    {!! JsValidator::formRequest('Vanguard\Http\Requests\User\UpdateDetailsRequest', '#details-form') !!}
    {!! JsValidator::formRequest('Vanguard\Http\Requests\User\UpdateProfileLoginDetailsRequest', '#login-details-form') !!}

    @if (setting('2fa.enabled'))
        {!! JsValidator::formRequest('Vanguard\Http\Requests\TwoFactor\EnableTwoFactorRequest', '#two-factor-form') !!}
    @endif
@stop