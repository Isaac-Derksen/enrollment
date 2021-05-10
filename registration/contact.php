<?php 
    require_once "../config.php";

    $student = $name = $rel = $phone = ""; // rel = relation
    $student_err = $name_err = $rel_err = $phone_err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (empty(trim($_POST["student"]))) {
            $student_err = "please supply the student id.";
        } else {
            $sql = "SELECT StudentID FROM Student WHERE StudentID = ?";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("s", $param_student);

                $param_student = trim($_POST["student"]);

                if ($stmt->execute()) {
                    $stmt->store_result();

                    if ($stmt->num_rows = 0) {
                        $student_err = "A student with that ID does not exist.";
                    } else {
                        $student = trim($_POST["student"]);
                    }
                } else echo "Something went wrong, please try again";
            }
        }

        if (empty(trim($_POST["name"]))) {
            $name_err = "Please provide Your name.";
        } else {
            $name = trim($_POST["name"]);
        }

        if (empty(trim($_POST["rel"]))) {
            $rel_err = "Please supply your rel to the student.";
        } else {
            $rel = trim($_POST["rel"]);
        }

        if (empty(trim($_POST["phone"]))) {
            $phone_err = "Please supply your phone number.";
        } else {
            $phone = trim($_POST["phone"]);
        }

        if (empty($student_err) && empty($name_err) && empty($rel_err) && empty($phone_err)) {
            $sql = "INSERT INTO StudentContact (StudentID, Name, Relationship, PhoneNumber) VALUES (?, ?, ?, ?)";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ssss", $param_student, $param_name, $param_rel, $param_phone);

                $param_student = $student;
                $param_name = $name;
                $param_rel = $rel;
                $param_phone = $phone;

                if ($stmt->execute()) {
                    header("location: /");
                } else {
                    echo "Something went wrong, please try again.";
                }
            }
        }
        $conn->close();
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Student contacts</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link media="all" type="text/css" rel="stylesheet" href="/style.css">
</head>
<body>
    <div class="wrapper">
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
            <div class="form-group">
                <label for="student">Student ID</label>
                <input type="text" name="student"
                    class="form-control <?php echo (!empty($student_err)) ? 'is-invalid' : '' ?>"
                    value="<?php echo $student ?>">
                <span class="invalid-feedback"><?php echo $student_err ?></span>
            </div>

            <div class="form-group">
                <label for="name">Contact Name</label>
                <input type="text" name="name"
                    class="form-control <?php echo (!empty($contact_err)) ? 'is-invalid' : '' ?>"
                    value="<?php echo $contact ?>">
                <span class="invalid-feedback"><?php echo $contact_err ?></span>
            </div>

            <div class="form-group">
                <label for="rel">Relationship</label>
                <input type="text" name="rel"
                    class="form-control <?php echo (!empty($rel_err)) ? 'is-invalid' : '' ?>"
                    value="<?php echo $rel ?>">
                <span class="invalid-feedback"><?php echo $rel_err ?></span>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" name="phone"
                    class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : '' ?>"
                    value="<?php echo $phone ?>">
                <span class="invalid-feedback"><?php echo $phone_err ?></span>
            </div>

            <div class="form-group">
                <input type="submit" value="Submit" class="btn btn-primary">
                <input type="reset" value="Reset" class="btn btn-secondary m1-2">
            </div>
        </form>
    </div>
</body>
</html>
