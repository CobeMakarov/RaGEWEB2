<?php
	/*
		RaGEWEB 2
	*/

	class pdo_database_driver {
		private $link, $statement, $params;

		public function __construct($application) {
			$this->link = new PDO(
				'mysql:dbname=' . $application->config->database->name . ';host=' . $application->config->database->host,
				$application->config->database->user,
				$application->config->database->password);
		}

		public function prepare($query, $args) {

			$this->statement = $this->link->prepare($query);

			$this->params = $args;
		}

	    public function execute() {
	    	$this->statement->execute($this->params);

	    	include_once 'Statement.php';

	    	return new pdo_database_statement($this->statement, $this->link->lastInsertId());
	    }
	}
?>