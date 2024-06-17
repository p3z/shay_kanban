<?php
$nav_title = "Add new kanban board";
require_once('partials/header.php');
    //require_once('partials/left_sidebar.php');
?>
<div class="row">
    <div class="col-12 mb-xl-0 mb-4">
                
                <form class="pws-hide user-profile-form" role="form" method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>"  >
                  <div class="card">
                    <div class="card-header p-3 pt-2">
                      
                       <?php wp_nonce_field('skb_create_new_kanban', 'token', false); ?>
                       <input type="hidden" name="action" value="create_new_kanban">
                                
                        <div class="row">
                            <div class="col-6">
                                <div class="input-group input-group-outline">
                                    <label class="form-label" for="kanban_name">Kanban board name</label>
                                    <input class="form-control" type="text" name="kanban_name" id="kanban_name" value="">
                                </div>
                                
                            </div>
                            
                            <div class="col-6">
                                <div class="input-group input-group-outline">
                                        <label class="form-label" for="num_cols">Number of starting columns</label>
                                        <input class="js-num_cols form-control " type="number" step="1" min="1" max="30" name="num_cols" id="num_cols">
                                </div>
                            </div>
                        </div>
                      
                    </div><!-- card-header -->
                    
                    <div class="row">
                        
                        <div class="col-12">
                            <div class="input-group input-group-outline">
                                <div class="js-column-name-container">
                                    <input class="form-control" type="text" value="To do list" name="column_title_1">
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="row">
                        
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Create new kanban board</button>
                        </div>
                    </div>
                    
                        
                  </div><!-- card -->
                </form>
            
            </div><!-- col -->
</div><!-- row -->
      
<?php
    require_once('partials/footer.php');
?>

<script>

    document.addEventListener("DOMContentLoaded", () => {
        
        let column_qty_input = document.querySelector('.js-num_cols');
        let container = document.querySelector('.js-column-name-container');
        
        column_qty_input.onchange = (e) => {
            
            let num_cols = e.currentTarget.value;
            
            container.innerHTML = ""; // Reset the container
            let new_row = PwsHtmlBuilder.create_elements("div", ["row"])[0];
            container.append(new_row)
            
            for(let i = 1; i <= num_cols; i++){
                
                let new_col = PwsHtmlBuilder.create_elements("div", ["col-12"])[0];
                
                    let new_input = PwsHtmlBuilder.create_elements("input", ['form-control'])[0];
                    let first_few_placeholders = [
                        'To do list',
                        'Important',
                        'In progress',
                        'Complete'
                    ];
                    
                    let attr_map = {
                        "type": "text",
                        "name": `column_title_${i}`,
                        "value": first_few_placeholders[i] ?? `Column ${i}`
                    }
                    PwsHtmlBuilder.set_attributes( new_input, attr_map );
                    
                    new_col.appendChild(new_input)
                new_row.appendChild(new_col)
                
            } //end loop
            
           
            
        }// end change handler
    });
    //
</script>