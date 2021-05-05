<?php
    $group = $grade = $name = "";
    $group_err = $grade_err = $name_err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty(trim($_POST["group-id"]))) {
            $group_err = "Please supply a class group id";
        } else {
            $group = trim($_POST["group-id"]);
        }

        if (empty(trim($_POST["grade"]))) {
            $grade_err = "Please supply a grade level for this class";
        } else {
            $grade = trim($_POST["grade"]);
        }

        if (empty(trim($_POST("name")))) {
            $name_err = "Please supply a name for this class";
        } else {
            $name = trim($_POST("name"));
        }

        if (empty($group_err) && empty($grade_err) && empty($name_err)) {
            require_once "../config.php";
            $sql = "INSERT INTO Class (GroupID, GradeLevel, Name) VALUES (?, ?, ?)";
        
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("sss", $param_group, $param_grade, $param_name);

                $param_group = $group;
                $param_grade = $grade;
                $param_name = $name;

                if ($stmt->execute()) {
                    header("location: ../schools");
                } else {
                    echo "Something went wrong, please try again.";
                }
            }
            $conn->close();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Registration</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="/style.css">
</head>
<body>
    <h2>Add Class</h2>
    <div class="wrapper">
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
            <div class="form-group">
                <label for="group-id"></label>
                <input type="text" name="group-id"
                    class="form-control <?php echo (!empty($group_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $group; ?>">
                <span class="invalid-feedback"><?php echo $group_err; ?></span>
            </div>
            <div class="form-group">
                <label for="grade">
                </label><input type="text" name="grade"
                    class="form-control <?php echo (!empty($grade_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $grade ?>">
                <span class="invalid-feedback"><?php echo $grade_err; ?></span>
            </div>
            <div class="form-group">
                <label for="name"></label>
                <input type="text" name="name" 
                    class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $name; ?>">
                <span class="invalid-feedback"><?php echo $name_err; ?></span>
            </div>

            <div class="form-group">
                <input type="submit" value="Submit" class="btn btn-primary">
                <input type="reset" value="Clear" class="btn btn-secondary m1-2">
            </div>
        </form>
    </div>
</body>
</html>