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
                    <a href="{{ route('blog.index') }}">Blog</a> <span>>></span>
                </li>
                <li>Media Management</li>
            </ul>
        </div>
        <div class="right">
            <a href="{{ route('blog.index') }}" class="btn btn-primary create_new">Back</a>
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

    <div id="alert" class="alert alert-success" style="display:none;">
        <a href="#" class="btn-close" data-bs-dismiss="alert" aria-label="Close">&times;</a>
    </div>

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
                        <form autocomplete="off" id="blog-filters" action="{{ route('media.get', ['id' => $blogs->id]) }}" method="POST">
                            @csrf
                            @method('GET')
                            <div class="row">
                                <div class="col-md-3 col-lg-3 col-xl-3 col-sm-3">
                                    <div class="form-group">
                                        <select name="type" class="form-select p-2">
                                            <option value=""> Select Type</option>
                                            <option {{ Request::get('type') == 'image' ? 'selected' : '' }} value="image">
                                                Image</option>
                                            <option {{ Request::get('type') == 'video' ? 'selected' : '' }} value="video">
                                                Video</option>
                                        </select>
                                    </div>
                                </div>

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
                                    <a href="{{ route('media.get', ['id' => $blogs->id]) }}" class="btn btn-dark">Reset</a>
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

        {{-- <nav>
            <ul class="pagination">
                <li class="breadcrumb-item">
                    <a href="{{ url('admin/blog') }}">Blog</a>
                </li>
                <li class="breadcrumb-item active">
                    Media
                </li>
            </ul>
        </nav> --}}


        <div class="row gy-3 mt-2 mb-2 px-3">
            <form action="{{ route('media.save', ['id' => $blogs->id]) }}" method="post" class="form-inline"
                enctype="multipart/form-data" id="formValidation">
                @csrf
                <div class="row">
                    @if ($medias->count() < 4 )
                        <div class="col-md-3 form-group">
                            <label for="" class="fw-bold my-2">Select Media Type<span class="text-danger fs-5 fw-bold">*</span></label>
                            <select name="type" id="select-option" class="form-select mt-2 p-2">
                                <option value="" selected disabled class="">Select</option>
                                <option value="image" @if (old('type') == 'image') {{ 'selected' }} @endif>Image
                                </option>
                                <option value="video" @if (old('type') == 'video') {{ 'selected' }} @endif>Video
                                </option>
                            </select>
                        </div>

                        <div class="col-md-3 form-group" id="details-container">
                            <div class="image media-details" id="image">
                                <label for="floatingInput" class="fw-bold my-1">Image<span class="text-danger fs-5 fw-bold">*</span></label>
                                <input type="file" name="image" class="form-control mt-3" accept="image/*">
                                @error('image')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="video media-details" id="video">
                                <label for="" class="fw-bold my-1">Video<span class="text-danger fs-5 fw-bold">*</span></label>
                                <input type="text" name="video" class="form-control mt-3" placeholder="Video">
                                @error('video')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div class="col-md-2 mt-5">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    @endif

                    <div class="col-md-4 {{ $medias->count() > 3 ? ' mx-4' : '' }}">
                        <div class="d-inline-flex mt-5">
                            <div class="form-check form-switch mt-1">
                                {{-- <input data-id="{{$blogs->id}}" name="media_above_desc" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive"> --}}
                                <input class="form-check-input" type="checkbox" id="media_above_desc_{{ $blogs->id }}" data-id="{{ $blogs->id }}" name="media_above_desc" {{ $blogs->media_above_desc ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold  mx-5 pt-2" for="media_above_desc">Show media above description<i class="input-helper"></i></label>
                            </div>
                        </div>
                    </div>

                </div>

            </form>
        </div>

        <div class="row mt-5">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered border-light text-center">
                    <thead>
                        <tr class="table-dark">
                            <th class="text-center">S.No.</th>
                            <th class="text-start">Type</th>
                            <th class="text-start">Blog</th>
                            <th class="text-center">File</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($medias as $media)
                            <tr>
                                <td> {{ $medias->firstItem() + $loop->index }}</td>
                                <td class="text-start">{{ ucfirst($media->type) }}</td>

                                <td class="text-start">{{ optional($media->blogs)->title }}</td>

                                @if ($media->type == 'image')
                                    <td><img src="{{ $media->file }}" width="100px"
                                            height="100px" alt="img"></td>
                                @else
                                    <td>{{ $media->file }}</td>
                                @endif
                                <td> {{ $media->created_at->format('d-m-Y') }}</td>
                                <td>
                                    {{-- @if ($media->status == '1') --}}
                                        <a href="javascript:;" data-id="{{ $media->id }}" class="change-status-btn">
                                            <i id="active_{{ $media->id }}" style="display:{{ $media->status == '1' ? 'block' : 'none'}};" class="far fa-circle-check md-24 text-success" data-toggle="tooltip" title="Active"></i>
                                            <i id="deactive_{{ $media->id }}" style="display:{{ $media->status == '0' ? 'block' : 'none'}};" class="far fa-times-circle md-24 text-danger" data-toggle="tooltip" title="Deactive"></i>
                                        </a>
                                    {{-- @else
                                        <a href="javascript:;"
                                            data-id="{{ $media->id }}" data-status="{{ $media->status }}" class="change-status-btn"><i
                                                class="mdi mdi-alpha-x-circle-outline material-icons md-24 text-danger"
                                                data-toggle="tooltip" title="Inactive"></i></a>
                                    @endif --}}
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
            </div>
            {{-- Pagination --}}
            @if (!$medias->isEmpty())
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-5">
                    <div class="left">
                        Showing {{ $medias->firstItem() }} to {{ $medias->lastItem() }} of {{ $medias->total() }} entries
                    </div>
                    <div class="right">
                        {{ $medias->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            @endif
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
                    url     : "{{route('media.delete')}}",
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
                    url     : "{{route('media.status')}}",
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
            /* Show hide image or video field on select of file type */
            $("#details-container").css('position', 'absolute');
            $("#details-container").css('left', '-9999px');
            var name = $("#select-option").change(function() {
                $("#details-container").removeAttr('style');
                var name = $("#select-option").val();
                $(".media-details").hide();
                $("." + name).show();
            });

            // document.getElementById('select-option').addEventListener("change", function (e) {
            //     if (e.target.value === 'image') {
            //         document.getElementById('video').style.display = 'none';
            //         document.getElementById('image').style.display = 'block';
            //     } else {
            //         document.getElementById('image').style.display = 'none';
            //         document.getElementById('video').style.display = 'block'
            //     }
            // });

            // $( "div" ).remove( "#details-container1" );
            //     /* Show hide image or video field on select of file type */
            //     var name = $("#select-option").change(function() {
            //     var name = $("#select-option").val();
            //     RowAdd ='<div class="col-md-3" id="details-container1">' +
            //                 '</div>';
            //     $( "#details-container1" ).parent().html(RowAdd);

            //     if (name == 'image') {
            //         newRowAdd ='<div class="col-md-3" id="details-container">'+
            //             '<div class="image media-details" id="image">' +
            //                 '<label for="floatingInput" class="fw-bold">Image<span class="text-danger fs-5 fw-bold">*</span></label>' +
            //                 '<input type="file" name="image" class="form-control mt-4" accept="image/*">' +
            //                 '@error('image')' +
            //                     '<span class="text-danger">' +
            //                         '{{ $message }}' +
            //                     '</span>' +
            //                 '@enderror' +
            //             '</div>' +
            //         '</div>';
            //     } else {
            //         newRowAdd ='<div class="col-md-3" id="details-container">'+
            //             '<div class="image media-details" id="video">' +
            //                 '<label for="" class="fw-bold">Video<span class="text-danger fs-5 fw-bold">*</span></label>' +
            //                 '<input type="text" name="video" class="form-control mt-4" placeholder="Video">' +
            //                 '@error('video')' +
            //                     '<span class="text-danger">' +
            //                         '{{ $message }}' +
            //                     '</span>' +
            //                 '@enderror' +
            //             '</div>' +
            //         '</div>';
            //     }

            //     $("#details-container").html(newRowAdd);
            //     // $(".media-details").remove("." + name);
            //     // $("." + name).add();
            // });

            /**** Show media above description using ajax ****/
            $("input:checkbox").change(function() {
                var blog_id = $(this).data('id');
                let status = $(this).prop('checked') === true ? '1' : '0';
                let _token = "{{ csrf_token() }}";

                $.ajax({
                    url     : "{{route('media.showMediaAboveDesc')}}",
                    type    : 'POST',
                    dataType   : 'json',
                    data   : {
                        'blog_id': blog_id,
                        'media_above_desc': status,
                        '_token': _token
                    },
                    success: function (data) {
                        // alert(data.data.status)
                        if(data.data.status) {
                            // data = JSON.parse(data.data);
                            if($('#media_above_desc_'+blog_id).is(':checked')){
                                // Code in the case checkbox is checked.
                                $('#media_above_desc_'+blog_id).attr( 'value', data.data.success);
                            } else {
                                // Code in the case checkbox is NOT checked.
                                $('#media_above_desc_'+blog_id).attr( 'value', data.data.success);
                            }
                        }
                    },
                });
            });

            /**** Client side validation ****/
            $('#formValidation').validate({
                rules: {
                    image: {
                        required: true,
                        accept: "image/*",
                        filesize : 2,
                    },
                    video: {
                        required: true,
                        url: true
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
                unhighlight: function (element, errorClass, validClchangeass) {
                    $(element).removeClass('is-invalid');
                }
            });

        });
    </script>
@endpush
