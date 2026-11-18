/**
 * Grand Fiesta FEB UB - Celebratory Confetti & Micro-interactions
 */
(function () {
    var canvas = document.getElementById('success-confetti-canvas');
    if (!canvas) return;

    var ctx = canvas.getContext('2d');
    var particles = [];
    var animationFrameId = null;
    var colors = [
        '#d3a128', // UB Gold
        '#f59e0b', // Amber
        '#092b4c', // FEB Navy
        '#10b981', // Emerald
        '#ef4444', // Red
        '#0284c7', // Sky Blue
        '#8b5cf6', // Violet
        '#ec4899'  // Pink
    ];

    function resizeCanvas() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    }

    window.addEventListener('resize', resizeCanvas);
    resizeCanvas();

    function prefersReducedMotion() {
        return window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    }

    function createParticle(x, y, vx, vy, color) {
        var shapes = ['rect', 'circle', 'star'];
        return {
            x: x,
            y: y,
            vx: vx,
            vy: vy,
            size: Math.random() * 8 + 6,
            color: color || colors[Math.floor(Math.random() * colors.length)],
            shape: shapes[Math.floor(Math.random() * shapes.length)],
            rotation: Math.random() * 360,
            rotSpeed: (Math.random() - 0.5) * 8,
            tilt: Math.random() * 10,
            tiltSpeed: Math.random() * 0.1 + 0.05,
            opacity: 1,
            decay: Math.random() * 0.005 + 0.003
        };
    }

    function spawnBurst(originX, originY, count, spreadAngle, baseSpeed) {
        if (prefersReducedMotion()) return;
        for (var i = 0; i < count; i++) {
            var angle = spreadAngle + (Math.random() - 0.5) * 1.2;
            var speed = baseSpeed * (0.6 + Math.random() * 0.8);
            var vx = Math.cos(angle) * speed;
            var vy = Math.sin(angle) * speed;
            particles.push(createParticle(originX, originY, vx, vy));
        }
        if (!animationFrameId) {
            animate();
        }
    }

    function launchConfettiWave() {
        if (prefersReducedMotion()) return;
        var w = window.innerWidth;
        var h = window.innerHeight;

        // Left cannon shooting up-right
        spawnBurst(w * 0.1, h * 0.9, 45, -Math.PI / 3, 18);
        // Right cannon shooting up-left
        spawnBurst(w * 0.9, h * 0.9, 45, -2 * Math.PI / 3, 18);

        // Center burst after short delay
        setTimeout(function () {
            spawnBurst(w * 0.5, h * 0.7, 50, -Math.PI / 2, 16);
        }, 300);
    }

    function drawStar(ctx, cx, cy, spikes, outerRadius, innerRadius) {
        var rot = (Math.PI / 2) * 3;
        var x = cx;
        var y = cy;
        var step = Math.PI / spikes;

        ctx.beginPath();
        ctx.moveTo(cx, cy - outerRadius);
        for (var i = 0; i < spikes; i++) {
            x = cx + Math.cos(rot) * outerRadius;
            y = cy + Math.sin(rot) * outerRadius;
            ctx.lineTo(x, y);
            rot += step;

            x = cx + Math.cos(rot) * innerRadius;
            y = cy + Math.sin(rot) * innerRadius;
            ctx.lineTo(x, y);
            rot += step;
        }
        ctx.lineTo(cx, cy - outerRadius);
        ctx.closePath();
        ctx.fill();
    }

    function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        for (var i = particles.length - 1; i >= 0; i--) {
            var p = particles[i];

            p.x += p.vx;
            p.y += p.vy;
            p.vy += 0.38; // Gravity
            p.vx *= 0.985; // Drag
            p.vy *= 0.985;
            p.rotation += p.rotSpeed;
            p.tilt += p.tiltSpeed;
            p.opacity -= p.decay;

            if (p.opacity <= 0 || p.y > canvas.height + 50) {
                particles.splice(i, 1);
                continue;
            }

            ctx.save();
            ctx.globalAlpha = Math.max(0, p.opacity);
            ctx.fillStyle = p.color;
            ctx.translate(p.x, p.y);
            ctx.rotate((p.rotation * Math.PI) / 180);

            var scaleX = Math.cos(p.tilt);
            ctx.scale(scaleX, 1);

            if (p.shape === 'circle') {
                ctx.beginPath();
                ctx.arc(0, 0, p.size / 2, 0, Math.PI * 2);
                ctx.fill();
            } else if (p.shape === 'star') {
                drawStar(ctx, 0, 0, 5, p.size * 0.7, p.size * 0.35);
            } else {
                ctx.fillRect(-p.size / 2, -p.size / 4, p.size, p.size / 2);
            }

            ctx.restore();
        }

        if (particles.length > 0) {
            animationFrameId = requestAnimationFrame(animate);
        } else {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            animationFrameId = null;
        }
    }

    // Expose global trigger
    window.launchCelebration = function () {
        launchConfettiWave();
    };

    // Auto-launch on load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(launchConfettiWave, 250);
        });
    } else {
        setTimeout(launchConfettiWave, 250);
    }

    // Copy Ticket Code Button interaction
    var copyBtn = document.getElementById('btn-copy-ticket');
    if (copyBtn) {
        copyBtn.addEventListener('click', function () {
            var codeText = copyBtn.getAttribute('data-code');
            if (!codeText) return;

            var feedback = document.getElementById('copy-feedback');
            function showSuccess() {
                if (feedback) {
                    feedback.textContent = 'Kode disalin! ✓';
                    feedback.classList.add('show');
                    setTimeout(function () {
                        feedback.classList.remove('show');
                        setTimeout(function () { feedback.textContent = ''; }, 300);
                    }, 2200);
                }
            }

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(codeText).then(showSuccess).catch(function () {
                    fallbackCopy(codeText, showSuccess);
                });
            } else {
                fallbackCopy(codeText, showSuccess);
            }
        });
    }

    function fallbackCopy(text, callback) {
        var textArea = document.createElement('textarea');
        textArea.value = text;
        textArea.style.position = 'fixed';
        textArea.style.opacity = '0';
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        try {
            document.execCommand('copy');
            if (callback) callback();
        } catch (e) {
            // copy failed
        }
        document.body.removeChild(textArea);
    }
})();
