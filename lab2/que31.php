<?php
session_start();

// Database Connection
$conn = new mysqli("localhost", "root", "", "lab_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";
$edit_data = null;
$current_page = htmlspecialchars($_SERVER['PHP_SELF']);

// Determine which table to manage (default: courses)
$table = isset($_GET['table']) ? $_GET['table'] : 'courses';
if (!in_array($table, ['courses', 'students'])) {
    $table = 'courses';
}

// Read session message
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

// --- 1. DELETE RECORD ---
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM $table WHERE id=$id");
    
    $_SESSION['message'] = "<b>Record deleted successfully from $table.</b>";
    header("Location: $current_page?table=$table");
    exit();
}

// --- 2. EDIT MODE (Fetch Data) ---
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $res = $conn->query("SELECT * FROM $table WHERE id=$id");
    if ($res && $res->num_rows > 0) {
        $edit_data = $res->fetch_assoc();
    }
}

// --- 3. CREATE / UPDATE RECORD ---
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $error_found = false;
    
    if ($table == 'courses') {
        $title = trim($_POST['title']);
        $duration = trim($_POST['duration']);
        $status = trim($_POST['status']);
        
        if (empty($title) || empty($duration) || empty($status)) {
            $_SESSION['message'] = "<b>Error: All fields are required.</b>";
            $error_found = true;
        } else {
            if (!empty($id)) {
                $sql = "UPDATE courses SET title=?, duration=?, status=?, updated_at=NOW() WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssi", $title, $duration, $status, $id);
                $stmt->execute();
                $_SESSION['message'] = "<b>Course updated successfully.</b>";
            } else {
                $sql = "INSERT INTO courses (title, duration, status, created_at) VALUES (?, ?, ?, NOW())";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $title, $duration, $status);
                $stmt->execute();
                $_SESSION['message'] = "<b>Course created successfully.</b>";
            }
            $stmt->close();
        }
    } else if ($table == 'students') {
        $name = trim($_POST['name']);
        
        if (empty($name)) {
            $_SESSION['message'] = "<b>Error: Name is required.</b>";
            $error_found = true;
        } else {
            if (!empty($id)) {
                $sql = "UPDATE students SET name=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $name, $id);
                $stmt->execute();
                $_SESSION['message'] = "<b>Student updated successfully.</b>";
            } else {
                $sql = "INSERT INTO students (name) VALUES (?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $name);
                $stmt->execute();
                $_SESSION['message'] = "<b>Student created successfully.</b>";
            }
            $stmt->close();
        }
    }
    
    if (!$error_found) {
        header("Location: $current_page?table=$table");
        exit();
    }
}
?>

<h3>CRUD Operations</h3>

<!-- Navigation Links -->
<a href="?table=courses">Manage Courses</a> | 
<a href="?table=students">Manage Students</a>

<br><br>
<?php if (!empty($message)) echo $message; ?>

<hr>

<!-- FORM (Create / Edit) -->
<h4><?php echo $edit_data ? "Edit" : "Add New"; ?> <?php echo ucfirst($table); ?></h4>
<form method="post" action="<?php echo $current_page; ?>?table=<?php echo $table; ?>">
    <input type="hidden" name="id" value="<?php echo $edit_data['id'] ?? ''; ?>">
    
    <?php if ($table == 'courses'): ?>
        <label>Title:</label><br>
        <input type="text" name="title" value="<?php echo htmlspecialchars($edit_data['title'] ?? ''); ?>" required><br><br>
        
        <label>Duration:</label><br>
        <input type="text" name="duration" value="<?php echo htmlspecialchars($edit_data['duration'] ?? ''); ?>" required><br><br>
        
        <label>Status:</label><br>
        <select name="status" required>
            <option value="Active" <?php if(($edit_data['status'] ?? '') == 'Active') echo 'selected'; ?>>Active</option>
            <option value="Inactive" <?php if(($edit_data['status'] ?? '') == 'Inactive') echo 'selected'; ?>>Inactive</option>
        </select><br><br>
        
    <?php elseif ($table == 'students'): ?>
        <label>Name:</label><br>
        <input type="text" name="name" value="<?php echo htmlspecialchars($edit_data['name'] ?? ''); ?>" required><br><br>
    <?php endif; ?>
    
    <input type="submit" name="submit" value="<?php echo $edit_data ? 'Update Record' : 'Create Record'; ?>">
    <?php if($edit_data) echo "<a href='$current_page?table=$table'>Cancel</a>"; ?>
</form>

<hr>

<!-- LIST / READ -->
<h3><?php echo ucfirst($table); ?> List</h3>
<table border="1" cellpadding="8" cellspacing="0">
    <?php if ($table == 'courses'): ?>
        <tr>
            <th>ID</th><th>Title</th><th>Duration</th><th>Status</th>
            <th>Created At</th><th>Updated At</th><th>Actions</th>
        </tr>
        <?php
        $result = $conn->query("SELECT * FROM courses ORDER BY id DESC");
        
        if ($result === false) {
            echo "<tr><td colspan='7'>Database Error: " . $conn->error . "</td></tr>";
        } elseif ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['id'] . "</td>
                        <td>" . htmlspecialchars($row['title']) . "</td>
                        <td>" . htmlspecialchars($row['duration']) . "</td>
                        <td>" . htmlspecialchars($row['status']) . "</td>
                        <td>" . $row['created_at'] . "</td>
                        <td>" . $row['updated_at'] . "</td>
                        <td>
                            <a href='$current_page?table=$table&edit=" . $row['id'] . "'>Edit</a> | 
                            <a href='$current_page?table=$table&delete=" . $row['id'] . "' onclick='return confirm(\"Are you sure?\");'>Delete</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No courses found.</td></tr>";
        }
        ?>
        
    <?php elseif ($table == 'students'): ?>
        <tr>
            <th>ID</th><th>Name</th><th>Actions</th>
        </tr>
        <?php
        $result = $conn->query("SELECT * FROM students ORDER BY id DESC");
        
        if ($result === false) {
            echo "<tr><td colspan='3'>Database Error: " . $conn->error . "</td></tr>";
        } elseif ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['id'] . "</td>
                        <td>" . htmlspecialchars($row['name']) . "</td>
                        <td>
                            <a href='$current_page?table=$table&edit=" . $row['id'] . "'>Edit</a> | 
                            <a href='$current_page?table=$table&delete=" . $row['id'] . "' onclick='return confirm(\"Are you sure?\");'>Delete</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No students found.</td></tr>";
        }
        ?>
    <?php endif; ?>
</table>

<?php $conn->close(); ?>