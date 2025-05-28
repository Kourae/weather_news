<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Country & Weather</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;500&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background: #e3f2fd;
      margin: 0; padding: 0;
    }
    header {
      background: #90caf9;
      padding: 20px;
      text-align: center;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      position: relative;
    }
    header h1 {
      margin: 0;
      color: #0d47a1;
    }
    #viewSavedBtn {
      position: absolute;
      top: 20px;
      right: 20px;
      background: #42a5f5;
      border: none;
      color: white;
      padding: 10px 15px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 500;
      transition: background 0.3s ease;
    }
    #viewSavedBtn:hover {
      background: #1e88e5;
    }
    #searchContainer {
      margin: 20px auto;
      text-align: center;
    }
    #search {
      padding: 10px;
      width: 80%;
      max-width: 400px;
      border: 2px solid #90caf9;
      border-radius: 10px;
      font-size: 16px;
    }
    #searchBtn {
      padding: 10px 20px;
      margin-left: 10px;
      background: #64b5f6;
      border: none;
      color: white;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 500;
      transition: background 0.3s ease;
    }
    #searchBtn:hover {
      background: #42a5f5;
    }
    #results {
      display: flex;
      justify-content: center;
      padding: 20px;
    }
    .country-card {
      background: white;
      border-radius: 15px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      padding: 15px;
      width: 250px;
      text-align: center;
      transition: transform 0.2s ease;
    }
    .country-card:hover {
      transform: scale(1.05);
    }
    .country-card h3 {
      color: #1976d2;
      margin-bottom: 10px;
    }
    .country-card button.saveBtn {
      margin-top: 10px;
      padding: 8px 12px;
      background-color: #64b5f6;
      border: none;
      color: white;
      border-radius: 8px;
      cursor: pointer;
      transition: background 0.3s ease;
      font-weight: 500;
    }
    .country-card button.saveBtn:hover {
      background-color: #42a5f5;
    }

    /* Modal styles */
    #savedModal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0; top: 0;
      width: 100%; height: 100%;
      overflow: auto;
      background-color: rgba(0,0,0,0.4);
      font-family: 'Roboto', sans-serif;
    }
    #savedModalContent {
      background-color: #fefefe;
      margin: 10% auto;
      padding: 20px;
      border-radius: 15px;
      width: 90%;
      max-width: 500px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.3);
      position: relative;
    }
    #closeSavedModal {
      color: #aaa;
      position: absolute;
      top: 15px;
      right: 20px;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
      transition: color 0.3s ease;
    }
    #closeSavedModal:hover {
      color: #000;
    }
    .saved-item {
      border-bottom: 1px solid #ddd;
      padding: 10px 0;
    }
    .saved-item:last-child {
      border-bottom: none;
    }
    .saved-item h4 {
      margin: 0 0 5px 0;
      color: #1976d2;
    }
  </style>
</head>
<body>
  <header>
    <h1>Weather Checker</h1>
    <button id="viewSavedBtn" title="View Saved Countries">View Saved</button>
    <p>Discover countries and their current weather!</p>
  </header>

  <div id="searchContainer">
    <input type="text" id="search" placeholder="Search for a country..." />
    <button id="searchBtn">Search</button>
  </div>

  <div id="results"></div>

  <!-- Saved countries modal -->
  <div id="savedModal">
    <div id="savedModalContent">
      <span id="closeSavedModal">&times;</span>
      <h2>Saved Countries</h2>
      <div id="savedList">Loading...</div>
    </div>
  </div>

  <script src="js/main.js"></script>
</body>
</html>
