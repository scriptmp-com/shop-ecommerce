<?php
defined('ABSPATH') or die();

if (get_option('nasatheme_imported') !== 'imported') :
    /**
     * Required Plugins
     */
    $required_plugins = elessi_list_required_plugins();
    if (!function_exists('get_plugins')) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }

    $keys = array_keys(get_plugins());
    if (!empty($keys)) {
        foreach ($required_plugins as $k => $plugin) {
            $file_path = $plugin['slug'];
            foreach ($keys as $key) {
                if (preg_match('|^' . $plugin['slug'] . '/|', $key)) {
                    $file_path = $key;
                    break;
                }
            }

            if (is_plugin_active($file_path)) {
                unset($required_plugins[$k]);
            }
        }
    }
    ?>
    <div class="nasa-dashboard-demo-data">
        <h1 class="demo-data-heading">
            <img class="nasa-logo" src="<?php echo ELESSI_THEME_URI; ?>/assets/images/logo.png" alt="Logo" />
        </h1>
        
        <p><?php echo esc_html__("This wizard will set up your theme, install plugins, import content. It is optional & should take only a few minutes.", 'elessi-theme'); ?></p>

        <?php
        if (!empty($required_plugins)) :
            echo '<div class="recommend-plugins">';
            
            echo '<p class="plugin-list-notice">' . esc_html__('Step 1: Install Plugins', 'elessi-theme') . '</p>';
            
            echo '<p class="plugin-note">' . esc_html__("Let's install some essential WordPress plugins to set up your site.", 'elessi-theme') . '</p>';
            
            $builder_array = array('elementor', 'js_composer');
            
            foreach ($required_plugins as $plugin) :
                
                if (isset($plugin['auto']) && $plugin['auto']) :
                    $required = isset($plugin['required']) && $plugin['required'] ? true : false;
                    $class = 'recommend-plugin';
                    $class .= $required ? ' required-plugin' : '';
                    $class .= !$required && isset($plugin['unchecked']) && $plugin['unchecked'] ? '' : ' selected';
                    $class .= in_array($plugin['slug'], $builder_array) ? ' builder-plugin' : '';
                    
                    echo '<a href="javascript:void(0);" class="' . $class . '" data-slug="' . $plugin['slug'] . '" data-name="' . esc_attr($plugin['name']) . '">';
                    
                    echo $plugin['name'];
                    
                    echo $required ? '<span class="require-text">' . esc_html__('Required', 'elessi-theme') . '</span>' : '<span class="require-text">' . esc_html__('Recommended', 'elessi-theme') . '</span>';
                    
                    echo '</a>';
                endif;
                
            endforeach;
            
            echo '<a href="javascript:void(0);" class="confirm-selected-plugins nasa-disabled">' . esc_html__('CONTINUE', 'elessi-theme') . '</a>';
            
            echo '</div>';
        endif;
        ?>
        <div class="main-demo-data">
            <h1 class="demo-data-heading small runing-hide">
                <?php esc_html_e('Step 2: Choose Homepage Layout', 'elessi-theme'); ?>
            </h1>
            
            <p class="main-demo-data-notice"><?php echo esc_html__("Let's choose the homepage layout that you want to use on your website and click on the Start Import button.", 'elessi-theme'); ?></p>
            
            <p class="main-demo-data-notice color-gray"><?php echo esc_html__("Note: Images at demo are not included in the download package and they are replaced with placeholders in demo data.", 'elessi-theme'); ?></p>
            
            <a class="button button-hero nasa-back-step" href="javascript:void(0);"><?php echo esc_html__('BACK TO STEP 1', 'elessi-theme'); ?></a>
            
            <a class="button button-primary button-hero nasa-select-all" href="javascript:void(0);"><?php echo esc_html__('SELECT ALL HOMEPAGES', 'elessi-theme'); ?></a>
            
            <a class="button button-primary button-hero nasa-start-import" href="javascript:void(0);" data-permalink-option="<?php echo esc_url(admin_url('options-permalink.php')); ?>"><?php echo esc_html__('START IMPORT SAMPLE DATA', 'elessi-theme'); ?></a>

            <div class="nasa-select-homepage">
                <ul class="nasa-tabs-heading">
                    <li class="tab-heading-js_composer">
                        <a href="javascript:void(0);" class="nasa-tab-heading" data-target=".demo-homepages-wpb">
                            <?php echo esc_html__('WPBakery - Homes List', 'elessi-theme'); ?>
                        </a>
                    </li>

                    <li class="tab-heading-elementor">
                        <a href="javascript:void(0);" class="nasa-tab-heading" data-target=".demo-homepages-elm">
                            <?php echo esc_html__('Elementor - Homes List', 'elessi-theme'); ?>
                        </a>
                    </li>
                </ul>

                <div class="nasa-tabs-panel">
                    
                    <!-- Panel WPBakery -->
                    <div class="demo-homepages-wrap demo-homepages-wpb nasa-tab-content tab-content-js_composer">
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="fashion-1" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/fashion-1.jpg" alt="Fashion v1" />
                                </div>
                                
                                <h4 class="home-title">Fashion <sup>v1</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="fashion-2" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/fashion-2.jpg" alt="Fashion v2" />
                                </div>
                                
                                <h4 class="home-title">Fashion <sup>v2</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="fashion-3" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/fashion-3.jpg" alt="Fashion v3" />
                                </div>
                                
                                <h4 class="home-title">Fashion <sup>v3</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="fashion-4" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/fashion-4.jpg" alt="Fashion v4" />
                                </div>
                                
                                <h4 class="home-title">Fashion <sup>v4</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="fashion-5" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/fashion-5.jpg" alt="Fashion v5" />
                                </div>
                                
                                <h4 class="home-title">Fashion <sup>v5</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="fashion-6" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/fashion-6.jpg" alt="Fashion v6" />
                                </div>
                                
                                <h4 class="home-title">Fashion <sup>v6</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="fashion-7" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/fashion-7.jpg" alt="Fashion v7" />
                                </div>
                                
                                <h4 class="home-title">Fashion <sup>v7</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="fashion-8" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/fashion-8.jpg" alt="Fashion v8" />
                                </div>
                                
                                <h4 class="home-title">Fashion <sup>v8</sup></h4>
                            </a>
                        </div>
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="digital-1" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/digital-1.jpg" alt="Digital v1" />
                                </div>
                                
                                <h4 class="home-title">Digital <sup>v1</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="digital-2" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/digital-2.jpg" alt="Digital v2" />
                                </div>
                                
                                <h4 class="home-title">Digital <sup>v2</sup></h4>
                                
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="accessories-1" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/accessories.jpg" alt="Accessories v1" />
                                </div>
                                
                                <h4 class="home-title">Accessories <sup>v1</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="accessories-2" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/accessories-v2.jpg" alt="Accessories v2" />
                                </div>
                                
                                <h4 class="home-title">Accessories <sup>v2</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="accessories-3" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/accessories-v3.jpg" alt="Accessories v3" />
                                </div>
                                
                                <h4 class="home-title">Accessories <sup>v3</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="baby" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/baby.jpg" alt="Baby" />
                                </div>
                                
                                <h4 class="home-title">Baby</h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="bag" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/bag.jpg" alt="Bag" />
                                </div>
                                
                                <h4 class="home-title">Bag</h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="bike" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/bike.jpg" alt="Bike" />
                                </div>

                                <h4 class="home-title">Bike</h4>
                            </a>
                            
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="cosmetic" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/cosmetic.jpg" alt="Cosmetic" />
                                </div>

                                <h4 class="home-title">Cosmetic</h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="face-mask" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/face-mask.jpg" alt="Face Mask" />
                                </div>

                                <h4 class="home-title">Face Mask</h4>
                            </a>
                        </div>
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="furniture" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/furniture.jpg" alt="Furniture" />
                                </div>

                                <h4 class="home-title">Furniture</h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="jewelry" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/jewelry.jpg" alt="Jewelry" />
                                </div>

                                <h4 class="home-title">Jewelry</h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="organic-1" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/organic.jpg" alt="Organic v1" />
                                </div>

                                <h4 class="home-title">Organic <sup>v1</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="organic-2" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/organic-2.jpg" alt="Organic v2" />
                                </div>

                                <h4 class="home-title">Organic <sup>v2</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="organic-3" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/organic-3.jpg" alt="Organic v3" />
                                </div>

                                <h4 class="home-title">Organic <sup>v3</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="organic-4" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/organic-4.jpg" alt="Organic v4" />
                                </div>

                                <h4 class="home-title">Organic <sup>v4</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="organic-5" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/organic-5.jpg" alt="Organic v5" />
                                </div>

                                <h4 class="home-title">Organic <sup>v5</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="organic-farm" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/organic-farm.jpg" alt="Organic farm" />
                                </div>

                                <h4 class="home-title">Organic Farm</h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="retail" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/retail.jpg" alt="Retail" />
                                </div>

                                <h4 class="home-title">Retail</h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="shoes" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/shoes.jpg" alt="Shoes" />
                                </div>

                                <h4 class="home-title">Shoes</h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="t-shirt" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/t-shirt.jpg" alt="T-shirt" />
                                </div>

                                <h4 class="home-title">T-shirt</h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="christmas" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/christmas.jpg" alt="Christmas" />
                                </div>

                                <h4 class="home-title">Christmas</h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="pet-accessories" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/pet-accessories.jpg" alt="Pet Accessories" />
                                </div>

                                <h4 class="home-title">Pet Accessories</h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="watch" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/watch.jpg" alt="Watch" />
                                </div>

                                <h4 class="home-title">Watch</h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="watch-dark" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/watch-dark.jpg" alt="Watch Dark" />
                                </div>

                                <h4 class="home-title">Watch Dark</h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="auto-parts-1" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/auto-part-v1.jpg" alt="Auto Parts v1" />
                                </div>

                                <h4 class="home-title">Auto Parts <sup>v1</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="auto-parts-2" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/auto-part-v2.jpg" alt="Auto Parts v2" />
                                </div>

                                <h4 class="home-title">Auto Parts <sup>v2</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="auto-parts-3" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/auto-part-v3.jpg" alt="Auto Parts v3" />
                                </div>

                                <h4 class="home-title">Auto Parts <sup>v3</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="medical-1" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/medical-1.jpg" alt="Medical v1" />
                                </div>

                                <h4 class="home-title">Medical <sup>v1</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="medical-2" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/medical-2.jpg" alt="Medical v2" />
                                </div>

                                <h4 class="home-title">Medical <sup>v2</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="pharmacy" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/pharmacy.jpg" alt="Pharmacy" />
                                </div>

                                <h4 class="home-title">Pharmacy</h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="plant-1" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/plant-1.jpg" alt="Plant v1" />
                                </div>

                                <h4 class="home-title">Plant <sup>v1</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="plant-2" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/plant-2.jpg" alt="Plant v2" />
                                </div>

                                <h4 class="home-title">Plant <sup>v2</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="plant-3" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/plant-3.jpg" alt="Plant v3" />
                                </div>

                                <h4 class="home-title">Plant <sup>v3</sup></h4>
                            </a>
                        </div>
                    </div>

                    <!-- Panel Elementor -->
                    <div class="demo-homepages-wrap demo-homepages-elm nasa-tab-content tab-content-elementor">
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="fashion-1" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/fashion-1.jpg" alt="Fashion v1" />
                                </div>

                                <h4 class="home-title">Fashion <sup>v1</sup></h4>
                            </a>
                        </div>

                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="fashion-2" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/fashion-2.jpg" alt="Fashion v2" />
                                </div>

                                <h4 class="home-title">Fashion <sup>v2</sup></h4>
                            </a>
                        </div>

                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="fashion-3" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/fashion-3.jpg" alt="Fashion v3" />
                                </div>

                                <h4 class="home-title">Fashion <sup>v3</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="fashion-4" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/fashion-4.jpg" alt="Fashion v4" />
                                </div>

                                <h4 class="home-title">Fashion <sup>v4</sup></h4>
                            </a>
                        </div>

                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="fashion-5" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/fashion-5.jpg" alt="Fashion v5" />
                                </div>

                                <h4 class="home-title">Fashion <sup>v5</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="fashion-6" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/fashion-6.jpg" alt="Fashion v6" />
                                </div>

                                <h4 class="home-title">Fashion <sup>v6</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="fashion-8" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/fashion-8.jpg" alt="Fashion v8" />
                                </div>

                                <h4 class="home-title">Fashion <sup>v8</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="digital-1" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/digital-1.jpg" alt="Digital v1" />
                                </div>

                                <h4 class="home-title">Digital <sup>v1</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="digital-2" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/digital-2.jpg" alt="Digital v2" />
                                </div>

                                <h4 class="home-title">Digital <sup>v2</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="accessories-1" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/accessories.jpg" alt="Accessories v1" />
                                </div>

                                <h4 class="home-title">Accessories <sup>v1</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="accessories-2" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/accessories-v2.jpg" alt="Accessories v2" />
                                </div>
                                
                                <h4 class="home-title">Accessories <sup>v2</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="accessories-3" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/accessories-v3.jpg" alt="Accessories v3" />
                                </div>
                                
                                <h4 class="home-title">Accessories <sup>v3</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="baby" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/baby.jpg" alt="Baby" />
                                </div>

                                <h4 class="home-title">Baby</h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="bag" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/bag.jpg" alt="Bag" />
                                </div>

                                <h4 class="home-title">Bag</h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="bike" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/bike.jpg" alt="Bike" />
                                </div>

                                <h4 class="home-title">Bike</h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="cosmetic" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/cosmetic.jpg" alt="Cosmetic" />
                                </div>

                                <h4 class="home-title">Cosmetic</h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="face-mask" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/face-mask.jpg" alt="Face Mask" />
                                </div>

                                <h4 class="home-title">Face Mask</h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="furniture" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/furniture.jpg" alt="Furniture" />
                                </div>

                                <h4 class="home-title">Furniture</h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="jewelry" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/jewelry.jpg" alt="Jewelry" />
                                </div>

                                <h4 class="home-title">Jewelry</h4>
                            </a>
                        </div>

                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="organic-1" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/organic.jpg" alt="Organic v1" />
                                </div>

                                <h4 class="home-title">Organic <sup>v1</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="organic-2" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/organic-2.jpg" alt="Organic v2" />
                                </div>

                                <h4 class="home-title">Organic <sup>v2</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="organic-3" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/organic-3.jpg" alt="Organic v3" />
                                </div>

                                <h4 class="home-title">Organic <sup>v3</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="organic-4" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/organic-4.jpg" alt="Organic v4" />
                                </div>

                                <h4 class="home-title">Organic <sup>v4</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="organic-5" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/organic-5.jpg" alt="Organic v5" />
                                </div>

                                <h4 class="home-title">Organic <sup>v5</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="organic-farm" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/organic-farm.jpg" alt="Organic farm" />
                                </div>

                                <h4 class="home-title">Organic Farm</h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="retail" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/retail.jpg" alt="Retail" />
                                </div>

                                <h4 class="home-title">Retail</h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="shoes" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/shoes.jpg" alt="Shoes" />
                                </div>

                                <h4 class="home-title">Shoes</h4>
                            </a>
                        </div>

                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="t-shirt" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/t-shirt.jpg" alt="T-shirt" />
                                </div>

                                <h4 class="home-title">T-shirt</h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="christmas" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/christmas.jpg" alt="Christmas" />
                                </div>

                                <h4 class="home-title">Christmas</h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="pet-accessories" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/pet-accessories.jpg" alt="Pet Accessories" />
                                </div>

                                <h4 class="home-title">Pet Accessories</h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="watch" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/watch.jpg" alt="Watch" />
                                </div>

                                <h4 class="home-title">Watch</h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="watch-dark" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/watch-dark.jpg" alt="Watch Dark" />
                                </div>

                                <h4 class="home-title">Watch Dark</h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="auto-parts-1" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/auto-part-v1.jpg" alt="Auto Parts v1" />
                                </div>

                                <h4 class="home-title">Auto Parts <sup>v1</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="auto-parts-2" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/auto-part-v2.jpg" alt="Auto Parts v2" />
                                </div>

                                <h4 class="home-title">Auto Parts <sup>v2</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="auto-parts-3" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/auto-part-v3.jpg" alt="Auto Parts v3" />
                                </div>

                                <h4 class="home-title">Auto Parts <sup>v3</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="medical-1" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/medical-1.jpg" alt="Medical v1" />
                                </div>

                                <h4 class="home-title">Medical <sup>v1</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="medical-2" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/medical-2.jpg" alt="Medical v2" />
                                </div>

                                <h4 class="home-title">Medical <sup>v2</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="pharmacy" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/pharmacy.jpg" alt="Pharmacy" />
                                </div>

                                <h4 class="home-title">Pharmacy</h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="plant-1" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/plant-1.jpg" alt="Plant v1" />
                                </div>

                                <h4 class="home-title">Plant <sup>v1</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="plant-2" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/plant-2.jpg" alt="Plant v2" />
                                </div>

                                <h4 class="home-title">Plant <sup>v2</sup></h4>
                            </a>
                        </div>
                        
                        <div class="demo-homepage-item-wrap">
                            <a href="javascript:void(0);" data-home="plant-3" class="demo-homepage-item">
                                <div class="img-wrap">
                                    <img src="<?php echo ELESSI_THEME_URI; ?>/admin/assets/pages/plant-3.jpg" alt="Plant v3" />
                                </div>

                                <h4 class="home-title">Plant <sup>v3</sup></h4>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="processing-demo-data">
                <h1 class="demo-data-heading small">
                    <?php esc_html_e('Step 3: Import Content', 'elessi-theme'); ?>
                </h1>
                <p class="processing-notice-first"><?php echo esc_html__('Please waiting in a few minutes, The process is running...', 'elessi-theme'); ?></p>

                <div class="process-bar-loading"><div class="process-bar-finished"></div></div>
                
                <ul class="processing-steps">
                    <li class="step processing-install-child-theme step-first" data-step="1">
                        <?php echo esc_html__('Install Elessi Theme - Child', 'elessi-theme'); ?>
                    </li>
                    <li class="step processing-data" data-step="2">
                        <?php echo esc_html__('Install Plugins', 'elessi-theme'); ?>
                        <ul class="plugins-installed" data-url_manual="<?php echo esc_url(admin_url('themes.php?page=install-required-plugins')); ?>" data-text_error="<?php echo esc_attr__('Opp! please try to install the plugins here', 'elessi-theme'); ?>"></ul>
                    </li>
                    <li class="step processing-data" data-step="3">
                        <?php echo esc_html__('Import Data (Media, Posts, Products, Categories...)', 'elessi-theme'); ?> - <span class="statistic-data">0/25</span>
                    </li>
                    <li class="step processing-widgets" data-step="4">
                        <?php echo esc_html__('Import Widgets Sidebars', 'elessi-theme'); ?>
                    </li>
                    <li class="step processing-homepage" data-step="5">
                        <?php echo esc_html__('Import Homes', 'elessi-theme'); ?> - <span class="statistic-homes"></span>
                    </li>
                    <li class="step processing-revsliders" data-step="6">
                        <?php echo esc_html__('Import Sliders', 'elessi-theme'); ?>
                    </li>
                    <li class="step processing-theme-options step-end" data-step="7">
                        <?php echo esc_html__('Setup Theme Options', 'elessi-theme'); ?>
                    </li>
                </ul>
                
                <p class="processing-notice-last nasa-bold">
                    <?php echo esc_html__("All Done. Have fun!", 'elessi-theme'); ?>
                </p>
                
                <p class="processing-notice-last">
                    <?php echo esc_html__("Your theme has been all setup. Enjoy your new theme.", 'elessi-theme'); ?>
                </p>
                
                <p class="processing-notice-last">
                    <a class="button button-primary button-hero button-complete" href="<?php echo esc_url(admin_url('admin.php?page=wc-status&tab=tools')); ?>"><?php echo esc_html__('WooCommerce Tools', 'elessi-theme'); ?></a>
                    <a class="button button-primary button-hero button-complete" href="<?php echo esc_url(admin_url('themes.php?page=optionsframework')); ?>"><?php echo esc_html__('Go to Theme Options', 'elessi-theme'); ?></a>
                    <a class="button button-primary button-hero button-complete" href="<?php echo esc_url(home_url('/')); ?>" target="_blank"><?php echo esc_html__('View your website', 'elessi-theme'); ?></a>
                </p>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="nasa-dashboard-demo-data">
        <h1 class="demo-data-heading">
            <img class="nasa-logo" src="<?php echo ELESSI_THEME_URI; ?>/assets/images/logo.png" alt="Logo" />
        </h1>
        
        <p class="processing-notice-last nasa-bold nasa-block">
            <?php echo esc_html__("All Done. Have fun!", 'elessi-theme'); ?>
        </p>

        <p class="processing-notice-last nasa-block">
            <?php echo esc_html__("Your theme has been all setup. Enjoy your new theme.", 'elessi-theme'); ?><br />
            <?php echo esc_html__("Demo data was imported. If you want import demo data again, You should need reset data of your site.", 'elessi-theme'); ?>
        </p>

        <p class="processing-notice-last nasa-block">
            <a class="button button-primary button-hero" href="<?php echo esc_url(home_url('/')); ?>" target="_blank"><?php echo esc_html__('View your website', 'elessi-theme'); ?></a>
        </p>
    </div>
<?php
endif;
