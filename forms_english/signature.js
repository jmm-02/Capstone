document.addEventListener("DOMContentLoaded", function() {
    // Get the canvas and buttons elements
    var canvas = document.getElementById("canvas");
    var clearBtn = document.getElementById("clearBtn");
    var saveBtn = document.getElementById("saveBtn");
    var ctx = canvas.getContext("2d");

    // Set initial drawing state
    var isDrawing = false;

    // Set drawing styles
    ctx.lineWidth = 2;
    ctx.strokeStyle = "#000";

    // Function to start drawing
    function startDrawing(e) {
        isDrawing = true;
        ctx.beginPath();
        ctx.moveTo(e.offsetX, e.offsetY);
    }

    // Function to draw
    function draw(e) {
        if (isDrawing) {
            ctx.lineTo(e.offsetX, e.offsetY);
            ctx.stroke();
        }
    }

    // Function to stop drawing
    function stopDrawing() {
        isDrawing = false;
    }

    // Function to clear the canvas
    function clearCanvas() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    }

    // Function to save the signature as an image
    function saveSignature() {
        var imgData = canvas.toDataURL();
        var link = document.createElement("a");
        link.href = imgData;
        link.download = "signature.png";
        link.click();
    }

    // Event listeners
    canvas.addEventListener("mousedown", startDrawing);
    canvas.addEventListener("mousemove", draw);
    canvas.addEventListener("mouseup", stopDrawing);
    canvas.addEventListener("mouseout", stopDrawing);

    clearBtn.addEventListener("click", clearCanvas);
    saveBtn.addEventListener("click", saveSignature);
});
