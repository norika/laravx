@extends('admin.layouts.app')

@section('content')
    <div class="modal fade" id="addemployee" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form method="POST" enctype="multipart/form-data" action="{{ route('admin.company.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addemployeeTitle">{{ __('admin/general.add_company') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameWithTitle" class="form-label">{{ __('admin/general.company_name') }}</label>
                                <input type="text" id="nameWithTitle" class="form-control" name="title"
                                    placeholder="{{ __('admin/general.company_name') }}" />
                            </div>
                            <div class="col mb-0">
                                <label for="phone" class="form-label">{{ __('admin/general.logo') }}</label>
                                <input type="file" id="file" class="form-control" name="logo" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <label for="">{{ __('admin/general.industries') }}</label>
                                        <hr>
                                        @foreach ($industries as $industry)
                                            <div class="form-check inline">
                                                <input class="form-check-input" name="industry[]" type="checkbox"
                                                    value="{{ $industry->id }}" id="check{{ $industry->id }}">
                                                <label class="form-check-label" for="check{{ $industry->id }}">
                                                    {{ $industry->title }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-0">
                                <label class="form-label">{{ __('admin/general.desc') }}</label>
                                <textarea class="form-control" name="description" placeholder="{{ __('admin/general.desc') }}" /></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            {{ __('admin/general.close') }}
                        </button>
                        <button type="submit"
                            class="btn btn-primary create_employee">{{ __('admin/general.add_company') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            {{ __('admin/general.companies') }} |
            <button type="button" class="btn rounded-pill btn-success" data-bs-toggle="modal"
                data-bs-target="#addemployee">{{ __('admin/general.add_company') }}</button>
        </div>
    </div>
    <div class="card">
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
            <div class="table-responsive text-nowrap">
                <table id="datatable" class="display table table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('admin/general.company_name') }}</th>
                            <th>{{ __('admin/general.desc') }}</th>
                            <th>{{ __('admin/general.logo') }}</th>
                            <th>{{ __('admin/general.process') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
    </div>
</div>
@endsection

@section('footer')
<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            serverSide: true,
            processing: true,
            ajax: "{{ route('admin.companyAjaxPaginate') }}",
            columns: [{
                    data: 'title'
                },
                {
                    data: 'description'
                },
                {
                    data: 'logo'
                },
                {
                    data: 'process',
                    name: 'process',
                    orderable: false,
                    searchable: false
                }
            ],
            "fnDrawCallback": function(oSettings) {
                $('.delete').click(function() {
                    if (confirm("{{ __('admin/general.aresure') }}")) {
                        var itemID = $(this).attr('id');
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            }
                        });
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('admin.company.destroy', '') }}/" +
                                itemID,
                            success: function() {}
                        });

                        $(this).parents("tr").animate({
                            backgroundColor: "#fbc7c7"
                        }, "fast").animate({
                            opacity: "hide"
                        }, "slow");
                        return false;
                    }
                });
            }
        });


    });
</script>
@endsection
