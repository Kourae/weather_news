<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Weather Checker</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    /* Reset & base */
    * {
      box-sizing: border-box;
    }
    body, html {
      margin: 0; padding: 0; height: 100%;
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #2c2c2c 0%, #4a4a4a 100%);
      display: flex;
      justify-content: center;
      align-items: center;
      cursor: pointer;
      color: #ddd;
      user-select: none;
      transition: opacity 0.5s ease;
    }
    #container {
      text-align: center;
      background: rgba(100, 100, 100, 0.3); /* translucent gray */
      padding: 3rem 4rem;
      border-radius: 20px;
      box-shadow: 0 20px 50px rgba(0,0,0,0.5);
      backdrop-filter: blur(10px);
      max-width: 400px;
      width: 90%;
      color: #eee;
    }
    h1 {
      font-weight: 700;
      font-size: 3rem;
      margin-bottom: 0.3rem;
      text-shadow: 0 2px 5px rgba(0,0,0,0.7);
    }
    p {
      font-weight: 400;
      font-size: 1.25rem;
      letter-spacing: 0.05em;
      opacity: 0.85;
      color: #ccc;
    }
    body.fade-out {
      opacity: 0;
      pointer-events: none;
    }
  </style>
</head>
<body>
  <div id="container">
    <h1>Weather Checker</h1>
    <p>Click anywhere or press Enter to continue</p>
  </div>

  <script>
    const continueToApp = () => {
      document.body.classList.add('fade-out');
      setTimeout(() => window.location.href = "index.php", 500);
    };
    document.addEventListener('click', continueToApp);
    document.addEventListener('keydown', e => {
      if (e.key === 'Enter') continueToApp();
    });
  </script>
</body>
</html>
