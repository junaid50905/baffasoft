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
                            $profile_info = $user->userProfile;
                        @endphp

                        <form action="{{ route('user.update.profile', $user->id) }}" method="POST">
                            @csrf


                            @if ($profile_info)
                                <h4>Personal Information</h4>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Department</label>
                                        <select class="form-control" name="department_id">
                                            <option value="1"
                                                {{ $profile_info->department_id == '1' ? 'selected' : '' }}>Protocol &
                                                Public Relation</option>
                                            <option value="2"
                                                {{ $profile_info->department_id == '2' ? 'selected' : '' }}>Office Support
                                                Staff</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Place of Posting</label>
                                        <select class="form-control" name="place_of_posting">
                                            <option value="HSIA"
                                                {{ $profile_info->place_of_posting == 'HSIA' ? 'selected' : '' }}>HSIA
                                            </option>
                                            <option value="Headoffice, Dhaka"
                                                {{ $profile_info->place_of_posting == 'Headoffice, Dhaka' ? 'selected' : '' }}>
                                                Headoffice, Dhaka</option>
                                            <option value="Chattogram"
                                                {{ $profile_info->place_of_posting == 'Chattogram' ? 'selected' : '' }}>
                                                Chattogram</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Designation</label>
                                        <input type="text" name="designation" class="form-control"
                                            value="{{ $profile_info->designation }}" />
                                    </div>
                                    <div class="col-md-3">
                                        <label>Job Status</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="job_status" id="probation"
                                                value="probation"
                                                {{ $profile_info->job_status == 'probation' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="probation">
                                                Probation
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="job_status" id="permanent"
                                                value="permanent"
                                                {{ $profile_info->job_status == 'permanent' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="permanent">
                                                Permanent
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Joining Data</label>
                                        <input type="date" name="joining_date" class="form-control"
                                            value="{{ $profile_info->joining_date }}" />
                                    </div>
                                    <div class="col-md-3">
                                        <label>Confirmation Data</label>
                                        <input type="date" name="confirmation_date" class="form-control"
                                            value="{{ $profile_info->confirmation_date }}" />
                                    </div>
                                    <div class="col-md-3">
                                        <label>Father's Name</label>
                                        <input type="text" name="father_name" class="form-control"
                                            value="{{ $profile_info->father_name }}" />
                                    </div>
                                    <div class="col-md-3">
                                        <label>Mother's Name</label>
                                        <input type="text" name="mother_name" class="form-control"
                                            value="{{ $profile_info->mother_name }}" />
                                    </div>
                                    <div class="col-md-3">
                                        <label>Emergancy Contact</label>
                                        <input type="text" name="emergancy_contact" class="form-control"
                                            value="{{ $profile_info->emergancy_contact }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Blood Group</label>
                                        <input type="text" name="blood_group" class="form-control"
                                            value="{{ $profile_info->blood_group }}" />
                                    </div>
                                    <div class="col-md-3">
                                        <label>Last Education</label>
                                        <input type="text" name="last_education" class="form-control"
                                            value="{{ $profile_info->last_education }}" />
                                    </div>
                                    <div class="col-md-3">
                                        <label>Year of Experience</label>
                                        <input type="text" name="years_of_experience" class="form-control"
                                            value="{{ $profile_info->years_of_experience }}" />
                                    </div>
                                    <div class="col-md-6">
                                        <label>Present Address</label>
                                        <input type="text" name="present_address" class="form-control"
                                            value="{{ $profile_info->present_address }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Permanent Address</label>
                                        <input type="text" name="permanent_address" class="form-control"
                                            value="{{ $profile_info->permanent_address }}" />
                                    </div>
                                    <div class="col-md-6">
                                        <label>Date of Promotion</label>
                                        <textarea class="form-control" name="date_of_promotion" rows="3">{{ $profile_info->date_of_promotion }}</textarea>
                                    </div>
                                </div>
                            @else
                                <h4>Personal Information</h4>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Department</label>
                                        <select class="form-control" name="department_id">
                                            <option value="1">Protocol & Public Relation</option>
                                            <option value="2">Office Support Staff</option>
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
                                        <input type="text" name="designation" class="form-control" />
                                    </div>
                                    <div class="col-md-3">
                                        <label>Job Status</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="job_status"
                                                id="probation" value="probation">
                                            <label class="form-check-label" for="probation">
                                                Probation
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="job_status"
                                                id="permanent" value="permanent">
                                            <label class="form-check-label" for="permanent">
                                                Permanent
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Joining Data</label>
                                        <input type="date" name="joining_date" class="form-control" />
                                    </div>
                                    <div class="col-md-3">
                                        <label>Confirmation Data</label>
                                        <input type="date" name="confirmation_date" class="form-control" />
                                    </div>
                                    <div class="col-md-3">
                                        <label>Father's Name</label>
                                        <input type="text" name="father_name" class="form-control" />
                                    </div>
                                    <div class="col-md-3">
                                        <label>Mother's Name</label>
                                        <input type="text" name="mother_name" class="form-control" />
                                    </div>
                                    <div class="col-md-3">
                                        <label>Emergancy Contact</label>
                                        <input type="text" name="emergancy_contact" class="form-control" />
                                    </div>
                                    <div class="col-md-3">
                                        <label>Blood Group</label>
                                        <input type="text" name="blood_group" class="form-control" />
                                    </div>
                                    <div class="col-md-3">
                                        <label>Last Education</label>
                                        <input type="text" name="last_education" class="form-control" />
                                    </div>
                                    <div class="col-md-3">
                                        <label>Year of Experience</label>
                                        <input type="text" name="years_of_experience" class="form-control" />
                                    </div>
                                    <div class="col-md-6">
                                        <label>Present Address</label>
                                        <input type="text" name="present_address" class="form-control" />
                                    </div>
                                    <div class="col-md-6">
                                        <label>Permanent Address</label>
                                        <input type="text" name="permanent_address" class="form-control" />
                                    </div>
                                    <div class="col-md-6">
                                        <label>Date of Promotion</label>
                                        <textarea class="form-control" name="date_of_promotion" rows="3"></textarea>
                                    </div>
                                </div>
                            @endif

                            <button type="submit" class="btn btn-dark mt-2 w-100">Save</button>

                        </form>

                        <hr>

                        <div class="files my-3">
                            <h4>Upload essential files</h4>
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body card-block">
                                                @include('partials.messages')

                                                @if (Session::has('file_fields_required'))
                                                    <p class="text-danger">{{ Session('file_fields_required') }}</p>
                                                @endif

                                                <form action="{{ route('multiplefile.store', $user->id) }}"
                                                    method="post" enctype="multipart/form-data" class="form-horizontal">
                                                    @csrf

                                                    <div class="row form-group">
                                                        <div class="col-12 col-md-12">
                                                            <div class="control-group" id="fields">
                                                                <div class="controls">
                                                                    <div class="entry input-group upload-input-group">
                                                                        <input class="form-control" name="name[]"
                                                                            multiple type="text"
                                                                            placeholder="write something">
                                                                        <input class="form-control" name="url[]"
                                                                            multiple type="file" accept=".jpg,.pdf">
                                                                        <button class="btn btn-upload btn-success btn-add"
                                                                            type="button">
                                                                            <i class="fa fa-plus"></i>
                                                                        </button>
                                                                    </div>

                                                                </div>
                                                                <button class="btn btn-primary w-100"
                                                                    type="submit">Upload</button>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    @php
                        $userSalary = $user->salary;
                    @endphp


                    <form action="{{ route('salary.update', $user->id) }}" method="POST">
                        @csrf

                        <h4>Salary Information</h4>

                        @if ($userSalary)
                            <fieldset class="border p-2 mt-2">
                            <legend class="w-auto" style="font-size: 18px">Rate of Pay</legend>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group p-2">
                                        <label>Basic Salary</label>
                                        <input type="text" class="form-control" name="basic_salary"
                                            placeholder="Example: 24500" value="{{ $userSalary->basic_salary }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="">House Rent Allowance</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="house_rent_in_percent" value="{{ $userSalary->house_rent_in_percent }}">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">% of Basic Salary</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Medical Allowance</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="medical_allowance_in_percent" value="{{ $userSalary->medical_allowance_in_percent }}">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">% of Basic Salary</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Conveyance</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="conveyance_in_percent" value="{{ $userSalary->conveyance_in_percent }}">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">% of Basic Salary</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group p-2">
                                        <label>Other Additional Bill</label>
                                        <input type="text" class="form-control" name="other_addition" value="{{ $userSalary->other_addition }}">
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="border p-2 mt-2">
                            <legend class="w-auto" style="font-size: 18px">Deduction</legend>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group p-2">
                                        <label>TDS</label>
                                        <input type="text" class="form-control" name="tds" value="{{ $userSalary->tds }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Provident Fund</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="{{ $userSalary->provident_fund_in_percent }}" name="provident_fund_in_percent">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">% of Basic Salary</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Other Subtraction</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="other_subtraction" value="{{ $userSalary->other_subtraction }}">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        @else
                            <fieldset class="border p-2 mt-2">
                            <legend class="w-auto" style="font-size: 18px">Rate of Pay</legend>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group p-2">
                                        <label>Basic Salary</label>
                                        <input type="text" class="form-control" name="basic_salary"
                                            placeholder="Example: 24500">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="">House Rent Allowance</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="50"
                                            name="house_rent_in_percent">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">% of Basic Salary</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Medical Allowance</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="20"
                                            name="medical_allowance_in_percent">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">% of Basic Salary</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Conveyance</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="10" name="conveyance_in_percent">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">% of Basic Salary</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group p-2">
                                        <label>Other Additional Bill</label>
                                        <input type="text" class="form-control" name="other_addition">
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="border p-2 mt-2">
                            <legend class="w-auto" style="font-size: 18px">Deduction</legend>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group p-2">
                                        <label>TDS</label>
                                        <input type="text" class="form-control" name="tds">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Provident Fund</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="7" name="provident_fund_in_percent">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">% of Basic Salary</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Other Subtraction</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="other_subtraction">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        @endif


                        <button type="submit" class="btn btn-dark mt-2 w-100">Save</button>

                    </form>
                </div>
            </div>
        </div>

    </div>

@stop

@section('scripts')
    <script>
        $(function() {
            $(document).on('click', '.btn-add', function(e) {
                e.preventDefault();

                var controlForm = $('.controls:first'),
                    currentEntry = $(this).parents('.entry:first'),
                    newEntry = $(currentEntry.clone()).appendTo(controlForm);

                newEntry.find('input').val('');
                controlForm.find('.entry:not(:last) .btn-add')
                    .removeClass('btn-add').addClass('btn-remove')
                    .removeClass('btn-success').addClass('btn-danger')
                    .html('<span class="fa fa-trash"></span>');
            }).on('click', '.btn-remove', function(e) {
                $(this).parents('.entry:first').remove();

                e.preventDefault();
                return false;
            });
        });
    </script>


    {!! HTML::script('assets/js/as/btn.js') !!}
    {!! HTML::script('assets/js/as/profile.js') !!}
    {!! JsValidator::formRequest('Vanguard\Http\Requests\User\UpdateDetailsRequest', '#details-form') !!}
    {!! JsValidator::formRequest(
        'Vanguard\Http\Requests\User\UpdateProfileLoginDetailsRequest',
        '#login-details-form',
    ) !!}

    @if (setting('2fa.enabled'))
        {!! JsValidator::formRequest('Vanguard\Http\Requests\TwoFactor\EnableTwoFactorRequest', '#two-factor-form') !!}
    @endif
@stop
