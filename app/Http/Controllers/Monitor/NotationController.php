<?php

namespace App\Http\Controllers\Monitor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Monitor\NotationValidator;
use App\Models\City;
use App\Models\Notation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Class NotationController
 *
 * @package App\Http\Controllers\Monitor
 */
class NotationController extends Controller
{
    /**
     * Notation constructor.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(); // Initiate the global constructor.
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Function for displaying all the notations from a city in the application backend.
     *
     * @param  City $city The resource entity from the storage.
     * @return View
     */
    public function index(City $city): View
    {
        $notations = $city->notations()->simplePaginate();
        return view('monitor.notations.index', compact('city', 'notations'));
    }

    /**
     * Function for displaying the notation create view.
     *
     * @todo Implement status indicator
     *
     * @param  City $city The resource entity from the storage.
     * @return View
     */
    public function create(City $city): View
    {
        $statusses = [0 => 'Draft version', 1 => 'Publish notation'];
        return view('monitor.notations.create', compact('city', 'statusses'));
    }

    /**
     * Method for storing a city notation in the application.
     *
     * @see \App\Observers\NotationObserver::created()
     *
     * @param  NotationValidator $input The form request class that handles the validation.
     * @param  City              $city  The resource entity from the storage.
     * @return RedirectResponse
     */
    public function store(NotationValidator $input, City $city): RedirectResponse
    {
        $notation = new Notation($input->all());

        if ($city->notations()->save($notation)) {
            $this->flashMessage->success("The notation for {$city->name} has been saved.");
        }

        return redirect()->route('monitor.notations', $city);
    }

    /**
     * Method for updating the status from a notation.
     *
     * @param  Notation  $notation The database entity from the notation.
     * @param  string    $status   The newly status indicator for the notation.
     * @return RedirectResponse
     */
    public function status(Notation $notation, string $status): RedirectResponse
    {
        // Notation has a publish status so revert it to draft.
        // And let the user know it trough a flash message.
        if ($status === 'draft') {
            $notation->update(['status' => false]);
            $this->flashMessage->info('The notation has been registered as draft.');
        }

        // Notation has a draft status so publish the notation.
        // And letting the user know it trough a flash message.
        if ($status === 'publish') {
            $notation->update(['status' => true]);
            $this->flashMessage->info('The notation has been published.');
        }

        return redirect()->route('monitor.notations', $notation->city);
    }

    /**
     * Function to display the view for editing a notation.
     *
     * @todo Register route
     *
     * @param  Notation $notation The resource entity from the notation.
     * @return RedirectResponse
     */
    public function edit(Notation $notation): View
    {
        return view('monitor.notations.edit', compact('notation'));
    }

    /**
     * Method for deleting a notation in the application.
     *
     * @param  Notation $notation The resource entity from the notation in the storage.
     * @return RedirectResponse
     */
    public function destroy(Notation $notation): RedirectResponse
    {
        if ($notation->delete()) {
            $this->flashMessage->info("The notation for {$notation->city->name} has been deleted.");
        }

        return redirect()->back(); // Redirect to the previous page.
    }
}
