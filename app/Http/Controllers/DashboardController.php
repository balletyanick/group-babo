<?php 
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use App\Models\Product;
    use App\Models\User;
    use App\Models\Customer;
    use App\Models\Role;
    use App\Models\Contrat;
    use App\Models\Employe;
    use App\Models\Facture;
    use App\Models\Agence;
    use App\Models\ContratsEmployes;
    
    use Illuminate\Support\Facades\Storage;

    class DashboardController extends Controller
    {
        public function index()
        {
            $nbUsers = User::count();
            $nbProduct = Product::count();
            $nbCustomer = Customer::count();
            $nbContrat = Contrat::count();
            $nbEmploye = Employe::count();
            $nbFacture = Facture::count();
            $nbAgence = Agence::count();
            $totalSalaire = ContratsEmployes::sum('salaire');

            //Periode actuelle
            $currentYear = now()->year;
            $currentMonth = now()->month;

            // Déterminer le début et la fin du trimestre actuel
            $startOfQuarter = now()->firstOfQuarter(); // Premier jour du trimestre
            $endOfQuarter = now()->lastOfQuarter();    // Dernier jour du trimestre

            // Définir la période du mois actuel
            $startOfMonth = now()->year($currentYear)->month($currentMonth)->firstOfMonth(); // Premier jour du mois
            $endOfMonth = now()->year($currentYear)->month($currentMonth)->lastOfMonth(); // Dernier jour du mois

            // Ciffre d'affaire annuelle
            $CA_anuelle = \DB::table('products')
            ->join('factures', 'products.id', '=', 'factures.product_id')
            ->whereYear('factures.created_at', $currentYear)
            ->sum('products.amout_global');

            // Ciffre d'affaire trimeste
            $CA_trimeste = \DB::table('products')
            ->join('factures', 'products.id', '=', 'factures.product_id')
            ->whereBetween('factures.created_at', [$startOfQuarter, $endOfQuarter])
            ->sum('products.amout_global');

            // Ciffre d'affaire mensuelle
            $CA_mensuelle = \DB::table('products')
            ->join('factures', 'products.id', '=', 'factures.product_id')
            ->whereBetween('factures.created_at', [$startOfMonth, $endOfMonth])
            ->sum('products.amout_global');



            return view('dashboard.index', compact('nbUsers','nbProduct','nbCustomer',
            'nbContrat','nbEmploye','nbFacture','CA_anuelle','currentYear','nbAgence',
            'CA_mensuelle','CA_trimeste','totalSalaire'));
        }

        public function yop()
        {
            $nbUsers = User::count();
            $nbProduct = Product::count();
            $nbCustomer = Customer::count();
            $nbAgence = Agence::count();

            $nbFacture = Facture::whereHas('agence', function ($query) {
                $query->where('libelle', 'AGENCE YOPOUGON');
            })->count();

            $nbContrat = Contrat::whereHas('agence', function ($query) {
                $query->where('libelle', 'AGENCE YOPOUGON');
            })->count();

            $nbEmploye = Employe::whereHas('agence', function ($query) {
                $query->where('libelle', 'AGENCE YOPOUGON');
            })->count();

            $totalSalaire = ContratsEmployes::sum('salaire');

            $masseSalariale = ContratsEmployes::whereHas('agence', function ($query) {
                $query->where('libelle', 'AGENCE YOPOUGON');
            })->sum('salaire');


          

            //Periode actuelle
            $currentYear = now()->year;
            $currentMonth = now()->month;

            // Déterminer le début et la fin du trimestre actuel
            $startOfQuarter = now()->firstOfQuarter(); // Premier jour du trimestre
            $endOfQuarter = now()->lastOfQuarter();    // Dernier jour du trimestre

            // Définir la période du mois actuel
            $startOfMonth = now()->year($currentYear)->month($currentMonth)->firstOfMonth(); // Premier jour du mois
            $endOfMonth = now()->year($currentYear)->month($currentMonth)->lastOfMonth(); // Dernier jour du mois

            // Ciffre d'affaire annuelle
            $CA_anuelle = \DB::table('products')
            ->join('factures', 'products.id', '=', 'factures.product_id')
            ->whereYear('factures.created_at', $currentYear)
            ->sum('products.amout_global');

            // Ciffre d'affaire trimeste
            $CA_trimeste = \DB::table('products')
            ->join('factures', 'products.id', '=', 'factures.product_id')
            ->whereBetween('factures.created_at', [$startOfQuarter, $endOfQuarter])
            ->sum('products.amout_global');

            // Ciffre d'affaire mensuelle
            $CA_mensuelle = \DB::table('products')
            ->join('factures', 'products.id', '=', 'factures.product_id')
            ->whereBetween('factures.created_at', [$startOfMonth, $endOfMonth])
            ->sum('products.amout_global');

            return view('dashboard.yop', compact('nbUsers','nbProduct','nbCustomer',
            'nbContrat','nbEmploye','nbFacture','CA_anuelle','currentYear','nbAgence',
            'CA_mensuelle','CA_trimeste'));
        }

    }
