@extends('layouts.frontend')

@section('title')
    Visual Merchandising & Point of Purchase Display Projects 
@endsection
@section('meta_description', 'From bespoke shopfitting design and installation to innovative visual merchandising projects including virtual reality to point of purchase display stands.')

@push('styles')
    <style>
        .loader-div {
            visibility: hidden;
        }
    </style>
@endpush

@section('content')
    <section class="projects_page_section">
        <div class="bg_text">
            PROJECTS
        </div>
        <div class="container">
            <div class="banner_content">
                <h1>We're proud of our work...</h1>
                <div class="row">
                    <div class="col-md-6">
                        <p>Our experienced development team are fortunate enough to have worked on hundreds of projects in
                            retail over the years and it’s often word of mouth recommendations that have contributed to our
                            organic growth.
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p> Our work get’s noticed and our name get’s passed around. You’ll see from a small
                            selection of our portfolio below we excel in all aspects of retail display design,
                            manufacturing, production and installation. Whether it be for bespoke shopfitting installations
                            or mass produced point of purchase display stands, we’ll work with you every step of the way.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @if (!$projects->isEmpty())
            <div class="project_listing">
                <div class="container">
                    <div class="projects_outer">

                        @foreach ($projects as $key => $project)
                            <div class="project_box project-list-view">
                                <div data-bs-toggle="modal" data-bs-target="#puma_detail"
                                    data-slide="{{ $key }}" class="project-list-thumbnail">
                                    <div class="project_image_outer">
                                        <img src="{{ $project->thumbnail }}" alt="{{ $project->title }}">
                                    </div>
                                    <div class="project_info">
                                        <h2>{{ Str::upper($project->title) }}</h2>
                                        <p>{{ $project->description }}</p>
                                    </div>
                                    <div class="material_ids d-sm-none">
                                        {{ $project->hash_tags }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="project_box not-loading">
                            <div class="card br">
                                <div class="wrapper">
                                    <div class="animate_content">
                                        <div class="comment br animate"></div>
                                        <div class="comment br animate"></div>
                                        <div class="comment br animate"></div>
                                    </div>
                                    <div class="profilePic animate"></div>
                                </div>
                            </div>
                        </div>
                        <div class="project_box not-loading">
                            <div class="card br">
                                <div class="wrapper">
                                    <div class="animate_content">
                                        <div class="comment br animate"></div>
                                        <div class="comment br animate"></div>
                                        <div class="comment br animate"></div>
                                    </div>
                                    <div class="profilePic animate"></div>
                                </div>
                            </div>
                        </div>
                        @if ($projects->hasPages())
                            @if ($projects->hasMorePages())
                                <div class="load_more">
                                    <button type="button" data-href="{{ $projects->nextPageUrl() }}" id="loadMore"
                                        name="load_more_button">Load More</button>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </section>

    <div class="modal fade" id="puma_detail">
        <button type="button" class="btn-close" data-bs-dismiss="modal">
            <span></span>
            <span></span>
        </button>
        <div class="pop_footer">
            <div class="container">
                <div class="get_touch">GET IN TOUCH</div>
                <ul>
                    <li>Cambridge:<a href="tel:01480492111">01480 492 111</a></li>
                    <li>London:<a href="tel:01480492111">02038 367 756</a></li>
                    <li>Email:<a href="mailto:hello@biginstore.com">hello@biginstore.com</a></li>
                </ul>
            </div>
        </div>
        <div class="modal_slider">
            @foreach ($projects as $pKey => $project)
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal body -->
                        <div class="modal-body">
                            @if(!$project->fullwidth_image)
                                <div class="project_box">
                                    <div id="big_puma{{ $pKey }}" class="carousel slide carousel-fade"
                                        data-bs-ride="carousel">
                                        <div class="carousel-inner mb-5">
                                            <div class="carousel-item active">
                                                <img src="{{ $project->main_image }}" alt="{{ $project->title }}" loading="lazy">
                                            </div>
                                        </div>
                                        <div class="project_info">
                                            <h2>{{ $project->title }}</h2>
                                            <p>{{ $project->description }}</p>
                                            <div class="material_ids">
                                                {{ $project->hash_tags }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="project_box full-width-class">
                                    <div id="big_puma{{ $pKey }}" class="carousel slide carousel-fade"
                                        data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            <div class="carousel-item active">
                                                <img src="{{ $project->main_image }}" alt="{{ $project->title }}" loading="lazy">
                                            </div>
                                            @if (optional($project->getProjectMedia))
                                                @foreach ($project->getProjectMedia as $key => $projectThumbnail)
                                                    <div class="carousel-item">
                                                        <img src="{{ $projectThumbnail->image }}"
                                                            alt="{{ $projectThumbnail->image }}" loading="lazy">
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
										<div class="my slider carousel-indicators" style="margin-bottom: ;">
													<div class="op position-relative">
														<button type="button"
															data-bs-target="#big_puma{{ $pKey }}"
															data-bs-slide-to="0" class="active" aria-current="true"
															aria-label="Slide 1">
															<img src="{{ $project->main_image }}"
																alt="{{ $project->title }}">
														</button>
														@if (optional($project->getProjectMedia))
															@php
																$i = 2;
															@endphp
															@foreach ($project->getProjectMedia as $key => $projectThumbnail)
																@php
																	$key++;
																@endphp
																<button type="button"
																	data-bs-target="#big_puma{{ $pKey }}"
																	data-bs-slide-to="{{ $key }}"
																	aria-label="Slide {{ $i }}">
																	<img src="{{ $projectThumbnail->image }}"
																		alt="{{ $projectThumbnail->image }}">
																</button>
																@php
																	$i++;
																@endphp
															@endforeach
														@endif
													</div>
												</div>
                                    </div>
									<div class="project_info">
                                            <h2>{{ $project->title }}</h2>
                                            <p>{{ $project->description }}</p>


                                            <div class="material_ids">
                                                {{ $project->hash_tags }}
                                            </div>
                                        </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- @include('frontend/section/contact-us') --}}

    <!-- <section class="instagram_section" id="instafeed">
    </section> -->
@endsection
