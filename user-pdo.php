<?php


class userpdo
{

    private $id;
    public $login;
    public $email;
    public $firstName;
    public $lastName;
    private $pdo;

    public function __construct()
    {
        $this->pdo = new PDO("mysql:host=localhost;port=3306;dbname=classes;charset=utf8", 'root', '');
        if(isset($_SESSION['id']))
        {
            $this->id = $_SESSION['id'];
            $this->refresh();
        }
    }

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    public function query($request, $value = [])
    {
        if(!empty($value))
        {
            $statement = $this->pdo->prepare($request);
            $statement->execute($value);
        }
        else
        {
            $statement = $this->pdo->query($request);
        }
        return $statement;
    }

    public function register($login, $password, $email, $firstName, $lastName)
    {
        $test = $this->query('INSERT INTO utilisateurs(login, password, email, firstname, lastname) VALUE(:login, :password, :email, :firstname, :lastname)', [
            'login' => $login,
            'password' => $password,
            'email' => $email,
            'firstname' => $firstName,
            'lastname' => $lastName,
        ]);
        $statement =  $this->query('SELECT * FROM utilisateurs WHERE id = ?', [$this->lastInsertId()]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function connect($login, $password)
    {
        if(!$this->isConnected())
        {
            $statement = $this->query("SELECT * FROM utilisateurs WHERE login = ?", [$login]);
            $statement = $statement->fetch(PDO::FETCH_ASSOC);
            if(!empty($statement) && password_verify($password, $statement['password']))
            {
                $this->id = $statement['id'];
                $this->login = $statement['login'];
                $this->email = $statement['email'];
                $this->firstName = $statement['firstname'];
                $this->lastName = $statement['lastname'];
                $_SESSION['id'] = $statement['id'];
                return $this;
            }
            else
            {
                return null;
            }
        }
        else
        {
            return $this;
        }
    }

    public function disconnect()
    {
        session_destroy();
        $this->id = null;
        $this->login = null;
        $this->email = null;
        $this->firstName = null;
        $this->lastName = null;
        return $this;
    }

    public function delete()
    {
        session_destroy();
        $this->query('DELETE FROM utilisateurs WHERE id = ?', [$this->id]);
        $this->id = null;
        $this->login = null;
        $this->email = null;
        $this->firstName = null;
        $this->lastName = null;
        return $this;
    }

    public function update($login, $password, $email, $firstName, $lastName)
    {
        $statement = $this->query("SELECT * FROM utilisateurs WHERE login = ? AND login != ?", [$login, $this->login]);
        $statement = $statement->fetch(PDO::FETCH_ASSOC);
        if($statement)
        {
            return null;
        }
        else
        {
            $this->query("UPDATE utilisateurs SET login = ?, password = ?, email = ?,  firstname = ?, lastname = ? WHERE id = ?", [
                $login, $password, $email, $firstName, $lastName
            ]);
            return $this;
        }
    }

    public function isConnected()
    {
        if($this->id)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getAllInfos()
    {
        return [
            'login' => $this->login,
            'email' => $this->email,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName
        ];
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    protected function getInfoUser()
    {
        $statement = $this->query('SELECT * FROM utilisateurs WHERE id = ?', [$this->id]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function refresh()
    {
        $statement = $this->getInfoUser();
        $this->login = $statement['login'];
        $this->email = $statement['email'];
        $this->firstName = $statement['firstname'];
        $this->lastName = $statement['lastname'];
        return $this;
    }
}