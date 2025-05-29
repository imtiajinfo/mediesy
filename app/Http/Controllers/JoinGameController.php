<?php

namespace App\Http\Controllers;

use App\Models\Bet;
use App\Models\Boot;
use App\Models\Desk;
use App\Models\Room;
use App\Models\GameHistory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreWinRequest;
use App\Http\Requests\StoreCoinRequest;
use App\Http\Requests\StoreJoinGameRequest;

class JoinGameController extends Controller
{
    public function join(StoreJoinGameRequest $request)
    {
        try {
            $requestData = $request->validated();
            $roomName = '';
            do {
                $roomName = Str::random(8);
            } while (Room::where('room_name', $roomName)->exists());

            DB::beginTransaction();

            $room = Room::where('active_status', 1)
                ->where(function ($query) {
                    $query->where('creating_time', '>', '00:01:00')
                        ->orWhere('created_at', '>', DB::raw('DATE_SUB(NOW(), INTERVAL 1 MINUTE)'));
                })
                ->first(); // Retrieve the room object if it exists

            if (!$room) {
                // If no room meets the conditions, create a new room
                $room = Room::create([
                    'room_name' => $roomName,
                    'creating_time' => "00:01:00",
                    'active_status'  => true,
                ]);
            }

            // $room = Room::create([
            //     'room_name' => $roomName,
            //     'creating_time' => "00:01:00",
            //     'active_status'  => true,
            // ]);

            // Create a new Boot associated with the created Room
            $boot = Boot::create([
                'boot_name' => $roomName,
                'user_id' => $requestData['user_id'],
                'room_id' => $room->id,
                'active_status' => true,
            ]);

            if ($requestData['desk_id']) {
                foreach ($requestData['desk_id'] as $deskId) {
                    $desk = Desk::create([
                        'user_id' => $requestData['user_id'],
                        'room_id' => $room->id,
                        'boot_id' => $boot->id,
                        'desk_id' => $deskId,
                        'active_status' => true,
                    ]);
                }
            } else {
                return response()->json(['error' => "error desk_id"], 500);
            }



            DB::commit();
            return response()->json([
                '$roomDetails' => $room,
                '$bootDetails' => $boot,
                '$deskDetails' => $desk,
                'success' => "Data Created successfully.",
                'message' => "Game Start within 1 second..."
            ], 200);
        } catch (\Exception $error) {
            DB::rollBack();
            return response()->json(['error' => "error"], 500);
        }
    }

    public function getCoin(StoreCoinRequest $request)
    {
        try {
            $requestData = $request->validated();

            // Ensure both desk_id and coin arrays are provided
            if (isset($requestData['desk_id']) && isset($requestData['coin'])) {
                // Start a database transaction
                DB::beginTransaction();

                // Iterate over each desk_id and its corresponding coin value
                foreach ($requestData['desk_id'] as $index => $deskId) {
                    // Create a bet for each desk_id and its corresponding coin value
                    $user_id = Desk::where('id', $deskId)
                        ->where('active_status', true)
                        ->value('user_id');

                    $bet = Bet::create([
                        'user_id' => $user_id,
                        'desk_id' => $deskId,
                        'coin' => $requestData['coin'][$index],
                        'active_status' => true,
                    ]);
                }

                // Commit the transaction
                DB::commit();

                // Return success response
                return response()->json([
                    'betDetails' => $bet,
                    'success' => "Data Created successfully."
                ], 200);
            } else {
                // Return error response if desk_id or coin is missing
                return response()->json(['error' => "Desk ID or coin data missing."], 400);
            }
        } catch (\Exception $error) {
            // Rollback the transaction and return error response if an exception occurs
            DB::rollBack();
            return response()->json(['error' => $error->getMessage()], 500);
        }
    }





    public function getWin(StoreWinRequest $request)
    {
        try {

            $requestData = $request->validated();

            $getRoom = Room::where('active_status', true)
                ->where('id', $requestData['id'])
                ->first();

            if (!$getRoom) {
                return response()->json(['error' => "Room not found or already inactive."], 404);
            }

            DB::beginTransaction();

            $getRoom->update(['active_status' => false]);

            $getBoot = Boot::where('active_status', true)
                ->where('room_id', $getRoom->id)
                ->update(['active_status' => false]);

            $getDesk = Desk::where('active_status', true)
                ->where('room_id', $getRoom->id)
                ->update(['active_status' => false]);


            $getWinner = Bet::whereIn('desk_id', Desk::where('room_id', $getRoom->id)->pluck('id'))
                ->groupBy('user_id')
                ->selectRaw('user_id, SUM(coin) as total_coin')
                ->orderByDesc('total_coin')
                ->first();

            // Get user-wise total coin sums
            $userTotalCoins = Bet::whereIn('desk_id', Desk::where('room_id', $getRoom->id)->pluck('id'))
                ->groupBy('user_id')
                ->selectRaw('user_id, SUM(coin) as total_coin')
                ->get();

            // Get user with the maximum total coin
            $maxTotalCoinUser = $userTotalCoins->sortByDesc('total_coin')->first();

            // Get user with the minimum total coin
            $minTotalCoinUser = $userTotalCoins->sortBy('total_coin')->first();


            $gameHistory = GameHistory::create(['user_id' => $getWinner->user_id, 'room_id' => $getRoom->id]);


            // Update multiple rows in the Bet table
            $getBet = Bet::where('active_status', true)
                ->whereIn('desk_id', Desk::where('room_id', $getRoom->id)->pluck('id'))
                ->update(['active_status' => false]);

            DB::commit();

            return response()->json([

                'TotalBet' => $getBet,
                'max_total_coin_user' => $maxTotalCoinUser,
                'min_total_coin_user' => $minTotalCoinUser,
                'user_total_coins' => $userTotalCoins,
                'winer' => $getWinner,

                'success' => "Data updated successfully.",
                'message' => "Game is Over!",
            ], 200);
        } catch (\Exception $error) {
            //     // Rollback the transaction if an error occurs
            DB::rollBack();
            return response()->json(['error' => $error->getMessage()], 500);
        }
    }


    public function TopTenUser()
    {
        try {

            // Get the top 10 user_ids
            $top10UserIds = GameHistory::select('user_id')
                ->groupBy('user_id')
                ->orderByDesc(DB::raw('COUNT(*)'))
                ->limit(10)
                ->pluck('user_id');

            $top10UserGameHistory = GameHistory::whereIn('user_id', $top10UserIds)->get();

            return response()->json([
                'top_10_user' => $top10UserGameHistory,
                'top10UserIds' => $top10UserIds,
                'success' => "Data get successfully.",
            ], 200);
        } catch (\Exception $error) {
            return response()->json(['error' => $error->getMessage()], 500);
        }
    }
}
