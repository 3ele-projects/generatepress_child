<?php
/**
 * GeneratePress child theme functions and definitions.
 *
 * Add your custom PHP in this file. 
 * Only edit this file if you have direct access to it on your server (to fix errors if they happen).
 */

function generatepress_child_enqueue_scripts() {
	if ( is_rtl() ) {
		wp_enqueue_style( 'generatepress-rtl', trailingslashit( get_template_directory_uri() ) . 'rtl.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'generatepress_child_enqueue_scripts', 100 );

// Lesezeit anzeigen
function theme_slug_reading_time( $post = null, $wpm = 275 ) {

    // Get content and clean it.
    $content = get_post_field( 'post_content', $post );
    $content = strip_tags( strip_shortcodes( $content ) );

    // Get word count.
    $word_count = str_word_count( $content );

    // Calculate reading time.
    $reading_time = ceil( $word_count / $wpm );

    return sprintf( esc_html__( 'Vorraussichtliche Lesezeit: %s min', 'theme-slug' ), $reading_time );
}

// Automatisches Löschen des Autoptimize-Cache, wenn er über 128 MB kommt.
if (class_exists('autoptimizeCache')) {
    $myMaxSize = 128000; # Du kannst diesen Wert auf niedriger ändern, wenn du nur begrenzten Serverplatz hast.
    $statArr=autoptimizeCache::stats(); 
    $cacheSize=round($statArr[1]/1024);
    
    if ($cacheSize>$myMaxSize){
       autoptimizeCache::clearall();
       header("Refresh:0"); # Aktualisiert die Seite, damit Autoptimize neue Cache-Dateien erstellen kann
    }
}

//remove copyright from Footer
add_filter( 'generate_copyright','tu_custom_copyright' );
function tu_custom_copyright() {
    ?>
   <span class="copyright">© 2020 <a href="<?php echo get_home_url(); ?>"><?php echo get_bloginfo( 'name' ); ?></a>  |  <a href="/impressum/">Impressum</a>  |  <a href="/datenschutz/">Datenschutz</a></span>
    <?php
}
