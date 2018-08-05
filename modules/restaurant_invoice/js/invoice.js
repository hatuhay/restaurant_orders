/**
 * @file
 * Global utilities.
 *
 */
(function($, Drupal) {

    'use strict';

    Drupal.behaviors.restaurant_invoice = {
        attach: function(context, settings) {
            $('#edit-name-0-value').attr('readonly', 'readonly');
            $('#edit-tax-amount-0-value').attr('readonly', 'readonly');
            $('#edit-amount-0-value').attr('readonly', 'readonly');
            var product = $("#edit-line-item-wrapper .field--name-product input");
            var quantity = $("#edit-line-item-wrapper .field--name-quantity input");
            $(product).blur(function() {
                var pdt = $("#edit-line-item-wrapper .field--name-product input");
                var qty = $("#edit-line-item-wrapper .field--name-quantity input");
                $('#edit-line-item-wrapper .field--name-name input').val($(pdt).val() + ' Cantidad: ' + $(qty).val());
            });
            $(quantity).on("input", function() {
                var pdt = $("#edit-line-item-wrapper .field--name-product input");
                var qty = $("#edit-line-item-wrapper .field--name-quantity input");
                $('#edit-line-item-wrapper .field--name-name input').val($(pdt).val() + ' Cantidad: ' + $(qty).val());
            });
        }
    };

})(jQuery, Drupal);