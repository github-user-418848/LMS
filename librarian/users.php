<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/user_librarian.php");
    
    if (isset($_GET["submit"])) {
        $request = new Request_Validate($_GET, ["s", "csrf_token"]);
        $request -> redirect = "users.php";
        $request -> CSRF($_GET["csrf_token"]);
        $search = $request -> TextField($_GET["s"], 1);

        $user = new User("%{$search}%", "%{$search}%", "%{$search}%", "%{$search}%", "%{$search}%");
    }

    $user_list = $user -> List();

?>
    <div class="row justify-content-center">
        <div class="col-md-12 text-center">
            <h1>Users</h1>
            <form method="get">
                <input type="text" name="s" id="search" placeholder="Filter Users" <?=isset($search) ? "value='{$search}'" : ""?>>
                <input type="hidden" name="csrf_token" value="<?=$_SESSION["csrf_token"]?>">
                <input type="submit" value="Search" name="submit">
            </form>
            <?=isset($search) ? "<h3>Search results for: {$search}</h3>" : ""?>
        </div>
        <div class="col-md-3">
        <a class="btn" href="user_add.php">+ Add New User</a>
        </div>
    </div>
    <?php if (!empty($user_list)): ?>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="table-container">
                <table class="mx-auto table" cellspacing="0">
                    <tr class="table-head">
                        <th>Email</th>
                        <th>Username</th>
                        <th>Active? </th>
                        <th>Admin? </th>
                        <th colspan="2">Actions</th>
                    </tr>
                <?php foreach ($user_list as $key => $users): ?>
                    <tr <?=($users-> is_active === "false") ? "style='background: #ffff0061;'" : ""?>>
                        <td><?= $users -> email ?></td>
                        <td><?= $users -> username ?></td>
                        <td><?= $users -> is_active ?></td>
                        <td><?= $users -> is_admin ?></td>
                        <td>
                            <a href='user_update.php?id=<?=$users -> id?>&token=<?=$_SESSION["csrf_token"] ?>'>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                </svg>
                            </a>&nbsp;
                            <?php if ($users -> is_active === "true"): ?>
                                <a href='user_deactivate.php?id=<?=$users -> id?>&token=<?=$_SESSION["csrf_token"]?>'>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                    </svg>
                                </a>
                            <?php else: ?>
                                <a href='user_activate.php?id=<?=$users -> id?>&token=<?=$_SESSION["csrf_token"]?>'>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
    <?php elseif (empty($user_list)): ?>
        <hr><h1 class="text-center d-flex align-items-center justify-content-center" style="min-height: 50vh">No Users Available</h1><hr>
    <?php endif; ?>
<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/snippets/footer.php");?>