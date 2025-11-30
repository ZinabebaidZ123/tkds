
        // Countdown Timer
        function updateCountdown() {
            // Set target date to 3 days from now for demo
            const targetDate = new Date().getTime() + (3 * 24 * 60 * 60 * 1000);
            
            const now = new Date().getTime();
            const distance = targetDate - now;

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById('days').textContent = String(days).padStart(2, '0');
            document.getElementById('hours').textContent = String(hours).padStart(2, '0');
            document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
            document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');

            if (distance < 0) {
                document.getElementById('days').textContent = '00';
                document.getElementById('hours').textContent = '00';
                document.getElementById('minutes').textContent = '00';
                document.getElementById('seconds').textContent = '00';
            }
        }

        // Update countdown every second
        updateCountdown();
        setInterval(updateCountdown, 1000);

        // Add some interactive particles on mouse move
        document.addEventListener('mousemove', (e) => {
            if (Math.random() > 0.95) { // Only occasionally create particles
                const particle = document.createElement('div');
                particle.className = 'floating-dots';
                particle.style.left = e.clientX + 'px';
                particle.style.top = e.clientY + 'px';
                particle.style.position = 'fixed';
                particle.style.pointerEvents = 'none';
                particle.style.zIndex = '100';
                document.body.appendChild(particle);
                
                setTimeout(() => {
                    particle.remove();
                }, 3000);
            }
        });

 


        // Particles Animation
        function createParticles() {
            const container = document.getElementById('particles-container');
            if (!container) return;
            
            for (let i = 0; i < 50; i++) {
                const particle = document.createElement('div');
                particle.className = 'floating-particles';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 8 + 's';
                particle.style.animationDuration = (8 + Math.random() * 4) + 's';
                container.appendChild(particle);
            }
        }

        // Countdown Timer
        function updateCountdown() {
            const endDate = new Date();
            endDate.setDate(endDate.getDate() + 15); // 15 days from now
            
            const now = new Date().getTime();
            const distance = endDate.getTime() - now;
            
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            document.getElementById('days').innerText = days.toString().padStart(2, '0');
            document.getElementById('hours').innerText = hours.toString().padStart(2, '0');
            document.getElementById('minutes').innerText = minutes.toString().padStart(2, '0');
            document.getElementById('seconds').innerText = seconds.toString().padStart(2, '0');
        }

        // Services Slider
        let currentSlide = 0;
        const totalSlides = {{ count($services ?? [1,2,3,4]) }};

        function slideServices(direction) {
            const wrapper = document.getElementById('servicesWrapper');
            const dots = document.querySelectorAll('#servicesDots button');
            
            if (direction === 'next') {
                currentSlide = (currentSlide + 1) % totalSlides;
            } else {
                currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            }
            
            wrapper.style.transform = `translateX(-${currentSlide * 100}%)`;
            
            dots.forEach((dot, index) => {
                dot.className = index === currentSlide ? 'w-3 h-3 rounded-full transition-all duration-300 bg-neon-pink' : 'w-3 h-3 rounded-full transition-all duration-300 bg-gray-600';
            });
        }

        function slideToService(index) {
            currentSlide = index;
            slideServices();
        }

        // Auto-slide services
        setInterval(() => slideServices('next'), 5000);

        // Counter Animation
        function animateCounters() {
            const counters = document.querySelectorAll('.counter');
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target'));
                const suffix = counter.textContent.replace(/[0-9]/g, '');
                let current = 0;
                const increment = target / 100;
                
                const updateCounter = () => {
                    if (current < target) {
                        current += increment;
                        counter.textContent = Math.floor(current).toLocaleString() + suffix;
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = target.toLocaleString() + suffix;
                    }
                };
                
                updateCounter();
            });
        }

        // Scroll animations
        function handleScrollAnimations() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        if (entry.target.classList.contains('counter')) {
                            animateCounters();
                        }
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            });

            document.querySelectorAll('.card-3d, .counter').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(50px)';
                el.style.transition = 'all 0.6s ease-out';
                observer.observe(el);
            });
        }

      // Infinite scroll animation for clients
        const scrollAnimation = `
            @keyframes scroll {
                0% { transform: translateX(0); }
                100% { transform: translateX(-50%); }
            }
        `;
        
        // Add scroll animation to head
        const style = document.createElement('style');
        style.textContent = scrollAnimation;
        document.head.appendChild(style);

        // Navbar scroll effect
        function handleNavbarScroll() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 100) {
                navbar.classList.add('bg-dark-card/80', 'backdrop-blur-lg');
            } else {
                navbar.classList.remove('bg-dark-card/80', 'backdrop-blur-lg');
            }
        }

        // Smooth scrolling for internal links
        function smoothScroll() {
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        }

        // Form submission
        function handleFormSubmission() {
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Simple form validation
                    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
                    let isValid = true;
                    
                    inputs.forEach(input => {
                        if (!input.value.trim()) {
                            isValid = false;
                            input.classList.add('border-red-500');
                        } else {
                            input.classList.remove('border-red-500');
                        }
                    });
                    
                    if (isValid) {
                        // Show success message
                        const button = form.querySelector('button[type="submit"]');
                        const originalText = button.innerHTML;
                        button.innerHTML = '<i class="fas fa-check mr-2"></i>MESSAGE SENT!';
                        button.classList.add('bg-green-500');
                        
                        setTimeout(() => {
                            button.innerHTML = originalText;
                            button.classList.remove('bg-green-500');
                        }, 3000);
                        
                        // Reset form
                        form.reset();
                    }
                });
            });
        }

        // 3D card hover effects
        function enhance3DEffects() {
            document.querySelectorAll('.card-3d').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'perspective(1000px) rotateX(10deg) rotateY(10deg) scale(1.05)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) scale(1)';
                });
                
                card.addEventListener('mousemove', function(e) {
                    const rect = this.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;
                    const rotateX = (y - centerY) / 10;
                    const rotateY = (centerX - x) / 10;
                    
                    this.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.05)`;
                });
            });
        }

        // Initialize everything when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            createParticles();
            updateCountdown();
            handleScrollAnimations();
            smoothScroll();
            handleFormSubmission();
            enhance3DEffects();
            
            // Update countdown every second
            setInterval(updateCountdown, 1000);
            
            // Handle navbar scroll
            window.addEventListener('scroll', handleNavbarScroll);
            
            // Handle counter animation on scroll
            let hasCounterAnimated = false;
            window.addEventListener('scroll', function() {
                const statsSection = document.querySelector('#stats-section');
                if (statsSection && !hasCounterAnimated) {
                    const rect = statsSection.getBoundingClientRect();
                    if (rect.top < window.innerHeight) {
                        animateCounters();
                        hasCounterAnimated = true;
                    }
                }
            });
        });

        // Add stats section ID
        document.addEventListener('DOMContentLoaded', function() {
            const statsSection = document.querySelector('section').parentNode.children[6]; // Adjust index as needed
            if (statsSection) {
                statsSection.id = 'stats-section';
            }
        });
     (function() {
            let currentReviewSlide = 0;
            const totalReviewSlides = 6;
            let reviewAutoSlideInterval;
            
            const slidePositions = ['far-left', 'prev', 'active', 'next', 'far-right', 'hidden'];

            function updateReviewSlides() {
                const slides = document.querySelectorAll('#reviewsSlider .review-slide');
                const dots = document.querySelectorAll('#sliderDots .dot');

                slides.forEach((slide, index) => {
                    slidePositions.forEach(pos => slide.classList.remove(pos));
                    
                    let position = index - currentReviewSlide;
                    
                    if (position < -2) position += totalReviewSlides;
                    if (position > 2) position -= totalReviewSlides;
                    
                    switch(position) {
                        case -2: slide.classList.add('far-left'); break;
                        case -1: slide.classList.add('prev'); break;
                        case 0: slide.classList.add('active'); break;
                        case 1: slide.classList.add('next'); break;
                        case 2: slide.classList.add('far-right'); break;
                        default: slide.classList.add('hidden'); break;
                    }
                });

                dots.forEach((dot, index) => {
                    dot.classList.toggle('active', index === currentReviewSlide);
                });
            }

            function slideReviews(direction) {
                if (direction === 'next') {
                    currentReviewSlide = (currentReviewSlide + 1) % totalReviewSlides;
                } else {
                    currentReviewSlide = (currentReviewSlide - 1 + totalReviewSlides) % totalReviewSlides;
                }
                updateReviewSlides();
                resetAutoSlide();
            }

            function slideToReview(index) {
                currentReviewSlide = index;
                updateReviewSlides();
                resetAutoSlide();
            }

            function startAutoSlide() {
                reviewAutoSlideInterval = setInterval(() => {
                    slideReviews('next');
                }, 4000);
            }

            function stopAutoSlide() {
                if (reviewAutoSlideInterval) {
                    clearInterval(reviewAutoSlideInterval);
                }
            }

            function resetAutoSlide() {
                stopAutoSlide();
                setTimeout(startAutoSlide, 3000);
            }

            // Initialize when DOM is ready
            document.addEventListener('DOMContentLoaded', function() {
                // Check if elements exist before adding listeners
                const prevBtn = document.getElementById('prevBtn');
                const nextBtn = document.getElementById('nextBtn');
                const dots = document.querySelectorAll('#sliderDots .dot');
                const slides = document.querySelectorAll('#reviewsSlider .review-slide');
                const reviewSlider = document.getElementById('reviewsSlider');

                if (prevBtn) {
                    prevBtn.addEventListener('click', function() {
                        slideReviews('prev');
                    });
                }
                
                if (nextBtn) {
                    nextBtn.addEventListener('click', function() {
                        slideReviews('next');
                    });
                }
                
                dots.forEach(function(dot, index) {
                    dot.addEventListener('click', function() {
                        slideToReview(index);
                    });
                });

                slides.forEach((slide, index) => {
                    slide.addEventListener('click', function() {
                        if (!this.classList.contains('active')) {
                            slideToReview(index);
                        }
                    });
                });

                if (reviewSlider) {
                    reviewSlider.addEventListener('mouseenter', stopAutoSlide);
                    reviewSlider.addEventListener('mouseleave', startAutoSlide);
                }

                updateReviewSlides();
                startAutoSlide();
            });

            // Touch support
            let startX = 0;
            let endX = 0;

            document.addEventListener('DOMContentLoaded', function() {
                const reviewSlider = document.getElementById('reviewsSlider');
                if (reviewSlider) {
                    reviewSlider.addEventListener('touchstart', function(e) {
                        startX = e.touches[0].clientX;
                    });

                    reviewSlider.addEventListener('touchend', function(e) {
                        endX = e.changedTouches[0].clientX;
                        const threshold = 80;
                        const diff = startX - endX;
                        
                        if (Math.abs(diff) > threshold) {
                            if (diff > 0) {
                                slideReviews('next');
                            } else {
                                slideReviews('prev');
                            }
                        }
                    });
                }
            });

            // Keyboard navigation
            document.addEventListener('keydown', function(e) {
                if (e.key === 'ArrowLeft') {
                    slideReviews('prev');
                } else if (e.key === 'ArrowRight') {
                    slideReviews('next');
                }
            });

        })();
  
