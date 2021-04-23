<?php
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