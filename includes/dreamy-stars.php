<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evenly Spaced Falling Stars</title>
    <style>
    body {
        margin: 0;
        padding: 0;
        height: 100vh;
        overflow: hidden;
    }

    .stars-container {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        pointer-events: none;
        display: none;
        z-index: -9999;
    }

    .star {
        position: absolute;
        color: white;
        font-size: 24px;
        animation: fall linear infinite;
        opacity: 0;
        text-shadow:
            0 0 10px rgba(255, 255, 255, 0.8),
            0 0 20px rgba(255, 255, 255, 0.4);
        will-change: transform, opacity;
        z-index: 10;
    }

    @keyframes fall {
        0% {
            transform: translateY(-100px) rotate(0deg) scale(0.5);
            opacity: 0;
        }

        10% {
            opacity: 1;
            transform: scale(1.2);
        }

        90% {
            opacity: 1;
        }

        100% {
            transform: translateY(100vh) rotate(360deg) scale(0.5);
            opacity: 0;
        }
    }

    @media (max-width: 768px) {
        .stars-container {
            display: block;
        }

        .star {
            font-size: 12px;
            /* Smaller stars on mobile */
        }
    }

    @media screen and (max-width: 1024px) and (min-width: 769px) {
        .stars-container {
            display: block;
        }

        .star {
            font-size: 16px;
            /* Medium stars on tablets */
        }
    }
    </style>
</head>

<body>
    <div class="stars-container">
        <div class="star" id="star-template">★</div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.querySelector('.stars-container');
        const template = document.getElementById('star-template');
        const starCount = 20; // Reduced number for better spacing
        const minDistance = 5; // Minimum percentage distance between stars
        let positions = [];

        template.remove();

        // Initialize positions with more spacing
        for (let i = 0; i < starCount; i++) {
            createStar(i);
        }

        function createStar(index) {
            const star = template.cloneNode(true);
            let left;
            let attempts = 0;
            const maxAttempts = 20;

            // Find a position that's not too close to others
            do {
                left = Math.random() * 100;
                attempts++;
                if (attempts >= maxAttempts) {
                    // If we can't find a good spot, just pick any
                    break;
                }
            } while (positions.some(pos => Math.abs(pos - left) < minDistance));

            positions.push(left);
            if (positions.length > starCount) positions.shift();

            const delay = Math.random() * -10;
            const duration = Math.random() * 8 + 8;
            const size = Math.random() * 1.2 + 0.8; // Smaller size variation
            const hue = 190 + Math.random() * 40;
            const opacity = Math.random() * 0.5 + 0.3; // Reduced max opacity
            const glowIntensity = Math.random() * 0.4 + 0.4; // Softer glow

            star.style.left = `${left}%`;
            star.style.animationDelay = `${delay}s`;
            star.style.animationDuration = `${duration}s`;
            star.style.fontSize = `${size}em`;
            star.style.color = `hsla(${hue}, 80%, 90%, ${opacity})`;
            star.style.textShadow = `
                    0 0 ${8 * glowIntensity}px rgba(255, 255, 255, ${0.6 * glowIntensity}),
                    0 0 ${15 * glowIntensity}px rgba(255, 255, 255, ${0.3 * glowIntensity})`;

            container.appendChild(star);

            setTimeout(() => {
                star.remove();
                const posIndex = positions.indexOf(left);
                if (posIndex > -1) positions.splice(posIndex, 1);
                createStar(index);
            }, duration * 1000);
        }
    });
    </script>
</body>

</html>