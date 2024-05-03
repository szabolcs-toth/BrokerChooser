<?php

namespace App\Http\Controllers;

use App\Exceptions\NoVariablesException;
use App\Services\ab\AbTestsService;
use App\Services\ab\AbTestsVariablesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Throwable;

class PhotoController extends Controller
{
    /**
     * Show the profile for a given user.
     */
    public function index(): View
    {
        try {
            $variable = (new AbTestsService)->getRunningTestById(1);
        } catch (NoVariablesException $e) {
            Log::error('Missing variable for AB test', ['error' => $e]);
            $variable = 4;
        } catch (Throwable $e) {
            Log::error('Something wrong in PhotoController', ['error' => $e]);
            $variable = 4;
        }

        $color = match ($variable) {
            1 => 'green',
            2 => 'yellow',
            3 => 'blue',
            4 => 'red'
        };

        return view('photo.index', [
            'color' => $color,
            'variable' => $variable
        ]);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function thankYou(Request $request): View
    {
        $variable = $request->input('variable');

        if (!is_null($variable)) {
            (new AbTestsVariablesService)->incById($variable);
        } else {
            Log::error('Missing variableId for AB test');
        }

        return view('photo.thank-you');
    }
}
