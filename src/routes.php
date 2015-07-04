<?php

// home page
get('/', ['as'=>'dashboard', 'uses'=>function(){
	return 'home page';
}]);

// page routes
get('pages', ['as'=>'pages', 'uses'=>'PageController@index']);
get('pages/create', ['as'=>'pages.create', 'uses'=>'PageController@create']);
post('pages/store', ['as'=>'pages.store', 'uses'=>'PageController@store']);
get('pages/edit/{pageId}', ['as'=>'pages.edit', 'uses'=>'PageController@edit']);
post('pages/update/{pageId}', ['as'=>'pages.update', 'uses'=>'PageController@update']);
get('pages/trash/{pageId}', ['as'=>'pages.trash', 'uses'=>'PageController@trash']);
get('pages/trash', ['as'=>'pages.trash.index', 'uses'=>'PageController@trashIndex']);
get('pages/restore/{pageId}', ['as'=>'pages.restore', 'uses'=>'PageController@restore']);
get('{slug}', 'PageController@show');


// collection routes
get('collections', 'CollectionController@index');
get('collections/create', 'CollectionController@create');
post('collections/store', 'CollectionController@store');
get('collections/edit/{collectionSlug}', 'CollectionController@edit');
post('collections/update/{collectionSlug}', 'CollectionController@update');
get('collections/delete/{collectionSlug}', 'CollectionController@deleteConfirm');
post('collections/delete/{collectionId}', 'CollectionController@delete');
get('collections/{collectionSlug}', 'CollectionController@show');


// collection item routes
get('collections/{collectionSlug}/items/new', 'ItemController@create');
post('collections/{collectionSlug}/items/store', 'ItemController@store');
get('collections/{collectionSlug}/items/edit/{itemId}', 'ItemController@edit');
get('collections/{collectionSlug}/items/show/{itemId}', 'ItemController@edit');
get('collections/{collectionSlug}/items/delete/{itemId}', 'ItemController@deleteConfirm');
post('collections/{collectionSlug}/items/delete/{itemId}', 'ItemController@delete');
post('collections/{collectionSlug}/items/update/{itemId}', 'ItemController@update');








