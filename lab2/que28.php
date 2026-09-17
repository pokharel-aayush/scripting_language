<!-- Form to upload profile image (PNG/JPEG, max 500KB) -->
<form method="post" enctype="multipart/form-data">
    Upload Image (PNG/JPEG, Max 500KB): <input type="file" name="image" required>
    <input type="submit" name="submit" value="Upload">
</form>

<?php
// Check if form is submitted
if (isset($_POST['submit'])) {
    
    // Get file details from $_FILES array
    $file = $_FILES['image'];
    $fileName = $file['name'];
    $fileSize = $file['size'];
    $fileTmp = $file['tmp_name'];
    
    // Get file extension in lowercase
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
    // Allowed file types and max size (500 KB)
    $allowed = array("png", "jpeg", "jpg");
    $maxSize = 500 * 1024; // 500 KB in bytes
    
    // Validate file extension
    if (!in_array($fileExt, $allowed)) {
        echo "Error: Only PNG and JPEG files are allowed.";
    } 
    // Validate file size
    elseif ($fileSize > $maxSize) {
        echo "Error: File size must be less than 500 KB.";
    } 
    // If all checks pass, move file to profiles folder
    else {
        move_uploaded_file($fileTmp, "profiles/" . $fileName);
        echo "Profile image uploaded successfully!";
    }
}
?>