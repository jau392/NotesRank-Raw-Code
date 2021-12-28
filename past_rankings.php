<?php
    $title = "View Past Rankings";
    include "header.php";
    $leaderBoard = getTop3Notes();
?>
            <div class="row align-items-start gx-5 mb-5">
                <div class="col-12 mb-5">
                    <h1 class="display-4 text-center"><?php echo $title; ?> | Leaderboard</h1>
                </div>
                <div class="row align-items-start text-center">
                    <div class="col-4">
                        <h4>Rank #1</h4>
                        <div class="my-2">
                            <?php echo uploadEmbedHelper($leaderBoard[0],700); ?>
                        </div>
                    </div>
                    <div class="col-4">
                        <h4>Rank #2</h4>
                        <div class="my-2">
                            <?php echo uploadEmbedHelper($leaderBoard[1],700); ?>
                        </div>
                    </div>
                    <div class="col-4">
                        <h4>Rank #3</h4>
                        <div class="my-2">
                            <?php echo uploadEmbedHelper($leaderBoard[2],700); ?>
                        </div>
                    </div>
                </div>
            </div>
        
<?php
    include "footer.php";
?>