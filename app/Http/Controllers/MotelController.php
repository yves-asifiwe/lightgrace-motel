<?php

namespace App\Http\Controllers;

use App\Models\motelmodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MotelController extends Controller
{
    public function index()
    {
        $rooms = motelmodel::all();
        return view('admin.rooms', compact('rooms'));
    }

    public function create()
    {
        return view('rooms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'capacity' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'capacity' => $request->capacity,
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/rooms'), $imageName);
            $data['image'] = $imageName;
        }

        motelmodel::create($data);

        return redirect()->route('admin.rooms')->with('success', 'Room added successfully!');
    }

    public function show($id)
    {
        $room = motelmodel::findOrFail($id);
        return view('rooms.show', compact('room'));
    }

    public function edit($id)
    {
        $room = motelmodel::findOrFail($id);
        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'capacity' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $room = motelmodel::findOrFail($id);

        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'capacity' => $request->capacity,
        ];

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($room->image && file_exists(public_path('uploads/rooms/' . $room->image))) {
                unlink(public_path('uploads/rooms/' . $room->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/rooms'), $imageName);
            $data['image'] = $imageName;
        }

        $room->update($data);

        return redirect()->route('admin.rooms')->with('success', 'Room updated successfully!');
    }

    public function destroy($id)
    {
        $room = motelmodel::findOrFail($id);

        // Delete image if exists
        if ($room->image && file_exists(public_path('uploads/rooms/' . $room->image))) {
            unlink(public_path('uploads/rooms/' . $room->image));
        }

        $room->delete();

        return redirect()->route('admin.rooms')->with('success', 'Room deleted successfully!');
    }
}
