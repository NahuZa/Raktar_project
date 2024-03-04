<?php
class Database{
    protected $mysqli;
        public function __construct($host='localhost', $user='root', $password='', $database= 'raktar')
        {
            $this->mysqli=new mysqli($host, $user, $password, $database);
            if ($this->mysqli->connect_errno)
            {
                throw new Exception($this->mysqli->connect_errno);
            }
        }
        public function __destruct()
        {
            $this->mysqli->close();
        }

         
            private $servername = "localhost";
            private $username = "root";
            private $password = "";
            private $dbname = "raktar";
        
            public function createDatabase() {
                try {
                    $conn = new PDO("mysql:host=$this->servername", $this->username, $this->password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
                    $sql = "CREATE DATABASE IF NOT EXISTS $this->dbname";
                    $conn->exec($sql);
                   
                } catch(PDOException $e) {
                    echo "Hiba: " . $e->getMessage();
                }
            }
        
            public function createTables() {
                try {
                    $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
                    // Raktarok tábla létrehozása
                    $sql = "CREATE TABLE IF NOT EXISTS raktarok (
                        raktar_id INT AUTO_INCREMENT PRIMARY KEY,
                        raktar_name TEXT,
                        location TEXT
                    )";
                    $conn->exec($sql);
                    
        
                    // Termekek tábla létrehozása
                    $sql = "CREATE TABLE IF NOT EXISTS termekek (
                        termek_id INT AUTO_INCREMENT PRIMARY KEY,
                        raktar_id INT,
                        sor INT,
                        oszlop INT,
                        mennyiseg INT,
                        ar INT,
                        termek_name TEXT,
                        FOREIGN KEY (raktar_id) REFERENCES raktarok(raktar_id)
                    )";
                    $conn->exec($sql);
                    
                } catch(PDOException $e) {
                    echo "Hiba: " . $e->getMessage();
                }
            }

            public function importRaktarok($csvFile) {
                try {
                    $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
                    $handle = fopen($csvFile, "r");
                    if ($handle !== FALSE) {
                        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                            $raktar_id = $data[0];
                            $raktar_name = $data[1];
                            $location = $data[2];
            
                            $stmt = $conn->prepare("INSERT INTO raktarok (raktar_id, raktar_name, location) VALUES (?, ?, ?)");
                            $stmt->execute([$raktar_id, $raktar_name, $location]);
                        }
                        fclose($handle);
                        echo "Az adatok sikeresen importálva lettek a raktarok táblába!\n";
                    } else {
                        echo "Hiba: Nem sikerült megnyitni a CSV fájlt!\n";
                    }
                } catch(PDOException $e) {
                    echo "Hiba: " . $e->getMessage();
                }
            }
        }
?>