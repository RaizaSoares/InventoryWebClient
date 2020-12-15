<html>
   <head>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Search and Update Customer Records</title>
      <link rel="stylesheet" type="text/css" href="style.css">
   </head>
   
   <body class="bg5">
      <H2><CENTER>Search and Update Customer Information
	</CENTER></H2>
      <form METHOD="post" action="UpdateCustomers.php">
         
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
			//initialise id
         if (!isset($_POST['id']))
         {
            $id=0;
         }
         else
         {
            $id = $_POST['id'];
         }
		//left arrow button
		
	 if (isset($_POST['left']))
	{
	//fetches the record before the current record
   	$query = "SELECT CustomerID, FirstName, LastName FROM Customer WHERE CustomerID < $id ORDER BY CustomerID DESC";
   	$result = $mysqli->query($query);
   	$row = $result->fetch_row();
  	 if ($row[0] > 0)
   	{
       $id      = $row[0];
       $fname   = $row[1];
	   $lname   = $row[2];
       
    	}
	}
	//right arrow button
	elseif (isset($_POST['right']))
	{
	//fetches the record after the current record
   	$query = "SELECT CustomerID, FirstName, LastName FROM Customer WHERE CustomerID > $id ORDER BY CustomerID ASC";
  	 $result = $mysqli->query($query);
   	$row = $result->fetch_row();
   	if ($row[0] > 0)
   	{
      	 $id      = $row[0];
       	 $fname   = $row[1];
	 $lname   = $row[2];
       
    	}
}
	//search button
         elseif (isset($_POST['search']))
         {
            //performs a search with the Customer ID entered
			//prepared statement prevents SQL injection
            $stmt1 = $mysqli->prepare("SELECT CustomerID, FirstName, LastName FROM Customer WHERE CustomerID = ?");
            $stmt1->bind_param("i", $id);
            $stmt1->execute();
            $stmt1->bind_result($ident, $first, $last);
            $stmt1->fetch();
            //if any one of the parameters is fetched, the other two exist as well
			if($first)
			{
				$id      = $ident;
               $fname   = $first;
               $lname   = $last;
		
			}
            
            $stmt1->close();
         }
		 //add button
         elseif (isset($_POST['add']))
         {
			 //performs the addition of a new record.
			 //New Customer ID along with first and last name can be added to the Customer table.
			 
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            //prepared statement prevents SQL injection.
            $stmt2 = $mysqli->prepare("INSERT INTO Customer (CustomerID, FirstName, LastName) VALUES(?,?,?)");
            $stmt2->bind_param("iss", $id, $fname, $lname);
            $stmt2->execute();
            $stmt2->bind_result($result);
            $stmt2->close();
            

            $message = "*****Record added*****";
         }
		 //delete button
         elseif (isset($_POST['delete']))
         {
            //performs the deletion of an entire record based on Customer ID
			//prepared statement prevents SQL injection.
            $stmt3 = $mysqli->prepare("DELETE FROM Customer WHERE CustomerID = ?");
            $stmt3->bind_param("i", $id);
            $stmt3->execute();
            $stmt3->bind_result($result);
            $stmt3->close();
            
            $message = "*****Record deleted*****";
         }
		 //update button
		 
         elseif (isset($_POST['update']))
         {
			 //after the user enters a valid Customer ID, they can update the record
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            //prepared statement prevents SQL injection

            $stmt4 = $mysqli->prepare("UPDATE Customer SET FirstName='$fname', LastName='$lname' WHERE CustomerID = ?");
            $stmt4->bind_param("i", $id);
            $stmt4->execute();
            $stmt4->bind_result($result);
            $stmt4->close();
            
            $message = "*****Record updated*****";
         }

         $id = trim($id);
         $fname = trim($fname);
         $lname = trim($lname);


         $mysqli->close();

         ?>
         
            <br> Customer ID:
            <br><INPUT TYPE="TEXT" NAME="id"
               <?php echo "VALUE=\"$id\"" ?>>
            <br>
            <br> First Name:
            <br><INPUT TYPE="TEXT" NAME="fname"
               <?php echo "VALUE=\"$fname\"" ?>>
            <br>
            <br> Last Name:
            <br><INPUT TYPE="TEXT" NAME="lname"
               <?php echo "VALUE=\"$lname\"" ?>>
            <br>
            
            <br>
		
	   <INPUT TYPE="SUBMIT" NAME="left"     VALUE="<">
	   <INPUT TYPE="SUBMIT" NAME="right"     VALUE=">">
            <INPUT TYPE="SUBMIT" NAME="search"     VALUE="Search">

            <br>
            <br>
            <INPUT TYPE="SUBMIT" NAME="add"     VALUE="Add">
            <INPUT TYPE="SUBMIT" NAME="update"     VALUE="Update">
            <INPUT TYPE="SUBMIT" NAME="delete"     VALUE="Delete">

            <?php
            if (isset($_POST['message']))
            {
               echo "<BR><BR>$message";
            }

            ?>
            <br>

         <br>
         <a href = store.html class="btn txt">Home</a>
         
      </form>
   </body>
</html>
