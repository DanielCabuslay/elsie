function fetchAniListData(id) {
    var query = `
    query ($idMal: Int) {
      Media (idMal: $idMal, type: ANIME) {
        id
        hashtag
        bannerImage
        nextAiringEpisode {
          airingAt
          episode
        }
        externalLinks {
          url
          site
        }
      }
    }
    `;
    var variables = {
        idMal: id
    };
    var url = 'https://graphql.anilist.co',
        options = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                query: query,
                variables: variables
            })
        };
    fetch(url, options).then(handleResponse)
                       .then(handleData)
                       .catch(handleError);
    function handleResponse(response) {
        return response.json().then(function (json) {
            return response.ok ? json : Promise.reject(json);
        });
    }
    function handleData(data) {
        populateAniListData(data);
    }
    function handleError(error) {
        console.error("No AniList data found");
    }
}

function populateAniListData(data) {
    var anilistID = data['data']['Media']['id'];
    var bgUrl = data['data']['Media']['bannerImage'];
    var hashtag = data['data']['Media']['hashtag'];
    var links = data['data']['Media']['externalLinks'];
    var nextEp = data['data']['Media']['nextAiringEpisode'];
    if (anilistID != null) {
        $('#anilist_link_button').css('display', 'inline-block');
        $('#anilist_link_button').attr('href', 'https://anilist.co/anime/' + anilistID);
    }
    if (bgUrl != null) {
        $('#anime_title_info').css('background', 'linear-gradient(transparent, rgba(0, 0, 0, 0.33), rgba(0, 0, 0, 0.67))');
        $('#anilist_banner').attr('src', bgUrl);
    }
    if (nextEp != null) {
        $('#next_episode').css('display', 'block');
        var airingAt = moment.unix(nextEp['airingAt']).format('MMM. D [at] h:mm a');
        $('#next_episode .mdc-list-item__text').html('Episode ' + nextEp['episode'] + 
            '<span class="mdc-list-item__text__secondary">' + airingAt + '</span>'
            );
    }
    if (links != null) {
        $('#external_links').css('display', 'block');
        for(var i = 0; i < links.length; i++) {
            $('#external_links ul').append('<a class="mdc-list-item" target="_blank" href="' + links[i]['url'] + '">' + 
                '<span class="mdc-list-item__text">' + links[i]['site'] + 
                '<span class="mdc-list-item__text__secondary">' + links[i]['url'] + '</span></span></a>');
        }
    }
    if (hashtag != null) {
        var hashtags = hashtag.split('#');
        for (var i = 1; i < hashtags.length; i++) {
            $('#hashtag').append('<a class="mdc-typography--body2" target="_blank" href="https://twitter.com/search?q=%23' + hashtags[i] + '">#' + hashtags[i] + '</a>');
        }
    }
} 