<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Karyawan;
use App\Models\Pelanggan;
use App\Models\Nota;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UtamaController extends Controller
{
    public function tampilKategori()
    {
        $dataKats = Kategori::all();
        return view('daftarKategori', compact('dataKats'));
    }

    public function hitungBarang($kategoriId)
    {
        $count = Barang::where('kategori_id', $kategoriId)->count();
        return response()->json(['count' => $count]);
    }

    public function getKategoriList()
    {
        $kategoris = Kategori::all();
        return response()->json($kategoris);
    }

    public function storeKategori(Request $request)
    {
        $kategori = new Kategori();
        $kategori->nama = $request->nama;
        $kategori->deskripsi = $request->deskripsi;
        $kategori->save();
        
        return response()->json(['success' => true]);
    }

    public function deleteKategori($id)
    {
        Kategori::find($id)->delete();
        return response()->json(['success' => true]);
    }

    public function index()
    {
        // 1. Top 5 barang paling laku
        $topBarangs = DB::table('barang_nota')
            ->join('barangs', 'barang_nota.barang_id', '=', 'barangs.id')
            ->select('barangs.nama', DB::raw('SUM(barang_nota.qty) as total_terjual'))
            ->groupBy('barangs.id', 'barangs.nama')
            ->orderBy('total_terjual', 'desc')
            ->paginate(5, ['*'], 'barang_page');

        // 2. Top 1 kategori paling laku
        $topKategori = DB::table('barang_nota')
            ->join('barangs', 'barang_nota.barang_id', '=', 'barangs.id')
            ->join('kategoris', 'barangs.kategori_id', '=', 'kategoris.id')
            ->select('kategoris.nama', DB::raw('SUM(barang_nota.qty) as total_terjual'))
            ->groupBy('kategoris.id', 'kategoris.nama')
            ->orderBy('total_terjual', 'desc')
            ->first();

        // 3. Top 3 spenders
        $topSpenders = DB::table('notas')
            ->join('pelanggans', 'notas.pelanggan_id', '=', 'pelanggans.id')
            ->join('barang_nota', 'barang_nota.nota_id', '=', 'notas.id')
            ->select('pelanggans.nama', DB::raw('SUM(barang_nota.harga_jual * barang_nota.qty) as total_pembelian'))
            ->groupBy('pelanggans.id', 'pelanggans.nama')
            ->orderBy('total_pembelian', 'desc')
            ->paginate(5, ['*'], 'spender_page');

        // 4. Top buyer (by quantity)
        $topBuyer = DB::table('barang_nota')
            ->join('notas', 'barang_nota.nota_id', '=', 'notas.id')
            ->join('pelanggans', 'notas.pelanggan_id', '=', 'pelanggans.id')
            ->select('pelanggans.nama', DB::raw('SUM(barang_nota.qty) as total_items'))
            ->groupBy('pelanggans.id', 'pelanggans.nama')
            ->orderBy('total_items', 'desc')
            ->first();

        // 5. Pembeli dengan total pembelian di atas rata-rata per bulan
        $aboveAverageBuyers = DB::select("
            WITH monthly_totals AS (
                SELECT n.pelanggan_id,
                       EXTRACT(YEAR_MONTH FROM n.tanggal) as bulan,
                       SUM(bn.harga_jual * bn.qty) as total_pembelian,
                       AVG(SUM(bn.harga_jual * bn.qty)) OVER (PARTITION BY EXTRACT(YEAR_MONTH FROM n.tanggal)) as rata_rata_bulan
                FROM notas n
                JOIN barang_nota bn ON bn.nota_id = n.id
                GROUP BY n.pelanggan_id, EXTRACT(YEAR_MONTH FROM n.tanggal)
            )
            SELECT DISTINCT p.nama
            FROM monthly_totals mt
            JOIN pelanggans p ON mt.pelanggan_id = p.id
            WHERE mt.total_pembelian > mt.rata_rata_bulan
        ");

        // 6. Rata-rata pembelian 3 bulan terakhir
        $averageLastThreeMonths = DB::table('notas')
            ->join('barang_nota', 'barang_nota.nota_id', '=', 'notas.id')
            ->where('tanggal', '>=', Carbon::now()->subMonths(3))
            ->select(DB::raw('DATE_FORMAT(tanggal, "%Y-%m") as bulan'), 
                    DB::raw('AVG(barang_nota.harga_jual * barang_nota.qty) as rata_rata'))
            ->groupBy('bulan')
            ->orderBy('bulan', 'desc')
            ->paginate(5, ['*'], 'month_page');

        // 7. Total pembelian terbesar pelanggan wanita
        $topWomenBuyers = DB::table('notas')
            ->join('pelanggans', 'notas.pelanggan_id', '=', 'pelanggans.id')
            ->join('barang_nota', 'barang_nota.nota_id', '=', 'notas.id')
            ->where('pelanggans.sex', 'wanita')
            ->select('pelanggans.nama', DB::raw('SUM(barang_nota.harga_jual * barang_nota.qty) as total_pembelian'))
            ->groupBy('pelanggans.id', 'pelanggans.nama')
            ->orderBy('total_pembelian', 'desc')
            ->paginate(5, ['*'], 'women_page');

        // 8. Barang dengan rata-rata penjualan terkecil
        $lowestAvgSales = DB::table('barang_nota')
            ->rightJoin('barangs', 'barang_nota.barang_id', '=', 'barangs.id')
            ->select('barangs.nama', DB::raw('COALESCE(AVG(barang_nota.qty), 0) as rata_rata_penjualan'))
            ->groupBy('barangs.id', 'barangs.nama')
            ->orderBy('rata_rata_penjualan', 'asc')
            ->first();

        // 9. Karyawan dengan rata-rata penjualan terbesar per bulan
        $topEmployeesByMonth = DB::select("
            SELECT ms.nama, ms.bulan, ms.rata_rata_penjualan
            FROM (
                SELECT k.nama,
                       DATE_FORMAT(n.tanggal, '%Y-%m') as bulan,
                       AVG(bn.harga_jual * bn.qty) as rata_rata_penjualan
                FROM karyawans k
                JOIN notas n ON k.id = n.karyawan_id
                JOIN barang_nota bn ON bn.nota_id = n.id
                GROUP BY k.id, k.nama, DATE_FORMAT(n.tanggal, '%Y-%m')
            ) ms
            WHERE (
                SELECT COUNT(*)
                FROM (
                    SELECT k2.id,
                           DATE_FORMAT(n2.tanggal, '%Y-%m') as bulan2,
                           AVG(bn2.harga_jual * bn2.qty) as rata2
                    FROM karyawans k2
                    JOIN notas n2 ON k2.id = n2.karyawan_id
                    JOIN barang_nota bn2 ON bn2.nota_id = n2.id
                    GROUP BY k2.id, DATE_FORMAT(n2.tanggal, '%Y-%m')
                ) ms2
                WHERE ms2.bulan2 = ms.bulan
                AND ms2.rata2 > ms.rata_rata_penjualan
            ) = 0
            ORDER BY ms.bulan DESC, ms.rata_rata_penjualan DESC
        ");

        // 10. Karyawan yang berhak bonus tahunan
        $employeeBonuses = DB::select("
            WITH yearly_avg AS (
                SELECT AVG(monthly_sales.total) as avg_total
                FROM (
                    SELECT SUM(bn.harga_jual * bn.qty) as total
                    FROM notas n
                    JOIN barang_nota bn ON bn.nota_id = n.id
                    GROUP BY n.karyawan_id, DATE_FORMAT(n.tanggal, '%Y-%m')
                ) monthly_sales
            ),
            monthly_sales AS (
                SELECT 
                    n.karyawan_id,
                    DATE_FORMAT(n.tanggal, '%Y-%m') as bulan,
                    SUM(bn.harga_jual * bn.qty) as total
                FROM notas n
                JOIN barang_nota bn ON bn.nota_id = n.id
                GROUP BY n.karyawan_id, DATE_FORMAT(n.tanggal, '%Y-%m')
            ),
            employee_stats AS (
                SELECT 
                    karyawan_id,
                    MAX(total) as max_monthly_sales,
                    SUM(CASE WHEN total > (SELECT avg_total FROM yearly_avg) THEN total ELSE 0 END) as above_avg_sales
                FROM monthly_sales
                GROUP BY karyawan_id
            )
            SELECT 
                k.nama,
                COALESCE(es.max_monthly_sales * 0.10, 0) as bonus_bulanan,
                COALESCE(es.above_avg_sales * 0.05, 0) as bonus_kinerja,
                COALESCE(es.max_monthly_sales * 0.10, 0) + COALESCE(es.above_avg_sales * 0.05, 0) as total_bonus
            FROM karyawans k
            LEFT JOIN employee_stats es ON es.karyawan_id = k.id
            ORDER BY total_bonus DESC
        ");

        return view('utama.utama', compact(
            'topBarangs',
            'topKategori',
            'topSpenders',
            'topBuyer',
            'aboveAverageBuyers',
            'averageLastThreeMonths',
            'topWomenBuyers',
            'lowestAvgSales',
            'topEmployeesByMonth',
            'employeeBonuses'
        ));
    }
}
