<html>
<body>
    <form action="./studentcontact.php" method="POST">
        <label for="studentid">Student ID:</label>
        <input type="number" name="StudentID" id="studentID">
        <label for="Name">Name:</label>
        <input type="text" name="Name" id="Name">
        <label for="Relationship">Relationship: </label>
        <input type="text" name="Relationship" id="Relationship">
        <label for="Phonenumber">Phone Number: </label>
        <input type="text" name="Phonenumber" id="Phonenumber">
        <input type="submit" value="submit">
    </form>
</body>
</html>
<?PHP
$server = "localhost";
$user = "root";
$pass = "";
$db = "test";

$conn = new mysqli($server, $user, $pass, $db);
    function addStudent(){
        global $conn;
        $sql = strtr('INSERT INTO Student(StudentID, Firstname, MiddleName, LastName, Gender, Birthdate, Phonenumber, Email, addressID, GradeLevel, isFullyEnrolled)
            values ("%StudentID","fname","mname","lname","gender","bday","pnumber","email","addressid","gradelevel","enrolled");',[
            "%StudentID" => $_POST["studentid"], "fname" => $_POST["fname"], "mname" => $_POST["mname"], "lname" => $_POST["lname"],
            "gender" => $_POST["gender"], "bday" => $_POST["Date"], "pnumber" => $_POST["Phonenumber"], "email" => $_POST["email"],
            "gradelevel" => $_POST["number"], "enrolled" => $_POST["enrolled"]
        ]);
        $conn->query($sql);
    }
    if (isset($_POST["fname"])) addStudent();
    function add(){
        global $conn;
        $sql = strtr("INSERT INTO studentcontact(studentID,name,relationship,Phonenumber) values ('%StudentID','%Name','%Relationship','%Phonenumber');",
        ['%StudentID' => $_POST['StudentID'], '%Name' => $_POST['Name'], '%Relationship' => $_POST['Relationship'], '%Phonenumber' => $_POST['Phonenumber']]);
        $conn->query($sql);
    }
    if (isset($_POST['Name'])) add();

?>