<?php
   // This will cause a notice if debug mode is enabled
   $undefined_variable;
   
   // This will show debug information
   echo "<pre>";
   echo "WP_DEBUG: " . (defined('WP_DEBUG') && WP_DEBUG ? 'Enabled' : 'Disabled');
   echo "</pre>";