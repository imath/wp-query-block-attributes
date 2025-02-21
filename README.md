# WP Query Block Attributes

**This WP Plugin is no more maintained and is now archived**

Introduce a new WP_Query parameter to run block attributes queries. Here's an example of use:

```php
$q = new WP_Query();
$items = $q->query( 
	array(
		'post_type' => 'post',
		array(
			'block_attribute_query' => array(
				array(
					'block'     => 'wpqba/block',          // Name of the WP Block.
					'attribute' => 'wpqbaAttributeOne',    // Name of the WP Block attribute.
					'value'     => 'One',                  // Value to find.
					'type'      => 'string',               // Type for the value (string or integer).
				),
			),
		,)
	)	
);
```
