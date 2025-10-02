<?php include('header.php'); ?>
<head>

  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }


    /* News Grid */
    .news-container {
      max-width: 1200px;
      margin: 40px auto;
      padding: 0 20px;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 30px;
    }

    .news-card {
      background: white;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
      transition: transform 0.2s ease;
    }

    .news-card:hover {
      transform: translateY(-5px);
    }

    .news-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    .news-content {
      padding: 20px;
    }

    .news-title {
      font-size: 20px;
      margin-bottom: 10px;
      color: #2c3e50;
    }

    .news-excerpt {
      font-size: 16px;
      color: #555;
      margin-bottom: 15px;
    }

    .read-more {
      text-decoration: none;
      color: #3498db;
      font-weight: bold;
    }

    .read-more:hover {
      text-decoration: underline;
    }

    /* Footer */
    footer {
      background: #2c3e50;
      color: white;
      text-align: center;
      padding: 20px 0;
      margin-top: 40px;
    }

    @media (max-width: 600px) {
      header h1 {
        font-size: 24px;
      }
    }
  </style>
</head>
<body>

  <!-- News Grid -->
  <div class="news-container">
    <div class="news-card">
      <div class="news-content">
        <h3 class="news-title">Incoming Update</h3>
        <p class="news-excerpt">Website update will be coming soon.</p>
        <!-- News grid -- > <a href="#" class="read-more">Read More →</a> -->
      </div>
    </div>

    <div class="news-card">
      <div class="news-content">
        <h3 class="news-title">Game Day (10/3/2025)</h3>
        <p class="news-excerpt">SJSU Spartans will be going against UCLA this friday.</p>
        <!--<a href="#" class="read-more">Read More →</a> -->   
      </div>
    </div>

  </div>

  <!-- Footer -->

</body>
</html>
