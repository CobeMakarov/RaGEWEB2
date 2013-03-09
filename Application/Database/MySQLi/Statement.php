<?php
	/*
		RaGEWEB 2
	*/

	class mysqli_database_statement {
		public $error, $field_count, $insert_id, $num_rows, $result, $array;

		public function __construct($statement) {
			$this->error = $statement->error;
			$this->field_count = $statement->field_count;
			$this->insert_id = $statement->insert_id;
			$this->num_rows = $statement->num_rows;

			if ($this->field_count == 1) {
				$statement->bind_result($res);

				while($statement->fetch) {
					$this->result = $res;
					break;
				}

				$this->array = array();
			} else {
				$data = $statement->result_metadata();

				$rows = array();

				$fields = array($statement);

				while($f = $data->fetch_field()) {
					$fields[] =& $rows[$f->name];
				}

				call_user_func_array('mysqli_stmt_bind_result', $fields);

				$statement->fetch();

				$this->array = array();

				foreach($rows as $key => $value) {
					$this->array[$key] = $value;
				}

				$this->result = '';
			}
		}
	}
?>