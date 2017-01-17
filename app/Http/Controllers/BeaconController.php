<?php

namespace App\Http\Controllers;

use App\Floor;
use App\Place;
use App\Beacon;
use App\Setting;
use App\Http\Requests;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class BeaconController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $beacons = Beacon::all();
        return view('beacons.index', compact('beacons'));
    }

    /**
     * Display import/settings page
     *
     * @return \Illuminate\Http\Response
     */
    public function import()
    {
	    $services = array(
   	    	'' => 'Select Service' ,
	    	'kontakt.io' => 'Kontakt.io',
	    	'estimote' => 'estimote',
	    );

        return view('beacons.import', compact('services'));
    }

    /**
     * Save import/settings
     *
     * @return \Illuminate\Http\Response
     */
    public function importing(Request $request)
    {
        $filtered = collect($request->all())->filter(function ($value, $key) {
            return substr($key, 0, 1) != '_';
        });

        foreach ($filtered as $key => $value) {
            $setting = Setting::firstOrCreate(['key' => str_replace('-', '.', $key)]);
            $setting->update(['value' => $value]);
        }
        
        $devices = $this->getBeaconsFromWebservice();
        foreach( $devices as $device ) {
			$beacon = Beacon::where( 'beacon_uid', '=', $device )->first();	        

	        if( empty( $beacon ) ) {
		        $device = $this->getBeaconFromWebservice($device);		        
		        
		        $beacon = Beacon::create([
			        'name' => $device->uniqueId,
			        'beacon_uid' => $device->uniqueId,
			        'proximity_uuid' => $device->proximity,
			        'minor' => $device->minor,
	   		        'major' => $device->major, 		        		        
		        ]);		        
	        }
        }
        
        return redirect()->route('beacons.import');    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
//        $places = Place::pluck('name', 'id');
//        $floors = Floor::pluck('name', 'id');

//        $devices = $this->getBeaconsFromWebservice();

//        if ($request->input('beacon_uid')) {
 //           $beacon = $this->getBeaconFromWebservice($request->input('beacon_uid'));
   //     }

        return view('beacons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
           'name' => 'required|max:255',
        ]);

        $beacon = Beacon::create($request->all());
        return redirect()->route('beacons.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $beacon = Beacon::findOrFail($id);
        return view('beacons.show', compact('beacon'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $beacon = Beacon::findOrFail($id);
//        $places = Place::pluck('name', 'id');
//        $floors = Floor::pluck('name', 'id');

        return view('beacons.edit', compact('beacon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
           'name' => 'required|max:255',
        ]);

        $beacon = Beacon::findOrFail($id);
        $beacon->update($request->all());
        return redirect()->route('beacons.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $beacon = Beacon::findOrFail($id);
        $beacon->delete();
        return redirect()->route('beacons.index');
    }

    /**
     * Get beacons from Kontakt webservice
     * @return Illuminate\Support\Collection
     */
    protected function getBeaconsFromWebservice()
    {
        $client = new Client([
            'base_uri' => 'https://api.kontakt.io/',
            'headers' => [
                'Accept' => 'application/vnd.com.kontakt+json;version=7',
                'Api-Key' => config('services.kontakt.key'),
                'User-Agent' => 'BeaconBacon'
            ]
        ]);

        try {
            $response = $client->request('GET', '/device?maxResult=1000');
            $results = json_decode($response->getBody()->getContents());
            $devices = collect();

            foreach ($results->devices as $device) {
                $devices->put($device->uniqueId, $device->uniqueId . ($device->alias ? ' (' . $device->alias . ')' : ''));
            }

            return $devices;
        }
        catch (\Exception $e) {
            return [];
        }
    }

    protected function getBeaconFromWebservice($beaconId)
    {
        $client = new Client([
            'base_uri' => 'https://api.kontakt.io/',
            'headers' => [
                'Accept' => 'application/vnd.com.kontakt+json;version=7',
                'Api-Key' => config('services.kontakt.key'),
                'User-Agent' => 'BeaconBacon'
            ]
        ]);

        try {
            $response = $client->request('GET', '/device/'.$beaconId);
            $results = json_decode($response->getBody()->getContents());
            return $results;
        }
        catch (\Exception $e) {
            return null;
        }
    }
}
