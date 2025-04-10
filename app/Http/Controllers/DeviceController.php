<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use Inertia\Inertia;

class DeviceController extends Controller
{
    public function index()
    {

        $devices = Device::where('userId', auth()->user()->id)->get(); // Ambil semua data device

        return Inertia::render('device/list', [
            'devices' => $devices,
        ]);
    }

    public function monitoring($serialNumber)
    {
        return Inertia::render('device/monitoring', [
            'params' => [
                'serialNumber' => $serialNumber
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('device/create');
    }

    public function destroy($id)
    {
        $device = Device::find($id);

        if (!$device) {
            return response()->json(['message' => 'Device not found'], 404);
        }

        $device->delete();
        return response()->json(['message' => 'Device deleted successfully'], 200);
    }

    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'nameDevice' => 'required|string|max:255',
            'serialNumber' => 'required|string|unique:devices,serialNumber|max:255',
        ]);

        // Simpan ke database
        Device::create([
            'nameDevice' => $request->nameDevice,
            'serialNumber' => $request->serialNumber,
            'userId' => auth()->user()->id,
        ]);

        return response()->json(['message' => 'Device added successfully!'], 201);
    }

}