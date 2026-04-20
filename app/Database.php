<?php

namespace db {
	class Database {
		private static ?Database $instance = null;
		private static \PDO $database;

		private function __construct() {
			self::$database = new \PDO(
				'mysql:host=' . \Environment\get('DATABASE_HOST') . ';port=' . \Environment\get('DATABASE_PORT') . ';dbname=' . \Environment\get('DATABASE_NAME') .';',
				\Environment\get('DATABASE_USERNAME'),
				\Environment\get('DATABASE_PASSWORD'),
				array(\PDO::ATTR_EMULATE_PREPARES => false, \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION)
			);
		}

		public static function getDatabase(): \PDO {
			if (self::$instance === null) {
				self::$instance = new self();
			}

			return self::$instance::$database;
		}
	}

	/**
	 * @param array<string,string|int> $params
	 */
	function execute(string $query, array $params = array()) : \PDOStatement {
		$sth = Database::getDatabase()->prepare($query);
		$sth->execute($params);
		return $sth;
	}
}
