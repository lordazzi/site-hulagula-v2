<?php
# AUTHOR: RICARDO AZZI #
# CREATED: 31/10/12 #

class MySql {
	private $conn;
	
	public function __construct() {
		$this->conn = mysqli_connect("SERVIDOR", "USUARIO", "SENHA", "DATABASE");
	}
	
	public function __destruct() {
		return mysqli_close($this->conn);
	}
	
	public function Query($query, $onlyone = FALSE) {
		$datas = mysqli_query($this->conn, decode($query));
		
		if (gettype($datas) == "object") {
			$fields = array();
			$finfo = $datas->fetch_fields();
			
			foreach($finfo as $val) {
				$fields[] = array(
					"fieldname" => $val->name,
					"type" => $val->type,
					"max_length" => $val->max_length
				);
			}
			
			$i = 0;
			$record = array();
			while ($data = $datas->fetch_array()) {
				$record[$i] = array();
				foreach ($fields as $f) {
					if (!is_numeric($f['fieldname'])) {
						switch ($f["type"]) {
							case 3:
							case 8:
								$record[$i][$f['fieldname']] = (int) $data[$f['fieldname']];
								break;
							case 1:
							case 16:
								$record[$i][$f['fieldname']] = (bool) $data[$f['fieldname']];
								break;
							case 12:
							case 10:
							case 9:
							case 8:
								$record[$i][$f['fieldname']] = (int) strtotime($data[$f['fieldname']]);
								break;
							case 246:
							case 4:
								$record[$i][$f['fieldname']] = (float) $data[$f['fieldname']];
								break;
							case 'NULL':
								$record[$i][$f['fieldname']] = NULL;
								break;
							case 11: //hora
								$record[$i][$f['fieldname']] = $data[$f['fieldname']];
								break;
							case 253: //string
							default:
								$record[$i][$f['fieldname']] = encode($data[$f['fieldname']]);
							break;
						}
					}
				}
				$i++;
			}
			
			if ($onlyone) {
				return $record[0];
			} else {
				return $record;
			}
		}
	}
	
	public function lastId() {
		return mysqli_insert_id($this->conn);
	}
}
?>