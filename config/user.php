<?php

class User extends DB {
        
    public function __construct($email=null, $username=null, $password=null, $is_active=null, $is_admin=null) {

        parent::__construct();

        $this -> email = $email;
        $this -> username = $username;
        $this -> password = $password;
        $this -> is_active = $is_active;
        $this -> is_admin = $is_admin;

        $this -> data = array($this -> email, $this -> username, $this -> password, $this -> is_active, $this -> is_admin);

    }

    public function Login($email, $password) {

        $stmt = $this -> conn_str -> prepare("SELECT * FROM user WHERE email = :email LIMIT 1");
        $stmt -> execute(array(":email" => $email));
        $stmtRow = $stmt -> fetch(PDO::FETCH_OBJ);

        if($stmt -> rowCount() > 0){
            if($email === $stmtRow -> email && password_verify($password, $stmtRow -> password)) {

                if ($stmtRow -> is_active === "false") {
                    Redirect("This account is disabled.");
                }
                else if ($stmtRow -> is_active === "true") {
                    
                    $_SESSION["id"] = $stmtRow -> id;
                    $_SESSION["email"] = $email;
                    $_SESSION["username"] = $stmtRow -> username;
                    $_SESSION["is_admin"] = $stmtRow -> is_admin;
                    $_SESSION["is_logged_in"] = "true";

                }
                else {
                    Redirect("Username or Password is Incorrect");
                }
            }
            else {
                Redirect("Username or Password is Incorrect");
            }
        }
        else {
            Redirect("This is not a registered user");
        }
    }

    public function Create() {
        
        $stmt = $this -> conn_str -> prepare("SELECT * FROM user WHERE email = :email LIMIT 1");
        $stmt -> execute(array(":email" => $this -> email));

        if ($stmt -> rowCount() > 0){
            Redirect("The provided email address has already been taken.");
        }
        else {
            $stmt = $this -> conn_str -> prepare("INSERT INTO user (email, username, password, is_active, is_admin) values (?, ?, ?, ?, ?)");
            $stmt->execute($this -> data);
        }
    }

    public function List($id=null) {
        if ($id !== null) {
            $stmt = $this -> conn_str -> prepare("SELECT * FROM user WHERE id=?");
            $stmt->execute(array($id));
            return $stmt -> fetch();
        }
        elseif ($this -> email !== null) {
            $stmt = $this -> conn_str -> prepare("SELECT * FROM user WHERE email LIKE :email OR username LIKE :username OR is_active LIKE :is_active OR is_admin LIKE :is_admin AND  id != {$_SESSION["id"]} LIMIT 50");
            $stmt -> bindParam('email', $this -> email);
            $stmt -> bindParam('username', $this -> username);
            $stmt -> bindParam('is_active', $this -> is_active);
            $stmt -> bindParam('is_admin', $this -> is_admin);
            $stmt->execute();
            return $stmt -> fetchAll();
        }
        else {
            $stmt = $this -> conn_str -> prepare("SELECT * FROM user WHERE id != {$_SESSION["id"]} ORDER BY id DESC LIMIT 50");
            $stmt->execute();
            return $stmt -> fetchAll();
        }
    }
    
    public function Update($id) {

        $stmt = $this -> conn_str -> prepare("SELECT * FROM user WHERE email = :email LIMIT 1");
        $stmt -> execute(array(":email" => $this -> email));
        $row = $stmt -> fetch();

        if ($stmt -> rowCount() > 0 && $this -> email !== $_SESSION["email"]){
            Redirect("The provided email address has already been taken.");
        }
        else {
            $stmt = $this -> conn_str -> prepare("UPDATE user SET email=?, username=?, password=?, is_active=?, is_admin=? WHERE id=?");
            array_push($this -> data, $id);
            $stmt->execute($this -> data);

            $_SESSION["email"] = $this -> email;
            $_SESSION["username"] = $this -> username;
            $_SESSION["is_admin"] = $this -> is_admin;

        }
    }

    
    public function Activate($id) {
        $stmt = $this -> conn_str -> prepare("UPDATE user SET is_active='true' WHERE id=:id");
        $stmt -> execute(array(":id" => $id));
    }

    public function Deactivate($id) {
        $stmt = $this -> conn_str -> prepare("UPDATE user SET is_active='false' WHERE id=:id");
        $stmt -> execute(array(":id" => $id));
    }

    public function Is_Logged_In() {
        return (isset($_SESSION["email"]) && isset($_SESSION["username"]) && isset($_SESSION["is_logged_in"])) ? true : false;
    }

    public function Is_Admin(){
        return (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] === "true") ? true : false;
    }

    public function Logout() {
        session_unset();
        session_destroy();
    }

}
