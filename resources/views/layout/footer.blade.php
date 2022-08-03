<footer class="footer footer-bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-4 mb-4 f_width">
                <div class="footer-logo">
                    <img src="{{ asset('assets/images/logo/logo.png') }}" alt="{{ Config::get('app.name') }} logo" class="img-fluid logo_res">
                </div>
                <div class="payment-logo">
                    <img src="{{ asset('assets/images/logo/b_logo-white.svg') }}" alt="{{ Config::get('app.name') }} logo" class="img-fluid">
                </div>
            </div>
            <div class="col-sm-6 col-md-4 mb-4">
                <h4>Quick Links</h4>
                <ul class="usful-link">
                    <li><a href="@if (Request::url() != Config::get('app.url')) {{ Config::get('app.url') }}@endif#contact_us_section">Contact us </a></li>
                    <li><a href="{{ route('terms.conditions') }}">Terms of Service </a></li>
                    <li><a href="{{ route('privacy.policy') }}">Privacy Policy </a></li>
                    <li><a href="{{ route('refund.policy') }}">Refund Policy </a></li>
                    <li><a href="{{ route('about.us') }}">About Us </a></li>
                </ul>
            </div>
        </div>
        <div class="row copy-right">
            <div class="col-sm-12 col-lg-12 ">
                <p class="text-center py-3"> Copyright {{ Config::get('app.name') }} {{ date('Y') }}. All rights reserved</p>
            </div>
        </div>
    </div>
</footer>
