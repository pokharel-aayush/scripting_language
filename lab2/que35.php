<?php
$message = "";

if (isset($_POST['submit'])) {
    // Sanitize filename to prevent directory traversal
    $filename = basename(trim($_POST['filename']));
    $action = $_POST['action'];
    $content = $_POST['content'] ?? '';
    $new_filename = basename(trim($_POST['new_filename'] ?? ''));
    
    if (empty($filename)) {
        $message = "<b>Error: Filename is required.</b>";
    } else {
        switch ($action) {
            // a. CHECK FILE
            case 'check':
                if (file_exists($filename)) {
                    $message = "<b>Result:</b> The file '$filename' exists.";
                } else {
                    $message = "<b>Result:</b> The file '$filename' does NOT exist.";
                }
                break;

            // b. OPEN FILE
            case 'open':
                $fp = @fopen($filename, 'a+');
                if ($fp) {
                    $message = "<b>Result:</b> File '$filename' opened successfully in 'a+' mode.";
                    fclose($fp); // e. CLOSE FILE (Automatic)
                } else {
                    $message = "<b>Error:</b> Could not open file '$filename'.";
                }
                break;

            // c. WRITE FILE
            case 'write':
                if (empty($content)) {
                    $message = "<b>Error:</b> Please enter text to write.";
                } else {
                    $fp = @fopen($filename, 'a'); // 'a' appends to the file
                    if ($fp) {
                        fwrite($fp, $content . "\n");
                        $message = "<b>Result:</b> Successfully wrote to '$filename'.";
                        fclose($fp); // e. CLOSE FILE (Automatic)
                    } else {
                        $message = "<b>Error:</b> Could not write to file.";
                    }
                }
                break;

            // d. READ FILE
            case 'read':
                if (file_exists($filename)) {
                    $fp = @fopen($filename, 'r');
                    if ($fp) {
                        $filesize = filesize($filename);
                        $filecontent = ($filesize > 0) ? fread($fp, $filesize) : "File is empty.";
                        $message = "<b>File Contents of '$filename':</b><br><textarea rows='5' cols='40' readonly>" . htmlspecialchars($filecontent) . "</textarea>";
                        fclose($fp); // e. CLOSE FILE (Automatic)
                    } else {
                        $message = "<b>Error:</b> Could not read file.";
                    }
                } else {
                    $message = "<b>Error:</b> File does not exist.";
                }
                break;

            // f. RENAME FILE
            case 'rename':
                if (empty($new_filename)) {
                    $message = "<b>Error:</b> Please enter a new filename.";
                } elseif (!file_exists($filename)) {
                    $message = "<b>Error:</b> Original file does not exist.";
                } else {
                    if (rename($filename, $new_filename)) {
                        $message = "<b>Result:</b> File renamed from '$filename' to '$new_filename'.";
                    } else {
                        $message = "<b>Error:</b> Could not rename file.";
                    }
                }
                break;

            // g. CHECK PERMISSIONS
            case 'check_perms':
                if (file_exists($filename)) {
                    $perms = fileperms($filename);
                    $readable_perms = substr(sprintf('%o', $perms), -4);
                    $message = "<b>Result:</b> Permissions for '$filename' are: $readable_perms";
                } else {
                    $message = "<b>Error:</b> File does not exist.";
                }
                break;

            // h. CHANGE PERMISSIONS
            case 'change_perms':
                if (file_exists($filename)) {
                    if (chmod($filename, 0777)) {
                        $new_perms = substr(sprintf('%o', fileperms($filename)), -4);
                        $message = "<b>Result:</b> Permissions changed. New permissions: $new_perms";
                    } else {
                        $message = "<b>Error:</b> Could not change permissions. (Note: May fail on Windows).";
                    }
                } else {
                    $message = "<b>Error:</b> File does not exist.";
                }
                break;
                
            default:
                $message = "<b>Error:</b> Invalid action selected.";
        }
    }
}
?>

<h3>File Handling Operations</h3>

<?php if (!empty($message)) echo $message . "<br><br>"; ?>

<!-- FORM -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <td><label>Filename (e.g., test.txt):</label></td>
            <td><input type="text" name="filename" value="test.txt" required></td>
        </tr>
        <tr>
            <td><label>Select Operation:</label></td>
            <td>
                <select name="action" required>
                    <option value="check">a. Check File</option>
                    <option value="open">b. Open File</option>
                    <option value="write">c. Write File</option>
                    <option value="read">d. Read File</option>
                    <option value="rename">e. Rename File</option>
                    <option value="check_perms">f. Check Permissions</option>
                    <option value="change_perms">g. Change Permissions</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><label>Text to Write (for option c):</label></td>
            <td><textarea name="content" rows="3" cols="30"></textarea></td>
        </tr>
        <tr>
            <td><label>New Filename (for option e):</label></td>
            <td><input type="text" name="new_filename"></td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="submit" name="submit" value="Perform Operation">
            </td>
        </tr>
    </table>
</form>