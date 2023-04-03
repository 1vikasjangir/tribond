@extends('layouts.admin')
<!-- partial -->
@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h3>Edit Project</h3>
        <a href="{{ route('projects.index') }}">
            <button type="submit" name="add" class="btn btn-primary">Back</button>
        </a>
    </div>


    <div class="container-body">

        <form action="{{ route('projects.update', ['id' => $project->id]) }}" method="post"
            class="form-inline justify-content-center" enctype="multipart/form-data" id="formValidation">
            @csrf

            <div class="row">
                <div class="form-group col-md-8">
                    <label for="" class="fw-bold">Title<span
                            class="text-danger fs-5 fw-bold">*</span></label>
                    <input type="text" class="form-control" name="title" size="120" placeholder="Title"
                        value="{{ old('title', $project->title) }}">
                    @error('title')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-8">
                    <label for="" class="fw-bold">Description<span
                            class="text-danger fs-5 fw-bold">*</span></label>
                    <textarea name="description" class="form-control" rows="4" cols="120" placeholder="Description">{{ old('description', $project->description) }}</textarea>
                    @error('description')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-8">
                    <label for="" class="fw-bold">Hash Tags<span
                            class="text-danger fs-5 fw-bold">*</span></label>
                    <input type="text" class="form-control" name="hash_tags" size="120" placeholder="Hash Tag"
                        value="{{ old('hash_tags', $project->hash_tags) }}">
                    @error('hash_tags')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <div class="form-group col-md-3">
                        <label for="" class="fw-bold">Thumbnail<span
                                class="text-danger fs-5 fw-bold">*</span></label>
                        <input type="file" class="form-control" name="thumbnail"
                            value="{{ old('thumbnail', $project->thumbnail) }}" accept="image/*">
                        <br>
                        @if ($project->thumbnail)
                            <img src="{{ $project->thumbnail }}" width="100px"
                                height="100px" alt="thumbnail" accept="image/*">
                        @else
                            @error('thumbnail')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        @endif
                    </div>

                    <div class="form-group col-md-3">
                        <label for="" class="fw-bold">Main Image<span
                                class="text-danger fs-5 fw-bold">*</span></label>
                        <input type="file" class="form-control" name="main_image"
                            value="{{ old('main_image', $project->main_image) }}" accept="image/*">
                        <br>
                        @if ($project->main_image)
                            <img src="{{ $project->main_image }}" width="100px"
                                height="100px" alt="main_image" accept="image/*">
                        @else
                            @error('main_image')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        @endif
                    </div>

                    <div class="form-group col-md-4 mt-3">
                        <div class="form-check form-switch mt-3">
                            <input class="form-check-input" type="checkbox" id="fullwidth_image" name="fullwidth_image" {{ $project->fullwidth_image ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold  mx-5 pt-2" for="fullwidth-image">Full Width Image<i class="input-helper"></i></label>
                        </div>
                    </div>
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
        $(document).ready(function() {
            $('#formValidation').validate({
                rules: {
                    title: {
                        required: true,
                    },
                    description: {
                        required: true,
                    },
                    hash_tags: {
                        required: true,
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endpush
