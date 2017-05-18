


jQuery(function() {


  // window scroll event
  jQuery(window).scroll(function() {

    if (jQuery('nav#top-nav').position().top < jQuery(window).scrollTop()) {

      //if (StickyMenuControl.lastStatus != StickyMenuControl.currentStatus) {
        StickyMenuControl.makeItStick();
     // }

      StickyMenuControl.lastStatus = StickyMenuControl.currentStatus;
      StickyMenuControl.currentStatus = 'on';
    }


    else {
     // if (StickyMenuControl.lastStatus != StickyMenuControl.currentStatus) {
        StickyMenuControl.pryItDown();
      //}
      StickyMenuControl.lastStatus = StickyMenuControl.currentStatus;
      StickyMenuControl.currentStatus = 'off';
    }
  });
})



var StickyMenuControl = {

  // Status variable
  currentStatus: '',

  lastStatus: '',

  // makeItStick is a function that will transform the nav#top-nav to become
  // sticky. It also make an adjustment if the WP admin bar is present.
  makeItStick: function() {
    console.log(jQuery('#wpadminbar').length);
    if (jQuery('#wpadminbar').length > 0) {
      jQuery('nav#top-nav').addClass('fixed_to_top_admin');
    } else {
      jQuery('nav#top-nav').addClass('fixed_to_top');
    }

  },
  // pryItDown is a function that will attempt to restore things to normal.
  pryItDown: function() {
    jQuery('nav#top-nav').removeClass('fixed_to_top_admin');
    jQuery('nav#top-nav').removeClass('fixed_to_top');
  }
}
