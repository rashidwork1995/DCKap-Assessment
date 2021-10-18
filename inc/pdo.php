<?php
	class Epdo
	{
		private $db;
		public $res = 0;
		public $count = 0;
		public $log_s = 0;
		
		public function __construct($host, $user = 0, $pass = 0, $db = 0)
		{
			$data = $host;
			if (is_array($data)) {
				$host = $data[0];
				$user = $data[1];
				$pass = $data[2];
				$db = $data[3];
			}
			try {
				$this->db = new PDO('mysql:host=' . $host . ';dbname=' . $db . ';charset=utf8', $user, $pass);
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
				} catch (PDOException $e) {
				$e->getMessage() . "<br/>";
				file_put_contents(PDOERRORS . 'PDOErrors.txt', $e, FILE_APPEND);
				die();
			}
		}
		
		public function s($a)
		{
			try {
				$q = $this->db->prepare($a);
				$this->res = $q->execute();
				} catch (Exception $e) {
				$e->getMessage() . "<br/>";
				file_put_contents(PDOERRORS . 'PDOErrors.txt', $e, FILE_APPEND);
			}
			return $this->res;
		}
		
		public function sl($a)
		{
			try {
				$q = $this->db->prepare($a);
				$q->execute();
				$this->res = $q->fetch(PDO::FETCH_ASSOC);
				} catch (Exception $e) {
				$e->getMessage() . "<br/>";
				file_put_contents(PDOERRORS . 'PDOErrors.txt', $e, FILE_APPEND);
			}
			return $this->res;
		}
		
		public function sq($a)
		{
			try {
				$q = $this->db->prepare($a);
				$q->execute();
				$this->res = $q->fetchAll(PDO::FETCH_ASSOC);
				} catch (Exception $e) {
				$e->getMessage() . "<br/>";
				file_put_contents(PDOERRORS . 'PDOErrors.txt', $e, FILE_APPEND);
			}
			return $this->res;
		}
		
		public function inq($a, $b = array())
		{
			try {
				$q = $this->db->prepare($a);
				$this->res = (empty($b)) ? $q->execute() : $q->execute($b);
				} catch (Exception $e) {
				$e->getMessage() . "<br/>";
				file_put_contents(PDOERRORS . 'PDOErrors.txt', $e, FILE_APPEND);
			}
			return $this->res;
		}
		
		public function incondition($a, $b)
		{
			for ($i = 0; $i <= count($b); $i++) {
				try {
					$c = array(array_keys($b)[0] => $b[array_keys($b)[0]][$i]);
					$q = $this->db->prepare($a);
					$this->res = $q->execute($c);
					} catch (Exception $e) {
					echo $e->getMessage() . "<br/>";
					file_put_contents(PDOERRORS . 'PDOErrors.txt', $e, FILE_APPEND);
				}
			}
			
			return $this->res;
		}
		
		public function q($a, $b = array())
		{
			try {
				$q = $this->db->prepare($a);
				(empty($b)) ? $q->execute() : $q->execute($b);
				$this->res = $q->fetchAll(PDO::FETCH_ASSOC);
				} catch (Exception $e) {
				$e->getMessage() . "<br/>";
				file_put_contents(PDOERRORS . 'PDOErrors.txt', $e, FILE_APPEND);
			}
			return $this->res;
		}
		
		public function qc($a, $b = array())
		{
			try {
				$q = $this->db->prepare($a);
				(empty($b)) ? $q->execute() : $q->execute($b);
				$this->res = $q->fetchAll(PDO::FETCH_ASSOC);
				$this->count = $q->rowCount();
				} catch (Exception $e) {
				$e->getMessage() . "<br/>";
				file_put_contents(PDOERRORS . 'PDOErrors.txt', $e, FILE_APPEND);
			}
			return array($this->res, $this->count);
		}
		
		public function line($a, $b = array())
		{
			try {
				$q = $this->db->prepare($a);
				(empty($b)) ? $q->execute() : $q->execute($b);
				$this->res = $q->fetch(PDO::FETCH_ASSOC);
				} catch (Exception $e) {
				$e->getMessage() . "<br/>";
				file_put_contents(PDOERRORS . 'PDOErrors.txt', $e, FILE_APPEND);
			}
			return $this->res;
		}
		
		public function one($a, $b = array())
		{
			try {
				$q = $this->db->prepare($a);
				(empty($b)) ? $q->execute() : $q->execute($b);
				$this->res = $q->fetchColumn();
				} catch (Exception $e) {
				$e->getMessage() . "<br/>";
				file_put_contents(PDOERRORS . 'PDOErrors.txt', $e, FILE_APPEND);
			}
			return $this->res;
		}
		
		public function onev($a)
		{
			try {
				$q = $this->db->prepare($a);
				$q->execute();
				$this->res = $q->fetchColumn();
				} catch (Exception $e) {
				$e->getMessage() . "<br/>";
				file_put_contents(PDOERRORS . 'PDOErrors.txt', $e, FILE_APPEND);
			}
			return $this->res;
		}
		
		public function insert($a, $b)
		{
			$q = "INSERT INTO `$a` (";
			foreach ($b as $c => $d)
            $q .= "`$c`,";
			$q = substr($q, 0, -1);
			$q .= ") VALUES (";
			foreach ($b as $v => $k) {
				if ($k == "NULL")
                $q .= ":$v,";
				else
                $q .= ":$v,";
			}
			$q = substr($q, 0, -1);
			return $this->inq($q . ');', $b);
		}
		
		public function update($a, $b, $c)
		{
			$q = "UPDATE `$a` SET ";
			foreach ($b as $v => $k) {
				if ($k == "NULL")
                $q .= "`$v`=:$v,";
				else
                $q .= "`$v`=:$v,";
			}
			$q = substr($q, 0, -1);
			$q .= " WHERE 1";
			foreach ($c as $v => $k)
            $q .= " AND `$v`=:$v";
			$d = array_merge($b, $c);
			return $this->inq($q, $d);
			//return $d;
		}
		
		public function delete($a, $b)
		{
			$q = "DELETE FROM `$a` WHERE 1";
			foreach ($b as $v => $k)
            $q .= " AND `$v`=:$v";
			return $this->inq($q, $b);
		}
		public function DeleteInCheck($a, $b, $c, $d)
		{
			$q = "DELETE FROM `$a` WHERE 1 ";
			if($b != "")
			$q .= " AND " . $b;
			$q .= " AND `$c` IN (";
			$q1 = '';
			foreach ($d as $v => $k)
            $q1 .= ":$v,";
			$q1 = substr($q1, 0, -1);
			$q .= $q1 . ")";
			return $this->inq($q, $d);
		}
		public function deleteMulti($a, $b, $c)
		{
			$q = "DELETE FROM `$a` WHERE";
			$q .= " `$b` IN (:multi_ids)";
			return $this->inq($q, $c);
		}
		
		public function deleteBlk($a, $b, $c)
		{
			$q = "DELETE FROM `$a` WHERE " . $b . " IN (:" . array_keys($c)[0] . ")";
			return $this->incondition($q, $c);
		}
		
		public function updateMulti($a, $b, $c, $d)
		{
			$q = "UPDATE `$a` SET";
			foreach ($b as $v => $k) {
				if ($k == "NULL")
                $q .= "`$v`=:$v,";
				else
                $q .= "`$v`=:$v,";
			}
			$q = substr($q, 0, -1);
			$q .= " WHERE 1";
			$q .= " AND `" . $c . "` IN (:multi_ids)";
			$d = array_merge($b, $d);
			return $this->inq($q, $d);
		}
		
		public function updateCheck($a, $b, $c)
		{
			$q = "UPDATE `$a` SET";
			foreach ($b as $v => $k) {
				if ($k == "NULL")
                $q .= "`$v`=:$v,";
				else
                $q .= "`$v`=:$v,";
			}
			$q = substr($q, 0, -1);
			$q .= " WHERE 1";
			$q .= " AND " . $c;
			return $this->inq($q, $b);
		}
		
		public function updateIn($a, $b, $c, $d, $e)
		{
			$q = "UPDATE `$a` SET ";
			foreach ($b as $v => $k) {
				if ($k == "NULL")
                $q .= "`$v`=:$v,";
				else
                $q .= "`$v`=:$v,";
			}
			$q = substr($q, 0, -1);
			$q .= " WHERE 1";
			foreach ($c as $v => $k)
            $q .= " AND `$v`=:$v";
			$q .= " AND `$d` IN (";
			$q1 = '';
			foreach ($e as $v => $k)
            $q1 .= ":$v,";
			$q1 = substr($q1, 0, -1);
			$q .= $q1 . ")";
			$f = array_merge($b, $c);
			$g = array_merge($f, $e);
			return $this->inq($q, $g);
		}
		public function updateInwithCheck($a, $b, $c, $d, $e)
		{
			$q = "UPDATE `$a` SET ";
			foreach ($b as $v => $k) {
				if ($k == "NULL")
                $q .= "`$v`=:$v,";
				else
                $q .= "`$v`=:$v,";
			}
			$q = substr($q, 0, -1);
			$q .= " WHERE 1 ";
			$q .= " AND " . $c;
			$q .= " AND `$d` IN (";
			$q1 = '';
			foreach ($e as $v => $k)
            $q1 .= ":$v,";
			$q1 = substr($q1, 0, -1);
			$q .= $q1 . ")";
			/* $f = array_merge($b, $c); */
			$g = array_merge($b, $e);
			return $this->inq($q, $g);
		}
		
		public function countTable($a)
		{
			$q = "SELECT COUNT(*) FROM $a LIMIT 1";
			return $this->onev($q);
		}
		
		public function countWhere($a, $b)
		{
			$q = "SELECT COUNT(*) FROM $a WHERE 1";
			foreach ($b as $v => $k)
            $q .= " AND `$v`=:$v";
			$q .= " LIMIT 1";
			return $this->one($q, $b);
		}
		
		public function countWhereCol($a, $b, $c)
		{
			$q = "SELECT COUNT($b) FROM $a WHERE 1";
			foreach ($c as $v => $k)
            $q .= " AND `$v`=:$v";
			$q .= " LIMIT 1";
			return $this->one($q, $c);
		}
		
		public function countWhereType($a, $b)
		{
			$q = "SELECT COUNT(*) FROM $a WHERE 1" . $b;
			$q .= " LIMIT 1";
			return $this->one($q);
		}
		
		public function countWhereTypeCol($a, $b, $c)
		{
			$q = "SELECT COUNT($b) FROM $a WHERE 1" . $c;
			$q .= " LIMIT 1";
			return $this->one($q);
		}
		
		public function countWhereSet($a, $b, $c, $d)
		{
			$q = "SELECT COUNT($a) FROM $b WHERE 1 " . $c;
			$q .= " LIMIT 1";
			return $this->one($q, $d);
		}
		
		public function lastID()
		{
			return $this->db->lastInsertId();
		}
		
		public function NewUpdateIn($a, $b, $c, $d, $e)
		{
			$q = "UPDATE `$a` SET ";
			foreach ($b as $v => $k) {
				if ($k == "NULL")
				$q .= "`$v`=:$v,";
				else
				$q .= "`$v`=:$v,";
			}
			$q = substr($q, 0, -1);
			$q .= " WHERE 1";
			foreach ($c as $v => $k)
			$q .= " AND `$v`=:$v";
			$q .= " AND `$d` IN (";
			$q1 = '';
			foreach ($e as $v => $k)
			$q1 .= '"'.$k.'",';
			$q1 = substr($q1, 0, -1);
			$q .= $q1 . ")";
			$f = array_merge($b, $c);
			//$g = array_merge($f, $e);
			$id=$this->inq($q, $f);
			return $id;
		}
		
		public function Log_System($a, $b = array())
		{
			try {
				$q = $this->db->prepare($a);
				(empty($b)) ? $q->execute() : $q->execute($b);
				$this->res = $q->fetch(PDO::FETCH_ASSOC);
				$this->log_s = $q->getColumnMeta();
				} catch (Exception $e) {
				$e->getMessage() . "<br/>";
				file_put_contents(PDOERRORS . 'PDOErrors.txt', $e, FILE_APPEND);
			}
			return array($this->res, $this->log_s);
		}
		
		public function __destruct()
		{
			$this->db = NULL;
		}
	}
	
?>