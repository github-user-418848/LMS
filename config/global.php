<?php

    /*
        PDO::FETCH_ASSOC: returns an array indexed by column name
        PDO::FETCH_BOTH (default): returns an array indexed by both column name and number
        PDO::FETCH_BOUND: Assigns the values of your columns to the variables set with the ->bindColumn() method
        PDO::FETCH_CLASS: Assigns the values of your columns to properties of the named class. It will create the properties if matching properties do not exist
        PDO::FETCH_INTO: Updates an existing instance of the named class
        PDO::FETCH_LAZY: Combines PDO::FETCH_BOTH/PDO::FETCH_OBJ, creating the object variable names as they are used
        PDO::FETCH_NUM: returns an array indexed by column number
        PDO::FETCH_OBJ: returns an anonymous object with property names that correspond to the column names
    */

    // Always start a session

    session_start();

    // Database Configuration

    define("HOSTNAME", $_SERVER["HTTP_HOST"]);
    define("PORT", "3306");
    define("USERNAME", "root");
    define("PASSWORD", "");
    define("DB", "librarygh");
    define("SALT_COUNT", "12");

    // Paths
        
    define("DIR", basename(dirname(dirname(__FILE__))));
    define("SUB_DIR", basename(dirname(__FILE__)));
    define("BASE_URL", "//" . HOSTNAME . "/" . DIR);
    define("CURRENT_URL", $_SERVER['REQUEST_URI']);

    // Token Sessions
    
    if (!isset($_SESSION["csrf_token"])) {
        $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(16));
    }

    if (!isset($_SESSION["nonce"])) {
        $_SESSION['nonce'] = bin2hex(openssl_random_pseudo_bytes(32));
    }

    // Other Settings

    header("Content-Security-Policy: script-src 'self' 'nonce-" . $_SESSION['nonce'] . "'");
    date_default_timezone_set("Asia/Manila");
    
    // Global Functions

    function CheckActiveUrl($url) {
        return ($_SERVER['PHP_SELF'] == "/" . DIR . "/" . $url . ".php") ? "class='active'" : "";
    }

    function Redirect($msg="", $location=CURRENT_URL) {
        $_SESSION["msg"] = "{$msg}";
        header("Location: {$location}");
        die();
    }

    function Minify($buffer) {

        $search = array(
            '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
            '/[^\S ]+\</s',     // strip whitespaces before tags, except space
            '/(\s)+/s',         // shorten multiple whitespace sequences
            '/<!--(.|\s)*?-->/' // Remove HTML comments
        );

        $replace = array(
            '>',
            '<',
            '\\1',
            ''
        );

        $buffer = preg_replace($search, $replace, $buffer);

        return $buffer;
    }


    // Database Connection

    class DB {

        public function __construct($host=HOSTNAME, $port=PORT, $username=USERNAME, $password=PASSWORD, $db=DB) {

            $this -> host = $host;
            $this -> port = $port;
            $this -> username = $username;
            $this -> password = $password;
            $this -> db = $db;

            try {
                $this -> conn_str = new PDO("mysql:host={$this -> host};dbname={$this -> db};port={$this -> port};charset=utf8", $this -> username, $this -> password);
                $this -> conn_str -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $this -> conn_str -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this -> conn_str -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            }
            catch(PDOException $e) {
                die($e -> getMessage());
            }

        }
    }

    // Header Navbar Reference: https://1stwebdesigner.com/pure-css-navigation-menus/

    // I have maximized the security measures the best that I could, here is the reference: https://owasp.org/www-project-top-ten/2017/Top_10