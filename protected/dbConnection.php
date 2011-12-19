<?php
class DbConnection
{
	protected function __construct($host,$username,$password,$dbName)
	{
		$dbConnection = new mysqli($host,$username,$password,$dbName);
		
		if( mysqli_connect_errno() ){
			die('Error: Database connection fail.');
			exit;
		}
		
		return $dbConnection;
	}

	/**
	 * This method is used to create a multi dimensional
	 * matrix when the sql result contains more than one row.
	 * @param array $arg array(mysqli->field_count, result)
	 */
	protected function fetch_row_array($arg)
    {
        $matrix = array();
        
        if( $arg[0] == 1 ){
            while( $row = $arg[1]->fetch_row() ){
                $matrix[] = $row[0];
            }
        }else{
            $i = 0;
            while( $row = $arg[1]->fetch_row() ){
                for($j=0; $j<$arg[0]; $j++){
                    $matrix[$i][$j] = $row[$j];
                }
                $i++;
            }
        }
        unset($row,$i,$j,$arg);
        
        return $matrix;
    }
}
?>