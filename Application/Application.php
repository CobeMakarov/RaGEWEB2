<?php
	/*
		RaGEWEB 2
	*/

	class application {

		public $config, $database, $is_authenicated, $user, $url;

		public function __construct() {

			$this->loadConfig();
			$this->loadDatabase();
			$this->loadInterfaces();
			$this->loadLibrary();
			
			if ($_GET['request'] == '' || strlen($_GET['request']) <= 2) {
				$this->url = 'index';
			} else {
				$this->url = $_GET['request'];
			}
		}

		private function loadConfig() {
			foreach(glob('Config/*.php') as $File) {
				include $File;
			}

			$this->config = new stdClass;

			foreach($config as $key => $value) {
				$this->config->$key = null;

				foreach($config[$key] as $lk => $lv) {
					$this->config->$key->$lk = $lv;
				} 
			}
		}

		private function loadDatabase() {
			include_once 'Application/Database/' . $this->config->database->driver . '/Driver.php';

			$fake = strtolower($this->config->database->driver) . '_database_driver';

			$this->database = new $fake($this);
		}

		private function loadInterfaces() {
			foreach(glob('Application/Interfaces/*.php') as $File) {
				include $File;
			}
		}

		private function loadLibrary() {
			foreach(glob('Application/Library/*.php') as $File) {
				include $File;
			}
		}

		private function loadUser() {
			if (isset($_SESSION['id'])) {

				$this->is_authenicated = true;
			} else {
				$this->is_authenicated = false;
			}
		}

		public function route() {
			$controller_name = null;
			$required_function = null;

			if (count(explode('/', $this->url)) >= 1) {
				$debri = explode('/', $this->url);

				$controller_name = $debri[0];
				$required_function = $debri[1];
			} else {
				$controller_name = $this->url;
			}

			if (!file_exists('Application/Themes/' . $this->config->site->theme . '/Controllers/' . $controller_name . '.php'))
			{
				$controller_name = 'Error';
				$required_function = 'controller_not_found';
			}

			include_once 'Application/Themes/' . $this->config->site->theme . '/Controllers/' . $controller_name . '.php';

			$controller = new $controller_name();

			if (!is_null($required_function)) {
				if(method_exists($controller, $required_function)) {
					$controller->{$required_function}();
				}
			} else {
				$controller->execute();
			}
		}

		public function direct($controller, $leave) {
			if ($leave) { //take them to a whole new page
				header('Location: ' . $controller);
			} else { //used before controller is parsed
				$this->url = $controller;
				$this->route();
			}
		}
	}
?>