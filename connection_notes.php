<?php
class Connection
{
    public $pdo = null;

    public function __construct()
    {
        try {
            $this->pdo = new PDO('mysql:host=yourhostname;dbname=yourdatabasename', 'yourdatabaseuser', 'yourdatabasepassword');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "ERROR: " . $exception->getMessage();
        }

    }

    public function getNotes($username)
    {
        $statement = $this->pdo->prepare("SELECT * FROM notes WHERE username = '$username' ORDER BY create_date DESC");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addNote($note)
    {
        $statement = $this->pdo->prepare("INSERT INTO notes (username, title, description, create_date) VALUES (:username, :title, :description, :date)");
        $statement->bindValue('username', $note['username']);
        $statement->bindValue('title', $note['title']);
        $statement->bindValue('description', $note['description']);
        $statement->bindValue('date', date('Y-m-d H:i:s'));
        return $statement->execute();
    }

    public function updateNote($id, $note)
    {
        $statement = $this->pdo->prepare("UPDATE notes SET title = :title, description = :description WHERE id = :id");
        $statement->bindValue('id', $id);
        $statement->bindValue('title', $note['title']);
        $statement->bindValue('description', $note['description']);
        return $statement->execute();
    }

    public function removeNote($id)
    {
        $statement = $this->pdo->prepare("DELETE FROM notes WHERE id = :id");
        $statement->bindValue('id', $id);
        return $statement->execute();
    }

    public function getNoteById($id)
    {
        $statement = $this->pdo->prepare("SELECT * FROM notes WHERE id = :id");
        $statement->bindValue('id', $id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function delete_acc($username)
    {
        //select all notes based on username
        $statement = $this->pdo->prepare("SELECT * FROM notes WHERE username = :username");
        $statement->bindValue('username', $username);
        $result = $statement->execute();

        //delete all notes
        for ($x = 0; $x < $result; $x++) {

            $statement = $this->pdo->prepare("DELETE FROM notes WHERE username = :username");
            $statement->bindValue('username', $username);
            $statement->execute();
        }
    }


}
return new Connection();