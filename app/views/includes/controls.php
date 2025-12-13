<!-- Theme Toggle Button -->
<div class="theme-toggle" onclick="toggleTheme()" title="Cambiar tema">
    <span id="themeIcon" class="text-2xl">🌙</span>
</div>

<!-- Logout Button (Only if logged in) -->
<?php if (isset($_SESSION['auth_user']) && $_SESSION['auth_user'] === true): ?>
    <a href="<?= BASE_URL ?>auth/logout" class="logout-button" title="Cerrar Sesión">
        <span class="mr-2">🚪</span> Cerrar Sesión
    </a>
<?php endif; ?>

<!-- Music Player -->
<div class="music-player">
    <button class="music-btn" onclick="toggleMusic()" id="musicBtn" title="Reproducir/Pausar música">
        ▶️
    </button>
    <span class="text-sm font-medium dark:text-white" style="color: #667eea;">🎵</span>
    <input type="range" class="volume-slider" min="0" max="100" value="30" id="volumeSlider" title="Volumen">
</div>

<!-- Audio Element (Christmas Music) -->
<audio id="christmasMusic" loop>
    <source src="https://www.bensound.com/bensound-music/bensound-jazzyfrenchy.mp3" type="audio/mpeg">
</audio>