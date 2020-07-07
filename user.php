<?php


class utilisateurs
{
    private $id;
    public $login;
    public $email;
    public $password;
    public $firstname;
    public $lastname;
    public $db;


    public function bddaccess()
    {
        $this->db = mysqli_connect('localhost', 'root', '', 'classes');
    }

    public function register($login, $password, $email, $firstname, $lastname)
    {
        $request = mysqli_query($this->db, "INSERT INTO utilisateurs(login, password, email, firstname, lastname) VALUES ('$login', '$password', '$email', '$firstname', '$lastname')");
        $query = mysqli_query($this->db, $request);


        $querydeux=mysqli_query($this->db,'SELECT * FROM utilisateurs WHERE id= :id');

    }

    public function connect()
    {

        if (!isset($this->db)) {

            $this->db;

            if ($this->db) {
                $this->db = true;
                echo "connected";
                return true;
            } else {
                echo "failed";
                return false;
            }
        } else {
            echo "Déjà connecté <br/>";
            return false;
        }
    }

    public function disconnect()
    {
        if (isset($this->db)) {
            if (mysqli_close($this->db)) {
                $this->db = false;
                echo "connection closed";
                return true;
            } else {
                echo "failed to close connection";
                return false;
            }
        } else {
            echo "Aucune connexion";
        }
    }

    public function delete()
    {
        $requete2 = mysqli_query($this->db, "DELETE FROM utilisateurs WHERE id = :id");
        $this->id = null;
        $this->login = null;
        $this->email = null;
        $this->firstName = null;
        $this->lastName = null;
        mysqli_close($this->db);
    }

    public function update($login, $password, $email, $firstname, $lastname)
    {
        $request = mysqli_query($this->db, "SELECT '$login', '$password', '$email', '$firstname', '$lastname' FROM utilisateurs WHERE id = :id");
        $query = mysqli_query($this->db, $request);


        $request = mysqli_query($this->db, "UPDATE `utilisateurs` SET `login`=['$login'],`password`=['$password'],`email`=['$email'],`firstname`=['$firstname'],`lastname`=['$lastname'] WHERE id = :id");
        $querydeux = mysqli_query($this->db, $request);
    }

    public function isConnected()
    {
        if (isset($_SESSION)) {
            echo true . "<br/>";
            return true;
        } else {
            echo false . "<br/>";
            return false;
        }
    }

    public function getAllInfos()
    {
        return $this->login;
        return $this->email;
        return $this->firstname;
        return $this->lastname;


    }

    function getLogin()
    {
        return $this->login;
    }

    function getEmail()
    {
        return $this->email;
    }

    function getFirstname()
    {
        return $this->firstname;
    }

    function getLastname()
    {
        return $this->lastname;
    }

}


$register = new utilisateurs();
$register->bddaccess();
$register->register('yo', 'ahben', 'ahben@ahben.fr', 'allowiegehts', 'monsieur');
$register->connect();
$register->disconnect();
$register->delete();
$register->update('yop', 'ahbendacc', 'ahbendacc@ahbendacc.fr', 'allowiegehtsmeinfreund', 'monsieurs');
$register->isConnected();
$register->getAllInfos();
$register->getLogin();
$register->getEmail();
$register->getFirstname();
$register->getLastname();

?>