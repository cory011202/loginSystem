<html>
<head>
<title>New User Signup</title>
<link rel="stylesheet" type="text/css" href="includes/style/general.css" />

</head> 
<body>
    <div id="stylized" class="myform">
        <form id="form" name="form" method="POST" action="newUserFormProcess.php">
            <h1>Sign-up form</h1>

            <label>
                Username:
                <span class="small">Add your username</span>
            </label>
            <input type="text" name="userName" id="userNameId" />

            <label>
                First Name:
                <span class="small">Add your first name</span>
            </label>
            <input type="text" name="fName" id="fNameId" />

            <label>
                Last Name:
                <span class="small">Add your last name</span>
            </label>
            <input type="text" name="lName" id="lNameId" />

            <label>
                Email:
                <span class="small">Add a valid address</span>
            </label>
            <input type="text" name="email" id="emailId" />

            <label>
                Conf Email:
                <span class="small">Confirm Email address</span>
            </label>
            <input type="text" name="confEmail" id="confEmailId" />

            <label>
                Password:
                <span class="small">Enter password</span>
            </label>
            <input type="password" name="password" id="password" />

            <label>
                Conf Password:
                <span class="small">Confirm password</span>
            </label>
            <input type="password" name="confPassword" id="confPassword" />

            <button type="submit">Sign-up</button>
            <div class="spacer"></div>
        </form>
    </div>
</body>
</html>
