<?php
namespace App\Imports;

use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\CategoryStatusModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoryStatusImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            CategoryStatusModel::create(
                [
                    'name' => $row['name']
                ]
            );
        }
    }
}
