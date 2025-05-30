<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Country & Weather</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Open Sans', sans-serif; /* for body text */
      background: #F5F5F5;
      margin: 0; padding: 0;
      color: #2E2E2E;
    }
    header {
      font-family: 'Montserrat', sans-serif; /* headings */
      background: #2E2E2E;
      padding: 20px;
      text-align: center;
      box-shadow: 0 3px 12px rgba(0,0,0,0.2);
      position: relative;
      color: #FFFFFF;
      font-weight: 600;
    }
    header h1 {
      margin: 0;
      font-weight: 700;
      font-size: 2.4rem;
      letter-spacing: 2px;
    }

    /* Back button on the left */
    #backBtn {
      font-family: 'Montserrat', sans-serif;
      position: absolute;
      top: 20px;
      left: 20px;
      background: #4B4B4B;
      border: none;
      color: #FFFFFF;
      padding: 10px 16px;
      border-radius: 12px;
      cursor: pointer;
      font-weight: 700;
      font-size: 1rem;
      transition: background 0.3s ease;
      box-shadow: 0 3px 8px rgba(75, 75, 75, 0.6);
      letter-spacing: 0.8px;
    }
    #backBtn:hover {
      background: #666666;
      box-shadow: 0 5px 12px rgba(102, 102, 102, 0.8);
    }

    /* View Saved Countries button on the right */
    #viewSavedBtn {
      font-family: 'Montserrat', sans-serif;
      position: absolute;
      top: 20px;
      right: 20px;
      background: #4B4B4B;
      border: none;
      color: #FFFFFF;
      padding: 10px 16px;
      border-radius: 12px;
      cursor: pointer;
      font-weight: 700;
      font-size: 1rem;
      transition: background 0.3s ease;
      box-shadow: 0 3px 8px rgba(75, 75, 75, 0.6);
      letter-spacing: 0.8px;
    }
    #viewSavedBtn:hover {
      background: #666666;
      box-shadow: 0 5px 12px rgba(102, 102, 102, 0.8);
    }

    #searchContainer {
      margin: 30px auto;
      text-align: center;
    }
    #search {
      font-family: 'Open Sans', sans-serif;
      padding: 14px;
      width: 80%;
      max-width: 420px;
      border: 2px solid #A0A0A0;
      border-radius: 14px;
      font-size: 18px;
      transition: border-color 0.3s ease;
      outline-offset: 3px;
      background: #FFFFFF;
      color: #2E2E2E;
      font-weight: 600;
    }
    #search::placeholder {
      color: #A0A0A0;
      font-weight: 400;
    }
    #search:focus {
      border-color: #4B4B4B;
      outline: none;
      box-shadow: 0 0 10px #4B4B4Baa;
      background: #FFFFFF;
    }
    #searchBtn {
      font-family: 'Montserrat', sans-serif;
      padding: 14px 28px;
      margin-left: 14px;
      background: #4B4B4B;
      border: none;
      color: #FFFFFF;
      border-radius: 14px;
      cursor: pointer;
      font-weight: 700;
      font-size: 1.1rem;
      transition: background 0.3s ease, box-shadow 0.3s ease;
      box-shadow: 0 4px 12px rgba(75, 75, 75, 0.6);
      letter-spacing: 0.7px;
    }
    #searchBtn:hover {
      background: #666666;
      box-shadow: 0 6px 16px rgba(102, 102, 102, 0.8);
    }
    #results {
      display: flex;
      justify-content: center;
      padding: 28px 15px;
      flex-wrap: wrap;
      gap: 24px;
    }
    .country-card {
      font-family: 'Open Sans', sans-serif;
      background: #FFFFFF;
      border-radius: 20px;
      box-shadow: 0 8px 24px rgba(46, 46, 46, 0.1);
      padding: 22px;
      width: 270px;
      text-align: center;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      color: #2E2E2E;
      font-weight: 600;
    }
    .country-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 18px 40px rgba(46, 46, 46, 0.2);
    }
    .country-card h3 {
      font-family: 'Montserrat', sans-serif;
      color: #2E2E2E;
      margin-bottom: 14px;
      font-weight: 700;
      font-size: 22px;
      letter-spacing: 0.7px;
    }
    .country-card button.saveBtn {
      font-family: 'Montserrat', sans-serif;
      margin-top: 18px;
      padding: 12px 24px;
      background-color: #4B4B4B;
      border: none;
      color: #FFFFFF;
      border-radius: 16px;
      cursor: pointer;
      transition: background 0.3s ease, box-shadow 0.3s ease;
      font-weight: 700;
      font-size: 16px;
      box-shadow: 0 5px 15px rgba(75, 75, 75, 0.6);
      letter-spacing: 0.6px;
    }
    .country-card button.saveBtn:hover {
      background-color: #666666;
      box-shadow: 0 7px 20px rgba(102, 102, 102, 0.8);
    }
    /* Modal styles */
    #savedModal {
      font-family: 'Open Sans', sans-serif;
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0; top: 0;
      width: 100%; height: 100%;
      overflow: auto;
      background-color: rgba(46, 46, 46, 0.85);
      color: #FFFFFF;
    }
    #savedModalContent {
      background-color: #FFFFFF;
      margin: 10% auto;
      padding: 28px 36px;
      border-radius: 24px;
      width: 90%;
      max-width: 540px;
      box-shadow: 0 12px 40px rgba(46, 46, 46, 0.35);
      position: relative;
      color: #2E2E2E;
      font-weight: 600;
    }
    #closeSavedModal {
      font-family: 'Montserrat', sans-serif;
      color: #4B4B4B;
      position: absolute;
      top: 20px;
      right: 28px;
      font-size: 34px;
      font-weight: 700;
      cursor: pointer;
      transition: color 0.3s ease;
      letter-spacing: 0.8px;
    }
    #closeSavedModal:hover {
      color: #2E2E2E;
    }
    .saved-item {
      border-bottom: 1px solid #A0A0A0;
      padding: 16px 0;
    }
    .saved-item:last-child {
      border-bottom: none;
    }
    .saved-item h4 {
      font-family: 'Montserrat', sans-serif;
      margin: 0 0 10px 0;
      color: #2E2E2E;
      font-weight: 700;
      letter-spacing: 0.6px;
    }
  </style>
</head>

<body>
  <header>
    <button id="backBtn" onclick="window.location.href='startup.php'">Back</button>
    <h1>Weather Checker</h1>
    <button id="viewSavedBtn" onclick="window.location.href='view_saved_countries.php'">View Saved Countries</button>

    <p>Discover countries and their current weather!</p>
  </header>

  <div id="searchContainer">
    <input type="text" id="search" placeholder="Search for a country..." />
    <button id="searchBtn">Search</button>
  </div>

  <div id="results"></div>

  <!-- Save Confirmation Modal -->
  <div id="saveConfirmModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    background-color: rgba(0, 0, 0, 0.5); justify-content: center; align-items: center; z-index: 2000;">
    <div style="background: white; padding: 24px 32px; border-radius: 16px; text-align: center; max-width: 320px;">
      <p style="font-weight: 600; font-size: 18px; color: #2E2E2E;">Do you want to save this country?</p>
      <div style="margin-top: 20px;">
        <button id="saveYes" style="margin-right: 10px; background-color: #4B4B4B; color: white; padding: 10px 20px; border: none; border-radius: 10px; cursor: pointer; font-weight: bold;">Yes</button>
        <button id="saveNo" style="background-color: #AAAAAA; color: white; padding: 10px 20px; border: none; border-radius: 10px; cursor: pointer; font-weight: bold;">No</button>
      </div>
    </div>
  </div>

  <script src="js/main.js"></script>
</body>
</html>
