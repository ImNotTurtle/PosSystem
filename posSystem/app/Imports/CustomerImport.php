<?php
namespace App\Imports;

use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\CustomerModel;

class CustomerImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            CustomerModel::create([
                'name'  => $row[0],
                'email' => $row[1],
            ]);
        }
    }
}
