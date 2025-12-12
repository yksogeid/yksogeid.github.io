// Dark Mode Management
function initTheme() {
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const savedTheme = localStorage.getItem('theme');

    if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
        document.documentElement.classList.add('dark');
        updateThemeIcon(true);
    } else {
        document.documentElement.classList.remove('dark');
        updateThemeIcon(false);
    }
}

function updateThemeIcon(isDark) {
    const themeIcon = document.getElementById('themeIcon');
    if (themeIcon) {
        themeIcon.textContent = isDark ? '☀️' : '🌙';
    }
}

function toggleTheme() {
    const isDark = document.documentElement.classList.toggle('dark');
    updateThemeIcon(isDark);
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
}

window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
    if (!localStorage.getItem('theme')) {
        if (e.matches) {
            document.documentElement.classList.add('dark');
            updateThemeIcon(true);
        } else {
            document.documentElement.classList.remove('dark');
            updateThemeIcon(false);
        }
    }
});

// Music Player Management
let music, musicBtn, volumeSlider, isPlaying = false;

function initMusicPlayer() {
    music = document.getElementById('christmasMusic');
    musicBtn = document.getElementById('musicBtn');
    volumeSlider = document.getElementById('volumeSlider');

    if (!music || !musicBtn || !volumeSlider) return;

    music.volume = 0.3;

    volumeSlider.addEventListener('input', function () {
        music.volume = this.value / 100;
    });
}

function toggleMusic() {
    if (!music) return;

    if (isPlaying) {
        music.pause();
        musicBtn.textContent = '▶️';
        isPlaying = false;
    } else {
        music.play().catch(e => {
            console.log('Auto-play prevented. User interaction required.');
        });
        musicBtn.textContent = '⏸️';
        isPlaying = true;
    }
}

// Enhanced Snowfall Effect
function createSnowflakes() {
    // Detect if mobile
    const isMobile = window.innerWidth <= 768;
    const snowflakeCount = isMobile ? 20 : 50; // Less snowflakes on mobile
    const snowflakeChars = ['❄', '❅', '❆'];

    for (let i = 0; i < snowflakeCount; i++) {
        const snowflake = document.createElement('div');
        snowflake.className = 'snowflake';
        snowflake.textContent = snowflakeChars[Math.floor(Math.random() * snowflakeChars.length)];
        snowflake.style.left = Math.random() * 100 + '%';
        snowflake.style.animationDuration = (Math.random() * 3 + 7) + 's';
        snowflake.style.animationDelay = Math.random() * 5 + 's';
        snowflake.style.fontSize = (Math.random() * 0.3 + 0.8) + 'em';
        document.body.appendChild(snowflake);
    }
}

// Christmas Lights
function createChristmasLights() {
    const lightsContainer = document.createElement('div');
    lightsContainer.className = 'christmas-lights';

    // Detect if mobile
    const isMobile = window.innerWidth <= 768;
    const lightCount = isMobile ? 15 : 25;

    for (let i = 0; i < lightCount; i++) {
        const light = document.createElement('div');
        light.className = 'light';
        light.style.animationDelay = (i * 0.1) + 's';
        lightsContainer.appendChild(light);
    }

    document.body.appendChild(lightsContainer);
}

// Prevent zoom on double tap (iOS)
let lastTouchEnd = 0;
document.addEventListener('touchend', function (event) {
    const now = (new Date()).getTime();
    if (now - lastTouchEnd <= 300) {
        event.preventDefault();
    }
    lastTouchEnd = now;
}, false);

// Smooth scroll behavior
document.documentElement.style.scrollBehavior = 'smooth';

// Initialize on page load
window.addEventListener('load', function () {
    initTheme();
    initMusicPlayer();
    createSnowflakes();
    createChristmasLights();

    // Add viewport height fix for mobile browsers
    const setVH = () => {
        const vh = window.innerHeight * 0.01;
        document.documentElement.style.setProperty('--vh', `${vh}px`);
    };

    setVH();
    window.addEventListener('resize', setVH);
});

// Optimize performance on mobile
if (window.innerWidth <= 768) {
    // Reduce animation complexity on mobile
    document.body.style.willChange = 'auto';
}
