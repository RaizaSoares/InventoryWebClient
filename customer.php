<HTML>
<HEAD>
<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Customers</title>
        <link rel="stylesheet" type="text/css" href="style.css">
</HEAD>
<BODY class="bg3">
<H2><CENTER>Customers</CENTER></H2>
<HR height=8>
<P>

<?php

$host="services1.cse.sdsmt.edu"; //hostname URL
$port=3306;						//default port 3306
$user="s_7505038_s20";					//DBMS login username
$password="raiza16";				//DBMS login password
$dbname="db_7505038_s20";		//Select DB  


/* Connect to MySQL */
$mysqli = new mysqli($host, $user, $password, $dbname, $port);


/* Check connection error*/
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}


/* Access the Customer table */
$result = $mysqli->query("Select * from Customer"); 

?>
<div class= "cl">
<TABLE style="font-size:150%; background-color: LightGray;"
border="1">
<TR>

<?php
/* Fetch and display the attribute names */
while ($field=$result->fetch_field())
{
   echo "<TH>";
   echo "$field->name";
   echo "</TH>";
}
echo "</TR>";

/* Fetch and displays each row of $result */ 
if($result)
   while($row=$result->fetch_row())
   {
      echo "<TR>";
      for ($i=0; $i < $result->field_count; $i++)
      {
         echo "<TD> $row[$i] </TD>";
      }
      echo "</TR>\n";
   }

$result->close();
$mysqli->close();
?>

</TABLE>
</div>
<BR>
<BR>
<a href=store.html class="btn txt"> Home</a>

</BODY>
</HTML>
