<?php

require_once("../includes/class.php");
//require_once 'db.php';
    //$connectionInfo = new inc_dataBase();
    //$connectionInfo->connect();
/*$newPlayer = new Player("Powell","Cory","kings","2011","23","male");
$newPlayer->setLName("GradKowski");
$newPlayer->setFName("George");
$newPlayer->setTeamName("Hawks");
$newPlayer->setGradyear("2012");
$newPlayer->setNumber("45");
$newPlayer->setGender("both");
//$newPlayer->addPlayer();
$newPlayer->removePlayer("34");*/ 
?>
 <html>
 <head>
 <title>Form Creator</title>
<link rel="stylesheet" type="text/css" href="../includes/admin.css" />
</head> 
<body align="center">
<div>                    
<?php

echo "<div>\n\t<form method=\"POST\" action=\"formProcess.php\">";
      $form = new Form();
      echo "<div>\n\t";
      $form->addText("First Name: ","fName","fNameId","First Name","25");
      echo "</div>\n<div>\n\t";
      $form->addText("Last Name: ","lName","lNameId","Last Name","25");
      echo "</div>\n<div>\n\t";
      $form->addText("Phone: ","phone","phoneId","###-###-####","25");
      echo "</div>\n<div>\n\t"; 
      $form->addText("Email: ","email","emailId","someone@example.com","25");         
      echo "</div>\n<div>\n\t";
      $form->addSelectTeam("Team: ","teamName");
      echo "</div>\n<div class=\"testdiv\">\n\t";
      $form->addButton("click Me");
      echo "</div>\n";
      $connectionInfo->disConnect();
echo "</div></div></body></html>"; 
?>