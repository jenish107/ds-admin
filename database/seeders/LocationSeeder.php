<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            'Australia' => [
                'New South Wales' => [
                    'Sydney',
                    'Newcastle',
                    'Wollongong',
                    'Albury',
                    'Maitland',
                ],
                'Victoria' => [],
                'Queensland' => [],
                'Western Australia' => [],
                'South Australia' => [],
                'Tasmania' => [],
                'Northern Territory' => [],
                'Australian Capital Territory' => [],
            ],
            'India' => [
                'Andhra Pradesh' => [],
                'Arunachal Pradesh' => [],
                'Assam' => [],
                'Bihar' => [],
                'Chhattisgarh' => [],
                'Goa' => [],
                'Gujarat' => [
                    'Ahmedabad',
                    'Surat',
                    'Vadodara',
                    'Rajkot',
                    'Bhavnagar',
                ],
                'Haryana' => [],
                'Himachal Pradesh' => [],
                'Jharkhand' => [],
                'Karnataka' => [],
                'Kerala' => [],
                'Madhya Pradesh' => [],
                'Maharashtra' => [
                    'Mumbai',
                    'Pune',
                    'Nagpur',
                    'Nashik',
                    'Aurangabad',
                ],
                'Manipur' => [],
                'Meghalaya' => [],
                'Mizoram' => [],
                'Nagaland' => [],
                'Odisha' => [],
                'Punjab' => [],
                'Rajasthan' => [],
                'Sikkim' => [],
                'Tamil Nadu' => [],
                'Telangana' => [],
                'Tripura' => [],
                'Uttar Pradesh' => [],
                'Uttarakhand' => [],
                'West Bengal' => [],
            ],
            'USA' => [
                'Alabama' => [],
                'Alaska' => [],
                'Arizona' => [],
                'Arkansas' => [],
                'California' => [
                    'Los Angeles',
                    'San Francisco',
                    'San Diego',
                    'Sacramento',
                    'San Jose',
                ],
                'Colorado' => [],
                'Connecticut' => [],
                'Delaware' => [],
                'Florida' => [],
                'Georgia' => [],
                'Hawaii' => [],
                'Idaho' => [],
                'Illinois' => [],
                'Indiana' => [],
                'Iowa' => [],
                'Kansas' => [],
                'Kentucky' => [],
                'Louisiana' => [],
                'Maine' => [],
                'Maryland' => [],
                'Massachusetts' => [],
                'Michigan' => [],
                'Minnesota' => [],
                'Mississippi' => [],
                'Missouri' => [],
                'Montana' => [],
                'Nebraska' => [],
                'Nevada' => [],
                'New Hampshire' => [],
                'New Jersey' => [],
                'New Mexico' => [],
                'New York' => [],
                'North Carolina' => [],
                'North Dakota' => [],
                'Ohio' => [],
                'Oklahoma' => [],
                'Oregon' => [],
                'Pennsylvania' => [],
                'Rhode Island' => [],
                'South Carolina' => [],
                'South Dakota' => [],
                'Tennessee' => [],
                'Texas' => [],
                'Utah' => [],
                'Vermont' => [],
                'Virginia' => [],
                'Washington' => [],
                'West Virginia' => [],
                'Wisconsin' => [],
                'Wyoming' => [],
                'District of Columbia' => [],
            ],
        ];

        foreach ($locations as $countryName => $states) {
            $country = Country::firstOrCreate(['name' => $countryName]);

            foreach ($states as $stateName => $cities) {
                $state = State::firstOrCreate([
                    'name' => $stateName,
                    'country_id' => $country->id,
                ]);

                foreach ($cities as $cityName) {
                    City::firstOrCreate([
                        'name' => $cityName,
                        'state_id' => $state->id,
                    ]);
                }
            }
        }
    }
}
