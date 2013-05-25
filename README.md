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


    $customPostType = new WPCmsPostType(array(
    	'post_type' => 'projects',
    	'fields' => array...
    ));


	'fields' è un array così composto:
		
	array(
		'wpcms-custom-1' => array(
			'title' => 'Campi Custom 1',
			'fields' => elenco di campi per il box "Campi Custom 1"
		),
		'wpcms-cust-2' => array(
			'title' => 'Campi Custom 2',
			'fields' => elenco di campi per il box "Campi Custom 2"
		)
    )
    
    a sua volta 'fields' è un elenco di campi personalizzati (checkbox, input, select etc...)
    	
    esempio:
    
	
	array(
		'wpcms-custom-1' => array(
			'title' => 'Campi Custom 1',
			'fields' => array(
				new WPCmsInputField ('input1', 'WPCmsInputField 1', 'Example of WPCmsInputField'),
				new WPCmsTextField ('text1', 'WPCmsTextField 1', 'Example of WPCmsTextField'),
				new WPCmsTextareaField ('textarea1', 'WPCmsTextareaField 1', 'Example of WPCmsTextareaField')
			)
		),
		...
    )
		
	
	  

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


####register()

	una volta settati argomenti e etichette


## Utilities:

### _o($label, $default = '')

	restituisce l'opzione settata in una WPCmsSettingsPage e se non la trova restituisce $default
	
	ad esempio se in una pagina c'è un textinput con id 'colore_header', per ricavarlo nel frontend posso usare _o('colore_header', '#ffffff')




### _m($label, $postID = false)

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


## Esempio:


in WPCms-admin.php setto un custom post type e lo chiamo 'progetti'

	$postTypeProgetti = new WPCmsPostType(array(
		'post_type' => 'progetti',
		'fields' => array()
	));

	$postTypeProgetti->register();


come campi personalizzati mi servono una mappa Google, un immagine e 2 campi di testo. La mappa la voglio mettere in un box a parte


	$postTypeProgetti = new WPCmsPostType(array(
		'post_type' => 'progetti',
		'fields' => array(
			'google-map-box' => array(),
			'immagine-e-testi-box' => array()
		)
	));

	$postTypeProgetti->register();
	
dentro a 'google-map-box' e 'immagine-e-testi-box' devo settare title e i campi:

	$postTypeProgetti = new WPCmsPostType(array(
		'post_type' => 'progetti',
		'fields' => array(
			'google-map-box' => array(
				'title' => 'Box per la Mappa',
				'fields' => array...
			),
			'immagine-e-testi-box' => array(
				'title' => 'Box per immagine e i testi',
				'fields' => array...
			)
		)
	));

	$postTypeProgetti->register();

i fields che mi servono sono:

immagine: WPCmsImageField
testi: WPCmsTextField
mappa: WPCmsGoogleMapField

quindi:

	$postTypeProgetti = new WPCmsPostType(array(
		'post_type' => 'progetti',
		'fields' => array(
			'google-map-box' => array(
				'title' => 'Box per la Mappa',
				'fields' => array(
        			new WPCmsGoogleMapField (array(
          				'id' => 'ttgmap1',
          				'name' => 'Mappa',
          				'description' => 'Descrizione della mappa')),
				)
			),
			'immagine-e-testi-box' => array(
				'title' => 'Box per immagine e i testi',
				'fields' => array(
			        new WPCmsImageField (array(
          				'id' => 'ttimage1',
				          'name' => 'Immagine',
				          'description' => 'Descrizione Immagine')),
			        new WPCmsTextField (array(
			          'id' => 'tttext1',
			          'name' => 'Testo 1',
			          'description' => 'Descrizione testo 1')),
			        new WPCmsTextField (array(
			          'id' => 'tttext2',
			          'name' => 'Testo 2',
			          'description' => 'Descrizione testo 2'))
				)
			)
		)
	));

	$postTypeProgetti->register();


 i file che gestiranno l'elenco e il post singolo di questo tipo sono:
 
 	archive-progetti.php
 	single-progetti.php
 
 
 se voglio collegare una taxonomy per filtrare i post devo registrarla:
 
 	register_taxonomy(
		'categorie-progetti',
		null,
		array(
			'hierarchical' => true,
			'labels' => array(
				'name' => 'Categorie Progetti'
			),
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array('slug' => 'categorie-progetti'),
		)
	);
	
e poi collegarla al post

 	
 	$postTypeProgetti->setArgs(array(
		'taxonomies' => array('categorie-progetti')
	));


nell'admin comparirà il box della taxonomy,
il file che gestisce l'elenco di tutti i post con questa taxonomy, anche se i post sono di tipo diverso:


	taxonomy-categorie-progetti.php























