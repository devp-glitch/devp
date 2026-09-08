<?php
// ===== PHP CONFIGURATION =====
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ===== PHP VARIABLES =====
$pageTitle = "Dev Patel · Software Developer · Gujarat → Tanzania → Newfoundland";
$currentYear = date("Y");

// ===== PHP FORM HANDLING =====
$formSubmitted = false;
$formSuccess = false;
$formError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_contact'])) {
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $message = htmlspecialchars($_POST['message'] ?? '');
    
    if (!empty($name) && !empty($email) && !empty($message) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $formSuccess = true;
        $formSubmitted = true;
    } else {
        $formError = true;
        $formSubmitted = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $pageTitle; ?></title>
    <meta name="description" content="Dev Patel — Software Developer, CS student at Memorial University. Born in Gujarat, raised in Tanzania, now in Newfoundland." />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        :root {
            --bg: #0a0808;
            --bg2: #12100e;
            --card: rgba(20, 18, 16, 0.92);
            --text: #f0ede8;
            --text2: #b8b0a8;
            --text3: #706860;
            
            /* Taj Mahal - Warm marble & gold */
            --marble: #e8ddd0;
            --marble-dark: #c4b8a8;
            --gold: #d4a843;
            --gold-glow: rgba(212, 168, 67, 0.15);
            
            /* Tanzania - Savannah & National Park */
            --savanna: #c4a882;
            --acacia: #8a9a6a;
            --sunset: #e07040;
            --sunset-glow: rgba(224, 112, 64, 0.12);
            
            /* Newfoundland - Aurora & Atlantic */
            --aurora-green: #40e0a0;
            --aurora-purple: #8a6ad0;
            --aurora-blue: #4080d0;
            --atlantic: #1a3a5a;
            
            --accent: #6ac8b0;
            --accent2: #4a8a7a;
            --silver: #c8c0b8;
            --dark-silver: #888078;
            --carbon: #1a1816;
            --border: rgba(200, 180, 160, 0.08);
            --radius: 12px;
            --radius-sm: 8px;
            --shadow: 0 8px 32px rgba(0, 0, 0, 0.6);
        }
        .light {
            --bg: #f5f0ea;
            --bg2: #e8e0d8;
            --card: rgba(245, 240, 234, 0.92);
            --text: #1a1816;
            --text2: #4a4440;
            --text3: #7a7268;
            --carbon: #e0d8d0;
            --border: rgba(100, 80, 60, 0.1);
            --shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        }
        html {
            scroll-behavior: smooth;
            scroll-padding-top: 100px;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            transition: background 0.4s, color 0.3s;
            line-height: 1.6;
            overflow-x: hidden;
            min-height: 100vh;
        }

        /* ===== AURORA BACKGROUND (Newfoundland) ===== */
        #auroraCanvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
            opacity: 0.4;
        }
        
        /* ===== TAJ MAHAL DOME PATTERN OVERLAY ===== */
        .taj-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
            background: 
                radial-gradient(ellipse at 50% 10%, rgba(212, 168, 67, 0.03) 0%, transparent 50%),
                radial-gradient(ellipse at 20% 80%, rgba(200, 180, 160, 0.02) 0%, transparent 40%),
                radial-gradient(ellipse at 80% 80%, rgba(200, 180, 160, 0.02) 0%, transparent 40%);
            opacity: 0.6;
        }

        /* ===== SAVANNAH GRASS TEXTURE ===== */
        .savanna-texture {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 120px;
            pointer-events: none;
            z-index: 0;
            background: 
                repeating-linear-gradient(
                    75deg,
                    transparent 0px,
                    transparent 10px,
                    rgba(138, 154, 106, 0.03) 10px,
                    rgba(138, 154, 106, 0.03) 12px,
                    transparent 12px,
                    transparent 22px
                ),
                repeating-linear-gradient(
                    -75deg,
                    transparent 0px,
                    transparent 8px,
                    rgba(196, 168, 130, 0.02) 8px,
                    rgba(196, 168, 130, 0.02) 10px,
                    transparent 10px,
                    transparent 20px
                );
        }

        /* ===== INTRO OVERLAY ===== */
        #introOverlay {
            position: fixed;
            inset: 0;
            z-index: 10000;
            background: #0a0808;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: opacity 0.8s ease, transform 0.8s ease;
            overflow: hidden;
        }
        #introOverlay.hide {
            opacity: 0;
            transform: scale(1.05);
            pointer-events: none;
        }

        .intro-bg {
            position: absolute;
            inset: 0;
            overflow: hidden;
        }
        
        /* Intro: Aurora waves */
        .intro-bg .aurora-wave {
            position: absolute;
            width: 200%;
            height: 100%;
            background: 
                radial-gradient(ellipse at 30% 50%, rgba(64, 224, 160, 0.06) 0%, transparent 50%),
                radial-gradient(ellipse at 70% 30%, rgba(138, 106, 208, 0.05) 0%, transparent 40%),
                radial-gradient(ellipse at 50% 70%, rgba(64, 128, 208, 0.04) 0%, transparent 40%);
            animation: auroraDrift 8s ease-in-out infinite alternate;
        }
        .intro-bg .aurora-wave:nth-child(2) {
            animation-delay: 3s;
            opacity: 0.6;
        }
        
        @keyframes auroraDrift {
            0% { transform: translateX(-20%) scale(1); }
            100% { transform: translateX(20%) scale(1.2); }
        }

        /* Intro: Taj Mahal dome silhouette */
        .intro-dome {
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 300px;
            height: 200px;
            opacity: 0.04;
            background: 
                radial-gradient(ellipse at 50% 100%, #e8ddd0 0%, transparent 70%);
            border-radius: 50% 50% 0 0;
        }
        .intro-dome::before {
            content: '';
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 30px;
            background: radial-gradient(ellipse at 50% 100%, #e8ddd0 0%, transparent 70%);
            border-radius: 50% 50% 0 0;
        }

        /* Intro: Acacia tree silhouette */
        .intro-acacia {
            position: absolute;
            bottom: 0;
            right: 10%;
            width: 80px;
            height: 150px;
            opacity: 0.03;
        }
        .intro-acacia .trunk {
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 4px;
            height: 100px;
            background: #8a9a6a;
            transform: translateX(-50%);
        }
        .intro-acacia .canopy {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 50px;
            background: radial-gradient(ellipse at 50% 100%, #8a9a6a 0%, transparent 70%);
            border-radius: 50%;
        }

        .skip-intro {
            position: absolute;
            top: 30px;
            right: 30px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: var(--text2);
            padding: 8px 20px;
            border-radius: 30px;
            font-size: 0.7rem;
            cursor: pointer;
            transition: all 0.3s;
            z-index: 10;
            font-family: 'Inter', sans-serif;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .skip-intro:hover {
            background: rgba(255, 255, 255, 0.12);
            color: #fff;
            border-color: var(--aurora-green);
        }

        /* Intro content */
        .intro-icon {
            font-size: clamp(3rem, 6vw, 5rem);
            opacity: 0;
            animation: iconReveal 1s ease 0.3s forwards;
            filter: drop-shadow(0 0 40px rgba(64, 224, 160, 0.2));
            position: relative;
            z-index: 2;
        }
        @keyframes iconReveal {
            0% { opacity: 0; transform: scale(0.5) rotate(-10deg); }
            100% { opacity: 1; transform: scale(1) rotate(0deg); }
        }

        .intro-name {
            margin-top: 20px;
            font-size: clamp(3rem, 7vw, 5.5rem);
            font-weight: 900;
            letter-spacing: -2px;
            background: linear-gradient(135deg, 
                var(--marble) 0%, 
                var(--gold) 30%, 
                var(--aurora-green) 60%, 
                var(--aurora-purple) 85%, 
                var(--marble) 100%
            );
            background-size: 300% 300%;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            opacity: 0;
            animation: nameReveal 1s ease 0.6s forwards, gradientShift 4s ease-in-out infinite 1.6s;
            text-align: center;
            position: relative;
            z-index: 2;
        }
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .intro-title {
            font-size: clamp(0.7rem, 1.1vw, 1.1rem);
            color: var(--text2);
            letter-spacing: 8px;
            text-transform: uppercase;
            opacity: 0;
            animation: nameReveal 1s ease 1s forwards;
            margin-top: 10px;
            position: relative;
            z-index: 2;
        }
        .intro-divider {
            width: 80px;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), var(--aurora-green), transparent);
            opacity: 0;
            animation: nameReveal 0.8s ease 1.2s forwards;
            margin-top: 16px;
            position: relative;
            z-index: 2;
        }
        .intro-loading {
            margin-top: 30px;
            display: flex;
            gap: 14px;
            align-items: center;
            opacity: 0;
            animation: nameReveal 0.8s ease 1.4s forwards;
            position: relative;
            z-index: 2;
        }
        .intro-loading .bar {
            width: 160px;
            height: 3px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 2px;
            overflow: hidden;
            position: relative;
        }
        .intro-loading .bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, var(--gold), var(--aurora-green), var(--aurora-purple));
            border-radius: 2px;
            animation: loadingBar 1.5s ease 1.4s forwards;
        }
        @keyframes loadingBar {
            0% { left: -100%; }
            100% { left: 100%; }
        }
        .intro-loading .label {
            font-size: 0.6rem;
            color: var(--text3);
            letter-spacing: 4px;
            text-transform: uppercase;
        }

        @keyframes nameReveal {
            0% { opacity: 0; transform: translateY(25px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        /* ===== NAVIGATION ===== */
        nav {
            position: fixed;
            top: 18px;
            left: 50%;
            transform: translateX(-50%);
            width: 92%;
            max-width: 1280px;
            padding: 8px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            backdrop-filter: blur(24px) saturate(1.4);
            -webkit-backdrop-filter: blur(24px) saturate(1.4);
            background: rgba(10, 8, 8, 0.85);
            border-radius: 60px;
            z-index: 1000;
            border: 1px solid var(--border);
            transition: all 0.3s;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
        }
        .light nav {
            background: rgba(245, 240, 234, 0.85);
        }
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .logo-icon {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, var(--gold), var(--aurora-green));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            font-size: 0.9rem;
            color: #fff;
            flex-shrink: 0;
            border: 2px solid var(--marble);
        }
        .logo-text {
            font-size: 1.2rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            background: linear-gradient(135deg, var(--marble), var(--gold));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .logo-sub {
            font-size: 0.5rem;
            color: var(--aurora-green);
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            display: block;
        }
        nav ul {
            display: flex;
            gap: 1.8rem;
            list-style: none;
        }
        nav ul li a {
            color: var(--text2);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.7rem;
            transition: color 0.2s;
            position: relative;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        nav ul li a::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--gold), var(--aurora-green));
            transition: width 0.3s ease;
        }
        nav ul li a:hover {
            color: var(--text);
        }
        nav ul li a:hover::after {
            width: 100%;
        }
        .theme-toggle {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid var(--border);
            font-size: 1.1rem;
            border-radius: 50px;
            padding: 4px 14px;
            cursor: pointer;
            color: var(--text);
            transition: 0.2s;
            flex-shrink: 0;
        }
        .theme-toggle:hover {
            background: rgba(255, 255, 255, 0.12);
        }

        /* ===== SECTIONS ===== */
        section {
            position: relative;
            z-index: 2;
            padding: 120px 8% 100px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* ===== HERO ===== */
        #hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding-top: 100px;
        }
        .hero-content {
            max-width: 900px;
        }
        .hero-badge {
            display: inline-block;
            padding: 6px 24px;
            border-radius: 60px;
            background: rgba(212, 168, 67, 0.08);
            border: 1px solid rgba(212, 168, 67, 0.15);
            font-size: 0.6rem;
            font-weight: 700;
            color: var(--gold);
            margin-bottom: 24px;
            letter-spacing: 3px;
            text-transform: uppercase;
            backdrop-filter: blur(8px);
        }
        .hero-badge i {
            margin: 0 4px;
        }
        .hero-title {
            font-size: clamp(2.8rem, 8vw, 5.5rem);
            font-weight: 900;
            line-height: 1.05;
            background: linear-gradient(135deg, 
                var(--marble) 15%, 
                var(--gold) 35%, 
                var(--aurora-green) 55%, 
                var(--aurora-purple) 75%,
                var(--marble) 100%
            );
            background-size: 300% 300%;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: gradientShift 6s ease-in-out infinite;
            margin-bottom: 8px;
        }
        .hero-subtitle {
            font-size: clamp(0.8rem, 1.3vw, 1.1rem);
            color: var(--aurora-green);
            font-weight: 700;
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-bottom: 16px;
        }
        .hero-sub {
            font-size: clamp(0.95rem, 1.2vw, 1.1rem);
            color: var(--text2);
            max-width: 640px;
            margin: 0 auto 32px;
            line-height: 1.8;
        }
        .hero-sub .highlight-gold { color: var(--gold); font-weight: 600; }
        .hero-sub .highlight-green { color: var(--aurora-green); font-weight: 600; }
        .hero-sub .highlight-marble { color: var(--marble); font-weight: 600; }

        .hero-actions {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn-primary,
        .btn-secondary {
            padding: 14px 34px;
            border-radius: 60px;
            font-weight: 700;
            font-size: 0.75rem;
            border: none;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.22, 1, 0.36, 1);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .btn-primary {
            background: linear-gradient(95deg, var(--gold), var(--aurora-green));
            color: #0a0808;
            box-shadow: 0 6px 20px rgba(212, 168, 67, 0.2);
        }
        .btn-primary:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 12px 28px rgba(212, 168, 67, 0.35);
        }
        .btn-secondary {
            background: rgba(255, 255, 255, 0.05);
            border: 1.5px solid var(--border);
            color: var(--text);
        }
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-3px);
            border-color: var(--gold);
        }

        /* ===== SECTION LABELS ===== */
        .section-label {
            display: inline-block;
            font-size: 0.6rem;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 8px;
        }
        .section-title {
            font-size: clamp(2rem, 3.5vw, 2.8rem);
            font-weight: 800;
            margin-bottom: 12px;
            letter-spacing: -0.02em;
        }
        .section-desc {
            color: var(--text2);
            max-width: 560px;
            margin-bottom: 48px;
        }
        .text-center {
            text-align: center;
        }
        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }

        /* ===== JOURNEY MAP (3 continents) ===== */
        .journey-map {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin: 40px 0 30px;
            padding: 20px 0;
            position: relative;
        }
        .journey-map::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 10%;
            right: 10%;
            height: 2px;
            background: linear-gradient(90deg, var(--gold), var(--aurora-green), var(--aurora-purple));
            opacity: 0.2;
            transform: translateY(-50%);
        }
        .journey-stop {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            z-index: 2;
            background: var(--bg);
            padding: 12px 20px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            flex: 1;
        }
        .journey-stop .flag {
            font-size: 2rem;
        }
        .journey-stop .place {
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--text);
        }
        .journey-stop .detail {
            font-size: 0.55rem;
            color: var(--text3);
            text-align: center;
        }
        .journey-stop .icon {
            font-size: 1.2rem;
        }
        .journey-stop .icon.taj { color: var(--gold); }
        .journey-stop .icon.savanna { color: var(--savanna); }
        .journey-stop .icon.aurora { color: var(--aurora-green); }

        /* ===== ABOUT ===== */
        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 48px;
            align-items: start;
        }
        .about-text p {
            color: var(--text2);
            margin-bottom: 16px;
            font-size: 1.05rem;
        }
        .about-text .story-highlight {
            color: var(--gold);
            font-weight: 600;
        }
        .about-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-top: 24px;
        }
        .stat-item {
            background: var(--card);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: var(--radius-sm);
            padding: 20px 16px;
            text-align: center;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
        }
        .stat-number {
            font-size: 2rem;
            font-weight: 900;
            background: linear-gradient(135deg, var(--gold), var(--aurora-green));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .stat-label {
            font-size: 0.65rem;
            color: var(--text3);
            margin-top: 4px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* ===== SKILLS ===== */
        .skill-grid {
            display: grid;
            gap: 16px;
        }
        .skill-item {
            background: var(--card);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: var(--radius-sm);
            padding: 16px 20px;
            border: 1px solid var(--border);
            transition: all 0.3s;
            box-shadow: var(--shadow);
        }
        .skill-item:hover {
            border-color: var(--gold);
            transform: translateX(6px);
        }
        .skill-item .skill-name {
            display: flex;
            justify-content: space-between;
            font-weight: 600;
            margin-bottom: 6px;
            font-size: 0.9rem;
        }
        .skill-bar {
            height: 4px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 4px;
            overflow: hidden;
        }
        .skill-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--gold), var(--aurora-green));
            border-radius: 4px;
            width: 0%;
            transition: width 1.2s cubic-bezier(0.22, 1, 0.36, 1);
        }

        /* ===== TIMELINE ===== */
        .timeline {
            position: relative;
            padding-left: 32px;
        }
        .timeline::before {
            content: '';
            position: absolute;
            left: 6px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(180deg, var(--gold), var(--aurora-green), var(--aurora-purple));
            opacity: 0.2;
        }
        .timeline-item {
            position: relative;
            margin-bottom: 40px;
            padding-left: 20px;
        }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -26px;
            top: 6px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gold), var(--aurora-green));
            border: 2px solid var(--bg);
            box-shadow: 0 0 0 4px rgba(212, 168, 67, 0.12);
        }
        .timeline-item .date {
            font-size: 0.65rem;
            color: var(--gold);
            font-weight: 700;
            letter-spacing: 1px;
        }
        .timeline-item h3 {
            font-size: 1.2rem;
            margin: 4px 0 2px;
        }
        .timeline-item .company {
            color: var(--text2);
            font-weight: 500;
        }
        .timeline-item p {
            color: var(--text3);
            font-size: 0.95rem;
            margin-top: 6px;
        }

        /* ===== PROJECTS ===== */
        .projects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 28px;
        }
        .project-card {
            background: var(--card);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: var(--radius);
            padding: 28px 24px;
            border: 1px solid var(--border);
            transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }
        .project-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--gold), var(--aurora-green), var(--aurora-purple));
            opacity: 0;
            transition: opacity 0.3s;
        }
        .project-card:hover::before {
            opacity: 1;
        }
        .project-card:hover {
            transform: translateY(-8px);
            border-color: var(--gold);
            box-shadow: 0 24px 48px -12px rgba(212, 168, 67, 0.15);
        }
        .project-card .project-icon {
            font-size: 2.5rem;
            margin-bottom: 12px;
            display: block;
        }
        .project-card h3 {
            font-size: 1.3rem;
            margin-bottom: 6px;
        }
        .project-card .project-sub {
            font-size: 0.75rem;
            color: var(--text3);
            font-weight: 500;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }
        .project-card p {
            color: var(--text2);
            font-size: 0.95rem;
            margin-bottom: 16px;
        }
        .project-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 18px;
        }
        .project-tag {
            padding: 3px 14px;
            border-radius: 40px;
            background: rgba(212, 168, 67, 0.08);
            font-size: 0.55rem;
            font-weight: 600;
            color: var(--gold);
            border: 1px solid rgba(212, 168, 67, 0.08);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .project-tag.in-progress {
            background: rgba(64, 224, 160, 0.12);
            color: var(--aurora-green);
            border-color: rgba(64, 224, 160, 0.15);
        }
        .project-links {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        .project-links a,
        .project-links button {
            padding: 8px 18px;
            border-radius: 40px;
            font-size: 0.65rem;
            font-weight: 600;
            text-decoration: none;
            transition: 0.2s;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .project-links .demo-link {
            background: linear-gradient(95deg, var(--gold), var(--aurora-green));
            color: #0a0808;
        }
        .project-links .code-link {
            background: rgba(255, 255, 255, 0.04);
            color: var(--text2);
            border: 1px solid var(--border);
        }
        .project-links .code-link.disabled {
            opacity: 0.4;
            cursor: default;
            pointer-events: none;
        }
        .project-links .coming-soon {
            background: rgba(255, 255, 255, 0.02);
            color: var(--text3);
            border: 1px solid var(--border);
            cursor: default;
            opacity: 0.6;
        }
        .project-links a:hover {
            transform: translateY(-2px);
        }

        /* ===== TECH CATEGORIES ===== */
        .tech-categories {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
        }
        .tech-cat {
            background: var(--card);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: var(--radius-sm);
            padding: 24px 20px;
            border: 1px solid var(--border);
            text-align: center;
            transition: 0.3s;
            box-shadow: var(--shadow);
        }
        .tech-cat:hover {
            border-color: var(--aurora-green);
            transform: translateY(-4px);
        }
        .tech-cat .icon {
            font-size: 2.2rem;
            margin-bottom: 8px;
            display: block;
        }
        .tech-cat h4 {
            font-weight: 700;
            margin-bottom: 4px;
        }
        .tech-cat p {
            font-size: 0.75rem;
            color: var(--text3);
        }

        /* ===== EDUCATION ===== */
        .edu-card {
            background: var(--card);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: var(--radius);
            padding: 32px;
            border: 1px solid var(--border);
            max-width: 700px;
            margin: 0 auto;
            box-shadow: var(--shadow);
        }
        .edu-card h3 {
            font-size: 1.5rem;
        }
        .edu-card .meta {
            color: var(--aurora-green);
            font-weight: 600;
        }
        .edu-card ul {
            list-style: none;
            margin-top: 12px;
        }
        .edu-card ul li {
            padding: 4px 0;
            color: var(--text2);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .edu-card ul li::before {
            content: '▹';
            color: var(--gold);
        }

        /* ===== RESUME ===== */
        .resume-actions {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        /* ===== CONTACT ===== */
        .contact-form {
            max-width: 600px;
            margin: 0 auto;
            background: var(--card);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: var(--radius);
            padding: 40px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
        }
        .contact-form .form-group {
            margin-bottom: 20px;
        }
        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 14px 20px;
            border-radius: var(--radius-sm);
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border);
            color: var(--text);
            font-size: 1rem;
            outline: none;
            transition: 0.2s;
            font-family: 'Inter', sans-serif;
        }
        .contact-form input:focus,
        .contact-form textarea:focus {
            border-color: var(--gold);
            background: rgba(255, 255, 255, 0.05);
        }
        .contact-form textarea {
            height: 140px;
            resize: vertical;
        }
        .contact-form button {
            width: 100%;
            padding: 14px;
            border-radius: var(--radius-sm);
            background: linear-gradient(95deg, var(--gold), var(--aurora-green));
            border: none;
            color: #0a0808;
            font-weight: 700;
            font-size: 0.85rem;
            cursor: pointer;
            transition: 0.2s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .contact-form button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(212, 168, 67, 0.25);
        }
        .alert {
            padding: 15px 20px;
            border-radius: var(--radius-sm);
            margin-bottom: 20px;
            font-weight: 600;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        .alert-success {
            background: rgba(64, 224, 160, 0.12);
            border: 1px solid rgba(64, 224, 160, 0.2);
            color: var(--aurora-green);
        }
        .alert-error {
            background: rgba(255, 50, 50, 0.12);
            border: 1px solid rgba(255, 50, 50, 0.2);
            color: #ff6b6b;
        }

        /* ===== SOCIAL ===== */
        .social-links {
            display: flex;
            justify-content: center;
            gap: 28px;
            margin-top: 40px;
        }
        .social-links a {
            font-size: 1.8rem;
            color: var(--text3);
            transition: 0.2s;
            text-decoration: none;
        }
        .social-links a:hover {
            color: var(--gold);
            transform: translateY(-4px);
        }

        /* ===== FOOTER ===== */
        footer {
            text-align: center;
            padding: 40px 8% 30px;
            border-top: 1px solid var(--border);
            color: var(--text3);
            font-size: 0.8rem;
            position: relative;
            z-index: 2;
        }
        footer .footer-flags {
            font-size: 1.2rem;
            letter-spacing: 8px;
            display: block;
            margin-bottom: 10px;
        }

        /* ===== REVEAL ANIMATIONS ===== */
        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .reveal-stagger {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.7s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .reveal-stagger.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .reveal-stagger:nth-child(1) { transition-delay: 0.05s; }
        .reveal-stagger:nth-child(2) { transition-delay: 0.1s; }
        .reveal-stagger:nth-child(3) { transition-delay: 0.15s; }
        .reveal-stagger:nth-child(4) { transition-delay: 0.2s; }
        .reveal-stagger:nth-child(5) { transition-delay: 0.25s; }

        /* ===== CURSOR GLOW ===== */
        .cursor-glow {
            position: fixed;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(212, 168, 67, 0.04) 0%, transparent 70%);
            pointer-events: none;
            transform: translate(-50%, -50%);
            z-index: 1;
            transition: left 0.1s ease, top 0.1s ease;
        }

        /* ===== AI CHATBOT ===== */
        .chatbot-container {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 9999;
            width: 380px;
            max-width: 90vw;
            height: 500px;
            max-height: 80vh;
            background: var(--card);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 20px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transition: transform 0.3s cubic-bezier(0.22, 1, 0.36, 1), opacity 0.3s;
        }
        .chatbot-container.hidden {
            transform: translateY(calc(100% + 40px));
            opacity: 0;
            pointer-events: none;
        }
        .chatbot-header {
            padding: 16px 20px;
            background: linear-gradient(135deg, rgba(212, 168, 67, 0.2), rgba(64, 224, 160, 0.1));
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
            cursor: pointer;
        }
        .chatbot-header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .chatbot-avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--gold), var(--aurora-green));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: #0a0808;
            font-weight: 900;
            border: 2px solid var(--marble);
        }
        .chatbot-title {
            font-weight: 700;
            font-size: 0.9rem;
            background: linear-gradient(135deg, var(--gold), var(--aurora-green));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .chatbot-status {
            font-size: 0.6rem;
            color: var(--aurora-green);
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .chatbot-status .dot {
            width: 6px;
            height: 6px;
            background: var(--aurora-green);
            border-radius: 50%;
            animation: pulse 1.5s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 0.3; transform: scale(0.8); }
            50% { opacity: 1; transform: scale(1.2); }
        }
        .chatbot-close {
            background: none;
            border: none;
            color: var(--text2);
            font-size: 1.2rem;
            cursor: pointer;
            transition: 0.2s;
            padding: 4px 8px;
            border-radius: 8px;
        }
        .chatbot-close:hover {
            background: rgba(255, 255, 255, 0.05);
            color: var(--text);
        }
        .chatbot-toggle {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 9998;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gold), var(--aurora-green));
            border: 2px solid var(--marble);
            color: #0a0808;
            font-size: 1.5rem;
            cursor: pointer;
            box-shadow: 0 8px 30px rgba(212, 168, 67, 0.3);
            transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
        }
        .chatbot-toggle:hover {
            transform: scale(1.1);
            box-shadow: 0 12px 40px rgba(212, 168, 67, 0.4);
        }
        .chatbot-toggle.hidden {
            transform: scale(0);
            opacity: 0;
            pointer-events: none;
        }
        .chatbot-messages {
            flex: 1;
            overflow-y: auto;
            padding: 16px 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            scroll-behavior: smooth;
        }
        .chatbot-messages::-webkit-scrollbar {
            width: 4px;
        }
        .chatbot-messages::-webkit-scrollbar-track {
            background: transparent;
        }
        .chatbot-messages::-webkit-scrollbar-thumb {
            background: var(--gold);
            border-radius: 4px;
        }
        .message {
            max-width: 85%;
            padding: 10px 16px;
            border-radius: 16px;
            font-size: 0.85rem;
            line-height: 1.5;
            animation: messageSlide 0.3s ease;
        }
        @keyframes messageSlide {
            0% { opacity: 0; transform: translateY(10px) scale(0.95); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }
        .message.bot {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border);
            align-self: flex-start;
            border-bottom-left-radius: 4px;
        }
        .message.user {
            background: linear-gradient(135deg, rgba(212, 168, 67, 0.2), rgba(64, 224, 160, 0.1));
            border: 1px solid rgba(212, 168, 67, 0.15);
            align-self: flex-end;
            border-bottom-right-radius: 4px;
        }
        .message .timestamp {
            font-size: 0.55rem;
            color: var(--text3);
            margin-top: 4px;
            display: block;
        }
        .chatbot-input-area {
            padding: 12px 20px;
            border-top: 1px solid var(--border);
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            background: rgba(0, 0, 0, 0.2);
        }
        .chatbot-input-area input {
            flex: 1;
            padding: 10px 16px;
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border);
            color: var(--text);
            font-size: 0.85rem;
            outline: none;
            transition: 0.2s;
            font-family: 'Inter', sans-serif;
        }
        .chatbot-input-area input:focus {
            border-color: var(--gold);
            background: rgba(255, 255, 255, 0.08);
        }
        .chatbot-input-area input::placeholder {
            color: var(--text3);
        }
        .chatbot-input-area button {
            padding: 10px 18px;
            border-radius: 30px;
            background: linear-gradient(95deg, var(--gold), var(--aurora-green));
            border: none;
            color: #0a0808;
            font-weight: 700;
            font-size: 0.8rem;
            cursor: pointer;
            transition: 0.2s;
            white-space: nowrap;
        }
        .chatbot-input-area button:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 20px rgba(212, 168, 67, 0.3);
        }
        .chatbot-typing {
            padding: 8px 16px;
            display: flex;
            gap: 4px;
            align-self: flex-start;
        }
        .chatbot-typing span {
            width: 8px;
            height: 8px;
            background: var(--gold);
            border-radius: 50%;
            animation: typingBounce 1.4s infinite;
        }
        .chatbot-typing span:nth-child(2) { animation-delay: 0.2s; }
        .chatbot-typing span:nth-child(3) { animation-delay: 0.4s; }
        @keyframes typingBounce {
            0%, 60%, 100% { transform: translateY(0); opacity: 0.3; }
            30% { transform: translateY(-8px); opacity: 1; }
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            nav ul {
                gap: 1.2rem;
            }
        }
        @media (max-width: 900px) {
            .about-grid {
                grid-template-columns: 1fr;
                gap: 32px;
            }
            nav ul {
                gap: 0.8rem;
            }
            nav ul li a {
                font-size: 0.55rem;
            }
            section {
                padding: 100px 6% 80px;
            }
            .skip-intro {
                top: 20px;
                right: 20px;
                font-size: 0.6rem;
                padding: 6px 16px;
            }
            .journey-map {
                flex-direction: column;
                gap: 12px;
            }
            .journey-map::before {
                display: none;
            }
            .journey-stop {
                width: 100%;
                flex-direction: row;
                padding: 12px 16px;
                gap: 12px;
            }
            .chatbot-container {
                width: 340px;
                height: 450px;
                bottom: 20px;
                right: 20px;
            }
            .chatbot-toggle {
                bottom: 20px;
                right: 20px;
                width: 54px;
                height: 54px;
                font-size: 1.3rem;
            }
        }
        @media (max-width: 768px) {
            nav {
                padding: 6px 14px;
                width: 96%;
                top: 12px;
                border-radius: 40px;
            }
            nav ul {
                gap: 0.3rem;
            }
            nav ul li a {
                font-size: 0.45rem;
                letter-spacing: 0;
            }
            .logo-text {
                font-size: 0.9rem;
            }
            .logo-sub {
                display: none;
            }
            .logo-icon {
                width: 30px;
                height: 30px;
                font-size: 0.7rem;
            }
            .hero-actions {
                flex-direction: column;
                align-items: center;
            }
            .btn-primary,
            .btn-secondary {
                width: 100%;
                justify-content: center;
                font-size: 0.65rem;
                padding: 12px 20px;
            }
            section {
                padding: 80px 5% 60px;
            }
            .projects-grid {
                grid-template-columns: 1fr;
            }
            .about-stats {
                grid-template-columns: repeat(3, 1fr);
                gap: 10px;
            }
            .stat-item {
                padding: 14px 10px;
            }
            .stat-number {
                font-size: 1.5rem;
            }
            .intro-name {
                font-size: 2.5rem;
                letter-spacing: -1px;
            }
            .intro-title {
                font-size: 0.6rem;
                letter-spacing: 4px;
            }
            .skip-intro {
                top: 15px;
                right: 15px;
                font-size: 0.5rem;
                padding: 4px 12px;
            }
            .intro-loading .bar {
                width: 120px;
            }
            .intro-dome {
                width: 200px;
                height: 140px;
            }
            .intro-acacia {
                width: 50px;
                height: 100px;
            }
            .chatbot-container {
                width: 90vw;
                height: 60vh;
                bottom: 15px;
                right: 5vw;
                border-radius: 16px;
            }
            .chatbot-toggle {
                bottom: 15px;
                right: 15px;
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
            }
        }
        @media (max-width: 480px) {
            nav ul {
                gap: 0.15rem;
            }
            nav ul li a {
                font-size: 0.4rem;
            }
            .logo-text {
                font-size: 0.7rem;
            }
            .logo-icon {
                width: 22px;
                height: 22px;
                font-size: 0.5rem;
            }
            .hero-title {
                font-size: 2rem;
            }
            .contact-form {
                padding: 20px;
            }
            .intro-name {
                font-size: 2rem;
            }
            .intro-title {
                font-size: 0.5rem;
                letter-spacing: 2px;
            }
            .intro-loading .bar {
                width: 80px;
            }
            .intro-divider {
                width: 50px;
            }
            .chatbot-container {
                height: 50vh;
                bottom: 10px;
            }
            .chatbot-messages {
                padding: 12px 16px;
            }
        }
    </style>
</head>
<body>

    <!-- ===== AURORA CANVAS (Newfoundland) ===== -->
    <canvas id="auroraCanvas"></canvas>
    
    <!-- ===== TAJ MAHAL OVERLAY (India) ===== -->
    <div class="taj-overlay"></div>
    
    <!-- ===== SAVANNAH TEXTURE (Tanzania) ===== -->
    <div class="savanna-texture"></div>

    <!-- ===== INTRO OVERLAY ===== -->
    <div id="introOverlay">
        <div class="intro-bg">
            <div class="aurora-wave"></div>
            <div class="aurora-wave"></div>
            <div class="intro-dome"></div>
            <div class="intro-acacia">
                <div class="trunk"></div>
                <div class="canopy"></div>
            </div>
        </div>
        
        <button class="skip-intro" id="skipIntro">Skip →</button>
        
        <div class="intro-icon">🌏</div>
        <div class="intro-name">Dev Patel</div>
        <div class="intro-title">India · Tanzania · Newfoundland</div>
        <div class="intro-divider"></div>
        <div class="intro-loading">
            <div class="bar"></div>
            <span class="label">Loading</span>
        </div>
    </div>

    <div class="cursor-glow" id="cursorGlow"></div>

    <!-- ===== NAVIGATION ===== -->
    <nav>
        <div class="logo">
            <div class="logo-icon">🌏</div>
            <div>
                <span class="logo-text">Dev Patel</span>
            </div>
        </div>
        <ul>
            <li><a href="#hero">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#experience">Experience</a></li>
            <li><a href="#projects">Projects</a></li>
            <li><a href="#skills">Skills</a></li>
            <li><a href="#education">Education</a></li>
            <li><a href="#resume">Resume</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
        <button class="theme-toggle" id="themeToggle">🌙</button>
    </nav>


    <!-- ===== HERO ===== -->
    <section id="hero">
        <div class="container hero-content">
            <div class="hero-badge">
                <i class="fas fa-map-pin"></i> 
                India → Tanzania → Newfoundland 
                <i class="fas fa-map-pin"></i>
            </div>
            <h1 class="hero-title">Dev Patel</h1>
            <div class="hero-subtitle">Software Developer</div>
            <p class="hero-sub">
                <span class="highlight-gold">🏛️ Born in India</span> · 
                <span class="highlight-marble">🌿 Raised in Tanzania</span> · 
                <span class="highlight-green">🌌 Now in St. John's, NL</span>
                <br>
                Computer Science co-op student at Memorial University · 
                Building software that bridges cultures and solves real problems.
            </p>
        </div>
    </section>

    <!-- ===== ABOUT ===== -->
    <section id="about">
        <div class="container">
            <div class="text-center reveal">
                <span class="section-label">About</span>
                <h2 class="section-title">A Journey Across Three Continents</h2>
                <p class="section-desc mx-auto">My story is one of resilience, curiosity, and growth.</p>
            </div>
            
            <!-- Journey Map -->
            <div class="journey-map reveal">
                <div class="journey-stop">
                    <span class="flag">🇮🇳</span>
                    <span class="icon taj">🏛️</span>
                    <span class="place">India</span>
                    <span class="detail">Born</span>
                </div>
                <div class="journey-stop">
                    <span class="flag">🇹🇿</span>
                    <span class="icon savanna">🌿</span>
                    <span class="place">Tanzania</span>
                    <span class="detail">Age 2 → Grade 11</span>
                </div>
                <div class="journey-stop">
                    <span class="flag">🇨🇦</span>
                    <span class="icon aurora">🌌</span>
                    <span class="place">St. John's, NL</span>
                    <span class="detail">Grade 12 · MUN</span>
                </div>
            </div>
            
            <div class="about-grid">
                <div class="about-text reveal">
                    <p>
                        <span class="story-highlight">🇮🇳 Born in India</span>, I moved to 
                        <span class="story-highlight">🇹🇿 Tanzania at age 2</span>, where I grew up, studied, 
                        and discovered my love for cricket and problem-solving.
                    </p>
                    <p>
                        <span class="story-highlight">🌿 In Tanzania</span>, I found my first Rubik's cube in a 
                        small shop — a moment that would teach me about persistence, patience, and the 
                        beauty of not giving up.
                    </p>
                    <p>
                        <span class="story-highlight">🌌 Now in St. John's, Newfoundland</span>, I'm pursuing 
                        Computer Science at Memorial University, playing cricket in the cold, and falling in 
                        love with ice hockey.
                    </p>
                    <p>
                        <span class="story-highlight">🏏 Cricket in Tanzania & St. John's</span> · 
                        <span class="story-highlight">🏒 Hockey at the stadium</span> · 
                        <span class="story-highlight">🧊 Rubik's cube in 40.6 seconds</span>
                    </p>
                    <div class="about-stats">
                        <div class="stat-item"><div class="stat-number">3</div><div class="stat-label">Continents</div></div>
                        <div class="stat-item"><div class="stat-number">40.6s</div><div class="stat-label">Rubik's PB</div></div>
                        <div class="stat-item"><div class="stat-number">2028</div><div class="stat-label">Graduation</div></div>
                    </div>
                </div>
                <div class="skill-grid reveal">
                    <div class="skill-item"><div class="skill-name"><span>Python</span><span>98%</span></div><div class="skill-bar"><div class="skill-bar-fill" data-width="98"></div></div></div>
                    <div class="skill-item"><div class="skill-name"><span>JavaScript/TypeScript</span><span>85%</span></div><div class="skill-bar"><div class="skill-bar-fill" data-width="85"></div></div></div>
                    <div class="skill-item"><div class="skill-name"><span>React / Next.js</span><span>75%</span></div><div class="skill-bar"><div class="skill-bar-fill" data-width="75"></div></div></div>
                    <div class="skill-item"><div class="skill-name"><span>AWS</span><span>80%</span></div><div class="skill-bar"><div class="skill-bar-fill" data-width="80"></div></div></div>
                    <div class="skill-item"><div class="skill-name"><span>SQL / Databases</span><span>85%</span></div><div class="skill-bar"><div class="skill-bar-fill" data-width="85"></div></div></div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== EXPERIENCE ===== -->
    <section id="experience" style="background: rgba(0,0,0,0.3);">
        <div class="container">
            <div class="text-center reveal">
                <span class="section-label">Experience</span>
                <h2 class="section-title">My Career Track Record</h2>
                <p class="section-desc mx-auto">Every role has prepared me for high-performance environments.</p>
            </div>
            <div class="timeline">
                <div class="timeline-item reveal">
                    <span class="date">Jul 2025 – Present</span>
                    <h3>Product Operations Educator</h3>
                    <div class="company">Lululemon · St. John's, NL</div>
                    <p>Delivered exceptional customer experiences with 99.9% transaction accuracy. Developed teamwork and communication skills essential for high-pressure environments.</p>
                </div>
                <div class="timeline-item reveal">
                    <span class="date">Jan 2026 – May 2026</span>
                    <h3>Academic Mentor</h3>
                    <div class="company">Memorial University · St. John's, NL</div>
                    <p>• Developed modules used by 50+ students in calculus and linear algebra.<br>
                    • Re-engineered problem sets with real-world applications, increasing student engagement by 30%.<br>
                    • Developed automated grading pipelines in Python, reducing instructor workload by 40%.</p>
                </div>
                <div class="timeline-item reveal">
                    <span class="date">Jan 2025 – Sep 2025</span>
                    <h3>Computational Research Assistant</h3>
                    <div class="company">Memorial University · St. John's, NL</div>
                    <p>• Developed NumPy/SciPy routines achieving 99.7% accuracy in special function evaluations.<br>
                    • Created a SymPy verification workflow improving symbolic checks by 60%.<br>
                    • Learned and documented Beta/Gamma function derivations and their link to elliptic integrals.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== PROJECTS ===== -->
    <section id="projects">
        <div class="container">
            <div class="text-center reveal">
                <span class="section-label">Projects</span>
                <h2 class="section-title">Engineering Solutions</h2>
                <p class="section-desc mx-auto">Each project tells a story from my journey — solving problems I've personally faced.</p>
            </div>
            <div class="projects-grid">
                <!-- Project 1: Rubik's Cube Solver -->
                <div class="project-card reveal-stagger">
                    <span class="project-icon">🧊</span>
                    <h3>Rubik's Cube Solver</h3>
                    <div class="project-sub">🇹🇿 Born in a small shop in Tanzania</div>
                    <p>
                        <strong>The Challenge:</strong> I found my first 3×3 cube in Tanzania. I couldn't solve it. 
                        I even tried breaking it! But I learned persistence — and eventually hit 
                        <strong>40.6 seconds</strong>. This website teaches kids that the first 1-5% is the hardest, 
                        but what's waiting is life-changing.
                    </p>
                    <div class="project-tags">
                        <span class="project-tag">Python</span>
                        <span class="project-tag">OpenCV</span>
                        <span class="project-tag">Algorithms</span>
                        <span class="project-tag">3×3 · 2×2 · 4×4</span>
                    </div>
                    <div class="project-links">
                        <a href="https://webworldnetnet.ipage.com/webworldnet/devprojects/dev/Mirror.php" target="_blank" class="demo-link">
                            <i class="fas fa-external-link-alt"></i> Live Demo
                        </a>
                        <a href="https://github.com/devp-glitch/devarat-rubik-solver" target="_blank" class="code-link">
                            <i class="fab fa-github"></i> Code
                        </a>
                    </div>
                </div>
                
                <!-- Project 2: Retail Operations Platform (ROP) -->
                <div class="project-card reveal-stagger">
                    <span class="project-icon">📋</span>
                    <h3>Retail Operations Platform (ROP) <span style="font-size:0.5rem;color:var(--aurora-green);background:rgba(64,224,160,0.12);padding:2px 12px;border-radius:30px;margin-left:8px;font-weight:600;letter-spacing:0.5px;text-transform:uppercase;">In Progress</span></h3>
                    <div class="project-sub">🇨🇦 Born in St. John's · <span style="color:var(--aurora-green);font-weight:600;">🚧 Active Development</span></div>
                    <p>
                        <strong>The Challenge:</strong> This project is ultimately about asking whether everyday operational problems should simply be tolerated or redesigned. By questioning the existing process and asking <strong>"WHY?"</strong>, I identified an opportunity to turn fragmented verbal communication into a clearer, more visual, and potentially more reliable workflow. The goal is simple: put the right information in front of the right employee at the right time, so they can focus less on remembering and more on delivering the right result.
                    </p>
                    <div class="project-tags">
                        <span class="project-tag in-progress">
                            <i class="fas fa-spinner fa-pulse"></i>
                        </span>
                        <span class="project-tag">React</span>
                        <span class="project-tag">QR Code</span>
                        <span class="project-tag">Real-time</span>
                        <span class="project-tag">UX Design</span>
                    </div>
                    <div class="project-links">
                        <a href="https://localhost/rop-demo/index.php" target="_blank" class="demo-link">
                            <i class="fas fa-external-link-alt"></i> Live Demo
                        </a>
                        <button class="code-link disabled" disabled>
                            <i class="fab fa-github"></i> Private Repo
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== SKILLS ===== -->
    <section id="skills" style="background: rgba(0,0,0,0.2);">
        <div class="container">
            <div class="text-center reveal">
                <span class="section-label">Skills</span>
                <h2 class="section-title">Tech Stack</h2>
                <p class="section-desc mx-auto">The tools I use to build high-performance solutions.</p>
            </div>
            <div class="tech-categories">
                <div class="tech-cat reveal-stagger"><div class="icon">🐍</div><h4>Python</h4><p>Flask, Django, Pandas</p></div>
                <div class="tech-cat reveal-stagger"><div class="icon">⚛️</div><h4>React</h4><p>Next.js, Redux, Hooks</p></div>
                <div class="tech-cat reveal-stagger"><div class="icon">☁️</div><h4>AWS</h4><p>Lambda, S3, API Gateway</p></div>
                <div class="tech-cat reveal-stagger"><div class="icon">🗄️</div><h4>Databases</h4><p>PostgreSQL, MongoDB</p></div>
                <div class="tech-cat reveal-stagger"><div class="icon">🎨</div><h4>UI/UX</h4><p>Figma, Tailwind, Framer</p></div>
            </div>
        </div>
    </section>

    <!-- ===== EDUCATION ===== -->
    <section id="education">
        <div class="container">
            <div class="text-center reveal">
                <span class="section-label">Education</span>
                <h2 class="section-title">Academic Foundation</h2>
            </div>
            <div class="edu-card reveal">
                <h3>Bachelor of Computer Science</h3>
                <div class="meta">Memorial University · St. John's, NL · Expected Sep 2028</div>
                <ul>
                    <li>Relevant Coursework: Data Structures, Algorithms, Database Systems, Operating Systems</li>
                    <li>Computational Research Assistant: Algorithm Optimization</li>
                    <li>Focus: High-performance computing and distributed systems</li>
                    <li>🏏 Cricket at MUN · 🏒 Hockey fan</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- ===== RESUME ===== -->
    <section id="resume" style="background: rgba(0,0,0,0.15);">
        <div class="container">
            <div class="text-center reveal">
                <span class="section-label">Resume</span>
                <h2 class="section-title">My Professional Profile</h2>
                <p class="section-desc mx-auto">Download or view my full resume to learn more about my experience and qualifications.</p>
                <div class="resume-actions">
                    <button class="btn-primary" id="resumeDownloadBtn">
                        <i class="fas fa-download"></i> Download PDF
                    </button>
                    <button class="btn-secondary" id="resumeViewBtn">
                        <i class="fas fa-eye"></i> View Online
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CONTACT ===== -->
    <section id="contact">
        <div class="container">
            <div class="text-center reveal">
                <span class="section-label">Contact</span>
                <h2 class="section-title">Let's Connect</h2>
                <p class="section-desc mx-auto">Ready to accelerate? Let's discuss how I can contribute to your team.</p>
            </div>
            
            <?php if ($formSuccess): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> Thank you! Your message has been sent successfully.
                </div>
            <?php elseif ($formError): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> Please fill in all fields correctly.
                </div>
            <?php endif; ?>
            
            <form class="contact-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>#contact">
                <div class="form-group">
                    <input type="text" name="name" placeholder="Full Name" required />
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email Address" required />
                </div>
                <div class="form-group">
                    <textarea name="message" placeholder="Tell me about your project and how I can help accelerate your team's success." required></textarea>
                </div>
                <button type="submit" name="submit_contact"><i class="fas fa-globe-americas"></i> Send Message</button>
            </form>
            
            <div class="social-links">
                <a href="https://github.com/devp-glitch" target="_blank" aria-label="GitHub"><i class="fab fa-github"></i></a>
                <a href="https://www.linkedin.com/in/devp4" target="_blank" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                <a href="https://webworldnetnet.ipage.com/webworldnet/devprojects/dev/Mirror.php" target="_blank" aria-label="Rubik's Cube Solver"><i class="fas fa-cube"></i></a>
            </div>
        </div>
    </section>

    <footer>
        <span class="footer-flags">🇮🇳 🇹🇿 🇨🇦</span>
        <p>© <?php echo $currentYear; ?> Dev Patel · Gujarat → Tanzania → Newfoundland · 
        <i class="fas fa-heart" style="color: var(--gold);"></i> Built with Passion & Persistence</p>
    </footer>

    <!-- ===== AI CHATBOT ===== -->
    <!-- Toggle Button -->
    <button class="chatbot-toggle" id="chatbotToggle" aria-label="Toggle Chatbot">
        💬
    </button>

    <!-- Chatbot Window -->
    <div class="chatbot-container hidden" id="chatbotContainer">
        <div class="chatbot-header" id="chatbotHeader">
            <div class="chatbot-header-left">
                <div class="chatbot-avatar">🤖</div>
                <div>
                    <div class="chatbot-title">Dev's AI Assistant</div>
                    <div class="chatbot-status">
                        <span class="dot"></span> Online
                    </div>
                </div>
            </div>
            <button class="chatbot-close" id="chatbotClose" aria-label="Close Chatbot">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="chatbot-messages" id="chatbotMessages">
            <!-- Messages will be dynamically added here -->
        </div>
        
        <div class="chatbot-input-area">
            <input type="text" id="chatbotInput" placeholder="Ask me anything..." />
            <button id="chatbotSend">Send</button>
        </div>
    </div>

    <script>
        // ===== AURORA CANVAS (Newfoundland Northern Lights) =====
        const canvas = document.getElementById('auroraCanvas');
        const ctx = canvas.getContext('2d');
        let width, height;

        function resizeAurora() {
            width = window.innerWidth;
            height = window.innerHeight;
            canvas.width = width;
            canvas.height = height;
        }
        resizeAurora();
        window.addEventListener('resize', resizeAurora);

        // Aurora wave parameters
        let time = 0;
        const waves = [
            { amplitude: 80, frequency: 0.005, speed: 0.0008, color: '64, 224, 160', width: 2.5, yOffset: 0 },
            { amplitude: 60, frequency: 0.008, speed: 0.0012, color: '138, 106, 208', width: 2, yOffset: 40 },
            { amplitude: 50, frequency: 0.01, speed: 0.001, color: '64, 128, 208', width: 1.8, yOffset: 80 },
            { amplitude: 40, frequency: 0.006, speed: 0.0006, color: '212, 168, 67', width: 1.5, yOffset: 120 }
        ];

        function drawAurora() {
            ctx.clearRect(0, 0, width, height);
            
            const gradient = ctx.createLinearGradient(0, 0, 0, height);
            gradient.addColorStop(0, 'rgba(10, 8, 8, 0)');
            gradient.addColorStop(0.3, 'rgba(10, 8, 8, 0)');
            gradient.addColorStop(0.7, 'rgba(10, 8, 8, 0)');
            gradient.addColorStop(1, 'rgba(10, 8, 8, 0)');
            ctx.fillStyle = gradient;
            ctx.fillRect(0, 0, width, height);

            waves.forEach((wave, index) => {
                ctx.beginPath();
                const startY = height * (0.15 + index * 0.08);
                
                for (let x = 0; x < width; x += 1) {
                    const y = startY + 
                        Math.sin(x * wave.frequency + time * wave.speed) * wave.amplitude +
                        Math.sin(x * wave.frequency * 0.7 + time * wave.speed * 0.8) * wave.amplitude * 0.5 +
                        wave.yOffset;
                    
                    if (x === 0) {
                        ctx.moveTo(x, y);
                    } else {
                        ctx.lineTo(x, y);
                    }
                }

                const grad = ctx.createLinearGradient(0, startY - wave.amplitude, 0, startY + wave.amplitude);
                grad.addColorStop(0, `rgba(${wave.color}, 0)`);
                grad.addColorStop(0.3, `rgba(${wave.color}, 0.04)`);
                grad.addColorStop(0.5, `rgba(${wave.color}, 0.08)`);
                grad.addColorStop(0.7, `rgba(${wave.color}, 0.04)`);
                grad.addColorStop(1, `rgba(${wave.color}, 0)`);
                
                ctx.strokeStyle = grad;
                ctx.lineWidth = wave.width;
                ctx.shadowColor = `rgba(${wave.color}, 0.05)`;
                ctx.shadowBlur = 40;
                ctx.stroke();

                ctx.beginPath();
                for (let x = 0; x < width; x += 1) {
                    const y = startY + 
                        Math.sin(x * wave.frequency + time * wave.speed) * wave.amplitude +
                        Math.sin(x * wave.frequency * 0.7 + time * wave.speed * 0.8) * wave.amplitude * 0.5 +
                        wave.yOffset;
                    if (x === 0) ctx.moveTo(x, y);
                    else ctx.lineTo(x, y);
                }
                ctx.lineTo(width, height);
                ctx.lineTo(0, height);
                ctx.closePath();
                
                const fillGrad = ctx.createLinearGradient(0, startY - wave.amplitude, 0, height);
                fillGrad.addColorStop(0, `rgba(${wave.color}, 0)`);
                fillGrad.addColorStop(0.15, `rgba(${wave.color}, 0.02)`);
                fillGrad.addColorStop(0.5, `rgba(${wave.color}, 0.01)`);
                fillGrad.addColorStop(1, `rgba(${wave.color}, 0)`);
                ctx.fillStyle = fillGrad;
                ctx.shadowBlur = 0;
                ctx.fill();
            });

            time += 1;
            requestAnimationFrame(drawAurora);
        }
        drawAurora();

        // ===== INTRO OVERLAY =====
        const introOverlay = document.getElementById('introOverlay');
        const skipIntro = document.getElementById('skipIntro');

        function hideIntro() {
            introOverlay.classList.add('hide');
            setTimeout(function() {
                introOverlay.style.display = 'none';
            }, 800);
        }

        setTimeout(hideIntro, 2800);
        skipIntro.addEventListener('click', hideIntro);

        let introClicked = false;
        introOverlay.addEventListener('click', function(e) {
            if (e.target === skipIntro) return;
            if (!introClicked) {
                introClicked = true;
                setTimeout(hideIntro, 200);
            }
        });

        // ===== THEME TOGGLE =====
        const themeToggle = document.getElementById('themeToggle');
        let isLight = false;
        themeToggle.addEventListener('click', function() {
            document.body.classList.toggle('light');
            isLight = !isLight;
            this.textContent = isLight ? '☀️' : '🌙';
        });

        // ===== CURSOR GLOW =====
        const cursorGlow = document.getElementById('cursorGlow');
        document.addEventListener('mousemove', function(e) {
            cursorGlow.style.left = e.clientX + 'px';
            cursorGlow.style.top = e.clientY + 'px';
        });

        // ===== SCROLL REVEAL =====
        const revealElements = document.querySelectorAll('.reveal, .reveal-stagger');

        function checkReveal() {
            const windowHeight = window.innerHeight;
            revealElements.forEach(el => {
                const rect = el.getBoundingClientRect();
                if (rect.top < windowHeight - 120) {
                    el.classList.add('visible');
                }
            });
        }

        window.addEventListener('scroll', checkReveal);
        window.addEventListener('load', checkReveal);

        // ===== SKILL BARS =====
        const skillFills = document.querySelectorAll('.skill-bar-fill');

        function animateSkillBars() {
            skillFills.forEach(bar => {
                const rect = bar.getBoundingClientRect();
                if (rect.top < window.innerHeight - 50) {
                    const width = bar.getAttribute('data-width');
                    bar.style.width = width + '%';
                }
            });
        }

        window.addEventListener('scroll', animateSkillBars);
        setTimeout(animateSkillBars, 1000);

        // ===== RESUME BUTTONS =====
        document.getElementById('resumeDownloadBtn').addEventListener('click', function() {
            alert('📄 Downloading Dev Patel - Professional Resume.pdf');
        });
        document.getElementById('resumeViewBtn').addEventListener('click', function(e) {
            e.preventDefault();
            alert('📄 Viewing Dev Patel - Professional Resume');
        });

        // ===== SMOOTH SCROLL =====
        document.querySelectorAll('nav a[href^="#"]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const target = document.querySelector(targetId);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    history.pushState(null, null, targetId);
                }
            });
        });

        // ===== AI CHATBOT =====
        const chatbotContainer = document.getElementById('chatbotContainer');
        const chatbotToggle = document.getElementById('chatbotToggle');
        const chatbotClose = document.getElementById('chatbotClose');
        const chatbotMessages = document.getElementById('chatbotMessages');
        const chatbotInput = document.getElementById('chatbotInput');
        const chatbotSend = document.getElementById('chatbotSend');
        const chatbotHeader = document.getElementById('chatbotHeader');

        let isChatbotOpen = false;

        // Toggle chatbot
        function toggleChatbot() {
            isChatbotOpen = !isChatbotOpen;
            chatbotContainer.classList.toggle('hidden', !isChatbotOpen);
            chatbotToggle.classList.toggle('hidden', isChatbotOpen);
            if (isChatbotOpen) {
                chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
            }
        }

        chatbotToggle.addEventListener('click', toggleChatbot);
        chatbotClose.addEventListener('click', toggleChatbot);
        chatbotHeader.addEventListener('click', function(e) {
            if (e.target.closest('.chatbot-close')) return;
            toggleChatbot();
        });

        // AI responses
        function getBotResponse(message) {
            const msg = message.toLowerCase();
            
            // Personal info
            if (msg.includes('who are you') || msg.includes('your name') || msg.includes('about you')) {
                return "I'm Dev Patel's AI assistant! I can tell you about Dev's journey from Gujarat to Tanzania to Newfoundland, his skills, projects, and experience. What would you like to know?";
            }
            
            // Journey/background
            if (msg.includes('journey') || msg.includes('background') || msg.includes('story') || msg.includes('where')) {
                return "Dev was born in Gujarat, India, moved to Tanzania at age 2, and now lives in St. John's, Newfoundland. He's a Computer Science student at Memorial University and enjoys playing cricket, hockey, and solving Rubik's cubes!";
            }
            
            // Skills
            if (msg.includes('skill') || msg.includes('tech') || msg.includes('language') || msg.includes('programming')) {
                return "Dev's tech stack includes Python (98%), JavaScript/TypeScript (85%), React/Next.js (75%), AWS (80%), and SQL (85%). He's also skilled in Flask, Django, Pandas, Redux, and PostgreSQL.";
            }
            
            // Projects
            if (msg.includes('project') || msg.includes('work') || msg.includes('build') || msg.includes('created') || msg.includes('rubik')) {
                return "Dev has built 2 main projects: 1) Rubik's Cube Solver (Python, OpenCV) - you can try it at https://webworldnetnet.ipage.com/webworldnet/devprojects/dev/Mirror.php, and 2) Retail Operations Platform (ROP) (React, QR codes) - currently in progress at https://localhost/rop-demo/index.php.";
            }
            
            // Experience
            if (msg.includes('experience') || msg.includes('job') || msg.includes('work') || msg.includes('career')) {
                return "Dev currently works as a Product Operations Educator at Lululemon. He's also been an Academic Mentor and Computational Research Assistant at Memorial University. Every role has prepared him for high-performance environments!";
            }
            
            // Education
            if (msg.includes('education') || msg.includes('study') || msg.includes('university') || msg.includes('memorial')) {
                return "Dev is pursuing a Bachelor of Computer Science at Memorial University (expected graduation: 2028). He's worked as a Research Assistant and focuses on high-performance computing and distributed systems.";
            }
            
            // Rubik's cube
            if (msg.includes('cube')) {
                return "Dev's Rubik's cube journey started in Tanzania! His personal best is 40.6 seconds. He built a Rubik's Cube Solver to teach kids that the first 1-5% is the hardest, but what's waiting is life-changing! Try it at https://webworldnetnet.ipage.com/webworldnet/devprojects/dev/Mirror.php";
            }
            
            // ROP
            if (msg.includes('rop') || msg.includes('retail') || msg.includes('operations')) {
                return "The Retail Operations Platform (ROP) is Dev's project that rethinks retail communication workflows. It uses React and QR codes to put the right information in front of the right employee at the right time. Check out the demo at https://localhost/rop-demo/index.php!";
            }
            
            // Contact
            if (msg.includes('contact') || msg.includes('email') || msg.includes('reach') || msg.includes('message')) {
                return "You can reach Dev through the contact form on this website, or connect with him on GitHub (devp-glitch) and LinkedIn (devp4). He'd love to hear about your project!";
            }
            
            // Cricket/hockey
            if (msg.includes('cricket') || msg.includes('hockey')) {
                return "Dev played cricket in Tanzania and now plays at MUN. He also fell in love with ice hockey in Newfoundland — just like the locals taught him! 🏏🏒";
            }
            
            // Fun facts
            if (msg.includes('fun') || msg.includes('interesting') || msg.includes('fact')) {
                return "Fun fact: Dev's Rubik's cube journey started when he found one in a small shop in Tanzania. He even tried breaking it before learning to solve it! Now he can solve it in 40.6 seconds. 🧊";
            }
            
            // Default responses
            const defaultResponses = [
                "That's a great question! Dev is passionate about building software that bridges cultures and solves real problems. Can I tell you more about his projects or skills?",
                "Interesting! Dev's journey across 3 continents has given him a unique perspective on problem-solving. What specific area would you like to know more about?",
                "I'd love to help you learn more about Dev. He specializes in Python, React, and cloud infrastructure. Are you interested in his technical skills or his background?",
                "Dev believes that the first 1-5% of any challenge is the hardest, but what's waiting is life-changing. Just like his Rubik's cube journey! What would you like to know?"
            ];
            
            return defaultResponses[Math.floor(Math.random() * defaultResponses.length)];
        }

        // Add message to chat
        function addMessage(text, type) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${type}`;
            
            const timestamp = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            messageDiv.innerHTML = `${text}<span class="timestamp">${timestamp}</span>`;
            
            chatbotMessages.appendChild(messageDiv);
            chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
        }

        // Show typing indicator
        function showTyping() {
            const typingDiv = document.createElement('div');
            typingDiv.className = 'chatbot-typing';
            typingDiv.id = 'typingIndicator';
            typingDiv.innerHTML = '<span></span><span></span><span></span>';
            chatbotMessages.appendChild(typingDiv);
            chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
        }

        // Remove typing indicator
        function removeTyping() {
            const typing = document.getElementById('typingIndicator');
            if (typing) typing.remove();
        }

        // Send message
        function sendMessage() {
            const text = chatbotInput.value.trim();
            if (!text) return;
            
            addMessage(text, 'user');
            chatbotInput.value = '';
            
            showTyping();
            
            // Simulate AI thinking
            setTimeout(() => {
                removeTyping();
                const response = getBotResponse(text);
                addMessage(response, 'bot');
            }, 500 + Math.random() * 500);
        }

        // Event listeners
        chatbotSend.addEventListener('click', sendMessage);
        chatbotInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') sendMessage();
        });

        // Welcome message
        setTimeout(() => {
            addMessage("👋 Hi there! I'm Dev's AI assistant. Ask me about his journey, skills, projects, or anything else you'd like to know!", 'bot');
        }, 1500);

        console.log('🌏 Dev Patel - Gujarat → Tanzania → Newfoundland');
        console.log('🏛️ Born in India, raised in Tanzania, now in St. John\'s');
        console.log('🧊 Rubik\'s cube: 40.6 seconds');
        console.log('📅 Current year: <?php echo $currentYear; ?>');
        console.log('🤖 AI Chatbot is ready to chat!');
        console.log('🧊 Try Rubik\'s Cube Solver: https://webworldnetnet.ipage.com/webworldnet/devprojects/dev/Mirror.php');
        console.log('📋 Try Retail Operations Platform (ROP): https://localhost/rop-demo/index.php');
    </script>

</body>
</html>