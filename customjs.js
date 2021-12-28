function openLogin()
{
    $("#registerSection").hide();
    $("#loginSection").fadeIn();
}
function openRegister()
{
    $("#registerSection").fadeIn();
    $("#loginSection").hide();
}
var currentShown = 0;
function processCards(cardStart,slideid)
{
    if(slideid == null)
    {
        $("#"+cardStart+"0").fadeIn();
    }
    else
    {
        if($("#"+cardStart+slideid).length)
        {
            $("#"+cardStart+currentShown).hide();
            $("#"+cardStart+slideid).fadeIn();
            currentShown = slideid;
        }
        else
        {
            $("#alertSection").append('<div class="alert alert-success alert-dismissible" role="alert">No more notes left.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')
        }
    }
}
function prevProcessCards(cardId)
{
    if(currentShown > 0)
        processCards(cardId,Number(currentShown)-1)
}
function nextProcessCards(cardId)
{
    processCards(cardId,Number(currentShown)+1)
}
function rateNotes(cardStart)
{
    $("#saveRatingStatus").fadeIn();
    let data = {
        notesId: $("#"+cardStart+currentShown).data("noteid"),
        rating: $("#currentNotesRating").val()
    }
    $.post( "vote_notes.php",data)
    .done(function( data ) {
        $("#alertSection").append('<div class="alert alert-success alert-dismissible" role="alert">Rating submitted successfully.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')
        $("#saveRatingStatus").hide();
    })
    .fail(function(data) {
        $("#alertSection").append('<div class="alert alert-danger alert-dismissible" role="alert">Unable to submit rating. You might have already voted on this notes.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')
        $("#saveRatingStatus").hide();
    })
    return false;
}