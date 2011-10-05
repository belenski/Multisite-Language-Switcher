<?php

/**
 * Custom Column
 *
 * @package Msls
 */

require_once dirname( __FILE__ ) . '/MslsMain.php';
require_once dirname( __FILE__ ) . '/MslsOptions.php';
require_once dirname( __FILE__ ) . '/MslsLink.php';

class MslsCustomColumn extends MslsMain implements IMslsMain {

    static function init() {
        global $post_type;
        $options = MslsOptions::instance();
        if ( !$options->is_excluded() ) {
            $obj = new self();
            if ( 'page' == $post_type ) {
                add_filter( 'manage_pages_columns', array( $obj, 'th' ) );
                add_action( 'manage_pages_custom_column', array( $obj, 'td' ), 10, 2 );
            }
            else { 
                add_filter( 'manage_posts_columns', array( $obj, 'th' ) );
                add_action( 'manage_posts_custom_column', array( $obj, 'td' ), 10, 2 );
            }
        }
    }

    protected function get_type() {
        global $post;
        return $post->post_type;
    }

    public function th( $columns ) {
        global $post;
        $blogs = $this->blogs->get();
        if ( $blogs ) {
            $arr = array();
            foreach ( $blogs as $blog ) {
                $language = $blog->get_language();
                $icon     = new MslsAdminIcon( null );
                $icon->set_language( $language );
                $icon->set_src( $this->get_flag_url( $language, true ) );
                $arr[] = $icon->get_img();
            }
            $columns['mslscol'] = implode( '&nbsp;', $arr );
        }
        return $columns;
    }

    public function td( $column_name, $post_id ) {
        $this->columns( $column_name, $post_id );
    }

    protected function columns( $column_name, $item_id ) {
        global $post;
        if ( 'mslscol' == $column_name ) {
            $blogs = $this->blogs->get();
            if ( $blogs ) {
                $type = $this->get_type();
                $mydata = MslsOptionsFactory::create( $type, $item_id );
                foreach ( $blogs as $blog ) {
                    switch_to_blog( $blog->userblog_id );
                    $language  = $blog->get_language();
                    $edit_link = MslsAdminIcon::create( $type );
                    $edit_link->set_language( $language );
                    if ( $mydata->has_value( $language ) ) {
                        $edit_link->set_src( $this->get_url( 'images' ) . '/link_edit.png' );
                        $edit_link->set_href( $mydata->$language );
                    }
                    else {
                        $edit_link->set_src( $this->get_url( 'images' ) . '/link_add.png' );
                    }
                    echo $edit_link;
                    restore_current_blog();
                }
            }
        }
    }

}

class MslsCustomColumnTaxonomy extends MslsCustomColumn {

    static function init() {
        $options = MslsOptions::instance();
        if ( !$options->is_excluded() ) {
            $obj    = new self();
            $screen = get_current_screen();
            add_filter( 'manage_{$screen->id}_custom_column' , array( $obj, 'th' ) );
            add_action( 'manage_{$taxonomy}_custom_column' , array( $obj, 'td' ), 10, 2 );
        }
    }

    protected function get_type() {
        $screen = get_current_screen();
        return $screen->taxonomy;
    }

    public function td( $deprecated, $column_name, $term_id ) {
        $this->columns( $column_name, $term_id );
    }

}

?>
