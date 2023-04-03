@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h3>Edit Form</h3>
        <a href="{{ route('category.index') }}">
            <button type="submit" name="back" class="btn btn-primary">Back</button>
        </a>
    </div>

    <div class="container-body">
        <form action=" {{ route('category.update', ['id' => $category->id]) }}" method="post"
            class="form-inline justify-content-center" id="formValidation">
            @csrf

            <div class="row">
                <div class="form-group col-md-8">
                    <label for="" class="fw-bold">Title<span class="text-danger fs-5 fw-bold">*</span></label>
                    <input type="text" class="form-control" value="{{ old('title', $category->title) }}" name="title"
                        size="120" placeholder="Title">
                    @error('title')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-8">
                    <label for="" class="fw-bold">Description<span class="text-danger fs-5 fw-bold">*</span></label>
                    <textarea name="description" class="form-control" rows="4" cols="120" placeholder="Description">{{ old('description', $category->description) }}</textarea> @error('description')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>

            </div>

        </form>
    </div>
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
