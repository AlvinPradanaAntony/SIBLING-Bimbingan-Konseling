<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GuidanceBooking;

class GuidanceBookingController extends Controller
{
    public function index()
    {
        return view('data_booking_bimbingan', [
            'guidanceBookings' => GuidanceBooking::all(),
            'active' => 'guidance_booking'
        ]);
    }

    public function handlePost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'booking_date' => 'required|date',
            'booking_time' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        $bookingDateTime = $request->input('booking_date') . ' ' . $request->input('booking_time') . ':00';
        $existingBookings = GuidanceBooking::where('booking_date', $bookingDateTime)->count();
        $maxBookingPerSlot = 3;

        if ($existingBookings >= $maxBookingPerSlot) {
            return redirect()->back()->withInput()->withErrors([
                'booking_time' => 'Waktu ini sudah penuh! Silakan pilih waktu lain.'
            ]);
        }

        $guidanceBooking = new GuidanceBooking();
        $guidanceBooking->name = $request->input('name');
        $guidanceBooking->phone_number = $request->input('phone_number');
        $guidanceBooking->booking_date = $bookingDateTime;
        $guidanceBooking->status = $request->input('status');
        $guidanceBooking->save();
        return redirect()->route('guidanceBooking.index')->with('success', 'Pemesanan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|numeric',
            'booking_date' => 'required|date',
            'booking_time' => 'required',
            'status' => 'required|in:pending,confirmed,completed'
        ]);

        $bookingDateTime = $request->input('booking_date') . ' ' . $request->input('booking_time') . ':00';

        $guidanceBooking = GuidanceBooking::findOrFail($id);
        $guidanceBooking->name = $request->input('name');
        $guidanceBooking->phone_number = $request->input('phone_number');
        $guidanceBooking->booking_date = $bookingDateTime;
        $guidanceBooking->status = $request->input('status');
        $guidanceBooking->save();

        return redirect()->route('guidanceBooking.index')->with('success', 'Status berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $guidanceBooking = GuidanceBooking::findOrFail($id);
        $guidanceBooking->delete();

        return redirect()->route('guidanceBooking.index')->with('success', 'Pemesanan berhasil dihapus.');
    }

}
