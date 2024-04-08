<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class AddressController extends Controller
{
    protected $addressData;

    public function __construct()
    {
        $this->addressData = json_decode(file_get_contents(resource_path('data/philippine_provinces_cities_municipalities_and_barangays_2019v2.json')), true);
    }

    public function getRegions()
    {

        $regions = [];
        foreach ($this->addressData as $code => $regionData) {
  
            $regions[(string) $code] = $regionData['region_name'];
        }

      
        $sortRegions = function ($a, $b) {

            $specialCodes = ['4A', '4B', 'BARMM', 'CAR', 'NCR'];

            if (in_array($a, $specialCodes) && in_array($b, $specialCodes)) {
                return array_search($a, $specialCodes) <=> array_search($b, $specialCodes);
            }
            if (in_array($a, $specialCodes)) {
                return 1;
            }

            if (in_array($b, $specialCodes)) {
                return -1;
            }
            return strcmp($a, $b);
        };
        uksort($regions, $sortRegions);
        return Inertia::render('Student/NewIntern', ['regions' => $regions]);
    }


    public function getProvinces($region)
    {
        $provinces = array_keys($this->addressData[$region]['province_list'] ?? []);
        return Inertia::render('Student/NewIntern', ['provinces' => $provinces]);
    }
}
