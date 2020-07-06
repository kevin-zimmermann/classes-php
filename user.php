<?php


class utilisateurs
{
    private $id;
    public $login;
    public $email;
    public $password;
    public $firstname;
    public $lastname;

    public function register($login, $password, $email, $firstname, $lastname)
    {
        $db = mysqli_connect('localhost', 'root', '', 'classes');
        $request = 'INSERT INTO `utilisateurs`(`id`, `login`, `password`, `email`, `firstname`, `lastname`) VALUES (null ,[value-2],[value-3],[value-4],[value-5],[value-6])';
        $query = mysqli_query($db, $request);

        $req = 'SELECT * FROM utilisateurs';
        $query = mysqli_query($db, $req);
        $account = mysqli_fetch_all($query);
        var_dump($account);
        return $account;
    }

}

$register = new utilisateurs();
$register->register('lolmdr', 'admin', 'admin@admin.fr', 'lol', 'mdr');
?>

<html>
<body>

<form action="user.php" method="post">

    login: <input type="text" name="login"/>
    password: <input type="password" name="password"/>
    email: <input type="email" name="email"/>
    firstname : <input type="text" name="firstname"/>
    lastname: <input type="text" name="lastname"/>

    <input type="submit"/>
</form>

</body>
</html>

