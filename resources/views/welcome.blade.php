<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>n8n Video Slider</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .slider-container {
            position: relative;
        }

        .scrolling-wrapper {
            overflow-x: auto;
            display: flex;
            gap: 1rem;
            scroll-behavior: smooth;
            padding: 1rem 0;
        }

        .card {
            flex: 0 0 auto;
        }

        /* Responsive widths */
        @media (min-width: 992px) {
            .card {
                width: calc(100% / 3 - 1rem);
            }
        }

        @media (min-width: 768px) and (max-width: 991px) {
            .card {
                width: calc(100% / 2 - 1rem);
            }
        }

        @media (max-width: 767px) {
            .card {
                width: 100%;
            }
        }

        .scroll-btn {
            position: absolute;
            top: 40%;
            background-color: rgba(0, 0, 0, 0.5);
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            z-index: 2;
            cursor: pointer;
            border-radius: 50%;
        }

        .scroll-btn.left {
            left: -15px;
        }

        .scroll-btn.right {
            right: -15px;
        }

        .scrolling-wrapper::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>
<body class="bg-light">

<div class="container py-5">
    <h4 class="mb-4">🚀 Quick n8n Setup & AI Agent Build Videos</h4>

    <div class="slider-container">
        <button class="scroll-btn left" onclick="scrollLeft()">&#10094;</button>
        <button class="scroll-btn right" onclick="scrollRight()">&#10095;</button>

        <div class="scrolling-wrapper" id="slider">
            <!-- Card 1 -->
            <div class="card shadow">
                <iframe width="100%" height="200" src="https://www.youtube.com/embed/2LS2H37bCXM"
                        title="YouTube video" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                <div class="card-body">
                    <p class="card-text">Set up n8n locally in under 5 minutes using Docker!</p>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="card shadow">
                <iframe width="100%" height="200" src="https://www.youtube.com/embed/tWjzXbSMi-c"
                        title="YouTube video" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                <div class="card-body">
                    <p class="card-text">Building your first AI agent with n8n and OpenAI integration.</p>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="card shadow">
                <iframe width="100%" height="200" src="https://www.youtube.com/embed/M3qBpPw77qo"
                        title="YouTube video" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                <div class="card-body">
                    <p class="card-text">Automate repetitive tasks with n8n workflows in real time.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    const slider = document.getElementById('slider');

    function scrollLeft() {
        slider.scrollBy({ left: -slider.offsetWidth, behavior: 'smooth' });
    }

    function scrollRight() {
        slider.scrollBy({ left: slider.offsetWidth, behavior: 'smooth' });
    }

    // Auto scroll every 5 seconds
    setInterval(() => {
        if (slider.scrollLeft + slider.clientWidth >= slider.scrollWidth - 10) {
            slider.scrollTo({ left: 0, behavior: 'smooth' });
        } else {
            slider.scrollBy({ left: slider.offsetWidth, behavior: 'smooth' });
        }
    }, 5000);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
