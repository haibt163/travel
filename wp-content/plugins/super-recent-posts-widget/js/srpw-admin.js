/*global srpwAjax,alert,console,jQuery,ajaxurl */
var srpwForms, srpwSetupForms;
jQuery(document).ready(function($){
    srpwForms = function(){
        $("body").on("change", ".srpw-post-types", function(){
            var $parent = $(this).closest('.srpw-form'),
                $postTypesWrap = $parent.find('.post-types-wrap'),
                $taxonomiesWrap = $parent.find('.taxonomies-wrap'),
                $termsWrap = $parent.find('.terms-wrap'),
                $loading = $postTypesWrap.find('.loading'),
                postType = $(this).val(),
                data = {
                    action: "srpw_post_type_selected",
                    postType: postType,
                    srpwNonce: srpwAjax.srpwNonce
                };
            if (postType) {

                $loading.css('display', 'block');
                $.post(ajaxurl, data, function(response) {
                    $taxonomiesWrap.find(".srpw-taxonomies").empty().html(response);
                    $taxonomiesWrap.show();
                    $termsWrap.hide();
                    $loading.css('display', 'none');
                });        
            } else {
                $taxonomiesWrap.hide();
                $termsWrap.hide();
            }
        });
        $("body").on("change", ".srpw-taxonomies", function(){
            var $parent = $(this).closest('.srpw-form'),
                $termsWrap = $parent.find('.terms-wrap'),
                $taxonomiesWrap = $parent.find('.taxonomies-wrap'),
                taxonomy = $(this).val(),
                $loading = $taxonomiesWrap.find('.loading'),
                data = {
                    action: "srpw_taxonomy_selected",
                    taxonomy: taxonomy,
                    srpwNonce: srpwAjax.srpwNonce
                };
            if (taxonomy) {
                $loading.css('display', 'block');
                console.log($loading.html());
                $termsWrap.hide();
                $.post(ajaxurl, data, function(response) {
                    $parent.find(".terms").empty().html(response);
                    $termsWrap.show();
                    $loading.css('display', 'none');
                    $termsWrap.show();
                });   
            } else {
                $termsWrap.hide();
            }

        });
    };
    srpwSetupForms = function(){
        $(".srpw-form").each(function(){
            var $postTypesWrap = $(this).find('.post-types-wrap'),
                $taxonomiesWrap = $(this).find('.taxonomies-wrap'),
                $termsWrap = $(this).find('.terms-wrap'),
                $postTypes = $postTypesWrap.find('.srpw-post-types'),
                $taxonomies = $taxonomiesWrap.find('.srpw-taxonomies'),
                $terms = $termsWrap.find('.terms');
            if ($postTypes.val()){
                $taxonomiesWrap.show();
            } else {
                $taxonomiesWrap.hide();
            }
            if ($taxonomies.val()){
                $termsWrap.show();
            } else {
                $termsWrap.hide();
            }            
        });
    };
    srpwForms();
    srpwSetupForms();
});