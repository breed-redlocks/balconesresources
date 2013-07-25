<?php
include "db.inc";

class Default_Table
{
  var $tablename;         // table name
  var $dbname;            // database name
  var $rows_per_page;     // used in pagination
  var $pageno;            // current page number
  var $lastpage;          // highest page number
  var $fieldlist;         // list of fields in this table
  var $data_array;        // data from the database
  var $errors;            // array of error messages
  var $sql_orderby;
  var $sql_orderby_seq;


	function Default_Table ($table)
	{
    $this->tablename       = 'default';
    $this->dbname          = 'brdevdb';
   // $this->rows_per_page   = 10;
   // $this->orderby			= 'id';
    
    $this->fieldlist = array('column1', 'column2', 'column3');
    $this->fieldlist['column1'] = array('pkey' => 'y');

 	} // constructor
 	 // ****************************************************************************
    function setPageNo ($pageno='1')
    // this allows a particular page number to be selected (see getData)
    {
        $this->pageno = (int)$pageno;

    } // setPageNo

    // ****************************************************************************
     // ****************************************************************************
    function setRowsPerPage ($rows_per_page)
    // this allows the default value to be changed
    {
        if ($rows_per_page > 0) {
            $this->rows_per_page = (int)$rows_per_page;
        } // if

    } // setRowsPerPage

    // ****************************************************************************
    // ****************************************************************************
    function setOrderBy ($sql_orderby)
    // this allows a sort order to be specified (see getData)
    {
        $this->sql_orderby = trim($sql_orderby);

    } // setOrderBy
    // ****************************************************************************
    // ****************************************************************************
    function setOrderBySeq ($sql_orderby_seq)
    // this allows a sort sequence ('asc' or 'desc') to be set (see getData)
    {
        $this->sql_orderby_seq = trim($sql_orderby_seq);

    } // setOrderBySeq

    // ****************************************************************************
     // ****************************************************************************
    function getCount ($where)
    // get count of records that satisfy selection criteria in $where.
    {
        $this->errors = array();

        // connect to database
        global $dbconnect, $query;
      	$dbconnect = db_connect($this->dbname) or trigger_error("SQL", E_USER_ERROR);

        if (preg_match('/^(select )/i', $where)) {
            // $where starts with 'SELECT' so use it as a complete query
            $this->query = $where;
        } else {
            // does not start with 'SELECT' so it must be a 'where' clause
            if (empty($where)) {
            	$this->query = "SELECT SQL_CALC_FOUND_ROWS * FROM $this->tablename LIMIT 1";
            } else {
                $where = $where;
                $this->query = "SELECT SQL_CALC_FOUND_ROWS * FROM $this->tablename WHERE $where";
            } // if
        } // if

        $result = mysql_query($this->query, $dbconnect) or trigger_error("SQL", E_USER_ERROR);

        if (preg_match("/SQL_CALC_FOUND_ROWS /i", $this->query) == true) {
        	$result     = mysql_query('SELECT FOUND_ROWS()', $dbconnect) or trigger_error("SQL", E_USER_ERROR);
            $found_rows = mysql_fetch_row($result);
            $count      = $found_rows[0];
        } else {
            // if 'GROUP BY' was used then return the number of rows
            // (ignore GROUP BY if it is in a subselect)
            if (preg_match("/group by /i", $this->query) == true AND !preg_match("/\(.+group by.+\)/i", $this->query)) {
                $count = mysql_num_rows($result);
            } else {
                $query_data = mysql_fetch_row($result);
                $count = $query_data[0];
            } // if
        } // if

        // write query to log file, if option is turned on
//        logSqlQuery ($dbname, $tablename, $this->query, $count);
        $this->query = '';

        return $count;

    } // getCount

    // ****************************************************************************


    // JUST ASK TO THE DATABASE
 	function getResults ($query)
  	{
 	  $this->data_array = array();
 	  
	  if (empty($query)) {
	     return;
      } 
           
      global $dbconnect;
      
      $dbconnect = db_connect($this->dbname) or trigger_error("SQL", E_USER_ERROR);
      
      $result = mysql_query($query, $dbconnect) or trigger_error("SQL", E_USER_ERROR);
      
      while ($row = mysql_fetch_assoc($result)) {
         $this->data_array[] = $row;
      } // while

      mysql_free_result($result);
   
      return $this->data_array;
     }   
    
    

	function getData ($where)
  	{
      $this->data_array = array();
      $pageno          = $this->pageno;
      $rows_per_page   = $this->rows_per_page;
      $this->numrows   = 0;
      $this->lastpage  = 0;
      $order			= $this->orderby;
      
      global $dbconnect, $query;
      $dbconnect = db_connect($this->dbname) or trigger_error("SQL", E_USER_ERROR);

	if (empty($where)) {
         $where_str = NULL;
      } else {
         $where_str = "WHERE $where";
      } // if
      
      $query = "SELECT count(*) FROM $this->tablename $where_str ORDER BY id DESC";
      $result = mysql_query($query, $dbconnect) or trigger_error("SQL", E_USER_ERROR);
      $query_data = mysql_fetch_row($result);
      $this->numrows = $query_data[0];

	if ($this->numrows <= 0) {
         $this->pageno = 0;
         return;
      } // if
      
      	if ($rows_per_page > 0) {
         $this->lastpage = ceil($this->numrows/$rows_per_page);
      } else {
         $this->lastpage = 1;
      } // if
      
      // incorporate optional sort order
    if (!empty($this->sql_orderby)) {
            $sort_str = "\n" ."ORDER BY $this->sql_orderby $this->sql_orderby_seq";
     } else {
            $sort_str = '';
     } // if
      
      	if ($rows_per_page > 0) {
         $this->lastpage = ceil($this->numrows/$rows_per_page);
      } else {
         $this->lastpage = 1;
      } // if

	if ($pageno == '' OR $pageno <= '1') {
         $pageno = 1;
      } elseif ($pageno > $this->lastpage) {
         $pageno = $this->lastpage;
      } // if
      $this->pageno = $pageno;
      
      	if ($rows_per_page > 0) {
         $limit_str = 'LIMIT ' .($pageno - 1) * $rows_per_page .',' .$rows_per_page;
      } else {
         $limit_str = NULL;
      } // if

	$query = "SELECT * FROM $this->tablename $where_str $sort_str $limit_str";
	//echo "<br>SELECT QUERY - " . $query . "<br>";
      $result = mysql_query($query, $dbconnect) or trigger_error("SQL", E_USER_ERROR);
      
      while ($row = mysql_fetch_assoc($result)) {
         $this->data_array[] = $row;
      } // while

      mysql_free_result($result);
   
      return $this->data_array;
     
} // getData



   function insertRecord ($fieldarray)
   {
      $this->errors = array();
            global $dbconnect, $query;
      $dbconnect = db_connect($this->dbname) or trigger_error("SQL", E_USER_ERROR);
      $fieldlist = $this->fieldlist;
      foreach ($fieldarray as $field => $fieldvalue) {
         if (!in_array($field, $fieldlist)) {
            unset ($fieldarray[$field]);
         } // if
      } // foreach

      $query = "INSERT INTO $this->tablename SET ";

      foreach ($fieldarray as $item => $value) {
         $query .= "$item='$value', ";
      } // foreach
      $query = rtrim($query, ', ');
 $result = @mysql_query($query, $dbconnect);
       $lastId = mysql_insert_id();
      if (mysql_errno() <> 0) {
         if (mysql_errno() == 1062) {
            $this->errors[] = "A record already exists with this ID.";
         } else {
            trigger_error("SQL", E_USER_ERROR);
         } // if
      } // if
     // echo $query;
      return $lastId;
   	   
   } // insertRecord
   
   function updateRecord ($fieldarray)
   {
      $this->errors = array();
		global $dbconnect, $query;
      	$dbconnect = db_connect($this->dbname) or trigger_error("SQL", E_USER_ERROR);
      	 $fieldlist = $this->fieldlist;
      foreach ($fieldarray as $field => $fieldvalue) {
         if (!in_array($field, $fieldlist)) {
            unset ($fieldarray[$field]);
         } // if
      } // foreach
 		$where  = NULL;
      	$update = NULL;
      	foreach ($fieldarray as $item => $value) {
         if (isset($fieldlist[$item]['pkey'])) {
            $where .= "$item='$value' AND ";
         } else {
            $update .= "$item='$value', ";
         } // if
      	} // foreach
      	$where  = rtrim($where, ' AND ');
      	$update = rtrim($update, ', ');
		$query = "UPDATE $this->tablename SET $update WHERE $where";
		//echo $query;
      	$result = mysql_query($query, $dbconnect) or trigger_error("SQL", E_USER_ERROR);
      
      return;
      
   } // updateRecord




 function deleteRecord ($fieldarray)
   {
      $this->errors = array();
      global $dbconnect, $query;
      $dbconnect = db_connect($this->dbname) or trigger_error("SQL", E_USER_ERROR);
      $fieldlist = $this->fieldlist;
      $where  = NULL;
      foreach ($fieldarray as $item => $value) {
         if (isset($fieldlist[$item]['pkey'])) {
            $where .= "$item='$value' AND ";
         } // if
      } // foreach
      $where  = rtrim($where, ' AND ');
      $query = "DELETE FROM $this->tablename WHERE $where";
      $result = mysql_query($query, $dbconnect) or trigger_error("SQL", E_USER_ERROR);
      
      return $where;
      
   } // deleteRecord


}
?>