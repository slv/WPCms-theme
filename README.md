# WPCms
libreria di utilities per Wordpress



## WPCmsSettingsPage
Creare una pagina per le opzioni


	$settingsPage = new WPCmsSettingsPage($config)
	
	# Parametri:
	
	$config
	- array di configurazione
	
	'title' => Il titolo della Pagina
	
		il titolo che appare nella barra laterale dell'admin (es. 'Font e Colori')
	
	'menu_slug' => Slug
	
		stringa unica che identifica la pagina (es. 'theme_settings')
		
	'fields' => array dei campi personalizzati
	
		elenco di campi che devono essere visualizzati in questa pagina (checkbox, textarea, select etc…)
	
	'parent_slug' => Slug della pagina Genitore
	
		se la pagina di settings deve essere visualizzata come figlia di un'altra pagina nella barra laterale,
		indicare qui il menu_slug della pagina parent.
		

### Opzioni WPCmsSettingsPage

	Se la pagina deve avere dei permessi particolari per essere visualizzata bisogna settare l'attributo 'capabilityType':

	$settingsPage->capabilityType = 'edit_themes';


## WPCmsPostType
Creare custom post type

	$customPostType = new WPCmsPostType($config);
	
	# Parametri
	
	$config
	- array di configurazione
	
	'post_type' => nome del post type (univoco)
	
		ad es. 'projects', 'slideshows'
	
	'fields' => array dei campi personalizzati
	
		elenco di campi che devono essere visualizzati per ogni post (checkbox, textarea, select etc…)

### Metodi WPCmsPostType

####setArgs($args)
	
	setta gli arguments di questa pagina: http://codex.wordpress.org/Function_Reference/register_post_type

	valori di default:

	'public' => true,
	'exclude_from_search' => false,
	'publicly_queryable' => true,
	'show_ui' => true,
	'query_var' => true,
	'has_archive' => true,
	'show_in_menu' => true,
	'capability_type' => 'post',
	'map_meta_cap' => true,
	'hierarchical' => false,
	'menu_position' => null,
	'taxonomies' => array(),
	'supports' => array(
        'title',
        'editor',
        'thumbnail',
        'revisions'
      )
    );

####setLabels($labels)


	setta le etichette per il custom post type che compaiono nell'admin

	defaults: ($td è il dominio della lingua)

	'name' => __('Custom Items', $td)
	'singular_name' => __('Custom Item', $td)
	'add_new' => __('Add New', $td)
	'add_new_item' => __('Add New Item', $td)
	'edit_item' => __('Edit Item', $td)
	'new_item' => __('New Item', $td)
	'view_item' => __('View Item', $td)
	'search_items' => __('Search Items', $td)
	'not_found' =>  __('No items found', $td)
	'not_found_in_trash' => __('No items found in Trash', $td)
	'parent_item_colon' => ''
	'menu_name' => __('Custom Items', $td)




### Utilities:

#### _o($label, $default = '')

	restituisce l'opzione settata in una WPCmsSettingsPage e se non la trova restituisce $default
	
	ad esempio se in una pagina c'è un textinput con id 'colore_header', per ricavarlo nel frontend posso usare _o('colore_header', '#ffffff')




#### _m($label, $postID = false)

	dentro al Loop posso ricavare il metadata con id = $label, fuori dal Loop devo passare anche l'ID del post
	

	in Loop:
	
	while(have_posts()) { the_post();
		echo '<h1>' . the_title() . '</h1>';
		echo '<h2>' . _m('sottotitolo') . '</h2>';
	}
	
	----
	
	fuori dal Loop:
	
	$postIds = array(234, 235, 236);
	
	foreach($postIds as $postId) {
		echo '<h1>' . get_the_title($postId) . '</h1>';
		echo '<h2>' . _m('sottotitolo', $postId) . '</h2>';
	}



































