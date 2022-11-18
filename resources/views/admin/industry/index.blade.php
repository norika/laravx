@extends('admin.layouts.app')

@section('content')
    <div class="modal fade" id="addindustry" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form method="POST" action="{{ route('admin.industries.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addindustryTitle">{{ __('admin/general.add_industry') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameWithTitle" class="form-label">{{ __('admin/general.indname') }}</label>
                                <input type="text" name="title" id="nameWithTitle" class="form-control"
                                    placeholder="{{ __('admin/general.indname') }}" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            {{ __('admin/general.close') }}
                        </button>
                        <button type="submit" class="btn btn-primary">{{ __('admin/general.add_industry') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            {{ __('admin/general.industries') }} |
            <button type="button" class="btn rounded-pill btn-success" data-bs-toggle="modal"
                data-bs-target="#addindustry">{{ __('admin/general.add_industry') }}</button>
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
                            <th>{{ __('admin/general.indname') }}</th>
                            <th>{{ __('admin/general.process') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($industries as $industry)
                            <tr class="result_wrap">
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $industry->title }}</td>
                                <td style="width:20%">
                                    <a href="{{ route('admin.industries.edit', $industry->id) }}"
                                        class="btn rounded-pill btn-primary">{{ __('admin/general.edit') }}</a>
                                    <button type="button" class="btn rounded-pill btn-danger delete"
                                        id="{{ $industry->id }}">{{ __('admin/general.del') }}</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    </div>
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
                    url: "{{ route('admin.industries.destroy', '') }}/" + itemID,
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
