<?php
include("dbconnection.php");
$sql = "SELECT * FROM students_tbl";
$result = $connection->query($sql);
$output = "";
if ($result) {
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        // Format date_started
        $dateStarted = new DateTime($row['date_started']);
        $currentDate = new DateTime();  // Get current date
        $interval = $dateStarted->diff($currentDate);  // Calculate the difference

        $formattedDateStarted = $dateStarted->format('F j, Y, g:i a'); // Example: March 5, 2025, 9:31 pm
        $daysOld = $interval->days;  // Get the number of days difference
        $daysOldMessage = ($daysOld == 1) ? '1 day old' : "$daysOld days old";

        // Generate table row
        $output .= "
            <tr>
                <td>{$row['assign_id']}</td>
                <td>{$row['student_name']}</td>
                <td>{$row['school']}</td>
                <td>{$row['school_address']}</td>
                <td>{$row['contact_number']}</td>
                <td>{$row['coordinator']}</td>
                <td>{$row['organization']}</td>
                <td>{$daysOldMessage}</td>  <!-- Display days old -->
                <td>
                    <button class='btn btn-warning btn-sm' onclick='openEditModal(" . json_encode($row['assign_id']) . ")'>Edit</button>

                    <button class='btn btn-danger btn-sm' onclick='deleteUser(" . json_encode($row['assign_id']) . ")'>Delete</button>
                </td>
            </tr>
        ";
    }
} else {
    $output .= "<tr><td colspan='9' class='text-center'>No records found</td></tr>";
}
echo $output;

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "SELECT * FROM students_tbl WHERE assign_id = :id";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($user);
}
?>
