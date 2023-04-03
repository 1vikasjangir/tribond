@extends('layouts.admin')
<!-- partial -->

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h3>Blog Form</h3>
        <a href="{{ route('blog.index') }}">
            <button type="submit" name="add" class="btn btn-primary">Back</button>
        </a>
    </div>

    @if ($message = Session::get('error'))
        <x-admin.alert type="error" :message="$message" class="alert alert-danger alert-dismissible" />
    @endif

    <div class="container-body">

        <form action=" {{ route('blog.save') }}" method="post" class="form-inline justify-content-center"
            enctype="multipart/form-data" id="formValidation">
            @csrf
            <div class="row">
                <div class="form-group col-md-8">
                    <label for="" class="fw-bold">Title<span class="text-danger fs-5 fw-bold">*</span></label>
                    <input type="text" class="form-control" name="title" size="120" value="{{ old('title') }}"
                        placeholder="Title">
                    @error('title')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-8">
                    <label for="" class="fw-bold">Description<span class="text-danger fs-5 fw-bold">*</span></label>
                    <textarea name="description" id="editor" class="Form-control" rows="4" cols="120"
                        placeholder="Description">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                </div>

                <div class="form-group col-md-8">
                    <label for="" class="fw-bold">Author<span class="text-danger fs-5 fw-bold">*</span></label>
                    <input type="text" class="form-control" name="author" size="120" value="{{ old('author') }}"
                        placeholder="Author">
                    @error('author')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="fw-bold">Category<span class="text-danger fs-5 fw-bold">*</span></label>
                            <select name="category_id" id="select-option" class="form-select p-2">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        @if (old('category_id') == $category->id) {{ 'selected' }} @endif>{{ $category->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <br>
                    <label for="" class="fw-bold">Image<span class="text-danger fs-5 fw-bold">*</span></label>
                    <input type="file" class="form-control" name="image" accept="image/*">
                    @error('image')
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
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $.validator.setDefaults({
                ignore: ''
            })
            $('#formValidation').validate({
                rules: {
                    title: {
                        required: true,
                    },
                    description: {
                        required: true,
                    },
                    author: {
                        required: true,
                    },
                    image: {
                        required: true,
                        accept: "image/*",
                        filesize : 2,
                    },
                },
                // messages: {
                //     title: "First name is required"
                // },
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
