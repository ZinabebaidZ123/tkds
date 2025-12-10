@php
    $solutions = App\Models\BroadcastingSolution::active()->ordered()->get();
    $firstSolution = $solutions->first();
@endphp

<section>
<div id="slideshow" class="relative w-full h-full overflow-hidden rounded-lg">

<style>
.tv-3d {
  perspective: 1000px;
  transform-style: preserve-3d;
}

.tv-screen {
  transition: all 0.5s ease;
  transform-style: preserve-3d;
}

/* .tv-screen:hover {
  transform: rotateY(5deg) rotateX(2deg) scale(1.02);
} */

.tv-stand::before,
.tv-stand::after {
  content: '';
  position: absolute;
  bottom: -90px;
  width: 100px;
  height: 60px;
  background: linear-gradient(145deg, #1a1a1a, #000);
  border-radius: 8px;
}

.tv-stand::before {
  left: calc(50% - 90px);
  border-radius: 0 100% 0 0;
  transform: rotate(-35deg);
  box-shadow: -5px 5px 15px rgba(0, 0, 0, 0.5);
}

.tv-stand::after {
  left: calc(50% - 10px);
  border-radius: 100% 0 0 0;
  transform: rotate(35deg);
  box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.5);
}

.slide-bg {
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}

.tv-glow {
  box-shadow: 
    0 0 30px rgba(197, 48, 48, 0.3), 
    0 20px 40px rgba(0, 0, 0, 0.6),
    inset 0 0 20px rgba(255, 255, 255, 0.1);
}

.power-btn {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background: linear-gradient(145deg, #2a2a2a, #1a1a1a);
  box-shadow: 
    0 4px 8px rgba(0, 0, 0, 0.3),
    inset 0 0 10px rgba(0, 0, 0, 0.5);
  transition: all 0.3s ease;
  border: 2px solid #444;
}

.power-btn.on {
  background: linear-gradient(145deg, #C53030, #E53E3E);
  box-shadow: 
    0 0 25px rgba(197, 48, 48, 0.8), 
    0 4px 8px rgba(0, 0, 0, 0.3),
    inset 0 0 10px rgba(0, 0, 0, 0.3);
  border-color: #fff;
}

.floating-icons {
  animation: float 6s ease-in-out infinite;
}

@keyframes float {
  0%, 100% { transform: translateY(0px) rotate(0deg); }
  50% { transform: translateY(-20px) rotate(180deg); }
}

.screen-off {
  background: #111 !important;
  transition: all 0.3s ease;
}

.screen-off .slide {
  opacity: 0 !important;
  transition: opacity 0.3s ease;
}

.screen-off .slide-content {
  opacity: 0 !important;
}
</style>

<!-- Broadcasting Showcase Section -->
<section class="relative py-20 bg-gradient-to-b from-dark via-dark-light to-dark overflow-hidden">
  
  {{-- <!-- Floating Background Elements -->
  <div class="absolute inset-0 pointer-events-none">
    <div class="floating-icons absolute top-20 left-10 text-4xl text-primary/30">📺</div>
    <div class="floating-icons absolute top-32 right-20 text-3xl text-secondary/30" style="animation-delay: 1s;">📡</div>
    <div class="floating-icons absolute bottom-40 left-16 text-5xl text-accent/30" style="animation-delay: 2s;">🎥</div>
    <div class="floating-icons absolute bottom-20 right-16 text-3xl text-primary/30" style="animation-delay: 3s;">🔴</div>
    <div class="floating-icons absolute top-1/2 left-20 text-4xl text-secondary/30" style="animation-delay: 4s;">🎬</div>
    <div class="floating-icons absolute top-1/2 right-24 text-3xl text-accent/30" style="animation-delay: 5s;">📹</div>
  </div> --}}

  <div class="container mx-auto px-4">
    
    <!-- Section Header -->
    <div class="text-center mb-8 md:mb-16" data-aos="fade-down">
      <h2 class="text-4xl md:text-5xl font-black text-white mb-4">
        @if($firstSolution && ($firstSolution->title_part1 || $firstSolution->title_part2))
          {!! $firstSolution->getSectionTitle() !!}
        @else
          Our <span class="bg-gradient-to-r from-red-500 to-red-600 bg-clip-text text-transparent">Broadcasting</span>
        @endif
      </h2>
      <p class="text-gray-400 text-lg max-w-2xl mx-auto">
        @if($firstSolution && $firstSolution->subtitle)
          {{ $firstSolution->subtitle }}
        @else
          Experience professional broadcasting across all platforms
        @endif
      </p>
    </div>

    <!-- TV Container -->
    <div class="tv-3d flex justify-center mb-12" data-aos="zoom-in">
      <div class="relative">
        
        <!-- TV Frame -->
        <div class="tv-screen relative bg-black border-[12px] border-gray-900 rounded-xl w-[800px] h-[450px] max-w-[90vw] max-h-[50vw] tv-glow tv-stand shadow-2xl">
          <div class="absolute inset-0 bg-gradient-to-br from-gray-800 via-gray-900 to-black rounded-lg"></div>
          <div class="absolute inset-2 bg-black rounded-lg overflow-hidden shadow-inner">
            
            @if($solutions->count() > 0)
              @foreach($solutions as $index => $solution)
              <!-- Slide {{ $index + 1 }} -->
              <div class="slide absolute inset-0 slide-bg {{ $index === 0 ? 'opacity-100' : 'opacity-0' }} transition-opacity duration-1000" 
                   style="background-image: url('{{ $solution->getImageUrl() }}');">
                <div class="slide-content absolute inset-0 flex items-center justify-center bg-black/60">
                  <div class="text-center text-white p-6 backdrop-blur-sm bg-black/30 rounded-lg">
                    <h3 class="text-2xl font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent mb-2">{{ $solution->title }}</h3>
                    <p class="text-gray-200">{{ $solution->description }}</p>
                  </div>
                </div>
              </div>
              @endforeach
            @else
              <!-- Default Slide if no data -->
              <div class="slide absolute inset-0 slide-bg opacity-100 transition-opacity duration-1000" 
                   style="background-image: url('https://images.unsplash.com/photo-1611532736597-de2d4265fba3?w=800');">
                <div class="slide-content absolute inset-0 flex items-center justify-center bg-black/60">
                  <div class="text-center text-white p-6 backdrop-blur-sm bg-black/30 rounded-lg">
                    <h3 class="text-2xl font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent mb-2">Broadcasting Solutions</h3>
                    <p class="text-gray-200">Professional streaming services coming soon</p>
                  </div>
                </div>
              </div>
            @endif
            
          </div>
          </div>
          
          <!-- Power Button -->
          <button id="powerBtn" class="power-btn on absolute -bottom-16 left-1/2 transform -translate-x-1/2 flex items-center justify-center cursor-pointer z-20">
            <div class="w-5 h-5 border-2 border-white rounded-full flex items-center justify-center">
              <div class="w-1 h-3 bg-white rounded-full"></div>
            </div>
          </button>
          
        </div>
      </div>
    </div>

    <!-- Navigation Dots -->
    @if($solutions->count() > 0)
    <div class="flex justify-center space-x-4 mb-8 mt-28" data-aos="fade-up">
      @foreach($solutions as $index => $solution)
      <button class="dot w-4 h-4 rounded-full {{ $index === 0 ? 'bg-primary' : 'bg-gray-600 hover:bg-primary' }} transition-all duration-300 shadow-lg hover:scale-110" data-slide="{{ $index }}"></button>
      @endforeach
    </div>
    @endif

  </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');
    const powerBtn = document.getElementById('powerBtn');
    const slideshow = document.getElementById('slideshow');
    let currentSlide = 0;
    let isOn = true;
    let slideInterval;

    // Only proceed if we have slides
    if (slides.length === 0) return;

    function nextSlide() {
        if (!isOn || slides.length <= 1) return;
        
        slides[currentSlide].classList.remove('opacity-100');
        slides[currentSlide].classList.add('opacity-0');
        if (dots[currentSlide]) {
            dots[currentSlide].classList.remove('bg-primary');
            dots[currentSlide].classList.add('bg-gray-600');
        }
        
        currentSlide = (currentSlide + 1) % slides.length;
        
        slides[currentSlide].classList.remove('opacity-0');
        slides[currentSlide].classList.add('opacity-100');
        if (dots[currentSlide]) {
            dots[currentSlide].classList.remove('bg-gray-600');
            dots[currentSlide].classList.add('bg-primary');
        }
    }

    function startSlideshow() {
        if (slides.length > 1) {
            slideInterval = setInterval(nextSlide, 3000);
        }
    }

    function stopSlideshow() {
        clearInterval(slideInterval);
    }

    // Power button
    if (powerBtn) {
        powerBtn.addEventListener('click', function() {
            isOn = !isOn;
            
            if (isOn) {
                this.classList.add('on');
                slideshow.classList.remove('screen-off');
                slides[currentSlide].classList.add('opacity-100');
                slides[currentSlide].classList.remove('opacity-0');
                startSlideshow();
            } else {
                this.classList.remove('on');
                slideshow.classList.add('screen-off');
                slides.forEach(slide => {
                    slide.classList.remove('opacity-100');
                    slide.classList.add('opacity-0');
                });
                stopSlideshow();
            }
        });
    }

    // Dot navigation
    dots.forEach((dot, index) => {
        dot.addEventListener('click', function() {
            if (!isOn) return;
            
            slides[currentSlide].classList.remove('opacity-100');
            slides[currentSlide].classList.add('opacity-0');
            if (dots[currentSlide]) {
                dots[currentSlide].classList.remove('bg-primary');
                dots[currentSlide].classList.add('bg-gray-600');
            }
            
            currentSlide = index;
            
            slides[currentSlide].classList.remove('opacity-0');
            slides[currentSlide].classList.add('opacity-100');
            if (dots[currentSlide]) {
                dots[currentSlide].classList.remove('bg-gray-600');
                dots[currentSlide].classList.add('bg-primary');
            }
            
            stopSlideshow();
            startSlideshow();
        });
    });

    // Start slideshow
    if (isOn) {
        startSlideshow();
    }
});
</script>
@endpush