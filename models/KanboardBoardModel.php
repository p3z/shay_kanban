<?php

class KanbanBoardModel{
    
    public static function get_user_boards( $qty = -1, $status = "publish" ){
        
        $args = array(
            'post_type' => 'shay-kanban-boards',
            'post_status' => $status,
            'posts_per_page' => $qty
            // 'meta_key' => 'admin_status',
            // 'meta_value' => $admin_status
        );
        
        return get_posts($args);
        
    }// end fn
    
} // end class
    
?>