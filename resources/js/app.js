import './bootstrap';



// Theme initialization and toggle
(function () {
    const storageKey = 'theme';
    const classList = document.documentElement.classList;
    function applyTheme(theme) {
        if (theme === 'dark') {
            classList.add('dark');
        } else {
            classList.remove('dark');
        }
    }
    // Determine initial theme: localStorage > system preference
    try {
        const stored = localStorage.getItem(storageKey);
        if (stored === 'dark' || stored === 'light') {
            applyTheme(stored);
        } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            applyTheme('dark');
        } else {
            applyTheme('light');
        }
    } catch (_) {
        // Fallback to light if storage is unavailable
        applyTheme('light');
    }
    // Expose toggle for UI
    window.__toggleTheme = function () {
        const isDark = document.documentElement.classList.contains('dark');
        const next = isDark ? 'light' : 'dark';
        applyTheme(next);
        try { localStorage.setItem(storageKey, next); } catch (_) { }
    };
})();
