<?php
	function createFolder( $agent, $parentID, $name, $desc, $type, $version )
	{
		include_once "config.php";
		include_once "useful.php";
		
		$folder_id = generateUUID();
		
		// Create connection
		$conn = new mysqli(SQLServerName, SQLUserName, SQLPassword, SQLDatabase);

		// Check connection
		if ( $conn->connect_error ) {
			return "Failed to connect to SQL";
		}

		$sql  = "INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (?,?,?,?,?,?)";
		$stmt = $conn->stmt_init();
		
		if( !$stmt->prepare( $sql ) )
			return "Failed to prepare SQL";
			
		$stmt->bind_param( "ssssss", $name, $type, $version, $folder_id, $agent, $parentID );
		
		if( $stmt->execute() === FALSE )
			return "Failed to create folder!";
		
		return $folder_id;
	}
	
	function createInventoryItem( $asset_id, $asset_type, $inventory_name, $inventory_desc, $inv_next_perms, 
		$inv_current_perms, $inv_type, $creator_id, $base_perms, $everyone_perms, $sale_price, $salt_type, 
		$creation_date, $group_id, $group_owned, $flags, $avatar_id, $parent_id, $group_perms )
	{
		
		include_once "config.php";
		include_once "useful.php";
		
		// Create connection
		$conn = new mysqli(SQLServerName, SQLUserName, SQLPassword, SQLDatabase);

		// Check connection
		if ( $conn->connect_error ) {
			return "Failed to connect to SQL";
		}

		$inventory_id = generateUUID();
		
		$sql  = "INSERT INTO inventoryitems (assetID, assetType, inventoryName, inventoryDescription, inventoryNextPermissions, inventoryCurrentPermissions, invType, creatorID, inventoryBasePermissions, inventoryEveryOnePermissions, salePrice, saleType, creationDate, groupID, groupOwned, flags, inventoryID, avatarID, parentFolderID, inventoryGroupPermissions) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$stmt = $conn->stmt_init();
		
		if( !$stmt->prepare( $sql ) )
			return "Failed to prepare SQL";
			
		$stmt->bind_param( "sissiiisiiiiisiisssi", $asset_id, $asset_type, $inventory_name, $inventory_desc, $inv_next_perms, $inv_current_perms, $inv_type, $creator_id, $base_perms, $everyone_perms, $sale_price, $salt_type, $creation_date, $group_id, $group_owned, $flags, $inventory_id, $avatar_id, $parent_id, $group_perms);
		
		if( $stmt->execute() === FALSE )
			return "Failed to create item!";
		
		return $inventory_id;
	}

	function createDefaultInventory( $userID )
	{
		// Create Root Folder
		$root_folder = createFolder( $userID, "00000000-0000-0000-0000-000000000000", "My Inventory", "", 8, 18 );
		
		// Create Category Folders
		$animations_folder = createFolder( $userID, $root_folder, "Animations", "", 20, 1 );
		$body_parts_folder = createFolder( $userID, $root_folder, "Body Parts", "", 13, 5 );
		$calling_cards_folder = createFolder( $userID, $root_folder, "Calling Cards", "", 2, 2 );
		$clothing_folder = createFolder( $userID, $root_folder, "Clothing", "", 5, 3 );
		$current_outfits_folder = createFolder( $userID, $root_folder, "Current Outfit", "", 46, 7 );
		$favorites_folder = createFolder( $userID, $root_folder, "Favorites", "", 23, 1 );
		$gestures_folder = createFolder( $userID, $root_folder, "Gestures", "", 21, 1 );
		$landmarks_folder = createFolder( $userID, $root_folder, "Landmarks", "", 3, 1 );
		$lost_and_found_folder = createFolder( $userID, $root_folder, "Lost And Found", "", 16, 1 );
		$marketplace_listings_folder = createFolder( $userID, $root_folder, "Marketplace Listings", "", 53, 1 );
		$notecards_folder = createFolder( $userID, $root_folder, "Notecards", "", 7, 1 );
		$objects_folder = createFolder( $userID, $root_folder, "Objects", "", 6, 1 );
		$photo_album_folder = createFolder( $userID, $root_folder, "Photo Album", "", 15, 1 );
		$scripts_folder = createFolder( $userID, $root_folder, "Scripts", "", 10, 1 );
		$sounds_folder = createFolder( $userID, $root_folder, "Sounds", "", 1, 1 );
		$textures_folder = createFolder( $userID, $root_folder, "Textures", "", 0, 1 );
		$trash_folder = createFolder( $userID, $root_folder, "Trash", "", 14, 1 );
		
		// Create Sub Folders
		$friends_folder = createFolder( $userID, $calling_cards_folder, "Friends", "", 2, 2 );
		
		$all_folder = createFolder( $userID, $friends_folder, "All", "", 2, 1 );
		
		// Create Inventory Items
		
		// Body Parts
		$default_eyes  = createInventoryItem( '4bb6fa4d-1cd2-498a-a84c-95c1a0e745a7', 13, 'Default Eyes', 	'', 581632, 581632, 18, $userID, 581632, 581632, 0, 0, 1573955422, '00000000-0000-0000-0000-000000000000', 0, 3, $userID, $body_parts_folder, 581632 );
		$default_shape = createInventoryItem( '66c41e39-38f9-f75a-024e-585989bfab73', 13, 'Default Shape', 	'', 581632, 581632, 18, $userID, 581632, 581632, 0, 0, 1573955422, '00000000-0000-0000-0000-000000000000', 0, 0, $userID, $body_parts_folder, 581632 );
		$default_skin  = createInventoryItem( '77c41e39-38f9-f75a-024e-585989bbabbb', 13, 'Default Skin', 	'', 581632, 581632, 18, $userID, 581632, 581632, 0, 0, 1573955422, '00000000-0000-0000-0000-000000000000', 0, 1, $userID, $body_parts_folder, 581632 );
		$default_hair  = createInventoryItem( 'd342e6c0-b9d2-11dc-95ff-0800200c9a66', 13, 'Default Hair', 	'', 581632, 581632, 18, $userID, 581632, 581632, 0, 0, 1573955422, '00000000-0000-0000-0000-000000000000', 0, 2, $userID, $body_parts_folder, 581632 );
		
		// Clothing
		$default_shirt = createInventoryItem( '00000000-38f9-1111-024e-222222111110', 5, 'Default Shirt', 	'', 581632, 581632, 18, $userID, 581632, 581632, 0, 0, 1573955422, '00000000-0000-0000-0000-000000000000', 0, 4, $userID, $clothing_folder, 581632 );
		$default_pants = createInventoryItem( '00000000-38f9-1111-024e-222222111120', 5, 'Default Pants', 	'', 581632, 581632, 18, $userID, 581632, 581632, 0, 0, 1573955422, '00000000-0000-0000-0000-000000000000', 0, 5, $userID, $clothing_folder, 581632 );
		
		// Current Outfit
		createInventoryItem( $default_eyes, 	24, 'Default Eyes', 	'', 32768, 32768, 18, $userID, 32768, 32768, 0, 0, 1573955422, '00000000-0000-0000-0000-000000000000', 0, 3, $userID, $current_outfits_folder, 32768 );
		createInventoryItem( $default_skin, 	24, 'Default Skin', 	'', 32768, 32768, 18, $userID, 32768, 32768, 0, 0, 1573955422, '00000000-0000-0000-0000-000000000000', 0, 1, $userID, $current_outfits_folder, 32768 );
		createInventoryItem( $default_hair, 	24, 'Default Hair', 	'', 32768, 32768, 18, $userID, 32768, 32768, 0, 0, 1573955422, '00000000-0000-0000-0000-000000000000', 0, 2, $userID, $current_outfits_folder, 32768 );
		createInventoryItem( $default_shape, 	24, 'Default Shape', 	'', 32768, 32768, 18, $userID, 32768, 32768, 0, 0, 1573955422, '00000000-0000-0000-0000-000000000000', 0, 0, $userID, $current_outfits_folder, 32768 );
		createInventoryItem( $default_shirt, 	24, 'Default Shirt', 	'', 32768, 32768, 18, $userID, 32768, 32768, 0, 0, 1573955422, '00000000-0000-0000-0000-000000000000', 0, 4, $userID, $current_outfits_folder, 32768 );
		createInventoryItem( $default_pants, 	24, 'Default Pants', 	'', 32768, 32768, 18, $userID, 32768, 32768, 0, 0, 1573955422, '00000000-0000-0000-0000-000000000000', 0, 5, $userID, $current_outfits_folder, 32768 );
		
		return TRUE;
	}
?>