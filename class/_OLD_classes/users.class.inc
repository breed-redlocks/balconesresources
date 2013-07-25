<?php

require_once 'database.class.inc';
require_once "error.inc";

class Users extends Default_Table
{

    // additional class variables go here
    function Users ()
    {
        $this->tablename       = 'users';
        $this->dbname          = 'devjackw';
        $this->rows_per_page   = 15;
        $this->fieldlist       = array(	'id', 'userName', 'firstName', 'lastName', 'email', 'address1', 'address2', 'city', 'state', 'zip', 'country',  'password', 'date', 'ip', 'isCustomer', 'payerId', 'transId', 'transTime', 'packageIds', 'supportCredits');
        
        $this->fieldlist['id'] = array('pkey' => 'y');
				
    } // end class constructor
    
    function getErrors() {
    echo errorHandler();
    }

   function displayLogin($_action, $logMessage) {
   
   		switch ($logMessage){
			case 0:
				$message = '';
				break;
			case 1:
				$message = '<legend>Username not found</legend>';
				break;	
			case 2:
				$message = '<legend>Password did not match</legend>';
				break;	
			case 3:
				$message = '<legend>You have been logged out</legend>';
				break;
		}

   		echo '<form action="includes/admin-auth.php" method="post" name="admin" id="admin">
			<input type="hidden" name="hidden" value="<?php echo $ip; ?>">
			<input type="hidden" name="action" value="' . $_action . '">
				<fieldset>' .
				$message .
					'<legend>Log In to Continue</legend>
						<ol>	
							<li><label for="name">User Name</label><input type="text" name="userName"></li>
							<li><label for="password">Password</label><input type="password" name="password" value=""></li>
						</ol>
				</fieldset>
				<fieldset>
					<button type="submit">Log In</button>
				</fieldset>
				</form>';
   }

} // end class
?>