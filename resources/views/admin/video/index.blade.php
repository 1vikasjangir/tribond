@extends('layouts.admin')
<!-- partial -->
@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-5 pb-3 mb-3 heading_header">
        <div class="left">
            <h1 class="h2">Virtual Tour Management</h1>
            <ul>
                <li>
                    <a href="{{ route('dashboard') }}">Dashboard</a> <span>>></span>
                </li>
                <li>Virtual Tour Management</li>
            </ul>
        </div>
        <div class="right">
            <a href="{{ route('videoform.add') }}" class="btn btn-primary create_new">Add New</a>
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
                        <form autocomplete="off" id="video-filters" action="{{ route('video.index') }}" method="POST">
                            @csrf
                            @method('GET')
                            <div class="row">
                                <div class="col-md-3 col-lg-3 col-xl-3 col-sm-3">
                                    <div class="form-group">
                                        <input type="text" name="name" id="name" class="form-control"
                                            placeholder="Name" value="{{ Request::get('name') }}">
                                    </div>
                                </div>

                                <div class="col-md-3">
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
                                    <a href="{{ route('video.index') }}" class="btn btn-dark">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end filter -->

    <div class="sub-container">

        <div class="d-flex justify-content-between mb-3 mt-5">
            <h3>Video List</h3>
        </div>
        <div class="table-responsive">
            <table id="example" class="table table-striped table-bordered border-light text-center">
                <thead>
                    <tr class="table-dark">
                        <th class="text-center">S.No.</th>
                        <th class="text-start">Name</th>
                        <th class="text-start">Tour URL</th>
                        {{-- <th class="text-center">Download</th> --}}
                        <th class="text-center">Thumbnail</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($videos as $video)
                        <tr>
                            <td> {{ $videos->firstItem() + $loop->index }}</td>
                            <td class="text-start">{{ $video->name }}</td>
                            <td class="text-start">
                                @php

                                    $zipName = explode('.zip', $video->url);
                                    // p($zipName[0]); die;
                                @endphp
                                <a href="{{ $zipName[0]."/index.html" }}" target="_blank">{{ $zipName[0] }}</a>
                            </td>
                            {{-- <td><a href="{{ route('video.download', ['id' => $video->id]) }}">download</a></td> --}}
                            <td><img src="{{ $video->thumbnail }}" width="100px" height="100px"
                                alt="{{ Str::limit($video->name, 20) }}"></td>
                            <td> {{ $video->created_at->format('d-m-Y') }}</td>
                            <td>
                                <a href="javascript:;" data-id="{{ $video->id }}" class="change-status-btn">
                                    <i id="active_{{ $video->id }}" style="display:{{ $video->status == '1' ? 'block' : 'none'}};" class="far fa-circle-check md-24 text-success" data-toggle="tooltip" title="Active"></i>
                                    <i id="deactive_{{ $video->id }}" style="display:{{ $video->status == '0' ? 'block' : 'none'}};" class="far fa-times-circle md-24 text-danger" data-toggle="tooltip" title="Deactive"></i>
                                </a>
                            </td>
                            <td>
                                <a href="javascript:;" data-id="{{ $video->id }}" id="delete_{{ $video->id }}" class="change-delete-btn">
                                    <i class="fas fa-trash text-danger md-24" data-toggle="tooltip" title="Delete"></i>
                                </a>

                                <a href="{{ route('video.edit', $video->id) }}">
                                    <i class="fas fa-edit md-24 text-secondary"
                                        data-toggle="tooltip" title="Edit"></i>
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
        @if (!$videos->isEmpty())
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-5">
                <div class="left">
                    Showing {{ $videos->firstItem() }} to {{ $videos->lastItem() }} of {{ $videos->total() }} entries
                </div>
                <div class="right">
                    {{ $videos->links('pagination::bootstrap-4') }}
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        /* Delete record using ajax */
        $(document).on('click','.change-delete-btn',function(){
            if (confirm('Are you sure to delete this item?')) {
                var rowObj = $(this).parents('tr');
                var video_id = $(this).data('id');
                let _token = "{{ csrf_token() }}";

                $.ajax({
                    url     : "{{route('video.delete')}}",
                    type    : 'POST',
                    dataType   : 'json',
                    data : {
                        'video_id': video_id,
                        '_token': _token
                    },
                    success: function (data) {
                        if(data.status){
                            var siblings = rowObj.siblings();
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
                var video_id = $(this).data('id');
                let _token = "{{ csrf_token() }}";

                $.ajax({
                    url     : "{{route('video.status')}}",
                    type    : 'POST',
                    dataType   : 'json',
                    data : {
                        'video_id': video_id,
                        '_token': _token
                    },
                    success: function (data) {
                        // alert(data)
                        if(data.status == "1"){
                            // Code in the case checkbox is checked.
                            $('#active_'+video_id).show()
                            $('#deactive_'+video_id).hide()
                            $("#alert").css('opacity', '1').html(data.success).fadeIn(2000).fadeOut(4000);
                        } else {
                            // Code in the case checkbox is NOT checked.
                            $('#deactive_'+video_id).show()
                            $('#active_'+video_id).hide()
                            $("#alert").css('opacity', '1').html(data.success).fadeIn(2000).fadeOut(4000);
                        }
                    },
                });
            }
        });
    </script>
@endpush
