<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XKCD Archive Search & Browse</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .search-box {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .search-box input {
            width: 300px;
            padding: 10px;
            margin: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .search-box button {
            padding: 10px 20px;
            margin: 5px;
            background-color: #007cba;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .search-box button:hover {
            background-color: #005a87;
        }
        .comic-result {
            border: 1px solid #ddd;
            margin: 10px 0;
            padding: 15px;
            border-radius: 5px;
            background-color: #fff;
        }
        .comic-result img {
            max-width: 300px;
            max-height: 200px;
            float: left;
            margin-right: 15px;
        }
        .comic-info {
            overflow: hidden;
        }
        .comic-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .comic-meta {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .comic-alt {
            font-style: italic;
            margin-bottom: 10px;
        }
        .comic-links a {
            margin-right: 15px;
            color: #007cba;
            text-decoration: none;
        }
        .comic-links a:hover {
            text-decoration: underline;
        }
        .loading {
            text-align: center;
            padding: 20px;
            font-style: italic;
        }
        .error {
            color: red;
            padding: 10px;
            background-color: #ffe6e6;
            border-radius: 4px;
            margin: 10px 0;
        }
        .clear {
            clear: both;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 XKCD Archive Search & Browse</h1>
        
        <div class="search-box">
            <h3>Search Comics</h3>
            <input type="number" id="comicNumber" placeholder="Comic Number (e.g., 353)" min="1" />
            <input type="text" id="searchKeyword" placeholder="Search by keyword" />
            <br>
            <button onclick="searchByNumber()">Get Comic by Number</button>
            <button onclick="getRandomComic()">Random Comic</button>
            <button onclick="getLatestComic()">Latest Comic</button>
            <button onclick="clearResults()">Clear Results</button>
        </div>

        <div id="results"></div>
    </div>

    <script>
        function displayComic(comic) {
            const resultsDiv = document.getElementById('results');
            
            const comicDiv = document.createElement('div');
            comicDiv.className = 'comic-result';
            
            comicDiv.innerHTML = `
                <img src="${comic.img}" alt="${comic.alt}" />
                <div class="comic-info">
                    <div class="comic-title">${comic.title}</div>
                    <div class="comic-meta">Comic #${comic.num} - ${comic.month}/${comic.day}/${comic.year}</div>
                    <div class="comic-alt">"${comic.alt}"</div>
                    <div class="comic-links">
                        <a href="https://xkcd.com/${comic.num}/" target="_blank">View on XKCD</a>
                        <a href="https://www.explainxkcd.com/wiki/index.php/${comic.num}" target="_blank">Explain This Comic</a>
                    </div>
                </div>
                <div class="clear"></div>
            `;
            
            resultsDiv.appendChild(comicDiv);
        }

        function showLoading() {
            const resultsDiv = document.getElementById('results');
            resultsDiv.innerHTML = '<div class="loading">Loading comic...</div>';
        }

        function showError(message) {
            const resultsDiv = document.getElementById('results');
            resultsDiv.innerHTML = `<div class="error">Error: ${message}</div>`;
        }

        function searchByNumber() {
            const comicNumber = document.getElementById('comicNumber').value;
            if (!comicNumber) {
                showError('Please enter a comic number');
                return;
            }

            showLoading();
            
            fetch(`https://xkcd.com/${comicNumber}/info.0.json`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Comic not found');
                    }
                    return response.json();
                })
                .then(comic => {
                    clearResults();
                    displayComic(comic);
                })
                .catch(error => {
                    showError('Comic not found or network error');
                });
        }

        function getRandomComic() {
            showLoading();
            
            // First get the latest comic to know the range
            fetch('https://xkcd.com/info.0.json')
                .then(response => response.json())
                .then(latestComic => {
                    const randomNum = Math.floor(Math.random() * latestComic.num) + 1;
                    return fetch(`https://xkcd.com/${randomNum}/info.0.json`);
                })
                .then(response => response.json())
                .then(comic => {
                    clearResults();
                    displayComic(comic);
                })
                .catch(error => {
                    showError('Error fetching random comic');
                });
        }

        function getLatestComic() {
            showLoading();
            
            fetch('https://xkcd.com/info.0.json')
                .then(response => response.json())
                .then(comic => {
                    clearResults();
                    displayComic(comic);
                })
                .catch(error => {
                    showError('Error fetching latest comic');
                });
        }

        function clearResults() {
            document.getElementById('results').innerHTML = '';
        }

        // Load the latest comic on page load
        window.onload = function() {
            getLatestComic();
        };
    </script>
</body>
</html>

