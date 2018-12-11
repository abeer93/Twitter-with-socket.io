$(document).ready(function(){
    // get logged user id
    var loggedUserId = $('#logged-user-id').val();
    // get application base URL
    var domainUrl = $('#domain-url').val();

    // handle on-click over favorite button
    $( document ).on('click','.favBtn',function(){
        var tweetId = $(this).val();
        var favBtnText = $(this).text();
        var url = domainUrl;
        // check if button clicked to favorite or un-favorite tweet
        if (favBtnText === 'Favorite') {
            url += '/favorite';
            sendAjax(url, 'POST', tweetId);
        } else if (favBtnText === 'Un-Favorite') {
            url += '/unfavorite';
            sendAjax(url, 'DELETE', tweetId);
        }
    });

    // send ajax requests
    function sendAjax(url, methodType, tweetId) {
        // prepare sending ajax request
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        // prepare ajax form data
        var formData = {
            tweetId: tweetId,
            userId: loggedUserId,
        }
        
        // send ajax request to update tweet
        $.ajax({
            method: methodType,
            url: url,
            data: formData,
            dataType: 'json',
            success: function (data) {
                // edit favorite tweet counter with the number of favorites
                $('#favBtnCount' + tweetId).text(data.countFavoritesOverTweet);
                // check if button clicked to favorite or un-favorite tweet
                var favoriteBtn = $('#favBtnNum' + tweetId);
                if (methodType === 'POST') {
                    favoriteBtn.text('Un-Favorite');
                    favoriteBtn.removeClass('btn-default').addClass('btn-primary');
                } else if (methodType == 'DELETE') {
                    favoriteBtn.text('Favorite');
                    favoriteBtn.removeClass('btn-primary').addClass('btn-default');
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });

    }
});