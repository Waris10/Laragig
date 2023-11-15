<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class ListingController extends Controller
{
  public function index()
  {
    //dd('search');
    return view('listings.index', [
      'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(4)
    ]);
  }
  public function show(Listing $listing)
  {
    return view('listings.show', [
      'listing' => $listing,
    ]);
  }
  //show create form
  public function create()
  {
    return view('listings.create');
  }

  //Store listing data
  public function store(Request $request)
  {
    $formFields = $request->validate([
      'title' => 'required',
      'company' => ['required', Rule::unique('listings', 'company')],
      'location' => 'required',
      'website' => 'required',
      'email' => ['required', 'email'],
      'tags' => 'required',
      'description' => 'required',
      // 'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    if ($request->hasFile('logo')) {
      $formFields['logo'] = $request->file('logo')->store('logos', 'public');
    }

    $formFields['user_id'] = auth()->id();

    Listing::create($formFields);

    return redirect('/')->with('message', 'Listing created successfully!');
  }

  //show Edit form 
  public function edit(Listing $listing)
  {
    return view('listings.edit', ['listing' => $listing]);
  }

  //Update listing data
  public function update(Request $request, Listing $listing)
  {
    //Make Sure Logged in user is owner
    if ($listing->user_id != auth()->id()) {
      abort(403, 'Unauthorized');
    }
    $formFields = $request->validate([
      'title' => 'required',
      'company' => ['required'],
      'location' => 'required',
      'website' => 'required',
      'email' => ['required', 'email'],
      'tags' => 'required',
      'description' => 'required',
      // 'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    if ($request->hasFile('logo')) {
      $formFields['logo'] = $request->file('logo')->store('logos', 'public');
    }

    $listing->update($formFields);

    return back()->with('message', 'Listing updated successfully!');
  }

  //delete listing
  public function destroy(Listing $listing)
  {
    if ($listing->user_id != auth()->id()) {
      abort(403, 'Unauthorized');
    }
    $listing->delete();
    return redirect('/')->with('message', 'Listing successfully deleted ');
  }
  //Mange Listings
  public function manage()
  {
    return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
  }
}