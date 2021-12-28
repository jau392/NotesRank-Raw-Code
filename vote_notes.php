<?php
    $title = "Vote on Current Notes";
    include "header.php";
    $allNotesOrderById = allNotesOrderByIdDesc();

    if(isset($_POST) && isset($_POST['notesId']) && isset($_POST['rating']))
    {
        array_filter($_POST,'processPosts');
        if(is_numeric($_POST['notesId']) && is_numeric($_POST['rating']))
        {
            if(updateRating($_POST['notesId'],$_POST['rating']))
            {
                http_response_code(200);
                exit;
            }
            else
            {
                http_response_code(422);
                exit;
            }
        }
    }
?>
            <div class="row align-items-start gx-5 mb-5">
                <div class="col-12 mb-5">
                    <h1 class="display-4 text-center"><?php echo $title; ?></h1>
                    <p class="lead text-center">(ordered by upload date)</p>
                </div>
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <?php
                            if(count($allNotesOrderById) == 0)
                                echo '<p>No notes available for rating at this time.</p>';
                            else {   $processCards = "pdfCard-"; ?>
                                <div class="row mb-3">
                                    <div class="col-2"><span class="fa fa-arrow-left" style="font-size: 2rem; cursor:pointer;" onclick="prevProcessCards('pdfCard-')"></span></div>
                                    <div class="col-8"></div>
                                    <div class="col-2 text-end"><span class="fa fa-arrow-right" style="font-size: 2rem; cursor:pointer;" onclick="nextProcessCards('pdfCard-')"></span></div>
                                </div>
                                <?php
                                for($i=0;$i<count($allNotesOrderById);$i++)
                                {
                                    echo '<div id="pdfCard-'.$i.'" style="display:none;" data-noteid="'.$allNotesOrderById[$i]['id'].'">'.uploadEmbedHelper($allNotesOrderById[$i],700).'</div>';
                                }
                            }
                        ?>
                    </div>
                    <div class="col-md-6 text-center">
                        <h1 class="display-6">Any good? Rate it here!</h1>
                        <form method="post" onsubmit="return rateNotes('pdfCard-')">
                            <select class="form-select form-select-lg mb-3" id="currentNotesRating" required>
                                <option selected value="">Select rating out of 10</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                            <button class="btn btn-lg btn-primary" type="submit"><span class="spinner-border spinner-border-sm" style="display: none;" id="saveRatingStatus" role="status" aria-hidden="true"></span>Submit</button>
                        </form>
                    </div>
                </div>
            </div>

<?php
    include "footer.php";
?>
