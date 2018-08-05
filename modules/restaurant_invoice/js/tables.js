/**
 * @file
 * Global utilities.
 *
 */
(function($, Drupal) {

    'use strict';

    Drupal.behaviors.restaurant_invoice = {
        attach: function(context, settings) {
            $(".table-unit").click(function() {
                window.location = $(this).find("a").attr("href");
                return false;
            });
        }
    };

})(jQuery, Drupal);