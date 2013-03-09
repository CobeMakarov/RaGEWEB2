<?php
	/*
		RaGEWEB 2
	*/

	class view_object {

		public $public_dir, $theme;

		private $skeleton, $parameters = array();

		public function __construct() {
			global $application;

			$this->public_dir = $application->config->site->path;
			$this->theme = $application->config->site->theme;

			$this->skeleton = file_get_contents('./Public/' . $this->theme . '/Views/skeleton.html');

			$this->initDefault();
		}

		private function initDefault() {
			global $application;

			$this->parameters['site->title'] = $application->config->site->title;
			$this->parameters['site->theme'] = $this->theme;
			$this->parameters['site->path'] = $this->public_dir;

			$tihs->parameters['site->location'] = $application->url;

			if ($application->is_authenicated) {

			}
		}

		public function set($key, $value) {
			$this->parameters[$key] = $value;
		}

		public function append($key, $value) {
			$this->parameters[$key] .= $value;
		}

		public function setBody($view) {
			$content = file_get_contents('./Public/' . $this->theme . '/Views/' . $view . '.html');

			$this->skeleton = str_replace('{$page->body}', $content, $this->skeleton);
		}

		public function execute() {
			foreach($this->parameters as $key => $value) {
				$this->skeleton = str_replace('{$' . $key . '}', $value, $this->skeleton);
			}

			die($this->skeleton);
		}
	}

?>