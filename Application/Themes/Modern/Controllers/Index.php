<?php

	/*
		RaGEWEB 2
	*/

	class Index implements controller_interface{

		public function execute() {
			global $application;

			$view = new view_object();

			$view->setBody('index');

			$view->execute();
		}
	}
?>