<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .header {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
        }
        .main {
            text-align: center;
            padding: 20px;
            flex: 1;
        }
        .main img {
            width: 80%;
            height: auto;
            max-width: 600px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .main img:hover {
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
        }
        .history {
            max-width: 800px;
            margin: 20px auto;
            text-align: left;
        }
        .history h2 {
            text-align: center;
            color: #333;
        }
        .history p {
            color: #666;
            line-height: 1.6;
        }
        .history .section {
            margin-bottom: 20px;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .history .section.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .history .section p {
            margin: 0;
        }
        .history .section:first-of-type p::first-letter {
            font-size: 2em;
            float: left;
            margin-right: 8px;
            color: #333;
        }
        .footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px;
            position: relative;
            bottom: 0;
            width: 100%;
        }
        .footer a {
            color: #fff;
            text-decoration: none;
            margin: 0 10px;
            padding: 10px 20px;
            background-color: #ff6600;
            border-radius: 5px;
            transition: background-color 0.3s, transform 0.3s;
        }
        .footer a:hover {
            background-color: #ff8533;
            transform: scale(1.1);
        }
    </style>
</head>
<body>

<div class="header">
    <h1>About Us</h1>
</div>

<div class="main">
    <img src="Untitled design.jpg" alt="Cafe Image">
    <div class="history">
        <h2>A History of Our Café</h2>
        <div class="section">
            <p>From humble beginnings, our café has blossomed into a beloved local hangout. We pride ourselves on serving the freshest ingredients, sourced locally whenever possible. Our cozy atmosphere and friendly staff make it the perfect spot for a morning coffee or an afternoon break.</p>
        </div>
        <div class="section">
            <p>Established in 2005, our café has been a cornerstone of the community. We are committed to providing exceptional service and a welcoming environment for all. Whether you're here for a quick bite or a leisurely meal, we strive to make every visit special.</p>
        </div>
        <div class="section">
            <p>At our café, we believe in the power of community. That's why we host regular events, from live music to art exhibitions, supporting local talent and creating a space where people can come together. Join us and become a part of our vibrant community.</p>
        </div>
    </div>
</div>

<div class="footer">
    <p>Curabitur sed iaculis dolor, non congue ligula</p>
    <a href="#">View More</a>
    <a href="#">Contact Us</a>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var sections = document.querySelectorAll('.section');
        var options = {
            threshold: 0.5
        };
        var observer = new IntersectionObserver(function(entries, observer) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, options);

        sections.forEach(section => {
            observer.observe(section);
        });
    });
</script>

</body>
</html>