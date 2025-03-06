// add_user.php
<?php
include("dbconnection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $student_name = $_POST['student_name'] ?? '';
    $school = $_POST['school'] ?? '';
    $school_address = $_POST['school_address'] ?? '';
    $contact_number = $_POST['contact_number'] ?? '';
    $coordinator = $_POST['coordinator'] ?? '';
    $organization = $_POST['organization'] ?? '';
    $date_started = $_POST['date_started'] ?? date('Y-m-d H:i:s'); // Use posted date or current date if not set

    // Validate required fields
    if (empty($student_name) || empty($school) || empty($contact_number)) {
        echo "Please fill in all required fields.";
        exit;
    }

    try {
        // Prepare the SQL statement
        $sql = "INSERT INTO students_tbl (student_name, school, school_address, contact_number, coordinator, organization, date_started) 
                VALUES (:student_name, :school, :school_address, :contact_number, :coordinator, :organization, :date_started)";
        $stmt = $connection->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':student_name', $student_name);
        $stmt->bindParam(':school', $school);
        $stmt->bindParam(':school_address', $school_address);
        $stmt->bindParam(':contact_number', $contact_number);
        $stmt->bindParam(':coordinator', $coordinator);
        $stmt->bindParam(':organization', $organization);
        $stmt->bindParam(':date_started', $date_started);

        // Execute the statement
        $stmt->execute();

        echo "Data added successfully.";  // Send success message back
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();  // Return error if something goes wrong
    }
}
?>
