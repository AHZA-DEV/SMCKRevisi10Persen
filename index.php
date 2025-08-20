<!DOCTYPE html>
<html lang="id">

<head>
    <script src="https://static.readdy.ai/static/e.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Cuti Karyawan</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark');
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#64748B'
                    },
                    borderRadius: {
                        'none': '0px',
                        'sm': '4px',
                        DEFAULT: '8px',
                        'md': '12px',
                        'lg': '16px',
                        'xl': '20px',
                        '2xl': '24px',
                        '3xl': '32px',
                        'full': '9999px',
                        'button': '8px'
                    }
                }
            }
        }
    </script>
    <style>
        :where([class^="ri-"])::before {
            content: "\f3c2";
        }

        .gradient-bg {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }

        .dark .gradient-bg {
            background: linear-gradient(135deg, #1a1f2c 0%, #111827 100%);
        }
    </style>
</head>

<body class="bg-white dark:bg-gray-900 transition-colors">
    <header class="bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-700 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-6">
                    <div class="font-bold text-2xl text-primary dark:text-blue-400">SMCK</div>
                    <button id="darkModeToggle"
                        class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="ri-sun-line dark:hidden text-xl text-gray-700"></i>
                        <i class="ri-moon-line hidden dark:block text-xl text-white"></i>
                    </button>
                </div>
                <a href="https://readdy.ai/home/010bfdc8-ec51-4719-9d6e-62d050c9c0de/3384f74c-a7e5-43f6-81ba-cb2aa0a38ff7"
                    data-readdy="true">
                    <a href="login.php"
                        class="bg-primary text-white px-6 py-2.5 !rounded-button hover:bg-blue-600 transition-colors whitespace-nowrap font-medium dark:bg-blue-500 dark:hover:bg-blue-600">
                        Login
                    </a>
                </a>
            </div>
        </div>
    </header>
    <main>
        <section class="gradient-bg min-h-screen flex items-center justify-center py-20">
            <div class="w-full max-w-7xl mx-auto px-6">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="space-y-8">
                        <div class="space-y-6">
                            <h1 class="text-5xl lg:text-6xl font-bold text-gray-900 dark:text-white leading-tight">
                                Sistem Manajemen
                                <span class="text-primary dark:text-blue-400">Cuti Karyawan</span>
                            </h1>
                            <p class="text-xl text-gray-600 dark:text-gray-200 leading-relaxed max-w-lg">
                                Kelola pengajuan cuti karyawan dengan mudah dan efisien. Sistem terintegrasi untuk HR
                                modern yang mengutamakan produktivitas dan transparansi.
                            </p>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="dashboard.php"
                                class="bg-primary text-white px-8 py-4 !rounded-button hover:bg-blue-600 transition-all duration-300 font-semibold text-lg whitespace-nowrap">
                                Demo Dashboard
                            </a>
                            <a href="login.php"
                                class="border-2 border-gray-300 text-gray-700 px-8 py-4 !rounded-button hover:border-primary hover:text-primary transition-all duration-300 font-semibold text-lg whitespace-nowrap">
                                login
                            </a>
                        </div>
                    </div>
                    <div class="hidden lg:block">
                        <img src="assets/bg.jpg" alt="Sistem Manajemen Cuti Karyawan"
                            class="rounded-lg shadow-lg">
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 bg-white dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 mb-6">Fitur Unggulan</h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Solusi lengkap untuk mengelola sistem cuti karyawan dengan teknologi terdepan dan antarmuka yang
                        intuitif
                    </p>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div
                        class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 dark:border-gray-700">
                        <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center mb-6">
                            <i class="ri-calendar-check-line text-2xl text-primary"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Pengajuan Otomatis</h3>
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            Karyawan dapat mengajukan cuti dengan mudah melalui sistem yang terintegrasi dengan approval
                            workflow
                        </p>
                    </div>
                    <div
                        class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 dark:border-gray-700">
                        <div class="w-16 h-16 bg-green-100 rounded-xl flex items-center justify-center mb-6">
                            <i class="ri-user-settings-line text-2xl text-green-600"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Manajemen Tim</h3>
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            Kelola tim dan departemen dengan mudah, atur hak akses dan approval berdasarkan hierarki
                            organisasi
                        </p>
                    </div>
                    <div
                        class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 dark:border-gray-700">
                        <div class="w-16 h-16 bg-purple-100 rounded-xl flex items-center justify-center mb-6">
                            <i class="ri-bar-chart-box-line text-2xl text-purple-600"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Laporan Real-time</h3>
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            Dashboard analitik lengkap dengan laporan penggunaan cuti, tren, dan insights untuk
                            pengambilan keputusan
                        </p>
                    </div>
                    <div
                        class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 dark:border-gray-700">
                        <div class="w-16 h-16 bg-orange-100 rounded-xl flex items-center justify-center mb-6">
                            <i class="ri-notification-3-line text-2xl text-orange-600"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Notifikasi Pintar</h3>
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            Sistem notifikasi otomatis untuk pengingat, approval, dan update status cuti melalui email
                            dan aplikasi
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-20 gradient-bg">
            <div class="max-w-4xl mx-auto px-6 text-center">
                <div class="space-y-8">
                    <h2 class="text-4xl font-bold text-gray-900 dark:text-white">
                        Siap Meningkatkan Efisiensi HR Anda?
                    </h2>
                    <p class="text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                        Bergabunglah dengan ribuan perusahaan yang telah mempercayai sistem kami untuk mengelola cuti
                        karyawan dengan lebih efektif dan transparan.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <button
                            class="bg-primary text-white px-8 py-4 !rounded-button hover:bg-blue-600 transition-all duration-300 font-semibold text-lg whitespace-nowrap">
                            Mulai Gratis Sekarang
                        </button>
                        <button
                            class="border-2 border-gray-300 text-gray-700 px-8 py-4 !rounded-button hover:border-primary hover:text-primary transition-all duration-300 font-semibold text-lg whitespace-nowrap">
                            Jadwalkan Demo
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer class="bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-6 py-12">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="space-y-4">
                    <div class="font-['Pacifico'] text-2xl text-primary dark:text-blue-400">logo</div>
                    <p class="text-gray-600 dark:text-gray-300">
                        Solusi terdepan untuk manajemen cuti karyawan yang efisien dan modern.
                    </p>
                </div>
                <div class="space-y-4">
                    <h4 class="font-semibold text-gray-900 dark:text-white">Produk</h4>
                    <ul class="space-y-2 text-gray-600 dark:text-gray-300">
                        <li><a href="#" class="hover:text-primary transition-colors">Fitur Utama</a></li>
                        <li><a href="#" class="hover:text-primary transition-colors">Integrasi</a></li>
                        <li><a href="#" class="hover:text-primary transition-colors">API</a></li>
                        <li><a href="#" class="hover:text-primary transition-colors">Keamanan</a></li>
                    </ul>
                </div>
                <div class="space-y-4">
                    <h4 class="font-semibold text-gray-900 dark:text-white">Dukungan</h4>
                    <ul class="space-y-2 text-gray-600 dark:text-gray-300">
                        <li><a href="#" class="hover:text-primary transition-colors">Bantuan</a></li>
                        <li><a href="#" class="hover:text-primary transition-colors">Dokumentasi</a></li>
                        <li><a href="#" class="hover:text-primary transition-colors">Kontak</a></li>
                        <li><a href="#" class="hover:text-primary transition-colors">Status Sistem</a></li>
                    </ul>
                </div>
                <div class="space-y-4">
                    <h4 class="font-semibold text-gray-900 dark:text-white">Perusahaan</h4>
                    <ul class="space-y-2 text-gray-600 dark:text-gray-300">
                        <li><a href="#" class="hover:text-primary transition-colors">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-primary transition-colors">Karir</a></li>
                        <li><a href="#" class="hover:text-primary transition-colors">Blog</a></li>
                        <li><a href="#" class="hover:text-primary transition-colors">Kebijakan Privasi</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-200 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-600 dark:text-gray-300">© 2025 Sistem Manajemen Cuti. Semua hak dilindungi.</p>
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <a href="#"
                        class="w-10 h-10 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center hover:bg-primary hover:text-white transition-colors">
                        <i class="ri-facebook-fill text-lg"></i>
                    </a>
                    <a href="#"
                        class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center hover:bg-primary hover:text-white transition-colors">
                        <i class="ri-twitter-fill text-lg"></i>
                    </a>
                    <a href="#"
                        class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center hover:bg-primary hover:text-white transition-colors">
                        <i class="ri-linkedin-fill text-lg"></i>
                    </a>
                    <a href="#"
                        class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center hover:bg-primary hover:text-white transition-colors">
                        <i class="ri-instagram-fill text-lg"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>
    <script id="dark-mode-functionality">
        document.addEventListener('DOMContentLoaded', function () {
            const darkModeToggle = document.getElementById('darkModeToggle');
            darkModeToggle.addEventListener('click', function () {
                document.documentElement.classList.toggle('dark');
                localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
            });
        });
    </script>
    <script id="cta-functionality">
        document.addEventListener('DOMContentLoaded', function () {
            const ctaButtons = document.querySelectorAll('button');
            ctaButtons.forEach(button => {
                if (button.textContent.includes('Mulai') || button.textContent.includes('Demo')) {
                    button.addEventListener('click', function () {
                        if (button.textContent.includes('Demo')) {
                            alert('Terima kasih! Tim kami akan menghubungi Anda untuk menjadwalkan demo.');
                        } else {
                            alert('Selamat datang! Pendaftaran akan segera tersedia.');
                        }
                    });
                }
            });
        });
    </script>
    <script>
        !function (t, e) { var o, n, p, r; e.__SV || (window.posthog = e, e._i = [], e.init = function (i, s, a) { function g(t, e) { var o = e.split("."); 2 == o.length && (t = t[o[0]], e = o[1]), t[e] = function () { t.push([e].concat(Array.prototype.slice.call(arguments, 0))) } } (p = t.createElement("script")).type = "text/javascript", p.crossOrigin = "anonymous", p.async = !0, p.src = s.api_host.replace(".i.posthog.com", "-assets.i.posthog.com") + "/static/array.js", (r = t.getElementsByTagName("script")[0]).parentNode.insertBefore(p, r); var u = e; for (void 0 !== a ? u = e[a] = [] : a = "posthog", u.people = u.people || [], u.toString = function (t) { var e = "posthog"; return "posthog" !== a && (e += "." + a), t || (e += " (stub)"), e }, u.people.toString = function () { return u.toString(1) + ".people (stub)" }, o = "init capture register register_once register_for_session unregister unregister_for_session getFeatureFlag getFeatureFlagPayload isFeatureEnabled reloadFeatureFlags updateEarlyAccessFeatureEnrollment getEarlyAccessFeatures on onFeatureFlags onSessionId getSurveys getActiveMatchingSurveys renderSurvey canRenderSurvey getNextSurveyStep identify setPersonProperties group resetGroups setPersonPropertiesForFlags resetPersonPropertiesForFlags setGroupPropertiesForFlags resetGroupPropertiesForFlags reset get_distinct_id getGroups get_session_id get_session_replay_url alias set_config startSessionRecording stopSessionRecording sessionRecordingStarted captureException loadToolbar get_property getSessionProperty createPersonProfile opt_in_capturing opt_out_capturing has_opted_in_capturing has_opted_out_capturing clear_opt_in_out_capturing debug".split(" "), n = 0; n < o.length; n++)g(u, o[n]); e._i.push([i, s, a]) }, e.__SV = 1) }(document, window.posthog || []);
        posthog.init('phc_t9tkQZJiyi2ps9zUYm8TDsL6qXo4YmZx0Ot5rBlAlEd', {
            api_host: 'https://us.i.posthog.com',
            autocapture: false,
            capture_pageview: false,
            capture_pageleave: false,
            capture_performance: {
                web_vitals: false,
            },
            rageclick: false,
        })
        window.shareKey = 'gMdAJ6PgwH50sJZD2QQBmg';
        window.host = 'readdy.ai';
    </script>

</html>