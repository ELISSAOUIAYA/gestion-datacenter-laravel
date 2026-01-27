<?php

namespace App\Http\Controllers;

use App\Models\AccountRequest;
use Illuminate\Http\Request;

class AccountRequestController extends Controller
{
    /**
     * Affiche le formulaire de demande d'ouverture de compte (pour les invités)
     */
    public function create()
    {
        return view('guest.account-request');
    }

    /**
     * Enregistre la demande d'ouverture de compte
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:account_requests',
            'phone' => 'nullable|string|max:20',
            'user_type' => 'required|in:Ingénieur,Enseignant,Doctorant,Autre',
            'motivation' => 'required|string|min:50|max:2000'
        ]);

        AccountRequest::create($validated);

        return redirect()->route('welcome')->with('success', 
            'Demande d\'ouverture de compte envoyée avec succès. Un administrateur examinera votre demande.');
    }

    /**
     * Dashboard admin pour voir les demandes en attente
     */
    public function index()
    {
        $query = AccountRequest::query();

        // Filtrage par recherche
        if (request('search')) {
            $query->where('name', 'LIKE', '%' . request('search') . '%')
                  ->orWhere('email', 'LIKE', '%' . request('search') . '%');
        }

        // Filtrage par statut
        if (request('status')) {
            $query->where('status', request('status'));
        }

        // Filtrage par type d'utilisateur
        if (request('user_type')) {
            $query->where('user_type', request('user_type'));
        }

        $accountRequests = $query->latest()->paginate(15);

        // Statistiques globales
        $pending = AccountRequest::where('status', 'EN ATTENTE')->count();
        $approved = AccountRequest::where('status', 'APPROUVÉE')->count();
        $rejected = AccountRequest::where('status', 'REFUSÉE')->count();

        return view('admin.account-requests.index', compact('accountRequests', 'pending', 'approved', 'rejected'));
    }

    /**
     * Affiche les détails d'une demande
     */
    public function show(AccountRequest $accountRequest)
    {
        return view('admin.account-requests.show', compact('accountRequest'));
    }

    /**
     * Approuve une demande et crée le compte utilisateur
     */
    public function approve(AccountRequest $accountRequest)
    {
        if ($accountRequest->status !== 'EN ATTENTE') {
            return back()->with('error', 'Cette demande a déjà été traitée.');
        }

        // Créer l'utilisateur
        \App\Models\User::create([
            'name' => $accountRequest->name,
            'email' => $accountRequest->email,
            'password' => bcrypt(\Illuminate\Support\Str::random(16)),
            'role_id' => \App\Models\Role::where('name', 'Utilisateur Interne')->first()->id,
        ]);

        // Mettre à jour la demande
        $accountRequest->update(['status' => 'APPROUVÉE']);

        // Optionnel : Envoyer un email à l'utilisateur
        // Mail::send(new AccountApprovedMail($accountRequest));

        return back()->with('success', 'Compte créé et demande approuvée.');
    }

    /**
     * Refuse une demande
     */
    public function reject(Request $request, AccountRequest $accountRequest)
    {
        $validated = $request->validate([
            'admin_comment' => 'required|string|min:10|max:500'
        ]);

        $accountRequest->update([
            'status' => 'REFUSÉE',
            'admin_comment' => $validated['admin_comment']
        ]);

        // Optionnel : Envoyer un email à l'utilisateur avec le motif

        return back()->with('success', 'Demande refusée.');
    }
}
