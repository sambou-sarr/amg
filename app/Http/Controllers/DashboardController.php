<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Produit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Statistiques
            $stats = $this->getDashboardStats();
           
            // Données pour le graphique (si nécessaire, vous pouvez décommenter cette ligne une fois le code réécrit)
            $chartData = $this->getChartData(); 
           
            // Dernières commandes
            $commandes = $this->getRecentOrders();
            return view('admin.index', compact('stats', 'commandes','chartData')); // Ajout de 'commandes' dans la vue
        } catch (\Exception $e) {
            Log::error('Dashboard Error: ' . $e->getMessage());
            // Affiche un message d'erreur plus adapté en production
            return redirect()->route('dashboard')->with('error', 'Une erreur est survenue, veuillez réessayer plus tard.');
        }
    }
    
    protected function getDashboardStats(): array
    {
        return [
            'totalVentes' => $this->calculateTotalSales(),
            'commandesJour' => Commande::whereDate('created_at', today())->count(),
            'produitsStock' => Produit::where('stock', '<', 5)->count(),
            'clientsActifs' => Commande::select('id_user')->distinct()->count()
        ];
    }

    protected function calculateTotalSales(): float
    {
        $total = DB::table('detail_commandes')
            ->selectRaw('SUM(prix_unitaire * quantite) as total') // Pas besoin de cast ici
            ->value('total');

        return (float) ($total ?? 0);
    }

    // Si vous avez besoin de récupérer les données pour le graphique, décommentez et modifiez ce code
    
    protected function getChartData(): array
{
    $startOfWeek = Carbon::now()->startOfWeek();
    $endOfWeek = Carbon::now()->endOfWeek();

    // Modification de la requête
    $data = DB::table('commandes')
        ->join('detail_commandes', 'commandes.id', '=', 'detail_commandes.id_commande')
        ->selectRaw('DAYNAME(commandes.created_at) as day, SUM(detail_commandes.prix_unitaire * detail_commandes.quantite) as total')
        ->whereBetween('commandes.created_at', [$startOfWeek, $endOfWeek])
        ->groupBy(DB::raw('DAYNAME(commandes.created_at)'))
        ->orderByRaw('MIN(commandes.created_at)')
        ->get();

    // Initialisation des labels
    $labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    $values = [0, 0, 0, 0, 0, 0, 0];  // Valeurs initialisées à zéro

    // Récupération des valeurs pour chaque jour
    foreach ($data as $dayData) {
        $dayIndex = array_search($dayData->day, ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']);
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
        return Commande::with('user') // Correction ici, on charge la relation 'user', pas 'id_user'
            ->orderByDesc('created_at')
            ->take(5)
            ->get()
            ->map(function ($commande) {
                return [
                    'id' => $commande->id,
                    'nom' => $commande->user->name ?? 'Client inconnu', // On récupère le nom du client via la relation 'user'
                    'date' => $commande->created_at->format('d/m/Y H:i'),
                    'statut' => $commande->statut
                ];
            });
    }
}
