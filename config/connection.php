<?php 
require_once "global.php";

$connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
mysqli_query($connection, 'SET NAMES "'.DB_ENCODE.'"');

if (mysqli_connect_errno())
{
    printf("Failed to connect to the database: %s\n", mysqli_connect_error());
    exit();
}

if (!function_exists('executeQuery'))
{
    function executeQuery($sql)
    {
        global $connection;
        $query = $connection->query($sql);
        return $query;
    }

    function executeSequentialQuery($sql)
    {
        global $connection;
        $query = $connection->multi_query($sql);
        return $query;
    }

    function executeUpdate2($sql)
    {
        global $connection;
        if (!mysqli_query($connection, $sql)) {
            return("Error description: " . mysqli_error($connection));
        } else {
            return mysqli_affected_rows($connection);
        }
    }

    function executeCount($sql)
    {
        global $connection;
        $query = $connection->query($sql);
        return $query;
    }

    function executeUpdate($sql)
    {
        global $connection;
        $query = $connection->query($sql);
    
        if (!mysqli_query($connection, $sql)) {
            return("Error description: " . mysqli_error($connection));
        } else {
            return $query;
        }
    }
    
    function executeSimpleRowQuery($sql)
    {
        global $connection;
        $query = $connection->query($sql);        
        $row = $query->fetch_assoc();
        return $row;
    }

    function executeQueryReturnID($sql)
    {
        global $connection;
        $query = $connection->query($sql);        
        return $connection->insert_id;            
    }
    
    function cleanString($str)
    {
        global $connection;
        $str = mysqli_real_escape_string($connection, trim($str));
        return htmlspecialchars($str);
    }
}
?>
