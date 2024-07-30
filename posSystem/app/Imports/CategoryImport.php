<?php
namespace App\Imports;

use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\CategoryModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoryImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            CategoryModel::updateOrCreate(
                [
                    'name' => $row['name'],
                ],
                [
                    'name' => $row['name'],
                    'description' => $row['description'],
                    'thumbnailPath' => "",
                    'statusId' => $row['statusId'],
                    'deleted_at' => null,
                ]
            );
        }
    }
}
