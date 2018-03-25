
<?php
include("manager.php"); 
 
  class SuperManager extends Manager
  {
     
    function changepwd($password)
    {
      $this->password=$password;
      include("conn.php");
      mysqli_query($conn,"UPDATE administrator SET password='".$this->password."'WHERE id='".$this->managerid."'");
      mysqli_close($con);
    }
    }
 
?>