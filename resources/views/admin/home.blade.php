@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-4 col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <span class="fw-semibold d-block mb-1">{{ __('admin/general.companies') }}</span>
                    <h3 class="card-title mb-2">{{ $company }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <span class="fw-semibold d-block mb-1">{{ __('admin/general.employees') }}</span>
                    <h3 class="card-title mb-2">{{ $employee }}</h3>
                </div>
            </div>

        </div>
        <div class="col-lg-4 col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <span class="fw-semibold d-block mb-1">{{ __('admin/general.industries') }}</span>
                    <h3 class="card-title mb-2">{{ $industry }}</h3>
                </div>
            </div>

        </div>
    </div>
@endsection
