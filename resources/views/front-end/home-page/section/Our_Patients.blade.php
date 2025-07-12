<div class="features integration patients int_bg pb-35 mb-0">
    <div class="container">
        <div class="review_head">
            <p class="plugin-label">
                <span class="label-line"></span> Customer Feedback
            </p>
            <h2>Trusted by Professionals</h2>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-sm-12 col-12">
                <div class="professionals">
                    <div>
                        <img id="large-image" class="" 
                            src="{{ asset('storage/images/' . ($testimonials->first()->image ?? 'Rectangle 3985.png')) }}" 
                            alt="Professionals Image">
                    </div>
                    <div class="testimonial-section">
                        <div class="testimonial-slider">
                            <div class="testimonial-content patientsSlider" id="patientsSlider">
                                @if($testimonials->isNotEmpty())
                                    @php $firstTestimonial = $testimonials->first(); @endphp
                                    <p class="integra_p testimonial-text">
                                    </p>
                                    <h4 class="patient-name text_blue font_weight">{{ $firstTestimonial->name }}</h4>
                                    <p class="patient-role">{{ $firstTestimonial->designation ?? 'Happy Client' }}</p>
                                @endif
                            </div>
                            <div class="thumbnail-slider">
                                <div class="thumbnails">
                                   @if($testimonials->isNotEmpty())
                                        @foreach($testimonials as $key => $testimonial)
                                            <img src="{{ asset('storage/images/' . $testimonial->image) }}" 
                                                alt="Client {{ $key + 1 }}" 
                                                class="thumbnail {{ $key === 0 ? 'active' : '' }} {{ $key < 3 ? 'visible' : 'hidden' }}">
                                        @endforeach
                                    @endif
                                </div>
                                {{-- <div class="arrow-container w-70 arrows">
                                    <button class="prev-btn arrow left-arrow"></button>
                                    <button class="next-btn arrow right-arrow"></button>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
