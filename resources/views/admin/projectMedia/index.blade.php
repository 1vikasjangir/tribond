@extends('layouts.admin')
<!-- partial -->

@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-5 pb-3 mb-3 heading_header">
        <div class="left">
            <h1 class="h2">Media Management</h1>
            <ul>
                <li>
                    <a href="{{ route('dashboard') }}">Dashboard</a> <span>>></span>
                </li>
                <li>
                    <a href="{{ route('projects.index') }}">Project</a> <span>>></span>
                </li>
                <li>Media Management</li>
            </ul>
        </div>
        <div class="right">
            <a href="{{ route('projects.index') }}" class="btn btn-primary create_new">Back</a>
            <button class="accordion-button collapsed mobile_view" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                <i class="fas fa-filter"></i>
            </button>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <x-admin.alert type="success" :message="$message" class="alert alert-success alert-dismissible" />
    @endif
    @if ($message = Session::get('error'))
        <x-admin.alert type="error" :message="$message" class="alert alert-danger alert-dismissible" />
    @endif

    <!-- filter -->
    <div class="accordion filter" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button collapsed desktop_view" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    Advance Filter
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse filter_tab" aria-labelledby="headingOne"
                data-bs-parent="#accordionExample" style="">
                <div class="filter_card">
                    <div class="accordion-body">
                        <button class="accordion-button mobile_view collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            <i class="fas fa-times"></i>
                        </button>
                        <form autocomplete="off" id="project-media-filters" action="{{ route('projectmedia.get', ['id' => $projects->id]) }}" method="POST">
                            @csrf
                            @method('GET')
                            <div class="row">
                                <div class="col-md-3 col-lg-3 col-xl-3 col-sm-3">
                                    <div class="form-group">
                                       <input type="text" value="{{ Request::get('created_date') }}"
                                       name="created_date" id="created_date" class="form-control" placeholder="Created Date" onfocus="(this.type='date')" >
                                    </div>
                                </div>

                                <div class="col-md-3 col-lg-3 col-xl-3 col-sm-3">
                                    <div class="form-group">
                                        <select name="status" class="form-select p-2">
                                            <option value=""> Select Status</option>
                                            <option {{ Request::get('status') == '1' ? 'selected' : '' }} value="1">
                                                Active</option>
                                            <option {{ Request::get('status') == '0' ? 'selected' : '' }} value="0">
                                                Inactive</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <button class="btn btn-primary">Search</button>
                                    <a href="{{ route('projectmedia.get', ['id' => $projects->id]) }}" class="btn btn-dark">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end filter -->

    <!-- partial -->
    <div class="sub-container">
        <div class="d-flex justify-content-between mb-3 mt-5">
            <h3>Media</h3>
        </div>
        @if ($projectMedias->count() < 3)
            <div class="row gy-3 mt-2 mb-2 px-3">
                <form action="{{ route('projectmedia.save', ['id' => $projects->id]) }}" method="post" class="form-inline"
                    enctype="multipart/form-data" id="formValidation">
                    @csrf
                    <div class="row">

                        <div class="col-md-6 form-group">
                            <div class="image">
                                <label for="floatingInput" class="fw-bold">Image<span
                                        class="text-danger fs-5 fw-bold">*</span></label>
                                <input type="file" name="image[]" class="form-control mt-3" accept="image/*" multiple>
                                @error('image')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3 mt-5">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>

                </form>
            </div>
        @endif

        <div class="row mt-5">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered border-light text-center">
                    <thead>
                        <tr class="table-dark">
                            <th class="text-center">S.No.</th>
                            <th class="text-start">Project</th>
                            <th class="text-center">Gallery Images</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($projectMedias as $media)
                            <tr>
                                <td> {{ $projectMedias->firstItem() + $loop->index }}</td>

                                <td class="text-start">{{ optional($media->projects)->title }}</td>

                                <td><img src="{{ $media->image }}" width="100px"
                                        height="100px" alt="img"></td>
                                <td> {{ $media->created_at->format('d-m-Y') }}</td>
                                <td>
                                    <a href="javascript:;" data-id="{{ $media->id }}" class="change-status-btn">
                                        <i id="active_{{ $media->id }}" style="display:{{ $media->status == '1' ? 'block' : 'none'}};" class="far fa-circle-check md-24 text-success" data-toggle="tooltip" title="Active"></i>
                                        <i id="deactive_{{ $media->id }}" style="display:{{ $media->status == '0' ? 'block' : 'none'}};" class="far fa-times-circle md-24 text-danger" data-toggle="tooltip" title="Deactive"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="javascript:;" data-id="{{ $media->id }}" id="delete_{{ $media->id }}" class="change-delete-btn">
                                        <i class="fas fa-trash md-24 text-danger" data-toggle="tooltip"
                                            title="Delete"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr id="noData"><td colspan="8">No Record Found</td></tr>
                        @endforelse
                        <tr id="noDataFound" style="display: none;"><td colspan="8"></td></tr>
                    </tbody>
                </table>
                {{-- Pagination --}}
                @if (!$projectMedias->isEmpty())
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-5">
                        <div class="left">
                            Showing {{ $projectMedias->firstItem() }} to {{ $projectMedias->lastItem() }} of {{ $projectMedias->total() }} entries
                        </div>
                        <div class="right">
                            {{ $projectMedias->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <!-- script -->
    <script>
        /* Delete record using ajax */
        $(document).on('click','.change-delete-btn',function(){
            if (confirm('Are you sure to delete this item?')) {
                var rowObj = $(this).parents('tr');
                var media_id = $(this).data('id');
                let _token = "{{ csrf_token() }}";

                $.ajax({
                    url     : "{{route('projectmedia.delete')}}",
                    type    : 'POST',
                    dataType   : 'json',
                    data : {
                        'media_id': media_id,
                        '_token': _token
                    },
                    success: function (data) {
                        if(data.status){
                            var siblings = rowObj.siblings();
                            // var abc = Object.values(siblings);
                            rowObj.remove();
                            siblings.each(function(index) {
                                $(this).children('td').first().text(index + 1);
                            });
                            $("#alert").css('opacity', '1').html(data.success).fadeIn(2000).fadeOut(4000);
                            var rowCount = $('#example tbody tr').length;
                            if (rowCount == 1) {
                                $('#example tbody tr#noDataFound').show()
                                $('#example tbody tr#noDataFound td').text('No Record Found')
                            }
                        }
                    },
                });
            }
        });

        /**** Change status using ajax ****/
        $(document).on('click','.change-status-btn',function(){
            if (confirm('Are you sure you want to change status?')) {
                var media_id = $(this).data('id');
                let _token = "{{ csrf_token() }}";

                $.ajax({
                    url     : "{{route('projectmedia.status')}}",
                    type    : 'POST',
                    dataType   : 'json',
                    data : {
                        'media_id': media_id,
                        '_token': _token
                    },
                    success: function (data) {
                        // alert(data)
                        if(data.status == "1"){
                            // Code in the case checkbox is checked.
                            $('#active_'+media_id).show()
                            $('#deactive_'+media_id).hide()
                            $("#alert").css('opacity', '1').html(data.success).fadeIn(2000).fadeOut(4000);
                        } else {
                            // Code in the case checkbox is NOT checked.
                            $('#deactive_'+media_id).show()
                            $('#active_'+media_id).hide()
                            $("#alert").css('opacity', '1').html(data.success).fadeIn(2000).fadeOut(4000);
                        }
                    },
                });
            }
        });
        $(document).ready(function() {
            /**** Client side validation ****/
            $('#formValidation').validate({
                rules: {
                    'image[]': {
                        required: true,
                        accept: "image/*",
                        filesize : 2,
                    },
                },
                errorElement: 'span',
                    errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endpush
