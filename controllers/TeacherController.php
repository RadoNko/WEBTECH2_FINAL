<?php
require_once("Database.php");

class TeacherController
{

    private PDO $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }


    public function getAll()
    {
        try {
            $sql = "SELECT id,username,password FROM Teacher";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute();

            return json_encode($stmnt->fetchAll(PDO::FETCH_ASSOC), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage() . "
                    </div>";
        }
    }
}
