<?php
    // form names should be: SchoolName = name; District = dist; Address = addr
    require_once "../config.php";

    $studentID = $schoolID = $fname = $mname = $lname = $gender = $birthdate = $phonenumber = $email = $addressID = $gradelevel = $isfullyenrolled = "";
    $studentID_error = $schoolID_error = $fname_error = $mname_error = $lname_error = $gender_error = $birthdate_error = $phonenumber_error = $email_error = $addressID_error = $gradelevel_error = $isfullyenrolled_error = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty(trim($_POST["name"]))) {
            $fname_error = "Please provide Your name.";
        } else {
            $sql = "SELECT fname FROM Student WHERE Name = ?";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("s", $param_name);
                $param_name = trim($_POST["name"]);

                if ($stmt->execute()) {
                    $stmt->store_result();

                    // if ($stmt->num_rows == 1) {
                    //     $name_error = "A school with this name is already registered.";
                    // } else {}
                    // i dont think this needs to be here
                        $name = trim($_POST["name"]);
                } else {
                    echo "Something went wrong, please try again.";
                }
                $stmt->close();
            }
        }

        if (empty(trim($_POST["rela"]))) {
            $relationship_error = "Please supply your relationship to the student.";
        } else {
            $district = trim($_POST["rela"]);
        }

        if (empty(trim($_POST["phone"]))) {
            $street_error = "Please supply your phone number.";
        } else {
            $street = trim($_POST["phone"]);
        }

        // Check to see if any errors exist and if not, add the entry to the database
        if (/* empty($name_error) && empty($district_error) && empty($street_error) && empty($city_error) && empty($state_error) && empty($zip_error) */ true) {
            $sql = "SELECT AddressID FROM Address WHERE Street = ? AND City = ? AND State = ? AND Zipcode = ?";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ssss", $param_street, $param_city, $param_state, $param_zip);

                $param_street = $street;
                $param_city = $city;
                $param_state = $state;
                $param_zip = $zip;

                if ($stmt->execute()) {
                    $stmt->store_result();
                    
                    if ($stmt->num_rows != 1) {
                        $stmt->close();
                        $sql = "INSERT INTO Address(Street, City, State, Zipcode) VALUES (?, ?, ?, ?)";

                        if ($stmt = $conn->prepare($sql)) {
                            $stmt->bind_param("ssss", $param_street, $param_city, $param_state, $param_zip);

                            if ($stmt->execute()) {
                                $stmt->store_result();

                                $address = $stmt->insert_id;
                            } else {
                                echo "Something went wrong, please try again later. ";
                                exit();
                            }
                            $stmt->close();
                        }
                    } elseif ($stmt->num_rows == 1) {
                        while ($row = $stmt->get_result()->fetch_assoc()) {
                            $address = $row["AddressID"];
                            echo $address;
                        }
                    }
                } else {
                    "Something went wrong, please try again.";
                    exit();
                }
            }
            
            $sql = "INSERT INTO School(Name, District, AddressID) VALUES (?, ?, ?);";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ssi", $param_name, $param_district, $param_addr);

                $param_name = $name;
                $param_district = $district;
                $param_addr = $address;

                if ($stmt->execute()) {
                    header("location: ../schools?id=".$stmt->insert_id);
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
    <div>
        <form action="./student.php" method="POST">
            <div class="form-group">
                <label for="fname">First Name: </label>
                <input type="text" name="fname" id="fname"
                    class="form-control <?php echo (!empty($fname_error)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $fname; ?>">
                <span class="invalid-feedback"><?php echo $fname_error; ?></span>
            </div>
            <div class="form-group">
                <label for="mname">Middle Name: </label>
                <input type="text" name="mname" id="mname"
                class="form-control <?php echo (!empty($mname_error)) ? 'is-invalid' : ''; ?>"
                value="<?php echo $mname; ?>">
                <span class="invalid-feedback"><?php echo $mname_error; ?></span>
            </div>
            <div class="form-group">
                <label for="lname">Last Name: </label>
                <input type="text" name="lname" id="lname"
                class="form-control <?php echo (!empty($lname_error)) ? 'is-invalid' : ''; ?>"
                value="<?php echo $lname; ?>">
                <span class="invalid-feedback"><?php echo $lname_error; ?></span>
            </div>
            <br>
            <div class="form-group">
            <label for="gender">Gender: </label>
            <input type="radio" name="gender" id="male" class="form-control <?php echo (!empty($gender_error)) ? 'is-invalid' : ''; ?>"
            value="">
            <label for="gender">Male </label>
            <input type="radio" name="gender" id="female" class="form-control <?php echo (!empty($gender_error)) ? 'is-invalid' : ''; ?>"
            value="">
            <label for="gender">Female </label>
            <input type="radio" name="gender" id="other" class="form-control <?php echo (!empty($gender_error)) ? 'is-invalid' : ''; ?>"
            value="">
            </div>
            <div class="form-group">
            <label for="Birthdate">Birth day: </label>
            <input type="date" name="Birthdate" id="birthday <?php echo (!empty($birthdate_error)) ? 'is-invalid' : ''; ?>"
            value="">
            </div>
            <div class="form-group">
            <label for="phonrnumber">Phonenumber: </label>
            <input type="text" name="phonenumber" id="phonenumber <?php echo (!empty($phonenumber_error)) ? 'is-invalid' : ''; ?>"
            value="<?php echo $phonenumber; ?>">
            <span class="invalid-feedback"><?php echo $phonenumber_error; ?></span>
            </div>
            <br>
            div
        </form>
    </div>
</body>
</html>