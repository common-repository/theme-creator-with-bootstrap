<?php
if (!defined("ABSPATH")) {
	die;
}

include "layouts/TC4B_generate_layout1.php";
include "layouts/TC4B_generate_layout2.php";
include "layouts/TC4B_generate_layout3.php";
include "layouts/TC4B_generate_layout4.php";
include "layouts/TC4B_generate_layout5.php";
include "layouts/TC4B_generate_layout6.php";

class TC4B_Admin_Page{
	
    private static $instance = null;

	public static function get_instance() {
		if (self::$instance == null) 
			self::$instance = new self;
		
		return self::$instance;
	}
    
    const ICON = "data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMWVtIiBoZWlnaHQ9IjFlbSIgdmlld0JveD0iMCAwIDE2IDE2IiBjbGFzcz0iYmkgYmktYm9vdHN0cmFwIiBmaWxsPSJjdXJyZW50Q29sb3IiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+DQogIDxwYXRoIGZpbGwtcnVsZT0iZXZlbm9kZCIgZD0iTTEyIDFINGEzIDMgMCAwIDAtMyAzdjhhMyAzIDAgMCAwIDMgM2g4YTMgMyAwIDAgMCAzLTNWNGEzIDMgMCAwIDAtMy0zek00IDBhNCA0IDAgMCAwLTQgNHY4YTQgNCAwIDAgMCA0IDRoOGE0IDQgMCAwIDAgNC00VjRhNCA0IDAgMCAwLTQtNEg0eiIvPg0KICA8cGF0aCBmaWxsLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik04LjUzNyAxMkg1LjA2MlYzLjU0NWgzLjM5OWMxLjU4NyAwIDIuNTQzLjgwOSAyLjU0MyAyLjExIDAgLjg4NC0uNjUgMS42NzUtMS40ODMgMS44MTZ2LjFjMS4xNDMuMTE3IDEuOTA0LjkzMSAxLjkwNCAyLjAzMyAwIDEuNDg4LTEuMDg0IDIuMzk2LTIuODg4IDIuMzk2ek02LjM3NSA0LjY1OHYyLjQ2N2gxLjU1OGMxLjE2IDAgMS43NjQtLjQyOCAxLjc2NC0xLjIzIDAtLjc4LS41NjktMS4yMzctMS41NDEtMS4yMzdINi4zNzV6bTEuODk4IDYuMjI5SDYuMzc1VjguMTYyaDEuODIyYzEuMjM2IDAgMS44ODcuNDYzIDEuODg3IDEuMzQ4IDAgLjg5Ni0uNjI3IDEuMzc3LTEuODExIDEuMzc3eiIvPg0KPC9zdmc+";
	
    const DEFAULT_LAYOUT_OPTION = "";
    const DEFAULT_PAGE_OPTION = "";
    const DEFAULT_THEME_NAME = "Bootstrap Theme";
    
    private function __construct() {
    	add_action("admin_init", [$this,"register_mysettings"]);
		add_action("admin_enqueue_scripts", [$this, "enqueue_scripts"]);
      	add_action("admin_menu", [$this, "create_menu"]);
	}
    
    public function register_mysettings(){
    	if (!isset($_POST["layout_option"])) {
        	$_POST["layout_option"] = self::DEFAULT_LAYOUT_OPTION;
      	}
     
		if (!isset($_POST["page_option"])) {
			$_POST["page_option"] = self::DEFAULT_PAGE_OPTION;
	  	}

	  	if (!isset($_POST["theme_name"])) {
			$_POST["theme_name"] = self::DEFAULT_THEME_NAME;
	  	}
    }
    
    public function enqueue_scripts() {
		wp_enqueue_style("TC4B_admin-page-style", TC4B_URL."admin/css/style.css");
	}
    
    public function get_valid_dir($dir){ 
        $basedir = dirname(__DIR__, 3);
        $dir_other = $dir;
        $n = 1;
        while(is_dir($basedir. '/themes/'.$dir_other.'')){
            $dir_other = $dir.'_'.$n;
            $n += 1;
        }
        return $dir_other;
    }
    
    
    private function manage_settings(){

      //All Sanitizations
		$page_option = sanitize_text_field($_POST["page_option"]);
		$layout_option = sanitize_text_field($_POST["layout_option"]);
		$name = sanitize_text_field($_POST["theme_name"]);
		if(empty($name))
			$name = self::DEFAULT_THEME_NAME;    
		$tmp = str_replace(' ', '_', $name);
		$dir = sanitize_file_name($tmp);
		$dir = $this->get_valid_dir($dir);

      //Validation of inputs and call of each theme generator
		if($page_option == 'page1' or $page_option == 'page2' or $page_option == 'page3'){
    	
    		if($layout_option == 'layout1'){
          		TC4B_generate_layout1( $name , $dir, $page_option);
				?>
          		<div class='updated notice'>
    			<p>The Bootstrap Theme: <b><?php echo esc_attr($name);?></b> has been created successfully.<br> It uses 3 Columns layout.</p>
				</div>
				<?php
        	}

			else if($layout_option == 'layout2'){
				TC4B_generate_layout2( $name , $dir, $page_option);
				?>
				<div class='updated notice'>
				<p>The Bootstrap Theme: <b><?php echo esc_attr($name);?></b> has been created successfully.<br> It uses 2 Columns layout.</p>
				</div>
				<?php
			}

			else if($layout_option == 'layout3'){
				TC4B_generate_layout3( $name ,$dir , $page_option );
				?>
				<div class='updated notice'>
				<p>The Bootstrap Theme: <b><?php echo esc_attr($name);?></b> has been created successfully.<br> It uses 2:1 layout.</p>
				</div>
				<?php          
			}

			else if($layout_option == 'layout4'){
				TC4B_generate_layout4( $name , $dir , $page_option );
				?>
				<div class='updated notice'>
				<p>The Bootstrap Theme: <b><?php echo esc_attr($name);?></b> has been created successfully.<br> It uses Side Widgets layout.</p>
				</div>
				<?php     
			}

			else if($layout_option == 'layout5'){
				TC4B_generate_layout5( $name , $dir , $page_option );
				?>
				<div class='updated notice'>
				<p>The Bootstrap Theme: <b><?php echo esc_attr($name);?></b> has been created successfully.<br> It uses 1:2 layout.</p>
				</div>
				<?php     
			}

			else if($layout_option == 'layout6'){
				TC4B_generate_layout6( $name , $dir , $page_option );
				?>
				<div class='updated notice'>
				<p>The Bootstrap Theme: <b><?php echo esc_attr($name);?></b> has been created successfully.<br> It uses Masonry layout.</p>
				</div>
				<?php     
			}

			else{
				add_settings_error(
					"layout_option",
					"layout-option-error",
					"Unvalid choice of Layout");
			}
    	}

		else{
			add_settings_error(
				"page_option",
				"page-option-error",
				"Unvalid choice of Page");
		}
    }
    
	public function create_menu() {
		add_menu_page(
			"Bootstrap | Getting Started",
			"Bootstrap Themes",
			"manage_options",
			"bootstrap-start",
			[$this, "display_menu_start"],
			self::ICON
		);	

		add_submenu_page(
			"bootstrap-start",
			"Bootstrap | Getting Started",
			"Getting Started",
			"manage_options",
			"bootstrap-start"
		);		  

		add_submenu_page(
			"bootstrap-start",
			"Bootstrap | Create Theme",
			"Create Theme",
			"edit_posts",
			"bootstrap-create",
			[$this, "display_menu_create"]
		);
	}
	
    public function display_menu_create() {
		if (!current_user_can("manage_options")) {
			wp_die("You do not have sufficient permissions to access this page.");
		}
		?>
       	<div class='wrap'>

          <?php 
          $this->manage_settings(); 
          settings_errors(); 
          ?>
        

          <h1>Theme Creator for Bootstrap | Create Theme</h1>
          <form method='POST' action=''>
          
            <div class='frontpage_choice'>
            <h2> Select Frontpage Layout</h2>
          	  <div class='option'>
                <figure>
                  <img class='responsive-image' src='<?php echo esc_url(TC4B_URL.'/images/1option.png'); ?>' alt=''/>
                </figure>
                <p class='caption'>3 Columns</p>
                <label class='switch'>
                  <input type='radio' name='layout_option' value='layout1' <?php echo esc_attr((($_POST["layout_option"]=='layout1') ? "checked='checked'" : "")); ?> >
                  <span class='slider round'></span>
                </label>
              </div>
              
              <div class='option'>
				        <figure>
                  <img class='responsive-image' src='<?php echo esc_url(TC4B_URL.'/images/2option.png'); ?>' alt=''/>
                </figure>
                <p class='caption'>2 Columns</p>
                <label class='switch'>
                  <input type='radio' name='layout_option' value='layout2' <?php echo esc_attr((($_POST["layout_option"]=='layout2') ? "checked='checked'" : "")); ?> >
                  <span class='slider round'></span>
                </label>
              </div>
              
              <div class='option'>
                <figure>
                  <img class='responsive-image' src='<?php echo esc_url(TC4B_URL.'/images/3option.png'); ?>' alt=''/>
                </figure>
                <p class='caption'>2:1 Layout</p>
                <label class='switch'>
                  <input type='radio' name='layout_option' value='layout3' <?php echo esc_attr((($_POST["layout_option"]=='layout3') ? "checked='checked'" : "")); ?> >
                  <span class='slider round'></span>
                </label>
              </div>
             
              <div class='option'>
                <figure>
                  <img class='responsive-image' src='<?php echo esc_url(TC4B_URL.'/images/4option.png'); ?>' alt=''/>
                </figure>
                <p class='caption'>Side Widgets</p>
                <label class='switch'>
                  <input type='radio' name='layout_option' value='layout4' <?php echo esc_attr((($_POST["layout_option"]=='layout4') ? "checked='checked'" : "")); ?> >
                  <span class='slider round'></span>
                </label>
              </div>
              
              <div class='option'>
                <figure>
                  <img class='responsive-image' src='<?php echo esc_url(TC4B_URL.'/images/5option.png'); ?>' alt=''/>
                </figure>
                <p class='caption'>1:2 Layout</p>
                <label class='switch'>
                  <input type='radio' name='layout_option' value='layout5' <?php echo esc_attr((($_POST["layout_option"]=='layout5') ? "checked='checked'" : "")); ?> >
                  <span class='slider round'></span>
                </label>
              </div>
              
              <div class='option'>
                <figure>
                  <img class='responsive-image' src='<?php echo esc_url(TC4B_URL.'/images/6option.png'); ?>' alt=''/>
                </figure>
                <p class='caption'>Masonry</p>
                <label class='switch'>
                  <input type='radio' name='layout_option' value='layout6' <?php echo esc_attr((($_POST["layout_option"]=='layout6') ? "checked='checked'" : "")); ?> >
                  <span class='slider round'></span>
                </label>
              </div>
      </div>
              
      <div class='page_choice'>
      <h2> Select Page Layout </h2>
              <div class='option'>
              	<figure>
                  <img class='responsive-image' src='<?php echo esc_url(TC4B_URL.'/images/page1.png'); ?>' alt=''/>
                </figure>
                <p class='caption'>Right Aside</p>
                <label class='switch'>
                  <input type='radio' name='page_option' value='page1' <?php echo esc_attr((($_POST["page_option"]=='page1') ? "checked='checked'" : "")); ?> >
                  <span class='slider round'></span>
                </label>
              </div>
              
              <div class='option'>
              	<figure>
                  <img class='responsive-image' src='<?php echo esc_url(TC4B_URL.'/images/page2.png'); ?>' alt=''/>
                </figure>
                <p class='caption'>Left Aside</p>
                <label class='switch'>
                  <input type='radio' name='page_option' value='page2' <?php echo esc_attr((($_POST["page_option"]=='page2') ? "checked='checked'" : "")); ?> >
                  <span class='slider round'></span>
                </label>
              </div>
              
              <div class='option'>
              	<figure>
                  <img class='responsive-image' src='<?php echo esc_url(TC4B_URL.'/images/page3.png'); ?>' alt=''/>
                </figure>
                <p class='caption'>Standard</p>
                <label class='switch'>
                  <input type='radio' name='page_option' value='page3' <?php echo esc_attr((($_POST["page_option"]=='page3') ? "checked='checked'" : "")); ?> >
                  <span class='slider round'></span>
                </label>
              </div>
      </div>
              
      <div class='theme_choice'>          
      <h2> Select Theme Name</h2>
              <div>
              	<input type='text' name='theme_name' value='<?php echo esc_attr($_POST["theme_name"]) ?>' placeholder=''>
              </div>
             
              <?php submit_button("Create Theme"); ?>
          </form>
         </div>
<?php
     }


    public function display_menu_start() {
      if (!current_user_can("edit_posts")) {
        wp_die("You do not have sufficient permissions to access this page.");
      }
?>
      <div class='wrap' id="get-started">
        <h1>Theme Creator for Bootstrap | Getting Started </h1>
        
      	<p>Theme Creator for Bootstrap allows you to create your own Wordpress theme created with Bootstrap,
        you can choose between many layouts, colors and more. As It's created using Bootstrap, your theme will be complitely <b>responsive</b>: it will always adapt to the device, offering the best user experience in every situation. </p>

        <h3>Prerequirements</h3>
        <p> Make sure your WordPress folder <i>'/wp-content/themes'</i> is writable, as the Plugin will create a new directory containing all theme files. Check <a href='https://wordpress.org/support/article/changing-file-permissions/' target='_blank'>this</a> for further informations.</p>
        
        <div>
          <h3> Create your first theme</h3>
          <p> Creating your personal theme will be super-easy with our plugin, all you need to do is chosing the layout
          you prefer for the Front Page and for the Page, select a theme name and that's all!</p>

          <div class='container'>
              <div class='tutorial-fig'>
              	<p><b>1)</b> Go to Create Theme Section </p>
                <img class='' src='<?php echo esc_url(TC4B_URL.'/images/Tutorial/tutorial1.png'); ?>' alt=''/>
        	    </div>
              <div class='tutorial-fig'>
              	<p><b>2)</b> Choose Frontpage Layout </p>
                <img class='' src='<?php echo esc_url(TC4B_URL.'/images/Tutorial/tutorial2.png'); ?>' alt=''/>
              </div>
              <div class='tutorial-fig'>
              	<p><b>3)</b> Choose Page Layout</p>
                <img class='' src='<?php echo esc_url(TC4B_URL.'/images/Tutorial/tutorial3.png'); ?>' alt=''/>
              </div>
              <div class='tutorial-fig'>
              	<p><b>4)</b> Choose Theme Name and Create your Bootstrap Theme </p>
              	<img class='' src='<?php echo esc_url(TC4B_URL.'/images/Tutorial/tutorial4.png'); ?>' alt=''/>
        	     </div>
        	</div>
          
          <div class='tutorial-end'>
            	<p><b>At the top of the page</b> you can check if everything went fine with the creation of the theme.</p>
            	<img class='' src='<?php echo esc_url(TC4B_URL.'/images/Tutorial/tutorial5.png'); ?>' alt=''/>
        	</div>
          
          <div class='tutorial-end'>
              <p>You will find <b>your new theme</b> in Wordpress Themes section.</p>
              <img class='' src='<?php echo esc_url(TC4B_URL.'/images/Tutorial/tutorial6.png'); ?>' alt=''/>
        	</div>
        </div>

        <div>
	        <h3>More customization</h3>
	      	<p>Once you created your theme you can further customize it in the theme section.<br>
	        You can for example change layout colors, add more informations, and for more experienced users: add your additional .css. </p>
	        
	        <div class='tutorial-end'>
	            	<p><b>Select the theme</b> you've created.</p>
	            	<img class='' src='<?php echo esc_url(TC4B_URL.'/images/Tutorial/tutorial7.png'); ?>' alt=''/>
	        </div>
	        
	        <div class='tutorial-end'>
	            	<p>Use the <b>left menu options</b> to customize your site.</p>
	            	<img class='' src='<?php echo esc_url(TC4B_URL.'/images/Tutorial/tutorial8.png'); ?>' alt=''/>
	      	</div>
	    </div>
        
        <div>
	        <h3> Tips </h3>
	        <p> The layout isn't the only thing that a web user notices, <b>colors</b> of your UI and <b>fonts</b> are important as well.<br>
	       	The best colors schemes can be find in <a href='https://material.io/resources/color/' target='_blank'>Google Material</a>, it will help you with the choice of colors, also thinking about accessibility (high contrast schemes). <br>
	        Once you find a nice scheme you can apply it just using the theme customization options. <br>
	        The best fonts can be easily applied with the Wordpress plugin <a href='https://wordpress.org/plugins/olympus-google-fonts/' target='_blank'>Fonts Plugin | Google Fonts Typography</a> directly to your theme.
	        </p>
	    </div>
        
      </div>
      
      <i>Enjoy - Theme Creator for Bootstrap </i>
<?php
    }

}

TC4B_Admin_Page::get_instance();

?>
