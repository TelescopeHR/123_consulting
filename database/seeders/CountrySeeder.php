<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		Country::insert(array(
			0   => array(
				'id'         => 1,
				'name'       => 'Afghanistan',
				'code'       => 'AF',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			1   => array(
				'id'         => 2,
				'name'       => 'Aland Islands',
				'code'       => 'AX',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			2   => array(
				'id'         => 3,
				'name'       => 'Albania',
				'code'       => 'AL',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			3   => array(
				'id'         => 4,
				'name'       => 'Algeria',
				'code'       => 'DZ',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			4   => array(
				'id'         => 5,
				'name'       => 'American Samoa',
				'code'       => 'AS',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			5   => array(
				'id'         => 6,
				'name'       => 'Andorra',
				'code'       => 'AD',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			6   => array(
				'id'         => 7,
				'name'       => 'Angola',
				'code'       => 'AO',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			7   => array(
				'id'         => 8,
				'name'       => 'Anguilla',
				'code'       => 'AI',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			8   => array(
				'id'         => 9,
				'name'       => 'Antarctica',
				'code'       => 'AQ',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			9   => array(
				'id'         => 10,
				'name'       => 'Antigua And Barbuda',
				'code'       => 'AG',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			10  => array(
				'id'         => 11,
				'name'       => 'Argentina',
				'code'       => 'AR',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			11  => array(
				'id'         => 12,
				'name'       => 'Armenia',
				'code'       => 'AM',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			12  => array(
				'id'         => 13,
				'name'       => 'Aruba',
				'code'       => 'AW',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			13  => array(
				'id'         => 14,
				'name'       => 'Australia',
				'code'       => 'AU',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			14  => array(
				'id'         => 15,
				'name'       => 'Austria',
				'code'       => 'AT',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			15  => array(
				'id'         => 16,
				'name'       => 'Azerbaijan',
				'code'       => 'AZ',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			16  => array(
				'id'         => 17,
				'name'       => 'Bahamas The',
				'code'       => 'BS',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			17  => array(
				'id'         => 18,
				'name'       => 'Bahrain',
				'code'       => 'BH',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			18  => array(
				'id'         => 19,
				'name'       => 'Bangladesh',
				'code'       => 'BD',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			19  => array(
				'id'         => 20,
				'name'       => 'Barbados',
				'code'       => 'BB',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			20  => array(
				'id'         => 21,
				'name'       => 'Belarus',
				'code'       => 'BY',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			21  => array(
				'id'         => 22,
				'name'       => 'Belgium',
				'code'       => 'BE',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			22  => array(
				'id'         => 23,
				'name'       => 'Belize',
				'code'       => 'BZ',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			23  => array(
				'id'         => 24,
				'name'       => 'Benin',
				'code'       => 'BJ',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			24  => array(
				'id'         => 25,
				'name'       => 'Bermuda',
				'code'       => 'BM',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			25  => array(
				'id'         => 26,
				'name'       => 'Bhutan',
				'code'       => 'BT',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			26  => array(
				'id'         => 27,
				'name'       => 'Bolivia',
				'code'       => 'BO',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			27  => array(
				'id'         => 28,
				'name'       => 'Bosnia and Herzegovina',
				'code'       => 'BA',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			28  => array(
				'id'         => 29,
				'name'       => 'Botswana',
				'code'       => 'BW',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			29  => array(
				'id'         => 30,
				'name'       => 'Bouvet Island',
				'code'       => 'BV',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			30  => array(
				'id'         => 31,
				'name'       => 'Brazil',
				'code'       => 'BR',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			31  => array(
				'id'         => 32,
				'name'       => 'British Indian Ocean Territory',
				'code'       => 'IO',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			32  => array(
				'id'         => 33,
				'name'       => 'Brunei',
				'code'       => 'BN',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			33  => array(
				'id'         => 34,
				'name'       => 'Bulgaria',
				'code'       => 'BG',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			34  => array(
				'id'         => 35,
				'name'       => 'Burkina Faso',
				'code'       => 'BF',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			35  => array(
				'id'         => 36,
				'name'       => 'Burundi',
				'code'       => 'BI',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			36  => array(
				'id'         => 37,
				'name'       => 'Cambodia',
				'code'       => 'KH',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			37  => array(
				'id'         => 38,
				'name'       => 'Cameroon',
				'code'       => 'CM',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			38  => array(
				'id'         => 39,
				'name'       => 'Canada',
				'code'       => 'CA',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			39  => array(
				'id'         => 40,
				'name'       => 'Cape Verde',
				'code'       => 'CV',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			40  => array(
				'id'         => 41,
				'name'       => 'Cayman Islands',
				'code'       => 'KY',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			41  => array(
				'id'         => 42,
				'name'       => 'Central African Republic',
				'code'       => 'CF',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			42  => array(
				'id'         => 43,
				'name'       => 'Chad',
				'code'       => 'TD',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			43  => array(
				'id'         => 44,
				'name'       => 'Chile',
				'code'       => 'CL',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			44  => array(
				'id'         => 45,
				'name'       => 'China',
				'code'       => 'CN',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			45  => array(
				'id'         => 46,
				'name'       => 'Christmas Island',
				'code'       => 'CX',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			46  => array(
				'id'         => 47,
				'name'       => 'Cocos (Keeling) Islands',
				'code'       => 'CC',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			47  => array(
				'id'         => 48,
				'name'       => 'Colombia',
				'code'       => 'CO',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			48  => array(
				'id'         => 49,
				'name'       => 'Comoros',
				'code'       => 'KM',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			49  => array(
				'id'         => 50,
				'name'       => 'Congo',
				'code'       => 'CG',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			50  => array(
				'id'         => 51,
				'name'       => 'Congo The Democratic Republic Of The',
				'code'       => 'CD',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			51  => array(
				'id'         => 52,
				'name'       => 'Cook Islands',
				'code'       => 'CK',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			52  => array(
				'id'         => 53,
				'name'       => 'Costa Rica',
				'code'       => 'CR',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			53  => array(
				'id'         => 54,
				'name'       => 'Cote D\'Ivoire (Ivory Coast)',
				'code'       => 'CI',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			54  => array(
				'id'         => 55,
				'name'       => 'Croatia (Hrvatska)',
				'code'       => 'HR',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			55  => array(
				'id'         => 56,
				'name'       => 'Cuba',
				'code'       => 'CU',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			56  => array(
				'id'         => 57,
				'name'       => 'Cyprus',
				'code'       => 'CY',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			57  => array(
				'id'         => 58,
				'name'       => 'Czech Republic',
				'code'       => 'CZ',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			58  => array(
				'id'         => 59,
				'name'       => 'Denmark',
				'code'       => 'DK',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			59  => array(
				'id'         => 60,
				'name'       => 'Djibouti',
				'code'       => 'DJ',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			60  => array(
				'id'         => 61,
				'name'       => 'Dominica',
				'code'       => 'DM',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			61  => array(
				'id'         => 62,
				'name'       => 'Dominican Republic',
				'code'       => 'DO',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			62  => array(
				'id'         => 63,
				'name'       => 'East Timor',
				'code'       => 'TL',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			63  => array(
				'id'         => 64,
				'name'       => 'Ecuador',
				'code'       => 'EC',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			64  => array(
				'id'         => 65,
				'name'       => 'Egypt',
				'code'       => 'EG',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			65  => array(
				'id'         => 66,
				'name'       => 'El Salvador',
				'code'       => 'SV',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			66  => array(
				'id'         => 67,
				'name'       => 'Equatorial Guinea',
				'code'       => 'GQ',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			67  => array(
				'id'         => 68,
				'name'       => 'Eritrea',
				'code'       => 'ER',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			68  => array(
				'id'         => 69,
				'name'       => 'Estonia',
				'code'       => 'EE',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			69  => array(
				'id'         => 70,
				'name'       => 'Ethiopia',
				'code'       => 'ET',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			70  => array(
				'id'         => 71,
				'name'       => 'Falkland Islands',
				'code'       => 'FK',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			71  => array(
				'id'         => 72,
				'name'       => 'Faroe Islands',
				'code'       => 'FO',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			72  => array(
				'id'         => 73,
				'name'       => 'Fiji Islands',
				'code'       => 'FJ',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			73  => array(
				'id'         => 74,
				'name'       => 'Finland',
				'code'       => 'FI',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			74  => array(
				'id'         => 75,
				'name'       => 'France',
				'code'       => 'FR',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			75  => array(
				'id'         => 76,
				'name'       => 'French Guiana',
				'code'       => 'GF',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			76  => array(
				'id'         => 77,
				'name'       => 'French Polynesia',
				'code'       => 'PF',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			77  => array(
				'id'         => 78,
				'name'       => 'French Southern Territories',
				'code'       => 'TF',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			78  => array(
				'id'         => 79,
				'name'       => 'Gabon',
				'code'       => 'GA',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			79  => array(
				'id'         => 80,
				'name'       => 'Gambia The',
				'code'       => 'GM',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			80  => array(
				'id'         => 81,
				'name'       => 'Georgia',
				'code'       => 'GE',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			81  => array(
				'id'         => 82,
				'name'       => 'Germany',
				'code'       => 'DE',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			82  => array(
				'id'         => 83,
				'name'       => 'Ghana',
				'code'       => 'GH',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			83  => array(
				'id'         => 84,
				'name'       => 'Gibraltar',
				'code'       => 'GI',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			84  => array(
				'id'         => 85,
				'name'       => 'Greece',
				'code'       => 'GR',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			85  => array(
				'id'         => 86,
				'name'       => 'Greenland',
				'code'       => 'GL',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			86  => array(
				'id'         => 87,
				'name'       => 'Grenada',
				'code'       => 'GD',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			87  => array(
				'id'         => 88,
				'name'       => 'Guadeloupe',
				'code'       => 'GP',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			88  => array(
				'id'         => 89,
				'name'       => 'Guam',
				'code'       => 'GU',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			89  => array(
				'id'         => 90,
				'name'       => 'Guatemala',
				'code'       => 'GT',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			90  => array(
				'id'         => 91,
				'name'       => 'Guernsey and Alderney',
				'code'       => 'GG',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			91  => array(
				'id'         => 92,
				'name'       => 'Guinea',
				'code'       => 'GN',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			92  => array(
				'id'         => 93,
				'name'       => 'Guinea-Bissau',
				'code'       => 'GW',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			93  => array(
				'id'         => 94,
				'name'       => 'Guyana',
				'code'       => 'GY',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			94  => array(
				'id'         => 95,
				'name'       => 'Haiti',
				'code'       => 'HT',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			95  => array(
				'id'         => 96,
				'name'       => 'Heard Island and McDonald Islands',
				'code'       => 'HM',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			96  => array(
				'id'         => 97,
				'name'       => 'Honduras',
				'code'       => 'HN',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			97  => array(
				'id'         => 98,
				'name'       => 'Hong Kong S.A.R.',
				'code'       => 'HK',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			98  => array(
				'id'         => 99,
				'name'       => 'Hungary',
				'code'       => 'HU',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			99  => array(
				'id'         => 100,
				'name'       => 'Iceland',
				'code'       => 'IS',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			100 => array(
				'id'         => 101,
				'name'       => 'India',
				'code'       => 'IN',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			101 => array(
				'id'         => 102,
				'name'       => 'Indonesia',
				'code'       => 'ID',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			102 => array(
				'id'         => 103,
				'name'       => 'Iran',
				'code'       => 'IR',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			103 => array(
				'id'         => 104,
				'name'       => 'Iraq',
				'code'       => 'IQ',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			104 => array(
				'id'         => 105,
				'name'       => 'Ireland',
				'code'       => 'IE',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			105 => array(
				'id'         => 106,
				'name'       => 'Israel',
				'code'       => 'IL',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			106 => array(
				'id'         => 107,
				'name'       => 'Italy',
				'code'       => 'IT',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			107 => array(
				'id'         => 108,
				'name'       => 'Jamaica',
				'code'       => 'JM',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			108 => array(
				'id'         => 109,
				'name'       => 'Japan',
				'code'       => 'JP',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			109 => array(
				'id'         => 110,
				'name'       => 'Jersey',
				'code'       => 'JE',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			110 => array(
				'id'         => 111,
				'name'       => 'Jordan',
				'code'       => 'JO',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			111 => array(
				'id'         => 112,
				'name'       => 'Kazakhstan',
				'code'       => 'KZ',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			112 => array(
				'id'         => 113,
				'name'       => 'Kenya',
				'code'       => 'KE',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			113 => array(
				'id'         => 114,
				'name'       => 'Kiribati',
				'code'       => 'KI',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			114 => array(
				'id'         => 115,
				'name'       => 'Korea North',
				'code'       => 'KP',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			115 => array(
				'id'         => 116,
				'name'       => 'Korea South',
				'code'       => 'KR',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			116 => array(
				'id'         => 117,
				'name'       => 'Kuwait',
				'code'       => 'KW',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			117 => array(
				'id'         => 118,
				'name'       => 'Kyrgyzstan',
				'code'       => 'KG',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			118 => array(
				'id'         => 119,
				'name'       => 'Laos',
				'code'       => 'LA',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			119 => array(
				'id'         => 120,
				'name'       => 'Latvia',
				'code'       => 'LV',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			120 => array(
				'id'         => 121,
				'name'       => 'Lebanon',
				'code'       => 'LB',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			121 => array(
				'id'         => 122,
				'name'       => 'Lesotho',
				'code'       => 'LS',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			122 => array(
				'id'         => 123,
				'name'       => 'Liberia',
				'code'       => 'LR',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			123 => array(
				'id'         => 124,
				'name'       => 'Libya',
				'code'       => 'LY',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			124 => array(
				'id'         => 125,
				'name'       => 'Liechtenstein',
				'code'       => 'LI',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			125 => array(
				'id'         => 126,
				'name'       => 'Lithuania',
				'code'       => 'LT',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			126 => array(
				'id'         => 127,
				'name'       => 'Luxembourg',
				'code'       => 'LU',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			127 => array(
				'id'         => 128,
				'name'       => 'Macau S.A.R.',
				'code'       => 'MO',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			128 => array(
				'id'         => 129,
				'name'       => 'Macedonia',
				'code'       => 'MK',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			129 => array(
				'id'         => 130,
				'name'       => 'Madagascar',
				'code'       => 'MG',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			130 => array(
				'id'         => 131,
				'name'       => 'Malawi',
				'code'       => 'MW',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			131 => array(
				'id'         => 132,
				'name'       => 'Malaysia',
				'code'       => 'MY',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			132 => array(
				'id'         => 133,
				'name'       => 'Maldives',
				'code'       => 'MV',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			133 => array(
				'id'         => 134,
				'name'       => 'Mali',
				'code'       => 'ML',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			134 => array(
				'id'         => 135,
				'name'       => 'Malta',
				'code'       => 'MT',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			135 => array(
				'id'         => 136,
				'name'       => 'Man (Isle of)',
				'code'       => 'IM',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			136 => array(
				'id'         => 137,
				'name'       => 'Marshall Islands',
				'code'       => 'MH',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			137 => array(
				'id'         => 138,
				'name'       => 'Martinique',
				'code'       => 'MQ',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			138 => array(
				'id'         => 139,
				'name'       => 'Mauritania',
				'code'       => 'MR',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			139 => array(
				'id'         => 140,
				'name'       => 'Mauritius',
				'code'       => 'MU',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			140 => array(
				'id'         => 141,
				'name'       => 'Mayotte',
				'code'       => 'YT',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			141 => array(
				'id'         => 142,
				'name'       => 'Mexico',
				'code'       => 'MX',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			142 => array(
				'id'         => 143,
				'name'       => 'Micronesia',
				'code'       => 'FM',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			143 => array(
				'id'         => 144,
				'name'       => 'Moldova',
				'code'       => 'MD',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			144 => array(
				'id'         => 145,
				'name'       => 'Monaco',
				'code'       => 'MC',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			145 => array(
				'id'         => 146,
				'name'       => 'Mongolia',
				'code'       => 'MN',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			146 => array(
				'id'         => 147,
				'name'       => 'Montenegro',
				'code'       => 'ME',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			147 => array(
				'id'         => 148,
				'name'       => 'Montserrat',
				'code'       => 'MS',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			148 => array(
				'id'         => 149,
				'name'       => 'Morocco',
				'code'       => 'MA',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			149 => array(
				'id'         => 150,
				'name'       => 'Mozambique',
				'code'       => 'MZ',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			150 => array(
				'id'         => 151,
				'name'       => 'Myanmar',
				'code'       => 'MM',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			151 => array(
				'id'         => 152,
				'name'       => 'Namibia',
				'code'       => 'NA',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			152 => array(
				'id'         => 153,
				'name'       => 'Nauru',
				'code'       => 'NR',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			153 => array(
				'id'         => 154,
				'name'       => 'Nepal',
				'code'       => 'NP',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			154 => array(
				'id'         => 155,
				'name'       => 'Bonaire, Sint Eustatius and Saba',
				'code'       => 'BQ',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			155 => array(
				'id'         => 156,
				'name'       => 'Netherlands The',
				'code'       => 'NL',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			156 => array(
				'id'         => 157,
				'name'       => 'New Caledonia',
				'code'       => 'NC',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			157 => array(
				'id'         => 158,
				'name'       => 'New Zealand',
				'code'       => 'NZ',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			158 => array(
				'id'         => 159,
				'name'       => 'Nicaragua',
				'code'       => 'NI',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			159 => array(
				'id'         => 160,
				'name'       => 'Niger',
				'code'       => 'NE',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			160 => array(
				'id'         => 161,
				'name'       => 'Nigeria',
				'code'       => 'NG',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			161 => array(
				'id'         => 162,
				'name'       => 'Niue',
				'code'       => 'NU',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			162 => array(
				'id'         => 163,
				'name'       => 'Norfolk Island',
				'code'       => 'NF',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			163 => array(
				'id'         => 164,
				'name'       => 'Northern Mariana Islands',
				'code'       => 'MP',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			164 => array(
				'id'         => 165,
				'name'       => 'Norway',
				'code'       => 'NO',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			165 => array(
				'id'         => 166,
				'name'       => 'Oman',
				'code'       => 'OM',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			166 => array(
				'id'         => 167,
				'name'       => 'Pakistan',
				'code'       => 'PK',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			167 => array(
				'id'         => 168,
				'name'       => 'Palau',
				'code'       => 'PW',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			168 => array(
				'id'         => 169,
				'name'       => 'Palestinian Territory Occupied',
				'code'       => 'PS',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			169 => array(
				'id'         => 170,
				'name'       => 'Panama',
				'code'       => 'PA',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			170 => array(
				'id'         => 171,
				'name'       => 'Papua new Guinea',
				'code'       => 'PG',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			171 => array(
				'id'         => 172,
				'name'       => 'Paraguay',
				'code'       => 'PY',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			172 => array(
				'id'         => 173,
				'name'       => 'Peru',
				'code'       => 'PE',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			173 => array(
				'id'         => 174,
				'name'       => 'Philippines',
				'code'       => 'PH',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			174 => array(
				'id'         => 175,
				'name'       => 'Pitcairn Island',
				'code'       => 'PN',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			175 => array(
				'id'         => 176,
				'name'       => 'Poland',
				'code'       => 'PL',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			176 => array(
				'id'         => 177,
				'name'       => 'Portugal',
				'code'       => 'PT',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			177 => array(
				'id'         => 178,
				'name'       => 'Puerto Rico',
				'code'       => 'PR',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			178 => array(
				'id'         => 179,
				'name'       => 'Qatar',
				'code'       => 'QA',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			179 => array(
				'id'         => 180,
				'name'       => 'Reunion',
				'code'       => 'RE',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			180 => array(
				'id'         => 181,
				'name'       => 'Romania',
				'code'       => 'RO',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			181 => array(
				'id'         => 182,
				'name'       => 'Russia',
				'code'       => 'RU',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			182 => array(
				'id'         => 183,
				'name'       => 'Rwanda',
				'code'       => 'RW',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			183 => array(
				'id'         => 184,
				'name'       => 'Saint Helena',
				'code'       => 'SH',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			184 => array(
				'id'         => 185,
				'name'       => 'Saint Kitts And Nevis',
				'code'       => 'KN',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			185 => array(
				'id'         => 186,
				'name'       => 'Saint Lucia',
				'code'       => 'LC',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			186 => array(
				'id'         => 187,
				'name'       => 'Saint Pierre and Miquelon',
				'code'       => 'PM',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			187 => array(
				'id'         => 188,
				'name'       => 'Saint Vincent And The Grenadines',
				'code'       => 'VC',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			188 => array(
				'id'         => 189,
				'name'       => 'Saint-Barthelemy',
				'code'       => 'BL',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			189 => array(
				'id'         => 190,
				'name'       => 'Saint-Martin (French part)',
				'code'       => 'MF',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			190 => array(
				'id'         => 191,
				'name'       => 'Samoa',
				'code'       => 'WS',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			191 => array(
				'id'         => 192,
				'name'       => 'San Marino',
				'code'       => 'SM',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			192 => array(
				'id'         => 193,
				'name'       => 'Sao Tome and Principe',
				'code'       => 'ST',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			193 => array(
				'id'         => 194,
				'name'       => 'Saudi Arabia',
				'code'       => 'SA',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			194 => array(
				'id'         => 195,
				'name'       => 'Senegal',
				'code'       => 'SN',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			195 => array(
				'id'         => 196,
				'name'       => 'Serbia',
				'code'       => 'RS',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			196 => array(
				'id'         => 197,
				'name'       => 'Seychelles',
				'code'       => 'SC',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			197 => array(
				'id'         => 198,
				'name'       => 'Sierra Leone',
				'code'       => 'SL',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			198 => array(
				'id'         => 199,
				'name'       => 'Singapore',
				'code'       => 'SG',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			199 => array(
				'id'         => 200,
				'name'       => 'Slovakia',
				'code'       => 'SK',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			200 => array(
				'id'         => 201,
				'name'       => 'Slovenia',
				'code'       => 'SI',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			201 => array(
				'id'         => 202,
				'name'       => 'Solomon Islands',
				'code'       => 'SB',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			202 => array(
				'id'         => 203,
				'name'       => 'Somalia',
				'code'       => 'SO',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			203 => array(
				'id'         => 204,
				'name'       => 'South Africa',
				'code'       => 'ZA',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			204 => array(
				'id'         => 205,
				'name'       => 'South Georgia',
				'code'       => 'GS',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			205 => array(
				'id'         => 206,
				'name'       => 'South Sudan',
				'code'       => 'SS',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			206 => array(
				'id'         => 207,
				'name'       => 'Spain',
				'code'       => 'ES',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			207 => array(
				'id'         => 208,
				'name'       => 'Sri Lanka',
				'code'       => 'LK',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			208 => array(
				'id'         => 209,
				'name'       => 'Sudan',
				'code'       => 'SD',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			209 => array(
				'id'         => 210,
				'name'       => 'Suriname',
				'code'       => 'SR',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			210 => array(
				'id'         => 211,
				'name'       => 'Svalbard And Jan Mayen Islands',
				'code'       => 'SJ',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			211 => array(
				'id'         => 212,
				'name'       => 'Swaziland',
				'code'       => 'SZ',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			212 => array(
				'id'         => 213,
				'name'       => 'Sweden',
				'code'       => 'SE',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			213 => array(
				'id'         => 214,
				'name'       => 'Switzerland',
				'code'       => 'CH',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			214 => array(
				'id'         => 215,
				'name'       => 'Syria',
				'code'       => 'SY',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			215 => array(
				'id'         => 216,
				'name'       => 'Taiwan',
				'code'       => 'TW',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			216 => array(
				'id'         => 217,
				'name'       => 'Tajikistan',
				'code'       => 'TJ',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			217 => array(
				'id'         => 218,
				'name'       => 'Tanzania',
				'code'       => 'TZ',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			218 => array(
				'id'         => 219,
				'name'       => 'Thailand',
				'code'       => 'TH',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			219 => array(
				'id'         => 220,
				'name'       => 'Togo',
				'code'       => 'TG',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			220 => array(
				'id'         => 221,
				'name'       => 'Tokelau',
				'code'       => 'TK',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			221 => array(
				'id'         => 222,
				'name'       => 'Tonga',
				'code'       => 'TO',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			222 => array(
				'id'         => 223,
				'name'       => 'Trinidad And Tobago',
				'code'       => 'TT',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			223 => array(
				'id'         => 224,
				'name'       => 'Tunisia',
				'code'       => 'TN',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			224 => array(
				'id'         => 225,
				'name'       => 'Turkey',
				'code'       => 'TR',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			225 => array(
				'id'         => 226,
				'name'       => 'Turkmenistan',
				'code'       => 'TM',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			226 => array(
				'id'         => 227,
				'name'       => 'Turks And Caicos Islands',
				'code'       => 'TC',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			227 => array(
				'id'         => 228,
				'name'       => 'Tuvalu',
				'code'       => 'TV',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			228 => array(
				'id'         => 229,
				'name'       => 'Uganda',
				'code'       => 'UG',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			229 => array(
				'id'         => 230,
				'name'       => 'Ukraine',
				'code'       => 'UA',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			230 => array(
				'id'         => 231,
				'name'       => 'United Arab Emirates',
				'code'       => 'AE',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			231 => array(
				'id'         => 232,
				'name'       => 'United Kingdom',
				'code'       => 'GB',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			232 => array(
				'id'         => 233,
				'name'       => 'United States',
				'code'       => 'US',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			233 => array(
				'id'         => 234,
				'name'       => 'United States Minor Outlying Islands',
				'code'       => 'UM',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			234 => array(
				'id'         => 235,
				'name'       => 'Uruguay',
				'code'       => 'UY',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			235 => array(
				'id'         => 236,
				'name'       => 'Uzbekistan',
				'code'       => 'UZ',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			236 => array(
				'id'         => 237,
				'name'       => 'Vanuatu',
				'code'       => 'VU',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			237 => array(
				'id'         => 238,
				'name'       => 'Vatican City State (Holy See)',
				'code'       => 'VA',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			238 => array(
				'id'         => 239,
				'name'       => 'Venezuela',
				'code'       => 'VE',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			239 => array(
				'id'         => 240,
				'name'       => 'Vietnam',
				'code'       => 'VN',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			240 => array(
				'id'         => 241,
				'name'       => 'Virgin Islands (British)',
				'code'       => 'VG',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			241 => array(
				'id'         => 242,
				'name'       => 'Virgin Islands (US)',
				'code'       => 'VI',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			242 => array(
				'id'         => 243,
				'name'       => 'Wallis And Futuna Islands',
				'code'       => 'WF',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			243 => array(
				'id'         => 244,
				'name'       => 'Western Sahara',
				'code'       => 'EH',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			244 => array(
				'id'         => 245,
				'name'       => 'Yemen',
				'code'       => 'YE',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			245 => array(
				'id'         => 246,
				'name'       => 'Zambia',
				'code'       => 'ZM',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			246 => array(
				'id'         => 247,
				'name'       => 'Zimbabwe',
				'code'       => 'ZW',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			247 => array(
				'id'         => 248,
				'name'       => 'Kosovo',
				'code'       => 'XK',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			248 => array(
				'id'         => 249,
				'name'       => 'Curaçao',
				'code'       => 'CW',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			),
			249 => array(
				'id'         => 250,
				'name'       => 'Sint Maarten (Dutch part)',
				'code'       => 'SX',
				'created_at' => '2022-11-08 18:00:00',
				'updated_at' => '2022-11-08 18:00:00'
			)
		));

	}
}
