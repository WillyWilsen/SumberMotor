<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Models\Transaction;
// use App\Models\SusbaBank;
// use App\Models\SusbaCountry;
// use App\Models\SusbaIndicator;
// use App\Models\SusbaIndicatorAnswer;
// use App\Models\SusbaPerformanceCategory;
// use App\Models\SusbaRegion;
// use App\Models\SusbaSector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProductDashboard extends Controller
{
    //
    public function index(Request $request)
    {
        // $count_region = SusbaRegion::count();
        // $count_country = SusbaCountry::count();
        // $count_bank = SusbaBank::count();
        // $count_performance_category = SusbaPerformanceCategory::count();
        // // count with non sector
        // $count_sector = SusbaSector::count();
        // $count_indicator_esg = SusbaIndicator::where('id_susba_performance_category', '1')->where('is_header', 0)->count();
        // $count_indicator_sector = SusbaIndicator::where('id_susba_performance_category', '2')->where('is_header', 0)->count();
        // $expected_esg = $count_bank * $count_indicator_esg * 2;
        // $expected_sector = $count_bank * $count_sector * $count_indicator_sector * 2;
        // $expected_answer = $expected_esg + $expected_sector;

        // $count_indicator_answer = SusbaIndicatorAnswer::count();
        $sum_stock = number_format(
            Stock::join('items', 'stocks.item_id', '=', 'items.id')
                ->selectRaw('SUM(stocks.quantity * items.sell_price) as total')
                ->value('total'), 0, '.', ','
        );
        $sum_transaction = number_format(Transaction::sum('total_price'), 0, '.', ',');
        $sum_transaction_today = number_format(Transaction::whereDate('created_at', date('Y-m-d'))->sum('total_price'), 0, '.', ',');

        return view('product.dashboard', compact(
            'sum_stock', 
            'sum_transaction', 
            'sum_transaction_today'
        ));
    }
    // public function DownloadCsvExample()
    // {
    //     // return zip file from storage
    //     return response()->download(storage_path('seed_csv/susba/SUSBA_CSV_EXAMPLE.zip'));
    // }

    // public function ExportAllData(Request $request)
    // {
    //     // export all data using csv exporter, zip in and return it to user
    //     $zip = new \ZipArchive();
    //     $zip_name = "RESPOND_ALL_DATA.zip";
    //     $zip->open($zip_name, \ZipArchive::CREATE);
    //     Excel::store(new \App\Exports\Respond\AssetManagerExport, 'respond_asset_manager.csv');
    //     Excel::store(new \App\Exports\Respond\AumGroupExport, 'respond_aum_group.csv');
    //     Excel::store(new \App\Exports\Respond\CountryExport, 'respond_country.csv');
    //     Excel::store(new \App\Exports\Respond\IndicatorAnswerExport, 'respond_indicator_answer.csv');
    //     Excel::store(new \App\Exports\Respond\PillarExport, 'respond_pillar.csv');
    //     Excel::store(new \App\Exports\Respond\PRIExport, 'respond_pri.csv');
    //     Excel::store(new \App\Exports\Respond\SectionExport, 'respond_section.csv');
    //     Excel::store(new \App\Exports\Respond\SubIndicatorExport, 'respond_sub_indicator.csv');
    //     Excel::store(new \App\Exports\Respond\TCFDExport, 'respond_tcfd.csv');
    //     Excel::store(new \App\Exports\Respond\ThemeExport, 'respond_theme.csv');
    //     Excel::store(new \App\Exports\Respond\TypeExport, 'respond_type.csv');
    //     $zip->addFile(storage_path('app/respond_asset_manager.csv'), 'respond_asset_manager.csv');
    //     $zip->addFile(storage_path('app/respond_aum_group.csv'), 'respond_aum_group.csv');
    //     $zip->addFile(storage_path('app/respond_country.csv'), 'respond_country.csv');
    //     $zip->addFile(storage_path('app/respond_indicator_answer.csv'), 'respond_indicator_answer.csv');
    //     $zip->addFile(storage_path('app/respond_pillar.csv'), 'respond_pillar.csv');
    //     $zip->addFile(storage_path('app/respond_pri.csv'), 'respond_pri.csv');
    //     $zip->addFile(storage_path('app/respond_section.csv'), 'respond_section.csv');
    //     $zip->addFile(storage_path('app/respond_sub_indicator.csv'), 'respond_sub_indicator.csv');
    //     $zip->addFile(storage_path('app/respond_tcfd.csv'), 'respond_tcfd.csv');
    //     $zip->addFile(storage_path('app/respond_theme.csv'), 'respond_theme.csv');
    //     $zip->addFile(storage_path('app/respond_type.csv'), 'respond_type.csv');
    //     $zip->close();
    //     return response()->download($zip_name);
    // }


    // public function DeleteAll()
    // {
    //     // delete all data
    //     SusbaIndicatorAnswer::truncate();
    //     SusbaIndicator::truncate();
    //     SusbaPerformanceCategory::truncate();
    //     SusbaSector::truncate();
    //     SusbaBank::truncate();
    //     SusbaCountry::truncate();
    //     SusbaRegion::truncate();
    //     return response()->json(['message' => 'success']);
    // }
}
