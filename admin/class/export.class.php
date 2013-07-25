<?php
require_once 'database.class.inc';
require_once 'users.class.inc';

class Export extends Default_Table {

function Pages () {
        //$this->tablename      	= 'pages';
        $this->dbname          	= 'brdevdb';
        $this->rows_per_page   	= 15;
        $this->fieldlist       	= array(	'id', 'title', 'link', 'body');
        $this->fieldlist['id'] 	= array('pkey' => 'y');
       	//$this->sql_orderby = 'sortBy';
  		//$this->sql_orderby_seq = "DESC";
        $this->pageItems		= Default_Table::getData();
				
    } // end class constructor

 // HANDLE ERRORS 
    function getErrors() {
    	echo errorHandler();
    }

function getHtml($component,$sort) {
	$this->tablename      	= $component;
	$this->sql_orderby = "sortBy";
  	$this->sql_orderby_seq = "DESC";
  	$data = Default_Table::getData();
  	
  	if ($_POST['process']) {
  		//header("Content-disposition: attachment; filename=spreadsheet.xls");
  		//print_r($data);
  		//foreach ($data as $record) {
  			//$theHtml .= $record['id'].', '.$record['name']."\n";
  		//}
  		
  	} else {
  		$theHtml .= '<form id="admin" name="user" method="post" acton="?&amp;action=edit" enctype="multipart/form-data">
						<input type="hidden" value="1" name="process">
						<fieldset>
						<legend>Export</legend>
							<ol>
								<li><label for="date">Statring Date: </label> 
									<input id="datepicker" type="text" value="" name="startDate">
								</li>
								<li><label for="date">End Date: </label> 
									<input id="datepicker2" type="text" value="" name="endDate">
								</li>
							</ol>
						</fieldset>
  						<fieldset>
							<button type="submit">Submit</button>
						</fieldset>
					</form>';
  	}
  	
  	return $theHtml;
}

	function returnData() {
		$this->tablename      	= 'contact';
		$this->sql_orderby = "sortBy";
  		$this->sql_orderby_seq = "DESC";
  		$where = 'postDate >= "'.$_POST['startDate'].'" AND postDate <= "'.$_POST['endDate'].'"';
  		//$where = 'date = "'.$_POST['startDate'].'"';
  		//echo $where;
  		$data = Default_Table::getData($where);
  		//echo "<pre>";
  		//print_r($data);
  		//echo "</pre>";
  		return $data;
	}

}
?>