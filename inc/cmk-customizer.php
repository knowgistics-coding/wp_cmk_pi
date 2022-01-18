<?php

// ===== MastHead =====
$wp_customize->add_panel('pi_masthead', array(
  'title' => '[Phra.in] MastHead',
  'priority' => 30,
));
// ----- Main -----
$wp_customize->add_section('pi_masthead_main', array(
  'title' => 'Main',
  'priority' => 10,
  'panel' => 'pi_masthead',
));
$wp_customize->add_setting('masthead_bg',array('default'=>'#5BBFDD'));
$wp_customize->add_control('masthead_bg',array(
  'label'   => 'Background Color',
  'section' => 'pi_masthead_main',
  'type'    => 'color',
));
$wp_customize->add_setting('masthead_color',array('default'=>'#FFFFFF'));
$wp_customize->add_control('masthead_color',array(
  'label'   => 'Font Color',
  'section' => 'pi_masthead_main',
  'type'    => 'color',
));
$wp_customize->add_setting('masthead_border_color',array('default'=>'#DDDDDD'));
$wp_customize->add_control('masthead_border_color',array(
  'label'   => 'Border Color',
  'section' => 'pi_masthead_main',
  'type'    => 'color',
));
$wp_customize->add_setting('masthead_border_width',array('default'=>'1'));
$wp_customize->add_control('masthead_border_width',array(
  'label'   => 'Border Width',
  'section' => 'pi_masthead_main',
  'type'    => 'number',
));
// ----- Site Branding -----
$wp_customize->add_section('pi_masthead_site_branding', array(
  'title' => 'Site Branding',
  'priority' => 30,
  'panel' => 'pi_masthead',
));
$wp_customize->add_setting('site_branding_width',array('default'=>'120'));
$wp_customize->add_control('site_branding_width',array(
  'label'   => 'Site Branding Width (PC)',
  'section' => 'pi_masthead_site_branding',
  'type'    => 'number',
));
$wp_customize->add_setting('masthead_bgimage', array(
  'transport' => 'refresh',
  'height' => 325,
));
$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,'masthead_bgimage',array(
  'label' => 'Site Branding Image (PC)',
  'section' => 'pi_masthead_site_branding',
  'settings' => 'masthead_bgimage',    
)));
$wp_customize->add_setting('site_branding_width_mb',array('default'=>'120'));
$wp_customize->add_control('site_branding_width_mb',array(
  'label'   => 'Site Branding Width (Mobile)',
  'section' => 'pi_masthead_site_branding',
  'type'    => 'number',
));
$wp_customize->add_setting('masthead_bgimage_mb', array(
  'transport' => 'refresh',
  'height' => 325,
));
$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,'masthead_bgimage_mb',array(
  'label' => 'Site Branding Image (Mobile)',
  'section' => 'pi_masthead_site_branding',
  'settings' => 'masthead_bgimage_mb',    
)));
// ----- Menu -----
$wp_customize->add_section('pi_masthead_menu', array(
  'title' => 'Menu',
  'priority' => 10,
  'panel' => 'pi_masthead',
));
$wp_customize->add_setting('masthead_menu_color',array('default'=>'#333333'));
$wp_customize->add_control('masthead_menu_color',array(
  'label'   => 'Menu Color',
  'section' => 'pi_masthead_menu',
  'type'    => 'color',
));

// ===== ColoPhon =====
$wp_customize->add_panel('pi_colophon', array(
  'title' => '[Phra.in] ColoPhon',
  'priority' => 30,
));
// ----- Main -----
$wp_customize->add_section('pi_colophon_main', array(
  'title' => 'Main',
  'priority' => 30,
  'panel' => 'pi_colophon',
));
$wp_customize->add_setting('colophon_bg',array('default'=>'#333333'));
$wp_customize->add_control('colophon_bg',array(
  'label'   => 'Footer Background Color',
  'section' => 'pi_colophon_main',
  'type'    => 'color',
));
$wp_customize->add_setting('colophon_color',array('default'=>'#FFFFFF'));
$wp_customize->add_control('colophon_color',array(
  'label'   => 'Footer Font Color',
  'section' => 'pi_colophon_main',
  'type'    => 'color',
));
$wp_customize->add_setting('colophon_justify',array('default'=>'center'));
$wp_customize->add_control('colophon_justify',array(
  'label'   => 'Justify Content',
  'section' => 'pi_colophon_main',
  'type'    => 'select',
  'choices'  => array(
    "flex-start" => "flex-start",
    "flex-end" => "flex-end",
    "center" => "center",
    "space-between" => "space-between",
    "space-around" => "space-around",
  ),
));

// ===== Content =====
$wp_customize->add_panel('pi_content', array(
  'title' => '[Phra.in] Content',
  'priority' => 30,
));
// ----- Main -----
$wp_customize->add_section('pi_content_main', array(
  'title' => 'Main',
  'priority' => 30,
  'panel' => 'pi_content',
));
$wp_customize->add_setting('cover_brightness',array('default'=>70));
$wp_customize->add_control('cover_brightness',array(
  'label'   => 'Cover Brightness',
  'section' => 'pi_content_main',
  'type'    => 'number',
  'input_attrs' => array(
    "min" => 0,
    "max" => 100,
  ),
));
$wp_customize->add_setting('comment_display',array('default'=>true));
$wp_customize->add_control('comment_display',array(
  'label'   => 'Comment Display',
  'section' => 'pi_content_main',
  'type'    => 'checkbox',
));

// ===== Facebook =====
$wp_customize->add_section('fb_msg_setting', array(
  'title' => '[Phra.in] Facebook Messenger',
  'priority' => 20,
));
$wp_customize->add_setting('fb_app_id',array('default'=>''));
$wp_customize->add_control('fb_app_id',array(
  'label'   => 'App ID',
  'section' => 'fb_msg_setting',
  'type'    => 'text',
));
$wp_customize->add_setting('fb_msg_head',array('default'=>''));
$wp_customize->add_control('fb_msg_head',array(
  'label'   => 'Script',
  'section' => 'fb_msg_setting',
  'type'    => 'textarea',
));

// ===== Other =====
$wp_customize->add_section('other_setting', array(
  'title' => '[Phra.in] Other',
  'priority' => 30,
));
$wp_customize->add_setting('toggle_category',array('default'=>true));
$wp_customize->add_control('toggle_category',array(
  'label'   => 'Show Category',
  'section' => 'other_setting',
  'type'    => 'checkbox',
));
$wp_customize->add_setting('hilight_color',array('default'=>'#007bff'));
$wp_customize->add_control('hilight_color',array(
  'label'   => 'Hilight Color',
  'section' => 'other_setting',
  'type'    => 'color',
));