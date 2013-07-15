/**
 *
 */
var setSearchInitialPosition = function() {
    var viewport    = $(window).height(),
        searchFormH = $('#search-container').children('form').outerHeight(true);

    $('#search-container').animate({
        top: (viewport - searchFormH) / 2
    }, 800);
};

/**
 *
 */
var getActorCredits = function() {
    var r = '';

    $.ajax('inc/tmdb_api_impl.php', {
        data: {
            name: $('#search-actor-name').val()
        },
        success: function(response) {
            var $searchContainer = $('#search-container');

            $searchContainer.animate({top: 5}, {
                duration: 800,
                done: function() {
                    var $content       = $('#content'),
                        $personInfoDiv = $('.hero-unit'),
                        personData     = $.parseJSON(response),
                        personInfo     = personData.info,
                        personCredits  = personData.credits,
                        personHTML = '';

                    // console.log(personInfo);
                    personHTML = '<img src="http://d3gtl9l2a4fn1j.cloudfront.net/t/p/w500/' + personInfo.profile_path + ' class="img-rounded"><h1><a href="http://www.imdb.com/name/' + personInfo.imdb_id + '" target="_blank">' + personInfo.name + '</a></h1>';
                    personHTML += '<span>' + personInfo.place_of_birth +  '</span>';
                    $personInfoDiv.append(personHTML);

                    personHTML = '';

                    for (var i = 0, n = personCredits.cast.length; i < n; i++) {
                        cast = personCredits.cast[i];
                        personHTML += '<div><h3>' + cast.title + '</h3>';
                    }

                    $('#credits-list').append(personHTML);

                    $(this).addClass('navbar navbar-fixed-top');
                    $('body').css('padding-top', '80px');
                    $content.show();
                }
            });
        },
    });
};

/**
 *
 */
$(function() {
    setSearchInitialPosition();

    $('#search-button').click(function() {
        getActorCredits();
    });

    $('#search-actor-name').keypress(function(e) {
        if (e.which == 13) {
            getActorCredits();
        }
    });
});