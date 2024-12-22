<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promotion Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
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
        .content {
            padding: 20px;
        }
        .promotion {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        .promotion-item {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 45%;
            margin: 10px 0;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .promotion-item img {
            max-width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s;
        }
        .promotion-item:hover {
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }
        .promotion-item h2 {
            margin-top: 10px;
            color: #333;
        }
        .promotion-item p {
            color: #666;
        }
        .promotion-item .view-more {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .promotion-item .view-more:hover {
            background-color: #555;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Our Promotions</h1>
    <p>We are open everyday: 8 AM - 9 PM</p>
</div>

<div class="content">
    <div class="promotion">
        <div class="promotion-item">
            <img src="dish.jpg" alt="Dish 1">
            <h2>Spaghetti Carbonara</h2>
<p>Experience the authentic flavors of Italy with our Spaghetti Carbonara. Made with al dente pasta, crispy pancetta, and a creamy sauce of eggs and Parmesan cheese, this classic dish is a delightful blend of textures and tastes. Topped with freshly ground black pepper, it's a timeless favorite for any pasta lover.</p>
            <a href="#" class="view-more" onclick="openModal('modal1')">View More</a>
        </div>
        <div class="promotion-item">
            <img src="dish2.jpg" alt="Dish 2">
            <h2>Teriyaki Chicken</h2>
<p>Savor the rich, savory flavors of our Teriyaki Chicken. This dish features tender, marinated chicken glazed with a sweet and savory teriyaki sauce, served over a bed of steamed rice. Garnished with sesame seeds and fresh scallions, it's a perfect balance of sweet, salty, and umami flavors that will leave you craving more.</p>
            <a href="#" class="view-more" onclick="openModal('modal2')">View More</a>
        </div>
        <div class="promotion-item">
            <img src="dish3.jpg" alt="Dish 3">
            <h2>Butter Chicken</h2>
            <p>Indulge in the creamy, aromatic taste of our Butter Chicken. This popular Indian dish features succulent pieces of chicken simmered in a rich, buttery tomato sauce infused with a blend of traditional spices. Served with warm, fluffy naan or basmati rice, it's a comforting and flavorful meal that brings the essence of Indian cuisine to your table.</p>
            <a href="#" class="view-more" onclick="openModal('modal3')">View More</a>
        </div>
        <div class="promotion-item">
            <img src="dish4.jpg" alt="Dish 4">
            <h2>Greek Salad</h2>
            <p>Enjoy the fresh, vibrant flavors of the Mediterranean with our Greek Salad. This healthy and refreshing dish includes crisp cucumbers, juicy tomatoes, red onions, Kalamata olives, and tangy feta cheese, all tossed in a light olive oil and lemon dressing. Perfect as a starter or a light meal, it brings the taste of the Mediterranean coast to your palate.</p>
            <a href="#" class="view-more" onclick="openModal('modal4')">View More</a>
        </div>
    </div>
</div>

<!-- Modal Structure -->
<div id="modal1" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('modal1')">&times;</span>
        <h2>Spaghetti Carbonara</h2>
        <p>Experience the authentic flavors of Italy with our Spaghetti Carbonara. Made with al dente pasta, crispy pancetta, and a creamy sauce of eggs and Parmesan cheese, this classic dish is a delightful blend of textures and tastes. Topped with freshly ground black pepper, it's a timeless favorite for any pasta lover.</p>
    </div>
</div>

<div id="modal2" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('modal2')">&times;</span>
        <h2>Teriyaki Chicken</h2>
<p>Savor the rich, savory flavors of our Teriyaki Chicken. This dish features tender, marinated chicken glazed with a sweet and savory teriyaki sauce, served over a bed of steamed rice. Garnished with sesame seeds and fresh scallions, it's a perfect balance of sweet, salty, and umami flavors that will leave you craving more.</p>
    </div>
</div>

<div id="modal3" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('modal3')">&times;</span>
        <h2>Butter Chicken</h2>
        <p>Indulge in the creamy, aromatic taste of our Butter Chicken. This popular Indian dish features succulent pieces of chicken simmered in a rich, buttery tomato sauce infused with a blend of traditional spices. Served with warm, fluffy naan or basmati rice, it's a comforting and flavorful meal that brings the essence of Indian cuisine to your table.</p>
    </div>
</div>

<div id="modal4" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('modal4')">&times;</span>
        <h2>Greek Salad</h2>
        <p>Enjoy the fresh, vibrant flavors of the Mediterranean with our Greek Salad. This healthy and refreshing dish includes crisp cucumbers, juicy tomatoes, red onions, Kalamata olives, and tangy feta cheese, all tossed in a light olive oil and lemon dressing. Perfect as a starter or a light meal, it brings the taste of the Mediterranean coast to your palate.</p>
    </div>
</div>

<script>
    function openModal(modalId) {
        document.getElementById(modalId).style.display = "block";
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = "none";
    }

    window.onclick = function(event) {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        });
    }
</script>

</body>
</html>