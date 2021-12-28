<?php
    $title = "Upload Current Notes";
    include "header.php";
    $myUploads = getMyPastUploads();
    if(isset($_POST) && isset($_POST['notesUpload']))
    {
        array_filter($_POST,'processPosts');
        $targetfolder = "uploads/".md5(time()).".pdf";
        if(isset($_POST['title']) && isset($_POST['comments']) && isset($_FILES['notes_pdf']) && $_FILES['notes_pdf']['error'] == 0 && $_FILES['notes_pdf']['type'] == "application/pdf")
        {
            if( move_uploaded_file($_FILES['notes_pdf']['tmp_name'], $targetfolder) && uploadNotes($_POST['title'],$_POST['comments'],$targetfolder))
            {
                $myUploads = getMyPastUploads();
                $successMessages[] = "Upload Successful";
            }
            else
                $errorMessages[] = "Unable to upload your notes. Please try again.";
        }
        else
        {
            $errorMessages[] = "All fields are mandatory, check for blanks. Make sure you are uploading a valid PDF file.";
        }
    }
?>
            <div class="row align-items-start gx-5 mb-5">
                <div class="row align-items-start">
                    <div class="col-md-6">
                        <h1 class="display-5 mb-3 text-center"><?php echo $title; ?></h1>
                        <form method="post" enctype="multipart/form-data">
                            <div class="col-12 mb-3">
                                <label for="title" class="form-label">Enter notespage title:</label>
                                <input type="text" name="title" id="title" class="form-control" />
                            </div>
                            <div class="col-12 mb-3">
                                <label for="notes_pdf" class="form-label">Upload file (Type: PDF, Max File Size: <?php echo getMaximumFileUploadSize(); ?>MB):</label>
                                <input type="file" name="notes_pdf" id="notes_pdf" class="form-control" accept="application/pdf" required/>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="comments" class="form-label">Add comments to your upload:</label>
                                <textarea name="comments" id="comments" class="form-control" required></textarea>
                            </div>
                            <div class="col-12 text-center">
                                <input type="submit" name="notesUpload" value="Upload your notes" class="btn btn-primary btn-lg mx-auto" />
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <h1 class="text-center display-5 mb-3">Your Past Uploads</h1>
                        <?php
                            if(count($myUploads) == 0)
                                echo "<p>You haven't uploaded any notes yet.</p>";
                            else
                            {
                                //echo uploadEmbedHelper($myUploads[0]);
                                ?>
                                <div class="row mb-3">
                                    <div class="col-2"><span class="fa fa-arrow-left" style="font-size: 2rem; cursor:pointer;" onclick="prevProcessCards('pdfCard-')"></span></div>
                                    <div class="col-8"></div>
                                    <div class="col-2 text-end"><span class="fa fa-arrow-right" style="font-size: 2rem; cursor:pointer;" onclick="nextProcessCards('pdfCard-')"></span></div>
                                </div>
                                <?php
                                if(count($myUploads) > 0)
                                    $processCards = "pdfCard-";

                                    for($i=0;$i<count($myUploads);$i++)
                                    {
                                        echo '<div id="pdfCard-'.$i.'" style="display:none;" data-noteid="'.$myUploads[$i]['id'].'">'.uploadEmbedHelper($myUploads[$i]).'</div>';
                                    }

                                /*
                                foreach($myUploads as $upload)
                                {

                                }
                                */
                            }
                        ?>
                    </div>
                </div>
            </div>

<?php
    include "footer.php";
?>
