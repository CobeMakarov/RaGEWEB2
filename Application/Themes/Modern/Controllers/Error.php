<?php

	/*
		RaGEWEB 2
	*/

	class Error implements controller_interface{

		public function execute() {

		}

		public function controller_not_found() {
			die('Controller was not found');
		}
	}
?>