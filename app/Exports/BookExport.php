<?php

namespace App\Exports;

use App\Models\Book;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
//style
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BookExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function collection(): Collection
    {
        return Book::with('bookCategory')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Alamat Gambar Sampul Buku',
            'Nama Kategori Buku',
            'Judul Buku',
            'Penulis',
            'Penerbit',
            'Tanggal Rilis',
            'Jumlah Hal',
            'Bahasa',
            'Harga'

        ];
    }

    private $no = 0;

    public function map($book): array
    {
        return [
            $this->no++,
            $book->cover,
            $book->bookCategory?->name,
            $book->title,
            $book->writer,
            $book->publisher,
            $book->release_date
                ? \Carbon\Carbon::parse($book->release_date)->translatedFormat('d F Y')
                : '-',
            $book->page_of_book,
            $book->language,
            'Rp ' . number_format($book->price, 0, ',', '.'),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        $totalRows = $this->collection()->count() + 1;

        return [
            // Bold pada Header (Baris 1)
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'D9D9D9'],
                ],
            ],

            // Border pada seluruh rentang sel
            "A1:J{$totalRows}" => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ],
        ];
    }
}