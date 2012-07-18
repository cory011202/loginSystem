<?php
require_once("../includes/class.php");
?>
 <html>
 <head>
 <title>New User Signup</title>
<link rel="stylesheet" type="text/css" href="../includes/admin.css" />
</head> 
<body>
<div id="wrapper">
<?php
echo "<div>\n\t<form method=\"POST\" action=\"newUserFormProcess.php\">";
      $form = new Form();
      echo "\n</div>\n<div>\n\t";
      $form->addText("First Name: ","fName","fNameId","First Name","25");
      echo "\n</div>\n<div>\n\t";
      $form->addText("Last Name: ","lName","lNameId","Last Name","25");
      echo "\n</div>\n<div>\n\t";
      $form->addText("Email: ","email","emailId","someone@example.com","25");         
      echo "\n</div>\n<div>\n\t";
      $form->addText("Conf Email: ","confEmail","confEmailId","someone@example.com","25");
      echo "\n</div>\n<div class=\"testdiv\">\n\t";
      $form->addSubmitButton("click Me");
      $form->addClearButton("Clear");
      echo "\n</div></form>\n";
echo "</div>\n</body></html>";
?>