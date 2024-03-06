@extends('layouts.app')


@section('page-title', __('View user profile'))
@section('page-heading', __('View user profile'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('View user profile')
    </li>
@stop

@section('content')

    @include('partials.messages')

    <div class="row">
        <div class="col-md-12">
            <div class="card-title">
                <h4>{{ $user->first_name }}'s Profile</h4>
            </div>
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('user.update.profile.show', $user) }}" class="btn btn-dark mb-3">Update profile
                        info</a>
                    <div class="row">
                        <div class="col-md-3">
                            <h5 class="text-muted">Father's Name</h5>
                            <p class="text-secondary">{{ $userProfile->father_name ?? 'Null' }}</p>
                        </div>
                        <div class="col-md-3">
                            <h5 class="text-muted">Mother's Name</h5>
                            <p class="text-secondary">{{ $userProfile->mother_name ?? 'Null' }}</p>
                        </div>
                        <div class="col-md-3">
                            <h5 class="text-muted">Emergancy Contact</h5>
                            <p class="text-secondary">{{ $userProfile->emergancy_contact ?? 'Null' }}</p>
                        </div>
                        <div class="col-md-3">
                            <h5 class="text-muted">Blood Group</h5>
                            <p class="text-secondary">{{ $userProfile->blood_group ?? 'Null' }}</p>
                        </div>
                        <div class="col-md-3">
                            <h5 class="text-muted">Last Education</h5>
                            <p class="text-secondary">{{ $userProfile->last_education ?? 'Null' }}</p>
                        </div>
                        <div class="col-md-3">
                            <h5 class="text-muted">Years of Experience</h5>
                            <p class="text-secondary">{{ $userProfile->years_of_experience ?? 'Null' }}</p>
                        </div>
                        <div class="col-md-3">
                            <h5 class="text-muted">Present Address</h5>
                            <p class="text-secondary">{{ $userProfile->present_address ?? 'Null' }}</p>
                        </div>
                        <div class="col-md-3">
                            <h5 class="text-muted">Permanent Address</h5>
                            <p class="text-secondary">{{ $userProfile->permanent_address ?? 'Null' }}</p>
                        </div>
                        <div class="col-md-3">
                            <h5 class="text-muted">Confirmation Date</h5>
                            <p class="text-secondary">{{ $userProfile->confirmation_date ?? 'Null' }}</p>
                        </div>
                        <div class="col-md-3">
                            <h5 class="text-muted">Joining Date</h5>
                            <p class="text-secondary">{{ $userProfile->joining_date ?? 'Null' }}</p>
                        </div>
                        <div class="col-md-3">
                            <h5 class="text-muted">Place of Posting</h5>
                            <p class="text-secondary">{{ $userProfile->place_of_posting ?? 'Null' }}</p>
                        </div>
                        <div class="col-md-3">
                            <h5 class="text-muted">Designation</h5>
                            <p class="text-secondary">{{ $userProfile->designation ?? 'Null' }}</p>
                        </div>
                        <div class="col-md-3">
                            <h5 class="text-muted">Date of Promotion</h5>
                            <p class="text-secondary">{{ $userProfile->date_of_promotion ?? 'Null' }}</p>
                        </div>
                        <div class="col-md-3">
                            <h5 class="text-muted">Job Status</h5>
                            <p class="text-secondary">{{ $userProfile->job_status ?? 'Null' }}</p>
                        </div>
                        <div class="col-md-3">
                            <h5 class="text-muted">Department</h5>
                            <p class="text-secondary">{{ DB::table('departments')->where('id', $userProfile->department_id)->first()->name ?? 'Null' }}
                            </p>
                        </div>
                    </div>

                </div>
            </div>


        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('user.update.profile.show', $user) }}" class="btn btn-dark mb-4">+ Add files</a>
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">File name</th>
                                        <th scope="col">File</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($images as $image)
                                        @php
                                            $fileName = $image->url;
                                            $fileNameParts = explode('.', $fileName);
                                            $ext = end($fileNameParts);
                                        @endphp

                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $image->name }}</td>
                                            <td>
                                                <img src="{{ $ext === 'pdf' ? asset('/public/images/pdf.png') : asset('/storage/uploads/user-profile/' . $image->url) }}"
                                                    alt="" height="60" width="60" class="rounded-circle"
                                                    style="object-fit: cover">
                                            </td>
                                            <td>
                                                <a href="{{ route('delete.file', [$user->id, $image->id]) }}"
                                                    class="mx-2">Delete</a>
                                                <a href="{{ route('download.file', [$user->id, $image->id]) }}"
                                                    class="mx-2">Download</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('user.update.profile.show', $user) }}" class="btn btn-dark mb-3">Update Salary
                        Info</a>
                    <h5>Gross Salary : {{ $salaryInfo->gross_salary ?? 'Null' }}</h5>
                    <fieldset class="border p-2 mt-2">
                        <legend class="w-auto" style="font-size: 18px">Rate of Pay</legend>
                        <div class="row">
                            <div class="col-md-3">
                                <h5 class="text-muted">Basic Salary</h5>
                                <p class="text-secondary">{{ $salaryInfo->basic_salary ?? 'Null' }}</p>
                            </div>
                            <div class="col-md-4">
                                <h5 class="text-muted">House Rent Allowance({{ $salaryInfo->house_rent_in_percent ?? '' }}%)
                                </h5>
                                <p class="text-secondary">{{ $salaryInfo->house_rent_allowance ?? 'Null' }}</p>
                            </div>
                            <div class="col-md-4">
                                <h5 class="text-muted">Medical
                                    Allowance({{ $salaryInfo->medical_allowance_in_percent ?? "" }}%)</h5>
                                <p class="text-secondary">{{ $salaryInfo->medical_allowance ?? 'Null' }}</p>
                            </div>
                            <div class="col-md-3">
                                <h5 class="text-muted">Conveyance({{ $salaryInfo->conveyance_in_percent ?? ""}}%)</h5>
                                <p class="text-secondary">{{ $salaryInfo->conveyance ?? 'Null' }}</p>
                            </div>
                            <div class="col-md-3">
                                <h5 class="text-muted">Others</h5>
                                <p class="text-secondary">{{ $salaryInfo->other_addition ?? 'Null' }}</p>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="border p-2 mt-2">
                        <legend class="w-auto" style="font-size: 18px">Deduction</legend>
                        <div class="row">
                            <div class="col-md-2">
                                <h5 class="text-muted">TDS(Tax)</h5>
                                <p class="text-secondary">{{ $salaryInfo->tds ?? 'Null' }}</p>
                            </div>
                            <div class="col-md-3">
                                <h5 class="text-muted">Provident Fund({{ $salaryInfo->provident_fund_in_percent ?? "" }}%)
                                </h5>
                                <p class="text-secondary">{{ $salaryInfo->provident_fund ?? 'Null' }}</p>
                            </div>
                            <div class="col-md-2">
                                <h5 class="text-muted">Others</h5>
                                <p class="text-secondary">{{ $salaryInfo->other_subtraction ?? 'Null' }}</p>
                            </div>
                        </div>
                    </fieldset>

                    <a href="{{ route('monthly.attendance', $user->id) }}" class="btn btn-primary mt-3"><i class="fas fa-money-bill"></i>Pay salary</a>
                </div>

            </div>
        </div>
    </div>



@stop

@section('scripts')

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
