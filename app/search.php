<div class="translucent"></div>
<!-- <button id="search_fab" class="search_button mdc-fab material-icons" aria-label="Favorite">
    <span class="mdc-fab__icon">
        search
    </span>
</button> -->

<div id="search_sheet" class="mdc-typography--body1">
    <header id="search_header" class="mdc-toolbar mdc-toolbar--fixed">
      <div class="mdc-toolbar__row">
        <section class="mdc-toolbar__section mdc-toolbar__section--align-start">
            <a href="#" id="search_close" class="material-icons mdc-toolbar__icon--menu">close</a>
            <form id="mal_search">
                <div class="mdc-textfield" id="search_textfield" data-demo-no-auto-js="">
                    <input type="text" class="mdc-textfield__input" id="search_query" name="search_query" autocomplete="off" placeholder="Search" onkeyup="showResults()">
                  </div>
            </form>
        </section>
      </div>
    </header>
    <div id="search_body">
        <div id="search_results">
            <ul id="search_results_list" class="mdc-list mdc-list--two-line mdc-list--dense">
                <!-- handled through mal_search.php -->
            </ul>
        </div>
    </div>
</div>