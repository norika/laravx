@extends('admin.layouts.app')

@section('content')
    <div class="modal fade" id="addemployee" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form method="POST" action="{{ route('admin.employee.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addemployeeTitle">{{ __('admin/general.add_employee') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameWithTitle" class="form-label">{{ __('admin/general.name') }}</label>
                                <input type="text" name="name" id="nameWithTitle" class="form-control"
                                    placeholder="{{ __('admin/general.name') }}" />
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-0">
                                <label for="phone" class="form-label">{{ __('admin/general.phone') }}</label>
                                <input type="text" id="phone" class="form-control" name="phone"
                                    placeholder="{{ __('admin/general.phone') }}" />
                            </div>
                            <div class="col mb-3">
                                <label for="adress" class="form-label">{{ __('admin/general.address') }}</label>
                                <input type="text" id="adress" class="form-control" name="address"
                                    placeholder="{{ __('admin/general.address') }}" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameWithTitle" class="form-label">{{ __('admin/general.company') }}</label>
                                <select class="form-control" name="company_id">
                                    <option value="">{{ __('admin/general.selcompany') }}</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            {{ __('admin/general.close') }}
                        </button>
                        <button type="submit"
                            class="btn btn-primary create_employee">{{ __('admin/general.add_employee') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            {{ __('admin/general.employees') }} |
            <button type="button" class="btn rounded-pill btn-success" data-bs-toggle="modal"
                data-bs-target="#addemployee">{{ __('admin/general.add_employee') }}</button>
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
                <table id="tabled" class="display table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('admin/general.name') }}</th>
                            <th>{{ __('admin/general.company') }}</th>
                            <th>{{ __('admin/general.phone') }}</th>
                            <th>{{ __('admin/general.address') }}</th>
                            <th>{{ __('admin/general.process') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                            <tr class="result_wrap">
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $employee->name }}</td>
                                <td>
                                    @isset($employee->company->title)
                                        {{ $employee->company->title }}
                                    @endisset
                                </td>
                                <td>{{ $employee->phone }}</td>
                                <td>{{ $employee->address }}</td>
                                <td style="width:20%">
                                    <a href="{{ route('admin.employee.edit', $employee->id) }}"
                                        class="btn rounded-pill btn-primary">{{ __('admin/general.edit') }}</a>
                                    <button type="button" class="btn rounded-pill btn-danger delete"
                                        id="{{ $employee->id }}">{{ __('admin/general.del') }}</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    </div>
    {{ $employees->links('pagination::bootstrap-4') }}
</div>
@endsection

@section('footer')
<script>
    $(document).ready(function() {
        $('.delete').click(function() {
            if (confirm("{{ __('admin/general.aresure') }}")) {

                var itemID = $(this).attr('id');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('admin.employee.destroy', '') }}/" + itemID,
                    success: function() {}
                });

                $(this).parents(".result_wrap").animate({
                    backgroundColor: "#fbc7c7"
                }, "fast").animate({
                    opacity: "hide"
                }, "slow");
                return false;
            }
        });
    });
</script>
@endsection
