<tr id="tag-<?php echo esc_html( $category['term_id'] ); ?>" class="level-<?php echo esc_html($category['parent']); ?>">
    <td class="name column-name has-row-actions column-primary" data-colname="Name">
        <strong>
            <a class="row-title" href="<?php echo  esc_url(self::get_category_page_url( array(
                "action" => "edit",
                "id" => $category['term_id']
            ) ) ) ; ?>" aria-label="“<?php echo esc_attr($category['name']); ?>” (<?php esc_attr_e("Edit", "project-cost-calculator"); ?>)"><?php echo  esc_html($this->get_category_level( $category['parent'] )." ".$category['name']); ?></a>
        </strong>
        <div class="row-actions">
            <span class="edit">
                <a href="<?php echo esc_url(self::get_category_page_url( array(
                "action" => "edit",
                "id" => $category['term_id']
                ) ) ) ; ?>" aria-label="Edit"><?php esc_attr_e("Edit", "project-cost-calculator"); ?></a>
            </span>
            <?php  if( $category["parent"] != 0 ){ ?>
            | <span class="delete"><a href="<?php echo esc_url(self::get_category_page_url( array(
                "action" => "delete",
                "id" => $category['term_id']
            ) ) ); ?>" class="delete-tag aria-button-if-js" role="button"><?php esc_attr_e("Delete", "project-cost-calculator"); ?></a></span>
            <?php } ?>
        </div>
    </td>
    <td class="description column-description" data-colname="Description"><?php echo esc_html($category['description']); ?>
    </td>
</tr>