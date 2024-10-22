function validateFileType(input) {
    var file = input.files[0];
    if (file) {
        var fileType = file.type;
        if (fileType !== "application/pdf") {
            alert("Please upload a valid PDF file.");
            input.value = ''; // Reset file input
        }
    }
}
