@extends('layouts.admin')
<!-- partial -->

@section('content')

    <div class="d-flex justify-content-between mb-3">
        <h3>Edit Video Tour</h3>
        <a href="{{ route('video.index') }}">
            <button type="submit" name="add" class="btn btn-primary">Back</button>
        </a>
    </div>

    <div class="container-body">

        <form action="{{ route('video.update', ['id' => $video->id]) }}" method="post" class="form-inline justify-content-center"
            enctype="multipart/form-data" id="formValidation">
            @csrf
            <div class="row">
                <div class="form-group col-md-8">
                    <label for="" class="fw-bold">Name<span class="text-danger fs-5 fw-bold">*</span></label>
                    <input type="text" class="form-control" name="name" size="120" value="{{ old('name', $video->name) }}"
                        placeholder="Name">
                    @error('name')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="" class="fw-bold">Thumbnail<span
                        class="text-danger fs-5 fw-bold">*</span></label>
                    <input type="file" class="form-control" name="thumbnail" accept="image/*">
                    @if ($video->thumbnail)
                        <img src="{{ $video->thumbnail }}" width="100px" class="mt-3"
                            height="100px" alt="thumbnail" accept="image/*">
                    @else
                        @error('thumbnail')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    @endif
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
                    }
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
