<aside id="edit_dialog" class="mdc-dialog" role="alertdialog" aria-labelledby="my-mdc-dialog-label" aria-describedby="my-mdc-dialog-description">
  <div class="mdc-dialog__surface">
    <header id="edit_dialog_header" class="mdc-dialog__header">
      <section class="mdc-toolbar__section mdc-toolbar__section--align-start">
            <button type="button" class="material-icons mdc-toolbar__icon--menu menu mdc-dialog__footer__button mdc-dialog__footer__button--cancel">close</button>
            <span class="mdc-toolbar__title">Edit Anime Details</span>
        </section>
        <section class="mdc-toolbar__section mdc-toolbar__section--align-end">
            <button type="button" class="mdc-button mdc-dialog__footer__button--accept">Save</button>
        </section>
    </header>
    <section id="edit_dialog_body" class="mdc-dialog__body mdc-dialog__body--scrollable">
        <div id="edit_dialog_anime_info" class="edit_dialog_body_section">
            <img id="edit_dialog_image" src="<?= $animeInfo->image ?>">
            <span class="mdc-typography--title"><?= $animeInfo->title ?></span>
        </div>

        <hr class="mdc-list-divider">
        
        <?php if($userSaved): ?>
            <form id="user_details">
                <div id="user_status_section" class="edit_dialog_body_section">
                    <i class="material-icons">tv</i>
                    <select id="user_status" class="mdc-select" default="<?= $userInfo->my_status ?>">
                      <!-- <option value="" default selected>Pick a food</option> -->
                      <option value="1">Watching</option>
                      <option value="2">Completed</option>
                      <option value="3">On Hold</option>
                      <option value="4">Dropped</option>
                      <option value="6">Plan to Watch</option>
                    </select>
                </div>

                <hr class="mdc-list-divider">

                <div id="user_episode_section" class="edit_dialog_body_section">
                    <i class="material-icons">playlist_add_check</i>
                    <div id="user_episode_textfield" class="mdc-textfield" data-demo-no-auto-js>
                        <input type="text" id="user_episode" class="mdc-textfield__input" size="3" type="number" value="<?php if ($userInfo->my_rewatching == 0) { echo $userInfo->my_watched_episodes; } else { echo $userInfo->my_rewatching_ep; } ?>"> / <?= $animeInfo->episodes ?>
                    </div>
                    <div class="mdc-form-field">
                        <div class="mdc-checkbox">
                          <input type="checkbox"
                                 id="basic-checkbox"
                                 class="mdc-checkbox__native-control" <?php if ($userInfo->my_rewatching != 0) { echo 'checked';} ?>/>
                          <div class="mdc-checkbox__background">
                            <svg class="mdc-checkbox__checkmark"
                                 viewBox="0 0 24 24">
                              <path class="mdc-checkbox__checkmark__path"
                                    fill="none"
                                    stroke="white"
                                    d="M1.73,12.91 8.1,19.28 22.79,4.59"/>
                            </svg>
                            <div class="mdc-checkbox__mixedmark"></div>
                          </div>
                        </div>
                        <label for="basic-checkbox">Rewatching</label>
                      </div>
                     <!-- <div><?= $userInfo->my_rewatching ?></div> -->
                </div>

                <hr class="mdc-list-divider">

                <div id="user_score_section" class="edit_dialog_body_section">
                    <i class="material-icons">star</i>
                    <select id="user_score" class="mdc-select" default="<?= $userInfo->my_score ?>">
                      <option value="0">No Score</option>
                      <option value="1">1 (Appalling)</option>
                      <option value="2">2 (Horrible)</option>
                      <option value="3">3 (Very Bad)</option>
                      <option value="4">4 (Bad)</option>
                      <option value="5">5 (Average)</option>
                      <option value="6">6 (Fine)</option>
                      <option value="7">7 (Good)</option>
                      <option value="8">8 (Very Good)</option>
                      <option value="9">9 (Great)</option>
                      <option value="10">10 (Masterpiece)</option>
                    </select>
                </div>

                <hr class="mdc-list-divider">

                <div id="user_date_section" class="edit_dialog_body_section">
                    <i class="material-icons">date_range</i>
                    <select id="user_start_year" class="mdc-select" default="<?= substr($userInfo->my_start_date, 0, 4) ?>">
                      <option value="0000"></option>
                      <option value="2017">2017</option>
                      <option value="2016">2016</option>
                      <option value="2015">2015</option>
                      <option value="2014">2014</option>
                      <option value="2013">2013</option>
                      <option value="2012">2012</option>
                      <option value="2011">2011</option>
                      <option value="2010">2010</option>
                    </select>
                    <select id="user_start_month" class="mdc-select" default="<?= substr($userInfo->my_start_date, 5, 2) ?>">
                      <option value="00"></option>
                      <option value="01">January</option>
                      <option value="02">February</option>
                      <option value="03">March</option>
                      <option value="04">April</option>
                      <option value="05">May</option>
                      <option value="06">June</option>
                      <option value="07">July</option>
                      <option value="08">August</option>
                      <option value="09">September</option>
                      <option value="10">October</option>
                      <option value="11">November</option>
                      <option value="12">December</option>
                    </select>
                    <select id="user_start_day" class="mdc-select" default="<?= substr($userInfo->my_start_date, 8, 2) ?>">
                      <option value="00"></option>
                      <option value="01">1</option>
                      <option value="02">2</option>
                      <option value="03">3</option>
                      <option value="04">4</option>
                      <option value="05">5</option>
                      <option value="06">6</option>
                      <option value="07">7</option>
                      <option value="08">8</option>
                      <option value="09">9</option>
                      <option value="10">10</option>
                      <option value="11">11</option>
                      <option value="12">12</option>
                      <option value="13">13</option>
                      <option value="14">14</option>
                      <option value="15">15</option>
                      <option value="16">16</option>
                      <option value="17">17</option>
                      <option value="18">18</option>
                      <option value="19">19</option>
                      <option value="20">20</option>
                      <option value="21">21</option>
                      <option value="22">22</option>
                      <option value="23">23</option>
                      <option value="24">24</option>
                      <option value="25">25</option>
                      <option value="26">26</option>
                      <option value="27">27</option>
                      <option value="28">28</option>
                      <option value="29">29</option>
                      <option value="30">30</option>
                      <option value="31">31</option>
                    </select>
                    <br>
                    <i class="material-icons" style="visibility: hidden;">event_available</i>
                    <select id="user_finish_year" class="mdc-select" default="<?= substr($userInfo->my_finish_date, 0, 4) ?>">
                      <option value="0000"></option>
                      <option value="2017">2017</option>
                      <option value="2016">2016</option>
                      <option value="2015">2015</option>
                      <option value="2014">2014</option>
                      <option value="2013">2013</option>
                      <option value="2012">2012</option>
                      <option value="2011">2011</option>
                      <option value="2010">2010</option>
                    </select>
                    <select id="user_finish_month" class="mdc-select" default="<?= substr($userInfo->my_finish_date, 5, 2) ?>">
                      <option value="00"></option>
                      <option value="01">January</option>
                      <option value="02">February</option>
                      <option value="03">March</option>
                      <option value="04">April</option>
                      <option value="05">May</option>
                      <option value="06">June</option>
                      <option value="07">July</option>
                      <option value="08">August</option>
                      <option value="09">September</option>
                      <option value="10">October</option>
                      <option value="11">November</option>
                      <option value="12">December</option>
                    </select>
                    <select id="user_finish_day" class="mdc-select" default="<?= substr($userInfo->my_finish_date, 8, 2) ?>">
                      <option value="00"></option>
                      <option value="01">1</option>
                      <option value="02">2</option>
                      <option value="03">3</option>
                      <option value="04">4</option>
                      <option value="05">5</option>
                      <option value="06">6</option>
                      <option value="07">7</option>
                      <option value="08">8</option>
                      <option value="09">9</option>
                      <option value="10">10</option>
                      <option value="11">11</option>
                      <option value="12">12</option>
                      <option value="13">13</option>
                      <option value="14">14</option>
                      <option value="15">15</option>
                      <option value="16">16</option>
                      <option value="17">17</option>
                      <option value="18">18</option>
                      <option value="19">19</option>
                      <option value="20">20</option>
                      <option value="21">21</option>
                      <option value="22">22</option>
                      <option value="23">23</option>
                      <option value="24">24</option>
                      <option value="25">25</option>
                      <option value="26">26</option>
                      <option value="27">27</option>
                      <option value="28">28</option>
                      <option value="29">29</option>
                      <option value="30">30</option>
                      <option value="31">31</option>
                    </select>
                </div>

                <hr class="mdc-list-divider">

                <div id="user_tag_section" class="edit_dialog_body_section">
                    <i class="material-icons">label</i>
                    <div class="mdc-textfield mdc-textfield--multiline">
                      <textarea class="mdc-textfield__input" id="user_tags" rows="8" cols="26" placeholder="Tags"><?= $userInfo->my_tags ?></textarea>
                    </div>
                </div>
            </form>
        <?php endif;?>
    </section>
  </div>
  <div class="mdc-dialog__backdrop"></div>
</aside>