@extends('layouts.admin')
<!-- partial -->
@section('content')
    <div class="container-header">
        <div class="d-flex justify-content-between mb-3">
            <h3>Category Form</h3>
            <a href="{{ route('category.index') }}">
                <button type="submit" name="add" class="btn btn-primary">Back</button>
            </a>
        </div>


        <div class="container-body">
            <form action="{{ route('category.insert') }}" method="post" class="form-inline justify-content-center" id="formValidation">
                @csrf
                <div class="row">
                    <div class="form-group col-md-8">
                        <label for="" class="fw-bold">Title<span class="text-danger fs-5 fw-bold">*</span></label>
                        <input type="text" name="title" class="form-control" size="120" placeholder="Title"
                            value="{{ old('title') }}">
                        @error('title')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-8">
                        <label for="" class="fw-bold">Description<span
                                class="text-danger fs-5 fw-bold">*</span></label>
                        <textarea name="description" class="form-control" rows="4" cols="120" placeholder="Description">{{ old('description') }}</textarea>
                        <span class="text-danger">
                            @error('description')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

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
                    title: {
                        required: true,
                    },
                    description: {
                        required: true,
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
