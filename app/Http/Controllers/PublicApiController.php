<?php

namespace App\Http\Controllers;

use App\Models\motelmodel;
use Illuminate\Http\Request;

class PublicApiController extends Controller
{
    /**
     * Get all rooms for public site
     */
    public function getRooms()
    {
        $rooms = motelmodel::all()->map(function ($room) {
            return [
                'id' => $room->id,
                'name' => $room->name,
                'description' => $room->description,
                'price' => (int) $room->price,
                'capacity' => $room->capacity,
                'image' => $room->image ? asset('uploads/rooms/' . $room->image) : null,
                'created_at' => $room->created_at,
                'updated_at' => $room->updated_at,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $rooms
        ]);
    }

    /**
     * Get single room by ID
     */
    public function getRoom($id)
    {
        $room = motelmodel::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $room->id,
                'name' => $room->name,
                'description' => $room->description,
                'price' => (int) $room->price,
                'capacity' => $room->capacity,
                'image' => $room->image ? asset('uploads/rooms/' . $room->image) : null,
                'created_at' => $room->created_at,
                'updated_at' => $room->updated_at,
            ]
        ]);
    }

    /**
     * Get gallery images (placeholder for future implementation)
     */
    public function getGallery()
    {
        // This can be expanded when gallery is added to database
        return response()->json([
            'success' => true,
            'data' => []
        ]);
    }

    /**
     * Get restaurant menu (placeholder for future implementation)
     */
    public function getMenu()
    {
        // This can be expanded when menu is added to database
        return response()->json([
            'success' => true,
            'data' => []
        ]);
    }

    /**
     * Get services (placeholder for future implementation)
     */
    public function getServices()
    {
        // This can be expanded when services are added to database
        return response()->json([
            'success' => true,
            'data' => []
        ]);
    }
}
