<?php

namespace App\Traits;

use App\Models\Country;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

trait MondayComTrait
{
	/**
	 * @param $data
	 */
	public function add($data)
	{
		$token = env('MONDAY_API_TOKEN');
		$board_id = env('USER_BOARD_ID');
		$apiUrl = 'https://api.monday.com/v2';
		$headers = ['Content-Type: application/json', 'Authorization: ' . $token];
		$query = 'mutation ($myItemName: String!, $columnVals: JSON!) { create_item (board_id:' . $board_id . ', item_name:$myItemName, column_values:$columnVals) { id } }';
		$vars = [
			'myItemName' => $data['first_name'] . ' ' . $data['last_name'],
			'columnVals' => json_encode([
				'email' => ['email' => $data['email'], 'text' => $data['email']],
				'phone' => ['phone' => $data['phone'], 'text' => $data['phone']],
				'text4' => $data['agency_name'],
				'text0' => $data['username'],
				'text' => $data['address'],
				'text7' => $data['city'],
				'text5' => $data['country_id'] ? Country::whereId($data['country_id'])->first()->name : NULL,
				'text05' => $data['state'] ? State::whereId($data['state'])->first()->name : NULL,
				'text8' => $data['zipcode'],
				'date4' => ['date' => Carbon::parse($data['created_at'])->format('Y-m-d')],
				'status' => ['label' => 'Working on it'],
			])
		];

		$data = @file_get_contents($apiUrl, false, stream_context_create([
			'http' => [
				'method' => 'POST',
				'header' => $headers,
				'content' => json_encode(['query' => $query, 'variables' => $vars])
			]
		]));

		$responseContent = json_decode($data, true);

		return json_encode($responseContent);
	}

	/**
	 * @param $data
	 */
	public function addMostPurchased($data)
	{
		$token = env('MONDAY_API_TOKEN');
		$board_id = '4678744772';
		$apiUrl = 'https://api.monday.com/v2';
		$headers = ['Content-Type: application/json', 'Authorization: ' . $token];
		$query = 'mutation ($myItemName: String!, $columnVals: JSON!) { create_item (board_id:' . $board_id . ', item_name:$myItemName, column_values:$columnVals) { id } }';
		$vars = [
			'myItemName' => $data['first_name'] . ' ' . $data['last_name'],
			'columnVals' => json_encode([
				'email' => ['email' => $data['email'], 'text' => $data['email']],
				'numbers' => $data['count'],
				'date4' => ['date' => Carbon::now()->format('Y-m-d')],
				'status' => ['label' => 'Working on it'],
			])
		];

		$data = @file_get_contents($apiUrl, false, stream_context_create([
			'http' => [
				'method' => 'POST',
				'header' => $headers,
				'content' => json_encode(['query' => $query, 'variables' => $vars])
			]
		]));

		$responseContent = json_decode($data, true);

		return json_encode($responseContent);
	}

	public function addLeadToMonday($data)
	{
		$token = env('MONDAY_API_TOKEN');
		$board_id = '5229595637';
		$apiUrl = 'https://api.monday.com/v2';
		$headers = ['Content-Type: application/json', 'Authorization: ' . $token];
		$query = 'mutation ($myItemName: String!, $columnVals: JSON!) { create_item (board_id:' . $board_id . ', item_name:$myItemName, column_values:$columnVals) { id } }';
		$vars = [
			'myItemName' => $data['email'],
			'columnVals' => json_encode([
				'email' => ['email' => $data['email'], 'text' => $data['email']],
				'text' => $data['source'],
				'date4' => ['date' => Carbon::now()->format('Y-m-d')],
				'status' => ['label' => 'Working on it'],
			])
		];

		$data = @file_get_contents($apiUrl, false, stream_context_create([
			'http' => [
				'method' => 'POST',
				'header' => $headers,
				'content' => json_encode(['query' => $query, 'variables' => $vars])
			]
		]));

		$responseContent = json_decode($data, true);

		return json_encode($responseContent);
	}
}
