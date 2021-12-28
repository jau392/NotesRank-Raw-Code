<?php
    $title = "Dashboard";
    include "header.php";
    require_once "db.php";
    userOnlyPage();
?>
<div class="row align-items-start gx-5">
    <div class="col-12">
        <h1 class="text-center mb-5 display-1">Welcome to NotesRank!</h1>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title text-center">Step 1</h1>
                <p class="card-text text-center lead">
                    Upload your notes
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title text-center">Step 2</h1>
                <p class="card-text text-center lead">
                    Rank others' notes
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title text-center">Step 3</h1>
                <p class="card-text text-center lead">
                    View results
                </p>
            </div>
        </div>
    </div>
</div>
<?php
    include "footer.php";
?>
