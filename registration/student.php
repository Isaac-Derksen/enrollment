<?php
    // form names should be: SchoolName = name; District = dist; Address = addr
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
            $street_error = "Please supply the street address.";
        } else {
            $street = trim($_POST["street"]);
        }

        if (empty(trim($_POST["city"]))) {
            $city_error = "Please supply the city the school is located in.";
        } else {
            $city = trim($_POST["city"]);
        }

        if (empty(trim($_POST["state"]))) {
            $state_error = "Please supply the state the school is located in.";
        } else {
            $state = trim($_POST["state"]);
        }

        if (empty(trim($_POST["zip"]))) {
            $zip_error = "Please supply the zip code";
        } else {
            $zip = trim($_POST["zip"]);
        }



        // Check to see if any errors exist and if not, add the entry to the database
        if (true) {
            $sql = "";

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
    
</body>
</html>