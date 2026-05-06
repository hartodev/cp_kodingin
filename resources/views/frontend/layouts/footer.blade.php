<footer class="footer reveal">
    <div class="footer-grid">

        {{-- Brand --}}
        <div>
            <div class="footer-logo">PanduanFlow</div>
            <p class="footer-desc">Future of learning. Designed for the next generation of professionals.</p>
        </div>

        {{-- Platform --}}
        <div>
            <div class="footer-heading">Platform</div>
            <ul class="footer-links">
                <li><a href="{{ url('/courses') }}">Courses</a></li>
                <li><a href="{{ url('/guides') }}">Guides</a></li>
                <li><a href="{{ url('/mentors') }}">Mentors</a></li>
                <li><a href="{{ url('/pricing') }}">Pricing</a></li>
            </ul>
        </div>

        {{-- Company --}}
        <div>
            <div class="footer-heading">Company</div>
            <ul class="footer-links">
                <li><a href="{{ url('/about') }}">About</a></li>
                <li><a href="{{ url('/careers') }}">Careers</a></li>
                <li><a href="{{ url('/blog') }}">Blog</a></li>
                <li><a href="{{ url('/press') }}">Press</a></li>
            </ul>
        </div>

        {{-- Contact --}}
        <div>
            <div class="footer-heading">Contact</div>
            <ul class="footer-links">
                <li>hello@panduanflow.com</li>
                <li>+62 812-3456-7890</li>
                <li><a href="#" target="_blank" rel="noopener">Instagram</a></li>
                <li><a href="#" target="_blank" rel="noopener">LinkedIn</a></li>
            </ul>
        </div>

    </div>

    <div class="footer-bottom">
        <span class="footer-copy">&copy; {{ date('Y') }} PanduanFlow. All rights reserved.</span>
        <span class="footer-copy">Made with &hearts; in Indonesia</span>
    </div>
</footer>