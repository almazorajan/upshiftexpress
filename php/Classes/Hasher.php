
<?php 
	
	class Hasher
	{
		private $encryptedValue;

		function __construct( $value ) 
		{
			$this->encryptedValue = $this->Encrypt( $value );
			echo $this->encryptedValue;
			echo '<br />';
		}

		public function DecryptValue() 
		{
			return $this->Decrypt( $this->encryptedValue );
		}

		public function EncryptValue()
		{
			return $this->encryptedValue;
		}

		private function Encrypt( $value )
		{
			return base64_encode( base64_encode( base64_encode( $value ) ) );
		}

		private function Decrypt( $value )
		{
			return base64_decode( base64_decode( base64_decode( $value ) ) );
		}
	}

?>