@extends('layouts.admin')
<!-- partial -->

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h3>Edit Form</h3>
        <a href="{{ route('client.index') }}">
            <button type="submit" name="add" class="btn btn-primary">Back</button>
        </a>
    </div>


    <div class="container-body">

        <form action="{{ route('client.update', ['id' => $client->id]) }}" method="post"
            class="form-inline justify-content-center" enctype="multipart/form-data" id="formValidation">
            @csrf
            <div class="row">
                <div class="form-group col-md-8">
                    <label for="" class="fw-bold">Company Name<span
                            class="text-danger fs-5 fw-bold">*</span></label>
                    <input type="text" class="form-control" name="company_name" placeholder="Company Name"
                        value="{{ old('company_name', $client->company_name) }}" size="120">
                    @error('company_name')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="" class="fw-bold">Logo<span class="text-danger fs-5 fw-bold">*</span></label>
                    <input type="file" class="form-control" name="logo" value="{{ old('logo', $client->logo) }}" accept="image/*">
                    <br>
                    @if ($client->logo)
                        <img src="{{ $client->logo }}" accept="image/*" width="100px"
                            height="100px" alt="img">
                    @else
                        @error('logo')
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
                    company_name: {
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
