var pro_rate_cal_auto_update = true;
class ProRateCalFormFront{
    formId;
    form;
    fieldSettings;
    resultSectionClass = "pro_rate_cal_pricing";
    table_class = ".pricing_table";
    fieldRate;
    properties;
    quoteSend = false;
    quoteSendToUser = false;
    stateAutoUpdateResult = true;

    constructor( formId, fields, rate, properties ){
        
        this.setFormID( formId );
        this.setFormElement();
        this.setProperties(properties);
        this.setFieldSettings( fields );
        this.setfieldRate( rate )
        this.load();
        
    }

    autoUpdateResult( state = null ){
        if( state == true ){
            this.stateAutoUpdateResult = true;
        }else if( state == false ){
            this.stateAutoUpdateResult = false;
        }
        pro_rate_cal_auto_update = this.stateAutoUpdateResult;
        return this.stateAutoUpdateResult;
    }

    isSendQuote( $state ){
        if($state == true){
            this.quoteSend = true;
        }
    }

    isSendQuoteToUser( $state ){
        if($state == true){
            this.quoteSendToUser = true;
        }
    }

    setProperties( prop ){
        this.properties = prop;
    }

    setFormID( formId ){
        if( formId ){
            this.formId = formId;
        } else {
            console.error("Form Id is invalid or not specified, Error: f001");
        }
    }

    setfieldRate( rate ){
        this.fieldRate = rate;
    }

    setFieldSettings( settings ){
        this.fieldSettings = settings;
        if( this.fieldSettings == null ){
            console.error("Form settings not defined: "+ this.formId +", Error: f003");
        }
        if ( typeof this.fieldSettings != "object" ){
            console.error("Form settings type is invalid or it shoud be type of object: "+ this.formId +", Error: f0031");
        }
    }

    setFormElement(){
        this.form = document.getElementById(this.formId);
        if( this.form == null ){
            console.error("Form not found with assigned form id: "+ this.formId +", Error: f002");
        }
    }

    loadConditionalOperations(){
        jQuery(this.form).trigger("change");
        Object.entries( this.properties ).forEach(([key, value]) => {
            if( typeof value.settings.logic == "string" && value.settings.logic == "yes"){
                let initState = "show";
                 if( typeof value.settings.elements_state == "string" && value.settings.elements_state == "show" ){
                     initState = "hide";
                }else if( typeof value.settings.elements_state == "string" && value.settings.elements_state == "hide" ){
                    initState = "show";
                }else if( typeof value.settings.elements_state == "string" && value.settings.elements_state == "unlock" ){
                    initState = "lock";
                }else if( typeof value.settings.elements_state == "string" && value.settings.elements_state == "lock" ){
                 initState = "unlock";
                }
                let fields = this.properties;
                let form = this.form;
                if( initState == "show" || initState == "hide" ){
                  jQuery( "tr#"+key, this.form)[initState]();
                }

                jQuery(form).on("keyup keypress change click",function(){
                    let andCondition = true;
                    let resultState = [];
                    if( typeof value.settings.elements_state_if == "string" && value.settings.elements_state_if != "all" ){
                        andCondition = false;
                    }
                    if ( typeof value.settings.elements_condition.elements_select == "object" ){
                        value.settings.elements_condition.elements_select.forEach( function( el, index ){
                            let total_values = 0;
                            if( typeof fields[el] == "object" ){

                                if( fields[el].module_id == "checkbox" ){
                                    jQuery("#"+el+" input[type=checkbox]:checked", form).each(function(){
                                        if( typeof jQuery(this).val() == "string"){
                                            total_values = total_values + parseFloat(jQuery(this).val());
                                        }
                                    })
                                }

                                if( fields[el].module_id == "number_input" ){
                                    jQuery("#"+el+" input[type=number]", form).each(function(){ 
                                        if( typeof jQuery(this).val() == "string"){
                                            total_values = total_values + parseFloat(jQuery(this).val());
                                        }
                                    })
                                }

                                if( fields[el].module_id == "radio" ){
                                    jQuery("#"+el+" input[type=radio]:checked", form).each(function(){
                                        if( typeof jQuery(this).val() == "string"){
                                            total_values = total_values + parseFloat(jQuery(this).val());
                                        }
                                    })
                                }

                                if( fields[el].module_id == "dropdown" ){
                                    jQuery("#"+el+" select", form).each(function(){ 
                                        if( typeof jQuery(this).val() == "string"){
                                            total_values = total_values + parseFloat(jQuery(this).val());
                                        }
                                    })
                                }

                                if( fields[el].module_id == "toggle" ){
                                    if ( jQuery("#"+el+" input[type=checkbox]", form).prop("checked") == true) {
                                        total_values = total_values + parseFloat(fields[el].settings.rate);
                                    }
                                }

                                if( fields[el].module_id == "range" ){
                                    jQuery("#"+el+" input[type=range]", form).each(function(){ 
                                        if( typeof jQuery(this).val() == "string"){
                                            total_values = total_values + parseFloat(jQuery(this).val());
                                        }
                                    })
                                }
                                
                                if( typeof value.settings.elements_condition.elements_select_value[index] == "string" ){
                                    resultState[index] = verifyConditions( value.settings.elements_condition.elements_select_value[index], value.settings.elements_condition.elements_select_condition[index], total_values );
                                }

                            }
                          
                        })
                    }

                    let finalState = null;
                    resultState.forEach(function(el){
                        if(finalState == null){
                            finalState = el;
                        }else{
                            if(andCondition == true){
                                finalState = (finalState && el);
                            }else{
                                finalState = (finalState || el);
                            }
                        }
                    })
                   
                   console.log(finalState);
                   console.log(value.settings.elements_state);
                   console.log(initState);
                   
                    if( initState == "show" || initState == "hide" ) {
                        let trShowState;
                        if( finalState == true ){
                            jQuery( "tr#"+key, form)[value.settings.elements_state]();
                            trShowState = value.settings.elements_state;
                        }else{
                            jQuery( "tr#"+key, form)[initState]();
                            trShowState = initState;
                        }
                        let rowCat = jQuery( "tr#"+key, form).data( "category" );
                        jQuery( "tr[data-category="+rowCat+"] .pro_rate_cal_rowspan" ).attr("rowspan", jQuery( "tr[data-category="+rowCat+"]:visible" ).length );
                    }else if( initState == "lock" || initState == "unlock" ){
                        if( finalState == true ){
                            if( value.settings.elements_state == "lock" ){
                                jQuery( "tr#"+key, form).addClass("pro_rate_cal_field_lock");    
                            }else{
                                jQuery( "tr#"+key, form).removeClass("pro_rate_cal_field_lock");
                            }
                        }else{
                            if( initState == "lock" ){
                                jQuery( "tr#"+key, form).addClass("pro_rate_cal_field_lock");
                            }else{
                                jQuery( "tr#"+key, form).removeClass("pro_rate_cal_field_lock");
                            }
                        }
                    }
                })
            }
        })
    }

    load(){

        this.loadConditionalOperations();
        let currentObj = this;
        if( this.stateAutoUpdateResult ){
            console.log( this.stateAutoUpdateResult );
            jQuery( "select[name=pro_rate_cal_front_currency]" ).on( "change update" ,function(){
                if( pro_rate_cal_auto_update ){
                    jQuery(this).parents("form").trigger("submit");
                }
            });
        }

        /**Set Email address from cookie */
        let formId = jQuery(this.form).attr("form");
        let quoteEmail = proRateCalGetCookie( "pro_rate_cal_quote_email_" + formId );
        if( typeof quoteEmail == "string" ){
            jQuery(  "input[name=proratecal_user_mail]", this.form).val( quoteEmail );
        }

        jQuery(this.form).submit(function(e){
            let pricingSummery = [{ label:"Particular" , value:"Value" }];
            e.preventDefault();
            let formArrayData = jQuery(this).serializeArray();
            /* new functionalities data */
            let newTotal = 0;
            let form = jQuery(this);
            let tbody = currentObj.createElement("tbody");
            Object.entries( currentObj.properties ).forEach(([key, value]) => {
                if( jQuery("#"+value.element_id, form).css('display') == 'none' ){
                    return;
                }
                let tr = currentObj.createElement("tr");
                if( value.module_id == "checkbox" ){
                    let labelname = value.settings.label_name;
                    let Labeltd = currentObj.createElement("td");
                    if( value.settings.label_name ){
                        Labeltd.innerHTML = value.settings.label_name;
                    }
                    tr.append( Labeltd );
                    let tdValue = currentObj.createElement("td");
                    let comaState = false;
                    let tempValue = '';
                    let emptyFields = true;
                    jQuery("#"+value.element_id+" input[type=checkbox]", form).each(function(index, el){
                        if( jQuery(this).prop("checked") == true ){
                            emptyFields = false;
                            if( value.settings.option.labels[index] ){
                                let p = currentObj.createElement("span");
                                let coma = "";
                                if( comaState ){
                                    coma = ", ";
                                }
                                p.innerHTML = coma+value.settings.option.labels[index];
                                tempValue += coma+value.settings.option.labels[index];

                                tdValue.append(p);

                                newTotal = parseFloat(value.settings.option.values[index]) + parseFloat(newTotal);
                                comaState = true;
                            }
                        }
                    });
                    if( emptyFields ){
						tdValue.innerHTML = "-";
					}
                    tr.append(tdValue);
                    tempValue =  tempValue.trim().length == 0 ? "-" : tempValue;
                    pricingSummery.push( { label: value.settings.label_name, value: tempValue });
                }

                //dropdown
                if( value.module_id == "dropdown" ){
                    console.log( value.module_id );
                    let Labeltd = currentObj.createElement("td");
                    if( value.settings.label_name ){
                        Labeltd.innerHTML = value.settings.label_name;
                    }
                    tr.append( Labeltd );  
                    let tdValue = currentObj.createElement("td");
                    let inputValue = jQuery("#"+value.element_id+" select", form).val();
                    let inputtext = jQuery("#"+value.element_id+" select option:selected", form).text();
                    tdValue.innerHTML = inputtext;
                    let qtyTotal = parseFloat( inputValue );
                    newTotal = parseFloat(newTotal) + parseFloat(inputValue);  
                    let tempValue =  inputtext.trim().length == 0 ? "-" : inputtext;
                    pricingSummery.push( { label: value.settings.label_name, value: tempValue });
                    tr.append( tdValue );
                }
         
                if( value.module_id == "toggle" ){
                    let Labeltd = currentObj.createElement("td");
                    if( value.settings.label_name ){
                        Labeltd.innerHTML = value.settings.label_name;
                    }
                    tr.append( Labeltd );
                    let tdValue = currentObj.createElement("td");
                    let tempLabel = '';
                    jQuery("#"+value.element_id+" input[type=checkbox]", form).each(function(index, el){
                        if( jQuery(this).prop("checked") == true ){
                            if( value.settings.active_name ){
                                tdValue.innerHTML = value.settings.active_name;
                                tempLabel = value.settings.active_name;
                            }
                            if( value.settings.rate ){
                                newTotal = parseFloat(newTotal) + parseFloat(value.settings.rate);
                            }
                        }else{
                            tdValue.innerHTML = value.settings.deactive_name;
                            tempLabel = value.settings.deactive_name;
                        }
                    });
                    pricingSummery.push( { label: value.settings.label_name, value: value.settings.deactive_name });
                    tr.append( tdValue );
                }

                if(value.module_id  ==  "radio"){
                    let Labeltd = currentObj.createElement("td");
                    if( value.settings.label_name ){
                        Labeltd.innerHTML = value.settings.label_name;
                    }
                    tr.append( Labeltd );
                    let tdValue = currentObj.createElement("td");
                    let tempValues = '';
                    let emptyFields = true;
                    jQuery("#"+value.element_id+" input[type=radio]", form).each(function(index, el){
                        if( jQuery(this).prop("checked") == true ){
                            emptyFields = false;
                            let choiceValue = jQuery(this).val();
                            if( choiceValue ){
                                console.log(value.settings);
                                tdValue.innerHTML = jQuery(this).next("label").text();
                                tempValues = jQuery(this).next("label").text();
                                newTotal = parseFloat(newTotal) + parseFloat(choiceValue);    
                            }
                        }
                    });
                    if( emptyFields ){
						tdValue.innerHTML = "-";
					}
                    tr.append( tdValue );
                    tempValues =  tempValues.trim().length == 0 ? "-" : tempValues;
                    pricingSummery.push( { label: value.settings.label_name, value: tempValues });
                }

                if( value.module_id == "number_input" ){
                    let Labeltd = currentObj.createElement("td");
                    if( value.settings.label_name ){
                        Labeltd.innerHTML = value.settings.label_name;
                    }
                    tr.append( Labeltd );
                    let tdValue = currentObj.createElement("td");
                    let inputValue = jQuery("#"+value.element_id+" input[type=number]", form).val();
                    tdValue.innerHTML = inputValue;
                    let qtyTotal = parseFloat(value.settings.rate) * parseFloat( inputValue );
                    newTotal = parseFloat(newTotal) + parseFloat(qtyTotal);    
                    tr.append( tdValue );
                    pricingSummery.push( { label: value.settings.label_name, value: inputValue });
                }

                if( value.module_id == "range" ){
                    let Labeltd = currentObj.createElement("td");
                    if( value.settings.label_name ){
                        Labeltd.innerHTML = value.settings.label_name;
                    }
                    tr.append( Labeltd );
                    let tdValue = currentObj.createElement("td");
                    let inputValue = jQuery("#"+value.element_id+" input[type=range]", form).val();
                    tdValue.innerHTML = inputValue;
                    let qtyTotal = parseFloat(value.settings.rate) * parseFloat( inputValue );
                    newTotal = parseFloat(newTotal) + parseFloat(qtyTotal);    
                    tr.append( tdValue );
                    pricingSummery.push( { label: value.settings.label_name, value: inputValue });
                }
                tbody.append(tr);

            });

            let grandTotal = currentObj.createElement("tr");
            let grandTotalLabelTd = currentObj.createElement("td");
            grandTotalLabelTd.innerHTML = "<strong>Grand Total:</strong>";
            grandTotal.append(grandTotalLabelTd);
            let currentTotal = Number( newTotal * project_rate_calculator.pro_rate_cal_rate );
            let grandTotalValueTd = currentObj.createElement("td");
            let grandTotalText = project_rate_calculator.pro_rate_cal_current_country_currency.toUpperCase() + " " + currentTotal.toFixed(2);
            grandTotalValueTd.innerHTML = grandTotalText;
            grandTotal.append(grandTotalValueTd);
            tbody.append(grandTotal);
            currentObj.setPricing(tbody);
            pricingSummery.push( { isTotal : true, label: "Grand Total", value: grandTotalText } );
            jQuery(".pro_rate_cal_qoute_form" ,this ).show();

            if( typeof currentObj.quoteSendToUser == "boolean" && currentObj.quoteSendToUser ){
                currentObj.sendQuatationToUser( pricingSummery );
            }

        })
    }

    renderResult( result ){
        let tr = this.createElement("tr");
        let tdLabel = this.createElement("td",{ "colspan" : 1}, "<strong>Grand Total</strong>");
        tr.append(tdLabel);
        let tdResult = this.createElement("td",{  }, result );
        tr.append(tdResult);
        tr.setAttribute("data-result",result);
        return tr;
       
    }

    renderValueField( label, key, json, rate ){
        let tr = this.createElement("tr");
        let tdLabel = this.createElement("td",{}, label);
        tr.append(tdLabel);
        let tdRate = this.createElement("td",{}, json[key] );
        tr.append(tdRate);
        return tr;
    }

    setPricing(tbody){
        let tHead = this.createElement("thead");
        tHead.innerHTML = "<tr><th>Particular</th><th>Value</th></tr>";
        jQuery(this.table_class,this.form).html("");
        jQuery(this.table_class,this.form).append(tHead);
        jQuery(this.table_class,this.form).append(tbody);
    }


    createElement( element, attributes = {}, content = null){
        let field = document.createElement(element);
        Object.entries(attributes).forEach(([key, value]) => {
            field.setAttribute( key, value);
        });
        if ( content ){
            field.innerHTML = content;
        }
        return field;
    }


    sendQuatation( data ){
        
       if( this.quoteSend ){
            let json = JSON.stringify(data);
            let form_id = jQuery("#"+this.formId).attr("form");
            jQuery.ajax({
                url: project_rate_calculator.ajaxurl,
                type: 'POST',
                data: {
                    action: "pro_rate_cal_submit_quatation",
                    data :JSON.parse(json),
                    formid: form_id,
                },
                success: function( response ) {
                    
                },
            });
       }
    }

    
    sendQuatationToUser( data ){

        jQuery( "input.pro_rate_cal_send_qout_to_user", this.form ).unbind( "click" );
        jQuery( "input.show_quote_form", this.form ).unbind( "click" );
        let currentObj = this;
        jQuery( "input.show_quote_form", this.form ).on( "click", function(){
            jQuery( ".pro_rate_cal_user_quote_form", currentObj.form ).show();
        } );
        jQuery( "input.pro_rate_cal_send_qout_to_user", this.form ).on("click", function(){
            jQuery("pro_arte_cal_quot_message", currentObj.form).html("");
            if( typeof data == "object" && Object.keys(data).length != 0 ){
                let email = jQuery("input[name=proratecal_user_mail]", currentObj.form ).val();
                let EmailregExp = /^([\w\.\+]{1,})([^\W])(@)([\w]{1,})(\.[\w]{1,})+$/;
                if( typeof email == "string" && EmailregExp.test( email ) && email.length > 0 ){
                    jQuery("input[name=proratecal_user_mail]", currentObj.form ).removeClass("pro_rate_cal_error");
                    let json = JSON.stringify(data);
                    let form_id = jQuery("#"+currentObj.formId).attr("form");
                    jQuery.ajax({
                        url: project_rate_calculator.ajaxurl,
                        type: 'POST',
                        data: {
                            action: "pro_rate_cal_submit_quatation_to_user",
                            email: email,
                            data :JSON.parse(json),
                            formid: form_id,
                        },
                        success: function( response ) {
                            if(response.status){
                                jQuery(".pro_rate_cal_quot_message", currentObj.form).html("<p style='color: green;'>" + response.message + "</p>");
                            }else{
                                jQuery(".pro_rate_cal_quot_message", currentObj.form).html("<p>" + response.message + "</p>");
                            }
                            
                        },
                    });
                } else {
                    jQuery("input[name=proratecal_user_mail]", currentObj.form ).addClass("pro_rate_cal_error");
                    jQuery(".pro_rate_cal_quot_message", currentObj.form).html("<p>Invalid or empty email address.</p>");
                }
            }

        })
    }
}


class ProRateCalFormFrontTool{

    constructor(){
        this.initSimpleFieldFunction();
    }
    initSimpleFieldFunction(){
        jQuery("div.pro_rate_cal_qty-input").each(function(){
            let input = jQuery("input.pro_rate_cal_qty-txt",this);
            jQuery("input.pro_rate_cal_qty-minus",this).click(function(){
                let value = parseInt(jQuery(input).val());
                console.log( typeof value );
                
                if( isNaN( value ) ){
                    value = 0;
                }

                let minusValue = value - 1;
                if(jQuery(input).val().trim() == '' || jQuery(input).val().trim() < 0){
                    jQuery(input).val(0);
                }
                if( parseInt(jQuery(input).attr("min")) <= minusValue ){
                    jQuery(input).val( minusValue );
                }
                if( typeof jQuery(input).attr("min") === "undefined" ){
                    jQuery(input).val( plusValue );
                }
            })
            jQuery("input.pro_rate_cal_qty-plus",this).click(function(){
                let value = parseInt(jQuery(input).val());
                console.log( typeof value );

                if( isNaN( value ) ){
                    value = 0;
                }

                if(jQuery(input).val().trim() == ''){
                    jQuery(input).val(0);
                }

                let plusValue = value + 1;
                if( (parseInt(jQuery(input).attr("max")) >= plusValue) ){
                    jQuery(input).val( plusValue );
                }
                
                if( typeof jQuery(input).attr("max") === "undefined" ){
                    jQuery(input).val( plusValue );
                }
            })
        })
    }
}

var currentCorrencyRate = 1;
jQuery(document).ready(function(){
    var proRateCalFormFrontTool = new ProRateCalFormFrontTool();
    jQuery("form").trigger("change");
    jQuery(".pro_rate_cal_range_field").each(function(){
        jQuery(this).on("input",function(){
        let element = this;
            let value = jQuery("input",element).val();
            let min = jQuery("input",element).attr("min");
            let max = jQuery("input",element).attr("max");
            jQuery(".range-value",element).html("<span>"+ value + "</span>");
            const newValue = Number( (value - min) * 100 / (max - min) ),
             	newPosition = 10 - (newValue * 0.2);
            jQuery(".range-value",element).css("left","calc("+newValue+"% + ("+newPosition+"px)");    
        });
        jQuery(this).trigger("input");
    })

    jQuery(".fancy-layout .pro_rate_cal_range_field").each(function(){
    
        jQuery(this).on("input",function(){
            let element = this;
            let value = jQuery("input",element).val();
            let min = jQuery("input",element).attr("min");
            let max = jQuery("input",element).attr("max");
            jQuery(".range-value",element).html("<span>"+ value + "</span>");
            const newValue = Number( (value - min) * 100 / (max - min) ),
            newPosition = 15 - (newValue * 0.3);
            jQuery(".range-value",element).css("left","calc("+newValue+"% + ("+newPosition+"px)");    
        });
    })

})

function proRateCalGetCookie(cName) {
    const name = cName + "=";
    const cDecoded = decodeURIComponent(document.cookie); //to be careful
    const cArr = cDecoded.split('; ');
    let res;
    cArr.forEach(val => {
      if (val.indexOf(name) === 0) res = val.substring(name.length);
    })
    return res
}


class ProRateCalSubmmitionForm{
    form_id;
    current_form_id;
    #sectionid;
    constructor( form_id, sectionid, current_form_id ){
        this.form_id = form_id;
        this.#sectionid = sectionid;
        this.current_form_id = current_form_id;
        this.load();
    }

    load(){
        let form = document.getElementById( this.#sectionid );
        let currentObj = this;
        form.addEventListener("submit",function( e ){
            e.preventDefault();
            let validationState = true;
            jQuery(".pro_rate_cal_custom_fields_required",this).each(function(){
                let value = jQuery("input, textarea", this).val();

                if( value == '' || value == null || value == undefined ){
                    jQuery("span.pro_rate_cal_valdation",this).show();
                    validationState = false;
                }else{
                    jQuery("span.pro_rate_cal_valdation",this).hide();
                }

            })

            if(jQuery(".pro_rate_cal_custom_fields_required [name=firstname]").length == 1){
                var firstname =  jQuery(".pro_rate_cal_custom_fields_required [name=firstname]").val();
                var firstname_length = firstname.length;
                var name_regex = /^[a-zA-Z]+$/;
                if (firstname == '') {
                    var msg = jQuery(".pro_rate_cal_custom_fields_required [name=firstname]").attr('data-validation');
                    jQuery(".pro_rate_cal_custom_fields_required [name=firstname]").next("span.pro_rate_cal_valdation").html(msg)
                    jQuery(".pro_rate_cal_custom_fields_required [name=firstname]").next("span.pro_rate_cal_valdation").show();
                    validationState = false;
                    }else if(!name_regex.test(firstname)){
                        jQuery(".pro_rate_cal_custom_fields_required [name=firstname]").next("span.pro_rate_cal_valdation").html('First name should be in characters');
                        jQuery(".pro_rate_cal_custom_fields_required [name=firstname]").next("span.pro_rate_cal_valdation").show();
                        validationState = false;
                    }else if(firstname_length > 30){
                        jQuery(".pro_rate_cal_custom_fields_required [name=firstname]").next("span.pro_rate_cal_valdation").html('Please enter characters');
                        jQuery(".pro_rate_cal_custom_fields_required [name=firstname]").next("span.pro_rate_cal_valdation").show();
                        validationState = false;
                    }else if(firstname_length < 2){
                        jQuery(".pro_rate_cal_custom_fields_required [name=firstname]").next("span.pro_rate_cal_valdation").html('Please enter characters');
                        jQuery(".pro_rate_cal_custom_fields_required [name=firstname]").next("span.pro_rate_cal_valdation").show();
                        validationState = false;
                    } else {
                    
                    }
                }

            if(jQuery(".pro_rate_cal_custom_fields_required [name=lastname]").length == 1){
                var lastname =  jQuery(".pro_rate_cal_custom_fields_required [name=lastname]").val();
                var lastname_length = lastname.length;
                var name_regex = /^[a-zA-Z]+$/;
                if (lastname == '') {
                    var msg = jQuery(".pro_rate_cal_custom_fields_required [name=lastname]").attr('data-validation');
                    jQuery(".pro_rate_cal_custom_fields_required [name=lastname]").next("span.pro_rate_cal_valdation").html(msg)
                    jQuery(".pro_rate_cal_custom_fields_required [name=lastname]").next("span.pro_rate_cal_valdation").show();
                    validationState = false;
                }else if(!name_regex.test(lastname)){
                    jQuery(".pro_rate_cal_custom_fields_required [name=lastname]").next("span.pro_rate_cal_valdation").html('Last name should be in characters');
                    jQuery(".pro_rate_cal_custom_fields_required [name=lastname]").next("span.pro_rate_cal_valdation").show();
                    validationState = false;
                }else if(lastname_length > 30){
                    jQuery(".pro_rate_cal_custom_fields_required [name=lastname]").next("span.pro_rate_cal_valdation").html('Please enter characters');
                    jQuery(".pro_rate_cal_custom_fields_required [name=lastname]").next("span.pro_rate_cal_valdation").show();
                    validationState = false;
                }else if(lastname_length < 2){
                    jQuery(".pro_rate_cal_custom_fields_required [name=lastname]").next("span.pro_rate_cal_valdation").html('Please enter characters');
                    jQuery(".pro_rate_cal_custom_fields_required [name=lastname]").next("span.pro_rate_cal_valdation").show();
                    validationState = false;
                } else {
                
                }

            }

            if(jQuery(".pro_rate_cal_custom_fields_required [name=email]").length == 1){
                var email =  jQuery(".pro_rate_cal_custom_fields_required [name=email]").val();
                var regExp = /^([\w\.\+]{1,})([^\W])(@)([\w]{1,})(\.[\w]{1,})+$/;
                if (email == '') {
                    var msg = jQuery(".pro_rate_cal_custom_fields_required [name=email]").attr('data-validation');
                    jQuery(".pro_rate_cal_custom_fields_required [name=email]").next("span.pro_rate_cal_valdation").html(msg)
                    jQuery(".pro_rate_cal_custom_fields_required [name=email]").next("span.pro_rate_cal_valdation").show();
                    validationState = false;
                }else if(!regExp.test(email)){
                    jQuery(".pro_rate_cal_custom_fields_required [name=email]").next("span.pro_rate_cal_valdation").html('You have entered an invalid e-mail address.')
                    jQuery(".pro_rate_cal_custom_fields_required [name=email]").next("span.pro_rate_cal_valdation").show();
                    validationState = false;
                } else {
                
                    jQuery("input[name=proratecal_user_mail]", "#" + currentObj.current_form_id ).val(email);
                    document.cookie = "pro_rate_cal_quote_email_"+ currentObj.form_id +" = " + email;                  
                }
            }
            if(jQuery(".pro_rate_cal_custom_fields_required [name=phone]").length == 1){
                var phone =  jQuery(".pro_rate_cal_custom_fields_required [name=phone]").val();
                var filter = /^[0-9-+]+$/;
                if (phone == '') {
                    var msg = jQuery(".pro_rate_cal_custom_fields_required [name=phone]").attr('data-validation');
                    jQuery(".pro_rate_cal_custom_fields_required [name=phone]").next("span.pro_rate_cal_valdation").html(msg);
                    validationState = false;
                }else if(!filter.test(phone)){
                    jQuery(".pro_rate_cal_custom_fields_required [name=phone]").next("span.pro_rate_cal_valdation").html('Phone numder is not vaild')
                    jQuery(".pro_rate_cal_custom_fields_required [name=phone]").next("span.pro_rate_cal_valdation").show();
                    validationState = false;
                }else if(phone.length > 13){
                    jQuery(".pro_rate_cal_custom_fields_required [name=phone]").next("span.pro_rate_cal_valdation").html('Phone numder in maximum 13 character')
                    jQuery(".pro_rate_cal_custom_fields_required [name=phone]").next("span.pro_rate_cal_valdation").show();
                    validationState = false;
                }else if(phone.length < 9){
                    jQuery(".pro_rate_cal_custom_fields_required [name=phone]").next("span.pro_rate_cal_valdation").html('Phone numder in minimum 9 character')
                    jQuery(".pro_rate_cal_custom_fields_required [name=phone]").next("span.pro_rate_cal_valdation").show();
                    validationState = false;
                } 
                else {
                
                }
            }

            if( validationState ){
                let data = jQuery(this).serializeArray();
                if( data ){
                    let jsonArray = {};
                    data.forEach(function( value, index ){
                        jsonArray[value["name"]] = value["value"];
                    })
                    jQuery.ajax({
                        url: project_rate_calculator.ajaxurl,
                        type: 'POST',
                        data: {
                            'action': "submit_pro_rate_cal_custom_form",
                            'form_id': currentObj.form_id,
                            "data" : jsonArray,
                        },
                        success: function( response ) {
                            jQuery(".pro_rate_cal_message",form).text( response.message );
                            jQuery(".sticky_form").removeClass("active");
                            jQuery('.pro_cale_sticky_form_overly').removeClass("active");
                            jQuery("body").removeClass("pro_rate_overflow_hide");
                            setTimeout(function(){ 
                                jQuery(".pro_rate_cal_message",form).text("");
                            }, 5000);
                            document.cookie = "pro_rate_cal_form_id_"+currentObj.form_id+"=true";
                        },
                    });
                }
            }
        })
    }
}

function verifyConditions( conditionValue, conditions, totalvalue ){
    if( typeof conditionValue == "string" ){                 
        if( typeof conditions == "string" && conditions == "is" ){
            if( totalvalue == conditionValue ){
                return true;
            }else{
                return false;
            }
        }else{
            if( totalvalue != conditionValue ){
                return true;
            }else{
                return false;
            }
        }
    }
}