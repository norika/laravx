@extends('admin.layouts.app')

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ __('admin/general.industries') }} - <strong>{{ $industry->title }}</strong></h5>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="clear_ul">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (Session::has('result'))
                <div class="alert alert-success">{{ Session::get('result') }}</div>
            @endisset
            <form method="POST" enctype="multipart/form-data" action="{{ route('admin.industries.update', $industry) }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">{{ __('admin/general.indname') }}</label>
                    <input type="text" class="form-control" id="basic-default-fullname" name="title"
                        value="{{ $industry->title }}">
                </div>

                <button type="submit" class="btn btn-primary">{{ __('admin/general.save') }}</button>
            </form>
    </div>
</div>
@endsection
