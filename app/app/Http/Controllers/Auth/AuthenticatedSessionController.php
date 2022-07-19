<?php

namespace App\Http\Controllers\Auth;

use DataTables;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // dd(User::all());
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }


    public function list(Request $request)
    {
        if ($request->ajax()) {

            $client = new Client([
                'headers' => ['Content-Type' => 'application/json']
            ]);

            $response = $client->get(
                'https://devel.bebasbayar.com/web/test_programmer.php'
            );

            $data = json_decode($response->getBody()->getContents(), true);


            foreach ($data as $key => $value) {
                # code...
                if (isset($value[$key])) {
                    $collect[] = $value;
                } else {
                    if ($value !== []) {

                        for ($i = 0; $i < count($value); $i++) {
                            # code...
                            $collect[$key] = $value[$i];
                        }
                    }
                }
            }

            return Datatables::collection($collect)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<button class="btn btn-success btn-xs
                              ModalTriggerBtn " id="ModalTriggerBtn"  
                              data-catid=' . $row['nb_visits'] . ' data-toggle="modal"
                              data-target="#customermodal"><span class="glyphicon glyphicon-trash" title="Delete Center"/>Detail</button>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function SpecificData($id = 0)
    {

        $client = new Client([
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $response = $client->get(
            'https://devel.bebasbayar.com/web/test_programmer.php'
        );
        $data = json_decode($response->getBody()->getContents(), true);

        foreach ($data as $key => $value) {
            # code...
            if (isset($value[$key])) {
                $collect[] = $value;
            } else {
                if ($value !== []) {

                    for ($i = 0; $i < count($value); $i++) {
                        # code...
                        $collect[$key] = $value[$i];
                    }
                }
            }
        }

        $collection = collect($collect);
        $filteredItems = $collection->where('nb_visits', $id);

        return response()->json(['data' => $filteredItems]);
    }
}
