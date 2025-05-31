<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'weathernews_db';

// Connect to MySQL server (without selecting DB yet)
$conn = new mysqli($host, $user, $pass);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Create the database if it doesn't exist
$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");

// Select the database
$conn->select_db($dbname);

// Create the table if it doesn't exist
$createTableSQL = "CREATE TABLE IF NOT EXISTS saved_countries (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  capital VARCHAR(100),
  latlng VARCHAR(100)
)";
$conn->query($createTableSQL);

// Now fetch the data
$sql = "SELECT id, name, capital, latlng FROM saved_countries ORDER BY name ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Saved Countries</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Open Sans', sans-serif;
      background-color: #F5F5F5;
      margin: 0;
      padding: 24px 16px;
      color: #2E2E2E;
    }

    h2 {
      font-family: 'Montserrat', sans-serif;
      text-align: center;
      color: #2E2E2E;
      margin-bottom: 40px;
      font-weight: 700;
      font-size: 2.2rem;
      letter-spacing: 1.2px;
    }

    .back-btn {
      text-align: center;
      margin-bottom: 40px;
    }

    .back-btn a {
      font-family: 'Montserrat', sans-serif;
      text-decoration: none;
      background-color: #4B4B4B;
      color: #FFFFFF;
      padding: 12px 28px;
      border-radius: 14px;
      font-weight: 700;
      font-size: 1.1rem;
      transition: background-color 0.3s ease, box-shadow 0.3s ease;
      box-shadow: 0 4px 12px rgba(75, 75, 75, 0.6);
      letter-spacing: 0.8px;
      display: inline-block;
    }

    .back-btn a:hover {
      background-color: #666666;
      box-shadow: 0 6px 16px rgba(102, 102, 102, 0.8);
    }

    #countryContainer {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 20px;
      max-width: 600px;
      margin: 0 auto;
    }

    .country-card {
      background-color: #FFFFFF;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(46, 46, 46, 0.1);
      padding: 26px 30px;
      width: 100%;
      position: relative;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      font-weight: 600;
      color: #2E2E2E;
    }

    .country-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 18px 48px rgba(46, 46, 46, 0.2);
    }

    .country-card h3 {
      font-family: 'Montserrat', sans-serif;
      color: #2E2E2E;
      margin-top: 0;
      font-weight: 700;
      font-size: 1.6rem;
      letter-spacing: 0.7px;
      margin-bottom: 14px;
    }

    .country-card p {
      margin: 6px 0;
      color: #555555;
      font-size: 1rem;
      font-weight: 600;
    }

    button.deleteBtn {
      position: absolute;
      top: 18px;
      right: 18px;
      background-color: #B00020;
      border: none;
      color: white;
      padding: 8px 14px;
      border-radius: 14px;
      cursor: pointer;
      font-weight: 700;
      font-family: 'Montserrat', sans-serif;
      font-size: 0.95rem;
      transition: background-color 0.3s ease, box-shadow 0.3s ease;
      box-shadow: 0 4px 12px rgba(176, 0, 32, 0.6);
      letter-spacing: 0.6px;
    }

    button.deleteBtn:hover {
      background-color: #90001A;
      box-shadow: 0 6px 18px rgba(144, 0, 26, 0.8);
    }

    p.no-data {
      text-align: center;
      color: #777777;
      font-style: italic;
      font-size: 1.1rem;
      font-weight: 600;
    }

    /* Modal Styles */
    .modal-overlay {
      display: none;
      position: fixed;
      z-index: 999;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background-color: rgba(0,0,0,0.5);
      justify-content: center;
      align-items: center;
    }

    .modal-box {
      background: #fff;
      padding: 24px 32px;
      border-radius: 16px;
      text-align: center;
      max-width: 400px;
      width: 90%;
      box-shadow: 0 10px 30px rgba(0,0,0,0.3);
      animation: fadeIn 0.25s ease;
    }

    .modal-buttons {
      margin-top: 20px;
      display: flex;
      justify-content: space-around;
    }

    .btn {
      padding: 10px 20px;
      font-weight: bold;
      border-radius: 8px;
      cursor: pointer;
      border: none;
      font-family: 'Montserrat', sans-serif;
      transition: 0.3s ease;
    }

    .btn-danger {
      background: #B00020;
      color: white;
    }

    .btn-danger:hover {
      background: #90001A;
    }

    .btn-secondary {
      background: #ccc;
      color: #2E2E2E;
    }

    .btn-secondary:hover {
      background: #aaa;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>

  <h2>Saved Countries</h2>
  <div class="back-btn">
        <a href="index.php">← Back to search</a>

  </div>

  <div id="countryContainer">
    <?php
    if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "<div class='country-card' data-id='{$row['id']}'>";
        echo "<button class='deleteBtn'>Delete</button>";
        echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
        echo "<p><strong>Capital:</strong> " . htmlspecialchars($row['capital']) . "</p>";
        echo "<p><strong>Coordinates:</strong> " . htmlspecialchars($row['latlng']) . "</p>";
        echo "</div>";
      }
    } else {
      echo "<p class='no-data'>No saved countries found.</p>";
    }
    $conn->close();
    ?>
  </div>

  <!-- Delete Confirmation Modal -->
  <div id="deleteConfirmModal" class="modal-overlay">
    <div class="modal-box">
      <h3>Are you sure you want to delete this country?</h3>
      <div class="modal-buttons">
        <button id="confirmYes" class="btn btn-danger">Yes</button>
        <button id="confirmNo" class="btn btn-secondary">No</button>
        
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const container = document.getElementById('countryContainer');
      const modal = document.getElementById('deleteConfirmModal');
      const confirmYes = document.getElementById('confirmYes');
      const confirmNo = document.getElementById('confirmNo');
      let countryCardToDelete = null;

      container.addEventListener('click', (e) => {
        if (e.target.classList.contains('deleteBtn')) {
          countryCardToDelete = e.target.closest('.country-card');
          modal.style.display = 'flex';
        }
      });

      confirmYes.addEventListener('click', async () => {
        if (!countryCardToDelete) return;
        const id = countryCardToDelete.getAttribute('data-id');

        try {
          const res = await fetch('delete_country.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: Number(id) })
          });

          const result = await res.json();
          alert(result.message);
          if (result.success) countryCardToDelete.remove();
        } catch (err) {
          alert('Error deleting country.');
        } finally {
          modal.style.display = 'none';
          countryCardToDelete = null;
        }
      });

      confirmNo.addEventListener('click', () => {
        modal.style.display = 'none';
        countryCardToDelete = null;
      });
    });
  </script>

</body>
</html>
