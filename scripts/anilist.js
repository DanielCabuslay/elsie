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
    var bgUrl = data['data']['Media']['bannerImage'];
    var hashtag = data['data']['Media']['hashtag'];
    var links = data['data']['Media']['externalLinks'];
    var nextEp = data['data']['Media']['nextAiringEpisode'];
    if (bgUrl != null) {
        $('#anilist_banner').attr('src', bgUrl);
        $('#anime_title_info').css('background', 'linear-gradient(transparent, rgba(0, 0, 0, 0.33), rgba(0, 0, 0, 0.67))');
    } else {
        $('#anime_title_info').css('background', 'var(--mdc-theme-primary)');
    }
    if (nextEp != null) {
        var airingAt = moment.unix(nextEp['airingAt']).format('MMM. D [at] h:mm a');
        $('#next_episode').html('<span class="mdc-typography--caption">Episode ' + nextEp['episode'] + ': ' +  airingAt + '</span>');
    }
    // if (links != null) {
    //     for(var i = 0; i < links.length; i++) {
    //         $('#external_links_menu ul').append('<a class="mdc-list-item" role="menuitem" tabindex="0" target="_blank" href="' + links[i]['url'] + '">' + links[i]['site'] + '</a>');
    //     }
    // }
    if (hashtag != null) {
        var hashtags = hashtag.split('#');
        for (var i = 1; i < hashtags.length; i++) {
            $('#hashtag').append('<a class="mdc-typography--body2" target="_blank" href="https://twitter.com/search?q=%23' + hashtags[i] + '">#' + hashtags[i] + '</a>');
        }
    }
} 