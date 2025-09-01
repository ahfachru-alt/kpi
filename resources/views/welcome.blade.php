<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'KILANG PERTAMINA INTERNASIONAL') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-image: url('{{ asset("images/kilang.png") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            margin: 0;
            font-family: 'Figtree', sans-serif;
        }
        
        .overlay {
            background: rgba(0, 0, 0, 0.6);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .welcome-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 3rem;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            max-width: 500px;
            width: 90%;
        }
        
        .logo {
            width: 120px;
            height: auto;
            margin-bottom: 1.5rem;
        }
        
        .company-name {
            font-size: 2rem;
            font-weight: 700;
            color: #1a365d;
            margin-bottom: 0.5rem;
            line-height: 1.2;
        }
        
        .company-subtitle {
            font-size: 1.1rem;
            color: #4a5568;
            margin-bottom: 2rem;
            font-weight: 500;
        }
        
        .platform-name {
            font-size: 1.5rem;
            color: #2d3748;
            margin-bottom: 2rem;
            font-weight: 600;
        }
        
        .auth-buttons {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .btn {
            padding: 1rem 2rem;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-block;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #1a365d, #2d3748);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(26, 54, 93, 0.3);
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, #4a5568, #718096);
            color: white;
        }
        
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(74, 85, 104, 0.3);
        }
        
        .features {
            margin-top: 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }
        
        .feature {
            padding: 1rem;
            background: rgba(26, 54, 93, 0.1);
            border-radius: 10px;
            border-left: 4px solid #1a365d;
        }
        
        .feature-icon {
            font-size: 1.5rem;
            color: #1a365d;
            margin-bottom: 0.5rem;
        }
        
        .feature-title {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.25rem;
        }
        
        .feature-desc {
            font-size: 0.9rem;
            color: #4a5568;
        }
        
        @media (max-width: 768px) {
            .welcome-container {
                padding: 2rem;
                margin: 1rem;
            }
            
            .company-name {
                font-size: 1.5rem;
            }
            
            .company-subtitle {
                font-size: 1rem;
            }
            
            .platform-name {
                font-size: 1.25rem;
            }
            
            .features {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="overlay">
        <div class="welcome-container">
            <img src="{{ asset('images/pertamina.png') }}" alt="Pertamina Logo" class="logo">
            
            <h1 class="company-name">KILANG PERTAMINA INTERNASIONAL</h1>
            <p class="company-subtitle">REFINERY UNIT VI BALONGAN</p>
            
            <div class="platform-name">
                <i class="fas fa-video"></i> CCTV Monitoring Platform
            </div>
            
            <div class="features">
                <div class="feature">
                    <div class="feature-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="feature-title">Real-time Monitoring</div>
                    <div class="feature-desc">Live CCTV streams from all locations</div>
                </div>
                
                <div class="feature">
                    <div class="feature-icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <div class="feature-title">Interactive Maps</div>
                    <div class="feature-desc">Location-based CCTV viewing</div>
                </div>
                
                <div class="feature">
                    <div class="feature-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="feature-title">Smart Notifications</div>
                    <div class="feature-desc">Instant alerts and updates</div>
                </div>
                
                <div class="feature">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="feature-title">Analytics Dashboard</div>
                    <div class="feature-desc">Comprehensive monitoring data</div>
                </div>
            </div>
            
            <div class="auth-buttons">
                <a href="{{ route('login') }}" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
                <a href="{{ route('register') }}" class="btn btn-secondary">
                    <i class="fas fa-user-plus"></i> Register
                </a>
            </div>
        </div>
    </div>
</body>
</html>