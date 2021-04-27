<?php
    // form names should be: SchoolName = name; District = dist; Address = addr
    require_once "../config.php";
    
    $name = $district = $street = $city = $state = $zip = "";

    $name_error = $district_error = $address_error = $street_error = $city_error = $state_error = $zip_error = "";

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

        if (empty(trim($_POST["street"]))) {
            $street_error = "Please supply the street address.";
        } else {
            $street = trim($_POST["street"]);
        }

        if (empty(trim($_POST["city"]))) {
            $street_error = "Please supply the city the school is located in.";
        } else {
            $street = trim($_POST["city"]);
        }

        if (empty(trim($_POST["state"]))) {
            $street_error = "Please supply the state the school is located in.";
        } else {
            $street = trim($_POST["state"]);
        }

        if (empty(trim($_POST["zip"]))) {
            $street_error = "Please supply the zip code";
        } else {
            $street = trim($_POST["zip"]);
        }


        // Check to see if any errors exist and if not, add the entry to the database
        if (empty($name_error) && empty($district_error) && empty($address_error) && empty($street) && empty($city) && empty($state) && empty($zip)) {

            $sql = "SELECT AddressID FROM Address WHERE Street = ? AND City = ? AND State = ? AND Zipcode = ?";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ssss", $param_street, $param_city, $param_state, $param_zip);

                $param_street = $street;
                $param_city = $city;
                $param_state = $state;
                $param_zip = $zip;

                if ($stmt->execute()) {
                    $stmt->store_result();

                    if ($stmt->num_rows == 1) {
                        $address = $stmt->fetch_assoc()[0];
                    } else {
                        $stmt->close();
                        $sql = "INSERT INTO Address Values (?, ?, ?, ?);";

                        if ($stmt = $conn->prepare($sql)) {
                            $stmt->bind_param("ssss", $param_street, $param_city, $param_state, $param_zip);

                            $param_street = $street;
                            $param_city = $city;
                            $param_state = $state;
                            $param_zip = $zip;

                            if ($stmt->execute()) {
                                $stmt->store_result();

                                $address = $stmt->insert_id;
                            } else {
                                echo "Something went wrong, please try again later.";
                            }
                            $stmt->close();
                        }
                    }
                } else {
                    "Something went wrong, please try again.";
                }
                $stmt->close();
            }
            
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
                    value="<?php echo $district; ?>">
                <span class="invalid-feedback"><?php echo $district_error; ?></span>
            </div>

            <div class="form-group">
                <label for="street"></label>
                <input type="text" name="street" 
                    class="form-control <?php echo (!empty($street_error)) ? "in-invalid" : ""; ?>"
                    value="<?php echo $street ?>">
                <span class="invalid-feedback"></span>
            </div>
            <div class="form-group">
                <label for="city"></label>
                <input type="text" name="city" 
                    class="form-control <?php echo (!empty($city_error)) ? "is-invalid" : ""; ?>"
                    value="<?php echo $city ?>">
                <span class="invalid-feedback"></span>
            </div>
            <div class="form-group">
                <label for="state"></label>
                <input type="text" name="state" 
                    class="form-control <?php echo (!empty($state_error)) ? "is-invalid" : ""; ?>"
                    value="<?php echo $state ?>">
                <span class="invalid-feedback"></span>
            </div>
            <div class="form-group">
                <label for="zip"></label>
                <input type="text" name="zip" 
                    class="form-control <?php echo (!empty($zip_error)) ? "is-invalid" : ""; ?>"
                    value="<?php echo $zip ?>">
                <span class="invalid-feedback"></span>
            </div>

            <div class="form-group">
                <input type="submit" value="Submit" class="btn btn-primary">
                <input type="reset" value="Reset" class="btn btn-secondary m1-2">
            </div>
        </form>
    </div>
</body>
</html>