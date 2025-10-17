<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UsersExport implements FromView, WithStyles, WithEvents, WithTitle, ShouldAutoSize
{
	protected $users;

	public function __construct($users)
	{
		$this->users = $users;
	}

	public function view(): View
	{
		return view('exports.users', [
			'users' => $this->users,
		]);
	}

	/**
	 * @param Worksheet $sheet
	 */
	public function styles(Worksheet $sheet)
	{
		return [
			'1' => [
				'font' => [
					'bold' => true,
					'size' => 11,
				],
			]
		];
	}

	public function title(): string
	{
		return 'Users';
	}

	public function registerEvents(): array
	{
		return [
			AfterSheet::class => function ($event) {
				$event->sheet->setAutoFilter("A1:F1");

				$default_font_style = [
					'font' => [
						'name' => 'arial',
						'size' => 10,
						'bold' => false,
						'color' => ['argb' => '292b2d'],
					],
				];

				$active_sheet = $event->sheet->getDelegate();
				$active_sheet->getParent()->getDefaultStyle()->applyFromArray($default_font_style);
			},
		];
	}
}
