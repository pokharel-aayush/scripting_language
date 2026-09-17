<!-- Form to upload CV (PDF/DOC, max 1MB) -->
<form method="post" enctype="multipart/form-data">
    Upload CV (PDF/DOC, Max 1MB): <input type="file" name="cv" required>
    <input type="submit" name="submit" value="Upload">
</form>

<?php
// Check if form is submitted
if (isset($_POST['submit'])) {
    
    // Get file details from $_FILES array
    $file = $_FILES['cv'];
    $fileName = $file['name'];
    $fileSize = $file['size'];
    $fileTmp = $file['tmp_name'];
    
    // Get file extension in lowercase
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
    // Allowed file types and max size (1 MB)
    $allowed = array("pdf", "doc", "docx");
    $maxSize = 1 * 1024 * 1024; // 1 MB in bytes
    
    // Validate file extension
    if (!in_array($fileExt, $allowed)) {
        echo "Error: Only PDF and DOC/DOCX files are allowed.";
    } 
    // Validate file size
    elseif ($fileSize > $maxSize) {
        echo "Error: File size must be less than 1 MB.";
    } 
    // If all checks pass, move file to uploads folder
    else {
        move_uploaded_file($fileTmp, "uploads/" . $fileName);
        echo "CV uploaded successfully!";
    }
}
?>