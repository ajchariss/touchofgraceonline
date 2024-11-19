class Project_Rate_Calculator_Categories{
    selector_id_rate_calculator_category_form = "rate_calculator_category_form";
    /* generate formdata in json format [fieldname => value] */
    generateFormJsonData(formArray){
        let jsonArray = {};
        formArray.forEach(
            function(value, key){
                jsonArray[value.name] = value.value;
            }
        );
        return jsonArray;
    }

    validateFormFields( obj, jsonArray, ignoreFields = []){
        let state = null;
        Object.entries(jsonArray).forEach(([key, value]) => {
            if( !ignoreFields.includes(key) ){
                if( value == '' || value == null ){
                    jQuery( "[name=" + key + "]", obj).addClass("invalid");
                    state = false;
                } else {
                    jQuery( "[name=" + key + "]", obj).removeClass("invalid");
                    if( state == null){
                        state = true;
                    } else if( state == false ) {
                        state = false;
                    }
                }
            }
        });
        return state;
    }

    /* spinner visiblity */
    spinnerActive(obj ,state = false){
        if (state == true){
            jQuery(".spinner", obj).css("visibility","visible");
        } else {
            jQuery(".spinner", obj).css("visibility","hidden");
        }
    }

    /* insert category item in list */
    addCategoryInList( htmlItem ){
        jQuery("#the-list").prepend(htmlItem);
    }
}
/* ========================================================================================= */
var proRateCalCat = new Project_Rate_Calculator_Categories();
var selector_id_rate_calculator_category_form = "#rate_calculator_category_form";
jQuery( document ).ready( function(){
    setTimeout(function(){ 
        jQuery("#pro_rate_category_message").html('');
    }, 5000);
    /* submit category */
    jQuery( selector_id_rate_calculator_category_form ).on("submit",function(e){
        proRateCalCat.spinnerActive(this,true);
        e.preventDefault()
        let formArray = jQuery(this).serializeArray();
        let jsonArray = proRateCalCat.generateFormJsonData(formArray);
        if( proRateCalCat.validateFormFields( this, jsonArray, ["category-slug", "description"] ) ){
            jQuery.ajax({
                url: proRateCalCategoriesObj.ajaxurl,
                type: 'POST',
                data: {
                    'action':'submit_pro_rate_cal_field_cat',
                    'formData' : jsonArray
                },
                success: function( response ) {
                    if( response.state == "insert" ){
                        if( response.htmlItem ){
                            jQuery("#rate_calculator_category_form").trigger('reset');
                            setTimeout(function(){ location.reload(); }, 1000);
                            proRateCalMessage(response.message);
                        }
                    } else if( response.state == "update" ){
                        if( response.htmlItem && response.id ){
                         
                            jQuery("tr#tag-"+response.id).replaceWith( response.htmlItem );
                            proRateCalMessage( response.message );
                            setTimeout(function(){ location.reload(); }, 1000);
                        }
                    }else{
                        proRateCalMessage( response.error);
                    }

                   
                },
            });
        }
        proRateCalCat.spinnerActive(this,false);
    });

    jQuery("#pro_rate_category_page").DataTable(
        {
            "paging":   true,
            "bInfo" : false,
            "ordering": false,
            "autoWidth": false,
            "oLanguage": {
                sSearch: '<span class="dashicons dashicons-search"></span>',
                sLengthMenu: '_MENU_',
                sInfoEmpty: "Showing 0 to 0 of 0 entries",
            },
            responsive: true,
            "search" : {
                return: true,
            }
            
        }
    );  
    jQuery("#pro_rate_category_page").find('.dataTables_empty').html('No categories available.');
    jQuery('table').DataTable();
} )

function proRateCalMessage( $message ){
    jQuery("#pro_rate_category_message").html('<div class="notice notice-info"><p>'+ $message +'</p></div>');
    setTimeout(function(){ 
        jQuery("#pro_rate_category_message").html('');
     }, 5000);
}