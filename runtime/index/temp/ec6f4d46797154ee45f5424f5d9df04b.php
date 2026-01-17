<?php /*a:1:{s:47:"E:\Users\web\tp\app\index\view\index\index.html";i:1768642661;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title><?php echo htmlentities((string) (isset($config['site_title']) && ($config['site_title'] !== '')?$config['site_title']:'MoveCar - 专业挪车服务平台')); ?></title>
    <meta name="keywords" content="<?php echo htmlentities((string) (isset($config['site_keywords']) && ($config['site_keywords'] !== '')?$config['site_keywords']:'')); ?>">
    <meta name="description" content="<?php echo htmlentities((string) (isset($config['site_description']) && ($config['site_description'] !== '')?$config['site_description']:'')); ?>">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/static/layui/css/layui.css" media="all">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --bg-gradient: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            --text-main: #1e293b;
            --text-muted: #64748b;
            --glass-bg: rgba(255, 255, 255, 0.8);
            --glass-border: rgba(255, 255, 255, 0.3);
        }

        body {
            font-family: 'Outfit', 'PingFang SC', 'Microsoft YaHei', sans-serif;
            margin: 0;
            padding: 0;
            background: var(--bg-gradient);
            color: var(--text-main);
            min-height: 100vh;
        }

        .navbar {
            padding: 15px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid var(--glass-border);
            transition: all 0.3s;
        }

        .mobile-menu-btn {
            display: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--text-main);
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-links {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-main);
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: var(--primary-color);
        }

        .btn-primary {
            background: var(--primary-color);
            color: white !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 16px;
            height: 30px;
            border-radius: 50px;
            transition: all 0.3s;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
        }

        .hero {
            padding: 100px 50px;
            text-align: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .hero h1 {
            font-size: 64px;
            font-weight: 800;
            margin-bottom: 20px;
            background: linear-gradient(to right, #4f46e5, #9333ea);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1.2;
        }

        .hero p {
            font-size: 20px;
            color: var(--text-muted);
            max-width: 700px;
            margin: 0 auto 40px;
        }

        .hero-btns {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-top: 30px;
        }

        .services {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            padding: 50px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .service-card {
            background: white;
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            border: 1px solid #f1f5f9;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .service-card i {
            font-size: 48px;
            color: var(--primary-color);
            margin-bottom: 20px;
            display: block;
        }

        .service-card h3 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .service-card p {
            color: var(--text-muted);
            line-height: 1.6;
        }

        .cta-section {
            background: var(--primary-color);
            padding: 80px 50px;
            text-align: center;
            color: white;
            margin-top: 50px;
        }

        .cta-section h2 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .footer {
            padding: 50px;
            text-align: center;
            color: var(--text-muted);
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .navbar { padding: 15px 20px; }
            .nav-links { 
                display: none; 
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: white;
                flex-direction: column;
                padding: 20px;
                gap: 15px;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
                border-bottom: 1px solid #f1f5f9;
            }
            .nav-links.active { display: flex; }
            .mobile-menu-btn { display: block; }
            
            .hero { padding: 60px 20px; }
            .hero h1 { font-size: 36px; }
            .hero p { font-size: 16px; }
            .hero-btns { flex-direction: column; width: 100%; }
            .hero-btns .layui-btn { width: 100%; margin-left: 0 !important; }
            
            .services { padding: 30px 20px; grid-template-columns: 1fr; }
            .service-card { padding: 30px 20px; }
            
            .cta-section { padding: 60px 20px; }
            .cta-section h2 { font-size: 28px; }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="/" class="logo">
        <i class="layui-icon layui-icon-engine" style="font-size: 30px;"></i>
        MoveCar
    </a>
    <div class="mobile-menu-btn" id="mobileMenuBtn">
        <i class="layui-icon layui-icon-spread-left"></i>
    </div>
    <div class="nav-links" id="navLinks">
        <a href="#services">服务项目</a>
        <a href="#about">关于我们</a>
        <?php if(session('?user_id')): ?>
        <a href="<?php echo url('user/profile'); ?>">个人中心 (<?php echo session('user_nickname') ?: session('user_name'); ?>)</a>
        <a href="<?php echo url('user/logout'); ?>" class="layui-btn layui-btn-primary layui-btn-sm" style="border-radius: 50px; color: var(--text-main) !important;">退出</a>
        <?php else: ?>
        <a href="<?php echo url('user/login'); ?>">登录</a>
        <a href="<?php echo url('user/register'); ?>" class="btn-primary">立即注册</a>
        <?php endif; ?>
    </div>
</nav>

<header class="hero">
    <h1>智能挪车，让出行更优雅</h1>
    <p>MoveCar 为车主提供隐私保护、即时通知的智能挪车解决方案。告别电话骚扰，守护您的隐私安全。</p>
    <div class="hero-btns">
        <?php if(session('?user_id')): ?>
        <a href="<?php echo url('user/profile'); ?>" class="layui-btn layui-btn-lg layui-btn-radius btn-primary" style="padding:0 30px;height: 45px;">进入个人中心</a>
        <?php else: ?>
        <a href="<?php echo url('user/register'); ?>" class="layui-btn layui-btn-lg layui-btn-radius btn-primary" style="padding:0 30px;height: 45px;">开始使用</a>
        <?php endif; ?>
        <a href="#services" class="layui-btn layui-btn-lg layui-btn-radius layui-btn-primary" style="border-radius: 50px;padding: 0 30px;height: 45px;">了解更多</a>
    </div>
</header>

<section id="services" class="services">
    <div class="service-card">
        <i class="layui-icon layui-icon-vercode"></i>
        <h3>隐私保护</h3>
        <p>通过专属二维码联系车主，无需展示真实手机号，有效防止骚扰电话和短信。</p>
    </div>
    <div class="service-card">
        <i class="layui-icon layui-icon-notice"></i>
        <h3>即时通知</h3>
        <p>支持 Bark、Server酱等多种推送方式，确保您能第一时间收到挪车请求。</p>
    </div>
    <div class="service-card">
        <i class="layui-icon layui-icon-location"></i>
        <h3>精准定位</h3>
        <p>自动获取请求者位置信息，让您清楚了解车辆周边情况，处理更高效。</p>
    </div>
</section>

<section class="cta-section">
    <h2>准备好加入我们了吗？</h2>
    <p style="margin-bottom: 30px; opacity: 0.9;">立即注册，生成您的专属挪车码，开启智能用车新生活。</p>
    <a href="<?php echo url('user/register'); ?>" class="layui-btn layui-btn-lg layui-btn-radius" style="background: white; color: var(--primary-color); font-weight: 600; border-radius: 50px;">免费注册</a>
</section>

<footer class="footer">
    <p>&copy; 2026 MoveCar System. All rights reserved.</p>
    <p>专业的智能挪车服务平台</p>
    <?php if(!empty($config['site_contact'])): ?>
    <p>联系方式：<?php echo htmlentities((string) $config['site_contact']); ?></p>
    <?php endif; if(!empty($config['site_icp'])): ?>
    <p>IPC备案号:<a href="https://beian.miit.gov.cn/" target="_blank" style="color: inherit;"><?php echo htmlentities((string) $config['site_icp']); ?></a></p>
    <?php endif; ?>
</footer>

<script src="/static/layui/layui.js"></script>
<script>
    layui.use(['layer'], function(){
        var $ = layui.$;
        
        // 移动端菜单切换
        $('#mobileMenuBtn').on('click', function(){
            $('#navLinks').toggleClass('active');
            var icon = $(this).find('i');
            if($('#navLinks').hasClass('active')){
                icon.removeClass('layui-icon-spread-left').addClass('layui-icon-close');
            } else {
                icon.removeClass('layui-icon-close').addClass('layui-icon-spread-left');
            }
        });

        // 点击导航链接后关闭菜单
        $('#navLinks a').on('click', function(){
            if($(window).width() <= 768){
                $('#navLinks').removeClass('active');
                $('#mobileMenuBtn find i').removeClass('layui-icon-close').addClass('layui-icon-spread-left');
            }
        });
    });
</script>
</body>
</html>
