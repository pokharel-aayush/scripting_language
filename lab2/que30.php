<?php
// Database Connection
$conn = new mysqli("localhost", "root", "", "lab_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure uploads directory exists
if (!is_dir('uploads')) {
    mkdir('uploads', 0777, true);
}

$message = "";
$edit_data = null;
$current_page = htmlspecialchars($_SERVER['PHP_SELF']); // Gets the current file name dynamically

// --- 1. DELETE RECORD ---
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    $res = $conn->query("SELECT image FROM staff WHERE id=$id");
    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        if (!empty($row['image']) && file_exists("uploads/" . $row['image'])) {
            unlink("uploads/" . $row['image']);
        }
    }
    
    $conn->query("DELETE FROM staff WHERE id=$id");
    $message = "<span style='color:red;'>Record deleted successfully.</span>";
}

// --- 2. EDIT MODE (Fetch Data) ---
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $res = $conn->query("SELECT * FROM staff WHERE id=$id");
    if ($res->num_rows > 0) {
        $edit_data = $res->fetch_assoc();
    }
}

// --- 3. CREATE / UPDATE RECORD ---
if (isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $rank = trim($_POST['rank']);
    $status = trim($_POST['status']);
    $id = $_POST['id'];
    
    if (empty($name) || empty($rank) || empty($status)) {
        $message = "<span style='color:red;'>Error: Name, Rank, and Status are required.</span>";
    } else {
        $image_name = $_POST['old_image'] ?? "";
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, $allowed)) {
                $image_name = time() . "_" . basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image_name);
            } else {
                $message = "<span style='color:red;'>Error: Invalid image format.</span>";
            }
        }

        if (empty($message)) {
            if (!empty($id)) {
                $sql = "UPDATE staff SET name=?, rank=?, status=?, image=?, updated_by='admin', updated_at=NOW() WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssi", $name, $rank, $status, $image_name, $id);
                $stmt->execute();
                $message = "<span style='color:green;'>Record updated successfully.</span>";
            } else {
                $sql = "INSERT INTO staff (name, rank, status, image, created_by, created_at) VALUES (?, ?, ?, ?, 'admin', NOW())";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssss", $name, $rank, $status, $image_name);
                $stmt->execute();
                $message = "<span style='color:green;'>Record created successfully.</span>";
            }
            $stmt->close();
        }
    }
}
?>

<h3>Manage Staff Records</h3>
<?php echo $message; ?>

<!-- FORM (Create / Edit) -->
<!-- Notice the action here is now dynamic -->
<form method="post" enctype="multipart/form-data" action="<?php echo $current_page; ?>">
    <input type="hidden" name="id" value="<?php echo $edit_data['id'] ?? ''; ?>">
    <input type="hidden" name="old_image" value="<?php echo $edit_data['image'] ?? ''; ?>">
    
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <td><label>Name:</label></td>
            <td><input type="text" name="name" value="<?php echo $edit_data['name'] ?? ''; ?>" required></td>
        </tr>
        <tr>
            <td><label>Rank:</label></td>
            <td><input type="text" name="rank" value="<?php echo $edit_data['rank'] ?? ''; ?>" required></td>
        </tr>
        <tr>
            <td><label>Status:</label></td>
            <td>
                <select name="status" required>
                    <option value="Active" <?php if(($edit_data['status'] ?? '') == 'Active') echo 'selected'; ?>>Active</option>
                    <option value="Inactive" <?php if(($edit_data['status'] ?? '') == 'Inactive') echo 'selected'; ?>>Inactive</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><label>Image:</label></td>
            <td>
                <input type="file" name="image">
                <?php if(!empty($edit_data['image'])) echo "<br><small>Current: " . $edit_data['image'] . "</small>"; ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="submit" name="submit" value="<?php echo $edit_data ? 'Update Record' : 'Create Record'; ?>">
                <!-- Cancel link is now dynamic -->
                <?php if($edit_data) echo "<a href='$current_page'>Cancel</a>"; ?>
            </td>
        </tr>
    </table>
</form>

<br>

<!-- LIST / READ -->
<h3>Record List</h3>
<table border="1" cellpadding="8" cellspacing="0" style="width:100%; text-align:center;">
    <tr style="background-color:#f2f2f2;">
        <th>ID</th><th>Name</th><th>Rank</th><th>Status</th><th>Image</th>
        <th>Created By</th><th>Updated By</th><th>Created At</th><th>Updated At</th><th>Actions</th>
    </tr>
    <?php
    $result = $conn->query("SELECT * FROM staff ORDER BY id DESC");
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['rank'] . "</td>
                    <td>" . $row['status'] . "</td>
                    <td>";
            if (!empty($row['image'])) {
                echo "<img src='uploads/" . $row['image'] . "' width='50' height='50'>";
            } else {
                echo "No Image";
            }
            echo "</td>
                    <td>" . $row['created_by'] . "</td>
                    <td>" . $row['updated_by'] . "</td>
                    <td>" . $row['created_at'] . "</td>
                    <td>" . $row['updated_at'] . "</td>
                    <td>
                        <!-- Links are now dynamic -->
                        <a href='$current_page?edit=" . $row['id'] . "'>Edit</a> | 
                        <a href='$current_page?delete=" . $row['id'] . "' onclick='return confirm(\"Are you sure?\");'>Delete</a>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='10'>No records found.</td></tr>";
    }
    $conn->close();
    ?>
</table>