<?php
include('config.php');

// Fetching data for the User Overview (example: total students, instructors)
$sql_students = "SELECT COUNT(*) AS total_students FROM studentProfile";
$result_students = $conn->query($sql_students);
$total_students = $result_students->fetch_assoc()['total_students'];

// Fetching reports (example: concern reports)
$sql_reports = "SELECT reportID, reportMessage, dateTime FROM conReport";
$result_reports = $conn->query($sql_reports);

// Account creation form submission logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_account'])) {
    $accountType = $_POST['accountType'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $status = $_POST['status'];

    $sql = "INSERT INTO accounts (accountType, username, password, status) 
            VALUES ('$accountType', '$username', '$password', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "New account created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Report response handling
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['respond_to_report'])) {
    $reportID = $_POST['reportID'];
    $responseMessage = $_POST['responseMessage'];

    $sql_response = "INSERT INTO actReport (accountID, actionMessage, dateTime) 
                     VALUES (1, '$responseMessage', NOW())"; // Assume accountID 1 is the admin

    if ($conn->query($sql_response) === TRUE) {
        echo "Response submitted successfully.";
    } else {
        echo "Error: " . $sql_response . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="sidebar">
    <h2>Admin Dashboard</h2>
    <button onclick="showSection('accountForm')">Account</button>
    <button onclick="showSection('reportsSection')">Reports</button>
    <button onclick="showSection('userOverview')">User Overview</button>
    <button onclick="showSection('courseManagement')">Courses</button>
    <button onclick="showSection('activities')">Activities</button>
</div>

<div class="main-content">
    <!-- Account Form -->
    <div id="accountForm" class="dashboard-card" style="display: none;">
        <h3>Account</h3>
        <form method="POST" action="index.php">
            <label class="label">Account Type</label>
            <select class="select" name="accountType" required>
                <option value="Admin">Admin</option>
                <option value="Teacher">Teacher</option>
                <option value="Student">Student</option>
            </select>

            <label class="label">Username</label>
            <input type="text" name="username" class="input" required>

            <label class="label">Password</label>
            <input type="password" name="password" class="input" required>

            <label class="label">Status</label>
            <select class="select" name="status" required>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>

            <button type="submit" name="create_account" class="button">Create Account</button>
        </form>
    </div>

    <!-- Reports Section -->
    <div id="reportsSection" class="dashboard-card" style="display: none;">
        <h3>Reports</h3>
        <table>
            <thead>
                <tr>
                    <th>Report ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Time and Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_reports->fetch_assoc()) : ?>
                    <tr onclick="showReportResponse(<?php echo $row['reportID']; ?>, '<?php echo addslashes($row['reportMessage']); ?>')">
                        <td><?php echo $row['reportID']; ?></td>
                        <td><?php echo $row['reportMessage']; ?></td>
                        <td><?php echo $row['dateTime']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div id="responseArea" style="display: none;">
            <label class="label">Response for Report <span id="reportId"></span></label>
            <textarea class="textarea" id="responseText" placeholder="Enter your response here..."></textarea>
            <form method="POST" action="index.php">
                <input type="hidden" name="reportID" id="reportID">
                <button type="submit" name="respond_to_report" class="button">Submit Response</button>
            </form>
        </div>
    </div>

    <!-- User Overview -->
    <div id="userOverview" class="dashboard-card" style="display: none;">
        <h3>User Overview</h3>
        <div class="stat">Total Students: <?php echo $total_students; ?></div>
        <div class="stat">Total Instructors: 20</div>
        <div class="stat">Total Admins: 5</div>
    </div>

    <!-- Course Management -->
    <div id="courseManagement" class="dashboard-card" style="display: none;">
        <h3>Courses</h3>
        <div class="stat">Total Courses: 10</div>
    </div>

    <!-- Activities -->
    <div id="activities" class="dashboard-card" style="display: none;">
        <h3>Activities</h3>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Quiz 1</td>
                    <td>Introduction to Algebra</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    function showSection(sectionId) {
        const sections = document.querySelectorAll('.dashboard-card');
        sections.forEach(section => section.style.display = 'none');
        document.getElementById(sectionId).style.display = 'block';
    }

    function showReportResponse(reportId, reportMessage) {
        document.getElementById('responseArea').style.display = 'block';
        document.getElementById('reportId').textContent = reportId;
        document.getElementById('reportID').value = reportId;
    }
</script>

</body>
</html>
