<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PesaMaster - Finance Manager</title>

    @vite(['resources/css/welcome.css', 'resources/js/text_animate.js'])

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
</head>
<body>

    <!-- Header Section -->
    <header>
        <div class="container">
            <div class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="Company Logo" class="logo">
                <h1>PesaMaster</h1>
            </div>
            <nav>
                <ul>
                    <div class="control-links">
                        <li><a href="/">Home</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#pricing">Pricing</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </div>

                    <div class="auth-links">
                        @if (Route::has('login'))
                            @auth
                                <li><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                            @else
                                <li><a href="{{ route('login') }}">Log in</a></li>
                                @if (Route::has('register'))
                                    <li><a href="{{ route('register') }}">Register</a></li>
                                @endif
                            @endauth
                        @endif
                    </div>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="hero">
        <img src="{{ asset('images/background1.jpeg') }}" alt="background image">
        <div class="container">
            <h2>PesaMaster - Your Financial Partner</h2>
            <p></p>
            <a href="{{ route('register') }}" class="cta-button">Get Started</a>
        </div>
    </section>


    <!-- About Section -->
    <section id="about">
        <div class="container">
            <h2>About PesaMaster</h2>
            <p>PesaMaster is a comprehensive finance management system designed to help small businesses track transactions, budget effectively, and generate insightful reports.</p>

            <div class="about-content">
                <div class="about-feature">
                    <h3>Why Choose PesaMaster?</h3>
                    <ul>
                        <li>Track Income & Expenses - Stay on top of your financial health.</li>
                        <li>Real-Time Analytics - Gain insights into your spending habits.</li>
                        <li>Seamless MPesa Integration - Accept and track payments easily.</li>
                        <li>Automated Budgeting - Set financial goals and stick to them.</li>
                        <li>Generate Reports - Download professional financial reports in one click.</li>
                    </ul>
                </div>

                <div class="about-feature">
                    <h3>Who is PesaMaster for?</h3>
                    <p>PesaMaster is built for:</p>
                    <ul>
                        <li>🔹 Small business owners</li>
                        <li>🔹 Freelancers & consultants</li>
                        <li>🔹 Entrepreneurs & startups</li>
                        <li>🔹 Anyone looking to manage their finances efficiently</li>
                    </ul>
                </div>
            </div>

            <div class="about-cta">
                <p>Join thousands of users managing their finances with ease!</p>
                <a href="{{ route('register') }}" class="cta-button">Get Started Now</a>
            </div>
        </div>
    </section>


    <!-- Pricing Section -->
    <section id="pricing">
        <div class="container">
            <h2>Pricing</h2>
            <p>Choose a plan that suits your needs. Whether you're a freelancer, a small business, or a growing enterprise, PesaMaster has the right plan for you.</p>

            <div class="pricing-plans">
                <!-- Free Plan -->
                <div class="plan">
                    <h3>Free Plan</h3>
                    <p>Great for individuals and freelancers looking for basic financial tracking.</p>
                    <ul>
                        <li>Track income & expenses</li>
                        <li>Generate simple reports</li>
                        <li>Basic budgeting tools</li>
                        <li>MPesa Integration</li>
                        <li>Financial reporting</li>
                    </ul>
                    <p class="price">KES 0/month</p>
                    <a href="{{ route('register') }}" class="cta-button">Get Started</a>
                </div>

                <!-- Premium Plan -->
                <div class="plan">
                    <h3>Premium Plan</h3>
                    <p>Perfect for small businesses needing advanced analytics and automation.</p>
                    <ul>
                        <li>Everything in Free Plan</li>
                        <li>Advanced analytics & insights</li>
                        <li>MPesa Integration</li>
                        <li>Customizable budgets</li>
                        <li>Export financial reports</li>
                    </ul>
                    <p class="price">KES 999/month</p>
                    <a href="{{ route('login') }}" class="cta-button">Upgrade Now</a>
                </div>
            </div>

            <p class="pricing-footer">Need a custom plan? <a href="#contact">Contact us</a> for a tailored solution.</p>
        </div>
    </section>


    <!-- Contact Section -->
    <section id="contact">
        <div class="container">
            <h2>Contact Us</h2>
            <p>Email: support@pesamaster.com</p>
            <p>Phone: +254 123 456 789</p>
        </div>
    </section>

    <!-- Footer Section -->
    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} PesaMaster. All Rights Reserved.</p>
        </div>
    </footer>

</body>
</html>
