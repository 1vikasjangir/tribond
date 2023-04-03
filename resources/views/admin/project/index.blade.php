@extends('layouts.admin')

@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-5 pb-3 mb-3 heading_header">
        <div class="left">
            <h1 class="h2">Project Management</h1>
            <ul>
                <li>
                    <a href="{{ route('dashboard') }}">Dashboard</a> <span>>></span>
                </li>
                <li>Project Management</li>
            </ul>
        </div>
        <div class="right">
            <a href="{{ route('projects.create') }}" class="btn btn-primary create_new">Add New</a>
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
                        <form autocomplete="off" id="project-filters" action="{{ route('projects.index') }}" method="POST">
                            @csrf
                            @method('GET')
                            <div class="row">
                                <div class="col-md-3 col-lg-3 col-xl-3 col-sm-3">
                                    <div class="form-group">
                                        <input type="text" name="title" id="title" class="form-control"
                                            placeholder="Title" value="{{ Request::get('title') }}">
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
                                    <a href="{{ route('projects.index') }}" class="btn btn-dark">Reset</a>
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
            <h3>Project List</h3>
        </div>

        <div class="table-responsive">
            <table id="example" class="table table-striped table-bordered border-light text-center">
                <thead>
                    <tr class="table-dark">
                        <th class="text-center">S.No.</th>
                        <th class="text-start">Title</th>
                        <th class="text-center">Thumbnail</th>
                        <th class="text-center">Main Image</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($projects as $key => $project)
                        <tr id="project_row_{{ $project->id }}" data-id="{{ $project->id }}" class="project-list">
                            <td> {{ $projects->firstItem() + $loop->index }}</td>
                            <td class="text-start">{{ $project->title }}</td>
                            <td><img src="{{ $project->thumbnail }}" width="100px"
                                    height="100px" alt="thumbnail"></td>
                            <td><img src="{{ $project->main_image }}" width="100px"
                                    height="100px" alt="main_image"></td>
                            <td> {{ $project->created_at->format('d-m-Y') }}</td>
                            <td>
                                <a href="javascript:;" data-id="{{ $project->id }}" class="change-status-btn">
                                    <i id="active_{{ $project->id }}" style="display:{{ $project->status == '1' ? 'block' : 'none'}};" class="far fa-circle-check md-24 text-success" data-toggle="tooltip" title="Active"></i>
                                    <i id="deactive_{{ $project->id }}" style="display:{{ $project->status == '0' ? 'block' : 'none'}};" class="far fa-times-circle md-24 text-danger" data-toggle="tooltip" title="Deactive"></i>
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('projectmedia.get', ['id' => $project->id]) }}">
                                    <i class="fas fa-file-upload md-24 text-primary"
                                        data-toggle="tooltip" title="Add Media"></i>
                                </a>
                                <a href="javascript:;" data-id="{{ $project->id }}" id="delete_{{ $project->id }}" class="change-delete-btn">
                                    <i class="fas fa-trash text-danger md-24" data-toggle="tooltip" title="Delete"></i>
                                </a>
                                <a href="{{ route('projects.edit', $project->id) }}">
                                    <i class="fas fa-edit md-24 text-secondary"
                                        data-toggle="tooltip" title="Edit"></i>
                                </a>

                                @if (!$loop->first)
                                    <a href="javascript:;" class="change-sort-order up">
                                        <i class="fa-regular fa-circle-up md-24 text-secondary"
                                            data-toggle="tooltip" title="Change Order"></i>
                                    </a>
                                @endif
                                @if (!$loop->last)
                                    <a href="javascript:;" class="change-sort-order down">
                                        <i class="fa-regular fa-circle-down md-24 text-secondary"
                                            data-toggle="tooltip" title="Change Order"></i>
                                    </a>
                                @endif
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
        @if (!$projects->isEmpty())
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-5">
                <div class="left">
                    Showing {{ $projects->firstItem() }} to {{ $projects->lastItem() }} of {{ $projects->total() }} entries
                </div>
                <div class="right">
                    {{ $projects->links('pagination::bootstrap-4') }}
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
                var project_id = $(this).data('id');
                let _token = "{{ csrf_token() }}";

                $.ajax({
                    url     : "{{route('projects.delete')}}",
                    type    : 'POST',
                    dataType   : 'json',
                    data : {
                        'project_id': project_id,
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
                var project_id = $(this).data('id');
                let _token = "{{ csrf_token() }}";

                $.ajax({
                    url     : "{{route('projects.status')}}",
                    type    : 'POST',
                    dataType   : 'json',
                    data : {
                        'project_id': project_id,
                        '_token': _token
                    },
                    success: function (data) {
                        // alert(data)
                        if(data.status == 1){
                            // Code in the case checkbox is checked.
                            $('#active_'+project_id).show()
                            $('#deactive_'+project_id).hide()
                            $("#alert").css('opacity', '1').html(data.success).fadeIn(2000).fadeOut(4000);
                        } else {
                            // Code in the case checkbox is NOT checked.
                            $('#deactive_'+project_id).show()
                            $('#active_'+project_id).hide()
                            $("#alert").css('opacity', '1').html(data.success).fadeIn(2000).fadeOut(4000);
                        }
                    },
                });
            }
        });

        $(document).on('click','.change-sort-order',function(){
            var thisObj = $(this)
            // var row = $(this).closest('tr');
            var self_row_id = $(this).parents('tr').attr('id');
            var next_row_id = $(this).closest('tr').next().closest('tr').attr('id');
            var prev_row_id = $(this).closest('tr').prev().closest('tr').attr('id');

            var down = $(this).hasClass('down');
            var atype = ''
            if (down == true) {
                atype = "down"
            } else {
                atype = "up"
            }

            var self_project_id = $(this).parents('tr').data('id');
            var next_project_id = $(this).closest('tr').next().closest('tr').data('id');
            var previous_project_id = $(this).closest('tr').prev().closest('tr').data('id');
            let _token = "{{ csrf_token() }}";

            $.ajax({
                url      : "{{route('projects.sortPrevOrder')}}",
                type     : 'POST',
                dataType : 'json',
                cache    : false,
                data : {
                    'id': self_project_id,
                    'next_project_id': next_project_id,
                    'previous_project_id': previous_project_id,
                    'atype' : atype,
                    '_token': _token
                },
                success: function (data) {
                    if(data.status){
                        let oldFirstRowId = $(".project-list").first().attr("id")
                        let oldLastRowId = $(".project-list").last().attr("id")

                        // alert("old Last" +oldLastRowId + "Self" + self_row_id + "Next Row" + next_row_id)

                        if(thisObj.hasClass("down")){
                            $('#'+self_row_id).replaceWith($('#'+self_row_id).next('tr').after($('#'+self_row_id).clone(true)));
                            // var row = $(document.getElementById(self_row_id)); // Or continue to use the invalid ID selector: '#'+id
                            // var siblings = row.siblings();
                            // // $('#'+self_row_id).replaceWith($('#'+self_row_id).next('tr').after($('#'+self_row_id).clone(true)));
                            // siblings.each(function(index) {
                            //     alert(index)
                            //     $(this).children('td').first().text(index + 1);
                            // });

                            let lastRowId = $(".project-list").last().attr("id")
                            let firstRowId = $(".project-list").first().attr("id")
                            if(self_row_id == lastRowId){
                                var clonedDownArr = $('#'+self_row_id).find(".down").clone()
                                $('#'+self_row_id).prev('tr').find(".up").after(clonedDownArr)
                                $('#'+self_row_id).find(".down").remove()
                            }
                            if(self_row_id == firstRowId){
                                $('#'+next_row_id).find(".up").hide()
                                $('#'+self_row_id).find(".up").show()
                            }
                            if(self_row_id == oldFirstRowId){
                                var clonedDownArr = $('#'+next_row_id).find(".up").clone()
                                $('#'+oldFirstRowId).find(".down").after(clonedDownArr)
                                $('#'+oldFirstRowId).find(".up").show()
                                $('#'+next_row_id).find(".up").remove()
                            }
                        }else{
                            $('#'+self_row_id).replaceWith($('#'+self_row_id).prev('tr').after($('#'+self_row_id).clone(true)));
                            let lastRowId = $(".project-list").last().attr("id")
                            let firstRowId = $(".project-list").first().attr("id")
                            if(self_row_id == firstRowId){
                                var clonedDownArr = $('#'+self_row_id).find(".up").clone()
                                $('#'+self_row_id).next('tr').find(".down").after(clonedDownArr)
                                $('#'+self_row_id).find(".up").remove()
                            }
                            if(self_row_id == lastRowId){
                                $('#'+prev_row_id).find(".down").hide()
                                $('#'+self_row_id).find(".down").show()
                            }
                            if(self_row_id == oldLastRowId){
                                var clonedDownArr = $('#'+prev_row_id).find(".down").clone()
                                $('#'+oldLastRowId).find(".up").after(clonedDownArr)
                                $('#'+oldLastRowId).find(".down").show()
                                $('#'+prev_row_id).find(".down").remove()
                            }
                        }

                    }
                },
            });
        });
    </script>
@endpush
