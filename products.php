<?php include('header.php'); ?>

<body>


  
    <br>
    <div class="product-grid-wrapper">
        <h1>Merch</h1>
        <div class="product-grid">

            <!-- Product Card 1 -->
            <div class="product-card">
                <img src="https://images.footballfanatics.com/san-jose-state-spartans/mens-gameday-greats-number-1-white-san-jose-state-spartans-lightweight-basketball-jersey_ss5_p-200939478+u-xvp0epcklssnbrypc8p5+v-gsbwtolktlbsbbcyvn3z.png?_hv=2"
                    alt="Product 1">
                <div class="product-info">
                    <h2>Spartan Home Jersey</h2>
                    <p>$29.99</p>
                    <button>Add to Cart</button>
                </div>
            </div>

            <!-- Product Card 2 -->
            <div class="product-card">
                <img src="https://images.footballfanatics.com/san-jose-state-spartans/unisex-gameday-greats-number-1-pink-san-jose-state-spartans-lightweight-basketball-jersey_ss5_p-201141949+pv-2+u-9lvr3hj9bzraapkebwzh+v-ke1g7vamtdrkdlvy1wqb.jpg?_hv=2&w=900"
                    alt="Product 2">
                <div class="product-info">
                    <h2>Spartan Special Jersey</h2>
                    <p>$39.99</p>
                    <button>Add to Cart</button>
                </div>
            </div>

            <!-- Product Card 3 -->
            <div class="product-card">
                <img src="https://images.footballfanatics.com/san-jose-state-spartans/mens-gameday-greats-number-1-black-san-jose-state-spartans-lightweight-basketball-jersey_ss5_p-200939479+u-7xsrxfvcerzopxmpbbmf+v-pbazgngroifxwbvi7ooc.png?_hv=2" alt="Product 3">
                <div class="product-info">
                    <h2>Spartan Gameday Jersey</h2>
                    <p>$49.99</p>
                    <button>Add to Cart</button>
                </div>
            </div>

            <!-- Product Card 4 -->
            <div class="product-card">
                <img src="https://images.footballfanatics.com/san-jose-state-spartans/mens-gameday-greats-number-1-royal-san-jose-state-spartans-lightweight-basketball-jersey_ss5_p-200939480+pv-1+u-r981abcxbwg6dbzqihcy+v-gumqrins7oqdfvqassti.png?_hv=2&w=900" alt="Product 4">
                <div class="product-info">
                    <h2>Spartan Royal Jersey</h2>
                    <p>$59.99</p>
                    <button>Add to Cart</button>
                </div>
            </div>
        </div>
    </div>
    <style>
        * {
            box-sizing: border-box;
        }

        .product-grid-wrapper {
            justify-content: center;
            padding: 20px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .product-card {
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-card img {
            display: block;
            margin: 0 auto;
            /* ✅ centers block-level image */
            width: 300px;
            height: 300px;
        }

        .product-info {
            text-align: center;

        }

        .product-title {
            font-size: 18px;
            margin: 0 0 10px;
            color: #333;
        }

        .product-price {
            font-size: 16px;
            color: #27ae60;
            margin-bottom: 15px;
        }

        .product-button {
            display: inline-block;
            padding: 10px 15px;
            background: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .product-button:hover {
            background: #2980b9;
        }
    </style>
</body>