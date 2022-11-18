@extends('admin.layouts.app')

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ __('admin/general.companies') }} - <strong>{{ $company->title }}</strong></h5>
        </div>
        <div class="card-body">
            <center>
                <img style="width:20%" src="{{ Storage::url('company/' . $company->logo) }}" alt="">
            </center>
            <div class="row">
                <div class="col col-12 col-lg-10 ">

                    <form method="POST" enctype="multipart/form-data"
                        action="{{ route('admin.company.update', $company) }}">
                        @method('PUT')
                        @csrf
                        <div class="mb-3">
                            <label class="form-label"
                                for="basic-default-fullname">{{ __('admin/general.company_name') }}</label>
                            <input type="text" class="form-control" id="basic-default-fullname" name="title"
                                value="{{ $company->title }}">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">{{ __('admin/general.logo') }}</label>
                            <input type="file" id="file" class="form-control" name="logo" />
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <label for="">{{ __('admin/general.industries') }}</label>
                                        <hr>
                                        @foreach ($industries as $industry)
                                            <div class="form-check inline">
                                                <input class="form-check-input"
                                                    {{ in_array($industry->id, $company->industry->pluck('id')->toArray()) ? 'checked' : '' }}
                                                    type="checkbox" name="industry[]" value="{{ $industry->id }}"
                                                    id="check{{ $industry->id }}">
                                                <label class="form-check-label" for="check{{ $industry->id }}">
                                                    {{ $industry->title }}
                                                </label>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-message">{{ __('admin/general.desc') }}</label>
                            <textarea id="basic-default-message" name="description" class="form-control">{{ $company->description }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('admin/general.save') }}</button>
                    </form>

                </div>
                <div class="col col-12 col-lg-2">
                    <div class="divider">
                        <div class="divider-text">{{ __('admin/general.employees') }}</div>
                        <ul class="clear_ul mt-2">
                            @foreach ($company->employee as $employee)
                                <li>{{ $employee->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
