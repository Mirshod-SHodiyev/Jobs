<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job.uz🇺🇿</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 100px 0;
            border-radius: 0 0 20px 20px;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') center/cover;
            opacity: 0.2;
            z-index: 0;
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
        }
        
        .logo {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        .logo span {
            color: var(--accent-color);
        }
        
        .btn-telegram {
            background-color: #0088cc;
            color: white;
            font-weight: 600;
            padding: 12px 25px;
            border-radius: 50px;
            transition: all 0.3s;
        }
        
        .btn-telegram:hover {
            background-color: #006b9f;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .feature-card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            padding: 30px;
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        
        .feature-icon {
            font-size: 2.5rem;
            color: var(--secondary-color);
            margin-bottom: 20px;
        }
        
        .stat-item {
            text-align: center;
            padding: 30px;
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            color: var(--secondary-color);
        }
        
        .how-to-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 30px;
        }
        
        .how-to-number {
            background-color: var(--secondary-color);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            margin-right: 20px;
            flex-shrink: 0;
        }
        
        .testimonial-card {
            background-color: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            margin: 15px;
        }
        
        .testimonial-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 20px;
        }
        
    </style>
</head>
<body>
   
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <span style="color: var(--accent-color);">Job.</span>uz🇺🇿
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Bosh Sahifa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Xususiyatlar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#how-it-works">Qanday Ishlaydi</a>
                    </li>
                  
                </ul>
                <a href="https://t.me/jobsuzall" class="btn btn-telegram ms-lg-3 mt-3 mt-lg-0">
                    <i class="fab fa-telegram me-2"></i> Kanalga Qo'shilish
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container hero-content">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="logo">Job.<span>uz🇺🇿</span></h1>
                    <h2>O'zbekistondagi eng yirik ish qidirish platformasi</h2>
                    <p class="lead my-4">1000+ vakansiya, 500+ kompaniya va 10,000+ foydalanuvchi biz bilan ish topmoqda</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="https://t.me/jobsuzall" class="btn btn-telegram">
                            <i class="fab fa-telegram me-2"></i> Kanalga Qo'shilish
                        </a>
                        <a href="https://t.me/jobvakansiyabot" class="btn btn-light btn-lg">
                            <i class="fas fa-robot me-2"></i> Botni Boshlash
                        </a>
                    </div>
        <div class="container">
            <div class="row">
                <div class="col-md-4 stat-item">
                    <div class="stat-number">1000+</div>
                    <h4>Faol Vakansiyalar</h4>
                </div>
                <div class="col-md-4 stat-item">
                    <div class="stat-number">500+</div>
                    <h4>Ish Beruvchilar</h4>
                </div>
                <div class="col-md-4 stat-item">
                    <div class="stat-number">10K+</div>
                    <h4>Foydalanuvchilar</h4>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2>Nega Aynan Biz?</h2>
                <p class="lead">Job.uz🇺🇿- bu ish qidirishning eng qulay va samarali usuli</p>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h3>Tez va Oson</h3>
                        <p>Bir necha bosqichda o'zingizga mos ishni toping. kanal orqali qidiruv juda oddiy va tushunarli.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-filter"></i>
                        </div>
                        <h3>Keng Filtrlash</h3>
                        <p>Ish turi, maosh, joylashuv va boshqa ko'plab parametrlar bo'yicha vakansiyalarni filtrlash imkoniyati.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <h3>Bildirishnomalar</h3>
                        <p>Qiziqtirgan sohangizdagi yangi vakansiyalar haqida darhol xabar oling.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <h3>Rezyume Yaratish</h3>
                        <p>Professional rezyume tuzish va uni ish beruvchilarga bir tugma bosish orqali yuborish.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h3>Direkt Xabarlash</h3>
                        <p>Ish beruvchilar bilan to'g'ridan-to'g'ri aloqa qilish imkoniyati.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3>Ishonchli</h3>
                        <p>Barcha vakansiyalar tekshirib chiqilgan va haqiqiyligiga ishonch hosil qilingan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="how-it-works" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2>Botdan Qanday Foydalaniladi?</h2>
                <p class="lead">4 oddiy qadamda ish toping</p>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="how-to-item">
                        <div class="how-to-number">1</div>
                        <div>
                            <h4>Botga Kirish</h4>
                            <p>Telegramda @jobvakansiyabot ni toping yoki quyidagi tugma orqali botga o'ting.</p>
                        </div>
                    </div>
                    <div class="how-to-item">
                        <div class="how-to-number">2</div>
                        <div>
                            <h4>Ro'yxatdan O'tish</h4>
                            <p>Bot sizdan kerakli ma'lumotlarni so'raydi va ro'yxatdan o'tkazadi (2-3 daqiqa).</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="how-to-item">
                        <div class="how-to-number">3</div>
                        <div>
                            <h4>Ish Qidirish</h4>
                            <p>Kerakli vakansiyalarni soha, maosh, joylashuv va boshqa parametrlar bo'yicha filtrlash.</p>
                        </div>
                    </div>
                    <div class="how-to-item">
                        <div class="how-to-number">4</div>
                        <div>
                            <h4>Ariza Yuborish</h4>
                            <p>Yoqqan ishga ariza yuboring va ish beruvchidan javob kutishni boshlang.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
                <a href="https://t.me/jobvakansiyabot" class="btn btn-primary btn-lg">
                    <i class="fas fa-robot me-2"></i> Botni Boshlash
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2>Foydalanuvchilar Fikrlari</h2>
                <p class="lead">Bizning mijozlarimiz biz haqimizda nima deyishadi</p>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="d-flex align-items-center mb-3">
                            <img src="" alt="User" class="testimonial-avatar">
                            <div>
                                <h5 class="mb-0">Mirshod Shodiyev</h5>
                                <p class="text-muted mb-0">Dasturchi</p>
                            </div>
                        </div>
                        <p>"Job.uz🇺🇿 orqali ajoyib kompaniyada ish topdim. Bot juda qulay va tez ishlaydi. Har kuni yangi vakansiyalar haqida bildirishnomalar olaman."</p>
                        <div class="text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="d-flex align-items-center mb-3">
                            <img src="user.png" alt="User" class="testimonial-avatar">
                            <div>
                                <h5 class="mb-0">Ruslan Qahramonov</h5>
                                <p class="text-muted mb-0">Menejer</p>
                            </div>
                        </div>
                        <p>"Biz kompaniyamiz uchun xodimlarni topishda Job.uz🇺🇿 dan foydalanamiz. Natijalar ajoyib!"</p>
                        <div class="text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="d-flex align-items-center mb-3">
                            <img src="user.png" alt="User" class="testimonial-avatar">
                            <div>
                                <h5 class="mb-0">Sherzod Nosirov</h5>
                                <p class="text-muted mb-0">Dizayner</p>
                            </div>
                        </div>
                        <p>"Rezyume yaratish funksiyasi juda qulay. Bir marta ma'lumotlarni kiritasiz va keyin istalgan ishga bir tugma bosish orqali ariza yuborishingiz mumkin."</p>
                        <div class="text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container text-center">
            <h2 class="mb-4">Hozir Boshlang!</h2>
            <p class="lead mb-5">O'zingizga mos ishni topish uchun hozirroq botga ulaning</p>
            <div class="d-flex justify-content-center flex-wrap gap-3">
                <a href="https://t.me/jobvakansiyabot" class="btn btn-light btn-lg">
                    <i class="fas fa-robot me-2"></i> Botni Boshlash
                </a>
                <a href="https://t.me/jobsuzall" class="btn btn-outline-light btn-lg">
                    <i class="fab fa-telegram me-2"></i> Kanalga Qo'shilish
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h3 class="logo">Job.<span>uz🇺🇿</span></h3>
                    <p class="mt-3">O'zbekistondagi eng yirik ish qidirish platformasi. 1000+ vakansiya, 500+ kompaniya va 10,000+ foydalanuvchi.</p>
                    <div class="mt-4">
                        <a href="#" class="text-white me-3"><i class="fab fa-telegram fa-lg"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook fa-lg"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5>Havolalar</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Bosh Sahifa</a></li>
                        <li class="mb-2"><a href="#features" class="text-white text-decoration-none">Xususiyatlar</a></li>
                        <li class="mb-2"><a href="#how-it-works" class="text-white text-decoration-none">Qanday Ishlaydi</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Foydalanish Shartlari</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5>Biz Bilan Bog'laning</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="https://t.me/jobsuzall" class="text-white text-decoration-none">Telegram Kanal</a></li>
                        <li class="mb-2"><a href="https://t.me/jobvakansiyabot" class="text-white text-decoration-none">Telegram Bot</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Support</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-4">
                    <h5>Yangiliklarga Obuna Bo'ling</h5>
                    <p>Yangi vakansiyalar va yangiliklardan xabardor bo'lish uchun obuna bo'ling.</p>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email manzilingiz">
                        <button class="btn btn-primary" type="button">Obuna Bo'lish</button>
                    </div>
                </div>
            </div>
            <hr class="my-4 bg-secondary">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">© 2025 Job.uz🇺🇿 Barcha huquqlar himoyalangan.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0">Ishla, Orzu Qil, Erish! 🚀 ((bazi kamchiliklar uchun uzur))</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>