<?php include 'protect.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Score Submitted</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #ffffff;
      color: #000;
      text-align: center;
      padding: 60px 20px;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .success-container {
      max-width: 600px;
      margin: 0 auto;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 5px 25px rgba(0,0,0,0.08);
    }
    .success-icon {
      font-size: 5rem;
      color: #28a745;
      margin: 20px 0;
      animation: pulse 1.5s infinite;
    }
    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.1); }
      100% { transform: scale(1); }
    }
    .btn-red {
      background-color: #ff3131;
      border: 2px solid #ff3131;
      color: #fff;
      border-radius: 8px;
      padding: 12px 35px;
      font-weight: 700;
      text-decoration: none;
      display: inline-block;
      margin-top: 25px;
      font-size: 1.1rem;
      transition: all 0.3s;
    }
    .btn-red:hover {
      background-color: white !important;
      color: #ff3131 !important;
      border: 2px solid #ff3131 !important; /* Changed to red border */
    }
    footer {
      margin-top: 60px;
      padding: 25px;
      font-size: 0.9rem;
      color: #777;
      text-align: center;
    }
    .support-info {
      font-size: 0.85rem;
      margin-top: 10px;
      color: #555;
      line-height: 1.5;
    }
    @media (max-width: 768px) {
      .success-container {
        padding: 20px;
      }
      .success-icon {
        font-size: 4rem;
      }
      h1 {
        font-size: 2rem !important;
      }
    }
  </style>
</head>
<body>
  <div class="success-container">
    <img src="../logo.png" alt="SRWTC Logo" style="height: 120px; margin-bottom: 25px;">
    <div class="success-icon">✅</div>
    <h1 class="mb-4 fw-bold" style="font-size: 2.5rem;">SCORES SUBMITTED SUCCESSFULLY!</h1>
    <p class="lead mb-4">All scores have been successfully recorded in the system.</p>
    <a href="index.php" class="btn-red">SUBMIT MORE SCORES</a>
  </div>
  
  <footer>
    <div class="fw-bold" style="color: #ff3131;">© SRWTC GYMNASTICS SCORING SYSTEM</div>
    <div class="support-info">
      Designed and maintained by Freddie Mullen<br>
      For support or enquiries, please contact:<br>
      E: support@srwtc.co.uk<br>
      M: 07796 184248<br>
      Interested in a similar system for your club or region? Contact Freddie
    </div>
  </footer>
</body>
</html>