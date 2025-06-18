<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">

    <script>
        function toggleStudentFields() {
            const role = document.getElementById("choose").value;
            const studentFields = document.getElementById("studentFields");
            studentFields.style.display = role === "student" ? "block" : "none";
        }

        window.onload = function() {
            document.getElementById("choose").addEventListener("change", toggleStudentFields);
            toggleStudentFields();
        };
    </script>
 
</head>
<body>
    <div class="container">
        <h2>Choosing Combination</h2>
        <form method="post" action="database.php">
           
            <input type="text" name="username" placeholder="Enter Username" required><br><br>
            <input type="email" name="email" placeholder="Enter Email" required><br><br>
            <input type="password" name="password" placeholder="Enter Password" required><br><br>
            <input type="file"  name="post" placeholder="Upload Photo of yours" required><br><br>
         


        
            <label for="choose">Select Role:</label><br>
            <select id="choose" name="choose">
                <option value="admin">Admin</option>
                <option value="student">Student</option>
            </select><br><br>

           
            <div id="studentFields">
                <input type="number" name="progress" max="100" min="0"  placeholder="Progress"><br><br>

                <label for="combination">Choose Combination</label><br>
                <select id="combination" name="combination">
                    <option value="MPC">Mathematics, Physics, and Computer Science</option>
                    <option value="MCE">Mathematics, Economics, and Computer Sciences</option>
                    <option value="MEG">Mathematics, Economics, and Geography</option>
                    <option value="HGL">History, Geography, and Literature</option>
                    <option value="PCB">Physics, Chemistry, and Biology</option>
                </select><br><br>
            </div>
            <input type="radio" name="gender" value="male"> Male<br>
            <input type="radio" name="gender" value="female"> Female<br>
            <input type="radio" name="gender" value="other"> Other<br><br>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="admin-login.php">Login here</a></p>
    </div>
</body>
</html>
