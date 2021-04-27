<html>
<body>
    <form action="enrollment.php" method="POST">
    <label for="enrolled"> Are You Enrolled?: </label>
    <input type="radio" name="enrolled" id="enrolled" value="1">
    <label for="enrolled"> Yes </label>
    <input type="radio" name="enrolled" id="enrolled" value="0">
    <label for="enrolled"> No </label>
    <br>
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
    $sql = strtr('INSERT INTO classenrollment values ("enrolled", "67536", "12");',[
        "enrolled" => $_POST['enrolled']
    ]);
    $conn->query($sql);
    ?>