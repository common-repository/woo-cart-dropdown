<?php
   /*
   Plugin Name: WooCommerce Cart Dropdown
   Plugin URI: 
   description: Adds WooCommerce cart + dropdown to any menu
   Version: 1.0
   Author: WP Distillery
   Author URI: https://wp-distillery.com
   License: GPL2
   */

add_action( 'admin_menu', 'wcd_add_admin_menu' );
add_action( 'admin_init', 'wcd_settings_init' );

  $iconArray = array(
    "1" => array(
      "type" => "material",
      "code" => "shopping_cart"
    ),    
    "2" => array(
      "type" => "material",
      "code" => "shopping_basket"
    ),    
    "3" => array(
      "type" => "font-awesome",
      "code" => "fas fa-shopping-cart"
    ),
    "4" => array(
      "type" => "font-awesome",
      "code" => "fas fa-shopping-basket"
    ),    
    "5" => array(
      "type" => "font-awesome",
      "code" => "fas fa-shopping-bag"
    ),    
    "6" => array(
      "type" => "ionic",
      "code" => "ion-bag"
    ),    
    "7" => array(
      "type" => "ionic",
      "code" => "ion-ios-cart"
    ),    
    "8" => array(
      "type" => "ionic",
      "code" => "ion-ios-cart-outline"
    ),    
    "9" => array(
      "type" => "foundation",
      "code" => "fi-shopping-cart"
    ),    
    "10" => array(
      "type" => "foundation",
      "code" => "fi-shopping-bag"
    )

  );


function wcd_add_admin_menu(  ) { 

  add_submenu_page( 'woocommerce', 'Cart Dropdown', 'Cart Dropdown', 'manage_options', 'woocommerce_cart_dropdown', 'wcd_options_page' );

}



function wcd_enqueue_styles(){
  wp_register_style( 'wcd-styles', plugins_url( '/assets/css/woocommerce-cart-dropdown.css', __FILE__ ), array(), '', 'all' );
  wp_enqueue_style( 'wcd-styles' );  

  wp_register_style( 'wcd-font-awesome', '//use.fontawesome.com/releases/v5.0.9/css/all.css', array(), '', 'all' );
  wp_enqueue_style( 'wcd-font-awesome' );  

  wp_register_style( 'wcd-ion-fonts', '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css', array(), '', 'all' );
  wp_enqueue_style( 'wcd-ion-fonts' );  

  wp_register_style( 'wcd-foundation-icons', plugins_url( '/assets/css/fonts/foundation-icons.css', __FILE__ ), array(), '', 'all' );
  wp_enqueue_style( 'wcd-foundation-icons' );
}


function wcd_settings_init(  ) { 

  wcd_enqueue_styles();

  register_setting( 'wcdSettingsPage', 'wcd_settings' );

  add_settings_section(
    'wcd_wcdSettingsPage_section', 
    __( 'Plugin settings', 'wordpress' ), 
    'wcd_settings_section_callback', 
    'wcdSettingsPage'
  );

  add_settings_field( 
    'wcd_display_in_menus', 
    __( 'Display cart in the following menus', 'wordpress' ), 
    'wcd_display_in_menus_render', 
    'wcdSettingsPage', 
    'wcd_wcdSettingsPage_section' 
  );



  add_settings_field( 
    'wcd_cart_position', 
    __( 'Cart Position', 'wordpress' ), 
    'wcd_cart_position_render', 
    'wcdSettingsPage', 
    'wcd_wcdSettingsPage_section' 
  );

  add_settings_field( 
    'wcd_display_mode', 
    __( 'Display mode', 'wordpress' ), 
    'wcd_display_mode_render', 
    'wcdSettingsPage', 
    'wcd_wcdSettingsPage_section' 
  );  

  add_settings_field( 
    'wcd_cart_icon', 
    __( 'Cart Icon', 'wordpress' ), 
    'wcd_cart_icon_render', 
    'wcdSettingsPage', 
    'wcd_wcdSettingsPage_section' 
  );  

  add_settings_field( 
    'wcd_item_text', 
    __( 'Item text', 'wordpress' ), 
    'wcd_item_text_render', 
    'wcdSettingsPage', 
    'wcd_wcdSettingsPage_section' 
  );  

  add_settings_field( 
    'wcd_item_text_seperator', 
    __( 'Item text seperator', 'wordpress' ), 
    'wcd_item_text_seperator_render', 
    'wcdSettingsPage', 
    'wcd_wcdSettingsPage_section' 
  );


    add_settings_field( 
    'wcd_cart_contents_dropdown', 
    __( 'Enable dropdown displaying cart contents', 'wordpress' ), 
    'wcd_cart_contents_dropdown_render', 
    'wcdSettingsPage', 
    'wcd_wcdSettingsPage_section' 
  );
  


    add_settings_field( 
    'wcd_display_cart_if_not_empty', 
    __( 'Only display cart if not empty', 'wordpress' ), 
    'wcd_display_cart_if_not_empty_render', 
    'wcdSettingsPage', 
    'wcd_wcdSettingsPage_section' 
  );


}

function wcd_default_settings() {
    $wcd_options = get_option('wcd_settings');

    $default = array(
      'wcd_display_cart_if_not_empty' => '0',
      'wcd_display_mode'  => array(
        'icon' => isset($wcd_options['wcd_display_mode']['icon']) ? $wcd_options['wcd_display_mode']['icon']:'1',
        'counter' => isset($wcd_options['wcd_display_mode']['counter']) ? $wcd_options['wcd_display_mode']['counter']:'1',
        'text' => isset($wcd_options['wcd_display_mode']['text']) ? $wcd_options['wcd_display_mode']['text']:'0',
        'seperator' => isset($wcd_options['wcd_display_mode']['seperator']) ? $wcd_options['wcd_display_mode']['seperator']:'1',
        'total' => isset($wcd_options['wcd_display_mode']['total']) ? $wcd_options['wcd_display_mode']['total']:'1'
      ),
      'wcd_item_text'    => isset($wcd_options['wcd_item_text']) ? $wcd_options['wcd_item_text']:'items',
      'wcd_item_text_seperator'   => isset($wcd_options['wcd_item_text_seperator']) ? $wcd_options['wcd_item_text_seperator']:'-',
      'wcd_cart_contents_dropdown' => isset($wcd_options['wcd_cart_contents_dropdown']) ? $wcd_options['wcd_cart_contents_dropdown']:'1',
      'wcd_cart_icon'    => isset($wcd_options['wcd_cart_icon']) ? $wcd_options['wcd_cart_icon']:'3',
      'wcd_cart_position'  => isset($wcd_options['wcd_cart_position']) ? $wcd_options['wcd_cart_position']:'last'
    );

    update_option( 'wcd_settings', $default );
  }
register_activation_hook( __FILE__, 'wcd_default_settings' );


function wcd_display_in_menus_render(  ) { 

  $options = get_option( 'wcd_settings' );
  $nav_menus = wp_get_nav_menus();
  
  foreach ( (array) $nav_menus as $_nav_menu ) : ?>
          <label><?php echo esc_html( $_nav_menu->name ); ?></label>
          
          
          <input name="wcd_settings[wcd_display_in_menus][<?php echo esc_attr( $_nav_menu->slug ); ?>]" type="checkbox" <?php checked( $options['wcd_display_in_menus'][ $_nav_menu->slug ], $_nav_menu->slug ); ?> value="<?php echo esc_attr( $_nav_menu->slug ); ?>" />
          

          
        <?php endforeach; ?>

  <?php

}


function wcd_display_cart_if_not_empty_render(  ) { 

  $options = get_option( 'wcd_settings' );
  ?>
  <input type='checkbox' name='wcd_settings[wcd_display_cart_if_not_empty]' <?php checked( $options['wcd_display_cart_if_not_empty'], 1 ); ?> value='1'>
  <?php

}


function wcd_display_mode_render(  ) { 

  $options = get_option( 'wcd_settings' );
  $displayModes = array('icon', 'counter', 'text', 'seperator', 'total');
  
  foreach($displayModes as $displayMode){ ?>
  <label><?php echo $displayMode; ?></label>
  <input type='checkbox' name='wcd_settings[wcd_display_mode][<?php echo $displayMode; ?>]' <?php checked( $options['wcd_display_mode'][$displayMode], 1 ); ?> value='1'>
  <?php } // end foreach

  echo '<p class="description">Remember to empty or update the cart to see these changes.</p>';

}


function wcd_cart_contents_dropdown_render(  ) { 

  $options = get_option( 'wcd_settings' );
  ?>
  <input type='checkbox' name='wcd_settings[wcd_cart_contents_dropdown]' <?php checked( $options['wcd_cart_contents_dropdown'], 1 ); ?> value='1'>
  <?php

}


function wcd_cart_icon_render(  ) { 

  $options = get_option( 'wcd_settings' );
  $icons = array();

  // material design
  // <i class="material-icons">shopping_cart</i>
  ?>
  <div class="wcd-icon-control">
    <i class="material-icons">shopping_cart</i>
    <input type='radio' name='wcd_settings[wcd_cart_icon]' <?php checked( $options['wcd_cart_icon'], '1' ); ?> value='1'>
  </div>
  <div class="wcd-icon-control">
    <i class="material-icons">shopping_basket</i>
    <input type='radio' name='wcd_settings[wcd_cart_icon]' <?php checked( $options['wcd_cart_icon'], '2' ); ?> value='2'>
  </div>
  <div class="wcd-icon-control">
    <i class="fas fa-shopping-cart"></i>
    <input type='radio' name='wcd_settings[wcd_cart_icon]' <?php checked( $options['wcd_cart_icon'], '3' ); ?> value='3'>
  </div>
  <div class="wcd-icon-control">
    <i class="fas fa-shopping-basket"></i>
    <input type='radio' name='wcd_settings[wcd_cart_icon]' <?php checked( $options['wcd_cart_icon'], '4' ); ?> value='4'>
  </div>
  <div class="wcd-icon-control">
    <i class="fas fa-shopping-bag"></i>
    <input type='radio' name='wcd_settings[wcd_cart_icon]' <?php checked( $options['wcd_cart_icon'], '5' ); ?> value='5'>  
  </div>
  <div class="wcd-icon-control">
    <i class="ion-bag"></i>
    <input type='radio' name='wcd_settings[wcd_cart_icon]' <?php checked( $options['wcd_cart_icon'], '6' ); ?> value='6'>
  </div>  
  <div class="wcd-icon-control">
    <i class="ion-ios-cart"></i>
    <input type='radio' name='wcd_settings[wcd_cart_icon]' <?php checked( $options['wcd_cart_icon'], '7' ); ?> value='7'> 
  </div> 
  <div class="wcd-icon-control">
    <i class="ion-ios-cart-outline"></i>
    <input type='radio' name='wcd_settings[wcd_cart_icon]' <?php checked( $options['wcd_cart_icon'], '8' ); ?> value='8'>  
  </div>
  <div class="wcd-icon-control">
    <i class="fi-shopping-cart"></i>
    <input type='radio' name='wcd_settings[wcd_cart_icon]' <?php checked( $options['wcd_cart_icon'], '9' ); ?> value='9'>  
  </div>
  <div class="wcd-icon-control">
    <i class="fi-shopping-bag"></i>
    <input type='radio' name='wcd_settings[wcd_cart_icon]' <?php checked( $options['wcd_cart_icon'], '10' ); ?> value='10'>
  </div>
  <?php

}
function wcd_cart_position_render() { 

  $options = get_option( 'wcd_settings' );

  // material design
  // <i class="material-icons">shopping_cart</i>
  ?>
  <label>Left</label>
  <input type='radio' name='wcd_settings[wcd_cart_position]' <?php checked( $options['wcd_cart_position'], 'left' ); ?> value='left'>
  <label>First</label>
  <input type='radio' name='wcd_settings[wcd_cart_position]' <?php checked( $options['wcd_cart_position'], 'first' ); ?> value='first'>  
  <label>Last</label>
  <input type='radio' name='wcd_settings[wcd_cart_position]' <?php checked( $options['wcd_cart_position'], 'last' ); ?> value='last'>
  <label>Right</label>
  <input type='radio' name='wcd_settings[wcd_cart_position]' <?php checked( $options['wcd_cart_position'], 'right' ); ?> value='right'>
  <?php

}

function wcd_item_text_render() { 

  $options = get_option( 'wcd_settings' );
  ?>
  
  <input type='text' name='wcd_settings[wcd_item_text]' value="<?php echo $options['wcd_item_text']; ?>" placeholder="Displayed after counter">
  <?php

}

function wcd_item_text_seperator_render() { 

  $options = get_option( 'wcd_settings' );
  ?>
  
  <input type='text' name='wcd_settings[wcd_item_text_seperator]' value="<?php echo $options['wcd_item_text_seperator']; ?>" placeholder="-">
  <?php

}


function wcd_settings_section_callback(  ) { 

  // echo __( 'This section description', 'wordpress' );

}


function wcd_options_page(  ) { 

  ?>
  <form action='options.php' method='post' id="wcd-editor-wrapper">

    <h2>WooCommerce Cart Dropdown</h2>

    <?php
    settings_fields( 'wcdSettingsPage' );
    do_settings_sections( 'wcdSettingsPage' );
    submit_button();
    ?>

  </form>
  <?php

}


function wcd_line_items(){ 
  global $iconArray;
  $productCount = WC()->cart->get_cart_contents_count();
  $filled = '';
  $options = get_option( 'wcd_settings' );

  if($options['wcd_display_cart_if_not_empty'] > 0){
    $filled .= 'only-if-not-empty ';
  }

  if($productCount > 0){ $filled .= 'heavy'; } 

  $content = '';

  $content .= '<a class="cart-contents '. $filled .'" href="'. esc_url( wc_get_cart_url() ) .'">';
  if($options['wcd_display_mode']['icon'] && $options['wcd_cart_icon']){
    $icon = $options['wcd_cart_icon'];
    $iconDetails = $iconArray[$icon];

    // Material icons
    if($iconDetails['type'] == 'material'){
      $content .= '<i class="icon material-icons">'. $iconDetails['code'] .'</i>';
    }    

    // Font awesome icons
    if($iconDetails['type'] == 'font-awesome'){
      $content .= '<i class="icon '. $iconDetails['code'] .'"></i>';
    }

    // Ionic icons
    if($iconDetails['type'] == 'ionic'){
      $content .= '<i class="icon '. $iconDetails['code'] .'"></i>';
    }

    // Foundation icons
    if($iconDetails['type'] == 'foundation'){
      $content .= '<i class="icon '. $iconDetails['code'] .'"></i>';
    }
  }
  if($options['wcd_display_mode']['counter']){
    $content .= '<span class="count">'. wp_kses_data( sprintf( _n( '%d', '%d', WC()->cart->get_cart_contents_count()), WC()->cart->get_cart_contents_count() ) ) .'</span>';
  }
  if($options['wcd_display_mode']['text']){
    $content .= '<span class="text"> '. $options['wcd_item_text'] .'</span>';
  }  
  if($options['wcd_display_mode']['seperator']){
    $content .= '<span class="seperator"> '. $options['wcd_item_text_seperator'] .' </span>';
  }
  if($options['wcd_display_mode']['total']){
    $content .= '<span class="amount">'. wp_kses_data( WC()->cart->get_cart_subtotal() ) .'</span>';
  }  
  $content .= '</a>';

  return $content;
}

function wcd_line_items_output(){ 
  global $iconArray;
  $productCount = WC()->cart->get_cart_contents_count();
  $filled = '';
  $options = get_option( 'wcd_settings' );

  if($options['wcd_display_cart_if_not_empty'] > 0){
    $filled .= 'only-if-not-empty ';
  }

  if($productCount > 0){ $filled .= 'heavy'; } 

  $content = '';

  $content .= '<a class="cart-contents '. $filled .'" href="'. esc_url( wc_get_cart_url() ) .'">';
  if($options['wcd_display_mode']['icon'] && $options['wcd_cart_icon']){
    $icon = $options['wcd_cart_icon'];
    $iconDetails = $iconArray[$icon];

    // Material icons
    if($iconDetails['type'] == 'material'){
      $content .= '<i class="icon material-icons">'. $iconDetails['code'] .'</i>';
    }    

    // Font awesome icons
    if($iconDetails['type'] == 'font-awesome'){
      $content .= '<i class="icon '. $iconDetails['code'] .'"></i>';
    }

    // Ionic icons
    if($iconDetails['type'] == 'ionic'){
      $content .= '<i class="icon '. $iconDetails['code'] .'"></i>';
    }

    // Foundation icons
    if($iconDetails['type'] == 'foundation'){
      $content .= '<i class="icon '. $iconDetails['code'] .'"></i>';
    }
  }
  if($options['wcd_display_mode']['counter']){
    $content .= '<span class="count">'. wp_kses_data( sprintf( _n( '%d', '%d', WC()->cart->get_cart_contents_count()), WC()->cart->get_cart_contents_count() ) ) .'</span>';
  }
  if($options['wcd_display_mode']['text']){
    $content .= '<span class="text"> '. $options['wcd_item_text'] .'</span>';
  }  
  if($options['wcd_display_mode']['seperator']){
    $content .= '<span class="seperator"> '. $options['wcd_item_text_seperator'] .' </span>';
  }
  if($options['wcd_display_mode']['total']){
    $content .= '<span class="amount">'. wp_kses_data( WC()->cart->get_cart_subtotal() ) .'</span>';
  }  
  $content .= '</a>';

  echo $content;
}

function wcd_add_cart_to_menus(){
  $options = get_option( 'wcd_settings' );
  $activeMenus = $options['wcd_display_in_menus'];

  if(!empty($activeMenus)){
    foreach($activeMenus as $activeMenu){
      add_filter('wp_nav_menu_'. $activeMenu .'_items', 'wcd_add_cart_link', 1, 2);
    }
  }
}

function wcd_add_cart_link($items, $args){ 

  $options = get_option( 'wcd_settings' );
  $cartPosition = $options['wcd_cart_position'];

  $classes = '';

  if($cartPosition == 'left'){
    $classes = 'wcd-before';
  } else if($cartPosition == 'right'){
    $classes = 'wcd-after';
  }

      $wcdItem = '<li class="'. $classes .'">' . wcd_cart_link() . '</li>';
      $reconstructedItemList = '';

        if($cartPosition == 'left' || $cartPosition == 'first'){
          $reconstructedItemList .= $wcdItem;
          $reconstructedItemList .= $items;
        } else {
          $reconstructedItemList .= $items;
          $reconstructedItemList .= $wcdItem;
        }

  return $reconstructedItemList;

}

add_action( 'init', 'wcd_add_cart_to_menus' );

function wcd_cart_link(){ 

  $options = get_option( 'wcd_settings' );
  $output = '';
  $widgetOutput = '';

  // get output of cart widget
  ob_start();
    eval(the_widget( 'WC_Widget_Cart' ));
    $widgetOutput = ob_get_contents();
  ob_end_clean();

  $output .= '<div class="wcd-wrapper">'. wcd_line_items();
  if($options['wcd_cart_contents_dropdown'] == true){
    $output .= '<div class="dropdown-cart-wrapper"><h4 class="heading">Your Shopping Bag</h4>'. $widgetOutput .'</div>';
  }
  $output .= '</div>';

  return $output;
}

function wcd_cart_link_fragment( $fragments ) {
    
    global $woocommerce;

    ob_start(); 
    wcd_line_items_output();    
    $fragments['a.cart-contents'] = ob_get_clean();

    return $fragments;
    

    // calling wcd_line_items instead
  }

function wcd_enqueue_styles_front(){
  global $iconArray;

  wp_register_script( 'wcd-js', plugins_url( '/assets/js/wcd.js', __FILE__ ), array( 'jquery' ) );
  wp_enqueue_script( 'wcd-js' );

  wp_register_style( 'wcd-styles', plugins_url( '/assets/css/woocommerce-cart-dropdown.css', __FILE__ ), array(), '', 'all' );
  wp_enqueue_style( 'wcd-styles' ); 

  $options = get_option( 'wcd_settings' );
  $icon = $options['wcd_cart_icon'];
    $iconDetails = $iconArray[$icon];

    // font awesome icons
    if($iconDetails['type'] == 'font-awesome'){
      wp_register_style( 'wcd-font-awesome', '//use.fontawesome.com/releases/v5.0.9/css/all.css', array(), '', 'all' );
      wp_enqueue_style( 'wcd-font-awesome' ); 
    }

    // ionic icons
    if($iconDetails['type'] == 'ionic'){
      wp_register_style( 'wcd-ion-fonts', '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css', array(), '', 'all' );
      wp_enqueue_style( 'wcd-ion-fonts' ); 
    }

    // foundation icons
    if($iconDetails['type'] == 'foundation'){
      wp_register_style( 'wcd-foundation-icons', plugins_url( '/assets/css/fonts/foundation-icons.css', __FILE__ ), array(), '', 'all' );
      wp_enqueue_style( 'wcd-foundation-icons' );
    }
 
}  

add_action('template_redirect', 'wcd_enqueue_styles_front'); 

add_action( 'wp_footer', 'wcd_enqueue_styles_front' );

add_filter( 'woocommerce_add_to_cart_fragments', 'wcd_cart_link_fragment' );

function wcd_settings_link( $links ) {
    $settings_link = '<a href="admin.php?page=woocommerce_cart_dropdown">'. __( 'Settings', 'woocommerce' ) . '</a>';
    array_push( $links, $settings_link );
    return $links;
}

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'wcd_settings_link' );

