<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Category;
use App\Http\Requests\StoreColocationRequest;
use App\Http\Requests\UpdateColocationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ColocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colocations = Auth::user()->colocations()
            ->with(['users', 'categories'])
            ->get();

        return view('colocations.index', compact('colocations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreColocationRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $colocation = Colocation::create($request->validated());

            foreach ($request->categories as $categoryData) {
                $colocation->categories()->create([
                    'name' => $categoryData['name']
                ]);
            }

            $colocation->users()->attach(Auth::id(), [
                'role' => 'owner',
                'joined_at' => now()
            ]);

            return redirect()->route('colocations.show', $colocation)
                ->with('success', 'Colocation created successfully!');
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Colocation $colocation)
    {
        $response = Gate::inspect('view', $colocation);
        
        if ($response->denied()) {
            return redirect()->route('colocations.index')->with('error', $response->message());
        }

        $colocation->load(['users', 'categories', 'expenses.payer', 'expenses.category', 'expenses.debts.debtor', 'expenses.debts.expense.payer']);

        return view('colocations.show', compact('colocation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Colocation $colocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateColocationRequest $request, Colocation $colocation)
    {
        return DB::transaction(function () use ($request, $colocation) {
            $colocation->update($request->validated());

            $existingIds = $colocation->categories()->pluck('id')->toArray();
            $newCategoryData = collect($request->categories);
            
            $providedIds = $newCategoryData->pluck('id')->filter()->toArray();
            
            $toDelete = array_diff($existingIds, $providedIds);
            Category::destroy($toDelete);

            foreach ($request->categories as $categoryData) {
                if (isset($categoryData['id'])) {
                    Category::where('id', $categoryData['id'])->update(['name' => $categoryData['name']]);
                } else {
                    $colocation->categories()->create(['name' => $categoryData['name']]);
                }
            }

            return redirect()->route('colocations.show', $colocation)
                ->with('success', 'Colocation updated successfully!');
        });
    }

    /**
     * Remove (Cancel) the specified resource from storage.
     */
    public function destroy(Colocation $colocation)
    {
        $response = Gate::inspect('delete', $colocation);

        if ($response->denied()) {
            return redirect()->back()->with('error', $response->message());
        }

        $colocation->update(['status' => 'canceled']);

        return redirect()->route('colocations.index')
            ->with('success', 'Colocation canceled successfully.');
    }
}
