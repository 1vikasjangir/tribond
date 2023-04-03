@if ($message = Session::get('success'))
    <x-admin.alert type="success" :message="$message" class="alert alert-success alert-dismissible" />
@endif
@if ($message = Session::get('error'))
    <x-admin.alert type="error" :message="$message" class="alert alert-danger alert-dismissible" />
@endif

<section class="get_in_touch_section" id="get_in_touch_section">
    <div class="container">
        <h2>GET IN TOUCH</h2>
        <div class="contact_form">
            <div class='row col-md-6'>
                <div id="alert" class="alert alert-success d-nome" style="display:none;">
                    <a href="#" class="btn-close" data-bs-dismiss="alert" aria-label="Close">&times;</a>
                </div>
            </div>
            <form action=" {{ route('frontend.contact') }}" method="post" id="formValidation">
                @csrf
                <div class="form_group">
                    <div class="form_field">
                        <input type="text" name="name" placeholder="Name" class="form-control contact-field" value="{{ old('name') }}">
                        @error('name')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
						<input type="email" name="email" placeholder="Email Address" class="form-control contact-field" value="{{ old('email') }}">
                        @error('email')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
						<input type="tel" name="mobile" placeholder="Telephone" class="form-control contact-field" value="{{ old('mobile') }}">
						@error('mobile')
						<span class="text-danger">
							{{ $message }}
						</span>
						@enderror
                    </div>
                    <div class="form_field">
						<textarea class="form-control contact-field" name="message" placeholder="Message" id="message">{{ old('message') }}</textarea>
                        @error('message')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror

						<div class="half_field_group">
							<div class="captcha" style="float: left;">
								<span>{!! captcha_img() !!}</span>
								{{--<button type="button" class="btn btn-danger" class="reload" id="reload">
									&#x21bb;
								</button>--}}
							</div>
							<div class="form-group mb-4 half_field">
								<input id="captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha">
                                @error('captcha')
                                    <span class="text-danger">
                                        Enter correct captcha
                                    </span>
                                @enderror
							</div>
						</div>
                    </div>
                </div>
				<div class="form-group captcha_group text-center">
					<input class="btn_primary" type="submit" value="SEND">
                    <input type="hidden" name="csrfHidden" value="{{ session('contact_hidden_csrf') }}"/>
				</div>
            </form>
        </div>
    </div>
</section>
