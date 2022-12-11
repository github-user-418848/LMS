<?php

    require_once "global.php";

    class Category extends DB {

        public function __construct($id=null, $name=null) {

            parent::__construct();

            $this -> id = $id;
            $this -> name = $name;
            
            $this -> data = array($this -> id, $this -> name);
        }

        public function List($id=null) {
            if ($id !== null) {
                $stmt = $this -> conn_str -> prepare("SELECT * FROM category WHERE id=?");
                $stmt->execute(array($id));
            }

            else {
                $stmt = $this -> conn_str -> prepare("SELECT * FROM category");
                $stmt->execute();
            }

            return $stmt -> fetchAll();
        }
    }

    class Book extends DB {

        public function __construct($isbn=null, $title=null, $author=null, $category=null, $copies=null) {

            parent::__construct();

            $this -> isbn = $isbn;
            $this -> title = $title;
            $this -> author = $author;
            $this -> category = $category;
            $this -> copies = $copies;

            $this -> data = array($this -> isbn, $this -> title, $this -> author, $this -> category, $this -> copies);

        }
        
        public function List($id=null) {
            if ($id !== null) {
                $stmt = $this -> conn_str -> prepare("SELECT * FROM book WHERE id=?");
                $stmt->execute(array($id));
            }
            elseif($this -> title !== null) {
                $stmt = $this -> conn_str -> prepare("SELECT * FROM book WHERE isbn LIKE ? OR title LIKE ? OR author LIKE ? OR CATEGORY LIKE ? OR COPIES LIKE ? LIMIT 50");
                $stmt->execute($this -> data);
            }
            else {
                $stmt = $this -> conn_str -> prepare("SELECT * FROM book");
                $stmt->execute();
            }

            return $stmt -> fetchAll();
        }

        public function Save() { 
            $stmt = $this -> conn_str -> prepare("INSERT INTO book (isbn, title, author, category, copies) values (?, ?, ?, ?, ?)");
            $stmt->execute($this -> data);
        }

        public function Update($id) {
            $stmt = $this -> conn_str -> prepare("UPDATE book SET isbn=?, title=?, author=?, category=?, copies=? WHERE id=?");
            array_push($this -> data, $id);
            $stmt->execute($this -> data);
        }

        public function Delete($id) {
            $stmt = $this -> conn_str -> prepare("DELETE FROM book WHERE id=?");
            $stmt->execute(array($id));
        }

    }


    class Pending_Books extends DB {

        public function __construct($user=null, $book=null, $copies=null) {

            parent::__construct();

            $this -> user = $user;
            $this -> book = $book;
            $this -> copies = $copies;

            $this -> data = array($this -> user, $this -> book, $this -> copies);

        }

        // "SELECT pending_book_requests.id 'id', pending_book_requests.copies 'copies', user.id 'user_id', user.username, user.email, 
        // book.id 'book_id', pending_book_requests.book_isbn, pending_book_requests.date 
        // FROM pending_book_requests join user on (pending_book_requests.member_name=user.username) 
        // join book on (pending_book_requests.book_isbn=book.isbn) WHERE user.id=?"
        
        public function List($id=null, $book_id=null) {
            if ($id !== null) {
                $stmt = $this -> conn_str -> prepare(
                    "SELECT pending_book_requests.id 'id', pending_book_requests.copies 'copies', user.id 'user_id', user.username, user.email, 
                    book.id 'book_id', pending_book_requests.book_isbn, pending_book_requests.date 
                    FROM pending_book_requests join user on (pending_book_requests.member_name=user.username) 
                    join book on (pending_book_requests.book_isbn=book.isbn) WHERE user.id=?"
                );
                $stmt->execute(array($id));
                
            }
            if ($book_id !== null) {
                $stmt = $this -> conn_str -> prepare(
                    "SELECT pending_book_requests.id 'id', pending_book_requests.copies 'copies', user.id 'user_id', user.username, user.email, 
                    book.id 'book_id', pending_book_requests.book_isbn, pending_book_requests.date 
                    FROM pending_book_requests join user on (pending_book_requests.member_name=user.username) 
                    join book on (pending_book_requests.book_isbn=book.isbn) WHERE pending_book_requests.id=?"
                );
                $stmt->execute(array($book_id));
                
            }
            else {
                $stmt = $this -> conn_str -> prepare(
                    "SELECT pending_book_requests.id 'id', pending_book_requests.copies 'copies', user.id 'user_id', user.username, user.email, 
                    book.id 'book_id', book.copies 'copies', pending_book_requests.book_isbn, pending_book_requests.date 
                    FROM pending_book_requests join user on (pending_book_requests.member_name=user.username) 
                    join book on (pending_book_requests.book_isbn=book.isbn)"
                );
                $stmt->execute();
            }
            return $stmt -> fetchAll();
        }

        public function Approve() {
            // decrease number of books
            // insert into issued books
        }

        public function Remove($id) {
            $stmt = $this -> conn_str -> prepare("DELETE FROM pending_book_requests WHERE id=?");
            $stmt->execute(array($id));
        }

        public function Save() {
            
            $stmt = $this -> conn_str -> prepare("SELECT * FROM book WHERE isbn=?");
            $stmt->execute(array($this -> book));
            $book = $stmt -> fetch();

            if ($this -> copies <= $book -> copies) {
                $stmt = $this -> conn_str -> prepare("INSERT INTO pending_book_requests (member_name, book_isbn, copies) values (?, ?, ?)");
                $stmt->execute($this -> data);
            }
            else {
                Redirect("Number of copies should be less than {$book -> copies}");
            }


        }

        
        
    }


    class Book_Issue_Log extends DB {


        public function __construct($user=null, $book=null, $due_date=null, $last_reminded=null) {

            parent::__construct();

            $this -> user = $user;
            $this -> book = $book;
            $this -> due_date = $due_date;
            $this -> last_reminded = $last_reminded;

            $this -> data = array($this -> user, $this -> book, $this -> due_date, $this -> last_reminded);

            // CALL MAIL DEFAULT HERE
        }

        
        public function List($user=null) {
            if ($user !== null) {
                $stmt = $this -> conn_str -> prepare("SELECT * FROM book_issue_log WHERE member_name=?");
                $stmt->execute(array($user));
            }
            else {
                $stmt = $this -> conn_str -> prepare("SELECT * FROM book_issue_log");
                $stmt->execute();
            }
            return $stmt -> fetchAll();
        }

        // IF DUE DATE THEN EMAIL USER

        // $to = "somebody@example.com, somebodyelse@example.com";
        // $subject = "HTML email";

        // $message = "
        // <html>
        // <head>
        // <title>HTML email</title>
        // </head>
        // <body>
        // <p>This email contains HTML Tags!</p>
        // <table>
        // <tr>
        // <th>Firstname</th>
        // <th>Lastname</th>
        // </tr>
        // <tr>
        // <td>John</td>
        // <td>Doe</td>
        // </tr>
        // </table>
        // </body>
        // </html>
        // ";

        // // Always set content-type when sending HTML email
        // $headers = "MIME-Version: 1.0" . "\r\n";
        // $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // // More headers
        // $headers .= 'From: <webmaster@example.com>' . "\r\n";
        // $headers .= 'Cc: myboss@example.com' . "\r\n";

        // mail($to,$subject,$message,$headers);

    }

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
                        Redirect("This account has been disabled.");
                    }
                    else if ($stmtRow -> is_active === "pending") {
                        Redirect("Please ask assistance from the administrator to activate this account.");
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
            }
            elseif ($this -> email !== null) {
                $stmt = $this -> conn_str -> prepare("SELECT * FROM user WHERE email LIKE :email OR username LIKE :username OR is_active LIKE :is_active OR is_admin LIKE :is_admin AND  id != {$_SESSION["id"]} LIMIT 50");
                $stmt -> bindParam('email', $this -> email);
                $stmt -> bindParam('username', $this -> username);
                $stmt -> bindParam('is_active', $this -> is_active);
                $stmt -> bindParam('is_admin', $this -> is_admin);
                $stmt->execute();
            }
            else {
                $stmt = $this -> conn_str -> prepare("SELECT * FROM user WHERE id != {$_SESSION["id"]} LIMIT 50");
                $stmt->execute();
            }
            return $stmt -> fetchAll();
        }
        
        public function Update($id) {
            if ($this -> password === null) {
                $stmt = $this -> conn_str -> prepare("UPDATE user SET email=:email, username=:username, is_active=:is_active, is_admin=:is_admin WHERE id=:id");
                $stmt -> bindParam('email', $this -> email);
                $stmt -> bindParam('username', $this -> username);
                $stmt -> bindParam('is_active', $this -> is_active);
                $stmt -> bindParam('is_admin', $this -> is_admin);
                $stmt -> bindParam('id', $id);
                $stmt->execute();
            }
            else {
                $stmt = $this -> conn_str -> prepare("UPDATE user SET email=?, username=?, password=?, is_active=?, is_admin=? WHERE id=?");
                array_push($this -> data, $id);
                $stmt->execute($this -> data);
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

    class Request_Validate {

        public function __construct($method, $fields) {

            $this -> method = $method;
            $this -> fields = $fields;
            $this -> redirect = CURRENT_URL;

            $this -> Fields($this -> method, $this -> fields);

        }

        public function TextField($value, $min_length=3, $max_length=80) {
            if ($this -> Output($value) && strlen($value) >= $min_length && strlen($value) <= $max_length) {
                return $this -> Output($value);
            }
            else {
                Redirect("It should be longer than {$min_length} characters and should not exceed of {$max_length} characters", $this -> redirect);
            }
        }
        
        public function DigitField($value, $min_length=1, $max_length=32) {
            if (ctype_digit((string)$value) ) {
                if ($value === "0") {
                    Redirect("Cannot accept 0 as a value", $this -> redirect);
                }
                else {
                    if (strlen($value) >= $min_length && strlen($value) <= $max_length) {
                        return $this -> Output($value);
                    }
                    else {
                        Redirect("Minimum of {$min_length} and a maximum of {$max_length} input characters are accepted only.", $this -> redirect);
                    }
                }
            }
            else {
                Redirect("Digits are only accepted.", $this -> redirect);
            }
        }

        public function EmailField($value) {
            if (filter_var($this -> Output($value), FILTER_VALIDATE_EMAIL)) {
                return $this -> Output($value);
            }
            else {
                Redirect("Input must be an email. Please try again.", $this -> redirect);
            }
        }

        public function ChoicesField($value, $array) {
            if (in_array($value, $array)) {
                return $this -> Output($value);
            }
            else {
                Redirect("Select from the value of the choices only.", $this -> redirect);
            }
        }

        public function PasswordField($value) {
            return $this -> Output($this -> TextField(password_hash($value, PASSWORD_BCRYPT, ['cost' => SALT_COUNT])));
        }

        public function CheckBoxField($value) {
            if (isset($value)) {
                return "true";
            }
            else {
                return "false";
            }
        }

        public function DateField($value) {
            $arr  = explode('/', $value);
            if (count($arr) == 3) {
                return (checkdate($this -> DigitField($arr[0]), $this -> DigitField($arr[1]), $this -> DigitField($arr[2]))) ? $arr[0]."/".$arr[1]."/".$arr[2] : "Not a valid date";
            }
            else {
                Redirect("Not a valid date", $this -> redirect);
            }
        }

        // Could be optional, but it is most often recommended to be added as much as possible

        public function CSRF($value) {
            if (!isset($_SESSION["csrf_token"]) || $this -> TextField($value) !== $_SESSION["csrf_token"]) {
                Redirect("Token has been expired/invalid. Please try again.", $this -> redirect);
            }
        }
        
        public function Fields($method, $fields) {
            foreach ($fields as $field) {
                if (!in_array($field, array_keys($method))) {
                    Redirect("Some fields are missing. Please try again and don't do that.", $this -> redirect);
                }
            }
        }

        public function Output($input) {
            if (!empty($input)) {
                return htmlspecialchars(stripslashes(trim($input)), ENT_QUOTES, "UTF-8");
            }
            else {
                Redirect("Input shouldn't be empty.", $this -> redirect);
            }
        }
    }
