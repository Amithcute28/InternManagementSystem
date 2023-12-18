<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class AddressController extends Controller
{
    protected $addressData;

    public function __construct()
    {
        // Load the JSON file once and store it in the class property
        $this->addressData = json_decode(file_get_contents(resource_path('data/philippine_provinces_cities_municipalities_and_barangays_2019v2.json')), true);
    }

    public function getRegions()
    {
        // Extract regions with their codes
        $regions = [];
        foreach ($this->addressData as $code => $regionData) {
            // Ensure the code is a string
            $regions[(string) $code] = $regionData['region_name'];
        }

        // Define a custom sorting function
        $sortRegions = function ($a, $b) {
            // Special codes that should be sorted at the end
            $specialCodes = ['4A', '4B', 'BARMM', 'CAR', 'NCR'];

            // Check if both keys are special codes
            if (in_array($a, $specialCodes) && in_array($b, $specialCodes)) {
                return array_search($a, $specialCodes) <=> array_search($b, $specialCodes);
            }

            // If only $a is a special code
            if (in_array($a, $specialCodes)) {
                return 1;
            }

            // If only $b is a special code
            if (in_array($b, $specialCodes)) {
                return -1;
            }

            // Compare as strings
            return strcmp($a, $b);
        };

        // Sort regions by keys using the custom sort function
        uksort($regions, $sortRegions);


        // Return the sorted regions as Inertia props
        return Inertia::render('Student/NewIntern', ['regions' => $regions]);
    }


    public function getProvinces($region)
    {
        // Extract provinces based on the region
        $provinces = array_keys($this->addressData[$region]['province_list'] ?? []);
        return Inertia::render('Student/NewIntern', ['provinces' => $provinces]);
    }

    // ... other methods for cities and barangays
}
