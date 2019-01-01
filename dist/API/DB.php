<?php
   
   require_once "hideSettings/dbSettings.php";

class DB
{
    
    
    //Połączenie z bazą zwracane jest PDO
    public function connectDB()
    {
        $setDB = new dbSettings;
        $setting = $setDB->getSettings();
      
        // var_dump($setting);
      
        
        try {
            $pdo = new PDO(
          "mysql:host=".$setting['host'].";dbname=".$setting['dbName'].";charset=utf8",
          $setting['user'],
          $setting['password'],
      array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      //   PDOStatement::fetch => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"
      )
      );
        } catch (PDOException $e) {
            echo "Błąd połączenia z bazą danych!";
        }
//    echo "Połączenie nawiązane!";
        return $pdo;
    }
    

    //Zwróć dane z bazy na podstawie zapytania SQL
    public function getData($MySQL_query)
    {

      // echo $MySQL_query."<br>";
        
        try {
            $pdo = $this->connectDB();
      
            $sth = $pdo->prepare($MySQL_query);
            // $sth->bindParam(':calories', $calories, PDO::PARAM_INT);
            // $sth->bindParam(':colour', $colour, PDO::PARAM_STR, 12);
            $sth->execute();

      
            if (substr($MySQL_query, 0, 6) == 'SELECT') {
          
      // echo '<PRE>';
                  
                // $result = $sth->fetchAll();
                $result = $sth->fetch(PDO::FETCH_ASSOC);
                // var_dump($result);
            
                // echo '</PRE>';
                $sth->closeCursor();
                return $result;
            } else {
                $sth->closeCursor();
            }
        } catch (PDOException $e) {
            echo 'Błąd zapytania do bazy danych!: ' . $e->getMessage();
            //  echo "Błąd zapytania do bazy danych!";
        }
    }
}

$db = new DB();
// $db->getData("SELECT id, data_odczytu, temperatura FROM AVR WHERE  `data_odczytu` > DATE_SUB( NOW( ) , INTERVAL 1 DAY )");
$db->connectDB();
