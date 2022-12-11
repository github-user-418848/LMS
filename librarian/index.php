<?php
    
    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/header.php");

    if (!$user -> Is_Logged_in() || !$user -> Is_Admin()) {
        Redirect(location: BASE_URL);
    }
?>
<div class="row justify-content-center">
    <div class="col-md-12 text-center">
        <h1>Welcome <?=$_SESSION["username"]?>!</h1>
    </div>
    <div class="col-md-7">
        <div class="card">
            <h2>Books</h2>
            <p>Test</p>
        </div>
    </div>
    <div class="col-md-5">
        <row>
            <div class="col-md-12">
                <div class="card">
                    <h2>Pending for approval (Users)</h2>
                    <p>Test</p>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <h2>Pending for approval (Books)</h2>
                    <p>Test</p>
                </div>
            </div>
        </row>
    </div>
</div>
<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/footer.php");