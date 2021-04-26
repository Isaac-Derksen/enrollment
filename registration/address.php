<?php
    require_once "../config.php";
    require_once "../models/address.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $address = $address_error = "";

        if (empty(trim($_POST["addr"]))) {
            $address_error = "No address supplied.";
        } else {
            $params = explode(',', trim($_POST["addr"]));
            $addr = "";
            try {
                $addr = new Address($params[0], $params[1], $params[2], (int)$params[3]);
            } catch (Exception $e) {
                $address_error = "Supplied address is invalid: ". $e;
            }

            $sql = "SELECT AddressID FROM Address WHERE Street == ? AND City = ? AND State = ? AND Zipcode = ?";

            if (($stmt = $conn->prepare($sql)) && !empty($addr)) {
                $stmt->bind_param("ssss", $param_street, $param_city, $param_state, $param_zip);

                $param_street = $addr->street;
                $param_city   = $addr->city;
                $param_state  = $addr->state;
                $param_zip    = (string)$addr->zip;
            }
        }
    }


// old address code
    // /**
    //  * Checks to see if the address has errors in the syntax
    //  */
    // function buildAddress(string $try) {
    //     require_once "../models/address.php";
    //     GLOBAL $address_error;

    //     $params = explode(",", $try);

    //     try {
    //         return new Address($params[0], $params[1], $params[2], (int)$params[3]); 
    //     } catch (Exception $e) {
    //         $address_error = "The supplied address was in an invalid format. Correct format: STREET ADDRESS, CITY, STATE, ZIP_CODE";
    //         return null;
    //     }
    // }

    // /**
    //  * Adds the address to the database
    //  */
    // function addAddress(Address $addr) {
    //     GLOBAL $conn;

    //     $sql = "SELECT AddressID FROM Address WHERE Street = ? AND City = ? AND State = ? AND Zipcode = ?";

    //     if ($stmt = $conn->prepare($sql)) {
    //         $stmt->bind_param("ssss", $param_street, $param_city, $param_state, $param_zip);

    //         $param_street = $addr->street;
    //         $param_city = $addr->city;
    //         $param_state = $addr->state;
    //         $param_zip = (string)$addr->zip;

    //         if ($stmt->execute()) {
    //             $stmt->store_result();

    //             if ($stmt->num_rows == 1) {
    //                 $address_error = "A school at this address is already registered";
    //             }
    //         } else {
    //             $sql = "INSERT INTO Address VALUES (?, ?, ?, ?)";

    //             $stmt->close();
    //             if ($stmt = $conn->prepare($sql)) {
    //                 $stmt->bind_param("ssss", $param_street, $param_city, $param_state, $param_zip);

    //                 if ($stmt->execute()) {
    //                     $stmt->store_result();

    //                     $sql = "SELECT AddressID FROM Address WHERE Street = ? AND City = ? AND State = ? AND Zipcode = ?";

    //                     $stmt->close();
    //                     if ($stmt = $conn->prepare($sql)) {
    //                         $stmt->bind_param("ssss", $param_street, $param_city, $param_state, $param_zip);

    //                         $stmt->bind_param("ssss", $param_street, $param_city, $param_state, $param_zip);

    //                         if ($stmt->execute()) {
    //                             $stmt->store_result();

    //                             if ($stmt->num_rows == 1) {
    //                                 $id = $stmt->fetch()[0]['AddressID'];
    //                                 $stmt->close();

    //                                 return $id;
    //                             } else {
    //                                 $address_error = "Something went wrong, please try again...";
    //                             }
    //                         } else {
    //                             $address_error = "Something went wrong, please try again";
    //                         }
    //                     }
    //                 } else {
    //                     $address_error = "something went wrong, please try again!";
    //                 }
    //             }
    //         }
    //     }
    // }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link media="all" type="text/css" rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="wrapper">
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
            <div class="form-group">
                <label for="addr">Address:</label>
                <input type="text" name="addr"
                    class="form-control <?php echo (!empty($address_error)) ? 'is-invalid' : ''; if ($_SERVER["REQUEST_METHOD"] == "post" && empty($address_error)) echo 'is-valid' ?>"
                    value="<?php echo $address; ?>">
                <span class="invalid-feedback"><?php echo $address_error; ?></span>
                <input type="submit" value="Check Address">
            </div>
        </form>
    </div>
</body>
</html>