<html>
<body>
    <form action="./tests.php" method="post">
    <!-- this is the student name and identification -->
        <label for="studentid">Student ID:</label>
            <input type="text" name="studentid" id="studentid">
        <label for="firstname">First Name:</label>
            <input type="text" name="fname" id="fname">
        <label for="middlename">Middle Name:</label>
            <input type="text" name="mname" id="mname">
        <label for="lastname">Last Name:</label>
            <input type="text" name="lname" id="lname">
    <br>
    <!-- this is the radio buttons for gender -->
        <label for="gender">Gender: </label>
            <input type="radio" name="gender" id="male" class="gender" value="M">
                <label for="Male">Male</label>
            <input type="radio" name="gender" id="female" class="gender" value="F">
                <label for="gender">Famale</label>
            <input type="radio" name="gender" id="other" class="gender" value="OTH">
                <label for="gender">Other</label>
    <br>
    <!-- this is the date input -->
        <label for="birthday">Birthdate: </label>
            <input type="date" name="Date" id="Date">
    <br>
    <!-- these would be the contact information -->
        <label for="phonenumber">Phone number: </label>
            <input type="text" name="phonenumber" id="phonenumber">
        <label for="email"> Email: </label>
            <input type="text" name="email" id="Email">
    <br>
    <!-- these would be the grade level and if they are enrolled or not -->
        <label for="gradeLevel">Grade Level</label>
            <input type="number" name="number" id="number">
        <label for="enrolled">Are you Fully Enrolled:</label>
            <input type="radio" name="enrolled" id="true" class="enrolled" value="1">
                <label for="yes">YES</label>
            <input type="radio" name="enrolled" id="false" class="enrolled" value="0">
                <label for="False">NO</label>
    <br>
        <input type="submit" value="submit">
    </form>



    
    <?PHP
        $server = "localhost";
        $user = "root";
        $pass = "";
        $db = "test";

        $conn = new mysqli($server, $user, $pass, $db);
        function addStudent(){
            global $conn;
            $sql = strtr('INSERT INTO Student(StudentID, Firstname, Middlename, Lastname, Gender, Birthdate, Phonenumber, Email, AddressID, GradeLevel, isFullyEnrolled)
                values ("%StudentID","fname","mname","lname","gender","bday","pnumber","email","addressid","gradelevel","enrolled");',[
                "%StudentID" => $_POST["studentid"], "fname" => $_POST["fname"], "mname" => $_POST["mname"], "lname" => $_POST["lname"],
                "gender" => $_POST["gender"], "bday" => $_POST["Date"], "pnumber" => $_POST["phonenumber"], "email" => $_POST["email"],
                "gradelevel" => $_POST["number"], "enrolled" => $_POST["enrolled"]
            ]);
            $conn->query($sql);
        }
        if (isset($_POST["fname"])) addStudent();
    ?>
</body>
</html>