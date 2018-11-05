<?php

namespace App\Http\Controllers\Account;

use App\Http\Requests\Account\{InformationValidator, SecurityValidator};
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

/**
 * Class SettingsController
 * 
 * @package App\Http\Controllers\Account
 */
class SettingsController extends Controller
{
    /**
     * SettingsController constructor 
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware(['auth']);
    }

    /**
     * Function for displaying the account settings pages. 
     * 
     * @param  null|string $type The type of settings page the user wants to display. 
     * @return View
     */
    public function index(?string $type = null): View
    {
        switch ($type) {
            case 'security':    return view('account.settings-security');
            default:            return view('account.settings-information');
        }
    }

    /**
     * Update the account information settings.
     *
     * @param  InformationValidator $input The form request class that handles the validation.
     * @return RedirectResponse
     */
    public function updateInformation(InformationValidator $input): RedirectResponse
    {
        if ($this->auth->user()->update($input->all())) {
            $this->flashMessage->success('Your account information has been updated!')->important();
        }

        return redirect()->route('account.settings');
    }

    /**
     * Update the account security settings.
     *
     * @param  SecurityValidator $input The form request class that handles the validation.
     * @return RedirectResponse
     */
    public function updateSecurity(SecurityValidator $input): RedirectResponse
    {
        $user = $this->auth->user();

        if ($user->update($input->all())) {
            $this->auth->logoutOtherDevices($user->password);
            $this->flashMessage->success('Your account security has been updated!')->important();
        }

        return redirect()->route('account.settings', ['type' => 'security']);
    }
}
