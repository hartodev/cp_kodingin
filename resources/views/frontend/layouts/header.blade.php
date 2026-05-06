<nav class="navbar reveal">
    <div class="nav-container">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="logo">PanduanFlow</a>

        {{-- Menu Navigasi --}}
        <ul class="nav-menu">
            <li><a href="{{ url('/') }}" class="nav-link">Home</a></li>
            <li><a href="{{ url('/courses') }}" class="nav-link">Courses</a></li>
            <li><a href="{{ url('/guides') }}" class="nav-link">Guides</a></li>
            <li><a href="{{ url('/pricing') }}" class="nav-link">Pricing</a></li>
            <li><a href="{{ url('/contact') }}" class="nav-link">Contact</a></li>
        </ul>

        {{-- CTA Button --}}
        <button class="nav-cta">Mulai Gratis</button>

    </div>
</nav>