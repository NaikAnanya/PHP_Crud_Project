<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Details</title>
</head>
<body>
    <h2>View Details</h2>

    <!-- Display Records -->
    <table border="1">
        <tr>
            <th>Name</th>
            <th>USN</th>
            <th>Phone Number</th>
            <th>Delete Record</th>
        </tr>

        <?php
        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'wshop');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Search query
        $search_query = "";
        if (isset($_GET['query'])) {
            $search_query = $conn->real_escape_string($_GET['query']);
        }

        // Sorting
        $sort_by = "name";
        if (isset($_GET['sort'])) {
            $sort_by = $conn->real_escape_string($_GET['sort']);
        }

        // Prepare SQL query
        $sql = "SELECT * FROM students WHERE name LIKE '%$search_query%' ORDER BY $sort_by";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row["name"]) . "</td>
                        <td>" . htmlspecialchars($row["usn"]) . "</td>
                        <td>" . htmlspecialchars($row["phone"]) . "</td>
                        <td>
                            <form action='delete.php' method='post'>
                                <input type='hidden' name='id' value='" . htmlspecialchars($row['id']) . "'>
                                <input type='submit' value='Delete'>
                            </form>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No records found</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>
