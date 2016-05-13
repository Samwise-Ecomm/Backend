<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\Offers\StoreRequest;
use App\Http\Requests\Offers\UpdateRequest;
use App\Http\Requests\Offers\StoreItemRequest;
use App\Http\Requests\Offers\StoreImageRequest;
use App\Http\Requests\Offers\UpdateImagesRequest;

use App\Search;
use App\Offer;
use App\OfferPicture;
use App\Item;

class OffersController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request, Search $search)
	{
		return $search->query('offers', $request);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreRequest $request)
	{
		return Offer::extractTypeInfo($request->offer);
	}

	/**
	 * Display the specified public version of the resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		return Offer::findOrFail($id)->toPublicArray();
	}

	/**
	 * Display the specified private version of the resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function showAdmin($id)
	{
		return Offer::findOrFail($id)->toPrivateArray();
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$offer = Offer::findOrFail($id);
		$request['type_info'] = Offer::extractTypeInfo($request->all());

		OfferPicture::saveMany($request['pictures'], $id);
		OfferPicture::destroy($request['deleted_pictures']);
		Item::saveMany($request['items'], $id);
		$offer->update($request->all());

		return Offer::findOrFail($id)->toPrivateArray();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}

	public function storeItem(StoreItemRequest $request)
	{

	}

	public function storeImage(StoreImageRequest $request)
	{
		$file = $request->file('picture');
		$file_name = uniqid().'.'.$file->getClientOriginalExtension();
		$file->move(base_path()."/storage/app/tmp", "$file_name");

		return $file_name;
	}

	public function updateImages(UpdateImagesRequest $request)
	{

	}
}
