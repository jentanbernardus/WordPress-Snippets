<?php

/*

	Setup and add our custom post types

*/

function create_post_types(){
	
	/*
	
		Products
	
	*/

	register_post_type( 'my_products',
		array(
			'labels' => array(
				'name' => 'Products',
				'singular_name' => 'Product',
				'add_new' => 'Add New Product',
				'add_new_item' => 'Add New Product',
				'edit_item' => 'Edit Product',
				'new_item' => 'New Product'
			),
			'public' => true,
			'rewrite' => array(
				'slug' => 'products'
			),
			'supports' => array(
				'title',
				'editor',
				'excerpt',
				'page-attributes',
				'revisions',
				'thumbnail',
			)
		)
	);

}

function create_custom_meta(){

	/*
	
		Products
	
	*/

	add_meta_box("my_products", "Product Information", "my_products_meta", "my_products", "normal", "low");
	
	function my_products_meta(){
	
		global $post;
		
		$my_model_number = get_post_meta($post->ID, 'my_model_number', true);
																
		echo '<p><label>Model Number(s): </label><input type="text" name="my_model_number" value="' . $my_model_number . '" /><br /><small><em>For awesome people</em></small></p>';	

	}

	/*
	
		Save all our info!!
	
	*/

	function save_details($post_id){
	
	     global $post;
		
		/*
		
			Save Product Info
		
		*/

		if(isset($_POST['post_type']) && ($_POST['post_type'] == "edisson_products")) {
	
			foreach($_POST as $k => $v){
			
				update_post_meta($post_id, $k, $v);
			
			}
		  
		}
	     
	}

	add_action("save_post", "save_details");
	
}

add_action('init', 'create_post_types');
add_action('admin_menu', 'create_custom_meta');

/*

	Create the Product Types

*/

add_action( 'init', 'create_product_type_taxonomies', 0 );

function create_product_type_taxonomies() {

	$labels = array(
		'name' => _x( 'Product Types', 'products' ),
		'singular_name' => _x( 'Product Type', 'product' ),
		'search_items' =>  __( 'Search Product Types' ),
		'all_items' => __( 'All Product Types' ),
		'parent_item' => __( 'Parent Genre' ),
		'parent_item_colon' => __( 'Parent Genre:' ),
		'edit_item' => __( 'Edit Product Type' ),
		'update_item' => __( 'Update Product Type' ),
		'add_new_item' => __( 'Add New Product Type' ),
		'new_item_name' => __( 'New Product Type Name' ),
	); 	

	register_taxonomy( 'product_type', array( 'my_products' ), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'product' ),
	));
	
}