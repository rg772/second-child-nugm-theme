/**
 * Created by carbon on 8/30/16.
 */
var html;
jQuery(function() {
    jQuery('form#searchform').attr('action', 'http://googlesearch.northwestern.edu/search')
    jQuery('#mobile-search form').attr('action', 'http://googlesearch.northwestern.edu/search');



    html = jQuery('form#searchform > div').html();
    html += '<input type="hidden" name="sitesearch" value="www.communication.northwestern.edu">' +
        '<input type="hidden" name="client" value="default_frontend">' +
        '<input type="hidden" name="output" value="xml_no_dtd">' +
        '<input type="hidden" name="oe" value="UTF-8">' +
        '<input type="hidden" name="ie" value="UTF-8">' +
        '<input type="hidden" name="proxystylesheet" value="default_frontend">';
    html = jQuery('form#searchform > div').html(html);
});