<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Build Your Own XKCD Story</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        #canvas {
            border: 2px solid #000;
            cursor: crosshair;
        }
        .panel {
            display: inline-block;
            margin: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            cursor: pointer;
        }
        .panel img {
            max-width: 100px;
            max-height: 100px;
        }
        .controls {
            margin: 20px 0;
        }
        button {
            margin: 5px;
            padding: 10px 15px;
            font-size: 14px;
        }
        #textInput {
            width: 300px;
            margin: 5px;
        }
    </style>
</head>
<body>
    <h1>🎨 Build Your Own XKCD Story</h1>
    <p>Create your own comic by adding text and simple shapes to the canvas!</p>

    <div class="controls">
        <input type="text" id="textInput" placeholder="Enter text to add to comic" />
        <button onclick="addText()">Add Text</button>
        <button onclick="clearCanvas()">Clear Canvas</button>
        <button onclick="saveComic()">Save Comic</button>
    </div>

    <canvas id="canvas" width="800" height="600"></canvas>

    <div id="message" style="margin-top: 20px; font-weight: bold;"></div>

    <script>
        const canvas = document.getElementById('canvas');
        const ctx = canvas.getContext('2d');
        let isDrawing = false;
        let currentTool = 'text';

        // Set up canvas background
        ctx.fillStyle = 'white';
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        // Add click event for adding text
        canvas.addEventListener('click', function(e) {
            if (currentTool === 'text') {
                const rect = canvas.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                const text = document.getElementById('textInput').value;
                if (text) {
                    ctx.font = '16px Arial';
                    ctx.fillStyle = 'black';
                    ctx.fillText(text, x, y);
                }
            }
        });

        // Drawing functionality
        canvas.addEventListener('mousedown', function(e) {
            if (currentTool === 'draw') {
                isDrawing = true;
                const rect = canvas.getBoundingClientRect();
                ctx.beginPath();
                ctx.moveTo(e.clientX - rect.left, e.clientY - rect.top);
            }
        });

        canvas.addEventListener('mousemove', function(e) {
            if (isDrawing && currentTool === 'draw') {
                const rect = canvas.getBoundingClientRect();
                ctx.lineTo(e.clientX - rect.left, e.clientY - rect.top);
                ctx.stroke();
            }
        });

        canvas.addEventListener('mouseup', function() {
            isDrawing = false;
        });

        function addText() {
            currentTool = 'text';
            document.getElementById('message').innerHTML = 'Click on the canvas to add text at that position.';
        }

        function enableDraw() {
            currentTool = 'draw';
            document.getElementById('message').innerHTML = 'Click and drag to draw on the canvas.';
        }

        function clearCanvas() {
            ctx.fillStyle = 'white';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            document.getElementById('message').innerHTML = 'Canvas cleared!';
        }

        function saveComic() {
            const dataURL = canvas.toDataURL('image/png');
            
            // Send to PHP backend for saving
            fetch('save_comic.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    imageData: dataURL
                })
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('message').innerHTML = data;
            })
            .catch(error => {
                document.getElementById('message').innerHTML = 'Error saving comic: ' + error;
            });
        }
    </script>

    <div class="controls">
        <button onclick="enableDraw()">Enable Drawing</button>
        <button onclick="addText()">Enable Text Mode</button>
    </div>

    <h3>Instructions:</h3>
    <ul>
        <li>Click "Enable Text Mode" and then click anywhere on the canvas to add text</li>
        <li>Click "Enable Drawing" and then click and drag to draw simple lines</li>
        <li>Use "Clear Canvas" to start over</li>
        <li>Click "Save Comic" to save your creation</li>
    </ul>
</body>
</html>

