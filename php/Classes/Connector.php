<?php 

	class Connector
	{
		private $server 	= 'localhost';
		private $user 		= 'root';
		private $password 	= '';
		private $database 	= 'upshift';
		private $conn;

		function __construct()
		{
			$this->conn = mysqli_connect( $this->server, $this->user, $this->password, $this->database );
		} 

		public function GetConnection()
		{
			return $this->conn;
		}

		public function CloseConnection()
		{
			mysqli_close( $this->conn );
		}
	}
?>