<?php
require_once "../config.php";

    $school = $fname = $mname = $lname = $gender = $birthday = $phone = $email = $street = $city = $state = $zip = $grade = $isFullyEnrolled = "";
    $school_err = $fname_err = $mname_err = $lname_err = $gender_err = $birthday_err = $phone_err = $email_err = $street_err = $city_err = $state_err = $zip_err = $grade_err = $isFullyEnrolled_err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (empty(trim($_POST["school"]))) {
            $school_err = "Please supply the school id.";
        } else {
            $school = trim($_POST["school"]);
        }

        if (empty(trim($_POST["fname"]))) {
            $fname_err = "Please provide your first name.";
        } else {
            $fname = trim($_POST["fname"]);
        }

        if (empty(trim($_POST["mname"]))) {
            $mname_err = "Please provide a middle name.";
        } else {
            $mname = trim($_POST["mname"]);
        }

        if (empty(trim($_POST["lname"]))) {
            $lname_err = "Please provide your last name.";
        } else {
            $lname = trim($_POST["lname"]);
        }

        if (empty(trim($_POST["gender"]))) {
            $gender_err = "please supply a gender.";
        } else {
            $gender = trim($_POST["gender"]);
        }

        if (empty(trim($_POST["birthday"]))) {
            $birthday_err = "please select a birthday.";
        } else {
            $birthday = trim($_POST["birthday"]);
        }

        if (empty(trim($_POST["phone"]))) {
            $phone_err = "Please supply a valid phone number.";
        } else {
            $phone = trim($_POST["phone"]);
        }

        if (empty(trim($_POST["email"]))) {
            $email_err = "Please supply a valid email.";
        } else {
            $email = trim($_POST["email"]);
        }

        if (empty(trim($_POST["grade"]))) {
            $grade_err = "please supply a grade level.";
        } else {
            $grade = trim($_POST["grade"]);
        }

        if (empty(trim($_POST["street"]))) {
            $street_err = "Please supply the street address.";
        } else {
            $street = trim($_POST["street"]);
        }

        if (empty(trim($_POST["city"]))) {
            $city_err = "Please supply the city the school is located in.";
        } else {
            $city = trim($_POST["city"]);
        }

        if (empty(trim($_POST["state"]))) {
            $state_err = "Please supply the state the school is located in.";
        } else {
            $state = trim($_POST["state"]);
        }

        if (empty(trim($_POST["zip"]))) {
            $zip_err = "Please supply the zip code";
        } else {
            $zip = trim($_POST["zip"]);
        }

        switch ($_POST["enrolled"]) {
            case 'true':
                $isFullyEnrolled = true;
                break;
            case 'false':
                $isFullyEnrolled = false;
                break;
            default:
                $isFullyEnrolled_err = "Fully enrolled is either 'true' or 'false'";
                break;
        }

        // Check to see if any errors exist and if not, add the entry to the database
        if (
            empty($school_err)   && 
            empty($fname_err)    && 
            empty($mname_err)    && 
            empty($lname_err)    && 
            empty($gender_err)   && 
            empty($birthday_err) &&
            empty($phone_err)    && 
            empty($email_err)    && 
            empty($street_err)   && 
            empty($city_err)     && 
            empty($state_err)    &&
            empty($zip_err)      &&
            empty($grade_err)    &&
            empty($isFullyEnrolled_err)
        ) {
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
            
            $sql = "INSERT INTO Student(SchoolID, Firstname, Middlename, Lastname, Gender, Birthdate, Phonenumber, Email, AddressID, Gradelevel, IsFullyEnrolled) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param(
                    "ssssssssssb", 
                    $param_school, 
                    $param_fname, 
                    $param_mname,
                    $param_lname,
                    $param_gender,
                    $param_birthday,
                    $param_phone,
                    $param_email,
                    $param_address,
                    $param_grade,
                    $param_enrolled
                );

                $param_school = $school;
                $param_fname = $fname;
                $param_mname = $mname;
                $param_lname = $lname;
                $param_gender = $gender;
                $param_birthday = $birthday;
                $param_phone = $phone;
                $param_email = $email;
                $param_address = $address;
                $param_grade = $grade;
                $param_enrolled = $isFullyEnrolled;

                if ($stmt->execute()) {
                    
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
        <title>Student sign up</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link media="all" type="text/css" rel="stylesheet" href="/style.css">
</head>
<body>
    <div>
        <form action="./student.php" method="POST">
            <div class="form-group">
                <label for="fname">First Name: </label>
                <input type="text" name="fname"
                    class="form-control <?php echo (!empty($fname_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $fname; ?>">
                <span class="invalid-feedback"><?php echo $fname_err; ?></span>
            </div>
            <div class="form-group">
                <label for="mname">Middle Name: </label>
                <input type="text" name="mname"
                    class="form-control <?php echo (!empty($mname_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $mname; ?>">
                <span class="invalid-feedback"><?php echo $mname_err; ?></span>
            </div>
            <div class="form-group">
                <label for="lname">Last Name: </label>
                <input type="text" name="lname"
                    class="form-control <?php echo (!empty($lname_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $lname; ?>">
                <span class="invalid-feedback"><?php echo $lname_err; ?></span>
            </div>
            <div class="form-group">
                <label for="gender">Gender: </label>
                <input type="radio" name="gender" 
                    class="form-control <?php echo (!empty($gender_err)) ? 'is-invalid' : ''; ?>"
                    value="male"
                    <?php echo ($gender == "male") ? 'checked' : ''; ?>>
                    Male
                </input>
                <input type="radio" name="gender" 
                    class="form-control <?php echo (!empty($gender_err)) ? 'is-invalid' : ''; ?>"
                    value="female"
                    <?php echo ($gender == "female") ? 'checked' : ''; ?>>
                    Female
                </input>
                <input type="radio" name="gender" 
                    class="form-control <?php echo (!empty($gender_err)) ? 'is-invalid' : ''; ?>"
                    value="other"
                    <?php echo ($gender == "other") ? 'checked' : ''; ?>>
                    Other
                </input>
                <span class="invalid-feedback"><?php echo $gender_err ?></span>
            </div>
            <div class="form-group">
                <label for="birthday">Birth day: </label>
                <input type="date" name="birthday"
                    class="form-control <?php echo (!empty($birthday_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php $birthday ?>">
                <span class="invalid-feedback"><?php $birthday_err ?></span>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number: </label>
                <input type="text" name="phone"
                    class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $phone; ?>">
                <span class="invalid-feedback"><?php echo $phone_err; ?></span>
            </div>
            <div class="form-group">
            <label for="email">Email: </label>
            <input type="text" name="email" 
                class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>"
                value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
            <label for="grade">Grade Level: </label>
            <input type="number" name="grade" 
                class="form-control <?php echo (!empty($grade_err)) ? 'is-invalid' : ''; ?>"
                value="<?php echo $grade; ?>">
            </div>
            <div class="form-group">
                <label for="enrolled">Are You Enrolled?: </label>
                <input type="checkbox" name="enrolled" value="true"
                    class="form-control <?php echo (!empty($isFullyEnrolled_err)) ? 'is-invalid' : '' ?>"
                    <?php echo ($isFullyEnrolled == "true") ? 'checked' : '' ?>>
                <span class="invalid-feedback"><?php echo $isFullyEnrolled_err ?></span>
            </div>
            <div class="form-group">
                <label for="street">Street</label>
                <input type="text" name="email" 
                    class="form-control <?php echo (!empty($street_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $street; ?>">
                <span class="invalid-feedback"><?php echo $street_err; ?></span>
            </div>
            <div class="form-group">
                <label for="city">City</label>
                <input type="text" name="email" 
                    class="form-control <?php echo (!empty($city_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $city; ?>">
                <span class="invalid-feedback"><?php echo $city_err; ?></span>
            </div>
            <div class="form-group">
                <label for="state">State</label>
                <input type="text" name="email" 
                    class="form-control <?php echo (!empty($state_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $state; ?>">
                <span class="invalid-feedback"><?php echo $state_err; ?></span>
                </div>
            <div class="form-group">
                <label for="zip">Zipcode</label>
                <input type="text" name="email" 
                    class="form-control <?php echo (!empty($zip_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $zip; ?>">
                <span class="invalid-feedback"><?php echo $zip_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" value="Submit" class="btn btn-primary">
                <input type="reset" value="Clear" clear="btn btn-secondary m1-2">
            </div>
        </form>
    </div>
</body>
</html>