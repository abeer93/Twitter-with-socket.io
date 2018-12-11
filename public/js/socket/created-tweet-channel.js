$( document ).ready(() => {
    var socket = io('http://localhost:3000/');
    
    var loggedUserId = $('#logged-user-id').val();    
    var domainUrl = $('#domain-url').val();
    var newTweetsDiv = $("#new-tweets-div");
    var oldTweetsDiv = $("#old-tweets-div");
    var btnLoad = $('#btn-load');

    // listen to new messges
    socket.on('tweet-created:App\\Events\\TweetCreatedEvent', function(data) {
        tweet = data.tweet;
        followers = data.followers;
        
        // check if current logged user is follow the tweet publisher
        if($.inArray(loggedUserId, followers)) {
            // draw new tweet html
            var tweetHtml = '<a href="' + domainUrl +'/tweets/' + tweet.id + '"><h2>' 
            + tweet.title + '</h2></a><p>' + tweet.description + 
            '</p><button class="btn" id="favBtnCount' + tweet.id + '">0</button> \n' +
            '<button class="btn btn-default favBtn" value="' + tweet.id + 
            '" id="favBtnNum' + tweet.id + '">Favorite</button>';
            // append new tweet to div which view new tweets
            newTweetsDiv.prepend(tweetHtml);
            // show button to notify user with new tweets
            btnLoad.show();
            // on-click on button which notify logged users that new tweets exist
            $('#new-tweet-btn').on('click', function() {
                // display new tweets and hide the button
                newTweetsDiv.show();
                btnLoad.hide();
                // hide div that display new tweets after 2 second
                setTimeout(function() {
                    oldTweetsDiv.prepend(newTweetsDiv.html());
                    newTweetsDiv.hide();
                }, 2000);
            });
        }     
    });
});