<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Produit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Statistiques
        $stats = $this->getDashboardStats();
        
        // Données pour le graphique
        $chartData = $this->getChartData(); 
        
        // Dernières commandes
        $commandes = $this->getRecentOrders();

        return view('admin.index', compact('stats', 'commandes', 'chartData'));
    }

    protected function getDashboardStats(): array
    {
        return [
            'totalVentes' => $this->calculateTotalSales(),
            'commandesJour' => Commande::whereDate('created_at', today())->count(),
            'produitsStock' => Produit::where('stock', '<', 5)->count(),
            'clientsActifs' => Commande::select('id_user')->distinct()->count(),
        ];
    }

    protected function calculateTotalSales(): float
    {
        $total = DB::table('detail_commandes')
            ->selectRaw('SUM(CAST(prix_unitaire AS FLOAT) * quantite) as total')
            ->value('total');

        return (float) ($total ?? 0);
    }

    protected function getChartData(): array
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $data = DB::table('commandes')
            ->join('detail_commandes', 'commandes.id', '=', 'detail_commandes.id_commande')
            ->selectRaw("TO_CHAR(commandes.created_at, 'FMDay') as day, SUM(CAST(detail_commandes.prix_unitaire AS FLOAT) * detail_commandes.quantite) as total")
            ->whereBetween('commandes.created_at', [$startOfWeek, $endOfWeek])
            ->groupBy(DB::raw("TO_CHAR(commandes.created_at, 'FMDay')"))
            ->orderByRaw('MIN(commandes.created_at)')
            ->get();

        // PostgreSQL retourne les jours complets (Monday, Tuesday, ...)
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $values = array_fill(0, 7, 0);

        foreach ($data as $dayData) {
            $dayName = ucfirst(strtolower(trim($dayData->day))); // Ex: "monday ", on corrige l'espace
            $dayIndex = array_search($dayName, $daysOfWeek);
            if ($dayIndex !== false) {
                $values[$dayIndex] = (float) $dayData->total;
            }
        }

        return [
            'labels' => $labels,
            'data' => $values
        ];
    }

    protected function getRecentOrders()
    {
        return Commande::with('user')
            ->orderByDesc('created_at')
            ->take(5)
            ->get()
            ->map(function ($commande) {
                return [
                    'id' => $commande->id,
                    'nom' => $commande->user->name ?? 'Client inconnu',
                    'date' => $commande->created_at->format('d/m/Y H:i'),
                    'statut' => $commande->statut
                ];
            });
    }
}
