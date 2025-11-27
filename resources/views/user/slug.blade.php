<x-layout-user title="Under Armour - Segmentação">
    <style>
        .carousel-container {
            position: relative;
            width: 100%;
            height: calc(100vh - 113px);
            overflow: hidden;
            border-radius: 10px;
        }


        .carousel-wrapper {
            display: flex;
            width: {{ count($banners) * 100 }}%;
            height: 100%;
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .carousel-slide {
            width: {{ 100 / count($banners) }}%;
            height: 100%;
            position: relative;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
        }


        /* Link que cobre todo o slide */
        .slide-link {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 3;
            cursor: pointer;
        }

        .slide-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1;
        }

        .slide-content {
            text-align: center;
            color: white;
            z-index: 2;
            position: relative;
            max-width: 800px;
            padding: 0 20px;
            pointer-events: none;
            /* Permite que o clique passe através do conteúdo para o link */
        }

        .slide-title {
            font-size: 3.5rem;
            font-weight: 300;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
            opacity: 0;
            transform: translateY(30px);
            animation: slideInUp 1s ease-out 0.3s forwards;
        }

        .slide-subtitle {
            font-size: 1.2rem;
            margin-bottom: 30px;
            opacity: 0;
            transform: translateY(30px);
            animation: slideInUp 1s ease-out 0.6s forwards;
        }

        .slide-description {
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 40px;
            opacity: 0;
            transform: translateY(30px);
            animation: slideInUp 1s ease-out 0.9s forwards;
        }

        .slide-btn {
            display: inline-block;
            padding: 12px 30px;
            background: transparent;
            border: 2px solid white;
            color: white;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            transition: all 0.3s ease;
            opacity: 0;
            transform: translateY(30px);
            animation: slideInUp 1s ease-out 1.2s forwards;
        }

        .slide-btn:hover {
            background: white;
            color: #333;
            transform: translateY(-2px);
        }

        /* Navigation Arrows */
        .nav-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.5);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .nav-arrow:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: white;
            transform: translateY(-50%) scale(1.1);
        }

        .nav-arrow.prev {
            left: 30px;
        }

        .nav-arrow.next {
            right: 30px;
        }

        .nav-arrow svg {
            width: 20px;
            height: 20px;
        }

        /* Dots Navigation */
        .dots-container {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 15px;
            z-index: 10;
        }

        .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.4);
            border: 2px solid rgba(255, 255, 255, 0.6);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .dot.active {
            background: white;
            border-color: white;
            transform: scale(1.2);
        }

        .dot:hover {
            background: rgba(255, 255, 255, 0.8);
            transform: scale(1.1);
        }

        /* Slides Background Images - Geradas dinamicamente */
        @foreach ($banners as $index => $banner)
            .slide-{{ $index + 1 }} {
                background-image: url('/{{ $banner->image }}');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
            }
        @endforeach

        /* Animations */
        @keyframes slideInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .slide-title {
                font-size: 2.5rem;
            }

            .slide-subtitle {
                font-size: 1rem;
            }

            .slide-description {
                font-size: 0.9rem;
            }

            .nav-arrow {
                width: 50px;
                height: 50px;
            }

            .nav-arrow.prev {
                left: 15px;
            }

            .nav-arrow.next {
                right: 15px;
            }

            .dots-container {
                bottom: 20px;
            }
        }

        @media (max-width: 480px) {
            .slide-title {
                font-size: 2rem;
            }

            .slide-content {
                padding: 0 15px;
            }
        }
    </style>
    <main class="lg:flex flex-1">
        <!-- Menu lateral -->
        <x-sidebar activeItem="inicio" />

        <!-- Conteúdo principal -->
        <section class="flex-1 flex flex-col overflow-hidden pt-5 pr-[10px]">

            <div class="carousel-container">
                <div class="carousel-wrapper" id="carouselWrapper">
                    @foreach ($banners as $index => $banner)
                        <div class="carousel-slide slide-{{ $index + 1 }}">
                            @if ($banner->link)
                                <a href="{{ $banner->link }}" target="_blank" rel="noopener noreferrer" class="slide-link"
                                    aria-label="Link do banner {{ $index + 1 }}">
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Navigation Arrows -->
                <div class="nav-arrow prev" onclick="previousSlide()">
                    <svg fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="nav-arrow next" onclick="nextSlide()">
                    <svg fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>

            </div>

        </section>
    </main>

    @push('scripts')
        <script>
            let currentSlide = 0;
            const totalSlides = {{ count($banners) }};
            const wrapper = document.getElementById('carouselWrapper');
            const dots = document.querySelectorAll('.dot');

            function updateSlider() {
                const translateX = -currentSlide * (100 / totalSlides);
                wrapper.style.transform = `translateX(${translateX}%)`;

                // Update dots
                dots.forEach((dot, index) => {
                    dot.classList.toggle('active', index === currentSlide);
                });

                // Reset animations for current slide
                const currentSlideElement = document.querySelectorAll('.carousel-slide')[currentSlide];
                const animations = currentSlideElement.querySelectorAll(
                    '.slide-title, .slide-subtitle, .slide-description, .slide-btn');

                animations.forEach((element, index) => {
                    element.style.animation = 'none';
                    setTimeout(() => {
                        element.style.animation = `slideInUp 1s ease-out ${0.3 + (index * 0.3)}s forwards`;
                    }, 10);
                });
            }

            function nextSlide() {
                currentSlide = (currentSlide + 1) % totalSlides;
                updateSlider();
            }

            function previousSlide() {
                currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                updateSlider();
            }

            function goToSlide(slideIndex) {
                currentSlide = slideIndex;
                updateSlider();
            }

            // Auto-play
            let autoPlayInterval = setInterval(nextSlide, 5000);

            // Pause auto-play on hover
            const container = document.querySelector('.carousel-container');
            container.addEventListener('mouseenter', () => {
                clearInterval(autoPlayInterval);
            });

            container.addEventListener('mouseleave', () => {
                autoPlayInterval = setInterval(nextSlide, 5000);
            });

            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') {
                    previousSlide();
                } else if (e.key === 'ArrowRight') {
                    nextSlide();
                }
            });

            // Touch/Swipe support
            let startX = 0;
            let endX = 0;

            container.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
            });

            container.addEventListener('touchmove', (e) => {
                endX = e.touches[0].clientX;
            });

            container.addEventListener('touchend', () => {
                const threshold = 50;
                if (startX - endX > threshold) {
                    nextSlide();
                } else if (endX - startX > threshold) {
                    previousSlide();
                }
            });

            // Initialize
            updateSlider();
        </script>
    @endpush

</x-layout-user>
