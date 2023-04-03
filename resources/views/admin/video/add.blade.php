@extends('layouts.admin')
<!-- partial -->

@section('content')
    @if ($message = Session::get('success'))
        {{-- <div class="alert alert-success alert-dismissible">
    <a href="#" class="btn-close" data-bs-dismiss="alert" aria-label="Close">&times;</a>
    <p>{{$message}}</p>
    </div> --}}

        <x-admin.alert type="success" :message="$message" class="alert alert-success alert-dismissible" />
    @endif
    @if ($message = Session::get('error'))
        {{-- <div class="alert alert-danger alert-dismissible">
    <a href="#" class="btn-close" data-bs-dismiss="alert" aria-label="Close">&times;</a>
    <p>{{$message}}</p>
    </div> --}}

        <x-admin.alert type="error" :message="$message" class="alert alert-danger alert-dismissible" />
    @endif

    <div class="d-flex justify-content-between mb-3">
        <h3>Video Form</h3>
        <a href="{{ route('video.index') }}">
            <button type="submit" name="add" class="btn btn-primary">Back</button>
        </a>
    </div>

    <div class="container-body">

        <form action="{{ url('/') }}/admin/videosave" method="post" class="form-inline justify-content-center"
            enctype="multipart/form-data" id="formValidation">
            @csrf
            <div class="row">
                <div class="form-group col-md-8">
                    <label for="" class="fw-bold">Name<span class="text-danger fs-5 fw-bold">*</span></label>
                    <input type="text" class="form-control" name="name" size="120" value="{{ old('name') }}"
                        placeholder="Name">
                    @error('name')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="" class="fw-bold">Upload Zip File<span
                            class="text-danger fs-5 fw-bold">*</span></label>
                    <input type="file" class="form-control" name="zip" value="{{ old('zip') }}">
                    @error('zip')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="" class="fw-bold">Thumbnail<span
                        class="text-danger fs-5 fw-bold">*</span></label>
                    <input type="file" class="form-control" name="thumbnail" accept="image/*">
                    @error('thumbnail')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>


            </div>
        </form>
    </div>

    <!-- container-scroller -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#formValidation').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    zip: {
                        required: true,
                        accept: "application/zip,application/octet-stream,application/x-zip,application/x-zip-compressed",
                        extension: "zip"
                    },
                    thumbnail: {
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
