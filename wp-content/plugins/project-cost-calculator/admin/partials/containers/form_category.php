<?php
   /* operation on requested query */
   $message = array();
   $addNewCategoryState = false;
   $actionTitle = __("Add New Category","project-cost-calculator");
   $submitBtn = __("Add New Category","project-cost-calculator");
   if( isset( $_REQUEST['action'] ) ){
      if( sanitize_text_field( $_REQUEST['action'] ) == "delete" ){
         if( isset( $_REQUEST['id'] ) &&  ( !empty( sanitize_text_field( $_REQUEST['id'] ) ) ) ){
            $returnValue = $this->delete_category( sanitize_text_field( $_REQUEST['id'] ) );
            if( !empty ( $returnValue )){
               $message[] = __("Category Deleted Successfully.", "project-cost-calculator");
            }
         }
      }
      if( sanitize_text_field( $_REQUEST['action'] ) == "edit" ){
         if( isset( $_REQUEST['id'] ) &&  ( !empty( sanitize_text_field( $_REQUEST['id'] ) ) ) ){
            $categoryItem = $this->get_category( "ID", sanitize_text_field( $_REQUEST['id'] ) );
            if( !empty ($categoryItem )){
               $actionTitle = __("Edit Category","project-cost-calculator");
               $submitBtn = __("Update Category","project-cost-calculator");
               $addNewCategoryState = true;
            } 
         }
      }
   }
?>
<div class="pro_rate_cal_main_section_new">
   <!-- New Deisign Start -->
   <div class="pro_rate-cal_container-fluid">
      <div id="pro_rate_category_message" class="pro_rate_cal_message_container">
         <?php 
            if( !empty( $message ) ){
               foreach ($message as $key => $value) {
                  printf('<div class="notice notice-info"><p>%s</p></div>',$value);
               }
            }
         ?>
      </div>
      <div class="pro_rate-cal_row">
         <div class="pro_rate-cal_col_12 pro_rate-cal_col_lg_4">
            <div class="pro_rate-cal_card">
               <div class="pro_rate-cal_card_header">
                  <?php if(!empty( $actionTitle )) { ?>
                        <h4>
                        <?php
                            echo esc_html($actionTitle);
                           ?>
                        </h4>
                  <?php } ?>
                  <?php
                     if( !empty( $addNewCategoryState ) ){
                        printf('<a class="rate_cal_button rate_cal_button_primary" href="%s" title="%s">%s</a>',self::get_category_page_url(),__("Add New Category", "project-cost-calculator"),__("Add New Category", "project-cost-calculator"));
                     }
                  ?>
               </div>   
               <div class="pro_rate-cal_card-body">
                  <form id="rate_calculator_category_form" method="post" action="#" class="validate">
                     <?php
                        if( !empty( $categoryItem['term_id'] ) ){
                           ?>
                           <input name="id" id="category-id" type="hidden" value="<?php echo esc_attr($categoryItem['term_id']); ?>" size="40">
                           <?php
                        }
                     ?>
                     <div class="pro_rate_cal_form_fields term-name-wrap">
                        <label for="category-name"><?php _e( "Name", "project-cost-calculator" ); ?></label>
                        <input name="category-name" id="category-name" type="text" value="<?php
                           if( !empty($categoryItem['name']) ){
                              echo esc_attr($categoryItem['name']);
                           }  
                        ?>" size="40" aria-required="true">
                        <p><?php esc_html_e("The name is how it appears on your site.","project-cost-calculator"); ?></p>
                     </div>
                     <div class="pro_rate_cal_form_fields term-slug-wrap">
                        <label for="category-slug"><?php _e( "Slug", "project-cost-calculator" ); ?></label>
                        <input name="category-slug" id="category-slug" type="text" value="<?php
                           if( !empty($categoryItem['slug']) ){
                              echo esc_attr($categoryItem['slug']);
                           }  
                        ?>" size="40">
                        <p><?php esc_html_e("The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.","project-cost-calculator"); ?></p>
                     </div>
                     <div class="pro_rate_cal_form_fields term-parent-wrap">
                        <label for="parent"><?php esc_html_e( "Parent Category", "project-cost-calculator" ); ?></label>
                        <select name="parent" id="parent" class="postform">
                           <?php
                              $catList = PRC_db::get_category_list();
                              foreach ($catList as $key => $value) {
                                    if($value->parent == 0){
                                    ?>
                                    <option class="level-<?php echo esc_attr($value->parent); ?>" value="<?php echo esc_attr($value->term_id); ?>" <?php 
                                    if( !empty( $categoryItem['name'] ) ){
                                       if( $value->term_id == $categoryItem['parent'] ){
                                          echo esc_attr("selected");
                                       }
                                    }  
                                    ?>><?php echo esc_html($value->name); ?></option> <?php
                                    
                                 }
                              }
                              unset( $catList );
                           ?>
                        </select>
                        <?php printf("<p>%s</p>",__("Categories, unlike tags, can have a hierarchy. You might have a Jazz category, and under that have children categories for Bebop and Big Band. Totally optional.","project-cost-calculator" ));  ?> 
                     </div>
                     <div class="pro_rate_cal_form_fields term-description-wrap">
                        <label for="category-description"><?php esc_html_e( "Description" ,"project-cost-calculator" ); ?></label>
                        <textarea name="description" id="category-description" rows="5" cols="40"><?php
                           if( !empty( $categoryItem['description'] ) ){
                              echo esc_html($categoryItem['description']);
                           }  
                        ?></textarea>
                        <?php printf( "<p>%s</p>", __("The description is not prominent by default; however, some themes may show it.","project-cost-calculator" ) );  ?> 
                     </div>
                     <div class="pro_rate_cal_form_fields_submit">
                        <input type="submit" name="submit" id="submit" class="rate_cal_button rate_cal_button_primary" title="<?php echo esc_attr($submitBtn); ?>" value="<?php echo esc_attr($submitBtn); ?>"> <span class="spinner"></span>
                     </div>
                  </form>
               </div>   
            </div>   
         </div> 
         <div class="pro_rate-cal_col_12 pro_rate-cal_col_lg_8">
            <div class="pro_rate-cal_card">
               <div class="pro_rate-cal_card_header">
                  <h4><?php esc_html_e( "All Categories", "project-cost-calculator" ); ?></h4>
               </div>   
               <div class="pro_rate-cal_card-body">
               <form id="posts-filter" method="post">
                  <input type="hidden" name="taxonomy" value="category">
                  <input type="hidden" name="post_type" value="post">
                  <input type="hidden" id="_wpnonce" name="_wpnonce" value="d8be18f5bf"><input type="hidden" name="_wp_http_referer" value="/wp-admin/edit-tags.php?taxonomy=category">   
                  <h2 class="screen-reader-text"><?php esc_html_e( "Categories list", "project-cost-calculator" ); ?></h2>
                  <table id="pro_rate_category_page">
                     <thead>
                        <tr>
                           <th scope="col" id="name"><?php esc_html_e( "Name", "project-cost-calculator"); ?></th>
                           <th scope="col" id="description"><?php esc_html_e( "Description", "project-cost-calculator" ); ?></th>
                        </tr>
                     </thead>
                     <tbody id="the-list" data-wp-lists="list:tag">
                           <?php $this -> render_category_list(); ?>
                     </tbody>
                  </table>
               </form>
               </div>   
            </div>  
         </div>   
      </div>   
   </div>   
</div>
      <!-- New Desig End -->