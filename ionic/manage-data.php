<?php
   header('Access-Control-Allow-Origin: *');

   // Define database connection parameters
   $hn      = 'localhost';
   $un      = 'root';
   $pwd     = '';
   $db      = 'ionic';
   $cs      = 'utf8';

   // Set up the PDO parameters
   $dsn  = "mysql:host=" . $hn . ";port=3306;dbname=" . $db . ";charset=" . $cs;
   $opt  = array(
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                        PDO::ATTR_EMULATE_PREPARES   => false,
                       );
   // Create a PDO instance (connect to the database)
   $pdo  = new PDO($dsn, $un, $pwd, $opt);

   // Retrieve specific parameter from supplied URL
   $key  = strip_tags($_REQUEST['key']);
   $data    = array();


   // Determine which mode is being requested
   switch($key)
   {

      // Add a new record to the technologies table
      case "create":

         // Sanitise URL supplied values
         $nama      = filter_var($_REQUEST['nama'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $jenis       = filter_var($_REQUEST['jenis_barang'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $detail   = filter_var($_REQUEST['detail'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $jumlah   = filter_var($_REQUEST['jumlah'], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_ENCODE_LOW);
         $lokasi   = filter_var($_REQUEST['lokasi'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $status   = filter_var($_REQUEST['status'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);

         // Attempt to run PDO prepared statement
         try {
            $sql  = "INSERT INTO technologies(nama, jenis_barang,detail,jumlah,lokasi,status) VALUES(:nama, :jenis_barang,:detail, :jumlah,:lokasi, :status)";
            $stmt    = $pdo->prepare($sql);
            $stmt->bindParam(':nama', $nama, PDO::PARAM_STR);
            $stmt->bindParam(':jenis_barang', $jenis, PDO::PARAM_STR);
            $stmt->bindParam(':detail', $detail, PDO::PARAM_STR);
            $stmt->bindParam(':jumlah', $jumlah, PDO::PARAM_STR);
            $stmt->bindParam(':lokasi', $lokasi, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->execute();

            echo json_encode(array('message' => 'Congratulations the record ' . $name . ' was added to the database'));
         }
         // Catch any errors in running the prepared statement
         catch(PDOException $e)
         {
            echo $e->getMessage();
         }

      break;



      // Update an existing record in the technologies table
      case "update":

         // Sanitise URL supplied values
         $nama      = filter_var($_REQUEST['nama'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $jenis       = filter_var($_REQUEST['jenis_barang'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $detail   = filter_var($_REQUEST['detail'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $jumlah   = filter_var($_REQUEST['jumlah'], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_ENCODE_LOW);
         $lokasi   = filter_var($_REQUEST['lokasi'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $status   = filter_var($_REQUEST['status'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $recordID   = filter_var($_REQUEST['recordID'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);

         // Attempt to run PDO prepared statement
         try {
            $sql  = "UPDATE technologies SET nama = :nama, jenis_barang = :jenis_barang, detail=:detail, jumlah = :jumlah, lokasi = :lokasi, status=:status WHERE id = :recordID";
            $stmt    = $pdo->prepare($sql);
            $stmt->bindParam(':nama', $nama, PDO::PARAM_STR);
            $stmt->bindParam(':jenis_barang', $jenis, PDO::PARAM_STR);
            $stmt->bindParam(':detail', $detail, PDO::PARAM_STR);
            $stmt->bindParam(':jumlah', $jumlah, PDO::PARAM_STR);
            $stmt->bindParam(':lokasi', $lokasi, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':recordID', $recordID, PDO::PARAM_STR);
            $stmt->execute();

            echo json_encode('Congratulations the record ' . $name . ' was updated');
         }
         // Catch any errors in running the prepared statement
         catch(PDOException $e)
         {
            echo $e->getMessage();
         }

      break;



      // Remove an existing record in the technologies table
      case "delete":

         // Sanitise supplied record ID for matching to table record
         $recordID   =  filter_var($_REQUEST['recordID'], FILTER_SANITIZE_NUMBER_INT);

         // Attempt to run PDO prepared statement
         try {
            $pdo  = new PDO($dsn, $un, $pwd);
            $sql  = "DELETE FROM technologies WHERE id = :recordID";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':recordID', $recordID, PDO::PARAM_INT);
            $stmt->execute();

            echo json_encode('Congratulations the record ' . $name . ' was removed');
         }
         // Catch any errors in running the prepared statement
         catch(PDOException $e)
         {
            echo $e->getMessage();
         }

      break;
   }

?>
