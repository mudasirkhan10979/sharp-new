<?php
class ModelToolAutobackup extends Model {
	
	public function addFile($data) {
		$this->db->query('INSERT INTO ' . DB_PREFIX . 'autobackup SET filename = "' . $this->db->escape($data['filename']) . '", download = "' . $this->db->escape($data['download']) . '", identification = "' . $this->db->escape($data['identification']) . '", service = "' . $this->db->escape($data['service']) . '", date = NOW(), backup_file = "' . (int)$this->config->get('autobackup_backup_files') . '", backup_database = "' . (int)$this->config->get('autobackup_backup_database') . '", backup_cache = "' . (int)$this->config->get('autobackup_backup_cache') . '", backup_logs = "' . (int)$this->config->get('autobackup_backup_logs') . '", exclude = "' . (int)$this->config->get('autobackup_exclude') . '"');
		
		return $this->getFile($this->db->getLastId());
	}
	
	public function backupDatabase() {
		
		$table_data = array();

		$query = $this->db->query("SHOW TABLES FROM `" . DB_DATABASE . "`");

		foreach ($query->rows as $result) {
			if (utf8_substr($result['Tables_in_' . DB_DATABASE], 0, strlen(DB_PREFIX)) == DB_PREFIX) {
				if (isset($result['Tables_in_' . DB_DATABASE])) {
					$table_data[] = $result['Tables_in_' . DB_DATABASE];
				}
			}
		}

		$output = '';

		foreach ($table_data as $table) {
			if (DB_PREFIX) {
				if (strpos($table, DB_PREFIX) === false) {
					$status = false;
				} else {
					$status = true;
				}
			} else {
				$status = true;
			}

			if ($status) {
				$output .= 'TRUNCATE TABLE `' . $table . '`;' . "\n\n";

				$query = $this->db->query("SELECT * FROM `" . $table . "`");

				foreach ($query->rows as $result) {
					$fields = '';

					foreach (array_keys($result) as $value) {
						$fields .= '`' . $value . '`, ';
					}

					$values = '';

					foreach (array_values($result) as $value) {
						$value = str_replace(array("\x00", "\x0a", "\x0d", "\x1a"), array('\0', '\n', '\r', '\Z'), $value);
						$value = str_replace(array("\n", "\r", "\t"), array('\n', '\r', '\t'), $value);
						$value = str_replace('\\', '\\\\',	$value);
						$value = str_replace('\'', '\\\'',	$value);
						$value = str_replace('\\\n', '\n',	$value);
						$value = str_replace('\\\r', '\r',	$value);
						$value = str_replace('\\\t', '\t',	$value);

						$values .= '\'' . $value . '\', ';
					}

					$output .= 'INSERT INTO `' . $table . '` (' . preg_replace('/, $/', '', $fields) . ') VALUES (' . preg_replace('/, $/', '', $values) . ');' . "\n";
				}

				$output .= "\n\n";
			}
		}

		return $output;
	}

	public function restoreDatabase($file) {
		
		$sql = file_get_contents($file);
		
		foreach (explode(";\n", $sql) as $sql) {
			$sql = trim($sql);

			if ($sql) {
				$this->db->query($sql);
			}
		}

		$this->cache->delete('*');
	}
	
	public function getFiles() {
		$query = $this->db->query('SELECT * FROM ' . DB_PREFIX . 'autobackup ORDER BY autobackup_id DESC');
		
		return $query->rows;
	}
	
	public function getFile($autobackup_id) {
		$query = $this->db->query('SELECT * FROM ' . DB_PREFIX . 'autobackup WHERE autobackup_id = "' . (int)$autobackup_id . '"');
		
		return $query->row;
	}

	public function remove($autobackup_id) {
		$data = $this->getFile($autobackup_id);
		
		$this->db->query('DELETE FROM ' . DB_PREFIX . 'autobackup WHERE autobackup_id = "' . (int)$autobackup_id . '"');
		
		return $data;		
	}
}