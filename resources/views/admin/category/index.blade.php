@extends('layouts.admin')
{{-- toggle --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.css"
    integrity="sha512-9tISBnhZjiw7MV4a1gbemtB9tmPcoJ7ahj8QWIc0daBCdvlKjEA48oLlo6zALYm3037tPYYulT0YQyJIJJoyMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- partial -->

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-5 pb-3 mb-3 heading_header">
        <div class="left">
            <h1 class="h2">Category Management</h1>
            <ul>
                <li>
                    <a href="{{ route('dashboard') }}">Dashboard</a> <span>>></span>
                </li>
                <li>Category Management</li>
            </ul>
        </div>
        <div class="right">
            <a href="{{ route('category.add') }}" class="btn btn-primary create_new">Add New</a>
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
                        <form autocomplete="off" id="category-filters" action="{{ route('category.index') }}" method="POST">
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
                                    <a href="{{ route('category.index') }}" class="btn btn-dark">Reset</a>
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
            <h3>Category List</h3>
        </div>

        <div class="table-responsive">
            <table id="example" class="table table-striped table-bordered border-light text-center">
                <thead>
                    <tr class="table-dark">
                        <th class="text-center">S.No.</th>
                        <th class="text-start">Title</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td> {{ $categories->firstItem() + $loop->index }}</td>
                            <td class="text-start">{{ $category->title }}</td>
                            <td> {{ $category->created_at->format('d-m-Y') }}</td>
                            <td>
                                <a href="javascript:;" data-id="{{ $category->id }}" class="change-status-btn">
                                    <i id="active_{{ $category->id }}" style="display:{{ $category->status == '1' ? 'block' : 'none'}};" class="far fa-circle-check md-24 text-success" data-toggle="tooltip" title="Active"></i>
                                    <i id="deactive_{{ $category->id }}" style="display:{{ $category->status == '0' ? 'block' : 'none'}};" class="far fa-times-circle md-24 text-danger" data-toggle="tooltip" title="Deactive"></i>
                                </a>
                            </td>

                            <td>
                                <a href="javascript:;" data-id="{{ $category->id }}" id="delete_{{ $category->id }}" class="change-delete-btn">
                                    <i class="fas fa-trash text-danger md-24" data-toggle="tooltip" title="Delete"></i>
                                </a>

                                <a href=" {{ route('edit', ['id' => $category->id]) }}">
                                    <i class="fas fa-edit text-secondary md-24" data-toggle="tooltip" title="Edit"></i>
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
        @if (!$categories->isEmpty())
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-5">
                <div class="left">
                    Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }} entries
                </div>
                <div class="right">
                    {{ $categories->links('pagination::bootstrap-4') }}
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
                var category_id = $(this).data('id');
                let _token = "{{ csrf_token() }}";

                $.ajax({
                    url     : "{{route('category.delete')}}",
                    type    : 'POST',
                    dataType   : 'json',
                    data : {
                        'category_id': category_id,
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
                var category_id = $(this).data('id');
                let _token = "{{ csrf_token() }}";

                $.ajax({
                    url     : "{{route('category.status')}}",
                    type    : 'POST',
                    dataType   : 'json',
                    data : {
                        'category_id': category_id,
                        '_token': _token
                    },
                    success: function (data) {
                        // alert(data)
                        if(data.status == "1"){
                            // Code in the case checkbox is checked.
                            $('#active_'+category_id).show()
                            $('#deactive_'+category_id).hide()
                            $("#alert").css('opacity', '1').html(data.success).fadeIn(2000).fadeOut(4000);
                        } else {
                            // Code in the case checkbox is NOT checked.
                            $('#deactive_'+category_id).show()
                            $('#active_'+category_id).hide()
                            $("#alert").css('opacity', '1').html(data.success).fadeIn(2000).fadeOut(4000);
                        }
                    },
                });
            }
        });

        $(document).ready(function() {
            // $(function () {
            //     $('[data-toggle="tooltip"]').tooltip({
            //         'placement': 'shown.bs.tooltip'
            //     })
            // });
            $('.cattooltip').on('hidden.bs.tooltip', function () {
                // do something…
            })
        });
    </script>
@endpush
