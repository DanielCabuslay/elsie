<aside id="info-dialog" class="mdc-dialog" role="alertdialog">
  <div class="mdc-dialog__surface">
    <header class="mdc-dialog__header">
        <img id="anilist_banner">
        <div id="anime_title_info">
            <img id="mal_poster">
            <div id="title_text">
                <h2 class="mdc-dialog__header__title"></h2>
                <div id="hashtag"></div>
                <div id="next_episode"></div>
            </div>
        </div>
    </header>
    <section class="mdc-dialog__body mdc-dialog__body--scrollable">
        <div class="mdc-list-group">
            <h3 class="mdc-list-group__subheader">Anime Info</h3>
            <ul class="mdc-list mdc-list--two-line mdc-list--dense">
                <li id="info_dialog_type" class="mdc-list-item">
                    <span class="mdc-list-item__text">Type
                        <span class="mdc-list-item__text__secondary"></span>
                    </span>
                </li>
                <li id="info_dialog_episodes" class="mdc-list-item">
                    <span class="mdc-list-item__text">Episodes
                        <span class="mdc-list-item__text__secondary"></span>
                    </span>
                </li>
                <li id="info_dialog_status" class="mdc-list-item">
                    <span class="mdc-list-item__text">Status
                        <span class="mdc-list-item__text__secondary"></span>
                    </span>
                </li>
                <li id="info_dialog_aired" class="mdc-list-item">
                    <span class="mdc-list-item__text">Aired
                        <span class="mdc-list-item__text__secondary"></span>
                    </span>
                </li>
                <li id="info_dialog_premiered" class="mdc-list-item">
                    <span class="mdc-list-item__text">Premiered
                        <span class="mdc-list-item__text__secondary">Spring 2017</span>
                    </span>
                </li>
            </ul>
        </div>
        <div class="mdc-list-group">
            <h3 class="mdc-list-group__subheader">Your Info</h3>
            <ul class="mdc-list mdc-list--two-line mdc-list--dense">
                <li id="info_dialog_user_status" class="mdc-list-item">
                    <span class="mdc-list-item__text">Status
                        <span class="mdc-list-item__text__secondary"></span>
                    </span>
                </li>
                <li id="info_dialog_user_episodes" class="mdc-list-item">
                    <span class="mdc-list-item__text">Episodes Watched
                        <span class="mdc-list-item__text__secondary"></span>
                    </span>
                </li>
                <li id="info_dialog_user_score" class="mdc-list-item">
                    <span class="mdc-list-item__text">Score
                        <span class="mdc-list-item__text__secondary"></span>
                    </span>
                </li>
                <li id="info_dialog_user_start_date" class="mdc-list-item">
                    <span class="mdc-list-item__text">Start Date
                        <span class="mdc-list-item__text__secondary"></span>
                    </span>
                </li>
                <li id="info_dialog_user_end_date" class="mdc-list-item">
                    <span class="mdc-list-item__text">Finish Date
                        <span class="mdc-list-item__text__secondary"></span>
                    </span>
                </li>
            </ul>
        </div>
    </section>
    <footer class="mdc-dialog__footer">
      <a id="mal_link_button" type="button" class="mdc-button mdc-dialog__footer__button" target="_blank">MyAnimeList</a>
      <button type="button" class="mdc-button mdc-dialog__footer__button mdc-dialog__footer__button--cancel">Close</button>
    </footer>
  </div>
  <div class="mdc-dialog__backdrop"></div>
</aside>