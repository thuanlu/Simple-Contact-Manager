<?php
class config
{
    private function connect()
    {
        $con = mysqli_connect("localhost", "admin", "123456", "simplecontactmanager");
        if (!$con) 
        {
            die("Loi ket noi: " . mysqli_connect_error());
        }
        else
        {
            mysqli_query($con, "SET NAMES 'utf8'");
            return $con;
        }
    }

    public function getConnection()
    {
        return $this->connect();
    }
}




?>