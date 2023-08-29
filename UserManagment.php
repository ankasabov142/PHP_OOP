<?php
class UserManagement
{
    private $database;

    public function __construct(Database $database) {
        $this->database = $database;
    }

    public function create($data) {
        $table = "users";

        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        try {
            $statement = $this->database->getConnection()->prepare($sql);
            $statement->execute(array_values($data));
            return $this->database->getConnection()->insert_id;
        } catch (PDOException $e) {
            echo "Create failed: " . $e->getMessage();
            return false;
        }
    }

    public function read($id)
    {
        $table = "users";

        $sql = "SELECT * FROM $table WHERE id = :id";

        try {
            $statement = $this->database->getConnection()->prepare($sql);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Read failed: " . $e->getMessage();
            return false;
        }
    }

    public function update($id, $data)
    {
        $table = "users"; 

        $set = implode(', ', array_map(function ($key) {
            return "$key = :$key";
        }, array_keys($data)));

        $sql = "UPDATE $table SET $set WHERE id = :id";

        try {
            $statement = $this->database->getConnection()->prepare($sql);
            $data['id'] = $id;
            $statement->execute($data);
            return true;
        } catch (PDOException $e) {
            echo "Update failed: " . $e->getMessage();
            return false;
        }
    }

    public function delete($id)
    {
        $table = "users";

        $sql = "DELETE FROM $table WHERE id = :id";

        try {
            $statement = $this->database->getConnection()->prepare($sql);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();
            return true;
        } catch (PDOException $e) {
            echo "Delete failed: " . $e->getMessage();
            return false;
        }
    }
}

?>