<div class="features integration patients int_bg pb-35 mb-0">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-12 col-sm-12 col-12">
                {{-- <img class="mt-65" src="{{ asset('front-end/images/Group 5685.png') }}" alt="not found"> --}}
                 <p class="plugin-label">
                    <span class="label-line"></span> Testimonial
                 </p>
                <h2>Happy <span class="underline">Clients</span></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6 col-lg-12 col-sm-12 col-12 patientsSlider" id="patientsSlider">
                <div>
                    <img id="large-image" class="mt-65 w-50 h-auto" 
                         src="{{ asset('storage/images/' . ($testimonials->first()->image ?? 'Rectangle 3985.png')) }}" 
                         alt="not found" style="min-width: 75%;">
                </div>
            </div>
            <div class="col-xl-6 col-lg-12 col-sm-12 col-12 mt-2">
                <div class="">
                    <div class="testimonial-section">
                        <div class="testimonial-slider">
                            <div class="testimonial-content patientsSlider" id="patientsSlider">
                                @if($testimonials->isNotEmpty())
                                    @php $firstTestimonial = $testimonials->first(); @endphp
                                    <p class="integra_p mt-65 mb-60 testimonial-text">
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
                                <div class="arrow-container w-70 arrows">
                                    <button class="prev-btn arrow left-arrow"></button>
                                    <button class="next-btn arrow right-arrow"></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
