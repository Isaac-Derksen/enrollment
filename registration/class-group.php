<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $school = $name = "";
        $school_err = $name_err = "";

        if (empty(trim($_POST["school-id"]))) {
            $school_err = "Please supply the school ID";
        } else {
            $school = trim($_POST["school-id"]);
        }

        if (empty(trim($_POST["name"]))) {
            $name_err = "Please supply a name for the class group";
        } else {
            $name = trim($_POST["name"]);
        }

        if (empty($school_err) && empty($name_err)) {
            require_once "../config.php";
            $sql = "INSERT INTO ClassGroup (SchoolID, Name) VALUES (?, ?)";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ss", $param_school, $param_name);

                $param_school = $school;
                $param_name = $name;

                if ($stmt->execute()) {
                    $stmt->store_result();
                    header("location: ../schools?school-id=".$school."&class-group=".$stmt->insert_id);
                } else {
                    echo "Something went wrong, please try again.";
                }
                $stmt->close();
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
    <title>Add Class Group</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="/style.css">
</head>
<body>
    <div class="wrapper">
        <h2>Add Class Group</h2>
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="school-id">School ID</label>
                <input type="text" name="school-id" 
                    class="form-control <?php echo (!empty($school_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $school; ?>">
                <span class="invalid-feedback"><?php echo $school_err; ?></span>
            </div>
            <div class="form-group">
                <label for="name">Group Name</label>
                <input type="text" name="name" 
                    class="form-control <?php echo (!empty($name_err)) ? 'in-invalid' : ''; ?>"
                    value="<?php echo $name ?>">
                <span class="invalid-feedback"></span>
            </div>
            <div class="form-group">
                <input type="submit" value="Submit" class="btn btn-primary">
                <input type="reset" value="Clear" class="btn btn-secondary m1-2">
            </div>
        </form>
    </div>
</body>
</html>