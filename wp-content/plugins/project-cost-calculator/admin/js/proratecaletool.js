var proRateCalFormListTable;
var proRateCalLoader;
var saveState = true;
var proRateCalFormNameSaveState = null;
jQuery(document).ready(function(){
    if(jQuery('.form-setting-notification').length){
        setTimeout(function(){
        jQuery('.form-setting-notification').remove();
        }, 3000);
    }
    jQuery(" input, textarea, select, radio, .wp-editor-wrap ").on("keyup input", function(){
        saveState = false;  
    })
    jQuery(" input[type=submit] ").on("click", function(){
        saveState = true;  
    })
    jQuery("form").on("change",function(){
        saveState = false;
    })
    //saveState
    window.onbeforeunload = function (e) {
        e = e || window.event;
        if( typeof saveState == "boolean" && saveState == false ){
            if (e) {
                e.returnValue = 'Changes you made may not be saved.';
            }
        
            // For Safari
            return 'Changes you made may not be saved.';
        }
    }

    proRateCalLoader = new ProRateCalLoader();
    RestoreEvents();
    initEditForm();
    loadCalFormModule();
    proRateCalFormListTable = jQuery("#pro_rate_cal_list_table").DataTable(
        {
            "paging":   true,
            "bInfo" : false,
            "ordering": true,
            "autoWidth": false,
            "oLanguage": {
				
                sSearch: '<span class="dashicons dashicons-search"></span>',
                sLengthMenu: '_MENU_',
                sInfoEmpty: "Showing 0 to 0 of 0 entries",
				
            },
			 "language": {
      
        searchPlaceholder: "Search...",
    },
            responsive: true,
            "search" : {
                return: true,
				
            }
        }
    );

    jQuery(".pro_rate_cal_field_radio_item  input[name=form_state]").on("change",function(){
        let value = jQuery(this).val();
        let formId = jQuery("#pro_rate_cal_custom_fields_form input[name=form_id]").val();
        if( (value == "active" ||  value == "deactive") && formId ){
            jQuery.ajax({
                url: project_rate_calculator.ajaxurl,
                type: 'POST',
                data: {
                    'action': "submit_form_state",
                    'form_id': formId,
                    "formState" : value,
                },
                success: function( response ) {
                    jQuery(".pro_rate_cal_custom_form_message").html('<div class="notice notice-success form-setting-notification"><p>'+ response.message +'</p>');
                    setTimeout(function(){ 
                        jQuery(".pro_rate_cal_custom_form_message").html("");
                    }, 6000);
                },
            });
        }
    })

    jQuery('iframe').contents().find('body').css({'background-color' : 'inherit'});
    
    jQuery("#pro_rate_cal_new_form input[name=form_name]").each(function(){
        jQuery(this).on("keyup",function(){
            let value = jQuery(this).val().trim();
            if( value.length < 1 || typeof value === null || typeof value === undefined ){
                if(jQuery(this).next("p.pro_rate_cal_valdation").length == 0){
                    jQuery(this).addClass("pro_rate_cal_field_error");
                    jQuery(this).after("<p class='pro_rate_cal_valdation'>"+project_rate_calculator.message.form_name+"</p>");
                }
            }else{
                jQuery(this).removeClass("pro_rate_cal_field_error");
                jQuery(this).next(".pro_rate_cal_valdation").remove();
            }
        })
    })
    // mobile responsive js 
    //Sidebar nav toggle  ---------//
    jQuery(".rate_cal_add_element, .pro_rate_cal_module_elements_close, .pro_rate_cal_module").on("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        jQuery(".pro_rate_cal_right_list_bar").toggleClass("show");
        jQuery("body").toggleClass("offcanvas-active");
        jQuery(".pro_rate-cal_screen_overlay").toggleClass("show");
    });
    // Close menu when pressing ESC
    jQuery(document).on("keydown", function (event) {
        if (event.keyCode === 27) {
        jQuery(".pro_rate_cal_right_list_bar").removeClass("show");
        jQuery("body").removeClass("offcanvas-active");
        }
    });
    jQuery(".pro_rate-cal_screen_overlay").click(function (e) {
        jQuery(".pro_rate-cal_screen_overlay").removeClass("show");
        jQuery(".pro_rate_cal_right_list_bar").removeClass("show");
        jQuery("body").removeClass("offcanvas-active");
    });
    jQuery(window).resize(function () {
        var viewportWidth = jQuery(window).width();
        if (viewportWidth > 1199) {
        jQuery("body").removeClass("offcanvas-active");
        jQuery(".pro_rate-cal_screen_overlay").removeClass("show");
        jQuery(".pro_rate_cal_right_list_bar").removeClass("show");
        }
    });
    //Sidebar nav End  ---------//

    //Sidebar nav toggle  22 ---------//
    jQuery(".pro_rate-cal_mobile_menu_toggle, .pro_rate_cal_menu_sidebar_close").on("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        jQuery(".pro_rate_cal-sidebar-div").toggleClass("show");
        jQuery("body").toggleClass("offcanvas-active");
        jQuery(".pro_rate-cal_screen_overlay").toggleClass("show");
    });
    // Close menu when pressing ESC
    jQuery(document).on("keydown", function (event) {
        if (event.keyCode === 27) {
        jQuery(".pro_rate_cal-sidebar-div").removeClass("show");
        jQuery("body").removeClass("offcanvas-active");
        }
    });
    jQuery(".pro_rate-cal_screen_overlay").click(function (e) {
        jQuery(".pro_rate-cal_screen_overlay").removeClass("show");
        jQuery(".pro_rate_cal-sidebar-div").removeClass("show");
        jQuery("body").removeClass("offcanvas-active");
    });
    jQuery(window).resize(function () {
        var viewportWidth = jQuery(window).width();
        if (viewportWidth > 1199) {
        jQuery("body").removeClass("offcanvas-active");
        jQuery(".pro_rate-cal_screen_overlay").removeClass("show");
        jQuery(".pro_rate_cal-sidebar-div").removeClass("show");
        }
    });
    // mobile responsive js End

    //  clone data in element
    jQuery(document).on('click','.pro_rate_clone_btn',function(){
        var clone = jQuery(this).closest('li').clone();
        clone.find('.elements_value_setting_field').val('');
        jQuery(this).closest('li').after(clone);
        jQuery(this).html("<span class='dashicons dashicons-no-alt'></span>");
        jQuery(this).addClass('pro_rate_close_btn');
        jQuery(this).removeClass('pro_rate_clone_btn');
        
    });
    jQuery(document).on('click','.pro_rate_close_btn',function(){
        jQuery(this).closest('li').remove();
    });
    jQuery(document).on('change','.simple_Logic_setting_field',function(){
        if(jQuery(this).prop('checked') == true){
            jQuery(this).closest('form').find('.pro_rate-hide_field').addClass('pro_rate-show_field');
            jQuery(this).closest('form').find('.pro_rate-hide_field').removeClass('pro_rate-hide_field');
            jQuery(this).val('yes');
        }else{
            jQuery(this).closest('form').find('.pro_rate-show_field').addClass('pro_rate-hide_field');
            jQuery(this).closest('form').find('.pro_rate-show_field').removeClass('pro_rate-show_field');
            jQuery(this).val('no');
        }    
    });
    //  clone data in element End

    //Form Entries Table
    jQuery(document).ready(function(){
        jQuery("#pro_rate_cal_form_entries").DataTable(
            {
                "paging":   true,
                "bInfo" : false,
                "ordering": true,
                "autoWidth": false,
                "oLanguage": {
                    sSearch: '<span class="dashicons dashicons-search"></span>',
                    sLengthMenu: '_MENU_',
                    sInfoEmpty: "Showing 0 to 0 of 0 entries",
					searchPlaceholder: 'search',
					
                },
                responsive: true,
                "search" : {
                    return: true,
                }
            }
        );  
    })

})

function RestoreEvents(){
    jQuery("#pro_rate_cal_admin a").unbind("click");
}

function clearPopup(){
    jQuery("#pro_rate_cal_admin .popup").remove();
}

function deleteProCalForm(id){
    new ProRateCalModel( id );
}

function initEditForm(){
    jQuery("form.pro_rate_cal_new_form").submit(function(e){
        e.preventDefault();
        let form_name = jQuery("input[name=form_name]",this).val();
        form_name = form_name.trim();
        if( form_name.length > 0 && typeof form_name !== null && typeof form_name !== undefined ){
            jQuery("input[name=form_name]",this).removeClass("pro_rate_cal_field_error");
            jQuery("input[name=form_name]",this).next(".pro_rate_cal_valdation").remove();
            proRateCalLoader.start();
            form_id = jQuery("input[name=form_id]",this).val();
            json_values = jQuery("input[name=json_values]",this).val();
            wpnonce = jQuery("input[name=_wpnonce]",this).val();
            action = jQuery(this).attr("action");
            var xhr = jQuery.ajax({
                url: project_rate_calculator.ajaxurl,
                type: 'POST',
                data: {
                    'action': action,
                    'form_name' : form_name,
                    'form_id' : form_id,
                    '_wpnonce' : wpnonce,
                    //'json_values' : proRatCalBuilder.getJsonValues(),
                    'json_values' : project_rate_calculator_edit,
                },
                success: function( response ) {
                    if(response.shortcode){
                        jQuery("#pro_rate_cal_shortcode_generate > p").text(response.shortcode);
                    }
                    if( response.form_id ){
                        jQuery("input[name=form_id]","form.pro_rate_cal_new_form").val(response.form_id);
                        setUrlFormID( response.form_id );
                        proRateCalCategoryUpdate( response.form_id );
                        // Show field when form name submitted
                        jQuery(".pro_rate_cal_footer_form_actions_container").removeClass("pro_rate_cal_disabled-section");
                        jQuery(".pro_rate_cal_right_list_bar").removeClass("pro_rate_cal_disabled-section");
                        jQuery(".pro_rate_cal_builder").removeClass("pro_rate_cal_disabled-section");
                        jQuery(".pro_rate_cal_new_form_field").removeClass("pro_rate_cal_disabled-section");
                        /**
                         * Appear tips to display build form
                         */
                        if ( typeof proRateCalFormNameSaveState == "boolean" && !proRateCalFormNameSaveState ){
                            let tips = document.createElement("p");
                            if(  typeof project_rate_calculator.tool_tip_for_field == "string" ){
                                tips.innerHTML = project_rate_calculator.tool_tip_for_field;
                            }else{
                                tips.innerHTML = "Select the element from the right-hand side column to start the building of the calculator.";
                            }
                            jQuery(".pro_rate_cal_form_name-save_shortcode").after(tips);
                            setTimeout(
                                function(){
                                    tips.remove();
                                },
                                5000,
                            );
                        }

                    }
                    saveState = true;
                },
                complete: function(data){
                    console.log(data.responseText);
                    new ProRateCalNotification("#pro_rate_cal_message" , JSON.parse(data.responseText).message, "info");
                    proRateCalLoader.stop();
                }
            });
        }else{
            jQuery("input[name=form_name]",this).addClass("pro_rate_cal_field_error");
            new ProRateCalNotification("#pro_rate_cal_message" , project_rate_calculator.message.form_name_empty, "error");
            if(jQuery("input[name=form_name]",this).next("p.pro_rate_cal_valdation").length == 0){ 
                jQuery("input[name=form_name]",this).after("<p class='pro_rate_cal_valdation'> "+project_rate_calculator.message.form_name_empty+"</p>");
            }
        }
    })
}

function setUrlFormID(id){
    if( id ){
        const url = new URL(window.location);
        url.searchParams.set('id', id);
        window.history.pushState({}, '', url);
        jQuery(".pro_rat_cal_submenus a").each(function(el, i){
            const urlObj = new URL(jQuery(this).attr("href"));
            urlObj.searchParams.set('id', id);
            jQuery(this).attr("href", urlObj.href );
            jQuery(this).parents("li.pro_rat_cal_submenus").removeClass("pro_rate_cal_disabled");
        })
    }else{
        console.error(project_rate_calculator.message.form_id_specified);
    }
}

function deleteCalculatorForm(id){
    proRateCalLoader.start();
    jQuery.ajax({
        url: project_rate_calculator.ajaxurl,
        type: 'POST',
        data: {
            'action': "delete_rate_calculator_form",
            'id' : id
        },
        success: function( response ) {
            if( response.status == "true" ){
                if(response.ID){
                    proRateCalFormListTable
                        .row("tr.calculator_item[data-id="+response.ID+"]")
                        .remove()
                        .draw();

                    new ProRateCalNotification("#pro_rate_cal_message" , project_rate_calculator.message.form_deleted , "info");
                }
            }
        },
        complete: function(data){
            proRateCalLoader.stop();
        }
    });
}

function copyShortcode(shortcode,obj){
    if(typeof shortcode == "string"){
        if( typeof navigator.clipboard != "undefined" ){
            navigator.clipboard.writeText(shortcode);
            console.log(shortcode);
            jQuery(".rate_cal_tooltiptext",obj).text("Shortcode copied");
            setTimeout(function(){
                jQuery(".rate_cal_tooltiptext",obj).text("Copy shortcode");
            }, 1000);
        }else{
            var $temp = jQuery("<input>");
            jQuery("body").append($temp);
            $temp.val(shortcode).select();
            document.execCommand("copy");
            $temp.remove();

            jQuery(".rate_cal_tooltiptext",obj).text("Shortcode copied");
            setTimeout(function(){
                jQuery(".rate_cal_tooltiptext",obj).text("Copy shortcode");
            }, 1000);
        }
    }
}

/* Cal Form Bulder functions */
function loadCalFormModule(){
    jQuery("span.pro_rate_cal_keyword_generate").each(function(){
        jQuery(this).click(function(){
            let value = jQuery("p", this).text();
            let text = jQuery(".rate_cal_tooltiptext", this).text();
            jQuery(".rate_cal_tooltiptext", this).text("Keyword Copied");
            if( typeof navigator.clipboard != "undefined" ){
                navigator.clipboard.writeText(value);
                jQuery(".rate_cal_tooltiptext",this).text("Keyword Copied");
                setTimeout(function(){
                    jQuery(".rate_cal_tooltiptext",this).text("Copy keyword");
                }, 1000);
            }else{
                var $temp = jQuery("<input>");
                jQuery("body").append(value);
                $temp.val(value).select();
                document.execCommand("copy");
                $temp.remove();
    
                jQuery(".rate_cal_tooltiptext",this).text("Keyword Copied");
                setTimeout(function(){
                    jQuery(".rate_cal_tooltiptext",this).text("Copy keyword");
                }, 1000);
            }
            let obj = this;
            setTimeout(function(){
                jQuery(".rate_cal_tooltiptext",obj).text(text);
            }, 1000);
        })
    })
    jQuery("#pro_rate_cal_shortcode_generate > p").click(function(){
        copyShortcode(jQuery(this).text());
    })
    jQuery(".pro_rate_cal_module").click(function(){
        if( jQuery(this).data("module") ){
            loadModuleSettingsWindow( jQuery(this).data("module") );
        }
    })

    proRateCalFormSortable = jQuery( "#pro_rate_cal_builder_fields" ).sortable( {
        placeholder: "highlight",
        start: function (event, ui) {
                ui.item.toggleClass("highlight");
        },
        stop: function (event, ui) {
                ui.item.toggleClass("highlight");
        }
     } );

    proRateCalFormSortable.on( "sortupdate", function( event, ui ) {
        let fieldsOrder = {};
        jQuery("tr",this).each(function(index, element){
            element.setAttribute("data-order",index);
            fieldsOrder[jQuery(element).attr("id")] = index;
        });
        proRatCalBuilder.updateFieldsOrder(fieldsOrder);
    } );

    let proRateCalTbodySortable = jQuery( ".pro_rate_cal_sortable" ).sortable( {
        placeholder: "highlight",
        start: function (event, ui) {
                ui.item.toggleClass("highlight");
        },
        stop: function (event, ui) {
                ui.item.toggleClass("highlight");
        }
     } );

     proRateCalTbodySortable.on( "sortupdate", function( event, ui ) {
        jQuery("tr",this).each(function(index, element){
            jQuery("input.pro_rate_cal_field_order_input",element).attr("value",index);
        });
    } );

    jQuery(".pro_rate_cal_field_radio_item  input[type=radio]").on('click', function () {
        var form_value =  jQuery(this).attr('value');
        if(form_value == 'active'){
            jQuery('.pro_rate-cal_panel_tab').show();
        }else{
            jQuery('.pro_rate-cal_panel_tab').hide();
        }
    });

}

/* generate setting window for modules */
function loadModuleSettingsWindow(module, moduleData = null){
    let formId = jQuery("input[name=form_id]","form#pro_rate_cal_new_form").val();
    jQuery.ajax({
        url: project_rate_calculator.ajaxurl,
        type: 'POST',
        data: {
            'action': "get_pro_rate_cal_form_module_settings",
            "module" : module,
            "id" : formId,
        },
        success: function( response ) {
            proRateCalModuleSettings( response );
        },
    });
}

/* custom validation functions */
/* RANGE FIELD */
function checkRangeValue(obj, form, state){
    field_value = jQuery(obj,form).val();
    min_value = jQuery("input[name=min_range]", form).val();
    max_value = jQuery("input[name=max_range]", form).val();
    if( typeof field_value === "string"){
        if( (parseFloat(min_value) <= parseFloat(field_value) ) && 
            (parseFloat(max_value) >= parseFloat(field_value) )  ){
                jQuery(obj,form).next("p.error_range_default_field",form).remove();
                if( field_value != ''){
                    jQuery(obj,form).removeClass("pro_rate_cal_field_error");
                }
            if( state == true || state == null ){
                state = true;
            }
        }else{
            state = false;
            jQuery(obj,form).val(min_value);
            jQuery(obj,form).addClass("pro_rate_cal_field_error");
            
            if( jQuery(obj,form).next("p.error_range_default_field").length == 0 ){
                jQuery(obj,form).after(function(){
                    return "<p class='error_range_default_field error_field'>"+project_rate_calculator.message.module_default_quantity+"</p>";
                });
            }
        }
    }
    return state;
}
function prevantMinusValue(obj, form, state){
    field_value = jQuery(obj,form).val();
    if( parseInt(field_value) < 0 ){
        jQuery(obj,form).addClass("pro_rate_cal_field_error");
        jQuery(obj,form).val(0);
        state = false;
    }else{
        if( field_value != ''){
            jQuery(obj,form).removeClass("pro_rate_cal_field_error");
        }
    }
    return state;
}

function prevantMinusValueForChoice(obj, form, state){
    console.log(state);
    jQuery("input[type=number]",obj).each(function(){
        let value = jQuery(this).val();
        if( parseInt(value) < 0 ){
            jQuery(this,obj).addClass("pro_rate_cal_field_error");
            jQuery(this).val(0)
            state = false;
        }else{
            jQuery(this,obj).removeClass("pro_rate_cal_field_error");
        }
    })
    return state;
}

/* Update Categories */
function proRateCalCategoryUpdate( $form_id ){
    jQuery.ajax({
        url: project_rate_calculator.ajaxurl,
        type: 'POST',
        data: {
            'action': "pro_rate_cal_get_form_categories",
            "id" : $form_id,
        },
        success: function( response ) {
            if( response ){
                Object.entries(project_rate_calculator.calFormData.modules).forEach(([key, value]) => {
                    project_rate_calculator.calFormData.modules[key].category_field.attributes.list = response;
                });
                project_rate_calculator.calFormData.category = response;
            }
        },
    });
}

function pro_rate_cal_tab_notification(evt, pro_rate_cal_tab_name) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("pro_rate-cal_tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("pro_rate-cal_tab_nav_tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(pro_rate_cal_tab_name).style.display = "block";
    evt.currentTarget.className += " active";
}

setTimeout(function() {
    jQuery('#notifi_email_template_ifr').css('height','300px');
}, 2500);

