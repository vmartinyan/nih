/* Credit for tab styles - http://tympanus.net/codrops/2014/09/02/tab-styles-inspiration/ */

jQuery(function ($) {

    $('.lvca-tabs').each(function () {

        var tabs = $(this);
        new LVCA_Tabs(tabs);

    });

});

var LVCA_Tabs = function (tabs) {

    this.tabs = tabs;

    // tabs elems
    this.tabNavs = tabs.find('.lvca-tab');

    // content items
    this.items = tabs.find('.lvca-tab-pane');

    // current index
    this.current = 0;

    // show current content item
    this.show();

    // init events
    this.initEvents();

    // make the tab responsive
    this.makeResponsive();
};

LVCA_Tabs.prototype.show = function (index) {
    // Clear out existing tab
    this.tabNavs.eq(this.current).removeClass('lvca-active');
    this.items.eq(this.current).removeClass('lvca-active');

    // change current
    if (index != undefined)
        this.current = index;
    this.tabNavs.eq(this.current).addClass('lvca-active');
    this.items.eq(this.current).addClass('lvca-active');
};

LVCA_Tabs.prototype.initEvents = function () {
    var self = this;

    this.tabNavs.click(function (event) {
        event.preventDefault();
        self.show(self.tabNavs.index(jQuery(this)));
    });

};

LVCA_Tabs.prototype.makeResponsive = function () {

    var self = this;

    /* Trigger mobile layout based on an user chosen browser window resolution */
    var mediaQuery = window.matchMedia('(max-width: ' + self.tabs.data('mobile-width') + 'px)');
    if (mediaQuery.matches) {
        self.tabs.addClass('lvca-mobile-layout');
    }
    mediaQuery.addListener(function (mediaQuery) {
        if (mediaQuery.matches)
            self.tabs.addClass('lvca-mobile-layout');
        else
            self.tabs.removeClass('lvca-mobile-layout');
    });

    /* Close/open the mobile menu when a tab is clicked and when menu button is clicked */
    this.tabNavs.click(function (event) {
        event.preventDefault();
        self.tabs.toggleClass('lvca-mobile-open');
    });

    this.tabs.find('.lvca-tab-mobile-menu').click(function (event) {
        event.preventDefault();
        self.tabs.toggleClass('lvca-mobile-open');
    });
};
