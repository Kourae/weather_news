document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.getElementById('search');
  const searchBtn = document.getElementById('searchBtn');
  const resultsDiv = document.getElementById('results');
  const viewSavedBtn = document.getElementById('viewSavedBtn');
  const savedModal = document.getElementById('savedModal');
  const closeSavedModal = document.getElementById('closeSavedModal');
  const savedList = document.getElementById('savedList');

  async function searchCountries() {
    const query = searchInput.value.trim();
    if (!query) return alert('Please enter a country name.');

    resultsDiv.innerHTML = '<p>Loading...</p>';

    try {
      const res = await fetch(`https://restcountries.com/v3.1/name/${encodeURIComponent(query)}`);
      if (!res.ok) throw new Error('Country not found');
      const countries = await res.json();

      resultsDiv.innerHTML = '';

      // Only first matched country
      const country = countries[0];
      const countryName = country.name.common;
      const capital = country.capital ? country.capital[0] : 'N/A';
      const latlng = country.capitalInfo?.latlng || country.latlng || null;

      let weatherHTML = '<p>Weather data not available</p>';
      if (latlng) {
        try {
          const weatherRes = await fetch(`https://api.open-meteo.com/v1/forecast?latitude=${latlng[0]}&longitude=${latlng[1]}&current_weather=true`);
          const weatherData = await weatherRes.json();
          if (weatherData.current_weather) {
            const temp = weatherData.current_weather.temperature;
            const windspeed = weatherData.current_weather.windspeed;
            weatherHTML = `<p>Temp: ${temp}°C | Wind: ${windspeed} km/h</p>`;
          }
        } catch {
          weatherHTML = '<p>Weather data unavailable</p>';
        }
      }

      const card = document.createElement('div');
      card.className = 'country-card';
      card.innerHTML = `
        <h3>${countryName}</h3>
        <p><strong>Capital:</strong> ${capital}</p>
        ${weatherHTML}
        <button class="saveBtn">Save</button>
      `;

      card.querySelector('.saveBtn').addEventListener('click', () => {
        saveCountry({ name: countryName, capital, latlng: JSON.stringify(latlng) });
      });

      resultsDiv.appendChild(card);

    } catch (err) {
      resultsDiv.innerHTML = `<p>${err.message}</p>`;
    }
  }

  async function saveCountry(countryData) {
    try {
      const res = await fetch('save_country.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(countryData)
      });
      const result = await res.json();
      alert(result.message);
    } catch {
      alert('Error saving country.');
    }
  }

  async function viewSavedCountries() {
    savedList.innerHTML = '<p>Loading saved countries...</p>';
    savedModal.style.display = 'block';

    try {
      const res = await fetch('view_saved.php');
      const savedCountries = await res.json();

      if (!savedCountries.length) {
        savedList.innerHTML = '<p>No saved countries yet.</p>';
        return;
      }

      savedList.innerHTML = '';
      savedCountries.forEach(country => {
        const div = document.createElement('div');
        div.className = 'saved-item';
        div.innerHTML = `
          <h4>${country.name}</h4>
          <p><strong>Capital:</strong> ${country.capital}</p>
          <p><strong>Coordinates:</strong> ${country.latlng}</p>
        `;
        savedList.appendChild(div);
      });
    } catch {
      savedList.innerHTML = '<p>Failed to load saved countries.</p>';
    }
  }

  searchBtn.addEventListener('click', searchCountries);
  searchInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') searchCountries();
  });

  viewSavedBtn.addEventListener('click', viewSavedCountries);

  closeSavedModal.addEventListener('click', () => {
    savedModal.style.display = 'none';
  });

  window.addEventListener('click', (e) => {
    if (e.target === savedModal) {
      savedModal.style.display = 'none';
    }
  });
});
