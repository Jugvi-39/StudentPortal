<?php
session_start();

$title_name = "Admin Dashboard";
$config = include("../private/config/database.php");

require "../private/includes/databaseconnection.php";
require "../private/student/student.class.php";

$student = new Student($config);

$admin_logged_in = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;

if (!$admin_logged_in) {
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['admin_login'])) {
        $admin_username = $_POST['admin_username'];
        $admin_password = $_POST['admin_password'];
        if ($admin_username === 'admin' && $admin_password === 'admin') {
            $_SESSION['admin_logged_in'] = true;
            $admin_logged_in = true;
        } else {
            echo "<div class='alert alert-danger'>Invalid admin credentials</div>";
        }
    }
}

if (!$admin_logged_in) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Login</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <style>
            body {
                background: #f8f9fa;
                min-height: 100vh;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }
            .feature-icon {
                width: 80px;
                height: 80px;
                background: #1a237e;
                color: white;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.5rem;
                margin: 0 auto 1rem;
            }
            .btn-primary-custom {
                background: #1a237e;
                border: none;
                color: white;
                padding: 12px 30px;
                border-radius: 8px;
                font-weight: 600;
                text-decoration: none;
                display: inline-block;
                transition: all 0.3s ease;
            }
            .btn-primary-custom:hover {
                background: #111a5c;
                color: white;
            }
        </style>
    </head>
    <body>
    <?php
    ?>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card p-4" style="border-color:#ff6f00;">
                    <div class="text-center mb-3">
                        <i class="fas fa-user-shield fa-3x mb-2 feature-icon"></i>
                        <h3 class="fw-bold" style="color:#1a237e;">Admin Login</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="admin_username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="admin_username" name="admin_username" required>
                            </div>
                            <div class="mb-3">
                                <label for="admin_password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="admin_password" name="admin_password" required>
                            </div>
                            <button type="submit" name="admin_login" class="btn btn-primary-custom w-100">Login</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="welcome.php" class="text-muted">
                                <i class="fas fa-arrow-left me-2"></i>Back to Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
    <?php
    exit();
}

include('includes/header.php');

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $result = $student->deleteStudent($delete_id);
    if ($result) {
        echo "<div class='alert alert-success'>Student deleted successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Failed to delete student</div>";
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['update_student'])) {
    $student_id = $_POST['student_id'];
    $student_name = $_POST['student_name'];
    $email = $_POST['email'];
    $program = $_POST['program'];
    $contact = $_POST['contact'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];

    $errors = array();
    if (empty($student_name)) {
        $errors[] = "Name is required";
    }
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    if (empty($program)) {
        $errors[] = "Program is required";
    }
    if (empty($contact)) {
        $errors[] = "Contact is required";
    }
    if (empty($gender)) {
        $errors[] = "Gender is required";
    }
    if (empty($address)) {
        $errors[] = "Address is required";
    }
    if (empty($errors)) {
        $result = $student->updateStudentProfile($student_id, $student_name, $email, $program, $gender, $contact, $address);
        if ($result) {
            echo "<div class='alert alert-success'>Student updated successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Failed to update student</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>";
        foreach ($errors as $error) {
            echo "<p>" . $error . "</p>";
        }
        echo "</div>";
    }
}

$all_students = $student->fetchAllStudents();
$students = array();
if ($all_students) {
    while ($row = $all_students->fetch(PDO::FETCH_ASSOC)) {
        $students[] = $row;
    }
}

$display_students = $students;
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_term = $_GET['search'];
    $search_results = $student->searchStudents($search_term);
    if ($search_results !== false && is_array($search_results)) {
        $display_students = $search_results;
    }
}
?>

<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="dashboard-card card mb-4 p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="fw-bold" style="color:#1a237e;">Student Management</h3>
                    <a href="logout.php" class="btn btn-secondary-custom">Logout</a>
                </div>
                <!-- Search Form -->
                <form method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="search" 
                                   placeholder="Search by Student ID, Name, Email, or Contact" 
                                   value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary-custom">
                                <i class="fas fa-search"></i> Search
                            </button>
                            <a href="admin.php" class="btn btn-secondary-custom">
                                <i class="fas fa-times"></i> Clear
                            </a>
                        </div>
                    </div>
                </form>
                <!-- Students Table -->
                <div class="table-responsive">
                    <table class="table table-striped" id="studentsTable">
                        <thead style="background:#1a237e; color:#fff;">
                            <tr>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Program</th>
                                <th>Contact</th>
                                <th>Gender</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($display_students)): ?>
                                <tr>
                                    <td colspan="7" class="text-center">No students found</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($display_students as $student_data): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($student_data['st_id']); ?></td>
                                        <td><?php echo htmlspecialchars($student_data['name']); ?></td>
                                        <td><?php echo htmlspecialchars($student_data['email']); ?></td>
                                        <td><?php echo htmlspecialchars($student_data['program']); ?></td>
                                        <td><?php echo htmlspecialchars($student_data['contact']); ?></td>
                                        <td><?php echo htmlspecialchars($student_data['gender']); ?></td>
                                        <td>
                                            <button type="button" 
                                                    class="btn btn-orange btn-sm me-1" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editModal"
                                                    onclick="loadStudentData('<?php echo addslashes($student_data['st_id']); ?>', '<?php echo addslashes($student_data['name']); ?>', '<?php echo addslashes($student_data['email']); ?>', '<?php echo $student_data['program']; ?>', '<?php echo $student_data['gender']; ?>', '<?php echo addslashes($student_data['contact']); ?>', '<?php echo addslashes($student_data['address']); ?>', '<?php echo $student_data['bday']; ?>')">
                                                Edit
                                            </button>
                                            <a href="admin.php?delete=<?php echo $student_data['st_id']; ?>" 
                                               class="btn btn-danger btn-sm" 
                                               onclick="return confirm('Are you sure you want to delete this student?')">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    <p><strong>Total Students:</strong> <?php echo count($display_students); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Student Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="" onsubmit="return validateEditForm()">
                    <input type="hidden" name="student_id" id="edit_student_id" value="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="display_student_id">Student ID</label>
                                <input type="text" class="form-control" id="display_student_id" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="edit_student_name">Full Name *</label>
                                <input type="text" class="form-control" id="edit_student_name" name="student_name" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="edit_email">Email *</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="edit_program">Program *</label>
                                <select class="form-control" id="edit_program" name="program" required>
                                    <option value="">Select Program</option>
                                    <option value="BIT">BIT</option>
                                    <option value="BCSE">BCSE</option>
                                    <option value="MIT">MIT</option>
                                    <option value="BsCIT">BsCIT</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="edit_gender">Gender *</label>
                                <select class="form-control" id="edit_gender" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="edit_contact">Contact Number *</label>
                        <input type="tel" class="form-control" id="edit_contact" name="contact" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="edit_address">Address *</label>
                        <textarea class="form-control" id="edit_address" name="address" rows="3" required></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label>Birthday</label>
                        <input type="text" class="form-control" id="display_birthday" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary-custom" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="update_student" class="btn btn-primary-custom">Update Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
function loadStudentData(studentId, name, email, program, gender, contact, address, birthday) {
    document.getElementById('edit_student_id').value = studentId;
    document.getElementById('display_student_id').value = studentId;
    document.getElementById('edit_student_name').value = name;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_program').value = program;
    document.getElementById('edit_gender').value = gender;
    document.getElementById('edit_contact').value = contact;
    document.getElementById('edit_address').value = address;
    document.getElementById('display_birthday').value = birthday;
}
function validateEditForm() {
    var name = document.getElementById('edit_student_name').value;
    var email = document.getElementById('edit_email').value;
    var program = document.getElementById('edit_program').value;
    var contact = document.getElementById('edit_contact').value;
    var gender = document.getElementById('edit_gender').value;
    var address = document.getElementById('edit_address').value;
    var errorElements = document.querySelectorAll('.error-message');
    errorElements.forEach(function(element) {
        element.remove();
    });
    var isValid = true;
    if (name === '') {
        showError('edit_student_name', 'Name is required');
        isValid = false;
    }
    if (email === '') {
        showError('edit_email', 'Email is required');
        isValid = false;
    } else if (!isValidEmail(email)) {
        showError('edit_email', 'Invalid email format');
        isValid = false;
    }
    if (program === '') {
        showError('edit_program', 'Program is required');
        isValid = false;
    }
    if (contact === '') {
        showError('edit_contact', 'Contact is required');
        isValid = false;
    }
    if (gender === '') {
        showError('edit_gender', 'Gender is required');
        isValid = false;
    }
    if (address === '') {
        showError('edit_address', 'Address is required');
        isValid = false;
    }
    return isValid;
}
function showError(fieldId, message) {
    var field = document.getElementById(fieldId);
    var errorDiv = document.createElement('div');
    errorDiv.className = 'error-message text-danger small';
    errorDiv.textContent = message;
    field.parentNode.appendChild(errorDiv);
}
function isValidEmail(email) {
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}
</script>
<?php include('includes/footer.php'); ?>
