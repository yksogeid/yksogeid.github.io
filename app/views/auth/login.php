<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso - Navidad</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/styles.css">
</head>

<body class="bg-gray-100 dark:bg-gray-900 min-h-screen flex items-center justify-center p-4 transition-colors duration-300">

    <!-- Snowfall Container (Dark snowflakes in light mode, white in dark) -->
    <style>
        .snowflake {
            background-color: #cbd5e1; /* Light gray for light mode */
        }
        .dark .snowflake {
            background-color: white;
        }
    </style>
    <div id="snow-container" class="fixed inset-0 pointer-events-none z-0"></div>

    <div
        class="max-w-md w-full glass-card rounded-2xl p-8 shadow-2xl relative z-10 transform transition-all hover:scale-[1.01] bg-white/70 dark:bg-gray-800/80 backdrop-blur-xl border border-white/20">

        <div class="text-center mb-8">
            <div
                class="w-20 h-20 mx-auto bg-gradient-to-br from-red-500 to-red-700 rounded-full flex items-center justify-center shadow-lg mb-4 animate-bounce">
                <span class="text-4xl">🔒</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2" style="font-family: 'Mountains of Christmas', cursive;">
                Acceso Restringido
            </h1>
            <p class="text-gray-600 dark:text-gray-300 font-medium">
                Por favor, ingresa la contraseña para continuar 🎄
            </p>
        </div>

        <?php if (!empty($error)): ?>
            <div
                class="bg-red-100 border border-red-200 text-red-700 dark:bg-red-500/20 dark:border-red-500/50 dark:text-gray-100 p-3 rounded-lg mb-6 text-center text-sm font-semibold animate-pulse">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>auth/authenticate" method="POST" class="space-y-6">
            <div>
                <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2 ml-1">Contraseña</label>
                <div class="relative">
                    <span class="absolute left-4 top-3.5 text-gray-400">🔑</span>
                    <input type="password" name="password" required
                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-xl px-10 py-3 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-white transition-all text-center tracking-widest text-lg dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                        placeholder="••••••••••••">
                </div>
            </div>

            <button type="submit"
                class="w-full bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold py-3.5 rounded-xl shadow-lg transform transition-all hover:-translate-y-1 hover:shadow-2xl active:scale-95">
                🎅 Entrar
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-xs text-gray-500 dark:text-gray-400">Sistema Navideño 2025</p>
        </div>
    </div>

    <!-- Music Player (Hidden but functional if needed) -->
    <!-- Not including full controls here to keep login clean -->

    <script>
        // Simple snow effect specific for login if main js is heavy or depends on other things
        function createSnowflake() {
            const snow = document.createElement('div');
            snow.classList.add('fixed', 'rounded-full', 'opacity-80', 'pointer-events-none', 'snowflake');
            // Remove hardcoded bg-white here, handled by CSS
            
            snow.style.left = Math.random() * 100 + 'vw';
            snow.style.animationDuration = Math.random() * 3 + 2 + 's';
            snow.style.opacity = Math.random();
            snow.style.width = snow.style.height = Math.random() * 5 + 2 + 'px';

            snow.animate([
                { transform: 'translateY(-10px)' },
                { transform: 'translateY(100vh)' }
            ], {
                duration: Math.random() * 3000 + 2000,
                iterations: 1,
                easing: 'linear'
            }).onfinish = () => snow.remove();

            document.getElementById('snow-container').appendChild(snow);
        }
        setInterval(createSnowflake, 100);
    </script>
</body>

</html>