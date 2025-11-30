<!-- resources/views/components/roku-highlight-section.blade.php -->

<section class="relative bg-[#1a1a1a] py-20 px-6 text-white overflow-hidden">
  <div class="container mx-auto flex flex-col md:flex-row items-center justify-between gap-12">
    
    <!-- LEFT: TEXT -->
    <div class="w-full md:w-1/2">
      <h2 class="text-4xl sm:text-5xl font-extrabold leading-tight mb-6">
        <span class="block text-[#FF2C2C] drop-shadow-[0_0_15px_#FF2C2C] animate-pulse">
          We are the
        </span>
        <span class="block bg-gradient-to-r from-[#FF2C2C] via-[#FF5151] to-[#FF7B7B] text-transparent bg-clip-text drop-shadow-[0_0_25px_rgba(255,77,77,0.8)]">
          #1 Provider
        </span>
      </h2>

      <p class="text-lg text-gray-300 mb-8 leading-relaxed">
        TKDS Media doesn’t follow trends — we set them. <br class="hidden sm:block">
        From sleek Roku channel designs to full-scale OTT domination, we bring the 🔥.
      </p>

      <a href="{{ route('pricing') }}"
         class="inline-block bg-[#FF2C2C] hover:bg-[#FF5151] text-white font-bold py-3 px-6 rounded-xl shadow-[0_0_25px_rgba(255,77,77,0.6)] hover:shadow-[0_0_35px_rgba(255,102,102,0.8)] transition duration-300">
         Let's Build Something Legendary 💥
      </a>
    </div>

    <!-- RIGHT: ROKU LOGO -->
    <div class="w-full md:w-1/2 flex justify-center md:justify-end">
      <div class="relative group">
        <div class="absolute -inset-2 bg-gradient-to-r from-[#FF2C2C] via-[#FF5151] to-[#FF7B7B] blur-xl opacity-40 group-hover:opacity-60 transition duration-500 rounded-3xl"></div>
        <img src="{{ asset('images/roku.png') }}"
             alt="Roku Logo"
             class="relative z-10 h-40 md:h-52 lg:h-60 rounded-3xl shadow-lg transform group-hover:scale-105 transition duration-500" />
      </div>
    </div>

  </div>
</section>
