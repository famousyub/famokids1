<?PHP
//ini_set('memory_limit', '100M');




/*

require_once 'config.php';

class Connection
{
	public static function make($host, $db, $user, $password)
	{
		$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

		try {
			$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

			return new PDO($dsn, $username, $password, $options);
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}
}

return Connection::make($host, $db, $user, $password);







*/

$pdo = require 'Connection.php';
class Database
{


    private $db_host = '';
    private $db_user = '';
    private $db_pass = '';
    private $db_name = '';


    private $con = false;               // Checks to see if the connection is active
    private $result = array();          // Results that are returned from the query



    /*
     * Connects to the database, only one connection
     * allowed
     */
    public function connect()
    {
        if(!$this->con)
        {
           $dsn = "mysql:host=$this->db_host;dbname=$this->db_name;charset=UTF8";
          //  $myconn = @mysql_connect($this->db_host,$this->db_user,$this->db_pass);

            try {
              $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
             $myconn  = new PDO($dsn, $this->db_user, $this->db_pass,$options);

            	if ( $myconn ) {
            		echo "Connected to the $this->db_name database successfully!";
                $this->con = true;
                return  true;
            	}

              else {
                return false;
              }
            } catch (PDOException $e) {
            	echo $e->getMessage();

              return  false;

              //die();
            }



          /*  if($myconn)
            {
                $seldb = @mysql_select_db($this->db_name,$myconn);
                if($seldb)
                {
                    $this->con = true;
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
        else
        {
            return true;
        }
    }
*/
    /*
    * Changes the new database, sets all current results
    * to null
    */
    public function setDatabase($name)
    {
        if($this->con)
        {
            if($pdo)
            {
                $this->con = false;
                $this->results = null;
                $this->db_name = $name;
                $this->connect();
            }
        }

    }

    /*
    * Checks to see if the table exists when performing
    * queries
    */
    private function tableExists($table)
    {
        $tablesInDb = $pdo->query('SHOW TABLES FROM '.$this->db_name.' LIKE "'.$table.'"');


        if($tablesInDb)
        {

            $count = $tablesInDb->fetchColumn();
            if($count==1)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }

    /*
    * Selects information from the database.
    * Required: table (the name of the table)
    * Optional: rows (the columns requested, separated by commas)
    *           where (column = value as a string)
    *           order (column DIRECTION as a string)
    */
    public function select($table, $rows = '*', $where = null, $order = null, $group = null, $limit = null)
    {
        $q = 'SELECT '.$rows.' FROM '.$table;
        if($where != null)
            $q .= ' WHERE '.$where;
        if($order != null)
            $q .= ' ORDER BY '.$order;
		if($group != null)
            $q .= ' GROUP BY '.$group;
		if($limit != null)
			$q .= ' LIMIT '.$limit;

		//echo $q;

		$q=strip_tags($q);							//prevent html
		//$q=mysql_real_escape_string($q);			//prevent hacks

        $query = $pdo->query($q);

        if($query)
        {
            $this->numResults = $query->fetchColumn();

			//echo $this->numResults;
            for($i = 0; $i < $this->numResults; $i++)
            {
                $r = $query->fetchAll(PDO::FETCH_ASSOC);
                //mysql_fetch_array($query);
                $key = array_keys($r);
                for($x = 0; $x < count($key); $x++)
                {
                    // Sanitizes keys so only alphavalues are allowed
                    if(!is_int($key[$x]))
                    {
                        if($query->fetchColumn() > 1)
                            $this->result[$i][$key[$x]] = $r[$key[$x]];
                        else if($query->fetchColumn() < 1)
                            $this->result = null;
                        else
                            $this->result[$key[$x]] = $r[$key[$x]];
                    }
                }
            }
			$totalrowsq = $pdo->query("SELECT FOUND_ROWS() as mycount");
			$totalrows=$totalrowsq->fetchColumn();
			$this->totalrows=$totalrows['mycount'];
            return true;
        }
        else
        {
            return false;
        }
    }

	public function query($q)
    {

		//echo $q;
		$q=strip_tags($q);							//prevent html
		//$q=mysql_real_escape_string($q);			//prevent hacks

        $query = $pdo->query($q);
        // or die(mysql_error());

		//echo @mysql_error($q);

		if(stristr(strtolower($q),"insert into")&&stristr(strtolower($q),"profileupdates"))
		return TRUE;

		if(
			(!stristr(strtolower($q),"profileupdates")&&(
			stristr(strtolower($q),"insert ")||stristr(strtolower($q),"update ")||stristr(strtolower($q),"delete "))

		)){
			if($query)
				return TRUE;
			else
				return FALSE;
		}else if($query)
        {
            $this->numResults = $query->fetchColumn();
            for($i = 0; $i < $this->numResults; $i++)
            {
                $r = $query->fetchAll(PDO::FETCH_ASSOC);
                $key = array_keys($r);
                for($x = 0; $x < count($key); $x++)
                {
                    // Sanitizes keys so only alphavalues are allowed
                    if(!is_int($key[$x]))
                    {
                        if($query->fetchColumn()) > 1)
                            $this->result[$i][$key[$x]] = $r[$key[$x]];
                        else if($query->fetchColumn() < 1)
                            $this->result = null;
                        else
                            $this->result[$key[$x]] = $r[$key[$x]];
                    }
                }
            }
		$totalrowsq = $pdo->query("SELECT FOUND_ROWS() as mycount");
		$totalrows=$totalrowsq->fetchAll(PDO::FETCH_ASSOC);
		$this->totalrows=$totalrows['mycount'];
            return true;
        }
        else
        {
            return false;
        }
    }

//mysql_insert_id()
	public function getinsertedrow(){
		return($pdo->lastInsertId());
	}




    /*
    * Insert values into the table
    * Required: table (the name of the table)
    *           values (the values to be inserted)
    * Optional: rows (if values don't match the number of rows)
    */



    public function insert($table,$values,$rows = null)
    {
        if($this->tableExists($table))
        {
            $insert = 'INSERT INTO '.$table;
            if($rows != null)
            {
                $insert .= ' ('.$rows.')';
            }

            for($i = 0; $i < count($values); $i++)
            {
                if(is_string($values[$i]))
                    $values[$i] = '"'.$values[$i].'"';
            }
            $values = implode(',',$values);
            $insert .= ' VALUES ('.$values.')';

			$insert=strip_tags($insert);							//prevent html
			//$insert=mysql_real_escape_string($insert);			//prevent hacks

            $ins =  $pdo->query($insert);

            if($ins)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }


	public function repinto($table,$values,$rows = null)
    {
        if($this->tableExists($table))
        {
            $insert = 'REPLACE INTO '.$table;
            if($rows != null)
            {
                $insert .= ' ('.$rows.')';
            }

            for($i = 0; $i < count($values); $i++)
            {
                if(is_string($values[$i]))
                    $values[$i] = '"'.$values[$i].'"';
            }
            $values = implode(',',$values);
            $insert .= ' VALUES ('.$values.')';

			$insert=strip_tags($insert);							//prevent html
			//$insert=mysql_real_escape_string($insert);			//prevent hacks

            $ins =  $pdo->query($insert);

            if($ins)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }

    /*
    * Deletes table or records where condition is true
    * Required: table (the name of the table)
    * Optional: where (condition [column =  value])
    */
    public function delete($table,$where = null)
    {
        if($this->tableExists($table))
        {
            if($where == null)
            {
                $delete = 'DELETE '.$table;
            }
            else
            {
                $delete = 'DELETE FROM '.$table.' WHERE '.$where;
            }

			$delete=strip_tags($delete);							//prevent html
			//$delete=mysql_real_escape_string($delete);			//prevent hacks

            $del =  $pdo->query($delete);

            if($del)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    /*
     * Updates the database with the values sent
     * Required: table (the name of the table to be updated
     *           rows (the rows/values in a key/value array
     *           where (the row/condition in an array (row,condition) )
     */
    public function update($table,$rows,$where)
    {
        if($this->tableExists($table))
        {
            // Parse the where values
            // even values (including 0) contain the where rows
            // odd values contain the clauses for the row
            for($i = 0; $i < count($where); $i++)
            {
                if($i%2 != 0)
                {
                    if(is_string($where[$i]))
                    {
                        if(($i+1) != null)
                            $where[$i] = '"'.$where[$i].'" AND ';
                        else
                            $where[$i] = '"'.$where[$i].'"';
                    }
                }
            }
            $where = implode('',$where);


            $update = 'UPDATE '.$table.' SET ';
            $keys = array_keys($rows);
            for($i = 0; $i < count($rows); $i++)
            {
                if(is_string($rows[$keys[$i]]))
                {
                    $update .= $keys[$i].'="'.$rows[$keys[$i]].'"';
                }
                else
                {
                    $update .= $keys[$i].'='.$rows[$keys[$i]];
                }

                // Parse to add commas
                if($i != count($rows)-1)
                {
                    $update .= ',';
                }
            }
			if(strlen($where[0])>0)
				$update .= ' WHERE '.$where;

				//echo $update;

			$query=strip_tags($query);							//prevent html
			//$query=mysql_real_escape_string($query);			//prevent hacks

            $query =  $pdo->query($update);

            if($query)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    /*
    * Returns the result set
    */
    public function getResult()
    {
        return $this->result;
    }

	public function clearResult(){
		$this->result=null;
		return(true);
	}


	public function getTotalRows(){
		return $this->totalrows;
	}
}





?>
