<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
/**
 * 
 * function for,if not auth user die
 * 
 */
function authUserOrDie($user)
{
	if(!$user) {
		$data = [
			'status'    => 'error',
			'massage'   => 'هویت کاربر نا مشخص است',
				'data'  => []
		];
		return response()->json($data, 203); 
		die;
	}	
}

/**
 * 
 * function for, if not found user die
 * 
 */
function notFoundUserAndDie($user) 
{
	if(!$user) {
		$data = [
			'status'    => 'error',
			'massage'   => 'کاربر مورد نظر شما یافت نشد!',
			'data'  => []
		];
	

		return response()->json($data, 404);
		die;
	}
	
}

/**
 * 
 * function for, if user not access for do work die
 * 
 */
function accessDenyAndDie($user)
{
	if($user->id != Auth::user()->id) {
		$data = [
			'status'    => 'error',
			'massage'   => 'شما دسترسی لازم را برای انجام این کار ندارید!',
			'data'  => []
		];
		return response()->json($data, 203);
		die; 
	}
}

/**
 * 
 * function for, if not found post die
 * @return \Illuminate\Http\Response
 */
function notFoundPostAndDie($post)
{
	if(! $post) {
		$data = [
			'status'    => 'error',
			'massage'   => 'پست مورد نظر یافت نشد',
				'data'  => []
		];
		return response()->json($data, 404); 
		die;
	}
}