<?php
	/*
		RaGEWEB 2
	*/

	class mysqli_database_driver {
		private $link, $statement;

		public function __construct($application) {
			$this->link = new MySQLi(
				$application->config->database->host,
				$application->config->database->user,
				$application->config->database->password,
				$application->config->database->name);
		}

		public function prepare($query, $args) {

			$this->statement = $this->link->prepare($query);

			$this->bindParams($args);
		}

	    public function execute() {
	    	$this->statement->execute();

	    	$this->statement->store_result();

	    	include_once 'Statement.php';

	    	return new mysqli_database_statement($this->statement);
	    }

		private function bindParams($args) {

			$parameterString = '';

			foreach($args as $key => $value) {
				$parameterString .= $this->decipherType($value);
			}	

			$param = array($parameterString);

			foreach($args as $key => $value) {
                $param[] =& $args[$key];
            }

			call_user_func_array(array($this->statement, 'bind_param'), $param);
		}

		private function decipherType($var)
	    {
	    	return substr(gettype($var), 0, 1);
	    }

	}
?>