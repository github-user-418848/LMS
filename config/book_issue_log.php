<?php

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