import $, { data } from 'jquery';

class Search {
    // 1. describe and create/initiate our object
    constructor() {
        this.addSearchHtml();
        this.openButton = $(".js-search-trigger") ;
        this.closeButton = $(".search-overlay__close");
        this.searchOverlay = $(".search-overlay");
        this.searchField = $("#search-term");
        this.resultsDiv = $("#search-overlay__results");
        this.events();
        this.isOverlayOpen = false;
        this.typingTimer;
        this.IsSpinnerVisible = false;
        this.prevSearchValue;
    }

    // 2. events ( happens e.g. when click on an element )
    events() {
        this.openButton.on("click", this.openOverlay.bind(this));
        this.closeButton.on("click", this.closeOverlay.bind(this));
        $(document).on("keydown", this.keyPressDispatcher.bind(this));
        this.searchField.on("keyup", this.typingLogic.bind(this));
    }


    // 3. Methods ( functions/ actions..)
    typingLogic() {
        // to ensure this code will not run if the user uses arrows keys or something similar
        if (this.prevSearchValue != this.searchField.val()) {
            clearTimeout(this.typingTimer);

            // check if there is no term in the search field, if so, there is no need to show results or anything
            if (this.searchField.val()) {
                // there is something in the search field
                if (!this.IsSpinnerVisible) {

                    this.resultsDiv.html('<div class="spinner-loader"></div>');
                    this.IsSpinnerVisible = true;
                }

                this.typingTimer = setTimeout(this.getResults.bind(this), 750);

            } else {
                // empty search field
                this.resultsDiv.html('');
                this.IsSpinnerVisible = false;
            }
            
        }
        
        this.prevSearchValue = this.searchField.val();
        
    }

    getResults() {
        $.getJSON(universityData.root_url + '/wp-json/university/v1/search?term=' + this.searchField.val(), (results) => {
            this.resultsDiv.html(`
            <div class="row">
                <div class="col one-third">
                    <h2 class="search-overlay__section-title">General Information</h2>
                    
                        ${results.generalInfo.length ? '<ul class="link-list min-list">' : '<p>Sorry, there is no posts/ pages match the search!</p>'}
                            ${results.generalInfo.map(item => `<li><a href="${item.permalink}">${item.title}</a> ${item.postType == 'post' ? `by ${item.authorName}` : ''}</li>`).join('')}
                        ${results.generalInfo.length ? '</ul>' : ''}
                    
                </div>
                <div class="col one-third">
                    <h2 class="search-overlay__section-title">Programs</h2>
                   
                        ${results.programs.length ? '<ul class="link-list min-list">' : `<p>Sorry, there is no programs match the search! See <a href="${universityData.root_url + '/programs'}">all programs</a></p>`}
                            ${results.programs.map(item => `<li><a href="${item.permalink}">${item.title}</a></li>`).join('')}
                        ${results.programs.length ? '</ul>' : ''}
                    
                    <h2 class="search-overlay__section-title">Professors</h2>
                    ${results.professors.length ? '<ul class="professor-cards">' : `<p>Sorry, there is no professors match the search!</p>`}
                            ${results.professors.map(item => `
                            <li class="professor-card__list-item">
                                <a class="professor-card" href="${item.permalink}">
                                    <img class="professor-card__image" src="${item.image}" alt="">
                                    <span class="professor-card__name">${item.title}</span>
                                </a>
                            </li>`).join('')}
                        ${results.professors.length ? '</ul>' : ''}

                </div>
                <div class="col one-third">
                    <h2 class="search-overlay__section-title">Campuses</h2>
                        ${results.campuses.length ? '<ul class="link-list min-list">' : `<p>Sorry, there is no campuses match the search! See <a href="${universityData.root_url + '/campuses'}">all campuses</a></p>`}
                            ${results.campuses.map(item => `<li><a href="${item.permalink}">${item.title}</a></li>`).join('')}
                        ${results.campuses.length ? '</ul>' : ''}

                    <h2 class="search-overlay__section-title">Events</h2>
                    ${results.events.length ? '' : `
                        <p>Sorry, there is no events match the search! See <a href="${universityData.root_url + '/events'}">all events</a></p>`}
                    
                        ${results.events.map(item => `
                            <div class="event-summary">
                                <a class="event-summary__date t-center" href="<?php the_permalink(); ?>">
                            
                                    <span class="event-summary__month">${item.month}</span>
                                    <span class="event-summary__day">${item.day}</span>
                                </a>
                                <div class="event-summary__content">
                                    <h5 class="event-summary__title headline headline--tiny"><a href="${item.permalink}">${item.title}</a></h5>
                                    <p>${item.description} <a href="${item.permalink}" class="nu gray">Learn more</a></p>
                                </div>
                            </div>
                        
                        `).join('')}
                        
                </div>
            </div>
            `);
            this.IsSpinnerVisible = false; 
        });
       

    }

    // us this function when sending multiple requests to the server
    getResultsAsynchronous(){
        // Asynchronous request
        $.when(
            // for more information read the rest api for wordpress: https://developer.wordpress.org/rest-api/
            $.getJSON(universityData.root_url + '/wp-json/wp/v2/posts?search=' + this.searchField.val()),
            $.getJSON(universityData.root_url + '/wp-json/wp/v2/pages?search=' + this.searchField.val())
        ).then( (posts, pages) => {
            var combinedResults = posts[0].concat(pages[0]);
            this.resultsDiv.html(`
                <h2 class="search-overlay__section-title">General Information</h2>
                ${combinedResults.length ? '<ul class="link-list min-list">' : '<p>Sorry, there is no results!</p>'}
                    ${combinedResults.map(item => `<li><a href="${item.link}">${item.title.rendered}</a> ${ item.type == 'post' ? `by ${item.authorName}` : ''}</li>`).join('')}
                ${combinedResults.length ? '</ul>' : ''}
            `);
            this.IsSpinnerVisible = false;
        }, () => {
            this.resultsDiv.html('<p>Unexpected error. Please try again.</p>');
        });
        
    }

    keyPressDispatcher(e) {
        //console.log(e.keyCode);

        // check if:
        // 1. pressed s key
        // 2. the search div is not opened yet
        // 3. the user didn't press on s key, while he is in an input text field :)
        if (e.keyCode == 83 && !this.isOverlayOpen && !$("input, textarea").is(':focus')) {
            this.openOverlay();
        }

        if (e.keyCode == 27 && this.isOverlayOpen) {
            this.closeOverlay();
        }
    }

    openOverlay() {
        this.searchOverlay.addClass("search-overlay--active");
        $("body").addClass("body-no-scroll");
        this.searchField.val('');
        this.resultsDiv.html('');
        // put the cursor inside the search field after the overlay is opened..
        setTimeout(() => {
            this.searchField.trigger('focus');
        }, 301);
        this.isOverlayOpen = true;
        //console.log("openOverlay method is ran");
        return false;
    }

    closeOverlay() {
        this.searchOverlay.removeClass("search-overlay--active");
        $("body").removeClass("body-no-scroll");
        this.isOverlayOpen = false;
        console.log("closeOverlay method is ran");
    }

    addSearchHtml() {
        $("body").append(`
            <div class="search-overlay">
                <div class="search-overlay__top">
                    <div class="container">
                        <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
                        <input type="text" class="search-term" placeholder="What Are You Searching For?" id="search-term">
                        <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>

                    </div>
                </div>
                <div class="container">
                    <div id="search-overlay__results">

                    </div>
                </div>
            </div>
        `);
    }
}

export default Search;