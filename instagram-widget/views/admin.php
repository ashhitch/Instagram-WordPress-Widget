 <p><label for="<?php echo $this->get_field_id('userID'); ?>">User ID: <input class="widefat" id="<?php echo $this->get_field_id('userID'); ?>" name="<?php echo $this->get_field_name('userID'); ?>" type="text" value="<?php echo esc_attr($userID); ?>" /></label></p>

  <p><label for="<?php echo $this->get_field_id('clientID'); ?>">Client ID: <input class="widefat" id="<?php echo $this->get_field_id('clientID'); ?>" name="<?php echo $this->get_field_name('clientID'); ?>" type="text" value="<?php echo esc_attr($clientID); ?>" /></label></p>
  
  <p><label for="<?php echo $this->get_field_id('accessToken'); ?>">Access Token: <input class="widefat" id="<?php echo $this->get_field_id('accessToken'); ?>" name="<?php echo $this->get_field_name('accessToken'); ?>" type="text" value="<?php echo esc_attr($accessToken); ?>" /></label></p>
  
    <p><label for="<?php echo $this->get_field_id('limit'); ?>">Limit: <select class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>">
      <?php  
      for ($i = 1;$i < 11;$i++) 
    { 
    	
    	$selected = ( esc_attr($limit) == $i) ? ' selected="selected"': '';  	
        echo '<option value="'.$i.'"'.$selected .'>'.$i.'</option>'; 
    } 
    ?>  
    </select>
    </label></p>
