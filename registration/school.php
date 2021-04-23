<?php
    // form names should be: SchoolName = name; District = dist; Address = addr
    require_once "../config.php";
    
    $name = $district = $address = "";
    $name_error = $district_error = $address_error = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty(trim($_POST["name"]))) {
            $name_error = "Please provide the school's name.";
        } else {
            $sql = "SELECT Name FROM School WHERE Name = ?";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("s", $param_name);
                $param_name = trim($_POST["name"]);

                if ($stmt->execute()) {
                    $stmt->store_result();

                    if ($stmt->num_rows == 1) {
                        $name_error = "A school with this name is already registered.";
                    } else {
                        $name = trim($_POST["name"]);
                    }
                } else {
                    echo "Something went wrong, please try again.";
                }
                $stmt->close();
            }
        }

        if (empty(trim($_POST["dist"]))) {
            $district_error = "Please supply the district for the school.";
        } else {
            $district = trim($_POST["dist"]);
        }

        $address = "0";
        // old address code
        #if (empty(trim($_POST["addr"]))) {
        #    $address_error = "Please supply the address of the school.";
        #} else {
        #    $addr = buildAddress(trim($_POST["addr"]));
        #    if ($addr === null) {
        #        $address_error = "This is not a valid address.";
        #    } else {
        #        $address = addAddress($addr);
        #    }
        #}

        if (empty($name_error) && empty($district_error) && empty($address_error)) {
            $sql = "INSERT INTO School (Name, District, AddressID) VALUES (?, ?, ?)";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("sss", $param_name, $param_district, $param_address);

                $param_name = $name;
                $param_district = $district;
                $param_address = $address;

                if ($stmt->execute()) {
                    header("location: view.php");
                } else {
                    echo "something went wrong, please try again later.";
                }
                $stmt->close();
            }
        }
        $conn->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Registration</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="/style.css">
</head>
<body>
    <div class="wrapper">
        <h2>School Registration</h2>
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        <div class="form-group">
                <label for="name">School Name</label>
                <input type="text" name="name" 
                    class="form-control <?php echo (!empty($name_error)) ? "is-invalid" : ""; ?>"
                    value="<?php echo $name; ?>">
                <span class="invalid-feedback"><?php echo $name_error; ?></span>
            </div>

            <div class="form-group">
                <label for="dist">District</label>
                <input type="text" name="dist"
                    class="form-control <?php echo (!empty($district_error)) ? "is-invalid" : ""; ?>"
                    value="<?php echo $district; ?>"
                >
                <span class="invalid-feedback"><?php echo $district_error; ?></span>
            </div>

            <div class="form-group">
                <label for="addr">Address</label>
                <input type="text" name="addr"
                    class="form-control <?php echo (!empty($address_error)) ? "is-invalid" : ""; ?>"
                    value="<?php echo $address; ?>"
                >
                <span class="invalid-feedback"><?php echo $address_error; ?></span>
            </div>

            <div class="form-group">
                <input type="submit" value="Submit" class="btn btn-primary">
                <input type="reset" value="Reset" class="btn btn-secondary m1-2">
            </div>
        </form>
    </div>
</body>
</html>