<?php

namespace App\Http\Controllers;

use App\Models\Brt;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;

class brtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Brt::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $brt = new Brt();
        $brt->user_id = $request->user_id;
        $brt->reserved_amount = $request->reserved_amount;
        $brt->status = $request->status;
        $brt->brt_code = (string)Str::uuid();

        $brt->save();

        return response()->json($brt, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $brt = Brt::find($id);

        return response()->json($brt);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $brt = Brt::find($id);

        if (!$brt) return response()->json(['message' => 'record not found'], 404);

        if (isset($request->user_id)) $brt->user_id = $request->user_id;
        if (isset($request->reserved_amount)) $brt->reserved_amount = $request->reserved_amount;
        if (isset($request->status)) $brt->status = $request->status;

        $brt->save();

        return response()->json($brt);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $brt = Brt::find($id);

        if (!$brt) return response()->json(['message' => 'record not found'], 404);

        $brt->delete();

        return response()->json(['message' => 'BRT Record Deleted Successfully']);
    }

    public function data_analysis(Request $request)
    {
        $brt_period = Brt::all();
        $date_in_use = Carbon::now();
        if (($request->startdate) && ($request->enddate)) {
            $request->validate(['startdate' => 'required|date', 'enddate' => 'required|date',]);
            $date_in_use = Carbon::createFromFormat('Y-m-d', $request->startdate);
            $brt_period = Brt::whereBetween('created_at', [$request->startdate, $request->enddate]);
        } else if ($request->startdate) {
            $date_in_use = Carbon::createFromFormat('Y-m-d', $request->startdate);
            $request->validate(['startdate' => 'required|date',]);
            $brt_period = Brt::where('created_at', '>=', $request->startdate);
        } else if ($request->enddate) {
            $date_in_use = Carbon::createFromFormat('Y-m-d', $request->enddate);
            $request->validate(['enddate' => 'required|date',]);
            $brt_period = Brt::where('created_at', '<=', $request->enddate);
        }

        $total_brts = $brt_period->count();
        $total_active_brts = $brt_period->where('status', 'active')->count();
        $total_expired_brts = $brt_period->where('status', 'expired')->count();
        $total_daily_brts = Brt::whereDate('created_at', $date_in_use)->count();
        $total_weekly_brts = Brt::all()->whereBetween(
            'created_at',
            [$date_in_use->startOfWeek()->startOfDay()->format('Y-m-d H:i:s'), $date_in_use->endOfWeek()->endOfDay()->format('Y-m-d H:i:s')]
        )->count();
        $total_monthly_brts = Brt::all()->whereBetween(
            'created_at',
            [$date_in_use->startOfMonth()->startOfDay()->format('Y-m-d H:i:s'), $date_in_use->endOfMonth()->endOfDay()->format('Y-m-d H:i:s')]
        )->count();
        $total_brts_reserved_amount = $brt_period->sum('reserved_amount');

        return [
            'total_brts' => $total_brts,
            'total_active_brts' => $total_active_brts,
            'total_expired_brts' => $total_expired_brts,
            'total_daily_brts' => $total_daily_brts,
            'total_weekly_brts' => $total_weekly_brts,
            'total_monthly_brts' => $total_monthly_brts,
            'total_brts_reserved_amount' => $total_brts_reserved_amount
        ];
    }
}
