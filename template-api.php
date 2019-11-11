<?php
	/*
		Template Name: API
	*/

$data = json_decode(file_get_contents("php://input"), true);

if( $data['remove_bringit_item'] ){
	var_dumpp($data);
}