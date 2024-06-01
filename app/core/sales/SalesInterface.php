<?php
namespace App\core\sales;

interface SalesInterface {
    public function getAllSales();
    public function storeSalesData(array $data);
    public function getSingleSales($id);
    public function updateSales($data,$id);
    public function deleteSales($id);
    
}