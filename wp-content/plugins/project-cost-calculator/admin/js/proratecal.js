/* Library that help to generate elements and windows */
var pro_rate_cal_currency_symbol = '$';
if( typeof project_rate_calculator.pro_rate_cal_default_currency == "string" ){
    pro_rate_cal_currency_symbol = project_rate_calculator.pro_rate_cal_default_currency;
}
class ProRateCalLib{

    class_fieldsTab = {
        "symbol" : "pro_rate_cal_symbol_tab",
        "field_name" : "pro_rate_cal_field_name_tab",
        "category" : "pro_rate_cal_field_category_tab",
        "rate" : "pro_rate_cal_field_rate_tab",
        "defaultQty" : "pro_rate_cal_field_default_qty_tab",
        "action" : "pro_rate_cal_field_action_tab",
        "half_field" : "pro_rate-cal_half",
        "hide_field" : "pro_rate-hide_field",
        "show_field" : "pro_rate-show_field",
        "required_field" : "pro_rate_cal_required_field"
    };

    content_fieldTab = {
        "symbol" : "<span class='dashicons dashicons-plus-alt'></span>",
        "field_name" : function(content){
            if( content ){
                return "<span>"+content+"</span>";
            }else{
                return null;
            }
        },
        "edit" : '<span class="dashicons dashicons-edit"></span>',
        "delete" : '<span class="dashicons dashicons-trash"></span>',
    }

    createFields( key, setting, className = null, tempeId = null , value = null){
        if( setting.attributes.layout ){
            if( setting.attributes.layout == "half" ){
                className = className +" "+ this.class_fieldsTab.half_field;
            }
        }
        
        if( setting.attributes.type == "checkbox" ){
            if( setting.status == "hide" ){
                if( setting.attributes.value == 'yes' ){
                    className = className +" "+ this.class_fieldsTab.show_field;
                }else{
                    className = className +" "+ this.class_fieldsTab.hide_field;
                }
            }
        }
        
        let fieldlabel = setting.name;
        let fieldClass =  className;
        if( setting.attributes.required ){
            if( setting.attributes.required == true ){
                fieldlabel = fieldlabel + " <span class='pro_rate_cal_astric'>*</span>";
                fieldClass = fieldClass + " " + this.class_fieldsTab.required_field;
            }
        }

        let field = document.createElement("div");
        field.setAttribute("class",fieldClass);
        field.setAttribute("id",key);
        let label = document.createElement("label");
        label.innerHTML = fieldlabel ;
        field.append(label);
        let element;

        if( setting.element == "choice" ){
            element = this.getCustomElement("choice", setting, className, tempeId, value);
        } else if( setting.element == "elements_condition" ){
            element = this.getconditionElement("elements_condition", setting, className, tempeId, value);
        }else if( setting.element == "textarea" ){
            element = document.createElement(setting.element);
            Object.entries(setting.attributes).forEach(([key, value]) => {
                element.setAttribute( key, value);
            });

            if( setting.attributes.value ){
                element.value = setting.attributes.value;
            }
        }else if( setting.attributes.type == "checkbox" ){
            element = document.createElement(setting.element);
            Object.entries(setting.attributes).forEach(([key, value]) => {
                element.setAttribute( key, value);
            });
            if( setting.attributes.value == 'yes' ){
                element.setAttribute(value,'yes');
                element.setAttribute('checked','checked');
            }else{
                element.setAttribute(value,'no'); 
            }
        }else {
            element = document.createElement(setting.element);
            Object.entries(setting.attributes).forEach(([key, value]) => {
                element.setAttribute( key, value);
            });

            if( setting.element == "select" ){
                Object.entries(setting.attributes.list).forEach(([key, value]) => {
                    let option = document.createElement( "option" );
                    option.setAttribute( "value", key);
                    if( setting.attributes.value == key ){
                        option.setAttribute( "selected", true);
                    }
                    option.innerHTML = value;
                    element.append(option);
                });
            }
        }
       
        field.append(element);
        return field;
    }

    // condition Element start 

    getconditionElement(element, setting, className = null, tempeId = null , value = null) {
        let list = document.createElement("ul");
        /* set values on update */
        if(setting.attributes.value ){
            if( typeof setting.attributes.value.elements_select != "undefined" ){
            let loop_count =  setting.attributes.value.elements_select.length
                for (let index = 0; index < setting.attributes.value.elements_select.length; index++) {
                    let li = document.createElement("li");
                        Object.entries(setting.attributes.value).forEach(([get_valus_keys,get_valus_values]) => {
                            Object.entries(setting.attributes).forEach(([key,values]) => {
                                if(get_valus_keys == key){
                                    element = document.createElement(values.element); 
                                    Object.entries(values).forEach(([key, value]) => {
                                        element.setAttribute( key, value);
                                    });  
                                        if(values.type == "select" ){
                                            if(get_valus_keys == 'elements_select'){
                                                Object.entries(proRatCalBuilder.getJsonValues()).forEach(([option_key, option_value]) => {
                                                if(tempeId != option_key){
                                                        if(option_value.module_id != 'line' ){
                                                            let option = document.createElement( "option" );
                                                            option.setAttribute( "value", option_key);
                                                            if( option_key == get_valus_values[index] ){
                                                                option.setAttribute( "selected", true);
                                                            }
                                                            option.innerHTML = option_value.settings.label_name;
                                                            element.append(option);
                                                        }
                                                }
                                                    
                                                });
                    
                                            } else if(get_valus_keys == 'elements_select_condition' ) {
                                                Object.entries(values.list).forEach(([option_key, option_value]) => {
                                                    let option = document.createElement( "option" );
                                                    option.setAttribute( "value", option_key);
                                                    if( option_key == get_valus_values[index] ){
                                                        option.setAttribute( "selected", true);
                                                    }
                                                    option.innerHTML = option_value;
                                                    element.append(option);
                                                });
                                            } else{
                                            }
                                        } else{
                                            element.setAttribute( "value", get_valus_values[index]);     
                                        }
                                    li.append(element);
                                }
                            
                            });
                        });
                    
                        let clone = document.createElement("button");
                        if(index == loop_count-1 ){
                            clone.setAttribute("class","pro_rate_clone_btn rate_cal_icon_transparent_button");
                            clone.innerHTML = "<span class='dashicons dashicons-plus-alt2'></span>";
                        }else{
                            clone.setAttribute("class","pro_rate_close_btn rate_cal_icon_transparent_button");
                            clone.innerHTML = "<span class='dashicons dashicons-no-alt'></span>";  
                        }
                        li.append(clone);

                    list.append(li);
                }  
            }
        }
        /* set values on update */
        else{
            let li = document.createElement("li");
            Object.entries(setting.attributes).forEach(([keys,values]) => {
                if(keys != 'value'){
                    element = document.createElement(values.element); 
                    Object.entries(values).forEach(([key, value]) => {
                        element.setAttribute( key, value);
                    });                    if(values.type == "select" ){
                        Object.entries(values.list).forEach(([key, value]) => {
                          if(values.name == 'elements_select'){
                              if( typeof proRatCalBuilder.getJsonValues() == "object" ){
                                Object.entries(proRatCalBuilder.getJsonValues()).forEach(([option_key, option_value]) => {
                                    if(tempeId != option_key){
                                        if(option_value.module_id != 'line' ){
                                            let option = document.createElement( "option" );
                                            option.setAttribute( "value", option_key);
                                            option.innerHTML = option_value.settings.label_name;
                                            element.append(option);
                                        }
                                    }
                                });
                              }else{
                                let option = document.createElement( "option" );
                                option.setAttribute( "value", '0');
                                option.innerHTML = 'select';
                                element.append(option);
                              }
                                
                          }else{
                            let option = document.createElement( "option" );
                            option.setAttribute( "value", key);
                            if( setting.attributes.value == key ){
                                option.setAttribute( "selected", true);
                            }
                            option.innerHTML = value;
                            element.append(option);
    
                          }
                        });
                    }
                    li.append(element);
                    if( values.clone == "true" ){
                        let clone = document.createElement("button");
                        clone.setAttribute("class","pro_rate_clone_btn rate_cal_icon_transparent_button");
                        clone.innerHTML = "<span class='dashicons dashicons-plus-alt2'></span>";
                        li.append(clone);
                        
                    }
                }
               
            });
            list.append(li);
        }
        /* set values  */     
        let sortable = jQuery(list).sortable();
        return list;  
    }

   // condition Element end 
    getCustomElement(element, setting, className = null, tempeId = null, value = null){
        if( element == "choice" ){
            let choiceElementContainer = document.createElement("div");
            choiceElementContainer.setAttribute("class", "pro_rate_settings_choice_fields simple_input_setting_field");
            if( typeof setting.attributes['data-validation'] == "string" ){
                choiceElementContainer.setAttribute("data-validation",setting.attributes['data-validation']);
            }
            let list = document.createElement("ul");
            choiceElementContainer.append(list);
            let currentObj = this;
            if( setting.attributes.value ){
                let defaultValue = null;
                if( setting.attributes.value.default ){
                    defaultValue = setting.attributes.value.default;
                }
                setting.attributes.value.labels.forEach(function(value, key){
                    let li = currentObj.createChoiceList(setting, value, setting.attributes.value.values[key],defaultValue);
                    list.append(li);
                })
            }
            let addBtn = document.createElement("button");
            addBtn.setAttribute("type","button");
            addBtn.setAttribute("class","rate_cal_button rate_cal_button_primary_border");
            addBtn.innerHTML = "Add new "+setting.name;
            addBtn.addEventListener("click", function(){
                let li = currentObj.createChoiceList(setting,null,null,null);
                list.append(li);
            })
            let default_value = null;
            if( setting.attributes.default_value ){
                default_value = "choice one";
            }
            /* Set byDefault choice one */
            if ( !setting.attributes.value ){
                let li = currentObj.createChoiceList(setting,"", "", default_value );
                list.append(li);
            }
            if( list.children.length > 1 ){
                list.childNodes.forEach(function(el){
                    el.childNodes[4].style = "display:block;" ;
                })
            }
            let sortable = jQuery(list).sortable();
            choiceElementContainer.append( addBtn );
            return choiceElementContainer;
        }

    }
    createChoiceList(setting, value, rateValue ,defaultValue = null){
        let li = document.createElement("li");
        let bar = document.createElement("img");
        bar.setAttribute("src",project_rate_calculator.calFormData.images.dragdropicon);
        bar.setAttribute("class","dashicons dashicons-menu rate_cal_sortable_tab");
        li.append(bar);
        let radio = document.createElement("input");
        radio.setAttribute("name",setting.attributes.name+"_choice_default");
        radio.setAttribute("type","radio");
        if( value ){
            radio.setAttribute("value",value);
            if( defaultValue == value ){
                radio.setAttribute("checked",true);
            }
        }
        li.append(radio);
        let label = document.createElement("input");
        label.setAttribute("name",setting.attributes.name);
        label.setAttribute("data-name",setting.attributes.name);
        if( value ){
            label.setAttribute("value",value);
        }
        label.setAttribute("type","text");
        label.setAttribute("placeholder","Choice Name");
        li.append(label);
        let valueField = document.createElement("input");
        valueField.setAttribute("name",setting.attributes.name+"_value");
        valueField.setAttribute("type","number");
        valueField.setAttribute("min",0);
        if( rateValue ){
            valueField.setAttribute("value",rateValue);
        }
        valueField.setAttribute("placeholder","("+ pro_rate_cal_currency_symbol +") Rate");
        li.append(valueField);
        label.addEventListener("keyup",function(){
            radio.value = this.value;
        })
        let removeBtn = document.createElement("button");
        removeBtn.setAttribute("class","rate_cal_button rate_cal_icon_transparent_button");
        removeBtn.innerHTML = "<span class='dashicons dashicons-no-alt'></span>";
        if( jQuery(".pro_rate_settings_choice_fields li").length < 1 ){
            removeBtn.style.display = "none";
        }else{
            jQuery(".pro_rate_settings_choice_fields li > button").show();
        }
        li.append(removeBtn);
        removeBtn.addEventListener("click",function(){
            li.remove();
            if( jQuery(".pro_rate_settings_choice_fields li").length <= 1 ){
                jQuery(".pro_rate_settings_choice_fields li > button").hide();
            }
        });
        return li;
    }

    createElement( element, attributes, content = null){
        let field = document.createElement(element);
        Object.entries(attributes).forEach(([key, value]) => {
            field.setAttribute( key, value);
        });
        if ( content ){
            field.innerHTML = content;
        }
        return field;
    }

    generateFieldItem(elementJson){
        let field = this.createElement( "tr", { "id" : elementJson.element_id, "data-module_id" : elementJson.module_id, "data-module_name" : elementJson.module_name, "data-order" : elementJson.order} );
        let dragSymbol = this.createElement( "img", { "src" : project_rate_calculator.calFormData.images.dragdropicon, "title" : "Drag and Sort" });
        let labelName;
        if( elementJson.settings.label_name ){
            labelName = elementJson.settings.label_name;
        }else{
            labelName = elementJson.module_name;
        }
       let fieldNameTab = this.createElement( "td", { "class" : this.class_fieldsTab.field_name }, this.content_fieldTab.field_name( labelName ) );
       fieldNameTab.append(dragSymbol);
       field.append(fieldNameTab);
       console.log(elementJson.settings.category_field);
       let fieldCatTab = this.createElement( "td", { "class" : this.class_fieldsTab.category }, this.content_fieldTab.field_name(project_rate_calculator.calFormData.category[elementJson.settings.category_field]) );
       field.append(fieldCatTab);
       let fieldRatetTab = this.createElement( "td", { "class" : this.class_fieldsTab.rate }, this.content_fieldTab.field_name( elementJson.settings.rate ) );
       field.append(fieldRatetTab);
       let fieldDefaultQtytTab = this.createElement( "td", { "class" : this.class_fieldsTab.defaultQty }, this.content_fieldTab.field_name( elementJson.settings.default_quantity ) );
       field.append(fieldDefaultQtytTab);
       //tooltip
       let tooltip = this.createElement( "td", {  }, this.content_fieldTab.field_name( elementJson.settings.tooltip ) );
       field.append(tooltip);
       let fieldActiontTab = this.createElement( "td", { "class" : this.class_fieldsTab.action });
       let btnEdit = this.createElement( "button", { "type" : "button","title" : "Edit Field" ,"onClick" : "proRatecalFormEditElement('" + elementJson.element_id + "');"}, this.content_fieldTab.edit);
       fieldActiontTab.append( btnEdit );
       let btnDelete = this.createElement( "button", { "type" : "button","title" : "Remove Field", "onClick" : "proRatecalFormRemoveElement('" + elementJson.element_id + "');"}, this.content_fieldTab.delete);
       fieldActiontTab.append( btnDelete );
       field.append(fieldActiontTab);
       return field;
    }

    updateFieldItem(elementJson){
        let field = document.getElementById(elementJson.element_id);
        field.innerHTML = "";
        let dragSymbol = this.createElement( "img", { "src" : project_rate_calculator.calFormData.images.dragdropicon, "title" : "Drag and Sort" });
        let labelName;
        if( elementJson.settings.label_name ){
            labelName = elementJson.settings.label_name;
        }else{
            labelName = elementJson.module_name;
        }
        let fieldNameTab = this.createElement( "td", { "class" : this.class_fieldsTab.field_name }, this.content_fieldTab.field_name(labelName) );
        fieldNameTab.append(dragSymbol);
        field.append(fieldNameTab);
        let fieldCatTab = this.createElement( "td", { "class" : this.class_fieldsTab.category }, this.content_fieldTab.field_name( project_rate_calculator.calFormData.category[elementJson.settings.category_field] ) );
        field.append(fieldCatTab);
        let fieldRatetTab = this.createElement( "td", { "class" : this.class_fieldsTab.rate }, this.content_fieldTab.field_name( elementJson.settings.rate ) );
        field.append(fieldRatetTab);
        let fieldDefaultQtytTab = this.createElement( "td", { "class" : this.class_fieldsTab.defaultQty }, this.content_fieldTab.field_name( elementJson.settings.default_quantity ) );
        field.append(fieldDefaultQtytTab);
         //tooltip
        let tooltip = this.createElement( "td", {  }, this.content_fieldTab.field_name( elementJson.settings.tooltip ) );
        field.append(tooltip);
        let fieldActiontTab = this.createElement( "td", { "class" : this.class_fieldsTab.action });
        let btnEdit = this.createElement( "button", { "type" : "button", "title" : "Edit Field" ,"onClick" : "proRatecalFormEditElement('" + elementJson.element_id + "');"}, this.content_fieldTab.edit);
        fieldActiontTab.append( btnEdit );
        let btnDelete = this.createElement( "button", { "type" : "button","title" : "Remove Field", "onClick" : "proRatecalFormRemoveElement('" + elementJson.element_id + "');"}, this.content_fieldTab.delete);
        fieldActiontTab.append( btnDelete );
        field.append(fieldActiontTab);
    }
}
var proRateCalTool = new ProRateCalLib();

/* ===================================================================================================================== */
/* Handle Fields Value and builder*/
class ProRatCalBuilder{
    elementFieldPrefix = "field_";
    jsonValueFieldSelector = "form#pro_rate_cal_new_form input[name=json_values]";
    proRateCalBulderContainerSelector = "pro_rate_cal_builder_fields";
    updateFieldsOrder( orders ){
        let jsonValue = this.getJsonValues();
        if ( jsonValue ){
            Object.entries(orders).forEach(([key, value]) => {
                jsonValue[key]["order"] = value;
            });
            if( this.updateJsonValues(jsonValue) ){
                console.log( "Order has been saved" );
            }
        } else {
            console.error("Json fields value are null or invalid");
        }
    }
    insertElement( module_id, module_name, settingsValues, elementId = null){
        let jsonValue = this.getJsonValues();
        if( !jsonValue ){
            jsonValue = {};
        }
        if( jsonValue[elementId] != undefined ){
            jsonValue[elementId].settings = settingsValues;
            proRateCalTool.updateFieldItem(jsonValue[elementId]);
        } else {
            let currentElementValue = {
                element_id : elementId,
                module_id : module_id,
                module_name : module_name,
                settings : settingsValues,
                order : this.getNewFieldOrder(),
            };
            jsonValue[elementId] = currentElementValue;
            let field = proRateCalTool.generateFieldItem(jsonValue[elementId]);
            let tbody = document.getElementById(this.proRateCalBulderContainerSelector);
            tbody.append(field);
        }
        return this.updateJsonValues(jsonValue);
    }

    getNewFieldOrder(){
        let length = document.querySelectorAll("#" + this.proRateCalBulderContainerSelector + "> tr").length;
        return length;
    }

    generateElementId(){
        let id = this.elementFieldPrefix + Date.now();
        return id;
    }

    /* fetch json input field values */
    getJsonValues(){
        let stringValue = document.querySelector(this.jsonValueFieldSelector).value;
        return project_rate_calculator_edit;
        if( stringValue ){
            let jsonValue = JSON.parse(stringValue);
            return jsonValue;
        } else {
            return "";
        }
    }

    /* add json values */
    updateJsonValues( jsonValue ){
        console.log( jsonValue );
        if( typeof jsonValue == "object" ){
            saveState = false;
            console.log( jsonValue );
            project_rate_calculator_edit = jsonValue;
            
            let stringValue = JSON.stringify(jsonValue);
            this.checkFieldsAvailabale( jsonValue );
            if( stringValue ){
                document.querySelector(this.jsonValueFieldSelector).value = stringValue;
                if(document.querySelector(this.jsonValueFieldSelector).value == stringValue){
                    return true;
                }
            }
        }
    }

    checkFieldsAvailabale( jsonValue ){
        if( ( typeof jsonValue == "object" || typeof jsonValue == "string" ) && Object.keys(jsonValue).length == 0){
            // set empty field label
            let p = document.createElement("p");
            p.setAttribute("id","pro_rate_cal_empty_field_message");
            p.innerHTML = "No fields available."
            document.getElementById("pro_rate_cal_builder").append( p );
        }else{
            // remove empty field label
            let p = document.getElementById( "pro_rate_cal_empty_field_message" );
            if( typeof p == "object" && p != null ){
                p.remove();
            }
        }
    }

    /* Remove Element Data from json */
    removeFieldElement( elementId ){
        let jsonValue = this.getJsonValues();
        delete jsonValue[elementId];
        document.getElementById( elementId ).remove();
        let newJsonValue = this.updateElementOrder( jsonValue );
        if( this.updateJsonValues( newJsonValue ) ){
           // console.log( elementId + " Has been removed" );
        }
    }

    updateElementOrder( json ){
        document.querySelectorAll("#pro_rate_cal_builder_fields" + "> tr").forEach(function(el, i){
            json[el.getAttribute("id")].order = i;
            el.setAttribute("data-order",i);
        });
        return json;
    }

    generateBuilder(){
        let jsonValue = this.getJsonValues();
        this.checkFieldsAvailabale( jsonValue );
        if( jsonValue ){
            //sort order
            let jsonOrder = [];
            Object.entries(jsonValue).forEach(([key, value]) => {
                jsonOrder[value.order] = key;
            });
            let tbody = document.getElementById(this.proRateCalBulderContainerSelector);
            jsonOrder.forEach(
                function( val, index){
                    let field = proRateCalTool.generateFieldItem(jsonValue[val]);
                    tbody.append(field);
                }
            );
        }
    }

    editFieldElement(elementId){
        let jsonValue = this.getJsonValues();
        let currentJsonValue = jsonValue[elementId];
        let settings = project_rate_calculator.calFormData.modules[currentJsonValue.module_id];
        Object.entries(settings).forEach(([key, value]) => {
            value.attributes["value"] = currentJsonValue.settings[key];
        });
        let newSettings = new ProRatCalModuleElement( currentJsonValue.module_id, currentJsonValue.module_name, settings, currentJsonValue.element_id  );
        newSettings.isUpdate = true;
        newSettings.load();
    }
}
var proRatCalBuilder = new ProRatCalBuilder( );
/* ===================================================================================================================== */
/* Handle Modules */
class ProRatCalModuleElement{
    moduleId;
    moduleName;
    moduleSettings;
    elementId;
    builder;
    isUpdate = false;
    /* Elements class and ids */
    class_element_popup_container = "pro_rate-cal_backdrop_model";
    class_element_setting_window = "pro_rate_cal_builder_popup_window proratecal_popup_window";
    pro_rate_cal_builder_popup_window_header = "pro_rate_cal_builder_popup_window_header";
    class_element_setting_fields = "pro_rate_cal_setting_fields";
    class_element_setting_action = "pro_rate_cal_setting_action";
    span_close_icon = "×";
    /* includes lib */
    tools = new ProRateCalLib();
    constructor(moduleId, moduleName, moduleSettings, elementId = null, builderId = "pro_rate_cal_builder"){
        this.moduleId = moduleId;
        this.moduleName = moduleName;
        this.moduleSettings = moduleSettings;
        if( elementId == null ){
            this.elementId = proRatCalBuilder.generateElementId();
        }else{
            this.elementId = elementId;
        }
        this.builder = document.getElementById(builderId);
    }

    load(){
        this.loadSettingsWindow();
    }

    loadSettingsWindow(){
        let popupConainer = document.createElement("div");
        popupConainer.setAttribute( "class", this.class_element_popup_container);
        let mainConainer = document.createElement("div");
        mainConainer.setAttribute("class",this.class_element_setting_window);
        let headerContainer = document.createElement("div");
        headerContainer.setAttribute("class",this.pro_rate_cal_builder_popup_window_header);
        let settingtitle = document.createElement("h4");
        settingtitle.innerHTML = this.moduleName;
        headerContainer.append(settingtitle)
        let closeBtn = this.tools.createElement( "span", { class: "rate_cal_close_popup_button" }, this.span_close_icon);
        headerContainer.append(closeBtn)
        mainConainer.append(headerContainer);
        let form = document.createElement("form");
        let tempeId = this.elementId;
        Object.entries(this.moduleSettings).forEach(([key, value]) => {
            if( typeof value.element == "string" && value.element == "textarea"){
                if( typeof value.attributes.value == "string"){
                    value.attributes.value = value.attributes.value.replace(/<quot;>/g, '"').replace(/<apos;>/g, "'");
                }
            }
            let field = this.tools.createFields( key, value, this.class_element_setting_fields,tempeId);
            form.append(field);
        });
        let actionBar = document.createElement("div");
        actionBar.setAttribute("class",this.class_element_setting_action);
        let insertBtnText = "insert";
        if( this.isUpdate ){
            insertBtnText = "Update";
        }
        let insertBtn = this.tools.createElement( "button", { type : "button", class : "rate_cal_button rate_cal_button_primary" }, insertBtnText);
        actionBar.append(insertBtn);
        let cancleBtn = this.tools.createElement( "button", { type : "button", class : "rate_cal_button rate_cal_button_primary_border" }, "Cancel");
        actionBar.append(cancleBtn);
        form.append(actionBar);
        form.addEventListener("submit", function(event){
            event.preventDefault();
        });
        let currentObj = this;
        cancleBtn.addEventListener("click", function(){
            currentObj.removeRequiredSettings();
            popupConainer.remove();
        });
        closeBtn.addEventListener("click", function(){
            currentObj.removeRequiredSettings();
            popupConainer.remove();
        });
        let moduleId = this.moduleId;
        let moduleName = this.moduleName;
        let elementId = this.elementId;
        let moduleSettings = this.moduleSettings;
        insertBtn.addEventListener("click", function(){
            let formObject  = new FormData(form);
            let result = {};
            let validationState = true;
            Object.entries( moduleSettings ).forEach(([key, value]) => {
                if( value.element == "choice" ){
                    result[key] = {};
                    result[key]['labels'] = formObject.getAll( value.attributes.name );
                    result[key]['values'] = formObject.getAll( value.attributes.name+"_value" );
                    result[key]['default'] = formObject.get(value.attributes.name+"_choice_default");
                } else if(value.element == "elements_condition"){
                    result[key] = {};
                    result[key]['elements_select'] = formObject.getAll( value.attributes.elements_select.name );
                    result[key]['elements_select_condition'] = formObject.getAll( value.attributes.elements_select_condition.name );
                    result[key]['elements_select_value'] = formObject.getAll( value.attributes.elements_select_value.name );
                }else if(value.element == "textarea"){
                    console.log(currentObj.getTextAreaContent(value.attributes.id));
                    result[key] = currentObj.getTextAreaContent(value.attributes.id);

                } else {
                    result[key] = formObject.get( value.attributes.name );
                }

            });
            jQuery("div.pro_rate_cal_required_field .simple_input_setting_field", form).each(function(){
                if(jQuery(this).is("input") || jQuery(this).is("textarea")){
                    let value = jQuery(this).val();
                    if( (value == null) || (value == undefined) || (value == '') ){
                        validationState = false;
                        jQuery(this).addClass("pro_rate_cal_field_error");
                    }else{
                        jQuery(this).removeClass("pro_rate_cal_field_error");
                        if(validationState == null ){
                            validationState = true;
                        }
                    }
                }
                let validationCall = jQuery(this).data("validation");
                if( typeof validationCall === "string" ){
                    if(typeof window[validationCall] === "function"){
                        validationState = window[validationCall]( this, form, validationState );
                    }
                }

            });

            jQuery("div.pro_rate_cal_required_field .pro_rate_settings_choice_fields input", form).each(function(){
                let value = jQuery(this).val();
                if( (value == null) || (value == undefined) || (value == '') ){
                    jQuery(this).addClass("pro_rate_cal_field_error");
                    validationState = false;
                }else{
                    jQuery(this).removeClass("pro_rate_cal_field_error");
                    if(validationState == null ){
                        validationState = true;
                    }
                }
            });

            // logic condition validationState true
            if(jQuery('#logic input').prop('checked') == true){
                jQuery("#elements_condition input, #elements_condition select").each(function(){
                    let value = jQuery(this).val();
                    if( (value == null) || (value == undefined) || (value == '') ){
                        validationState = false;
                    }else{ 
                        validationState = true; 
                    }
                });
            }
            // logic condition true end 

            let jsonValues = result;
            if( validationState ){
                if( proRatCalBuilder.insertElement( moduleId, moduleName, jsonValues, elementId) == true){
                    currentObj.removeRequiredSettings();
                    popupConainer.remove();
                }
            }else{
                jQuery("p.error_field",form).remove();
                let errorP = document.createElement("p");
                errorP.setAttribute("class","error_field");
                errorP.innerHTML = "Some Fields value are Required or Invalid.";
                form.prepend(errorP);
                setTimeout(function(){
                    errorP.remove();
                },3000)
            }
        });

        mainConainer.append(form);
        popupConainer.append(mainConainer);
        let preModule = document.querySelector("."+this.class_element_popup_container);
        if( preModule != null){
            preModule.remove();
        }
        this.builder.append(popupConainer);
        this.loadRequiredSettings();
    }

    loadRequiredSettings(){
        /* wp_wysig_editor */
        let elements = document.querySelectorAll(".wp_wysig_editor");
        elements.forEach(function(element, index){
            if( element.id ){
                if( wp.editor ){
                    wp.editor.initialize( element.id,
                        {
                            tinymce: {
                                wpautop: true,
                                plugins : 'charmap colorpicker compat3x directionality fullscreen hr image lists media paste tabfocus textcolor wordpress wpautoresize wpdialogs wpeditimage wpemoji wpgallery wplink wptextpattern wpview',
                                toolbar1: 'bold italic underline strikethrough | bullist numlist | blockquote hr wp_more | alignleft aligncenter alignright | link unlink | wp_adv',
                                toolbar2: 'formatselect alignjustify forecolor | pastetext removeformat charmap | outdent indent | undo redo | wp_help'
                            },
                            quicktags: true,
                            mediaButtons: true,
                        }
                    );
                }else{
                    console.warn("Cannot initialize wysig editor, Wordpress editor library not found.");
                }
            }else{
                console.warn("Id atrributes must be set for wysig editor");
            }
        })
    }

    removeRequiredSettings(){
        //wp.editor.remove(editor_id)
        let elements = document.querySelectorAll(".wp_wysig_editor");
        elements.forEach(function(element, index){
            if( element.id ){
                if( wp.editor ){
                    wp.editor.remove( element.id )
                }else{
                    console.warn("Cannot initialize wysig editor, Wordpress editor library not found.");
                }
            }else{
                console.warn("Id atrributes must be set for wysig editor");
            }
        })
    }

    getTextAreaContent(id){
        var mce_editor = tinymce.get(id);
        let content
        if(mce_editor) {
            content = wp.editor.getContent(id);
            content = content.replace(/"/g, "<quot;>").replace(/'/g, "<apos;>");
        } else {
            content = document.getElementById(id).value;
        }
        return content;
    }
}


/* ================================================================================================================= */
function proRatecalFormEditElement( elementId ){
    proRatCalBuilder.editFieldElement( elementId );
}

function proRatecalFormRemoveElement( elementId ){
    /* Remove field from jsonDate */
    new ProRateCalModel( elementId, "remove_element" );
}

/* Open settings of Module Element */
function proRateCalModuleSettings(response){
    let module = new ProRatCalModuleElement( response.module_id, response.module_name, response.settings);
    /* init module settings */
    module.load();
}

/* pro rate cal notification class */
class ProRateCalNotification{
    constructor( selector, message, state = "info" ){
        let type = "info";
        if( state == "info" ){
            type = "info";
        } else if ( state == "warning" ) {
            type = "warning";
        } else if ( state == "error" ){
            type = "error";
        }else if ( state == "success" ){
            type = "success";
        }else {
            type = "info";
        }
        let alert = document.createElement("div");
        alert.setAttribute("class","notice notice-"+type);
        let p = document.createElement("p");
        p.innerHTML = message;
        alert.append(p);
        let element = document.querySelector(selector);
        element.append(alert);
        setTimeout(function(){ 
            alert.remove();
        }, 5000);
    }
}

class ProRateCalModel{
    /* selector */
    selectorModelContainer = ".pro_rate_cal_model";
    selectorCloseModel = ".pro_rate_cal_model_icon_close";
    selectorModelBody = ".pro_rate_cal_model_model_body";
    selectorHeading = ".pro_rate_cal_model .pro_rate_cal_model_header h2";
    /* class */
    classOpenModel = "pro_rate_cal_model_open";
    /* element */
    model;
    modelBody;
    /*obj*/
    tools = new ProRateCalLib();
    /* values */
    responseValue;
    key = null;
    constructor( id, key = null ){
        this.key = key;
        this.responseValue = id;
        this.loadModel();
        this.loadCloseFunction();
        this.confirmModel();
        this.setheader("Delete Form");
        this.openModel();
    }

    loadModel(){
        this.model = document.querySelector( this.selectorModelContainer );
        this.modelBody = document.querySelector( this.selectorModelBody );
    }

    openModel(){
        this.model.classList.add( this.classOpenModel );
    }

    loadCloseFunction(){
        let close = document.querySelector( this.selectorCloseModel );
        let currentObj = this;
        close.addEventListener("click",function(){
            currentObj.model.classList.remove(currentObj.classOpenModel);
            currentObj.clearModel();
        })
    }

    setheader( text ){
        let header = document.querySelector( this.selectorHeading );
        header.innerHTML = text;
    }
    confirmModel(){
        let textContainer = this.tools.createElement( "div", {class:"pro_rate_cal_model_message"} );
        let message = this.tools.createElement( "p", {class:"pro_rate_cal_model_message_p"}, "Do you really want to delete?" );
        textContainer.append( message );
        this.modelBody.append(textContainer);
        let actions = this.actionContainer();
        this.modelBody.append(actions);
    }

    actionContainer(){
        let actionContainer = this.tools.createElement( "div", {class:"pro_rate_cal_model_action"} );
        let confirmBtn = this.tools.createElement( "input", {type:"button",class:"pro_rate_cal_model_confirm_btn rate_cal_button rate_cal_button_primary", value : "Delete"} );
        actionContainer.append(confirmBtn);
        let cancelBtn = this.tools.createElement( "input", {type:"button",class:"pro_rate_cal_model_cancel_btn rate_cal_button rate_cal_button_primary_border", value : "Cancel" } );
        actionContainer.append(cancelBtn);
        let currentObj = this;
        confirmBtn.addEventListener("click",function(){
            if( currentObj.key == "remove_element" ){
                proRatCalBuilder.removeFieldElement( currentObj.responseValue );
            }else{
                console.log( "hello");
                deleteCalculatorForm(currentObj.responseValue);
            }
            currentObj.clearModel();
            currentObj.model.classList.remove(currentObj.classOpenModel);
        })

        cancelBtn.addEventListener("click",function(){
            currentObj.model.classList.remove(currentObj.classOpenModel);
            currentObj.clearModel();
        });

        return actionContainer;
    }

    clearModel(){
        let header = document.querySelector( this.selectorHeading );
        header.innerHTML = '';
        this.modelBody.innerHTML = '';
    }
}

class ProRateCalLoader{
    loader;
    constructor(){
        this.loader = document.querySelector(".pro_rate_cal_loader_backdrop");
    }
    start(){
        this.loader.classList.add("pro_rate_cal_loader_backdrop_show");
    }
    stop(){
        this.loader.classList.remove("pro_rate_cal_loader_backdrop_show");
    }
}
