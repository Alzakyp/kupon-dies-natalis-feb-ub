(function () {
    function initEventAudio() {
        var audio = document.getElementById('event-audio');
        var btnToggle = document.getElementById('btn-toggle-audio');
        var playIcon = document.getElementById('play-icon');
        var pauseIcon = document.getElementById('pause-icon');
        var eqBars = document.getElementById('equalizer-bars');
        var statusPill = document.getElementById('audio-status-pill');
        var btnText = document.getElementById('btn-audio-text');

        if (!audio) return;

        var targetStartTime = 27; // 00:27 - Tantri scream 'Wooo!' and lyrics start
        var hasSeeked = false;

        function applyTargetTime() {
            if (hasSeeked) return;
            try {
                if (audio.readyState >= 1) { // HAVE_METADATA or higher
                    audio.currentTime = targetStartTime;
                    hasSeeked = true;
                }
            } catch (e) {
                // Ignore if audio is not ready to seek yet
            }
        }

        function setPlayingUI() {
            if (playIcon) playIcon.style.display = 'none';
            if (pauseIcon) {
                pauseIcon.style.display = 'inline-block';
                pauseIcon.classList.remove('hidden');
            }
            if (eqBars) eqBars.classList.add('playing');
            if (statusPill) {
                statusPill.textContent = 'Sedang Beraksi 🎵';
                statusPill.classList.add('playing');
            }
            if (btnText) btnText.textContent = 'Jeda Musik';
        }

        function setPausedUI() {
            if (playIcon) playIcon.style.display = 'inline-block';
            if (pauseIcon) {
                pauseIcon.style.display = 'none';
                pauseIcon.classList.add('hidden');
            }
            if (eqBars) eqBars.classList.remove('playing');
            if (statusPill) {
                statusPill.textContent = 'Musik Dijeda';
                statusPill.classList.remove('playing');
            }
            if (btnText) btnText.textContent = 'Lanjut Musik';
        }

        audio.addEventListener('loadedmetadata', applyTargetTime);
        audio.addEventListener('canplay', applyTargetTime);
        audio.addEventListener('play', function () {
            if (!hasSeeked) applyTargetTime();
            setPlayingUI();
        });
        audio.addEventListener('playing', function () {
            if (!hasSeeked) applyTargetTime();
            setPlayingUI();
        });
        audio.addEventListener('timeupdate', function () {
            if (!hasSeeked && audio.currentTime < targetStartTime) {
                applyTargetTime();
            }
        });
        audio.addEventListener('pause', setPausedUI);
        audio.addEventListener('ended', function () {
            hasSeeked = false;
            setPausedUI();
        });

        var audioStarted = false;
        var gestureEvents = ['click', 'touchstart', 'touchend', 'pointerdown', 'keydown'];

        function removeGestureListeners() {
            gestureEvents.forEach(function (evt) {
                window.removeEventListener(evt, handleGesture, true);
                document.removeEventListener(evt, handleGesture, true);
            });
        }

        function handleGesture(e) {
            if (audioStarted && !audio.paused) {
                removeGestureListeners();
                return;
            }
            playSong();
        }

        function playSong() {
            applyTargetTime();
            var promise = audio.play();
            if (promise !== undefined) {
                promise.then(function () {
                    audioStarted = true;
                    setPlayingUI();
                    removeGestureListeners();
                }).catch(function (err) {
                    // Browser prevented autoplay without prior gesture; listeners will trigger on first interaction
                    console.log('Autoplay deferred until user interaction:', err);
                });
            }
        }

        // Attach gesture listeners for fallback on first user action anywhere
        gestureEvents.forEach(function (evt) {
            window.addEventListener(evt, handleGesture, { capture: true, passive: true });
            document.addEventListener(evt, handleGesture, { capture: true, passive: true });
        });

        // 1. Try immediate autoplay right away
        playSong();

        // 2. Manual Play/Pause Button
        if (btnToggle) {
            btnToggle.addEventListener('click', function (e) {
                e.stopPropagation();
                if (audio.paused) {
                    playSong();
                } else {
                    audio.pause();
                }
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initEventAudio);
    } else {
        initEventAudio();
    }
})();
