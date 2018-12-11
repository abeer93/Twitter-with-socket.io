$(document).ready(function(){
    //get base URL
    var domainUrl = $('#domain-url').val();

    //display modal form for EDIT tweet
    $(document).on('click','#open-modal-btn',function(){
        var tweet_id = $(this).val();
        // Populate Data in Edit Modal Form
        $.get(domainUrl + '/tweets/' + tweet_id, function (tweet) {
            $('#tweet_id').val(tweet.id);
            $('#title').val(tweet.title);
            $('#description').val(tweet.description);
            $('#myModal').modal('show');
        });
    });

    // Update tweet
    $("#btn-save").click(function (e) {
        // prepare sending ajax request
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        
        e.preventDefault();
        // collect tweet data
        var tweet_id = $('#tweet_id').val();
        var tweet_title = $('#title').val();
        var tweet_description = $('#description').val();
        // check validation (title adn description should be not empty)
        if(tweet_title && tweet_description) {
            // prepare ajax form data
            var formData = {
                title: tweet_title,
                description: tweet_description,
            }
            // send ajax request to update tweet
            $.ajax({
                method: "PUT",
                url: domainUrl + '/tweets/' + tweet_id,
                data: formData,
                dataType: 'json',
                success: function (data) {
                    $('#tweet-title-h2').text(data.title);
                    $('#tweet-description-p').text(data.description);
                    $('#myModal').modal('hide');
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        } else {
            alert('Tweet title and tweet description should be filled');
        }
    });
});